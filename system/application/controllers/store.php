<?php

# Controller: Store

class Store extends Controller {

	function __construct() {
		parent::Controller();
		$cur_user = $this->session->userdata('userloggedin');													
		if($cur_user['level'] == 2)
		{
			redirect(TRADE_SITE);
		}
		$this->load->model('Content_model');
		$this->load->model('Product_model');
		$this->load->model('Category_model');
		$this->load->model('System_model');
		$this->load->model('Cart_model');
		$this->load->model('Customer_model');
		$this->load->model('Order_model');
		$this->load->model('User_model');
		$this->load->model('Subscribe_model');
		$this->load->model('Menu_model');
		$this->load->model('Gallery_model');
		$this->load->model('Position_model');
		$this->load->model('Lightspeed_model');
		$this->load->model('Tiles_model');
        $this->load->model('Landing_page_model');
	}
	
	
	
	function check_session()
	{
		if($this->session->userdata('previous'))
		{
			if(basename($_SERVER['PHP_SELF']) != $this->session->userdata('previous'))
			{
				$this->session->destroy();
			}
		}
	}

	
	function _index() {
		$this->check_session();
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		
		$data['promotions'] = $this->System_model->get_active_home_promotions();
		$data['stories'] = $this->System_model->get_active_home_stories();
		$data['features1'] = $this->Product_model->get_features1();
		$data['features2'] = $this->Product_model->get_features2();
		$data['features3'] = $this->Product_model->get_features3();
		$cc = 1;
		$first6 = array();
		$second6 = array();
		$prod12 = $this->Product_model->random12();
		//echo "<pre>".print_r($prod12,true)."</pre>";
		foreach($prod12 as $item)
		{
			if($cc<=6)
			{
				$first6[$cc-1] = $item['id'];
			}
			else
			{
				$second6[$cc-7] = $item['id'];
			}
			$cc++;
		}
		$data['first6'] = $this->Product_model->get_features1();
		$data['second6'] = $this->Product_model->get_features2();
		//echo "<pre>".print_r($first6,true)."</pre>";
		//exit;
		$hm=$this->Menu_model->get_setting_active();
		$data['homepage']=$hm;
		$this->load->view('common/header',$data);
		
		if($hm['id']==1){
			$data['banners'] = $this->Content_model->get_active_banners_temp_site(1,'Retail');
			
			$this->load->view('template1',$data);
		}
		else
		if($hm['id']==2){
			$data['banners'] = $this->Content_model->get_active_banners_temp_site(2,'Retail');
			$data['banners2'] = $this->Content_model->get_active_banners_temp_site(1,'Retail');
			$this->load->view('template2',$data);
		}
		else
		if($hm['id']==3){
			$data['banners2'] = $this->Content_model->get_active_banners_temp_site(1,'Retail');
			$data['banners'] = $this->Content_model->get_active_banners_temp_site(2,'Retail');
			$this->load->view('template3',$data);
		}
		
		
		$this->load->view('common/footer');
	}
	
	# Header - Logout
	function logout() {
		$this->session->destroy();
		redirect('store');
	}
	
	# Header Currency 
	function change_currency($cur = '')
	{
		if($cur != '')
		{
			$curr = $this->System_model->get_currency();
			$val = $curr[$cur];
			
			//$cur = $this->session->userdata('cur_name');
			if($cur == 'aud')
			{
				$sign = '<span style="font-size:12px">AU</span> $';
			}
			if($cur == 'usa')
			{
				$sign = '<span style="font-size:12px">US</span> $';
			}
			if($cur == 'eur')
			{
				$sign = '<span style="font-size:12px">€UR</span>';
			}
			if($cur == 'gbp')
			{
				$sign = '<span style="font-size:12px">GB£</span>';
			}
			if($cur == 'jpy')
			{
				$sign = '<span style="font-size:12px">JP¥</span>';
			}
			
			$this->session->set_userdata('cur_sign', $sign);
			$this->session->set_userdata('cur_val', $val);
			
			echo $sign;
		}
	}
	
	function update_currency()
	{
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=USD');
		$response = json_decode($response);
		$data['usa'] = round($response->rate,2);
		
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=EUR');
		$response = json_decode($response);
		$data['eur'] = round($response->rate,2);
		
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=GBP');
		$response = json_decode($response);
		$data['gbp'] = round($response->rate,2);
		
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=JPY');
		$response = json_decode($response);
		$data['jpy'] = round($response->rate,2);
		
		$this->System_model->update_currency($data);
	}
	
	
	# Sign In / Register /  Facebook Log In
	
	function forgot() {
		
		if(isset($_POST['username'])) 
		{
			$customer = $this->Customer_model->recognize($_POST['username']);
			$user = $this->User_model->recognize($_POST['username']);
			if ($customer || $user) 
			{				
				$this->send_password($customer);
				echo 1;
			}
			else 
			{
				echo 2;
			}
		}


	}
	
	function send_password($customer) {
		# Generate new random password
		$this->load->helper('string');
		$password = random_string('alnum', 8);
		$user = $this->User_model->customer($customer['id']);
		$message = sprintf("

<p>Dear %s %s</p>

<p>As requested your password has been reset. Your username and new password is noted below:</p>

<p>Username/Email: %s<br/>
Password: %s</p>
<p>
Please proceed to the website link below to commence shopping.<br/>
%s</p>


		",$customer['firstname'],$customer['lastname'],$user['username'],$password,base_url());
		
		//load email content
		//$data['content'] = $message;
		//$message = $this->load->view('email_template',$data, TRUE);
		
		$this->User_model->update($user['id'],array('password' => md5($password)));
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);	
		$this->email->from(NO_REPLY_EMAIL);
		$this->email->to($customer['email']);
		
		$this->email->subject('Your new password @  '.COMPANY_NAME);
		$this->email->message($message);
		$this->email->send();
		//return $password;
	}
	
	function register()
	{
		if(isset($_POST['sub_email']))
		{
			//echo $_POST['sub_email']; 
			$data['sub_email'] = $_POST['sub_email']; 
		}
		else
		{
			$data['sub_email'] = '';
		}
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['states'] = $this->System_model->get_states();
		
		$this->load->view('common/header',$data);
		$this->load->view('store/register');
		$this->load->view('common/footer');
	}
	
