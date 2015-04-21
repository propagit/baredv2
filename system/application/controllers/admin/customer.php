<?php
class Customer extends Controller {
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		$this->load->model('Category_model');
		$this->load->model('Product_model');
		$this->load->model('System_model');
		$this->load->model('Order_model');
		$this->load->model('Customer_model');
		$this->load->model('User_model');
		$this->load->model('Subscribe_model');
		
	}
	
	/* 1. 0. Dashboard */
	function index() {
		
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/common/footer');
	}
	
	function list_all_retail()
	{
		$this->session->set_userdata('type',1);
		redirect('admin/customer/list_all');
	}
	
	function list_all_trade()
	{
		$this->session->set_userdata('type',2);
		redirect('admin/customer/list_all');
	}
	
	function list_all_subcribe()
	{
		$this->session->set_userdata('type',5);
		redirect('admin/customer/list_all');
	}
	
	function list_all_competition()
	{
		$this->session->set_userdata('type',6);
		redirect('admin/customer/list_all');	
	}
	
	function list_all($action="",$value="")
	{
		if ($action == "search") {
			$this->session->set_userdata('name',$_POST['name']);
			//$this->session->set_userdata('email',$_POST['email']);
			$this->session->set_userdata('type',$_POST['type']);
			redirect('admin/customer/list_all');
		}
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		if ($action == "edit") {
			$user = $this->User_model->id($value);
			$data['customer'] = $this->Customer_model->identify($user['customer_id']);
			$data['user'] = $user;
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			$data['comments'] = $this->Customer_model->all_comment($user['customer_id']);
			$data['total'] = $this->Customer_model->get_total_spend($user['customer_id']);
			$this->load->view('admin/customer/edit',$data);
		} elseif ($action == "edit_trader") {
			$user = $this->User_model->id($value);
			$data['customer'] = $this->Customer_model->identify($user['customer_id']);
			$data['user'] = $user;
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			$data['comments'] = $this->Customer_model->all_comment($user['customer_id']);
			$data['total'] = $this->Customer_model->get_total_spend($user['customer_id']);
			$this->load->view('admin/customer/edit_trader',$data);
		} else {
			//$type = 1;
			//$dealer=0;
			//$this->session->set_userdata('dealer',$dealer);
			//echo $this->session->userdata('type');
			
			if ($this->session->userdata('type')) 
			{ 
				$type = $this->session->userdata('type'); 				
				if($type==4){$dealer=0; $this->session->set_userdata('dealer',$dealer);}
				if($type==3){$type=4; $dealer=1; $this->session->set_userdata('dealer',$dealer);}
				
			}
			else 
			{
				if ($this->session->userdata('type') == 0)
				{
					$type = 0;
				} 
				else
				{
					$type = 1;
				}
			}
			$data['type'] = $type;
			$name='';
			if ($this->session->userdata('name')){
				$name=$this->session->userdata('name');	
			}
			$email=$name;
			/*if ($this->session->userdata('email')){
				$name=$this->session->userdata('email');	
			}*/
			$data['users']=array();
			
			if($type == 6){
				$this->load->model('Competition_entry_model');
				$keyword = $this->session->userdata('name') ? $this->session->userdata('name') : '';
				$data['competition_entries'] = $this->Competition_entry_model->search($keyword);
				
			}elseif($type == 5){
				//echo 123;
				$this->load->model('Subscribe_model');
			    $subs = $this->Subscribe_model->all($name);
				//print_r($subs);
				$data['subscribers'] = $subs;
			}
			else
			{
				$data['subscribers'] ='';
			  if(isset($name)&&!empty($name))
			  {
				$data['users'] = $this->User_model->recognize_keyword($name,$type,$email);				
			  }
			  else
			  {
				$data['users'] = $this->User_model->get($type);	
			  }
			  //echo $this->db->last_query();
			}
			
			
			//$this->session->set_userdata('type',$type);
			//$this->session->unset_userdata('name');
			//$this->session->unset_userdata('type');
			
			$this->load->view('admin/customer/list',$data);
						
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	
		
		
	}

	function updatetrader() {
		if (!isset($_POST['id'])) { redirect('admin/customer/list_all'); }
		$id = $_POST['id'];
		$user = $this->User_model->id($id);
		
		$email = $this->input->post('email',true);
		$username = $email;
		$storename = $this->input->post('storename',true);
		$tradename = $this->input->post('tradename',true);
		$firstname = $this->input->post('firstname',true);
		$lastname = $this->input->post('lastname',true);
		
		
		$phone= $_POST['phone'];
		//$mobile = $_POST['mobile'];
		$address = $_POST['address'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		
		$postcode = $_POST['postcode'];
		
		$data = array(
			'email' => $email,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'storename' => $storename,
			'tradename' => $tradename,
			'phone' => $phone,
			'address' => $address,
			'address2' => $address2,
			'city' => $city,
			'state' => $state,
			'postcode' => $postcode,
			'phone' => $phone,
			//'mobile' => $mobile,
			'modified' => date('Y-m-d H:i:s')
		);
	}
		
	function update_retailer() {
		if (!isset($_POST['id'])) { redirect('admin/customer/list_all'); }
		$id = $_POST['id'];
		$user = $this->User_model->id($id);
		
		$email = $this->input->post('email',true);
		$username = $email;
		$firstname = $this->input->post('firstname',true);
		$lastname = $this->input->post('lastname',true);
		$dob = $this->input->post('dob',true);
		$title = $this->input->post('title',true);
		
		$phone= $_POST['phone'];
		$mobile = $_POST['mobile'];
		
		$address = $_POST['address'];
		$address2 = $_POST['address2'];
		$suburb = $_POST['suburb'];
		$state = $_POST['state'];
		$country = $_POST['country'];						
		$postcode = $_POST['postcode'];
		$membership_status = $_POST['membership_status'];
		$lightspeed_id = $_POST['lightspeed_id'];
		/*
		$shipping_firstname = $_POST['shipping_firstname'];
		$shipping_lastname = $_POST['shipping_lastname'];
		$shipping_same = $_POST['shipping_same'];
		
		$shipping_address = $_POST['shipping_address'];
		$shipping_address2 = $_POST['shipping_address2'];
		$shipping_suburb = $_POST['shipping_suburb'];
		$shipping_state = $_POST['shipping_state'];
		$shipping_country = $_POST['shipping_country'];						
		$shipping_postcode = $_POST['shipping_postcode'];
		*/
		$data = array(
			'email' => $email,
			'title' => $title,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'birthday' => date('Y-m-d',strtotime($dob)),
			'phone' => $phone,
			'mobile' => $mobile,
			'address' => $address,
			'address2' => $address2,
			'suburb' => $suburb,
			'country' => $country,
			'state' => $state,
			'postcode' => $postcode,
			'membership_status' => $membership_status,
			'lightspeed_id' => $lightspeed_id,
			/*
			'shipping_firstname' => $shipping_firstname,
			'shipping_lastname' => $shipping_lastname,
			'shipping_same' => $shipping_same,
			'shipping_address' => $shipping_address,
			'shipping_address2' => $shipping_address2,
			'shipping_suburb' => $shipping_suburb,
			'shipping_country' => $shipping_country,
			'shipping_state' => $shipping_state,
			'shipping_postcode' => $shipping_postcode,
			*/
			'modified' => date('Y-m-d H:i:s')
		);
		
		if ($_POST['password'] != "") {
			$this->User_model->update($id,array('password' => md5($_POST['password'])));
		}
		if ($this->Customer_model->update($user['customer_id'],$data)) {
			$this->session->set_flashdata('update',true);
		}
		redirect('admin/customer/list_all/edit/'.$id);
	}

	function update_trader() {
		if (!isset($_POST['id'])) { redirect('admin/customer/list_all'); }
		$id = $_POST['id'];
		$user = $this->User_model->id($id);
		
		$email = $this->input->post('email',true);
		$username = $email;
		$firstname = $this->input->post('firstname',true);
		$lastname = $this->input->post('lastname',true);
		
		$title= $_POST['title'];
		$tradename= $_POST['tradename'];
		$trading= $_POST['trading'];
		$title= $_POST['title'];
		$phone= $_POST['phone'];
		$fax= $_POST['fax'];
		$mobile = $_POST['mobile'];
		$address = $_POST['address'];
		$address2 = $_POST['address2'];
		$suburb = $_POST['suburb'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$postcode = $_POST['postcode'];
		
		$data = array(
			'email' => $email,
			'title' => $title,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'tradename' => $tradename,
			'trading' => $trading,
			'phone' => $phone,
			'fax' => $fax,
			'mobile' => $mobile,
			'address' => $address,
			'address2' => $address2,
			'suburb' => $suburb,
			'country' => $country,
			'state' => $state,
			'postcode' => $postcode,
			'modified' => date('Y-m-d H:i:s')
		);
		
		if ($_POST['password'] != "") {
			$this->User_model->update($id,array('password' => md5($_POST['password'])));
		}
		if ($this->Customer_model->update($user['customer_id'],$data)) {
			$this->session->set_flashdata('update',true);
		}
		redirect('admin/customer/list_all/edit_trader/'.$id);
	}

	function approvetrader() {
		//echo $_POST['send'];
		//exit;
		$id = $_POST['id'];
		$this->User_model->update($id,array('activated' => 1));
		
		if ($_POST['send'] == '1') {
			$user = $this->User_model->id($id);
			$customer = $this->Customer_model->identify($user['customer_id']);
			$subject = 'Customer Application Approval @ Spencer&Rutherford';
			$message = sprintf("
<p>Hi %s</p>
<p>Thank you for your recent request to become a Spencer & Rutherford stockist, your application has been successful. You are now able to login to the Spencer & Rutherford trade website, www.srtrade.com.au, using the following details:</p>
<p>
Username: %s<br />
Password: this will be the password you selected when you signed up via the registration form.<br/><br>
If you have forgotten your password please click 'Forgot Password' in the trade section of our website or follow this link.
</p>

<p>Should you have any queries please don't hesitate to <a href='http://www.odessa.net.au/cart_v1/store/page/38'>contact us</a>.</p>


<p>Warm Regards,</p>


Spencer & Rutherford Store

			",$customer['firstname'].' '.$customer['lastname'],$user['username']);
			/*
			//load email content
			$data['content'] = $message;
			$message = $this->load->view('email_template',$data, TRUE);
			*/
			
			//echo $message;
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from('noreply@spencerandrutherford.com','Spencer&Rutherford');
			$this->email->to($customer['email']);
			$this->email->bcc('peteryo11@gmail.com');
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			
			//echo $customer['email'];

			
		}
	}
		
	function pendingtrader() {
		$id = $_POST['id'];
		$data['activated'] = 0;
		$data['banned'] = 1;
		$this->User_model->update($id,$data);
		
		
		
		$user = $this->User_model->id($id);
		$customer = $this->Customer_model->identify($user['customer_id']);
		$subject = 'Customer Application Decline @ Spencer&Rutherford';
		$message = sprintf("
<p>Hi %s</p>
<br/><br/>
<p>
Thank you for your recent request to become a Spencer & Rutherford stockist. <br/><br/>

Unfortunately your application has not been successful on this occasion. We thank you for your interest in our brand however we currently already have representation in your area.<br/><br/> 

You may consider re-applying for a trade account at a later date, in the meantime we thank you for your interest. Please contact our Sales Manager by emailing <a href='mailto:sales@spencerandrutherford.com'>sales@spencerandrutherford.com</a> or calling +61 3 9536 8777 for further information.<br/><br/> 

Warm Regards,<br/><br/>

Spencer & Rutherford

</p>

		",$customer['firstname'].' '.$customer['lastname']);
		
		//load email content
		//$data['content'] = $message;
		//$message = $this->load->view('email_template',$data, TRUE);
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from('noreply@snr.com.au','Spencer & Rutherford Store');		
		$this->email->to($customer['email']);
		$this->email->bcc('peteryo11@gmail.com');
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
			
		//$user = $this->User_model->id($id);
		//$this->User_model->delete($id);
		//$this->Customer_model->delete($user['customer_id']);
		//$this->Order_model->delete($user['customer_id']);
		
		redirect('admin/customer/list_all');
	}
	function deletecustomer_old($id='') 
	{
		$user = $this->User_model->id($id);
		$customer = $this->Customer_model->identify($user['customer_id']);
		$subject = 'Customer Application Decline @ Case Construction Online Merchandise Store';
		$message = sprintf("
<p>Thank you %s</p>
<p>Unfortunately, at this moment we are unable to activate you as a Customer.</p>
<p>
Sorry for any inconvenience this might cause you.  If you would like to discuss the matter please feel free to contact us
</p>

<p>Warm Regards,</p>


Case Construction Online Merchandise Store

		",$customer['firstname']);
		
		//load email content
		//$data['content'] = $message;
		//$message = $this->load->view('email_template',$data, TRUE);
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from('noreply@onlinemerchandise.com.au','Case Construction Online Merchandise Store');		
		$this->email->to($customer['email']);
		
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
			
		$user = $this->User_model->id($id);
		$this->User_model->delete($id);
		$this->Customer_model->delete($user['customer_id']);
		$this->Order_model->delete($user['customer_id']);
		
		redirect('admin/customer/list_all');
	}
	
	function deletecustomer($id='') 
	{
		$user = $this->User_model->id($id);
		$customer = $this->Customer_model->identify($user['customer_id']);
		#check order
		$cust_order = $this->Customer_model->identify_order($user['customer_id']);
		
		if(count($cust_order)>0)
		{
			#update cust
			$this->User_model->delete($id);
			$this->Customer_model->update($user['customer_id'],array('deleted' =>1));
		}
		else
		{
			$this->User_model->delete($id);
			$this->Customer_model->delete($user['customer_id']);
		}
		
		
		
		
		//$this->Order_model->delete($user['customer_id']);
		
		//redirect('admin/customer/list_all');
	}
	
	function deletesubscribe($id) {
		$this->load->model('Subscribe_model');
		$this->Subscribe_model->delete($id);
		redirect('admin/customer/list_all');
	}
	
	function export_cust_for_MYOB()
	{
		// $csvdir = getcwd();
		// //$csvdir = $csvdir.'/csv/';
		// $csvname = 'customer_MYOB_'.date('d-m-Y');
		// $csvname = $csvname.'.csv';
		// header('Content-type: application/csv; charset=utf-8;');
        // header("Content-Disposition: attachment; filename=$csvname");
		// $fp = fopen("php://output", 'w');
		
		$path = "./exportcsv/customer";
		$dir = $path;
		//$csvdir = '/home/odessa/public_html/cart_v1/exportcsv/stock/';
		$csvname = 'customer_MYOB_'.date('Ymd_His');
		$csvname = $csvname.'.csv';
		//header('Content-type: application/csv; charset=utf-8;');
        //header("Content-Disposition: attachment; filename=$csvname");
		//$fp = fopen("php://output", 'w');
		$fp = fopen($dir.'/'.$csvname,'w+');
		
		$headings = array('customer_id','barcode','grade','notes','comments','status','costum1','costum2','inactive','date_modified','surname','given_name','position','company','salutation','account','opened_id','openedby','owner_id','account_manager','limit','days','fromEOM','addr1','addr2','addr3','suburb','state','postcode','country','phone','fax','mobile','email','abn','overseas','external','date_created','is_barcode_printed','document_delivery_type','group_email_exclusion_id');
		fputcsv($fp,$headings);
		
		$cust = $this->Customer_model->all_byid();
		
		foreach($cust as $c)
		{
			$lines = array();
			$state = $this->System_model->get_state_code($c['state']);
			$lines = array($c['id'],0,0,0,0,0,0,0,0,date('d/m/Y H:i',strtotime($c['modified'])),$c['lastname'],$c['firstname'],0,$c['tradename'],$c['title'],0,0,0,0,0,0,0,0,$c['address'],$c['address2'],0,$c['suburb'],$state,$c['postcode'],$c['country'],$c['phone'],0,$c['mobile'],$c['email'],$c['abn'],0,0,date('d/m/Y H:i',strtotime($c['joined'])),0,0,0);
			fputcsv($fp,$lines);
		}
		
		fclose($fp);
	}

	function exportcustomer() {
		//error_reporting(E_ALL);
		if($this->session->userdata('type'))
		{
			$type = $this->session->userdata('type');
		}
		else
		{
			$type = 0;
		}
		
		if($this->session->userdata('name'))
		{
			$name = $this->session->userdata('name');
		}
		else
		{
			$name = '';
		}
		
		//$subscribers = $this->Subscribe_model->all();
		//print_r($subscribers);
		
		//echo $type;
		//exit;
		$csvdir = getcwd();
		//$csvdir = $csvdir.'/csv/';
		$csvname = 'customer_'.date('d-m-Y');
		$csvname = $csvname.'.csv';
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');
		
		
		if ($this->session->userdata('type')) 
		{ 
			$type = $this->session->userdata('type'); 
		}
		else
		{
			$type = 1;
		}
		// if($name != '')
		// {
			// $this->User_model->recognize_keyword($name,$type,$name);		
		// }
		// else
		//{
			$users = $this->User_model->get_all($type);
		//}
		
		
		if($type==1)
		{
			$headings = array('Username','Title','First Name','Last Name','Email','Date of Birth','Address 1','Address 2','Suburb','State','Country','Postcode','Heard Us');
		fputcsv($fp,$headings);
			foreach ($users as $user) 
			{
				$customer = $this->Customer_model->identify($user['customer_id']);
				$state = $this->System_model->get_state($customer['state']);
				$heard_us = '';
				if($customer['heard_us'] == 'Professional Referral')
				{
					$heard_us = $customer['heard_us'].' ('.$customer['personal_referral'].')';
				}
				else
				{
					$heard_us = $customer['heard_us'];
				}
				fputcsv($fp,array($user['username'],$customer['title'],$customer['firstname'],$customer['lastname'],$customer['email'],$customer['date_dob'].'-'.$customer['month_dob'],$customer['address'],$customer['address2'],$customer['suburb'],$state,$customer['country'],$customer['postcode'],$heard_us));
			}
		}
		elseif($type==2)
		{
			$headings = array('Username','Title','First Name','Last Name','Email','Trader Name','Trading As','Retail Address 1','Retail Address 2','Telephone','Fax','Mobile','Suburb','State','Country','Postcode');
		fputcsv($fp,$headings);
			foreach ($users as $user) 
			{
				$customer = $this->Customer_model->identify($user['customer_id']);
				$state = $this->System_model->get_state($customer['state']);
				fputcsv($fp,array($user['username'],$customer['title'],$customer['firstname'],$customer['lastname'],$customer['email'],$customer['tradename'],$customer['trading'],$customer['address'],$customer['address2'],$customer['phone'],$customer['fax'],$customer['mobile'],$customer['suburb'],$state,$customer['country'],$customer['postcode']));
			}
		}
		
		else
		{
			$this->load->model('Subscribe_model');
			$subscribers = $this->Subscribe_model->all($name);
			$headings = array('Email','Date time');
			fputcsv($fp,$headings);
			foreach ($subscribers as $s) 
			{
				
				fputcsv($fp,array($s['email'],$s['date']));
			}
		}
		
        fclose($fp);
		//redirect(base_url().'csv/'.$csvname);
	}

	function add_comment()
	{
		$admin_id = $this->session->userdata('kiotiahraloggedin');
		$comment = $_POST['comment'];
		$cust_id = $_POST['cust_id'];
		
		$data['admin_id'] = $admin_id;
		$data['customer_id'] = $cust_id;
		$data['comment'] = $comment;
		
		$this->Customer_model->add_comment($data);
		
		$comments = $this->Customer_model->all_comment($cust_id);
		$text = '';
		foreach($comments as $cm)
		{
			
			$user = $this->User_model->id($cm['admin_id']);
			$text .='
			<tr>
				<td>'.date('d-m-Y',strtotime($cm['created'])).'</td>
				<td>'.$cm['comment'].'</td>
				<td>'.$user['username'].'</td>
			</tr>
			';
		}
		
		echo $text;
	}


	
	
}
?>