<?php

# Controller: Store

class Store_admin extends Controller {

	function __construct() {
		parent::Controller();
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
	function transfer_cart($order_id)
	{
		
		
		$order = $this->Order_model->identify($order_id);
		
		$carts =  $this->Cart_model->all($order['session_id']);
		$ct_id=0;
		foreach($carts as $ct)
		{
			$session_id = $this->session->userdata('session_id');
			$customer_id = 1;
			$product_id = $ct['product_id'];
			$qty = $ct['quantity'];
			$price = $ct['price'];
			$data=array(
				'session_id' => $session_id,
				'customer_id' => $customer_id,
				'product_id' => $product_id,
				'quantity' => $qty,
				'price' =>$price,
				'admin' => $order['customer_id'],
				'order_id' => $order_id
			);
			$this->Cart_model->add_cart_admin($data);
			
		}				
		
		$this->session->set_userdata('userloggedin',1);
		$this->session->set_userdata('orderid',$order_id);
		$this->session->set_userdata('adminid',$order['customer_id']);
		redirect('store_admin/cart');
	}
	
	function cart() {
		//$user = $this->session->userdata('userloggedin');
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
		
		$data['cart'] = $this->Cart_model->all($this->session->userdata('session_id'));
		//$data['cart'] = $this->Cart_model->all_save($user['customer_id']);
		//$data['cart'] = $this->Cart_model->all('4952959018f925261a4d7838722b0eb1');
		$data['page_title'] = "Your Shopping Basket";
		$this->load->view('common/header',$data);
		
		$this->load->view('store/cart');
		$this->load->view('common/footer');
	}
	
	function account_page()
	{
		if(! $this->session->userdata('userloggedin'))
		{
			redirect('store/signin');
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
		
		$data['cart'] = $this->Cart_model->all($this->session->userdata('session_id'));
		$cust_id='';
		foreach($data['cart'] as $ct)
		{
			
			if($ct['admin']!=1){$cust_id=$ct['admin'];break;}
		}
		//$data['cart'] = $this->Cart_model->all_save($user['customer_id']);
		//$data['cart'] = $this->Cart_model->all('4952959018f925261a4d7838722b0eb1');
		$data['page_title'] = "Your Account Detail";
		
		$user = $this->session->userdata('userloggedin');
		//$cust = $this->Customer_model->identify($user['customer_id']);
		$cust = $this->Customer_model->identify($cust_id);
		$data['cust'] = $cust;
		$data['states'] = $this->System_model->get_states();
		$data['state'] = $this->System_model->get_state($cust['state']);
		$data['countries_all'] = $this->System_model->get_shipping_countries();
		
		$this->load->view('common/header',$data);
		
		$this->load->view('store/account_page');
		$this->load->view('common/footer');
	}
	
	function checkout_order()
	{
		$shipping_method = $_POST['shipping_method'];
		$shipping_cost = 0;
		
		# Calculate sub total
		$session_id = $this->session->userdata('session_id');
		$user = $this->session->userdata('userloggedin');
		$customer_id = 1;
		$customer = $this->Customer_model->identify(1);
		$cart = $this->Cart_model->all($session_id);
		if($cart == NULL)
		{
			redirect('store');
		}
		$subtotal = 0;
		$valid = true;
		$total_weight=0;
		$total_volume=0;
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			$total_weight=$total_weight+($product['weight']*$item['quantity']);
			$total_volume=$total_volume+($product['volume']*$item['quantity']);
			$name = $product['title'];
			if($product['multiplesize'] == 0)
			{
			  if($product['stock'] < $item['quantity'])
			  {
				  $valid = false;
				  if($product['stock'] <= 0)
				  {
					  $keep = false;
				  }
				  else if($product['stock'] > 0)
				  {
					  $keep = true;
				  }
				  if($keep)
				  {
					  $newdata = array(
					                  'quantity' => $product['stock']
									  );
					  $this->Cart_model->update($item['id'],$newdata);
				  }
				  else
				  {
					  $this->Cart_model->delete($item['id']);
				  }
				  $message = "Sorry the item $name has low stock level since it has been sold recently. Your shopping cart has been updated automatically to reflect a maximum stock purchased. Please contact sales@onlinemerchandise.com.au for any questions";
				  $this->session->set_flashdata('error_product_quantity',$message);
			  }
			}
			else if($product['multiplesize'] == 1)
			{
				$multiple_stock = json_decode($product['size'],true);
				$attr = json_decode($item['attributes'],true);
				$size = $attr['Size'];
				if($multiple_stock[$attr['Size']] < $item['quantity'])
				{
					 $valid = false;
				  if($multiple_stock[$attr['Size']] <= 0)
				  {
					  $keep = false;
				  }
				  else if($multiple_stock[$attr['Size']] > 0)
				  {
					  $keep = true;
				  }
				  if($keep)
				  {
					  $newdata = array(
					                  'quantity' => $multiple_stock[$attr['Size']]
									  );
					  $this->Cart_model->update($item['id'],$newdata);
				  }
				  else
				  {
					  $this->Cart_model->delete($item['id']);
				  }
					 $message = "Sorry the item $name has low stock level in the size $size since it has been sold recently. Your shopping cart has been updated automatically to reflect a maximum stock purchased. Please contact sales@onlinemerchandise.com.au for any questions";
				  $this->session->set_flashdata('error_product_quantity',$message);
				}
			}
			$subtotal += $item['quantity'] * $item['price'];
		}
		if(!$valid)
		{
			redirect('store/cart');
		}
		$vtotal=0;
		if($customer['membership_status']==2){$vtotal=$subtotal*(5/100);}
		if($customer['membership_status']==3){$vtotal=$subtotal*(10/100);}
		# Tax first
		// australia country id is 13
		$tax_ob = $this->System_model->get_tax_country(13);
		$tax = 0;
		if ($tax_ob) {
			if ($tax_ob['included']) {
				$tax = $subtotal - $subtotal / (1 + $tax_ob['value']/100);
				$subtotal = $subtotal - $tax;
			} else {
				$tax = $subtotal * ($tax_ob['value']/100);
			}
		}
		$subtotal2 = $subtotal + $tax;
		
		# Discount second
		$discount = 0;
		if($_POST['coupon-code'] != "")
		 {
			$coupon = $this->System_model->check_coupon_code($_POST['coupon-code']);
			if($coupon)
			{
			 if($subtotal >= $coupon['condition'] && $subtotal > 0) 
			 {
				if($coupon['type'] == 1) { // Percentage
					//$discount = $subtotal2 * $coupon['value'] / 100;					
					$discount = $subtotal * $coupon['value'] / 100;					
				} else {
					$discount = $coupon['value'];					
				}
				//$subtotal2 = $subtotal2 - $discount;
				$subtotal2 = $subtotal2 - $discount;
				 $data = array(
			         'actual_used_times' => $coupon['actual_used_times'] + 1
					 );
					 $this->System_model->update_coupon($coupon['id'],$data);
			 }
			
				
			}
		}
		
		
		
		# Shipping last
		
		/*$method2 = $this->System_model->get_shipping_v2($shipping_method);
		$first_cost=$method2['price_value'];
		$cost_flat=$method2['price_value'];
		$shipping_cost = $method2['price_value'];
		*/
		//$shipping_method=2;
		$method = $this->System_model->get_shipping($shipping_method);
		$shipping_weight=0;
		$cost_flat=0;
		$cost_weight=0;
		$shipping_weight_method=0;
		if($method['price_type']==1){
			$cost_weight=$method['price_value'];
			$weight_cost=$cost_weight*$total_weight;
			$shipping_weight=$weight_cost;
			$shipping_weight_method=$shipping_method;
			$shipping_cost = $weight_cost;
		}				
		else if($method['price_type']==2)
		{
			$cost_weight=$method['price_value'];
			$weight_cost=$cost_weight*$total_volume;
			$shipping_weight=$weight_cost;
			$shipping_weight_method=$shipping_method;
			$shipping_cost = $weight_cost;
		}
		if($method['price_type']==3)
		{
			$cost_weight=$method['price_value'];
			$weight_cost=$cost_weight*$total_volume;
			$cost = $weight_cost;
			
			$shipping_weight=$weight_cost;
			$shipping_weight_method=$shipping_method;
			$shipping_cost = $weight_cost;
			
		}
				
		$conditions = $this->System_model->get_shipping_conditions($method['id']);
		foreach($conditions as $condition) {
			if ($subtotal >= $condition['condition']) {
				$shipping_cost = $condition['price'];
			}
		}
		
		$total = $subtotal2 + $shipping_cost - $vtotal;
		//$shipping_cost=$shipping_cost+$weight_cost;
		
		$this->session->set_userdata('ssubtotal',$subtotal);
		$this->session->set_userdata('scoupon_code',$_POST['coupon-code']);
		$this->session->set_userdata('smember_discount',$vtotal);
		$this->session->set_userdata('sdiscount',$discount);
		$this->session->set_userdata('stax',$tax);
		$this->session->set_userdata('sshipping_cost',$shipping_cost);
		$this->session->set_userdata('sshipping_method',$shipping_method);
		$this->session->set_userdata('sshipping_weight',$shipping_weight);
		$this->session->set_userdata('sshipping_weight_method',$shipping_weight_method);
		$this->session->set_userdata('sweight',$total_weight);
		$this->session->set_userdata('scost_weight',$cost_weight);
		$this->session->set_userdata('scost_flat',$cost_flat);
		$this->session->set_userdata('stotal',$total);
				
		redirect('store_admin/save_payment');
				
	}
	function save_payment()
	{
		$firstname = $this->session->userdata('sfirstname');
		$lastname = $this->session->userdata('Slastname');
		$address = $this->session->userdata('saddress');
		$address2 = $this->session->userdata('saddress2');
		$city = $this->session->userdata('ssuburb');
		$state = $this->session->userdata('sstate');
		$country = $this->session->userdata('scountry');
		$postcode = $this->session->userdata('spostcode');
		$msg = $this->input->post('pmsg',true);
		
		
		
		
		$subtotal = $this->session->userdata('ssubtotal');
		$coupon_code = $this->session->userdata('scoupon_code');
		$discount = $this->session->userdata('sdiscount');
		$tax = $this->session->userdata('stax');
		$shipping_cost = $this->session->userdata('sshipping_cost');
		$shipping_method = $this->session->userdata('sshipping_method');
		$shipping_weight = $this->session->userdata('sshipping_weight');
		$shipping_weight_method = $this->session->userdata('sshipping_weight_method');
		$weight = $this->session->userdata('sweight');
		$cost_weight = $this->session->userdata('scost_weight');
		$cost_flat = $this->session->userdata('scost_flat');
		$total = $this->session->userdata('stotal');
		
		
		
		
		
		
		
		$user = $this->session->userdata('userloggedin');
		$cust = $this->Customer_model->identify(1);
		$data['cart'] = $this->Cart_model->all($this->session->userdata('session_id'));
		$cust_id='';
		foreach($data['cart'] as $ct)
		{			
			if($ct['admin']!=1){$admin_id=$ct['admin'];$adminorder_id=$ct['order_id'];break;}
		}
		$cstate = $this->System_model->get_state($cust['state']);
		
		$session_id = $this->session->userdata('session_id');
		
		$data = array(
				'customer_id' => $admin_id,
				'session_id' => $session_id,
				'order_time' => date('Y-m-d H:i:s'),
				'subtotal' => $subtotal,
				'coupon_code' => $coupon_code,
				'discount' => $discount,
				'tax' => $tax,
				'shipping_cost' => $shipping_cost,
				'shipping_method' => $shipping_method,
				'shipping_weight' => $shipping_weight,
				'shipping_weight_method' => $shipping_weight_method,
				'weight' => $weight,
				'cost_weight' => $cost_weight,
				'cost_flat' => $cost_flat,
				'total' => $total,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'address' => $address,
				'address2' => $address2,
				'city' => $city,
				'state' => $state,
				'country' => $country,
				'postcode' => $postcode,
				'email' => $cust['email'],
				'admin' => $adminorder_id,
				'admin_id' => $cust['id']
			);
			
		//print_r($data);
		$order_id = $this->Order_model->add($data);
		
		//$this->send_order_confirmation($order_id);
		//$this->send_order_notification($order_id);
		$this->Order_model->update($order_id,array('status' => 'successful','order_status'=>'completed','msg' => 'successfull'));
		$this->Order_model->update($adminorder_id,array('status' => 'successful','order_status'=>'cancelled','msg' => 'successfull'));
		$user = $this->session->userdata('userloggedin');
		
		$this->session->destroy();
		// update stock
		$this->updatestock($order_id);
		//redirect('store/pathway/'.$user['id'].'/'.$order_id);
		redirect(base_url().'store/conf_success/'.$order_id);
							
	}
	function updatestock($order_id){
		$order = $this->Order_model->identify($order_id);
		$cart = $this->Cart_model->all($order['session_id']);	
		
		$message="<p>=====================================================</p>";
		$message.='<div style="width:490px"><div style="float:left; width:350px"><b>Product Name</b></div><div style="float:right; width: 100px"><b>Stock</b></div></div>';
		$message.="<p>=====================================================<br/></p>";
		$send_check=false;
		
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
		  if($product['multiplesize'] == 0)
	      {
			$amount_in_stock=$product['stock'];
			$still_in_stock=$amount_in_stock - $item['quantity'];
			if($still_in_stock<=1)
			{
				$send_check=true;
				//$this->send_low_stock_notification($item['product_id'], $product['title'], $still_in_stock);
				$message.='<div style="width:500px"><div style="float:left; width:360px">'.$product["title"].'</div><div style="float:right; width: 100px">'.$still_in_stock.'</div></div>';
				
			}
			$temp=array(
					'stock' => $still_in_stock
			        );
			/*
			if($still_in_stock<=0){
				$temp=array(
					'stock' => $still_in_stock
				);
			}
			*/
			$this->Product_model->update($item['product_id'],$temp);
		  }
		  else
		  {
			  // applying stock update for multiple size rather than the product stock in general
			  $multiple_stock = json_decode($product['size'],true);
			   $var = json_decode($item['attributes'],true);
			   $new = $multiple_stock[$var['Size']] -  $item['quantity'];
			    $multiple_stock[$var['Size']] = $new;
				$multiple_stock = json_encode($multiple_stock,JSON_FORCE_OBJECT);
				$temp=array(
					'size' => $multiple_stock
			        );
			   $this->Product_model->update($item['product_id'],$temp);
		  }
		}
		$message.="<p>=====================================================</p>";
		if($send_check)
		{
			//$this->send_low_stock_notification($message);
		}
	}
	function login_admin($order_id)
	{
		
		$this->session->set_userdata('kiotiahraloggedin',true);
		redirect(base_url().'/admin/order/list_all/view/'.$order_id);
	}
}