	function signin()
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$this->load->view('common/header',$data);
		$this->load->view('store/signin');
		$this->load->view('common/footer');
	}
	
	function signout()
	{
		$this->session->destroy();
		redirect(base_url());
	}
	
	function trade_register()
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['states'] = $this->System_model->get_states();
		
		$this->load->view('common/header',$data);
		$this->load->view('store/trade_register');
		$this->load->view('common/footer');
	}
	
	function trade($status="") {
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = 'AU$';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		$data['countries'] = $this->System_model->get_countries();
		$data['states'] = $this->System_model->get_states();
		$data['page_title'] = "Trade Customer";
		$this->load->view('common/header',$data);
		//$this->load->view('common/leftbar');
		if($status == "sent")
		{
			$this->load->view('store/tradesent');
		}
		else
		{
		$user = $this->session->userdata('userloggedin');
			if ($user['level'] == 4) {
				redirect('store/checkout');
			}
			$this->load->view('store/trade');
		}
		$this->load->view('common/footer');
	}
	function validatetrade() {		
		if (!isset($_POST['username']) || !isset($_POST['password'])) { echo 2; }
		$data = array(
			    'username' => $this->input->post('username',true), 
				'password' => $this->input->post('password',true)
				);
		
		$user = $this->User_model->validate($data);
		if ($user) 
		{
		  $this->session->set_userdata('previous',basename($_SERVER['PHP_SELF'])); 
		  $this->session->set_userdata('userloggedin',$user);
		  
		  
		  $session_id = $this->session->userdata('session_id');
		  $sql = "select * from carts where session_id = '$session_id'";
		  $nlist = $this->Cart_model->dosql($sql);
		  $nl = count($nlist);
		  
		  $new_items = $this->Cart_model->all($session_id);
		  //echo "<pre>".print_r($new_items,true)."</pre>";
		  $c_id = $user['customer_id'];
		  if(count($new_items) > 0)
		  {
			  foreach($new_items as $ni)
			  {
			  	$p_id = $ni['product_id'];
			  	$sql = "select * from carts where customer_id = '$c_id' and product_id = $p_id and session_id not in (select session_id from orders where status = 'successful')";
				
				//echo $sql;
				//exit;
				
				$list = $this->Cart_model->dosql($sql);
				//echo $list['id'];
				//echo "<pre>".print_r($list,true)."</pre>";
				//exit;
				if(count($list)>0)
				{
					//echo "<pre>".print_r($list,true)."</pre>";
					//$this->Cart_model->delete($list[0]['id']);
					foreach($list as $l)
					{
						$this->Cart_model->delete($l['id']);
					}
				}
				
				// if(count($list) > 0)
				// {
					// $this->Cart_model->delete($ni['id']);
				// }
			  }
		  }
		  
		  $data = array();
		  $data['customer_id'] = $user['customer_id'];
		  
		  $this->Cart_model->update_by_session_id($session_id,$data);
		  
		  $cust_id = $user['customer_id'];
		  
		  $sql = "select * from carts where customer_id='$cust_id' and session_id != '$session_id' and session_id not in (select session_id from orders where status = 'successful')";
		  
		  $list = $this->Cart_model->dosql($sql);
		  $cl = count($list);
		  foreach($list as $ls)
		  {
		  	$newdata2 = array();
		  	$newdata2['session_id'] = $session_id;
		  	$this->Cart_model->update($ls['id'],$newdata2);
		  }
		  
		  $sql = "select * from carts where session_id = '$session_id'";
		  $list = $this->Cart_model->dosql($sql);
		  foreach($list as $ls)
		  {
		  	$pid = $ls['product_id'];
			$prod = $this->Product_model->identify($pid);
			$nprice = $ls['price'];
			if($user['level'] == 1)
			{
				//retail
				if($prod['sale_price'] < $prod['price'])
				{
					$nprice = $prod['sale_price'];
				}
				else 
				{
					$nprice = $prod['price'];
				}
			}
			if($user['level'] == 2)
			{
				//trade
				if($prod['sale_price_trade'] < $prod['price_trade'])
				{
					$nprice = $prod['sale_price_trade'];
				}
				else 
				{
					$nprice = $prod['price_trade'];
				}
			}
			$newdata2 = array();
			$newdata2['price'] = $nprice;
			$this->Cart_model->update($ls['id'],$newdata2);
		  }
		  
		  if($_POST['wlist'] == 1)
		  {
		  	  echo 4;
		  }
		  else
		  {
		  	  if($nl>0)
			  {
			  	// check out
			  	echo 1;
			  }
			  else
			  {
			  	// my account
			  	if($cl>0)
				{
			  		echo 3;
				}
				else
				{
					echo 4;
				}
			  }		
		  }
		    
		  
		}
		else 
		{ 
		  
		  echo 2;
		}	
		 
	}
	
	
	function validate() {		
		if (!isset($_POST['username']) || !isset($_POST['password'])) { echo 2; }
		$data = array(
			    'username' => $this->input->post('username',true), 
				'password' => $this->input->post('password',true)
				);
		
		$user = $this->User_model->validate($data);
		if ($user) 
		{
		  $this->session->set_userdata('previous',basename($_SERVER['PHP_SELF'])); 
		  $this->session->set_userdata('userloggedin',$user);
		  
		  
		  $session_id = $this->session->userdata('session_id');
		  $sql = "select * from carts where session_id = '$session_id'";
		  $nlist = $this->Cart_model->dosql($sql);
		  $nl = count($nlist);
		  
		  $new_items = $this->Cart_model->all($session_id);
		  //echo "<pre>".print_r($new_items,true)."</pre>";
		  $c_id = $user['customer_id'];
		  if(count($new_items) > 0)
		  {
			  foreach($new_items as $ni)
			  {
			  	$p_id = $ni['product_id'];
			  	$sql = "select * from carts where customer_id = '$c_id' and product_id = $p_id and session_id not in (select session_id from orders where status = 'successful')";
				
				//echo $sql;
				//exit;
				
				$list = $this->Cart_model->dosql($sql);
				//echo $list['id'];
				//echo "<pre>".print_r($list,true)."</pre>";
				//exit;
				if(count($list)>0)
				{
					//echo "<pre>".print_r($list,true)."</pre>";
					//$this->Cart_model->delete($list[0]['id']);
					foreach($list as $l)
					{
						$this->Cart_model->delete($l['id']);
					}
				}
				
				// if(count($list) > 0)
				// {
					// $this->Cart_model->delete($ni['id']);
				// }
			  }
		  }
		  
		  $data = array();
		  $data['customer_id'] = $user['customer_id'];
		  
		  $this->Cart_model->update_by_session_id($session_id,$data);
		  
		  $cust_id = $user['customer_id'];
		  
		  $sql = "select * from carts where customer_id='$cust_id' and session_id != '$session_id' and session_id not in (select session_id from orders where status = 'successful')";
		  
		  $list = $this->Cart_model->dosql($sql);
		  $cl = count($list);
		  foreach($list as $ls)
		  {
		  	$newdata2 = array();
		  	$newdata2['session_id'] = $session_id;
		  	$this->Cart_model->update($ls['id'],$newdata2);
		  }
		  
		  $sql = "select * from carts where session_id = '$session_id'";
		  $list = $this->Cart_model->dosql($sql);
		  foreach($list as $ls)
		  {
		  	$pid = $ls['product_id'];
			$prod = $this->Product_model->identify($pid);
			$nprice = $ls['price'];
			if($user['level'] == 1)
			{
				//retail
				if($prod['sale_price'] < $prod['price'])
				{
					$nprice = $prod['sale_price'];
				}
				else 
				{
					$nprice = $prod['price'];
				}
			}
			if($user['level'] == 2)
			{
				//trade
				if($prod['sale_price_trade'] < $prod['price_trade'])
				{
					$nprice = $prod['sale_price_trade'];
				}
				else 
				{
					$nprice = $prod['price_trade'];
				}
			}
			$newdata2 = array();
			$newdata2['price'] = $nprice;
			$this->Cart_model->update($ls['id'],$newdata2);
		  }
		  
		  if($_POST['wlist'] == 1)
		  {
		  	  echo 4;
		  }
		  else
		  {
		  	  if($nl>0)
			  {
			  	// check out
			  	echo 1;
			  }
			  else
			  {
			  	// my account
			  	if($cl>0)
				{
			  		echo 3;
				}
				else
				{
					echo 4;
				}
			  }		
		  }
		    
		  
		}
		else 
		{ 
		  
		  echo 2;
		}	
		 
	}
	
	function trade_register_new()
	{
		$email = $this->input->post('email',true);
		$username = $email;
		$password = $this->input->post('password',true);		
				
		$data2 = array(
			    'username' => $this->input->post('email',true), 
				'password' => $this->input->post('password',true)
				);
		
		$user = $this->User_model->recognize($username);
		
		if(count($user)>1) 
		{ 
		  $this->session->set_flashdata('error_trade_reg', 'Your email has already exist in our database');
		  
		  redirect('store/trade_register');
		}
		else
		{
			$title = $this->input->post('title',true);
			$firstname = $this->input->post('first_name',true);
			$lastname = $this->input->post('last_name',true);
			$website = $this->input->post('website',true);
			$bussiness_name = $this->input->post('bussiness_name',true);
			$trading = $this->input->post('trading',true);
			$abn = $this->input->post('abn',true);
			$telephone = $this->input->post('telephone',true);
			$fax = $this->input->post('fax',true);
			$mobile = $this->input->post('mobile',true);
			$address1 = $this->input->post('address',true);
			$address2 = $this->input->post('address2',true);
			$suburb = $this->input->post('suburb',true);
			$state = $this->input->post('province',true);
			$country = $this->input->post('country',true);
			$postcode = $this->input->post('postcode',true);
			$btype = $this->input->post('btype',true);
			$btype = json_encode($btype);
			$interested = $this->input->post('interested',true);
			$interested = json_encode($interested);
			
			$data = array(
				'title' => $title,
				'firstname' => $firstname,
				'lastname' => $lastname,	
				'email' => $email,								
				'website' => $website,	
				'tradename' => $bussiness_name,		
				'trading' => $trading,	
				'abn' => $abn,	
				'phone' => $telephone,	
				'fax' => $fax,	
				'mobile' => $mobile,	
				'address' => $address1,	
				'address2' => $address2,	
				'suburb' => $suburb,
				'state' => $state,
				'country' => $country,
				'postcode' => $postcode,
				'btype' => $btype,
				'interested' => $interested,
				'dealer' => 1,
				'joined' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			$customer_id = $this->Customer_model->add($data);
			
			$updata = array();
			$updata['webid'] = 'w'.$customer_id;
			$this->Customer_model->update($customer_id,$updata);
			
			$data['type']='trader';
			$this->add_contactlist($data);
			
			if ($customer_id) {
				$user = array(
					'customer_id' => $customer_id,
					'username' => $username,
					'password' => md5($password),
					'level' => 2,
					'activated' => 0
				);
				$user_id = $this->User_model->add($user);
				$user['id'] = $user_id;
				
				
				$user = $this->User_model->recognize($email);
				
				$this->session->set_userdata('previous',basename($_SERVER['PHP_SELF'])); 
			  	$this->session->set_userdata('userloggedin',$user);
				
				
				$session_id = $this->session->userdata('session_id');
				
				$data = array();
		  
			  	$data['customer_id'] = $customer_id;
			  
			  	$this->Cart_model->update_by_session_id($session_id,$data);
			  
				$cust_id = $customer_id;
				  
				$sql = "select * from carts where customer_id='$cust_id' and session_id != '$session_id' and session_id not in (select session_id from orders where status = 'successful')";
				
				//echo $sql;
				//exit;
				
				$list = $this->Cart_model->dosql($sql);
				  
				foreach($list as $ls)
				{
					$ndata = Array();
					$ndata['session_id'] = $session_id;
				  	$this->Cart_model->update($ls['id'],$ndata);
				}
				$this->send_confirmation_dealer($user);
				
				redirect('store/cart');
			}
		}
	}
	function fb()
	{
		 require_once("fb/facebook.php");

		  $config = array();
		  
		  // $config['appId'] = appId;
		  // $config['secret'] = secret;
		  $config['appId'] = '602736106428564';
		  $config['secret'] = '30eed75017e208447700279172c796b1';
		  $config['fileUpload'] = false; // optional
		
		  $facebook = new Facebook($config);
		  $user = $facebook->getUser();
		  $json = $facebook->api('/me');
		  //echo "<pre>".print_r($json,true)."</pre>";
		  
		  //$fb_data=json_encode($json);
		  //echo "<pre>".print_r($fb_data,true)."</pre>";
		  
		  $user = $this->User_model->recognize($json['email']);
		  
		  if(count($user) > 0)
		  {
		  	$this->session->set_userdata('previous',basename($_SERVER['PHP_SELF'])); 
		  	$this->session->set_userdata('userloggedin',$user);
			
			
			$session_id = $this->session->userdata('session_id');
			
			$sql = "select * from carts where session_id = '$session_id'";
			$nlist = $this->Cart_model->dosql($sql);
			$nl = count($nlist);
		  
		  	$data['customer_id'] = $user['customer_id'];
		  
		  	$this->Cart_model->update_by_session_id($session_id,$data);
		  
			$cust_id = $user['customer_id'];
			  
			$sql = "select * from carts where customer_id='$cust_id' and session_id != '$session_id' and session_id not in (select session_id from orders where status = 'successful')";
			
			//echo $sql;
			//exit;
			
			$list = $this->Cart_model->dosql($sql);
			$cl = count($list);
			foreach($list as $ls)
			{
				$ndata=Array();
				$ndata['session_id'] = $session_id;
			  	$this->Cart_model->update($ls['id'],$ndata);
			}
			
			if($nl>0)
			{
				redirect(base_url().'cart/account_page');
			}
			else 
			{
				redirect(base_url().'store/edit_detail_retail/'.$cust_id);
			}
			
			//redirect(base_url().'store/edit_detail_retail/'.$cust_id);
		  }
		  else
		  {
		  	//new user
		  	$bdate = date('Y/m/d',strtotime($json['birthday']));
			//if($json['middle_name'])
			//{
				//$fn = $json['first_name'].' '.$json['middle_name'];
			//}
			//else 
			//{
				$fn = $json['first_name'];
			//}
			$data = array();
		  	$data = array(
				'email' => $json['email'],
				'firstname' => $fn,
				'lastname' => $json['last_name'],									
				'birthday' => $bdate,	
				'state' => 1,
				'joined' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			$customer_id = $this->Customer_model->add($data);
			if ($customer_id) {
				$user = array();
				$user = array(
					'customer_id' => $customer_id,
					'username' => $json['email'],
					'password' => md5('changeme123'),
					'level' => 1,
					'activated' => 1
				);
				$user_id = $this->User_model->add($user);
				$user['id'] = $user_id;
				
				$user = $this->User_model->recognize($json['email']);
				
				$this->session->set_userdata('previous',basename($_SERVER['PHP_SELF'])); 
			  	$this->session->set_userdata('userloggedin',$user);
				
				
				$session_id = $this->session->userdata('session_id');
				
				$sql = "select * from carts where session_id = '$session_id'";
				$nlist = $this->Cart_model->dosql($sql);
				$nl = count($nlist);
				
		  		$data = array();
			  	$data['customer_id'] = $customer_id;
			  
			  	$nl = $this->Cart_model->update_by_session_id($session_id,$data);
			  
				$cust_id = $customer_id;
				  
				$sql = "select * from carts where customer_id='$cust_id' and session_id != '$session_id' and session_id not in (select session_id from orders where status = 'successful')";
				
				//echo $sql;
				//exit;
				
				$list = $this->Cart_model->dosql($sql);
				$cl = count($list);
				foreach($list as $ls)
				{
					$ndata=Array();
					$ndata['session_id'] = $session_id;
				  	$this->Cart_model->update($ls['id'],$ndata);
				}
				
				if($nl>0)
				{
					redirect(base_url().'cart/account_page');
				}
				else 
				{
					redirect(base_url().'store/edit_detail_retail/'.$cust_id);
				}
				
				
				
				//$this->send_confirmation_dealer($user);		
			}
		  	
		  }
	}

	function forgot_pass()
	{
		$email = $_POST['email'];
		
		$user = $this->User_model->recognize($email);
		if($user)
		{
			$new_pass = 'changeme'.$user['id'].date('Y-m-d H:i:s');
			
			$data = array();
			$show_pass = md5($new_pass);
			$data['password'] = md5($show_pass);
			
			$this->User_model->update($user['id'],$data);
			
			$cust = $this->Customer_model->identify($user['customer_id']);
			
			$msg = FONT_EMAIL.'
					<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; font-family:open sans;">
						<tr>
							<td>
								Dear '.$cust['firstname'].' '.$cust['lastname'].',<br/>
								<br/>
								This is your new password : <span style="font-weight:700">'.$show_pass.'</span>
								
							</td>
						</tr>
					</table>';
			
			
					
			$msg .= '<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; margin-bottom: 30px">
						<tr>
							<td style="text-align: center">
								<br/>
								'.COMPANY_WEBSITE.'
							</td>
						</tr>
					</table>';
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);		
			$this->email->from(NO_REPLY_EMAIL);
	        
			$this->email->to($email);
			$this->email->bcc(EMAIL_BCC);
			
			$this->email->subject('Forgot Password @'. COMPANY_NAME);
			$this->email->message($msg);
			$this->email->send();
			
			echo 1;
		}
		else 
		{
			echo 0;
		}
	}
	
	
	function send_confirmation_dealer($user)
    {
       	$customer = $this->Customer_model->identify($user['customer_id']); 
       	$message = sprintf(TRADE_CONFIRMATION_EMAIL_CONTENT,$customer['firstname']);                        
        $this->load->library('email');
        $config['mailtype'] = 'html';    
        $this->email->initialize($config);
        $this->email->from(NO_REPLY_EMAIL,COMPANY_NAME);
        $this->email->to($customer['email']);
        $this->email->subject('Account Confirmation @ '.COMPANY_NAME);
        $this->email->message($message);
        $this->email->send();
    }

	function send_confirmation_retailer($user)
    {
       	$customer = $this->Customer_model->identify($user['customer_id']); 
       	$message = sprintf(RETAIL_CONFIRMATION_EMAIL_CONTENT,$customer['firstname']);                        
        $this->load->library('email');
        $config['mailtype'] = 'html';    
        $this->email->initialize($config);
        $this->email->from(NO_REPLY_EMAIL,COMPANY_NAME);
        $this->email->to($customer['email']);
        $this->email->subject('Account Confirmation @ '.COMPANY_NAME);
        $this->email->message($message);
        $this->email->send();
    }
	
	
	function traderegister() 
	{
		$email = $this->input->post('email',true);
		$username = $email;
		$password = $this->input->post('password',true);		
				
		$data2 = array(
			    'username' => $this->input->post('email',true), 
				'password' => $this->input->post('password',true)
				);
		
		$user = $this->User_model->recognize($username);
		
		
		if(count($user)>1) 
		{ 
		  
		
		  echo 2;		  
		  
		}
		else 
		{ 		  		  					
			$firstname = $this->input->post('firstname',true);
			$lastname = $this->input->post('lastname',true);

			
			$mobile = $_POST['mobile'];
			$address = $_POST['address'];
			$suburb = $_POST['suburb'];
			$state = $_POST['state'];
			$postcode = $_POST['postcode'];				
			 
			$data = array(
				'email' => $email,
				'firstname' => $firstname,
				'lastname' => $lastname,									
				'address' => $address,			
				'suburb' => $suburb,
				'state' => $state,
				'postcode' => $postcode,
				'phone' => $mobile,
				'mobile' => $mobile,
				'joined' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			$customer_id = $this->Customer_model->add($data);
			
			$updata = array();
			$updata['webid'] = 'w'.$customer_id;
			$this->Customer_model->update($customer_id,$updata);
			
			if ($customer_id) {
				$user = array(
					'customer_id' => $customer_id,
					'username' => $username,
					'password' => md5($password),
					'level' => 1
				);
				$user_id = $this->User_model->add($user);
				$user['id'] = $user_id;
				
				
				$this->send_confirmation_dealer($user);		
			}
			echo 1;
		
		}
	  
	}

	function traderegister2() 
	{
		$email = $this->input->post('email',true);
		$username = $email;
		$password = $this->input->post('password',true);		
				
		$data2 = array(
			    'username' => $this->input->post('email',true), 
				'password' => $this->input->post('password',true)
				);
		
		$user = $this->User_model->recognize($username);
		
		
		if(count($user)>1) 
		{ 
		  
		
		  echo 2;
		  
		}
		else 
		{ 		  		  					
			//error_reporting(E_ALL);
			$light_id =0;
			$lights = $this->Lightspeed_model->get_customer_lightspeed($email);
			if(count($lights)>0){$light_id = $lights['lightspeed_id'];}
			
			$firstname = $this->input->post('firstname',true);
			$lastname = $this->input->post('lastname',true);
			
			
			$title = $this->input->post('title');
			$mobile = $_POST['mobile'];
			$phone = $_POST['phone'];
			$month_dob = $_POST['month_dob'];
			$date_dob = $_POST['date_dob'];
			$address1 = $_POST['address1'];
			$address2 = $_POST['address2'];
			$country = $_POST['country'];
			$suburb = $_POST['suburb'];
			$state = $_POST['state'];
			$postcode = $_POST['postcode'];
			$heardus = $_POST['heardus'];
			$personal_referral = $_POST['personal_referral'];
			//$dob = $_POST['dob'];
			
			//echo date('Y-m-d',strtotime($dob));
			
			//exit;
			 
			$data = array(
				'lightspeed_id' => $light_id,
				'email' => $email,
				'phone' => $phone,
				'mobile' => $mobile,
				'title' => $title,
				'firstname' => $firstname,
				'lastname' => $lastname,		
				//'birthday' => date('Y-m-d',strtotime($dob)),	
				'month_dob' => $month_dob,	
				'date_dob' => $date_dob,									
				'address' => $address1,	
				'address2' => $address2,	
				'country' => $country,		
				'suburb' => $suburb,
				'state' => $state,
				'postcode' => $postcode,
				'heard_us' => $heardus,
				'personal_referral' => $personal_referral,
				'joined' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			$customer_id = $this->Customer_model->add($data);
			
			$updata = array();
			$updata['webid'] = 'w'.$customer_id;
			$this->Customer_model->update($customer_id,$updata);
			
			$data['type']='retailer';
			//$this->add_contactlist($data);
			
			if ($customer_id) {
				$user = array(
					'customer_id' => $customer_id,
					'username' => $username,
					'password' => md5($password),
					'level' => 1,
					'activated' => 1
				);
				$user_id = $this->User_model->add($user);
				$user['id'] = $user_id;
				
				
				$user = $this->User_model->recognize($email);
				
				$this->session->set_userdata('previous',basename($_SERVER['PHP_SELF'])); 
			  	$this->session->set_userdata('userloggedin',$user);
				
				
				$session_id = $this->session->userdata('session_id');
				
				$data = array();
		  
			  	$data['customer_id'] = $customer_id;
			  
			  	$this->Cart_model->update_by_session_id($session_id,$data);
			  
				$cust_id = $customer_id;
				  
				$sql = "select * from carts where customer_id='$cust_id' and session_id != '$session_id' and session_id not in (select session_id from orders where status = 'successful')";
				
				//echo $sql;
				//exit;
				
				$list = $this->Cart_model->dosql($sql);
				  
				foreach($list as $ls)
				{
					$ndata = Array();
					$ndata['session_id'] = $session_id;
				  	$this->Cart_model->update($ls['id'],$ndata);
				}
				//$this->send_confirmation_dealer($user);		
			}
			$this->send_confirmation_retailer2($user);
			echo 1;
		
		}
	  
	}
	
	function send_confirmation_retailer2($user)
	{
		
		$customer = $this->Customer_model->identify($user['customer_id']); 
		
		$message = "Hi ".$customer['firstname']." ".$customer['lastname'].",<br/><br/>
Thanks for signing up with ".COMPANY_NAME.".<br/>
If you would like to proceed into the products area to order something, click <a href='".base_url()."'>here</a>, or we look forward to the next time you visit us!<br/><br/>
Warm Regards,<br/>
".COMPANY_NAME."";
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from(NO_REPLY_EMAIL,COMPANY_NAME);
		$this->email->to($customer['email']);
		$this->email->bcc(EMAIL_BCC);
		$this->email->subject('Sign Up Confirmation @ '.COMPANY_NAME);
		$this->email->message($message);
		$this->email->send();
	}
	
	#Footer - Subscribe 
	function store_subscribe()
	{
		$email = $this->input->post('email');
		if($this->Subscribe_model->exist($email))
		{
			echo -1;
		}
		else
		{
			$data['email'] = $email;
			
			echo $this->Subscribe_model->add($data);
			
			$data['firstname'] = '-';
			$data['lastname'] = '-';
			$data['phone'] = '-';
			$data['country'] = '-';
			$data['state'] = '-';
			$data['type']='subscriber';
			$this->add_contactlist($data);
		}
		
	}
	#Home Promotions
	
	function promotion_product_new($cat,$id,$sort='id',$limit =12,$row=0)
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = 'AU$';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['promotion'] = $this->System_model->get_promotions_id($id);
		if($cat!='single'){$data['story'] = $this->System_model->get_story_id(5);}
		if($cat=='archive'){$data['story'] = $this->System_model->get_story_id(5);}
		//$data['products'] = $this->Product_model->get_product_story($cat,$id);
		
		
		//$cat = $this->Category_model->identify2($cat_name);
		$scat_name='';
		if($scat_name != 'all')
		{
			/*$scat = $this->Category_model->identify2($scat_name);
			$data['scate'] = $scat['title'];
			$scat_id = $scat['id'];
			
			$this->session->set_userdata('save_sub',$scat['title']);
			$this->session->set_userdata('save_sub_link',$scat_name);*/
		}
		else
		{
			$scat_id = 'all';
		}
		
		
		if($this->session->userdata('by'))
		{
			$by = $this->session->userdata('by');
		}
		else 
		{
			$by = '';
		}
		
		if($this->session->flashdata('look_by'))
		{
			$look_by = $this->session->flashdata('look_by');
		}
		else 
		{
			$look_by = '';
		}
		
		if($this->session->flashdata('text_keyword'))
		{
			$text = $this->session->flashdata('text_keyword');
		}
		else 
		{
			$text = '';
		}
		$cat_name='';
		$scat_name='';
		$data['cat_name'] = $cat_name;
		$data['scat_name'] = $scat_name;
		$data['look_by'] = $look_by;
		$data['text_key'] = $text;
		
		$all_products = $this->Product_model->get_product_promotion($cat,$id,$sort,0,0);
		//$this->Product_model->get_new_product_list_all($cat['id'],$scat_id,$text,$by,$look_by);
		$data['products'] =  $this->Product_model->get_product_promotion($cat,$id,$sort,$row,$limit);
		//$this->Product_model->get_new_product_list($cat['id'],$scat_id,$text,$by,$look_by,$row,$limit);	
		
		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."store/promotion_product_new/".$cat."/".$id."/".$limit."/";
		
		$config['total_rows'] = count($all_products);
		$config['per_page'] = $limit;
		$config['num_links'] = 3;
		$config['uri_segment'] = 6;
		//$config['cur_tag_open'] = '&nbsp;<span class="active">';
		//$config['cur_tag_close'] = '</span>';
		$config['tag_open'] = '<li>';
		$config['tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul>PG ';
		$config['full_tag_close'] = '&nbsp;&nbsp;</ul>';
			
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$row = 0;
		$data['total_row']=count($all_products);
		
							
		$this->load->view('common/header',$data);
		$this->load->view('store/promotion_product',$data);
		$this->load->view('common/footer');
	}

	function promotion($id)
	{
		$this->check_session();
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['id_active']=$id;
		$data['promotions'] = $this->System_model->get_active_promotions();
		
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/promotion',$data);
		$this->load->view('common/footer');
	}
	function promotion_new($id,$slide=-1)
	{
		$this->check_session();
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$cat=0;
		//$data['id_active']=$id;
		//$data['promotions'] = $this->System_model->get_active_promotions();
		$data['index']=0;
		$data['id_active']=$id;
		$data['stories'] = $this->Menu_model->get_active_stories();
		
		//$data['pages_story'] = $this->System_model->get_storypage($id);
		$data['id'] = $id;
		$data['cat'] = 0;
		$data['story_single'] = $this->System_model->get_story_id($id);
		
		if($cat!='all'){
		  $data['stories'] = $this->Menu_model->get_story_cat($cat,$id);				  
		}
		$data['pages_story'] = $this->Menu_model->get_promotions($id);
		$data['slide']=$slide;
		
		
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/promotion_new',$data);
		$this->load->view('common/footer');
	}
	
	# Home - Story
	
	/*
	function stories($id)
	{
		$this->check_session();
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['id_active']=$id;
		$data['stories'] = $this->System_model->get_active_stories();
		$data['pages_story'] = $this->System_model->get_storypage($id);
		$data['story'] = $this->System_model->get_story_id($id);
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/story',$data);
		$this->load->view('common/footer');
	}
	*/
	function story_product_new($cat,$id,$sort='id',$limit =12,$row=0,$by='')
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = 'AU$';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['story'] = $this->System_model->get_story_id($id);
		if($cat!='single' && $cat!='single_all' ){$data['story'] = $this->System_model->get_story_id(5);}
		if($cat=='archive'){$data['story'] = $this->System_model->get_story_id(5);}
		//$data['products'] = $this->Product_model->get_product_story($cat,$id);
		
		
		//$cat = $this->Category_model->identify2($cat_name);
		$scat_name='';
		if($scat_name != 'all')
		{
			/*$scat = $this->Category_model->identify2($scat_name);
			$data['scate'] = $scat['title'];
			$scat_id = $scat['id'];
			
			$this->session->set_userdata('save_sub',$scat['title']);
			$this->session->set_userdata('save_sub_link',$scat_name);*/
		}
		else
		{
			$scat_id = 'all';
		}
		
		
		/*if($this->session->userdata('by'))
		{
			$by = $this->session->userdata('by');
		}
		else 
		{
			$by = '';
		}
		*/
		if($this->session->flashdata('look_by'))
		{
			$look_by = $this->session->flashdata('look_by');
		}
		else 
		{
			$look_by = '';
		}
		
		if($this->session->flashdata('text_keyword'))
		{
			$text = $this->session->flashdata('text_keyword');
		}
		else 
		{
			$text = '';
		}
		$cat_name='';
		$scat_name='';
		$data['cat_name'] = $cat_name;
		$data['scat_name'] = $scat_name;
		$data['look_by'] = $look_by;
		$data['text_key'] = $text;
		
		$all_products = $this->Product_model->get_product_story($cat,$id,$sort,0,0,$by);
		//$this->Product_model->get_new_product_list_all($cat['id'],$scat_id,$text,$by,$look_by);
		$data['products'] =  $this->Product_model->get_product_story($cat,$id,$sort,$row,$limit,$by);
		//$this->Product_model->get_new_product_list($cat['id'],$scat_id,$text,$by,$look_by,$row,$limit);	
		
		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."store/story_product_new/".$cat."/".$id."/".$limit."/";
		
		$config['total_rows'] = count($all_products);
		$config['per_page'] = $limit;
		$config['num_links'] = 3;
		$config['uri_segment'] = 6;
		//$config['cur_tag_open'] = '&nbsp;<span class="active">';
		//$config['cur_tag_close'] = '</span>';
		$config['tag_open'] = '<li>';
		$config['tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul>PG ';
		$config['full_tag_close'] = '&nbsp;&nbsp;</ul>';
			
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$row = 0;
		$data['total_row']=count($all_products);
		
		$data['cat_story_link']=$cat."/".$id."/".$sort."/".$limit."/".$row;
		$data['curr_opt']=$by;
		$this->load->view('common/header',$data);
		$this->load->view('store/story_product',$data);
		$this->load->view('common/footer');
	}
	
	function stories($cat='all',$id=0,$slide=-1)
	{
		$config['ssl_active'] = false;
		$this->check_session();
		if($cat=='single'){redirect('store/stories/single_all/'.$id.'/'.$slide);}
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['index']=1;
		$data['id_active']=$id;
		$data['stories'] = $this->Menu_model->get_active_stories();
		
		//$data['pages_story'] = $this->System_model->get_storypage($id);
		//if($id=='Lookbook'){$cat='latest season'; $id='';}
		
		$data['id'] = $id;
		$data['cat'] = $cat;
		$data['story_single'] = $this->System_model->get_story_id($id);
		$data['story_parent'] = $this->System_model->get_story_id($id);
		
		if($cat=='cat_all')
		{
			$cat_all=$this->System_model->get_story_id($id);			
			$data['stories'] = $this->Menu_model->get_story_cat($cat_all['category'],$id);				  			
			$data['pages_story'] = $this->Menu_model->get_story_all($cat_all['category'],$id);						
			$search_slide = $this->Menu_model->get_first_detail_story($id);
			$data['slide']=$search_slide['id'];			
		}		
		else
		{		
			
			if($cat!='all' && $cat!='single_all'){
			  $data['stories'] = $this->Menu_model->get_story_cat($cat,$id);				  
			}
			$data['pages_story'] = $this->Menu_model->get_story_all($cat,$id);
			
			$data['slide']=$slide;
			if($cat=='single_all')
			{
				$search_slide = $this->Menu_model->get_first_detail_story($id);
				$data['slide']=$search_slide['id'];
			}
		}
		if(strtoupper($cat)=='LATEST SEASON' || strtoupper($cat)=='LUGGAGE' || strtoupper($cat)=='ARCHIVE' || strtoupper($cat)=='SINGLE' || strtoupper($cat)=='SINGLE_ALL'){$data['index']=0;}
		else{$data['index']=ceil(count($data['stories'])/9);}
		$this->load->view('common/header',$data);
		$this->load->view('store/story',$data);
		$this->load->view('common/footer');
	}
	function stories_archive()
	{
		
		$this->check_session();
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		$id=5;
		$slide=-1;
		$cat='archive';
		$data['id_active']=$id;
		$data['stories'] = $this->Menu_model->get_active_archive();
		
		//$data['pages_story'] = $this->System_model->get_storypage($id);
		$data['story_single'] = $this->System_model->get_story_id($id);
		$data['pages_story'] = $this->Menu_model->get_story_all($cat,$id);
		$data['slide']=$slide;
		$data['index']=ceil(count($data['stories'])/9);
		$this->load->view('common/header',$data);
		$this->load->view('store/story_archive',$data);
		$this->load->view('common/footer');
	}
	function send_friend_email_story()
	{
		$story_id = $this->input->post('story_id');
		$slide_id = $this->input->post('slide_id');
		$cat = $this->input->post('cat');
		$friend_name = $this->input->post('friend_name');
		$friend_email = $this->input->post('friend_email');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$message = $this->input->post('message');
		
		
		//$prod = $this->Product_model->identify($prod_id);
		//$cat = $this->Category_model->identify($prod['main_category']);
		if($story_id==-1)
		{
			$url = base_url().'store/stories_archive';
		}
		else{
			$url = base_url().'store/stories/'.$cat.'/'.$story_id.'/'.$slide_id;
		}
		
		$text = "Hello $friend_name,<br/><br/>
		Your friend has recommended a Bared product to you. Please follow the link below to view it:<br/>
		<a href='$url'>$url</a><br/><br/>
		<b>Notes:</b><br/>
		$message<br/><br/>
		".SUB_FOOTER_EMAIL."<br/>
		Shop online at ".COMPANY_WEBSITE_LONG;
		
		
		
		
		$this->load->library('email');
		$config['mailtype'] = 'html';	
		$this->email->initialize($config);	
		$this->email->from($friend_email,$friend_name);
		$this->email->to($friend_email);
		
		$this->email->subject(COMPANY_NAME.' : Recommendation from '.$name);
		$this->email->message($text);
		$sent = $this->email->send();
		
		
		
		
		
		redirect(base_url().'store/stories/'.$cat.'/'.$story_id.'/'.$slide_id);
	}
	
	
	# Product Module
	
	function product1($cat_name='',$mcat='') {
		
		$cat = $this->Category_model->identify2($cat_name);
		$data['category'] = $cat;
		$data['cat_name'] = $cat_name;
		
		if($this->session->userdata('by'))
		{
			$by = $this->session->userdata('by');
		}
		else 
		{
			$by = '';
		}
		$data['products'] = $this->Product_model->get_product_by_category_shopby($cat['id_menu'],$by,$mcat);
		$data['shop_by'] = $this->Category_model->get_category_menu($cat['id']);
		
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/list_product');
		$this->load->view('common/footer');
	}

	function product($cat_name='',$scat_name='')
	{
		$this->session->set_userdata('look_by','');
		$this->session->set_userdata('text_keyword','');
		redirect(base_url().'store/products/'.$cat_name.'/'.$scat_name);
	}

	function products($cat_name='',$scat_name='',$look_by=0,$text=0,$limit =36,$row=0)
	{
		//error_reporting(E_ALL);
		//echo $cat_name.'<br/>'.$scat_name.'<br/>'.$look_by.'<br/>'.$text.'<br/>'.$limit.'<br/>'.$row.'<br/>';
		//error_reporting(E_ALL);
		// if($this->session->userdata('cat_name'))
		// {
			// if($this->session->userdata('cat_name') != $cat_name)
			// {
				// $this->session->set_userdata('look_by','');
				// $this->session->set_userdata('text_keyword','');
			// }
		// }
		// else 
		// {
			// $this->session->set_userdata('look_by','');
			// $this->session->set_userdata('text_keyword','');
			// $this->session->set_userdata('cat_name',$cat_name);
		// }
// 		
		// if($this->session->userdata('scat_name'))
		// {
			// if($this->session->userdata('scat_name') != $scat_name)
			// {
				// $this->session->set_userdata('look_by','');
				// $this->session->set_userdata('text_keyword','');
			// }
		// }
		// else 
		// {
			// $this->session->set_userdata('look_by','');
			// $this->session->set_userdata('text_keyword','');
			// $this->session->set_userdata('scat_name',$scat_name);
		// }
		
		// if($this->session->userdata('cat_name') == $cat_name && $this->session->userdata('scat_name') == $scat_name)
		// {
			// if($limit == 0 and $row == 0)
			// {
				// $this->session->set_userdata('look_by','');
				// $this->session->set_userdata('text_keyword','');
			// }
		// }
		
		
						
		if($limit != 0)
		{
			$this->session->set_userdata('prod_limit',$limit);
		}
		else 
		{
			if($this->session->userdata('prod_limit'))
			{
				$limit = $this->session->userdata('prod_limit');
			}
			else
			{
				$limit = 12;
				$this->session->set_userdata('prod_limit',$limit);
			}
		}
		$cat = $this->Category_model->identify2($cat_name);
		//echo $scat_name;
		if($scat_name != 'all')
		{
			//echo $scat_name;
			$scat = $this->Category_model->identify_sub($scat_name,$cat['id']);
			$data['scate'] = $scat['title'];
			$scat_id = $scat['id'];
			
			$this->session->set_userdata('save_sub',$scat['title']);
			$this->session->set_userdata('save_sub_link',$scat_name);
		}
		else
		{
			$scat_id = 'all';
		}
		
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		if($this->session->userdata('by'))
		{
			$by = $this->session->userdata('by');
		}
		else 
		{
			$by = 'pos';
		}
		
		// if($look_by != '')
		// {
			// $look_by = $this->session->userdata('look_by');
		// }
		// else 
		// {
			// $look_by = '';
		// }
// 		
		// if($this->session->userdata('text_keyword'))
		// {
			// $text = $this->session->userdata('text_keyword');
		// }
		// else 
		// {
			// $text = '';
		// }
		
		$data['cat_name'] = $cat_name;
		$data['scat_name'] = $scat_name;
		$data['look_by'] = $look_by;
		$data['text_key'] = $text;
		
		$all_products = $this->Product_model->get_new_product_list_all_position($cat['id'],$scat_id,$text,$by,$look_by);
		//echo $this->db->last_query();
		//echo count($all_products);
		//$data['products'] = $this->Product_model->get_new_product_list($cat['id'],$scat_id,$text,$by,$look_by,$row,$limit);	
		
		$data['products'] = $this->Product_model->get_new_product_list_position($cat['id'],$scat_id,$text,$by,$look_by,$row,$limit);	
		$data['def']=$by;
		//print_r($data['products']);
		
		//echo $this->db->last_query();
		
		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."store/products/".$cat_name."/".$scat_name."/".$look_by."/".$text."/".$limit."/";
		
		$config['total_rows'] = count($all_products);
		$config['per_page'] = $limit;
		$config['num_links'] = 3;
		$config['uri_segment'] = 8;
		$config['cur_tag_open'] = '&nbsp;<span class="active_opt">';
		$config['cur_tag_close'] = '</span>';
		$config['tag_open'] = '<li>';
		$config['tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul>PG ';
		$config['full_tag_close'] = '&nbsp;&nbsp;</ul>';
		$config['last_link'] = false;
			
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$row = 0;
		$data['total_row']=count($all_products);
		
		$this->load->view('common/header',$data);
		$this->load->view('store/new_list_product');
		$this->load->view('common/footer');
		
	}

	function reset_search_product_by()
	{
		$this->session->set_userdata('look_by','');
		$this->session->set_userdata('text_keyword','');
		
		if($this->session->userdata('search_keyword'))
		{
			$s = $this->session->userdata('search_keyword');
		}
		else
		{
			$s = '';
		}
		
		redirect(base_url()."store/search_result/".$s."/");
	}

	function search_product_by($look_by,$text)
	{
		//$this->session->set_userdata('look_by',$look_by);
		//$this->session->set_userdata('text_keyword',$text);
		
		if($this->session->userdata('search_keyword'))
		{
			$s = $this->session->userdata('search_keyword');
		}
		else
		{
			$s = '';
		}
		
		redirect(base_url()."store/search_result/".$s."/".$look_by."/".$text."/");
		
		//redirect(base_url()."store/products/$cat_name/$scat_name");
	}

	function product_by($cat_name='',$scat_name='',$look_by,$text)
	{
		//$this->session->set_userdata('look_by',$look_by);
		//$this->session->set_userdata('text_keyword',$text);
		
		redirect(base_url()."store/products/$cat_name/$scat_name/$look_by/$text");
	}
	
	function product_sort_by()
	{
		$sort_by = $_POST['by'];
		$this->session->set_userdata('by',$sort_by);
	}
	

	function product_sort_by1($cat_name='',$scat_name='',$look_by='',$text='',$sort_by)
	{
		$this->session->set_userdata('by',$sort_by);
		if($look_by == '')
		{
			echo 123;
		}
		$link = base_url().'store/products/'.$cat_name.'/'.$scat_name.'/'.$look_by.'/'.$text;
		echo $link;
		exit;
		redirect($link);
	}
	
	function search_product_sort_by($s='',$look_by='',$text='',$sort_by)
	{
		$this->session->set_userdata('by',$sort_by);
		
		// if($this->session->userdata('search_keyword'))
		// {
			// $s = $this->session->userdata('search_keyword');
		// }
		// else
		// {
			// $s = '';
		// }
		
		redirect(base_url()."store/search_result/".$s."/".$look_by."/".$text."/");
	}

	function product_by_reset($cat_name='',$scat_name='')
	{
		$this->session->set_userdata('look_by','');
		$this->session->set_userdata('text_keyword','');
		
		redirect(base_url()."store/products/$cat_name/$scat_name");
	}
	
	
    function products_search($cat_name='',$type='',$text='',$cm_id=0) {
		
		$cat = $this->Category_model->identify2($cat_name);
		$data['category'] = $cat;
		$data['cat_name'] = $cat_name;		
		$data['shop_by'] = $this->Category_model->get_category_menu($cat['id']);
		//$this->output->enable_profiler(TRUE);
		
		if($this->session->userdata('by'))
		{
			$by = $this->session->userdata('by');
		}
		else 
		{
			$by = '';
		}
		
		if($type=='shop_by')
		{
			$data['products'] = $this->Product_model->get_product_by_category_shopby($cm_id,$by);
		}
		if($type=='style')
		{
			$data['products'] = $this->Product_model->get_product_by_category_style($cat['id_menu'],$text,$by);
		}
		if($type=='colour')
		{
			$data['products'] = $this->Product_model->get_product_by_category_colour($cat['id_menu'],$text,$by);
		}
		if($type=='size')
		{
			$data['products'] = $this->Product_model->get_product_by_category_size($cat['id_menu'],$text,$by);
		}
		if($type=='price')
		{
			$data['products'] = $this->Product_model->get_product_by_category_price($cat['id_menu'],$text,$by);
		}
		
		
		
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/list_product');
		$this->load->view('common/footer');
	}

	

	function story_product()
	{
		$this->load->view('common/header');
		$this->load->view('store/story_product');
		$this->load->view('common/footer');
	}
	
	function story_product_from_cart($id)
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = 'AU$';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['story'] = $this->System_model->get_story_id($id);
		$data['products'] = $this->Product_model->get_product_per_story($id);
		
		$this->load->view('common/header',$data);
		$this->load->view('store/story_product',$data);
		$this->load->view('common/footer');
	}
	
	function set_giftcard_data()
	{
		$this->session->set_userdata('gcard_recipient',$_POST['recipient']);
		$this->session->set_userdata('gcard_sender',$_POST['sender']);
		$this->session->set_userdata('gcard_notes',$_POST['notes']);
		$this->session->set_userdata('gcard_id',$_POST['id']);
		$this->session->set_userdata('gcard_amount',$_POST['amount']);
	}

	function giftcard_preview()
	{
		if($this->session->userdata('gcard_recipient'))
		{
			$data['recipient'] = $this->session->userdata('gcard_recipient');
		}
		else 
		{
			$data['recipient'] = '(Recipient)';
		}
		
		if($this->session->userdata('gcard_sender'))
		{
			$data['sender'] = $this->session->userdata('gcard_sender');
		}
		else 
		{
			$data['sender'] = '(Sender)';
		}
		//$this->load->view('store/ecard_preview');
		
		if($this->session->userdata('gcard_notes'))
		{
			$data['notes'] = $this->session->userdata('gcard_notes');
		}
		else 
		{
			$data['notes'] = "Here's a little present for you for our 30th wedding anniversary.";
		}
		
		if($this->session->userdata('gcard_id'))
		{
			$data['id'] = $this->session->userdata('gcard_id');
		}
		else 
		{
			$data['id'] = false;
		}
		
		if($this->session->userdata('gcard_amount'))
		{
			$data['amount'] = number_format($this->session->userdata('gcard_amount'),2,'.',',');
		}
		else 
		{
			$data['amount'] = 123.00;
		}
		
		$this->load->view('store/gcard_preview',$data);
	}
	
	
	
	
	function detail_product($cat_name='',$id_title='')
	{
		
		$product = $this->Product_model->identify2($id_title);

		$titles=explode('-',$product['title']);
		$title=$titles[0];		
		if(!$product) { redirect('error/error_404'); }
		$data['hero'] = $this->Product_model->get_hero($product['id']);
		$data['photos'] = $this->Product_model->get_all_photos($product['id']);
		$data['crosssales'] = $this->Product_model->get_crosssales($product['id']);
		$data['attributes'] = $this->Product_model->get_attributes($product['id']);
		$data['product'] = $product;
		if(($product['sale_price'] < $product['price']) || ($product['sale_price_trade'] < $product['price_trade']))
		{
			$data['sale'] = 'yes';
		}
		else 
		{
			$data['sale'] = 'no';
		}
		$data['cat_name']=$cat_name;
		$first = $this->Product_model->get_first_edition($product['title']);
		//echo $this->db->last_query();
		
		if(count($first) > 0)
		{
			//echo 'test';
			$data['first'] = $first['id_title'];
		}
		else
		{
			$data['first'] = '';
		}
		
		//if($this->session->userdata('cur_sign') != NULL)
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['features1'] = $this->Product_model->get_features1();
		$data['features2'] = $this->Product_model->get_features2();
		$data['features3'] = $this->Product_model->get_features3();
		$cc = 1;
		$cd=1;
		$ce=1;
		$first6 = array();
		$second6 = array();
		$all_other = array();
		
		$other = $this->Product_model->get_other_title_product($product['title'],'',$product['id']);
		
		//$other_title = $this->Product_model->get_other_product($titles[1],$product['id']);
		$data['like_other']=$other;
		//$other_title = $this->Product_model->get_other_product($titles[1],$product['id']);
		foreach($other as $ot)
		{
			$hero = $this->Product_model->get_hero($ot['id']);
			
			if($hero && $ot['status']==1 && $ot['deleted']==0 && $ot['gift_card']==0 && $ot['id']!=$product['id'] && $ot['main_category']==$product['main_category']){
				$all_other[]=$ot['id'];
			}
		}
		$all_other_ori = $all_other;
		
		$all_other[]=$product['id'];
		$cc = count($all_other_ori);
		$main_category = $product['main_category'];		
		if($cc<12){
			$prod12 = $this->Product_model->random_new_like_other($title,$all_other,$main_category);
			foreach($prod12 as $item)
			{
				if($cc<=12)
				{					
					$hero = $this->Product_model->get_hero($item['id']);
					if($hero)
					{
						$all_other_ori[]=$item['id'];
						$cc++;
					}
				}
				
				
			}
			$data['like_feature'] = $all_other_ori;
			//$data['first6'] = $this->Product_model->get_features1();
			//$data['second6'] = $this->Product_model->get_features2();
		}
		else
		{
			
			
			$prod12 = $this->Product_model->random_new_like_other($title,$all_other,$main_category);
			//echo "<pre>".print_r($prod12,true)."</pre>";
			foreach($prod12 as $item)
			{
				if($cc<6)
				{
					$first6[$cd] = $item['id'];
					$cd++;
				}
				else if($cc >= 6 && $cc <=12)
				{
					$second6[$ce-1] = $item['id'];
					$ce++;
				}
				$cc++;
				
			}
			$data['first6'] = $first6;
			$data['second6'] = $second6;
			$data['like_feature'] = $all_other_ori;
		}
		$data['save_sub'] = '';
		$data['save_sub_link'] = '';
		if($this->session->userdata('save_sub'))
		{
			
			$data['save_sub'] = $this->session->userdata('save_sub');
			$s_sub = $this->session->userdata('save_sub').' - ';
			$data['save_sub_link'] = $this->session->userdata('save_sub_link');
			$this->session->unset_userdata('save_sub');
			$this->session->unset_userdata('save_sub_link');
		}
		else 
		{
			$s_sub = '';
			$data['save_sub'] = '';
			$data['save_sub_link'] = '';
		}
		
		$data['page_title'] = COMPANY_NAME.' - '. $cat_name .' - '. $s_sub . $product['short_desc'] .' - '. $product['title'];
		$data['page_desc'] = COMPANY_NAME.' - '. $cat_name .' - '. $s_sub . $product['short_desc'] .' - '. $product['title'];
		
		//$data['page_title'] = 'Bared Footware - '. $cat_name .' - '. $product['title'];
		
		$data['cross_sale'] = $this->Product_model->get_crosssales_products($all_other_ori);
		
		
		$this->load->view('common/header',$data);
		//$this->load->view('common/header');
		if($product['gift_card'] != 1)
		{
			$this->load->view('store/detail_product');
		}
		else 
		{
			$this->load->view('store/detail_gcard');
		}
		$this->load->view('common/footer');
	}
	
	
	function boutique()
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$this->load->view('common/header',$data);
		$this->load->view('store/boutique');
		$this->load->view('common/footer');
	}
	
	function sort_by()
	{
		$by = $_POST['by'];
		$this->session->set_userdata('by',$by);
		
		echo $by;
	}
	
	
	
	
	function search()
	{
		$keyword = $_POST['keyword'];
		//echo $keyword;
		//exit;
		if(strpos($keyword, "'") !== FALSE)
		{
			$keyword = str_replace("'", "#", $keyword);
		}
		$this->session->set_userdata('search_keyword',$keyword);
		$this->session->set_userdata('look_by','');
		$this->session->set_userdata('text_keyword','');
		
		redirect(base_url().'store/search_result/'.$keyword);
	}
	
	function search_result($keyword='',$look_by=' ',$text=' ',$limit =12,$row=0)
	{
		//$keyword = $_POST['keyword'];
		//echo $keyword;
		
		//$keyword = $this->session->userdata('search_keyword');
		
		
		// if($this->session->userdata('search_keyword'))
		// {
			// if($this->session->userdata('search_keyword') != $keyword)
			// {
				// $this->session->set_userdata('look_by','');
				// $this->session->set_userdata('text_keyword','');
			// }
		// }
		// else 
		// {
			// $this->session->set_userdata('look_by','');
			// $this->session->set_userdata('text_keyword','');
			// //$this->session->set_userdata('cat_name',$cat_name);
		// }
		
		
		if(strpos($keyword, "#") !== FALSE)
		{
			$keyword = str_replace("#", "'", $keyword);
		}
		
		if($this->session->userdata('by'))
		{
			$by = $this->session->userdata('by');
		}
		else 
		{
			$by = '';
		}
		
		// if($this->session->userdata('look_by'))
		// {
			// $look_by = $this->session->userdata('look_by');
		// }
		// else 
		// {
			// $look_by = '';
		// }
// 		
		// if($this->session->userdata('text_keyword'))
		// {
			// $text = $this->session->userdata('text_keyword');
		// }
		// else 
		// {
			// $text = '';
		// }
		$data['s_keyword'] = $keyword;
		$data['cat_name'] = '';
		$data['scat_name'] = '';
		$data['look_by'] = $look_by;
		$data['text_key'] = $text;
		
		
		
		$all_products = $this->Product_model->get_new_search_product_list_all($keyword,$text,$by,$look_by);
		//echo $this->db->last_query().'<br/>';
		$data['products'] = $this->Product_model->get_new_search_product_list($keyword,$text,$by,$look_by,$row,$limit);	
		
		#echo '<pre>' . print_r($data['products'],true). '</pre>';exit;
		
		//echo $this->db->last_query();
		
		//echo $this->db->last_query();
		
		//echo $this->db->last_query();
		$this->load->library('pagination');
		$config['base_url'] = base_url()."store/search_result/".$keyword."/".$look_by."/".$text."/".$limit."/";
		
		$config['total_rows'] = count($all_products);
		$config['per_page'] = $limit;
		$config['num_links'] = 2;
		$config['uri_segment'] = 7;
		$config['cur_tag_open'] = '&nbsp;<span class="active_opt">';
		$config['cur_tag_close'] = '</span>';
		$config['tag_open'] = '<li>';
		$config['tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul>PG ';
		$config['full_tag_close'] = '&nbsp;&nbsp;</ul>';
			
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$row = 0;
		$data['total_row']=count($all_products);
		
		
		
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/search_list_product');
		$this->load->view('common/footer');
	}

	function contact_us()
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$this->load->view('common/header',$data);
		$this->load->view('admin/cms/show_new_contact',$data);
		$this->load->view('common/footer',$data);
	}

	function submit_contact_us()
	{
		
		$msg=" Hi,<br/><br/>
		
		This is a new customer contact from Bared Contact Us<br/><br/>
		<table>
			<tr>
				<td>Name</td>
				<td>".$_POST['name']."</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>".$_POST['email']."</td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>".$_POST['phone']."</td>
			</tr>
			<tr>
				<td>Subject</td>
				<td>".$_POST['subject']."</td>
			</tr>
			<tr>
				<td>Message</td>
				<td>".$_POST['message']."</td>
			</tr>
		</table>
		";
		if($_POST['email']!='' && $_POST['name']!=''){
			$this->load->library('email');
			$config['mailtype'] = 'html';	
			$this->email->initialize($config);	
			$this->email->from($_POST['email'],$_POST['name']);
			$this->email->to('info@bared.com.au');
			$this->email->bcc('raquel@propagate.com.au');
			$this->email->subject('New Customer Contact Us');
			$this->email->message($msg);
			$sent = $this->email->send();
			
			//print_r($_POST);
			//exit;
			
			
			$this->session->set_flashdata('cu_submit','yes');
		}
		redirect(base_url().'store/page/47');
	}
	
	function page($id)
	{
		//echo $id;
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		$pages = $this->Menu_model->getpage($id);
		$data['pages'] = $pages;
        if($pages['display']==0){
			$this->load->view('common/header',$data);
			if($id != '38' && $id != '47')
			{
				$this->load->view('admin/cms/show_new',$data);
			}
			else
			{
				if($id == '47')
				{
					$this->load->view('admin/cms/show_new_contact',$data);
				}
				else 
				{
					$this->load->view('admin/cms/show_new2',$data);
				}
				
			}
			$this->load->view('common/footer',$data);
		}else
		{
			$this->load->view('common/header_popout',$data);
			if($id != '38' && $id != '47')
			{
				$this->load->view('admin/cms/show_new',$data);
			}
			
			else
			{
				if($id == '47')
				{
					$this->load->view('admin/cms/show_new_contact',$data);
				}
				else 
				{
					$this->load->view('admin/cms/show_new2',$data);
				}
			}
		}
	}
	
	function pages($title)
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		$pages = $this->Menu_model->getpagetitle($title);
		$id=$pages['id'];
		$data['pages'] = $pages;
        if($pages['display']==0){
			$this->load->view('common/header',$data);
			if($id != '38' && $id != '47')
			{
				$this->load->view('admin/cms/show_new',$data);
			}
			else
			{
				if($id == '47')
				{
					$this->load->view('admin/cms/show_new_contact',$data);
				}
				else 
				{
					$this->load->view('admin/cms/show_new2',$data);
				}
				
			}
			$this->load->view('common/footer',$data);
		}else
		{
			$this->load->view('common/header_popout',$data);
			if($id != '38' && $id != '47')
			{
				$this->load->view('admin/cms/show_new',$data);
			}
			
			else
			{
				if($id == '47')
				{
					$this->load->view('admin/cms/show_new_contact',$data);
				}
				else 
				{
					$this->load->view('admin/cms/show_new2',$data);
				}
			}
		}
	
	}
	function send_friend_email()
	{
		$prod_id = $_POST['prod_id'];
		$friend_name = $_POST['friend_name'];
		$friend_email = $_POST['friend_email'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		
		$prod = $this->Product_model->identify($prod_id);
		$cat = $this->Category_model->identify($prod['main_category']);
		
		$url = base_url().'store/detail_product/'.$cat['title'].'/'.$prod['id_title'];
		
		
		$text = "Hello $friend_name,<br/><br/>
		Your friend has recommended a ".COMPANY_NAME." product to you. Please follow the link below to view it:<br/>
		<a href='$url'>$url</a><br/><br/>
		<b>Notes:</b><br/>
		$message<br/><br/>
		".SUB_FOOTER_EMAIL."<br/>
		Shop online at ".COMPANY_WEBSITE_LONG;
		
		
		
		
		$this->load->library('email');
		$config['mailtype'] = 'html';	
		$this->email->initialize($config);	
		$this->email->from($friend_email,$friend_name);
		$this->email->to($friend_email);
		
		$this->email->subject(COMPANY_NAME. ': Recommendation from '.$name);
		$this->email->message($text);
		$sent = $this->email->send();
		
		
		
		$prod = $this->Product_model->identify($prod_id);
		$cat = $this->Category_model->identify($prod['main_category']);
		
		redirect(base_url().'store/detail_product/'.$cat['title'].'/'.$prod['id_title']);
		
	}
    function edit_profile()
	{
		$user = $this->session->userdata('userloggedin');
		$customer_id = $user['customer_id'];
		$customer = $this->Customer_model->identify($customer_id);
		if($customer['dealer']==0)
		{
			redirect('store/edit_detail_retail/'.$customer_id);
		}else
		{
			redirect('store/edit_detail_trade/'.$customer_id);
		}
	}
	function edit_detail_retail($id)
	{
		if(!$this->session->userdata('userloggedin')){
			redirect('store/signin');	
		}else{
			$loggedin_user = $this->session->userdata('userloggedin');
			if($loggedin_user['id'] != $id){
				redirect('store/edit_detail_retail/'.$loggedin_user['id']);	
			}
		}
		
		if(isset($_POST['sub_email']))
		{
			//echo $_POST['sub_email']; 
			$data['sub_email'] = $_POST['sub_email']; 
		}
		else
		{
			$data['sub_email'] = '';
		}
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['states'] = $this->System_model->get_states();
		
		$data['cust'] = $this->Customer_model->identify($id);
		
		
		$this->load->view('common/header',$data);
		$this->load->view('store/edit_retail');
		$this->load->view('common/footer');
	}

	function update_retail()
	{
		$id = $_POST['id'];
		if(isset($_POST['title']))
		{
			$title = $_POST['title'];
		}
		else 
		{
			$title = '';	
		}
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		//$birthday = date('Y-m-d',strtotime($_POST['birthday']));
		$passsword = $_POST['password'];
		$password2 = $_POST['password'];
		$month_dob = $_POST['month_dob'];
		$date_dob = $_POST['date_dob'];
		$address = $_POST['address1'];
		$address2 = $_POST['address2'];
		$phone = $_POST['phone'];
		$mobile = $_POST['mobile'];
		$country = $_POST['country'];
		$state = $_POST['province'];
		$suburb = $_POST['suburb'];
		$postcode = $_POST['postcode'];
	
		$data['title'] = $title;
		$data['firstname'] = $firstname;
		$data['lastname'] = $lastname;
		//$data['birthday'] = $birthday;
		$data['month_dob'] = $month_dob;
		$data['date_dob'] = $date_dob;
		
		$data['address'] = $address;
		$data['address2'] = $address2;
		$data['phone'] = $phone;
		$data['mobile'] = $mobile;
		$data['country'] = $country;
		$data['state'] = $state;
		$data['suburb'] = $suburb;
		$data['postcode'] = $postcode;
		$data['modified'] = date('Y-m-d H:i:s');
		
		
		$this->Customer_model->update($id,$data);
		
		$user = $this->User_model->identify_cust_id($id);
		
		if($passsword != '')
		{
			$ndata['password'] = md5($passsword);
			$this->User_model->update($user['id'],$ndata);
		}
		
		$session_id = $this->session->userdata('session_id');
		
		$count_shopbag = count($this->Cart_model->all($session_id));	
		
		if($count_shopbag > 0)
		{
			redirect(base_url().'cart/account_page');
		}
		else 
		{
			redirect(base_url().'store/edit_detail_retail/'.$id);
		}
		
		
	}
	
	function edit_detail_trade($id)
	{
		if(isset($_POST['sub_email']))
		{
			//echo $_POST['sub_email']; 
			$data['sub_email'] = $_POST['sub_email']; 
		}
		else
		{
			$data['sub_email'] = '';
		}
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['states'] = $this->System_model->get_states();
		$cust = $this->Customer_model->identify($id);
		$data['cust'] = $cust;
		
		$data['btype'] = json_decode($cust['btype']);
		$data['interested'] = json_decode($cust['interested']);
		
		$this->load->view('common/header',$data);
		$this->load->view('store/edit_trade_register');
		$this->load->view('common/footer');
	}

	function update_trade_detail()
	{
		$id = $_POST['id'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$title = $this->input->post('title',true);
		$firstname = $this->input->post('first_name',true);
		$lastname = $this->input->post('last_name',true);
		$website = $this->input->post('website',true);
		$bussiness_name = $this->input->post('bussiness_name',true);
		$trading = $this->input->post('trading',true);
		$abn = $this->input->post('abn',true);
		$telephone = $this->input->post('telephone',true);
		$fax = $this->input->post('fax',true);
		$mobile = $this->input->post('mobile',true);
		$address1 = $this->input->post('address',true);
		$address2 = $this->input->post('address2',true);
		$suburb = $this->input->post('suburb',true);
		$state = $this->input->post('province',true);
		$country = $this->input->post('country',true);
		$postcode = $this->input->post('postcode',true);
		$btype = $this->input->post('btype',true);
		$btype = json_encode($btype);
		$interested = $this->input->post('interested',true);
		$interested = json_encode($interested);
		
		$data = array(
			'title' => $title,
			'firstname' => $firstname,
			'lastname' => $lastname,	
			'email' => $email,								
			'website' => $website,	
			'tradename' => $bussiness_name,		
			'trading' => $trading,	
			'abn' => $abn,	
			'phone' => $telephone,	
			'fax' => $fax,	
			'mobile' => $mobile,	
			'address' => $address1,	
			'address2' => $address2,	
			'suburb' => $suburb,
			'state' => $state,
			'country' => $country,
			'postcode' => $postcode,
			'btype' => $btype,
			'interested' => $interested,
			'dealer' => 1,
			'modified' => date('Y-m-d H:i:s')
		);
		$this->Customer_model->update($id,$data);
		
		
		if($passsword != '')
		{
			$ndata['passsword'] = $passsword;
			$this->User_model->update($user['id'],$ndata);
		}
		redirect(base_url().'store/edit_detail_trade/'.$id);
	}
	
	
	# STOCKIST
	
	
	function stockist()
	{
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		//$data['cart'] = $this->Cart_model->all($this->session->userdata('session_id'));
		//$data['cart'] = $this->Cart_model->all_save($user['customer_id']);
		//$data['cart'] = $this->Cart_model->all('4952959018f925261a4d7838722b0eb1');
		$data['page_title'] = "Stockist";
		$data['pages'] = $this->Menu_model->getpage(43);
		$this->load->view('common/header',$data);
		
		$this->load->view('store/stockist');
		$this->load->view('common/footer');
	}		

	function stockist_change_country()
	{
		$keyword = $_POST['keyword'];
		$result = $this->System_model->next_step_by_step1($keyword);
		$text = "<select onchange='state_change();' id='state' style='width: 100%'>";
		if($keyword == 'AU')
		{
			$text .= "<option value=''>State</option>";
		}
		if($keyword == 'NZ')
		{
			$text .= "<option value=''>Suburb</option>";
		}
		if($keyword == 'OT')
		{
			$text .= "<option value=''>Country</option>";
		}
		
		
		foreach($result as $rs)
		{
			$r = $rs['result'];
			if($r != '')
			{
				$text .= "<option value='$r'>$r</option>";
			}
		}
		
		$text .= "</select>";
		
		echo $text;
	}

	function stockist_change_state_au()
	{
		$keyword = $_POST['keyword'];
		
		$result = $this->System_model->next_step_by_step2($keyword);
		$text = "<select onchange='suburb_change();' id='suburb' style='width: 100%'>";
		$text .= "<option value=''>Suburb</option>";
		
		foreach($result as $rs)
		{
			$r = $rs['result'];
			if($r != '')
			{
				$text .= "<option value='$r'>$r</option>";
			}
		}
		
		$text .= "</select>";
		
		echo $text;
	}
	
	function get_stockist()
	{
		$country = $_POST['country'];
		$state = $_POST['state'];
		$suburb = $_POST['suburb'];
		
		if($country == 'AU')
		{
			$sql = "SELECT  * from stockist where `suburb` = '$suburb' and `country` = 'Australia' and `state` = '$state' and `status` = 'A'";
			$query = $this->db->query($sql);
			$result =  $query->result_array();
		}
		if($country == 'NZ')
		{
			$sql = "SELECT * from stockist where `suburb` = '$state' and `status` = 'A'  and (`country` = 'NZ' or `country` = 'NEW ZEALAND')";
			$query = $this->db->query($sql);
			$result =  $query->result_array();
		}
		if($country == 'OT')
		{
			$sql = "SELECT * from stockist where `country` = '$state' and `status` = 'A'";
			$query = $this->db->query($sql);
			$result =  $query->result_array();
		}
		
		$count = count($result);
		$line = floor($count / 3);
		
		//echo $sql.'-'.$count.'-'.$line;
		$cc = 1;
		$text = '';
		foreach($result as $r)
		{
			if($cc % 3 == 1)
			{
				if($cc<1)
				{
					$text .= '<div class="row-fluid" style="border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 10px">';
				}
				else
				{
					$text .= '<div class="row-fluid" style="padding-bottom: 10px; margin-bottom: 10px">';
				}
				
				$text .= '<div class="span4" style="border-left: 1px solid #696969">';
				$text .= '<div style="margin-left: 5%; padding-top: 20px">';
				$text .= '<div>';
				$text .= $r['name'].'<br/>';
				$text .= '<br/>';
				$text .= $r['address'].'<br/>';
				$text .= $r['state'].' '.$r['postcode'].'<br/>';
				$text .= $r['country'].'<br/>';
				$text .= '<b>Phone: </b>'.$r['phone'];
				$text .= '</div>';
				$text .= '<div style="height: 20px"></div>';
				$text .= '</div>';
				$text .= '</div>';
				$text .= '';
				$text .= '';

			}
			if($cc % 3 == 2)
			{
				$text .= '<div class="span4" style="border-left: 1px solid #696969">';
				$text .= '<div style="margin-left: 5%; padding-top: 20px">';
				$text .= '<div>';
				$text .= $r['name'].'<br/>';
				$text .= '<br/>';
				$text .= $r['address'].'<br/>';
				$text .= $r['state'].' '.$r['postcode'].'<br/>';
				$text .= $r['country'].'<br/>';
				$text .= '<b>Phone: </b>'.$r['phone'];
				$text .= '</div>';
				$text .= '<div style="height: 20px"></div>';
				$text .= '</div>';
				$text .= '</div>';
				$text .= '';
				$text .= '';
			}
			if($cc % 3 == 0)
			{
				$text .= '<div class="span4" style="border-left: 1px solid #696969">';
				$text .= '<div style="margin-left: 5%; padding-top: 20px">';
				$text .= '<div>';
				$text .= $r['name'].'<br/>';
				$text .= '<br/>';
				$text .= $r['address'].'<br/>';
				$text .= $r['state'].' '.$r['postcode'].'<br/>';
				$text .= $r['country'].'<br/>';
				$text .= '<b>Phone: </b>'.$r['phone'];
				$text .= '</div>';
				$text .= '<div style="height: 20px"></div>';
				$text .= '</div>';
				$text .= '</div>';
				$text .= '';
				
				
				
				
				$text .= '</div>';
				
				
			}
			
			$cc++;
		}

		if($cc % 3 == 1)
		{
			//nothing
		}
		if($cc % 3 == 2)
		{
			$text .= '<div class="span4" style="">';
			$text .= '<div style="margin-left: 5%; padding-top: 20px">';
			$text .= '<div>';
			$text .= '&nbsp;';
			$text .= '</div>';
			$text .= '</div>';
			$text .= '</div>';
			$text .= '';
			$text .= '';
		}
		if($cc % 3 == 3)
		{
			$text .= '<div class="span4" style="">';
			$text .= '<div style="margin-left: 5%; padding-top: 20px">';
			$text .= '<div>';
			$text .= '&nbsp;';
			$text .= '</div>';
			$text .= '</div>';
			$text .= '</div>';
			$text .= '';
			
			
			
			
			$text .= '</div>';
		}

		echo $text;
		
		
	}
	
	function redirect($banner_id="") {
		$banner = $this->System_model->get_banner($banner_id);
		if ($banner) {
			$hit = $banner['hit'] + 1;
			$this->System_model->update_banner($banner['id'],array('hit' => $hit));		
		} else { $banner = array('url' => '#'); }
		if ($banner['url'] == "http://") { $banner['url'] = '#'; }
		if ($banner['url'] == "") { $banner['url'] = '#'; }
		redirect($banner['url']);
	}
	
	function gallery($cat='all',$id=0,$slide=-1)
	{
		$this->load->model('System_model');             
		$this->load->model('Category_model');
		$this->load->model('Product_model');
		$this->load->model('Menu_model');               
		
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			//echo $this->session->userdata('cur_val');
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['index']=1;
		$data['slide']=-1;
		$data['pages_story']=1;
		$data['id_active']=$id;
		$data['stories'] = $this->Gallery_model->get_galleries_activepreview();
		
		//$data['pages_story'] = $this->System_model->get_storypage($id);
		//if($id=='Lookbook'){$cat='latest season'; $id='';}
		
		$data['id'] = $id;
		$data['cat'] = $cat;
		$data['story_single'] = $this->Gallery_model->get_galleries();
		$data['story_parent'] = $this->Gallery_model->get_galleries();
		
						
		$data['index']=ceil(count($data['stories'])/6);
		$this->load->view('common/header',$data);
		$this->load->view('admin/gallery/admin_gallery_preview',$data);
		$this->load->view('common/footer');
	}
}
?>