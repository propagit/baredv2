<?php

# Controller: Cart

class Cart extends Controller {

	function __construct() {
		parent::Controller();
		$cur_user = $this->session->userdata('userloggedin');													
		if($cur_user['level'] == 2)
		{
			redirect(TRADE_SITE);
		}
		
		$this->load->model('Content_model');   
		$this->load->model('Product_model');   
		$this->load->model('System_model');
		$this->load->model('Customer_model');
		$this->load->model('User_model');   
		$this->load->model('Cart_model');   
		$this->load->model('Category_model');
		$this->load->model('Order_model');
		$this->load->model('Subscribe_model');
		$this->load->model('Menu_model');
		$this->load->model('Lightspeed_model');
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
		
	
	function check_postcode($postcode)
	{
		$checks = $this->System_model->get_suburbs_postcode($postcode);
		if(count($checks)>0) {echo 1;}
		else
		{
			echo 2;
		}
	
	}
	function checkout2()
	{
		
		$this->check_session();
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = 'AU$';
			$data['cur_val'] = 1;
		}
		else 
		{
			
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		
		
		$data['countries_all'] = $this->System_model->get_shipping_countries();
		$data['states'] = $this->System_model->get_states();
		$data['suburbs'] = $this->System_model->get_suburbs_postcode(1);
		$data['page_title'] = "Trade Customer";
		
		
		$cart = $this->Cart_model->all($this->session->userdata('session_id'));
		$tax = $this->System_model->get_tax(1);
		if(! $this->session->userdata('userloggedin'))
		{
			redirect('store/signin');
		}
		$user = $this->session->userdata('userloggedin');
			
		if($user['level']!=4)		
		if ($tax) { 
			if ($tax['included']) {
				$cart2 = array();
				foreach($cart as $item) {
					$price = money_format('%i',$item['price'] * 10/11);
					
					$item['price'] = $price;
					
					$cart2[] = $item;
				} 
				$cart = $cart2;
			}			
		}
		$data['cart'] = $cart;
		$data['page_title'] = "Checkout";
		$data['states'] = $this->System_model->get_states();
		$data['countries'] = $this->System_model->get_shipping_countries();
		$data['customer'] = $this->Customer_model->identify($user['customer_id']);
		/*
		if ($user) 
		{
			$data['countries'] = $this->System_model->get_shipping_countries();
			$data['customer'] = $this->Customer_model->identify($user['customer_id']);
			$this->load->view('cart/checkout',$data);						
		} 
		else 
		{
			redirect('cart/trade');
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();			
		}
		*/
		$this->load->view('common/header',$data);
		$this->load->view('store/new_checkout',$data);
		$this->load->view('common/footer');
		
		
		
		
		
		
		
	}
	function checkout_order()
	{
		$shipping_method = $_POST['shipping_method'] ? $_POST['shipping_method'] : 0;
		$shipping_cost = 0;
		
		# Calculate sub total
		$session_id = $this->session->userdata('session_id');
		$user = $this->session->userdata('userloggedin');
		$customer_id = $user['customer_id'];
		$customer = $this->Customer_model->identify($customer_id);
		$cart = $this->Cart_model->all($session_id);
		if($cart == NULL)
		{
			redirect('store');
		}
		$subtotal = 0;
		$valid = true;
		$total_weight=0;
		$total_volume=0;
		$prods=array();
		$cats=array();
		$gift_card=0;
		$only_gift_voucher = true;

		foreach($cart as $item) 
		{
			if($item['product_id']==11){$gift_card=$gift_card+$item['price'];}
			else{
				# stupid way to code really - this is band aid solution to ignore shipping if cart only has gift voucher.
				$only_gift_voucher = false;
			
				$product = $this->Product_model->identify($item['product_id']);
				$total_weight=$total_weight+($product['weight']*$item['quantity']);
				$total_volume=$total_volume+($product['volume']*$item['quantity']);
				$prods[]=$item['product_id'];
				$categories=$this->Category_model->identify_category_all($item['product_id']);
				foreach($categories as $ctp)
				{
					if(!in_array($ctp['category_id'],$cats))
					{
						$cats[]=$ctp['category_id'];
					}
				}
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
					  $message = "Sorry the item $name has low stock level since it has been sold recently. Your shopping cart has been updated automatically to reflect a maximum stock purchased. Please contact sales@bared.com.au for any questions";
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
						 $message = "Sorry the item $name has low stock level in the size $size since it has been sold recently. Your shopping cart has been updated automatically to reflect a maximum stock purchased. Please contact sales@bared.com.au for any questions";
					  $this->session->set_flashdata('error_product_quantity',$message);
					}
				}
				$subtotal += $item['quantity'] * $item['price'];
			}
		}
		if(!$valid)
		{
			redirect('cart/list_cart');
		}
		
		//$user = $this->session->userdata('userloggedin');
		//$customer = $this->Customer_model->identify($user['customer_id']); 
		$vtotal=0;
		//$vtotal=$subtotal;
		//if($customer['membership_status']==2){$vtotal=$subtotal*(5/100);}
		//if($customer['membership_status']==3){$vtotal=$subtotal*(10/100);}
		
		# Tax first
		// australia country id is 13
		
		$tax_ob = $this->System_model->get_tax_country(13);
		$tax = 0;
		if ($tax_ob) {
			if ($tax_ob['included']) {
				$tax = $subtotal - round($subtotal / (1 + $tax_ob['value']/100),2);
				$tax=round($tax, 2);
				$subtotal = $subtotal - $tax;
			} else {
				$tax = $subtotal * ($tax_ob['value']/100);
				$tax=round($tax, 2);
			}
		}
		$subtotal=round($subtotal, 2);
		$subtotal2 = $subtotal + $tax;
		
		# Discount second
		$discount = 0;
		if($_POST['coupon-code'] != "")
		 {
			$code=$_POST['coupon-code'];
			$ori_code=$code;
			$coupon = $this->System_model->check_coupon_code($_POST['coupon-code']);
			//if($coupon)
			$conds = $this->System_model->get_coupon_condition($coupon['id']);
			$pass=0;
			if($coupon && count($conds)==0)
			{
				 if($coupon['expirary']==1)
				 {		
					 if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){$pass=1;}
				 }
				 if($coupon['expirary']==2)
				 {		
					 //if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){}
					 if($this->System_model->check_coupon_period_cond($code,$coupon['from_date'],$coupon['to_date'],date('Y-m-d')))
					 {$pass=1;}
				 }
				 if($coupon['expirary']==3)
				 {		
					$pass=1;
					 //if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){}
					 
				 }
				 
				 
				 if($subtotal >= $coupon['condition'] && $subtotal > 0 && $pass==1) 
				 {
					if($coupon['type'] == 1) { // Percentage
						//$discount = $subtotal2 * $coupon['value'] / 100;					
						$discount = $subtotal2 * $coupon['value'] / 100;					
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
			
			else
			{
				
				$couponcond = $this->System_model->get_coupon_cond($code);		
				$cop = $this->System_model->get_coupon($couponcond['id_coupon']);
				if($couponcond && $cop['actived']==1){
					$total_price_disc=0;
					$true=0;
					$conds=$this->System_model->get_coupon_condition($couponcond['id_coupon']);	
					
					if(count($conds)==2)
					{
						foreach($conds as $cd)
						{
							if($cd['type']==3)
							{
								if($cd['cond_prod']=='in')
								{
									
									$temp=explode(',',$cd['products']);							
									$result =array_intersect($prods,$temp);	
									if(count($result)>0)
									{								
										$true=1;
										$count=$result;
										foreach($cart as $item) {											
											if(in_array($item['product_id'],$temp))
											{																															
												$total_price_disc += $item['price']*$item['quantity'];
											}
											
										}
									}
								}
								else
								if($cd['cond_prod']=='out')
								{
									
									$temp=explode(',',$cd['products']);							
									$result =array_diff($prods,$temp);	
									if(count($result)>0)
									{								
										$true=1;										
										$count=$result;
										foreach($cart as $item) {											
											if(!in_array($item['product_id'],$temp))
											{																															
												$total_price_disc += $item['price']*$item['quantity'];
											}
											
										}
									}
								}
							}
							else
							if($cd['type']==2)
							{
								if($cd['cond_cat']=='in')
								{
									$temp=explode(',',$cd['categories']);							
									#check if there are categories in $cats
									$result =array_intersect($cats,$temp);	
									if(count($result)>0)
									{								
										$true=1;
										$count=$result;
										
										foreach($cart as $item) {
											$skip=0;
											$prods[]=$item['product_id'];
											$categories=$this->Category_model->identify_category_all($item['product_id']);
											foreach($categories as $ctp)
											{
												if(in_array($ctp['category_id'],$temp)&&$skip==0)
												{
													$cats[]=$ctp['category_id'];
													$total_price_disc += $item['price']*$item['quantity'];
													$skip=1;
												}
											}
										}
									}
								}
								else
								if($cd['cond_cat']=='out')
								{
									$temp=array();
									$temp=explode(',',$cd['categories']);							
									$result =array_diff($cats,$temp);	# to know how many that 
									$ots=1;
									if(count($result)>0)
									{								
										$true=1;
										//$trues=$trues+1;
										$count=count($result);
										$tag=0;
										foreach($cart as $item) {
											
											$prods[]=$item['product_id'];
											$skip=0;
											$tag=0;
											$categories=$this->Category_model->identify_category_all($item['product_id']);
											foreach($categories as $ctp)
											{
												if(in_array($ctp['category_id'],$temp))
												{												
													$skip=1;$tag=1;
												}
											}
											if($tag==0){
												//$cats[]=$ctp['category_id'];
												$total_price_disc += ($item['price']*$item['quantity']);											
											}
											
										}
										
									}
								}
							}
							else
							if($cd['type']==1)
							{
								if($subtotal>=$cd['value'])
								{
									$true=1;							
								}
							}
							else
							
							
							if($cd['type']==4)
							{
								if(count($prods)>=$cd['value'])
								{
									$true=1;
								}
							}
							
						}
					}
					else
					{
						$trues=1;
						$nums=count($conds);
						if(count($conds)>2 )
						{
							foreach($conds as $cd)
							{
								if($cd['type']==3)
								{
									if($cd['cond_prod']=='in')
									{
										$temp=explode(',',$cd['products']);							
										$result =array_intersect($prods,$temp);	
										if(count($result)>0)
										{								
											$trues=$trues+1;
											foreach($cart as $item) {											
												if(in_array($item['product_id'],$temp))
												{																															
													$total_price_disc += $item['price']*$item['quantity'];
												}
												
											}
										}
									}
									else
									if($cd['cond_prod']=='out')
									{
										$temp=explode(',',$cd['products']);							
										$result =array_diff($prods,$temp);	
										if(count($result)>0)
										{								
											$trues=$trues+1;
											foreach($cart as $item) {											
												if(!in_array($item['product_id'],$temp))
												{																															
													$total_price_disc += $item['price']*$item['quantity'];
												}
												
											}
										}
									}
								}
								
								if($cd['type']==1)
								{
									if($subtotal>=$cd['value'])
									{
										//$true=1;							
										$trues=$trues+1;
									}
								}
								
								if($cd['type']==2)
								{
									if($cd['cond_cat']=='in')
									{
										$temp=explode(',',$cd['categories']);							
										$result =array_intersect($cats,$temp);	
										
										if(count($result)>0)
										{								
											//$true=1;
											$trues=$trues+1;
											$count=count($result);
											
											foreach($cart as $item) {
												
												$prods[]=$item['product_id'];
												$skip=0;
												$categories=$this->Category_model->identify_category_all($item['product_id']);
												foreach($categories as $ctp)
												{
													if(in_array($ctp['category_id'],$temp) && $skip==0)
													{
														$cats[]=$ctp['category_id'];
														$total_price_disc += $item['price']*$item['quantity'];
														$skip=1;
													}
												}
												
											}
											
										}
									}
									else
									if($cd['cond_cat']=='out')
									{
										$temp=array();
										$temp=explode(',',$cd['categories']);							
										$result =array_diff($cats,$temp);	# to know how many that 
										$ots=1;
										if(count($result)>0)
										{								
											//$true=1;
											$trues=$trues+1;
											$count=count($result);
											$tag=0;
											foreach($cart as $item) {
												
												$prods[]=$item['product_id'];
												$skip=0;
												$tag=0;
												$categories=$this->Category_model->identify_category_all($item['product_id']);
												foreach($categories as $ctp)
												{
													if(in_array($ctp['category_id'],$temp))
													{												
														$skip=1;$tag=1;
													}
												}
												if($tag==0){
													//$cats[]=$ctp['category_id'];
													$total_price_disc += ($item['price']*$item['quantity']);											
												}
												
											}
											
										}
									}
								}
								
								if($cd['type']==4)
								{
									if(count($prods)>=$cd['value'])
									{
										//$true=1;
										$trues=$trues+1;
									}
								}
			
								
							}
						}
						if($trues==$nums)
						{
							$true=1;
						}
					}
					if($true==1)
					{
						if($total_price_disc>0 || $ots==1)	{$subtotal3=$total_price_disc;}else{$subtotal3=$subtotal2;}
						//$subtotal3=$subtotal2;
						$coupon = $this->System_model->get_coupon($couponcond['id_coupon']);
						$code=$coupon['code'];
						if($coupon['expirary']==1)
						{
							
							if(count($this->Order_model->identify_promotioncode($ori_code,$customer_id))==0)
							{	
								if($coupon['type'] == 1) { // Percentage
									$discount = $subtotal3 * $coupon['value'] / 100;								
								} else {
									if($ots==1 && $total_price_disc > 0){
									$discount = $coupon['value'];
									}
									else if($ots==0){$discount = $coupon['value'];}
								}
								$subtotal2 = $subtotal2 - $discount;
								$data = array(
								 'actual_used_times' => $coupon['actual_used_times'] + 1
								 );
								 $this->System_model->update_coupon($couponcond['id_coupon'],$data);
								 
							}
						}
						else if($coupon['expirary']==3)
						{
							if($coupon['type'] == 1) { // Percentage
								$discount = $subtotal3 * $coupon['value'] / 100;								
							} else {
									if($ots==1 && $total_price_disc > 0){
										$discount = $coupon['value'];
									}
									else if($ots==0){$discount = $coupon['value'];}
							}
						    
							$subtotal2 = $subtotal2 - $discount;
						  $data = array(
							 'actual_used_times' => $coupon['actual_used_times'] + 1
							 );
							 $this->System_model->update_coupon($couponcond['id_coupon'],$data);
						}
						else if($coupon['expirary']==2)
						{
						
							if($this->System_model->check_coupon_period_cond($code,$coupon['from_date'],$coupon['to_date'],date('Y-m-d')))
							{
													  
								  if($coupon['type'] == 1) { // Percentage
										$discount = $subtotal3 * $coupon['value'] / 100;								
									} else {
										if($ots==1 && $total_price_disc > 0){
											$discount = $coupon['value'];
										}
										else if($ots==0){$discount = $coupon['value'];}
									}
								  $subtotal2 = $subtotal2 - $discount;
								  $data = array(
									 'actual_used_times' => $coupon['actual_used_times'] + 1
									 );
									 $this->System_model->update_coupon($couponcond['id_coupon'],$data);
								
								
							}
						}
					}
				}
			}
		}
		
		if($subtotal2<=0){$subtotal2=0;}
		
		# Shipping last
		
		/*$method2 = $this->System_model->get_shipping_v2($shipping_method);
		$first_cost=$method2['price_value'];
		$cost_flat=$method2['price_value'];
		$shipping_cost = $method2['price_value'];
		*/
		//$shipping_method=2;
		
		# check if this is store pick up and by pass shipping if it is
		$shipping_weight = 0;
		$cost_flat = 0;
		$cost_weight = 0;
		$shipping_weight_method = 0;
		$shipping_cost = 0;
		if(!$this->session->userdata('store_pickup')){
			# if cart has other items other than gift voucer
			if(!$only_gift_voucher){
			$method = $this->System_model->get_shipping($shipping_method);
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
				$weight_cost=$cost_weight;
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
			$shipping_cost = $shipping_cost+ $method['base_rate'];
			$shipping_cost=round($shipping_cost, 2);
			$conditions = $this->System_model->get_shipping_conditions($method['id']);
			foreach($conditions as $condition) {
				if ($subtotal >= $condition['condition']) {
					$shipping_cost = $condition['price'];
				}
			}
			} # end gift voucher check
		}
		
		$total = $subtotal2 + $shipping_cost + $gift_card;
		//$shipping_cost=$shipping_cost+$weight_cost;
		
		$user = $this->session->userdata('userloggedin');
		$cust = $this->Customer_model->identify($user['customer_id']);
		$data= array(			
			'userloggedin' => $user['customer_id'],
			'ssubtotal'=>$subtotal,
			'smember_discount'=>$vtotal,
			'scoupon_code'=>$_POST['coupon-code'],
			'sdiscount'=>$discount,
			'stax'=>$tax,
			'sgift_card' =>$gift_card,
			'sshipping_cost'=>$shipping_cost,
			'sshipping_method'=>$shipping_method,
			'sshipping_weight'=>$shipping_weight,
			'sshipping_weight_method'=>$shipping_weight_method,
			'sweight'=>$total_weight,
			'scost_weight'=>$cost_weight,
			'scost_flat'=>$cost_flat,
			'stotal'=>$total					
		);
		
		#echo '<pre>'.print_r($data,true).'</pre>';exit;
		
		$this->Order_model->update_paypal_txn($this->session->userdata('session_id'),$data);
		
		$this->session->set_userdata('ssubtotal',$subtotal);
		$this->session->set_userdata('smember_discount',$vtotal);
		$this->session->set_userdata('scoupon_code',$_POST['coupon-code']);
		$this->session->set_userdata('sdiscount',$discount);
		$this->session->set_userdata('stax',$tax);
		$this->session->set_userdata('sgift_card',$gift_card);
		$this->session->set_userdata('sshipping_cost',$shipping_cost);
		$this->session->set_userdata('sshipping_method',$shipping_method);
		$this->session->set_userdata('sshipping_weight',$shipping_weight);
		$this->session->set_userdata('sshipping_weight_method',$shipping_weight_method);
		$this->session->set_userdata('sweight',$total_weight);
		$this->session->set_userdata('scost_weight',$cost_weight);
		$this->session->set_userdata('scost_flat',$cost_flat);
		$this->session->set_userdata('stotal',$total);
				
		redirect('cart/payment');
	}

	function checkout()
	{
		
		$this->check_session();
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
		
		
		
		$data['countries_all'] = $this->System_model->get_shipping_countries();
		$data['states'] = $this->System_model->get_states();
		$data['suburbs'] = $this->System_model->get_suburbs_postcode(1);
		$data['page_title'] = "Trade Customer";
		
		
		$cart = $this->Cart_model->all($this->session->userdata('session_id'));
		$tax = $this->System_model->get_tax(1);
		if(! $this->session->userdata('userloggedin'))
		{
			redirect('store/signin');
		}
		$user = $this->session->userdata('userloggedin');
		if($user['level']!=4)		
		if ($tax) { 
			if (!$tax['included']) {
				$cart2 = array();
				foreach($cart as $item) {
					$price = money_format('%i',$item['price'] * 10/11);
					
					$item['price'] = $price;
					
					$cart2[] = $item;
				} 
				$cart = $cart2;
			}			
		}
		$data['cart'] = $cart;
		$data['page_title'] = "Checkout";
		$data['states'] = $this->System_model->get_states();
		$data['countries'] = $this->System_model->get_shipping_countries();
		$data['customer'] = $this->Customer_model->identify($user['customer_id']);

		$this->load->view('common/header',$data);
		$this->load->view('store/new_checkout',$data);
		$this->load->view('common/footer');

	}
	/*
	function checkout_old()
	{
		$this->check_session();
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
		
		
		
		$data['countries_all'] = $this->System_model->get_shipping_countries();
		$data['states'] = $this->System_model->get_states();
		$data['suburbs'] = $this->System_model->get_suburbs_postcode(1);
		$data['page_title'] = "Trade Customer";
		
		
		$cart = $this->Cart_model->all($this->session->userdata('session_id'));
		$tax = $this->System_model->get_tax(1);
		if(! $this->session->userdata('userloggedin'))
		{
			redirect('store/signin');
		}
		$user = $this->session->userdata('userloggedin');
		if($user['level']!=4)		
		if ($tax) { 
			if ($tax['included']) {
				$cart2 = array();
				foreach($cart as $item) {
					$price = money_format('%i',$item['price'] * 10/11);
					
					$item['price'] = $price;
					
					$cart2[] = $item;
				} 
				$cart = $cart2;
			}			
		}
		$data['cart'] = $cart;
		$data['page_title'] = "Checkout";
		$data['states'] = $this->System_model->get_states();
		$data['countries'] = $this->System_model->get_shipping_countries();
		$data['customer'] = $this->Customer_model->identify($user['customer_id']);

		$this->load->view('common/header',$data);
		$this->load->view('store/checkout',$data);
		$this->load->view('common/footer');		
	}
	*/
	
	
	#update discount
	function get_updatememberdiscount()
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
		$user = $this->session->userdata('userloggedin');
		$customer = $this->Customer_model->identify($user['customer_id']); 
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		if($customer['membership_status']>1){
			$tot_purchase = 0;
			$total = 0;
			foreach($cart as $item) {
				$tot_purchase +=$item['quantity'];
				$total += $item['price']*$item['quantity'];
				
			}
			// $vtotal=$total;
			$vtotal = 0;
			//if($customer['membership_status']==2){$vtotal=$total*(5/100);}
			//if($customer['membership_status']==3){$vtotal=$total*(10/100);}
			printf('%01.2f ',$vtotal*$data['cur_val']);
		}
	}
	function get_updatediscount()
	{
		$step=$this->updatediscount($_POST['code']);

		if($step=='0')
		{
			echo '0';
		}
		else
		{
			$temp=explode('#%',$step);
			if(count($temp)>1){
				echo $temp[0].' %';
			}else
			{
				$temp=explode('#$',$step);
				if(count($temp)>1){
					echo $temp[0];
				}
			}
		}
	}
	function updatediscount($code='')
	{				
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$user = $this->session->userdata('userloggedin');
		
		$customer = $this->Customer_model->identify($user['customer_id']); 
		$temp=0;
		$total = 0;
		$total_weight=0;
		$total_volume=0;
		$cost=0;
		$categories_items=array();
		$products_items=array();
		$tot_purchase = 0;
		foreach($cart as $item) {
			if($item['product_id']!=11)
			{
				$tot_purchase +=$item['quantity'];
				$total += $item['price']*$item['quantity'];
				$weight= $this->Product_model->identify($item['product_id']);
				$total_weight=$total_weight+($weight['weight']*$item['quantity']);			
				$cats=$this->Product_model->get_categories($item['product_id']);
				foreach($cats as $ct)
				{
					$categories_items[] = $ct['category_id'];
				}
				$products_items[]=$item['product_id'];
			}
		}
		$coupons = $this->System_model->get_coupons_active();
		
		$coupon_use='';
		if(count($coupons)>0 && $code!='')
		{
			$fin=0;
			$amount_disc=0;
			$amount_disc_percentage=0;
			foreach($coupons as $coupon)
			{
												
				if($coupon['expirary']==1)#once
				{
		
					$check_once = $this->Order_model->identify_promotioncode($coupon['id'],$user['customer_id']);
					if(count($check_once)==0)			
					{
						/*$discount=$this->System_model->check_conditions($coupon['id'],$session_id);
						if($discount<>2)
						{
							if($coupon['type_cond']==2)#any
							{
								$coupon_use = $coupon['id'];
								break;
							}
							if($coupon['type_cond']==1 && $discount==1)#all
							{
								$coupon_use = $coupon['id'];	
								break;
							}
						}*/
						$temp=1;
					}
					
				}
				
				if($coupon['expirary']==2)#date range
				{
					/*$discount=$this->System_model->check_conditions($coupon['id'],$session_id);
					if($discount<>2)
					{
						if($coupon['type_cond']==2)#any
						{
							$coupon_use = $coupon['id'];
							break;
						}
						if($coupon['type_cond']==1 && $discount==1)#all
						{
							$coupon_use = $coupon['id'];	
							break;
						}
					}*/
					if(date('Y-m-d')>=$coupon['from_date'] && date('Y-m-d')<=$coupon['from_date'])
					{
						$temp=1;
					}
				}
				if($coupon['expirary']==3)#permanent
				{
					/*$discount=$this->System_model->check_conditions($coupon['id'],$session_id);
					if($discount<>2)
					{
						if($coupon['type_cond']==2)#any
						{
							$coupon_use = $coupon['id'];
							break;
						}
						if($coupon['type_cond']==1 && $discount==1)#all
						{
							$coupon_use = $coupon['id'];	
							break;
						}
					}*/
					$temp=1;
				}
				if($fin==1){break;}
				if($temp==1 && $fin==0 ){
					
					#list all conditions of the coupon
					$conditions = $this->System_model->get_coupon_condition($coupon['id']);
					$tot_cond=count($conditions);
					$disc=0;
					if($tot_cond > 0){
						foreach($conditions as $cond)
						{
							if($cond['type']==1)#spend amount
							{
								if($total >= $cond['value'])
								{
									$disc=$disc+1;
								}
							}
							else
							if($cond['type']==2)#categories
							{
								$flag=0;
								$flag_out=0;
								$cond_cat=explode(',',$cond['categories']);							
								foreach($categories_items as $cti)
								{
									if(in_array($cti,$cond_cat))
									{
										$flag=1;
									}
									else
									{
										$flag_out=1;
									}
								}
								if($cond['cond_cat']=='in' && $flag==1){$disc=$disc+1;}
								else
								if($cond['cond_cat']=='out' && $flag_out==1){$disc=$disc+1;}
							}
							else
							if($cond['type']==3)#products
							{
								$flag_prod=0;
								$flag_prod_out=0;
								$cond_prod=explode(',',$cond['products']);							
								foreach($products_items as $pr)
								{
									if(in_array($pr,$cond_prod))
									{
										$flag_prod=1;
									}
									else
									{
										$flag_prod_out=1;
									}
								}
								if($cond['cond_prod']=='in' && $flag_prod==1){$disc=$disc+1;}
								else
								if($cond['cond_prod']=='out' && $flag_prod_out==1){$disc=$disc+1;}
							}
							else
							if($cond['type']==4)#product purchased
							{
								if($tot_purchase >= $cond['value'])
								{
									$disc=$disc+1;
								}
							}
							else
							if($cond['type']==5)#coupon
							{
								if($code == $cond['value'])
								{
									$disc=$disc+1;
								}
							}																	
						}
						
						if($coupon['type_cond']==1) #must meet all cond 
						{
							if($disc==$tot_cond)
							{
								if($coupon['type']==2)#fixed
								{
									$amount_disc = $coupon['value'];
									$fin=1;
								}
								else
								if($coupon['type']==1)#percentage
								{
									$amount_disc_percentage = $coupon['value'];
									$fin=1;
								}
							}
						}
						else if($coupon['type_cond']==2) # meet any cond
						{
							if($disc > 0)
							{
								if($coupon['type']==2)#fixed
								{
									$amount_disc = $coupon['value'];
									$fin=1;
									
								}
								else
								if($coupon['type']==1)#percentage
								{
									$amount_disc_percentage = $coupon['value'];
									$fin=1;
								}
							}
						}
						
					}
				}
			}
			/*
			if($coupon_use !='')
			{
				$coupons_use=$this->System_model->get_coupon($coupon_use);
				if($coupons_use['type']==1)#percentage
				{
					echo $coupons_use['value'].'%';
				}else
				{
					echo '$ '.$coupons_use['value'];
				}
			}
			else
			{
				echo 'No Discount';
			}*/
			
			if($fin==1)
			{
				if($amount_disc>0){return $amount_disc.'#$';}
				else
				if($amount_disc_percentage>0){return $amount_disc_percentage.'#%';}
				
			}
			else
			{
				return '0';
			}
			
		}
		else
		{
			return '0';
		}
	}
	
	
	# Update the shipping methods, depends on the selected country (AJAX function)
	function updateshippingmethod() {
		# if store pick up by pass shipping calculation
		if($this->session->userdata('store_pickup')){
			echo $this->session->userdata('store_pickup');
			return;
		}
		
		//$methods = $this->System_model->get_shippings_country($_POST['country_id']);
		//$methods = $this->System_model->get_shippings_country_state($_POST['country_id'],$_POST['state_id']);
		if($_POST['postcode']==''|| $_POST['country_id']!=13){$methods = $this->System_model->get_shippings_country_state($_POST['country_id'],$_POST['state_id']);}
		else{
			$methods = $this->System_model->get_shippings_country_state_suburb($_POST['country_id'],$_POST['state_id'],$_POST['postcode']);
		}
		$out = '<select id="method" class="form-control" style="width:292px; margin-top:10px;" onChange="updateshippingcost()" name="shipping_method">';
		foreach($methods as $method) {
			$out .= '<option value="'.$method['id'].'">'.$method['name'].'</option>';
		}
		$out .= '</select>';
		print $out;
	}
	
	function checkupdateshippingmethod() {
		//$methods = $this->System_model->get_shippings_country($_POST['country_id']);
		//$methods = $this->System_model->get_shippings_country_state($_POST['country_id'],$_POST['state_id']);
		if($_POST['postcode']==''|| $_POST['country_id']!=13){$methods = $this->System_model->get_shippings_country_state($_POST['country_id'],$_POST['state_id']);
			
		}
		
		else{
			
			$methods = $this->System_model->get_shippings_country_state_suburb($_POST['country_id'],$_POST['state_id'],$_POST['postcode']);
		}
			
		if(count($methods)>0){$out=1;}else{$out=-1;}	
		
		print $out;
	}
	# Update the shipping cost, depends on the selected shipping method (AJAX function)
	function updateshippingcost() {
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
		
		
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$total = 0;
		$total_weight=0;
		$total_volume=0;
		$cost=0;
		$gift_card=0;
		foreach($cart as $item) {
			if($item['product_id']!=11)
			{
				$total += $item['price']*$item['quantity'];
				$weight= $this->Product_model->identify($item['product_id']);
				$total_weight=$total_weight+($weight['weight']*$item['quantity']);
				$total_volume=$total_volume+($weight['volume']*$item['quantity']);
			}
			else
			{
				$gift_card=1;
			}
		}
		
		if($_POST['code'] != "") {
			$coupon = $this->System_model->check_coupon_code($_POST['code']);
			
			if($total >= $coupon['condition'] && $total > 0) {
				if($coupon['type'] == 1) { // Percentage
					$discount = $total * $coupon['value'] / 100;					
				} else {
					$discount = $coupon['value'];					
				}
			//	$total = $total - $discount;
			}
		}
		
		# if store pick up by pass shipping calculation
		if($this->session->userdata('store_pickup')){
			printf('%01.2f ',0);return;
		}else{
		
			$method = $this->System_model->get_shipping($_POST['method_id']); // weight cost
			//$method2 = $this->System_model->get_shipping_v2($_POST['method_id']); // flat _rate
			$first_cost=0;
			$cost_weight=0;
			$weight_cost=0;
			if($method['price_value'] && $method['price_type']==2 )
			{
				$first_cost=$method['price_value'];
				$cost=$first_cost;
			}
			if($method['price_value'] && $method['price_type']==1)
			{
				$cost_weight=$method['price_value'];
				$weight_cost=$cost_weight*$total_weight;
				$cost = $weight_cost;
			}
			if($method['price_value'] && $method['price_type']==3)
			{
				$cost_weight=$method['price_value'];
				$weight_cost=$cost_weight*$total_volume;
				$cost = $weight_cost;
				
			}
			$cost = $cost+$method['base_rate'];	
			
			$conditions = $this->System_model->get_shipping_conditions($method['id']);
			foreach($conditions as $condition) {
				if ($total >= $condition['condition']) {
					$cost = $condition['price'];
				}
			}
			if($gift_card==1 && $total==0){$cost=0;}
			//$cost=$cost+$weight_cost+$first_cost;
			
			
			//$cost = $cost/1.1;		
			
			$s = '';
			if ($method['price_type'] == 2) {
				$s = 'Flat rate';
			}
			else if ($method['price_type'] == 1) {
					
				$s ='Weight rate';
			}
			else
			{
				$s ='Volume rate';
			}
		}
		
		//printf('(%s) %s%01.2f ',$s,$data['sign'],$cost*$data['cur_val']);
		printf('%01.2f ',$cost*$data['cur_val']);
	}
	# Get the tax, depends on selected country (AJAX function)
	function gettax() {
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
		
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$total = 0;
		foreach($cart as $item) {
			if($item['product_id']!=11)
			{
				$total += $item['price']*$item['quantity'];
			}
		}
		if($this->session->userdata('store_pickup')){
			$tax = $this->_get_store_pickup_tax();
		}else{
			$tax = $this->System_model->get_tax_country($_POST['country_id']);
		}
		$user = $this->session->userdata('userloggedin');
		if ($tax) { 
			
			# if store pick up by pass shipping calculation
			if($this->session->userdata('store_pickup')){
				if ($tax['included']) { 				
					printf('%01.2f',($total/($tax['value']+1))*$data['cur_val']); 					
				}else
				{
					printf('%01.2f',($total/($tax['value']))*$data['cur_val']);
				}
			}else{
				if ($user['level'] == 4) {
					//$method = $this->System_model->get_shipping($_POST['method_id']);
					$method = $this->System_model->get_shipping_v2($_POST['method_id']);
					$gst_of_shipping = $method['price_value']-$method['price_value']/1.1;
					$conditions = $this->System_model->get_shipping_conditions($method['id']);
					foreach($conditions as $condition) {
						if ($total >= $condition['condition']) {
							$gst_of_shipping = $condition['price']-$condition['price']/1.1;
						}
					}		
					$method_weight = $this->System_model->get_shipping($_POST['method_id']); //weight_cost
					$gst_of_weight = $method_weight['price_value']-$method_weight['price_value']/1.1;
					if ($tax['included']) {
						//printf('(%s%% %s) %s%01.2f',$tax['value'],$tax['name'],$data['sign'],($total + $gst_of_weight + $gst_of_shipping- $total/(($tax['value']+100)/100))*$data['cur_val']); 
						printf('%01.2f',($total + $gst_of_weight + $gst_of_shipping- $total/(($tax['value']+100)/100))*$data['cur_val']); 
					} else {
						//printf('(%s%% %s) %s%01.2f',$tax['value'],$tax['name'],$data['sign'],($gst_of_shipping + $gst_of_weight+ $total*$tax['value']/100)*$data['cur_val']); 
						printf('%01.2f',($gst_of_shipping + $gst_of_weight+ $total*$tax['value']/100)*$data['cur_val']); 
					}
				}
				else{
					//printf('(%s%% %s) %s%01.2f',$tax['value'],$tax['name'],$data['sign'],($total/($tax['value']))*$data['cur_val']);
					
					if ($tax['included']) { 				
						printf('%01.2f',($total/($tax['value']+1))*$data['cur_val']); 					
					}else
					{
						printf('%01.2f',($total/($tax['value']))*$data['cur_val']);
					}
					
				}
				
			}
		}
		else { print 'No tax'; }
	}
	/*
	function checkcoupon() {
		$code = $_POST['code'];
		$coupon = $this->System_model->check_coupon_code($code);
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$total = 0;
		foreach($cart as $item) {
			$total += $item['price']*$item['quantity'];
		}
		
		if($total >= $coupon['condition'] && $total > 0) 
		{
			if($coupon['type'] == 1) { // Percentage
				$discount = $total * $coupon['value'] / 100;
				$s = '('.$coupon['value'].'%)';
			} else {
				$discount = $coupon['value'];
				$s = '($'.$coupon['value'].')';
			}
			$dis = sprintf('%s $%01.2f',$s,$discount);
		}
		
		$output = '';
		if($coupon) 
		{
			if($coupon['actived']) 
			{
				if($coupon['allowed_used_times'] == 0 || $coupon['actual_used_times'] < $coupon['allowed_used_times']) 
				{
					if($coupon['permanent'] == 1) 
					{
						if($total >= $coupon['condition'] && $total > 0) 
		                {
						   $this->addcoupon($code);	
						  //$output = "Ok";
						 
						}
						else
						{
							$output = "Err01";
						}
					}
					else 
					{
						if($this->System_model->check_coupon_period($code,$coupon['from_date'],$coupon['to_date']))
						{
							if($total >= $coupon['condition'] && $total > 0) 
		                    {
						      //$output = "Ok";
							  $this->addcoupon($code);
							  
						    }
						    else
						    {
							 $output = "Err01";
						     }
						} 
						else 
						{ 
						$output = "Err04"; 
						}
					}
				} 
				else 
				{ 
				$output = "Err03"; 
				}
			} 
			else 
			{ 
			 $output = "Err02"; 
			}
		} 
		else 
		{ 
		$output = "Err01";	
		}
		print $output;
	}
	*/
	function checkcoupon() {
		
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
		
		
		$user = $this->session->userdata('userloggedin');
		$customer = $this->Customer_model->identify($user['customer_id']); 
		
		$code = $_POST['code'];
		$ori_code=$code;
		$coupon = $this->System_model->check_coupon_code($code);
		$conds = $this->System_model->get_coupon_condition($coupon['id']);

		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$total = 0;
		$prods=array();
		$cats=array();
		$discount=0;
		foreach($cart as $item) {
			$total += $item['price']*$item['quantity'];
			$prods[]=$item['product_id'];
			$categories=$this->Category_model->identify_category_all($item['product_id']);
			foreach($categories as $ctp)
			{
				if(!in_array($ctp['category_id'],$cats))
				{
					$cats[]=$ctp['category_id'];
				}
			}
		}
		
		if($total >= $coupon['condition'] && $total > 0) 
		{
			if($coupon['type'] == 1) { // Percentage
				$discount = $total * $coupon['value'] / 100;
				$s = '('.$coupon['value'].'%)';
			} else {
				$discount = $coupon['value'];
				$s = '($'.$coupon['value'].')';
			}
			$dis = sprintf('%s $%01.2f',$s,$discount);
		}
		
		
		if($coupon['code']==$code && count($conds)==0)
		{
			$output="CODEOK";
		}
		else
		{
		$couponcond = $this->System_model->get_coupon_cond($code);
		
		$total_price_disc=0;
		if($couponcond){
			
			$true=0;
			$conds=$this->System_model->get_coupon_condition($couponcond['id_coupon']);	
			
			if(count($conds)==2 )
			{
				foreach($conds as $cd)
				{
					if($cd['type']==3)
					{
						if($cd['cond_prod']=='in')
						{
							$temp=array();
							$temp=explode(',',$cd['products']);							
							$result =array_intersect($prods,$temp);	
							if(count($result)>0)
							{								
								$true=1;
								foreach($cart as $item) {											
									if(in_array($item['product_id'],$temp))
									{																															
										$total_price_disc += $item['price']*$item['quantity'];
									}
									
								}
							}
						}
						else
						if($cd['cond_prod']=='out')
						{
							$temp=array();
							$temp=explode(',',$cd['products']);							
							$result =array_diff($prods,$temp);	
							if(count($result)>0)
							{								
								$true=1;
								foreach($cart as $item) {											
									if(!in_array($item['product_id'],$temp))
									{																															
										$total_price_disc += $item['price']*$item['quantity'];
									}
									
								}
							}
						}
						
					}
					
					if($cd['type']==1)
					{
						if($total>=$cd['value'])
						{
							$true=1;							
						}
					}
					
					if($cd['type']==2)
					{
						if($cd['cond_cat']=='in')
						{
							$temp=array();
							$temp=explode(',',$cd['categories']);							
							$result =array_intersect($cats,$temp);	
							
							if(count($result)>0)
							{								
								$true=1;
								$count=count($result);
								
								foreach($cart as $item) {
									
									$prods[]=$item['product_id'];
									$skip=0;
									$categories=$this->Category_model->identify_category_all($item['product_id']);
									foreach($categories as $ctp)
									{
										if(in_array($ctp['category_id'],$temp) && $skip==0)
										{
											$cats[]=$ctp['category_id'];
											$total_price_disc += $item['price']*$item['quantity'];
											$skip=1;
										}
									}
									
								}
								
							}
						}
						else
						if($cd['cond_cat']=='out')
						{
							$temp=array();
							$temp=explode(',',$cd['categories']);							
							$result =array_diff($cats,$temp);	
							$ots=1;
							if(count($result)>0)
							{								
								$true=1;
								$count=count($result);
								$tag=0;
								foreach($cart as $item) {
									
									$prods[]=$item['product_id'];
									$skip=0;
									$tag=0;
									$categories=$this->Category_model->identify_category_all($item['product_id']);
									/*foreach($categories as $ctp)
									{
										if(!in_array($ctp['category_id'],$temp) && $skip==0)
										{
											$cats[]=$ctp['category_id'];
											$total_price_disc += $item['price']*$item['quantity'];
											$skip=1;
										}
									}*/
									
									foreach($categories as $ctp)
									{
										
										if(in_array($ctp['category_id'],$temp) && $tag==0)
										{												
											$skip=1;$tag=1;
											
										}
									}
									
									if($tag==0){
										//$cats[]=$ctp['category_id'];
										$total_price_disc += ($item['price']*$item['quantity']);
										
									}
									
								}
								
							}
						}
					}
					
					if($cd['type']==4)
					{
						if(count($prods)>=$cd['value'])
						{
							$true=1;
						}
					}

					
				}
			}
			else
			{
				$trues=1;
				$nums=count($conds);
				if(count($conds)>2 )
				{
					foreach($conds as $cd)
					{
						if($cd['type']==3)
						{
							if($cd['cond_prod']=='in')
							{
								$temp=array();
								$temp=explode(',',$cd['products']);							
								$result =array_intersect($prods,$temp);	
								if(count($result)>0)
								{								
									$trues=$trues+1;
									foreach($cart as $item) {											
										if(in_array($item['product_id'],$temp))
										{																															
											$total_price_disc += $item['price']*$item['quantity'];
										}
										
									}
								}
							}
							else
							if($cd['cond_prod']=='out')
							{
								$temp=array();
								$temp=explode(',',$cd['products']);							
								$result =array_diff($prods,$temp);	
								if(count($result)>0)
								{								
									$trues=$trues+1;
									foreach($cart as $item) {											
										if(!in_array($item['product_id'],$temp))
										{																															
											$total_price_disc += $item['price']*$item['quantity'];
										}
										
									}
								}
							}
						}
						
						if($cd['type']==1)
						{
							if($total>=$cd['value'])
							{
								//$true=1;							
								$trues=$trues+1;
							}
						}
						
						if($cd['type']==2)
						{
							if($cd['cond_cat']=='in')
							{
								$temp=array();
								$temp=explode(',',$cd['categories']);							
								$result =array_intersect($cats,$temp);	
								
								if(count($result)>0)
								{								
									//$true=1;
									$trues=$trues+1;
									$count=count($result);
									
									foreach($cart as $item) {
										
										$prods[]=$item['product_id'];
										$skip=0;
										$categories=$this->Category_model->identify_category_all($item['product_id']);
										foreach($categories as $ctp)
										{
											if(in_array($ctp['category_id'],$temp) && $skip==0)
											{
												$cats[]=$ctp['category_id'];
												$total_price_disc += $item['price']*$item['quantity'];
												$skip=1;
											}
										}
										
									}
									
								}
							}
							else
							if($cd['cond_cat']=='out')
							{
								$temp=array();
								$temp=explode(',',$cd['categories']);							
								$result =array_diff($cats,$temp);	# to know how many that 
								$ots=1;
								if(count($result)>0)
								{								
									//$true=1;
									$trues=$trues+1;
									$count=count($result);
									$tag=0;
									foreach($cart as $item) {
										
										$prods[]=$item['product_id'];
										$skip=0;
										$tag=0;
										$categories=$this->Category_model->identify_category_all($item['product_id']);
										foreach($categories as $ctp)
										{
											if(in_array($ctp['category_id'],$temp))
											{												
												$skip=1;$tag=1;
											}
										}
										if($tag==0){
											//$cats[]=$ctp['category_id'];
											$total_price_disc += ($item['price']*$item['quantity']);											
										}
										
									}
									
								}
							}
						}
						
						if($cd['type']==4)
						{
							if(count($prods)>=$cd['value'])
							{
								//$true=1;
								$trues=$trues+1;
							}
						}
	
						
					}
				}
				if($trues==$nums)
				{
					$true=1;
				}
			}
			
			if($true==1)
			{
				$coupon = $this->System_model->get_coupon($couponcond['id_coupon']);
				$code=$coupon['code'];
			}
		}
		
		
		$output = '';
		if($coupon) 
		{
			if($coupon['actived']) 
			{
				if($coupon['allowed_used_times'] == 0 || $coupon['actual_used_times'] < $coupon['allowed_used_times']) 
				{
					if($coupon['permanent'] == 1) 
					{
						if($total >= $coupon['condition'] && $total > 0) 
		                {
						   //$this->addcoupon($code);	
						   //$output = "Ok";
						 
						}
						else
						{
							$output = "Err01";
						}
					}
					else 
					{
						if($total_price_disc>0 || $ots==1){$total=$total_price_disc;}
						//print_r($total_price_disc.' '.$ot);
						if($coupon['expirary']==2)
						{
							
							if($this->System_model->check_coupon_period_cond($code,$coupon['from_date'],$coupon['to_date'],date('Y-m-d')))
							{
								
								  //$output = "Ok";
								  if($coupon['type'] == 1) { // Percentage
										$discount = $total * $coupon['value'] / 100;								
									} else {
										if($ots==1 && $total_price_disc>0){$discount = $coupon['value'];}
										else
										if($ots==0){$discount = $coupon['value'];}
									}
								  //$this->addcoupon($code);
								  $output = '<td width="50%" align="left">Discount  </td>
									<td width="7%">&nbsp;</td>
									<td width="10%">-'.$data['sign'].'</td>
									<td width="8%">&nbsp;</td>
									<td width="20%"><div id="discount-cost">'.sprintf('%01.2f',$discount).'</div></td>';
								
							}
							else
							{
								$output = "Err01";	
							}
						}
						else if($coupon['expirary']==1)
						{
							if(count($this->Order_model->identify_promotioncode($ori_code,$user['customer_id']))==0)
							{							
								if($coupon['type'] == 1) { // Percentage
									$discount = $total * $coupon['value'] / 100;								
								} else {
									if($ots==1 && $total_price_disc>0){$discount = $coupon['value'];}
									else
									if($ots==0){$discount = $coupon['value'];}
								}
								//$this->addcoupon($code);
								$output = '<td width="50%" align="left">Discount  </td>
								<td width="7%">&nbsp;</td>
								<td width="10%">-'.$data['sign'].'</td>
								<td width="8%">&nbsp;</td>
								<td width="20%"><div id="discount-cost">'.sprintf('%01.2f',$discount).'</div></td>';
							}
							else{
								$output = "Err01";	
							}
						}
						else if($coupon['expirary']==3)
						{
							if($coupon['type'] == 1) { // Percentage
								$discount = $total * $coupon['value'] / 100;								
							} else {
								if($ots==1 && $total_price_disc>0){$discount = $coupon['value'];}
								else
								if($ots==0){$discount = $coupon['value'];}
							}
						    //$this->addcoupon($code);
						    $output = '<td width="50%" align="left">Discount  </td>
							<td width="7%">&nbsp;</td>
							<td width="10%">-'.$data['sign'].'</td>
							<td width="8%">&nbsp;</td>
							<td width="20%"><div id="discount-cost">'.sprintf('%01.2f',$discount).'</div></td>';
						}
						else 
						{ 
						$output = "Err04"; 
						}
					}
				} 
				else 
				{ 
				$output = "Err03"; 
				}
			} 
			else 
			{ 
			 $output = "Err02"; 
			}
		} 
		else 
		{ 
		$output = "Err01";	
		}
		}
		print $output;
	}
	function addcoupon2() {
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
		
		
		$code = $_POST['code'];		
		$coupon = $this->System_model->check_coupon_code($code);
						
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$total = 0;
		foreach($cart as $item) {
			$total += $item['price']*$item['quantity'];
		}
		$dis = '0.00';
		$discount=0;
		$user = $this->session->userdata('userloggedin');
		$customer = $this->Customer_model->identify($user['customer_id']); 
		$customer_id = $customer['id'];
		$pass=0;
		if($coupon['expirary']==1)
		 {		
			 if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){$pass=1;}
		 }
		 if($coupon['expirary']==2)
		 {		
			 //if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){}
			 if($this->System_model->check_coupon_period_cond($code,$coupon['from_date'],$coupon['to_date'],date('Y-m-d')))
			 {$pass=1;}
		 }
		 if($coupon['expirary']==3)
		 {		
			$pass=1;
			 //if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){}
			 
		 }
				 
		if($total >= $coupon['condition'] && $total > 0 && $pass==1) 
		{
			if($coupon['type'] == 1) { // Percentage
				$discount = $total * $coupon['value'] / 100;
				$s = '('.$coupon['value'].'%)';
				$disc=$coupon['value'].'%';
			} else {
				$discount = $coupon['value'];
				$s = '($'.$coupon['value'].')';
				$disc='$'.$coupon['value'];
			}
			$dis = sprintf('%s $%01.2f',$s,$discount);
		}
		
		//$subtotal = sprintf('$%01.2f',$total - $discount);
		$extra = '';
		if($coupon['condition'] >0 )
		{
			$extra = '$'.$discount.' off total order price for orders over $'.$coupon['condition'].'';
		}
		/*
		$out = '
		<table cellpadding="0" cellspacing="0" border="0" width="450">
		  <tr>
		    <td width="160">Price before discount</td>
			<td align="left">'.sprintf('$%01.2f',$total).'</td>
	      </tr>
		  <tr>
			<td width="160"><div style="margin-top:4px"><p class="green">'.$coupon['name'].' Applied</p><p>'.$extra.'</p></div></td><td valign="top" align="left"><div style="margin-top:4px">'.sprintf('$%01.2f',$discount).' off ( '.$disc.' )</div></td>
	      </tr></table><div style="height:5px;"></div>';
		*/
		$out = '<td width="50%" align="left">Discount  </td>
                <td width="7%">&nbsp;</td>
                <td width="10%">-'.$data['sign'].'</td>
                <td width="8%">&nbsp;</td>
                <td width="20%"><div id="discount-cost">'.sprintf('%01.2f',$discount).'</div></td>';
		print $out;
	}
	# Update the total cost (AJAX function)
	function totalprice() {
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
		
		
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$total = 0;
		
		$total_weight=0;
		$total_volume=0;
		$total_items=0;
		$prods=array();
		$cats=array();
		$gift_card=0;
		$gift_avail=0;
		foreach($cart as $item) {
			if($item['product_id']==11){$gift_card=$gift_card+$item['price'];$gift_avail=1;}
			else
			{
				$total += $item['price']*$item['quantity'];
				$total_items += $item['price']*$item['quantity'];
				$weight= $this->Product_model->identify($item['product_id']);
				$total_weight=$total_weight+($weight['weight']*$item['quantity']);
				$total_volume=$total_volume+($weight['volume']*$item['quantity']);
				$prods[]=$item['product_id'];
				$categories=$this->Category_model->identify_category_all($item['product_id']);
				foreach($categories as $ctp)
				{
					if(!in_array($ctp['category_id'],$cats))
					{
						$cats[]=$ctp['category_id'];
					}
				}
			}
		}
		$mtot=$item['price']*$item['quantity'];
		$user = $this->session->userdata('userloggedin');
		$customer = $this->Customer_model->identify($user['customer_id']); 
		//$user = $this->session->userdata('userloggedin');
		//$customer = $this->Customer_model->identify($user['customer_id']); 
		$customer_id = $customer['id'];
		
		
		
		/*if($customer['membership_status']==2){$vtotal=$total_items*(5/100);}
		if($customer['membership_status']==3){$vtotal=$total_items*(10/100);}
		*/
		
		# Tax second
		if($this->session->userdata('store_pickup')){
			$tax = $this->_get_store_pickup_tax();
		}else{
			$tax = $this->System_model->get_tax_country($_POST['country_id']);
		}
		if ($tax) { 
			if (!$tax['included']) { 
				
				$total = $total + $total * $tax['value']/100; 
				
			}
		}
		
		
		
		# Discount first
		if($_POST['code'] != "") {
			$code=$_POST['code'];
			$coupon = $this->System_model->check_coupon_code($_POST['code']);			
			$conds = $this->System_model->get_coupon_condition($coupon['id']);
			
			$pass=0;
			if($coupon['expirary']==1)
			 {		
				 if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){$pass=1;}
			 }
			 if($coupon['expirary']==2)
			 {		
				 //if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){}
				 if($this->System_model->check_coupon_period_cond($code,$coupon['from_date'],$coupon['to_date'],date('Y-m-d')))
				 {$pass=1;}
			 }
			 if($coupon['expirary']==3)
			 {		
				$pass=1;
				 //if(count($this->Order_model->identify_promotioncode($code,$customer_id))==0){}
				 
			 }
			
			if($coupon && count($conds)==0 && $pass==1){
				
				
					if($total_items >= $coupon['condition'] && $total_items > 0) {
						if($coupon['type'] == 1) { // Percentage
							$discount = $total_items * $coupon['value'] / 100;					
						} else {
							$discount = $coupon['value'];					
						}
						$total = $total - $discount;
					}
				
			}
			else
			{
				$couponcond = $this->System_model->get_coupon_cond($code);	
				$cop = $this->System_model->get_coupon($couponcond['id_coupon']);
				if($couponcond && $cop['actived']==1){
							
				//Uif($couponcond){
					$total_price_disc=0;
					$true=0;
					$conds=$this->System_model->get_coupon_condition($couponcond['id_coupon']);	
					
					if(count($conds)==2)
					{
						foreach($conds as $cd)
						{
							if($cd['type']==3)
							{
								if($cd['cond_prod']=='in')
								{
									$temp=array();
									$temp=explode(',',$cd['products']);							
									$result =array_intersect($prods,$temp);	
									if(count($result)>0)
									{								
										$true=1;
										foreach($cart as $item) {											
											if(in_array($item['product_id'],$temp))
											{																															
												$total_price_disc += $item['price']*$item['quantity'];
											}
											
										}
									}
								}
								else
								if($cd['cond_prod']=='out')
								{
									$temp=array();
									$temp=explode(',',$cd['products']);							
									$result =array_diff($prods,$temp);	
									if(count($result)>0)
									{								
										$true=1;
										foreach($cart as $item) {											
											if(in_array($item['product_id'],$temp))
											{																															
												$total_price_disc += $item['price']*$item['quantity'];
											}
											
										}
									}
								}
							}
							if($cd['type']==1)
							{
								if($total>=$cd['value'])
								{
									$true=1;							
								}
							}
							
							if($cd['type']==2)
							{
								if($cd['cond_cat']=='in')
								{
									$temp=array();
									$temp=explode(',',$cd['categories']);							
									$result =array_intersect($cats,$temp);	
									if(count($result)>0)
									{								
										$true=1;
										$count=$result;
										
										foreach($cart as $item) {
											$skip=0;
											$prods[]=$item['product_id'];
											$categories=$this->Category_model->identify_category_all($item['product_id']);
											foreach($categories as $ctp)
											{
												if(in_array($ctp['category_id'],$temp)&&$skip==0)
												{
													$cats[]=$ctp['category_id'];
													$total_price_disc += $item['price']*$item['quantity'];
													$skip=1;
												}
											}
										}
									}
								}
								else
								if($cd['cond_cat']=='out')
								{
									$temp=array();
									$temp=explode(',',$cd['categories']);							
									$result =array_diff($cats,$temp);	# to know how many that 
									$ots=1;
									if(count($result)>0)
									{								
										$true=1;
										//$trues=$trues+1;
										//$count=count($result);
										$tag=0;
										foreach($cart as $item) {
											
											$prods[]=$item['product_id'];
											$skip=0;
											$tag=0;
											$categories=$this->Category_model->identify_category_all($item['product_id']);
											foreach($categories as $ctp)
											{
												if(in_array($ctp['category_id'],$temp))
												{												
													$skip=1;$tag=1;
												}
											}
											if($tag==0){
												//$cats[]=$ctp['category_id'];
												$total_price_disc += ($item['price']*$item['quantity']);											
											}
											
										}
										
									}
								}
							}
							
							if($cd['type']==4)
							{
								if(count($prods)>=$cd['value'])
								{
									$true=1;
								}
							}
							
							
						}
					}
					else
					{
						$trues=1;
						$nums=count($conds);
						if(count($conds)>2 )
						{
							foreach($conds as $cd)
							{
								if($cd['type']==3)
								{
									if($cd['cond_prod']=='in')
									{
										$temp=array();
										$temp=explode(',',$cd['products']);							
										$result =array_intersect($prods,$temp);	
										if(count($result)>0)
										{								
											$trues=$trues+1;
										}
									}
									else
									if($cd['cond_prod']=='out')
									{
										$temp=array();
										$temp=explode(',',$cd['products']);							
										$result =array_diff($prods,$temp);	
										if(count($result)>0)
										{								
											$trues=$trues+1;
										}
									}
								}
								
								if($cd['type']==1)
								{
									if($total>=$cd['value'])
									{
										//$true=1;							
										$trues=$trues+1;
									}
								}
								
								if($cd['type']==2)
								{
									if($cd['cond_cat']=='in')
									{
										$temp=array();
										$temp=explode(',',$cd['categories']);							
										$result =array_intersect($cats,$temp);	
										
										if(count($result)>0)
										{								
											//$true=1;
											$trues=$trues+1;
											$count=count($result);
											
											foreach($cart as $item) {
												
												$prods[]=$item['product_id'];
												$skip=0;
												$categories=$this->Category_model->identify_category_all($item['product_id']);
												foreach($categories as $ctp)
												{
													if(in_array($ctp['category_id'],$temp) && $skip==0)
													{
														$cats[]=$ctp['category_id'];
														$total_price_disc += $item['price']*$item['quantity'];
														$skip=1;
													}
												}
												
											}
											
										}
									}
									else
									if($cd['cond_cat']=='out')
									{
										$temp=array();
										$temp=explode(',',$cd['categories']);							
										$result =array_diff($cats,$temp);	# to know how many that 
										$ots=1;
										if(count($result)>0)
										{								
											//$true=1;
											$trues=$trues+1;
											$count=count($result);
											$tag=0;
											foreach($cart as $item) {
												
												$prods[]=$item['product_id'];
												$skip=0;
												$tag=0;
												$categories=$this->Category_model->identify_category_all($item['product_id']);
												foreach($categories as $ctp)
												{
													if(in_array($ctp['category_id'],$temp))
													{												
														$skip=1;$tag=1;
													}
												}
												if($tag==0){
													//$cats[]=$ctp['category_id'];
													$total_price_disc += ($item['price']*$item['quantity']);											
												}
												
											}
											
										}
									}
								}
								
								if($cd['type']==4)
								{
									if(count($prods)>=$cd['value'])
									{
										//$true=1;
										$trues=$trues+1;
									}
								}
			
								
							}
						}
						if($trues==$nums)
						{
							$true=1;
						}
					}
					if($true==1)
					{
						if($total_price_disc>0 || $ots==1){$total1=$total_price_disc;}else{$total1=$total;}
						//$total1=$total;
						$coupon = $this->System_model->get_coupon($couponcond['id_coupon']);
						$code=$coupon['code'];
						if($coupon['expirary']==2)
						{
							if($this->System_model->check_coupon_period_cond($code,$coupon['from_date'],$coupon['to_date'],date('Y-m-d')))
							{
								
								  if($coupon['type'] == 1) { // Percentage
										$discount = $total1 * $coupon['value'] / 100;								
									} else {
										if($ots==1 && $total_price_disc>0){$discount = $coupon['value'];}
										else
										if($ots==0){$discount = $coupon['value'];}
										
									}
								  $total = $total - $discount;
								
							}
						}
						else if($coupon['expirary']==1)
						{
							if(count($this->Order_model->identify_promotioncode($code,$user['customer_id']))==0)
							{	
								if($coupon['type'] == 1) { // Percentage
										$discount = $total1 * $coupon['value'] / 100;								
									} else {
										if($ots==1 && $total_price_disc>0){$discount = $coupon['value'];}
										else
										if($ots==0){$discount = $coupon['value'];}
									}
								  $total = $total - $discount;
							}
						}
						else if($coupon['expirary']==3)
						{
							if($coupon['type'] == 1) { // Percentage
										$discount = $total1 * $coupon['value'] / 100;								
									} else {
										if($ots==1 && $total_price_disc>0){$discount = $coupon['value'];}
										else
										if($ots==0){$discount = $coupon['value'];}
									}
								  $total = $total - $discount;
						}
					}
				}
			}
		}
		
		if($total <= 0){$total=0;}
		
		
		# Shipping last
		
		# if pick up at store by pass this step
		$cost = 0;
		if(!$this->session->userdata('store_pickup')){
			
			$method = $this->System_model->get_shipping($_POST['method_id']);
			
			//$method2 = $this->System_model->get_shipping_v2($_POST['method_id']);
			$cost=0;
			$weight_cost=0;
			if($method['price_type']==2){$first_cost=$method['price_value']; $cost = $method['price_value'];}
			
			if($method['price_type']==1){$cost_weight=$method['price_value']; $weight_cost=$cost_weight*$total_weight; $cost=$weight_cost;}
			
			if($method['price_type']==3){$cost_weight=$method['price_value']; $weight_cost=$cost_weight*$total_volume; $cost=$weight_cost;}
			
			$cost = $cost+$method['base_rate'];
			
			$conditions = $this->System_model->get_shipping_conditions($method['id']);
			foreach($conditions as $condition) {
				if ($total >= $condition['condition']) {
					$cost = $condition['price'];
				}
			}
			
		}
		
		if($gift_avail==1 && $total==0){$cost=0;}
		$total = $total + $cost + $gift_card;
		if ($total < 0)
		{
		  $total = 0;
		}
	
		printf('%01.2f ',$total*$data['cur_val']);
	}

	function set_temp_hero()
	{
		$prod = $_POST['prod_id'];
		$photo = $_POST['photo_id'];
		
		$this->session->set_userdata('prod_hero_'.$prod,$photo);
	}

	
	
	function send_ecard($id)
	{
		$order = $this->Order_model->identify($id);
		$state = $this->System_model->get_state($order['state']);
		$country = $this->System_model->get_country($order['country']);
		
		$add = $order['address'];
		$add = ' '.$order['address2'];
		$add = ' '.$order['city'];
		$add = ' '.$state;
		$add = ' '.$order['postcode'];
		$add = ' '.$country;
		
		$msg = '<link href="http://fonts.googleapis.com/css?family=Parisienne|Buenard:400,700|Open+Sans:400,600italic,600" rel="stylesheet" type="text/css">
				<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; font-family:open sans;">
					<tr>
						<td>
							Dear '.$order['receipt_name'].',<br/>
							<br/>
							A gorgeous gift has been sent to you from Bared. It will be sent to '.$add.' within the next 14 days and will arrive by courier or eParcel.<br/>
							<br/>
							We Hope you enjoy your gift<br/>
							
						</td>
					</tr>
				</table>';
		
		$msg .= '<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; background: #faf8f6; font-family:open sans;">
					<tr>
						<td style="padding: 10px; width: 50%">
							<img alt="" src="'.base_url().'img/ecard/large'.$order['gift_bg'].'.jpg"/>
						</td>
						<td style="padding: 50px; width: 50%; vertical-align: top">
							<p style="text-align: center; margin-bottom: 30px;">
							<img alt="" src="'.base_url().'img/logo_ecard.png"/>
							</p>
							<p>
							Dear '.$order['receipt_name'].',<br/>
							<br/>
							'.$order['gift_notes'].'<br/>
							<br/>
							</p>
							<p style="text-align: right">
							'.$order['gift_sender'].'
							</p>
						</td>
					</tr>
				</table>';
				
		$msg .= '<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; margin-bottom: 30px">
					<tr>
						<td style="text-align: center">
							
						</td>
					</tr>
				</table>';
				
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from($order['email']);
        
		$this->email->to($order['receipt_email']);
		$this->email->bcc('hans@propagate.com.au,peteryo11@gmail.com');
		
		$this->email->subject('Ecard @ Bared Online Store');
		$this->email->message($msg);
		$this->email->send();
	}
	
	function set_ecard_data()
	{
		$this->session->set_userdata('ecard_recipient',$_POST['recipient']);
		$this->session->set_userdata('ecard_sender',$_POST['sender']);
		$this->session->set_userdata('ecard_notes',$_POST['notes']);
		$this->session->set_userdata('ecard_img',$_POST['img']);
	}
	
	function ecard_preview()
	{
		
		if($this->session->userdata('ecard_recipient'))
		{
			$data['recipient'] = $this->session->userdata('ecard_recipient');
		}
		else 
		{
			$data['recipient'] = '(Recipient123)';
		}
		
		if($this->session->userdata('ecard_sender'))
		{
			$data['sender'] = $this->session->userdata('ecard_sender');
		}
		else 
		{
			$data['sender'] = '(Sender)';
		}
		//$this->load->view('store/ecard_preview');
		
		if($this->session->userdata('ecard_notes'))
		{
			$data['notes'] = $this->session->userdata('ecard_notes');
		}
		else 
		{
			$data['notes'] = "Here's a little present for you for our 30th wedding anniversary.";
		}
		
		if($this->session->userdata('ecard_img'))
		{
			$data['img'] = $this->session->userdata('ecard_img');
		}
		else 
		{
			$data['img'] = '1';
		}
		
		if($this->session->userdata('saddress'))
		{
			
			
			$add = $this->session->userdata('saddress');
			$add .= ' '.$this->session->userdata('saddress2');
			$add .= ' '.$this->session->userdata('ssuburb');
			
			
			
			$state = $this->System_model->get_state($this->session->userdata('sstate'));
			$add .= ' '.$state;
			
			$add .= ' '.$this->session->userdata('spostcode');
			
			$country = $this->System_model->get_country($this->session->userdata('scountry'));
			$add .= ' '.$country;
			
			$data['address'] = $add;
		}
		else 
		{
			$data['address'] = '(Delivery Address)';
		}
		
		//print_r($data);
		
		$this->load->view('store/ecard_preview',$data);
	}
	
	function from_cart_to_wishlist()
	{
		$user = $this->session->userdata('userloggedin');
		if($user){
			//echo "<pre>".print_r($user,true)."</pre>";
			//exit;
			$product_id = $this->input->post('id',TRUE);
			$user_id = $user['id'];
			$prod = $this->Product_model->identify($product_id);
			$cat = $this->Category_model->identify($prod['main_category']);
			//$cat_name = $this->input->post('cat_name',TRUE);
			
			$str =  $this->input->post('attributes',TRUE);
			
			$data['product_id']=$product_id;
			$data['user_id']=$user_id;
			$data['cat_name']=$cat['name'];
			
			print_r($data);
			
			$id = $this->Cart_model->add_wishlist($data);
			
			echo $id;
			
		}else{
			echo"-1";
		}
	}
	
	function add_towishlist()
	{
		$user = $this->session->userdata('userloggedin');
		if($user){
			//echo "<pre>".print_r($user,true)."</pre>";
			//exit;
			$product_id = $this->input->post('product_id',TRUE);
			$user_id = $user['id'];
			$cat_name = $this->input->post('cat_name',TRUE);
			$str =  $this->input->post('attributes',TRUE);
			
			$data['product_id']=$product_id;
			$data['user_id']=$user_id;
			$data['cat_name']=$cat_name;
			$data['attributes']=$str;
			
			$id = $this->Cart_model->add_wishlist($data);
			
			echo $id;
			
		}else{
			echo"-1";
		}
		 
	}
	
	function wishlist()
	{
		$user = $this->session->userdata('userloggedin');
		if($user){
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
			
			$data['lists'] = $this->Cart_model->get_wishlist($user['id']);
			
			$this->load->view('common/header',$data);
			$this->load->view('store/wishlist');
			$this->load->view('common/footer');
		}else{
			redirect('store/signin');
		}
	}

	function delete_wishlist($id)
	{
		$this->Cart_model->delete_wishlist($id);
		redirect('cart/wishlist');
	}
	
	function count_wishlist()
	{
		$user = $this->session->userdata('userloggedin');
		$count = count($this->Cart_model->get_wishlist($user['id']));
		//$count = str_pad($count, 2, '0', STR_PAD_LEFT);
		echo $count;
	}
	
	function count_cart()
	{
		$count = 0;
		$session_id = $this->session->userdata('session_id');
		//if($this->session->userdata('userloggedin'))
		//{
			//$user = $this->session->userdata('userloggedin');
		$count = count($data['cart'] = $this->Cart_model->all($session_id));
		//}
		//$count = str_pad($count, 2, '0', STR_PAD_LEFT);
		echo $count;
	}
	
	function fb_check()
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
		$data['page_title'] = "Confirmation - Unsuccessful Order";
		
		$this->load->view('common/header',$data);
		
		$this->load->view('store/fb_check');
		$this->load->view('common/footer');
	}
	
	function conf_unsuccess()
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
		$data['page_title'] = "Confirmation - Unsuccessful Order";
		
		$this->load->view('common/header',$data);
		
		$this->load->view('store/conf_unsuccess');
		$this->load->view('common/footer');
	}
	
	function create_order_csv($order_id='')
	{
		$order = $this->Order_model->identify($order_id);
		$cust = $this->Customer_model->identify($order['customer_id']);
		$state = $this->System_model->get_state_code($cust['state']);
		
		$headings = array('line_type','orders_id','customer_barcode','customers_first_name','customers_last_name','customers_street_address','customers_suburb','customers_city','customers_state','customers_postcode','customers_country','customers_telephone','customers_email_address','delivery_name','delivery_company','delivery_street_address','delivery_suburb','delivery_city','delivery_state','delivery_postcode','delivery_country','comments','billing_name','billing_company','billing_street_address','billing_suburb','billing_city','billing_state','billing_postcode','billing_country','currency','currency_value','payment_method','cc_type','date_purchased');
		
		$line = array('1',$order['id'],'',$cust['firstname'],$cust['lastname'],$cust['address'],$cust['suburb'],'',$cust['address'],$state,$cust['postcode'],$cust['country'],);
		
		$headings = array('','orders_id','stock_id','products_quantity','text(optional)','products_price_ex','products_tax%','tax_code');
		
		$headings = array('','orders_id','stock_id','title','text(optional)','value');
	}
	
	function get_stock_id($prod_id,$size)
	{
		$products=$this->Lightspeed_model->get_product_stock_id_lightspeed($size,$prod_id);
		if(isset($products['size_stock_id']))	
		{
			$multiple_stock_id = json_decode($products['size_stock_id'],true);
			if($multiple_stock_id){
				#get size
				foreach ($multiple_stock_id as $key => $value){
					if($key==$size){
						#echo  $key . ':' . $value;
						$id = $key;
					}
				}
				
			}
		}
		return $id;
	}
	
	
	
	
	function set_order($id)
	{
		$orders=$this->Lightspeed_model->get_order($id);
		
		$carts=$this->Lightspeed_model->get_cart($orders['session_id']);
		
		$customers = $this->Lightspeed_model->get_customer($orders['customer_id']);
		$email = $customers['email'];
		$firstname = $customers['firstname'];
		$lastname = $customers['lastname'];
		$address = $customers['address'];
		$suburb = $customers['suburb'];
		$state_id = $customers['state'];
		$country = $customers['country'];
		$postcode = $customers['postcode'];
		$phone = $customers['phone'];
		$mobile = $customers['mobile'];
		$MOStimestamp = date('Y-m-d H:i:s');
		
		
		
		
		$xml_create_customer = 
		"<?xml version='1.0'?>
		<Customer>
		  <firstName>$firstname</firstName>
		  <lastName>$lastname</lastName>		  
		  <timeStamp>$MOStimestamp</timeStamp>
		  <customerTypeID>1</customerTypeID>
		  <taxCategoryID>1</taxCategoryID>
		  <Contact>
			<timeStamp>$MOStimestamp</timeStamp>
			<Addresses>
			  <ContactAddress>
				<address1>$address</address1>
				<city>$suburb</city>
				<state>$state_id</state>
				<zip>$postcode</zip>
				<country>$country</country>
			  </ContactAddress>
			</Addresses>
			<Phones>
			  <ContactPhone>
				<number>$phone</number>
				<useType readonly='true'>Home</useType>
			  </ContactPhone>
			</Phones>
			<Emails>
			  <ContactEmail>
				<address>$email</address>
				<useType readonly='true'>Primary</useType>
			  </ContactEmail>
			</Emails>
		  </Contact>
		</Customer>";
		
		
		$additionalHeaders='';
		
		$apikey = '0c58a74d684a750b0a5d2bb55d65362303f4af04110210d7f7d44255131c9a17';
		$password = 'apikey';
		$account_id = 57839;
		
		
		$cust_id=0;
		// Create cURL resource
		
		$curl = curl_init();
		
		// Set URL
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=0");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account");
		curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Customer?load_relations=[\"Contact\"]");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all&archived=0&limit=5&offset=2");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
		
		// Authenticate
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 
		
		// Send content in proper format
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              
		
		// Set Request Type 
		// (you'll need to change this depending on what you're doing)
		curl_setopt($curl,CURLOPT_HTTPGET, 1);
		//curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
		// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
		// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
		
		// To send parameters (data)
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_create_customer);
		
		
		// Return the transfer as a string
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		// $output contains the output string
		$output = curl_exec($curl);
		
		// Close cURL resource to free up system resources
		curl_close($curl);
		
		$xml = simplexml_load_string($output);
		$emails = $xml->xpath('//Emails');
		$customer_ids = $xml->xpath('//customerID');
		
		$i=0;
		$pos=-1;
		foreach($emails as  $purge) { 							
			if($purge->ContactEmail->address==$email)
			{
				$pos=$i;
			}
			$i++;
			
		}		
		$j=0;
		if($pos > -1){
			foreach($customer_ids as  $purge) { 				
				
				if($j==$pos)
				{
					$cust_id=$purge;
				}
				$j++;
				
			}
		}
		
		if($cust_id==0)
		{
			
			//echo'create';
			// Create cURL resource
			
			$curl = curl_init();
			
			// Set URL
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=0");
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account");
			curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Customer");
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all&archived=0&limit=5&offset=2");
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
			
			// Authenticate
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 
			
			// Send content in proper format
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              
			
			// Set Request Type 
			// (you'll need to change this depending on what you're doing)
			//curl_setopt($curl,CURLOPT_HTTPGET, 1);
			curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
			// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
			// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
			
			// To send parameters (data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_create_customer);
			
			
			// Return the transfer as a string
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
			// $output contains the output string
			$output = curl_exec($curl);
			
			// Close cURL resource to free up system resources
			curl_close($curl);
			
			$xml = simplexml_load_string($output);
			$customer_ids = $xml->xpath('//customerID');
			foreach($customer_ids as $cs)
			{
				$cust_id= $cs;
			}
			
		}
		
		
		
		if($cust_id > 0)
		{
			//$amount = $orders['total'];
			$amount=0;
			$tx=$orders['tax'];
			$disc=$orders['member_discount']+$orders['discount'];
			
			$shipping=$orders['shipping_cost'];
			$paymentTypeID =3;
			$k=1;
			$dd=0;
			$salelineArray='';
			foreach ($carts as $cart) {
				
				
				$unitPrice = $cart['price'];
				//$unitPrice=money_format('%i',$cart['price'] * 10/11);
				#$tax=money_format('%i',$unitPrice * 0.10);
				//$unitPrice=round($cart['price'] / 1.1, 2);
				$tax=round($unitPrice / 10,2);
				$unitQuantity =1;
				
				
				
				$itemID = $cart['stock_id'];
				$k=$k+2;
				/*<tax1Rate>$tax</tax1Rate>
					  <taxClassID>1</taxClassID>
					  <taxCategoryID>1</taxCategoryID>*/
				$salelineArray .= "
					<SaleLine>
					  <unitQuantity>$unitQuantity</unitQuantity>
					  <unitPrice>$unitPrice</unitPrice>					  
					  <tax>false</tax>  					  
  					  <customerID>$cust_id</customerID>
					  <itemID>$itemID</itemID>";
					  if($disc>0 &&$dd==1){$salelineArray .= "	  									 					  
						<discountID>4</discountID>
					    <discountAmount currency='AUD'>$disc</discountAmount>
						<requireCustomer>true</requireCustomer>																	  
					  ";
					  $dd=1;
					  }		
					  $salelineArray .= "	  					  
					</SaleLine>
				 ";
			}
			
			
			$salelineArray .= "
					<SaleLine>
					  <unitQuantity>1</unitQuantity>
					  <unitPrice>$shipping</unitPrice>					  
					  <tax>false</tax>
  					  
  					  <customerID>$cust_id</customerID>
					  <Note>
    					<noteID>1</noteID>
    					<note>Shipping Cost</note>
    					<isPublic>true</isPublic>
    					<timeStamp>$MOStimestamp</timeStamp>
  					</Note>
		
					</SaleLine>
				";
			$salelineArray .= "
					<SaleLine>
					  <unitQuantity>1</unitQuantity>
					  <unitPrice>-$disc</unitPrice>					  
					  <tax>false</tax>
  					  
  					  <customerID>$cust_id</customerID>
					  <Note>
    					<noteID>2</noteID>
    					<note>Discount</note>
    					<isPublic>true</isPublic>
    					<timeStamp>$MOStimestamp</timeStamp>
  					</Note>
		
					</SaleLine>
				";
			
			
			$amount=$orders['subtotal']+$orders['tax'];
			$amount=$amount+$shipping;
			
			$amount=$amount-$disc;
			$shipnote='';
			$sfirstName = $orders['firstname'];
			$slastName = $orders['lastname'];
			$saddress1 = $orders['address'];
			$scity = $orders['city'];
			$sstate = $orders['state'];
			$scountry = $orders['country'];
			$szip = $orders['postcode'];
			$sContactPhone='';
			$xml_create_sale = 
				"<?xml version='1.0'?>
				<Sale>
				  <timeStamp>$MOStimestamp</timeStamp>
				  <employeeID>1</employeeID>
				  
				  
				  <completed>true</completed>
				  <customerID>$cust_id</customerID>	
				  <shopID>1</shopID>		  
				  <registerID>1</registerID>
				  <taxCategoryID>1</taxCategoryID>
				  <ShipTo>
					<shipped>false</shipped>
					<timeStamp>$MOStimestamp</timeStamp>
					<shipNote>$shipnote</shipNote>
					<firstName>$sfirstName</firstName>
					<lastName>$slastName</lastName>				
					<Contact>
					  <timeStamp>$MOStimestamp</timeStamp>
					  <Addresses>
						<ContactAddress>
						  <address1>$saddress1</address1>					 
						  <city>$scity</city>
						  <state>$sstate</state>
						  <zip>$szip</zip>
						  <country>$scountry</country>
						</ContactAddress>
					  </Addresses>
					  <Phones>
						<ContactPhone>
						  <number>$sContactPhone</number>
						  <useType readonly='true'>Home</useType>
						</ContactPhone>
					  </Phones>
					</Contact>
				  </ShipTo>
				  <SaleLines>
				  $salelineArray
				  </SaleLines>
				  <SalePayments>
					<SalePayment>
					  <amount currency='AUD'>$amount</amount>
					  <paymentTypeID>$paymentTypeID</paymentTypeID>
					  <registerID>1</registerID>
					</SalePayment>
				  </SalePayments>
				</Sale>";
	
			// Create cURL resource
			$xml2 = simplexml_load_string($xml_create_sale);
			
			$curl = curl_init();
			
			// Set URL		
			curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
			
			// Authenticate
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 
			
			// Send content in proper format
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              
			
			// Set Request Type 
			// (you'll need to change this depending on what you're doing)
			//curl_setopt($curl,CURLOPT_HTTPGET, 1);
			curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
			// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
			// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
			
			// To send parameters (data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_create_sale);
			
			
			// Return the transfer as a string
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
			// $output contains the output string
			$output = curl_exec($curl);
			
			// Close cURL resource to free up system resources
			curl_close($curl);
			
			$xml = simplexml_load_string($output);
			
	
			
			$saleID = $xml->xpath('//saleID');
			foreach($saleID as $si)
			{
				$sale_id= $si;
			}
	
			$data=array(
					'lightspeed_order_id' => $si,
					'lightspeed_date' => date('Y-m-d H:i:s')
				);
			if($i>0){	
			$this->Lightspeed_model->update($orders['id'],$data);}
			
		}
	
		
	}
	
	function conf_success()
	{
		$order_id = '';
		if($this->session->userdata('recent_order_id')){
			$order_id = $this->session->userdata('recent_order_id');
			/* 
				in future clear recent_order_id  
				but doing so will prevent the order being displayed to the user if they refresh the page
			*/	
		}
		#$order_id = 1511;
		$this->set_order($order_id);
		$this->send_giftcard();
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
		$data['page_title'] = "Confirmation - Successful Order";
		
		$order = $this->Order_model->identify($order_id);
		$data['order'] = $order;
		$data['carts'] = $this->Cart_model->all($order['session_id']);
		$this->load->view('common/header',$data);
		
		$this->load->view('store/conf_success');
		$this->load->view('common/footer');
	}

	function check_valid_shipping_country()
	{
		$name = $_POST['name'];
		
		$id = $this->System_model->get_country_id_by_name($name);
		
		$result = $this->System_model->check_valid_shipping_country($id);
		
		echo $result;
	}
	
	function account_page($temp=0)
	{		
		if($this->session->userdata('userloggedin')==1)
		{
			redirect('store_admin/account_page');	
		}
		
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
		$data['page_title'] = "Your Account Detail";
		
		$user = $this->session->userdata('userloggedin');
		$cust = $this->Customer_model->identify($user['customer_id']);
		$data['cust'] = $cust;
		$data['states'] = $this->System_model->get_states();
		$data['state'] = $this->System_model->get_state($cust['state']);
		$data['countries_all'] = $this->System_model->get_shipping_countries();		
		$data['temp']=$temp;
		$this->load->view('common/header',$data);
		
		$this->load->view('store/account_page');
		$this->load->view('common/footer');
	}



	/* 
		If a customer chooses shipping as store pick up the the control is passed to  
		save_store_pickup Controller
	*/
	function save_account_page()
	{
		
		if($_POST['input-spostcode']==''|| $_POST['input-scountry']!=13){$methods = $this->System_model->get_shippings_country_state($_POST['input-scountry'],$_POST['input-sstate']);
			
		}
		
		else{
			
			$methods = $this->System_model->get_shippings_country_state_suburb($_POST['input-scountry'],$_POST['input-sstate'],$_POST['input-spostcode']);
		}
			
		if(count($methods)>0){$out=1;}else{$out=-1;}	
		
		if($out==-1){
			redirect(base_url().'store/account_page/1');
		}
		else
		{
			// echo 123;
		// exit;		
			$title = $_POST['input-stitle'];
			$firstname = $_POST['input-sfirstname'];
			$lastname = $_POST['input-slastname'];
			$address = $_POST['input-saddress'];
			$address2 = $_POST['input-saddress2'];
			$suburb = $_POST['input-ssuburb'];
			$country = $_POST['input-scountry'];
			$state = $_POST['input-sstate'];
			$postcode = $_POST['input-spostcode'];
			
			
			$data= array(			
				'session_id'=>$this->session->userdata('session_id'),
				'stitle'=>$title,
				'sfirstname'=>$firstname,
				'slastname'=>$lastname,
				'saddress'=>$address,
				'saddress2'=>$address2,
				'ssuburb'=>$suburb,
				'scountry'=>$country,
				'sstate'=>$state,
				'spostcode'=>$postcode			
			);
			$check=$this->Order_model->get_txn_session($this->session->userdata('session_id'));
			if(count($check)>0){
				$this->Order_model->update_paypal_txn($this->session->userdata('session_id'),$data);
			}else{
				$this->Order_model->add_paypal_txn($data);
			}
			
			$this->session->set_userdata('stitle',$title);
			$this->session->set_userdata('sfirstname',$firstname);
			$this->session->set_userdata('Slastname',$lastname);
			$this->session->set_userdata('saddress',$address);
			$this->session->set_userdata('saddress2',$address2);
			$this->session->set_userdata('ssuburb',$suburb);
			$this->session->set_userdata('scountry',$country);
			$this->session->set_userdata('sstate',$state);
			$this->session->set_userdata('spostcode',$postcode);
			
			# unset store pickup
			if($this->session->userdata('store_pickup')){
				$this->session->unset_userdata('store_pickup');
			} 
			
			redirect(base_url().'cart/checkout');
		}
	}
	
	# set as store pick up
	/*
		We are not doing anything special here,
		Just setting up the shipping address as store location
		and set $this->session->unset_userdata('store_pickup',true);
	*/
	function save_store_pickup()
	{
		if(! $this->session->userdata('userloggedin')){
			redirect('store/signin');
		}
		 
		 $cmp_profile = $this->Company_profile_model->get_profile();
		 $sess_cust = $this->session->userdata('userloggedin');
		 $customer = $this->Customer_model->identify($sess_cust['id']);
		
		 $title = $customer['title'];
		 $firstname = $customer['firstname'];
		 $lastname = $customer['lastname'];
		 $address = $cmp_profile['address1'];
		 $address2 = $cmp_profile['address2'];
		 $suburb = $cmp_profile['suburb'];
		 $country = $cmp_profile['country_id'];
		 $state = $cmp_profile['state_id'];
		 $postcode = $cmp_profile['postcode'];
		
		 $data= array(			
				'session_id'=>$this->session->userdata('session_id'),
				'stitle'=>$title,
				'sfirstname'=>$firstname,
				'slastname'=>$lastname,
				'saddress'=>$address,
				'saddress2'=>$address2,
				'ssuburb'=>$suburb,
				'scountry'=>$country,
				'sstate'=>$state,
				'spostcode'=>$postcode			
			);
		  
		  $check=$this->Order_model->get_txn_session($this->session->userdata('session_id'));
		  if(count($check)>0){
			  $this->Order_model->update_paypal_txn($this->session->userdata('session_id'),$data);
		  }else{
			  $this->Order_model->add_paypal_txn($data);
		  }
		  
		  $this->session->set_userdata('store_pickup',true);
		  $this->session->set_userdata('stitle',$title);
		  $this->session->set_userdata('sfirstname',$firstname);
		  $this->session->set_userdata('Slastname',$lastname);
		  $this->session->set_userdata('saddress',$address);
		  $this->session->set_userdata('saddress2',$address2);
		  $this->session->set_userdata('ssuburb',$suburb);
		  $this->session->set_userdata('scountry',$country);
		  $this->session->set_userdata('sstate',$state);
		  $this->session->set_userdata('spostcode',$postcode);
		  
		  # use this data to identify that it is a store pick up in later stages of the checkout process
		  $this->session->set_userdata('store_pickup','Store Pickup');
		  
		  redirect(base_url().'cart/checkout');
	}

	function send_giftcard()
	{
		$ndate = date('Y-m-d');
		$list = $this->Cart_model->get_giftcard($ndate);
	
		foreach($list as $l)
		{
			$product = $this->Product_model->identify($l['product_id']);
			$hero = $this->Product_model->get_hero($product['id']);
			if($hero)
			{
				$img = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb1/'.$hero['name'];
			}
			else
			{
				$img = 'http://placehold.it/472x515';
			}
			$to_date = date('d/m/Y',strtotime('+1 year',strtotime($l['send_on'])));
			$msg = '<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; color: #403c3c; font-family: times; border-top: 5px solid #000">
						<tr>
							<td>
							</td>
						</tr>
					</table>
					<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; background: #faf8f6; color: #403c3c; font-family: times; font-style: italic">
					<tr>
						<td style="padding: 10px; width: 50%">
							<img style="width:100%" src="'.$img.'"/>
						</td>
						<td style="padding: 30px; width: 50%; vertical-align: top">
							
							<p>
							Dear '.$l['gift_to'].',<br/>
							<br/>
							'.$l['gift_notes'].'<br/>
							<br/>
							</p>
							<p style="text-align: left">
							'.$l['gift_from'].'
							</p>
							<br/>
							<br/>
							<p style="font-style: normal">
								GIFT AMOUNT<br/>
								<span style="font-weight: 700; font-size: 18px;">AU $ '.number_format($l['price'],2,'.',',').'</span><br/>
								<br/>
								ENTER CODE AT CHECKOUT<br/>
								<span style="font-weight: 700; font-size: 18px; text-transform: none;">'.$l['gift_code'].'</span><br/>
								<br/>
								VALID UNTIL<br/>
								<span style="font-weight: 700; font-size: 18px;">'.$to_date.'</span>
							</p>
						</td>
					</tr>
				</table>
				<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; color: #403c3c; font-family: times; ">
					<tr>
						<td>
							Dear '.$l['gift_to'].',<br/>
							<br/>
							'.$l['gift_from'].' has sent you a gift voucher to spend on something special from Bared Footwear. Your gift voucher can be redeemed in-store, online at <a href="'.base_url().'">www.bared.com.au</a> or by calling us on (03) 9509 5771.<br/>
							<br/>
							Now you just need to choose your gift, wait for your delivery, and enjoy!<br/><br/>
							xo Bared Footwear<br/>
							<br/>
							<br/>
							<span style="font-weight: 700">HOW TO REDEEM YOUR GIFT VOUCHER</span><br/>
							Your gift voucher has a unique code, which is required to \'pay\' for your item. <br/>
							<ol>
								<li>Go to <a href="'.base_url().'">www.bared.com.au</a></li>
								<li>Select the item you wish to purchase.</li>
								<li>Add to Shopping Bag.</li>
								<li>To purchase, go to your Shopping Bag, located in the top right of the screen, and follow the prompts. You will be required to sign in or register with us, and we will also ask you for a \'billing address\', even though you may not be required to pay any extra for your item. If there is an outstanding balance, you will be required to give your credit card details also.</li>
								<li>When you get to the ORDER SUMMARY page, you will need to add your gift voucher code into the area allocated and select UPDATE.</li>
								<li>Follow the prompts through to place your order.</li>
								<li>Wait for your delivery to arrive!</li>
							</ol>
							<br/>
							If there is a difference between the gift voucher amount and the order total you\'ll need to enter additional payment details (credit card or PayPal).<br/><br/>
							If there is an amount left over, it will remain available on your gift voucher for future use.<br/><br/>
							Gift vouchers are valid for 12 months from the date of purchase and can only be used in the Bared Footwear.<br/>
						</td>
					</tr>
				</table>
				
				<table cellspacing="0" cellpadding="0" width="630" align="center" style="margin-top: 20px">			
					<tr>
						<td style="width:630px; height:45px; line-height:45px; text-align:center; color:#5b5758">
							<a href="'.base_url().'"><img alt="" src="'.base_url().'img/email-link-footer.png"/></a>
						</td>
						
					</tr>
				</table>
				<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; color: #403c3c; font-family: times; border-top: 5px solid #000">
					<tr>
						<td>
						</td>
					</tr>
				</table>';
				
			#echo $msg;exit;
			
			$this->load->library('email');
			$config['mailtype'] = 'html';	
			$this->email->initialize($config);	
			$this->email->from('noreply@bared.com.au','Bared Footwear');
			$this->email->to($l['gift_email']);
			#$this->email->bcc('raquel@propagate.com.au');
			
			$this->email->subject('Bared Footwear - Gift Voucher @ Bared Footwear');
			$this->email->message($msg);
			$sent = $this->email->send();
		}
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
		
		
		
		$gift_card = $this->session->userdata('sgift_card');
		$subtotal = $this->session->userdata('ssubtotal');
		$coupon_code = $this->session->userdata('scoupon_code');
		$discount = $this->session->userdata('sdiscount');
		$member_discount = $this->session->userdata('smember_discount');
		$tax = $this->session->userdata('stax');
		$shipping_cost = $this->session->userdata('sshipping_cost');
		
		if($this->session->userdata('store_pickup')){
			$shipping_method = 0;
		}else{
			$shipping_method = $this->session->userdata('sshipping_method');
		}
		
		$shipping_weight = $this->session->userdata('sshipping_weight');
		$shipping_weight_method = $this->session->userdata('sshipping_weight_method');
		$weight = $this->session->userdata('sweight');
		$cost_weight = $this->session->userdata('scost_weight');
		$cost_flat = $this->session->userdata('scost_flat');
		$total = $this->session->userdata('stotal');
		
		$cardtype = $this->input->post('cardtype',true);
		$cardnumber = $this->input->post('cardnumber',true);
		$cardname = $this->input->post('cardname',true);
		$expmonth = $this->input->post('expmonth',true);
		$expyear = $this->input->post('expyear',true);
		$cvvnumber = $this->input->post('cvvnumber',true);
		
		
		
		$gift = $this->input->post('gift',true);
		
		if($gift == 'Y')
		{
			$gift_bg = $this->input->post('ecard_no',true);
			$yname = $this->input->post('yname',true);
			$rname = $this->input->post('rname',true);
			$remail = $this->input->post('remail',true);
			$send_gift = $this->input->post('send_gift',true);
			$gnote = $this->input->post('gnote',true);
		}
		else
		{
			$gift_bg = '';
			$rname = '';
			$remail = '';
			$send_gift = '';
			$gnote = '';
			$gift = 'N';
			$yname = '';
		}
		
		$user = $this->session->userdata('userloggedin');
		
		/* store user login details for future use */
		$user_id = $user['customer_id'];
		
		$cust = $this->Customer_model->identify($user['customer_id']);
		
		$cstate = $this->System_model->get_state($cust['state']);
		
		$session_id = $this->session->userdata('session_id');
		
		$data = array(
				'customer_id' => $cust['id'],
				'session_id' => $session_id,
				'order_time' => date('Y-m-d H:i:s'),
				'subtotal' => $subtotal,
				'coupon_code' => $coupon_code,
				'discount' => $discount,
				'member_discount' => $member_discount,
				'tax' => $tax,
				'gift_card' => $gift_card,
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
				'message' => $msg,
				'cardname' => $cardname,
				'cardtype' => $cardtype,
				'cardnumber' => "***".substr($cardnumber,12),
				'expmonth' => $expmonth,
				'expyear' => $expyear,
				'gift' => $gift,
				'gift_bg' => $gift_bg,
				'gift_sender' => $yname,
				'receipt_name' => $rname,
				'receipt_email' => $remail,
				'send_on' => date('Y-m-d',strtotime($send_gift)),
				'order_status' => 'processed',
				'gift_notes' => $gnote
			);
		
		# if order is set as Pick up from store	
		if($this->session->userdata('store_pickup')){
			$data['store_pickup'] = 1;
		}		
			
		#echo '<pre>' . print_r($data,true) . '</pre>';exit;
		$order_id = $this->Order_model->add($data);
		#exit;
		//$this->updatestock($order_id);
		//$total = $total * 100;
		$total = money_format('%i',$total);
		$total = str_replace('.','',$total); # Money in cent
		//$response = $this->process_eWay($order_id,$firstname,$lastname,$customer['email'],$address.','.$city.' '.$state,$postcode,$cardname,$cardnumber,$expmonth,$expyear,$cvv,$total);
		$response = "false";

		if (floatval($total) > 0)
		{
			//echo "test";
		  $response = $this->process_eWay($order_id,$cust['firstname'],$cust['lastname'],$cust['email'],$cust['address'].','.$cust['suburb'].' '.$cstate,$cust['postcode'],$cardname,$cardnumber,$expmonth,$expyear,$cvvnumber,$total);
		  //print_r($response);
		}
		else
		{
		   $response = 'no_charge';
		}
		
		if($response=='no_charge')
		{
			$this->send_order_confirmation($order_id);
			$this->send_order_notification($order_id);
			//$this->send_giftcard();
			$this->Order_model->update($order_id,array('status' => 'successful','order_status'=>'processed','msg' => 'No Charge'));
			$user = $this->session->userdata('userloggedin');
			
			$this->session->destroy();
			
			// update stock
			$this->updatestock($order_id);
			//redirect('store/pathway/'.$user['id'].'/'.$order_id);
			//redirect(base_url().'cart/conf_success/'.$order_id);
			redirect('cart/payment_successful/'.$user_id.'/'.$order_id);
		}
		//print_r($response);
		if (strtolower($response['EWAYTRXNSTATUS']) == "true") 
		{
			$today_date = date('Y-m-d');
			$send_gift = date('Y-m-d',strtotime($send_gift));
			
			if($today_date == $send_gift)
			{
				$this->send_ecard($order_id);
			}
			
			//$this->send_order_confirmation_trader($order_id);
			$this->send_order_confirmation($order_id);
			$this->send_order_notification($order_id);
			//$this->send_giftcard();
			$this->add_coupon_code($order_id);
			if($coupon_code!='')
			{
				$this->update_value_coupon($coupon_code,$discount);
			}
			$this->Order_model->update($order_id,array('status' => 'successful','order_status'=>'processed','msg' => $response['EWAYTRXNERROR']));
			//$this->Cart_model->update_by_session_id($session_id,array('sent' => 1));
			
			$user = $this->session->userdata('userloggedin');
			
			$this->session->destroy();
			
			// update stock
			$this->updatestock($order_id);
			//redirect('store/pathway/'.$user['id'].'/'.$order_id);
			//redirect(base_url().'cart/conf_success/'.$order_id);
			redirect('cart/payment_successful/'.$user_id.'/'.$order_id);
			
		} 
		else if(strtolower($response['EWAYTRXNSTATUS']) == "false") 
		{
			$this->Order_model->update($order_id,array('status' => 'failed','order_status'=>'failed','msg' => $response['EWAYTRXNERROR']));
			$this->session->set_userdata('response',$response['EWAYTRXNERROR']);
			
			//print_r($response);
			redirect('cart/conf_unsuccess');
		}
		
	}
	
	/* 
		private function which takes the user session data 
		this done to preserve the login info of the user
	 */
	function payment_successful($user_id,$order_id='')
	{		
		//get user and repopulate userloggedin session variable
		$user = $this->User_model->id($user_id);
		if($user){
			$this->session->set_userdata('userloggedin',$user);
		}
		if($order_id){
			$this->session->set_userdata('recent_order_id',$order_id);	
		}
		redirect(base_url().'cart/conf_success');
	}
	
	function save_note_b4_paypal()
	{
		$msg = $this->input->post('pmsg',true);
		if($msg){
			$this->session->set_userdata('order_note',$msg);
		}
		echo 'ok';
	}
	
	# Implement new Paypal REST API
	function paypal()
	{
		# Add order and mark it as pending
		$this->_add_order_b4_paypal();
		#ini_set('display_startup_errors',1); ini_set('display_errors',1); error_reporting(-1);
		$this->load->library('paypal_rest');

		$payer = $this->paypal_rest->getPayer();
		$payer->setPaymentMethod('paypal');

		$currency = 'AUD';

		# Now get all items in the cart
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		#echo '<pre>' . print_r($cart,true) . '</pre>';exit();
		#var_dump($cart); die();


		$items = array();

		$subtotal = 0;
		$total_tax = 0;
		foreach($cart as $product_item)
		{
			$product = $this->Product_model->identify($product_item['product_id']);
			$item = $this->paypal_rest->getItem();

			# Paypal need the price excluding tax
			$ex_tax_price = round($product_item['price'] * 10/11, 2);
			$item->setName($product['title'])
					->setCurrency($currency)
					->setQuantity($product_item['quantity'])
					->setPrice($ex_tax_price);
			$items[] = $item;

			# We want to get the subtotal excluding tax
			$subtotal += $product_item['quantity'] * $ex_tax_price;
			# We also want to get the tax
			#$total_tax += round($product_item['price']/11, 2);
		}

		# Now we deal with discount, consider as item with negative price
		# Discount
		$discount = $this->session->userdata('sdiscount');
		if ($discount)
		{
			$discount = $discount * (-1);

			# Must take the tax out of discount as well
			$ex_tax_price = round($discount * 10/11, 2);
			$discount_item = $this->paypal_rest->getItem();
			$discount_item->setName('Coupons')
							->setCurrency($currency)
							->setQuantity(1)
							->setPrice($ex_tax_price);

			$subtotal += $ex_tax_price;
			#$total_tax += round($discount/11, 2);
			$items[] = $discount_item;
		}
		# Member Discount
		$discount = $this->session->userdata('smember_discount');
		if ($discount)
		{
			$discount = $discount * (-1);

			# Must take the tax out of discount as well
			$ex_tax_price = round($discount * 10/11, 2);
			$discount_item = $this->paypal_rest->getItem();
			$discount_item->setName('Member Discounts')
							->setCurrency($currency)
							->setQuantity(1)
							->setPrice($ex_tax_price);

			$subtotal += $ex_tax_price;
			#$total_tax += round($discount/11, 2);
			$items[] = $discount_item;
		}


		$itemList = $this->paypal_rest->getItemList();
		$itemList->setItems($items);

		$shipping_cost = round($this->session->userdata('sshipping_cost'),2);

		# Deduct tax from shipping cost
		$shipping_tax = round($shipping_cost/11, 2);
		$shipping_cost = $shipping_cost - $shipping_tax;

		$total_tax = $subtotal * 0.1 + $shipping_tax;
		$total = $subtotal + $total_tax + $shipping_cost;

		$details = $this->paypal_rest->getDetails();
		$details->setShipping($shipping_cost)
				->setTax($total_tax)
				->setSubtotal($subtotal);
		#var_dump($details);

		$amount = $this->paypal_rest->getAmount();
        $amount->setCurrency($currency)
                ->setTotal($total)
                ->setDetails($details);
        #var_dump($amount); die();
        $transaction = $this->paypal_rest->getTransaction();
        $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Bared Footwear Paypal")
                ->setInvoiceNumber(uniqid());

        $redirectUrls = $this->paypal_rest->getRedirectUrls();
        #$redirectUrls->setReturn_url(base_url() . "cart/paypal_response?success=true");
        #$redirectUrls->setCancel_url(base_url(). "cart/paypal_response?success=false");
	    $redirectUrls->setReturnUrl(base_url() . "cart/paypal_response?success=true");
        $redirectUrls->setCancelUrl(base_url(). "cart/paypal_response?success=false");
		
        $payment = $this->paypal_rest->getPayment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        #$payment->setRedirect_urls($redirectUrls);
	    $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));
        #var_dump($payment); die();
        $mode = PAYPAL_MODE;
		$apiContext = $this->paypal_rest->getApiContext($mode);
		#var_dump($apiContext); die();

		$request = clone $payment;
		#$a = $payment->create($apiContext);

		try {
		    $payment->create($apiContext);
		} catch (Exception $ex) {
			redirect('cart/paypal_connection_failed');
			#var_dump($ex);exit;
		    #ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
		    #exit(1);
		    #echo '<pre>';print_r(json_decode($ex->getData()));exit;
		}

		foreach ($payment->getLinks() as $link) {
		    if ($link->getRel() == 'approval_url') {
		        $approvalUrl = $link->getHref();
		        break;
		    }
		}

		#ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

		header("Location: $approvalUrl");
		#var_dump($approvalUrl);
		#return $payment;
	}

	function paypal_connection_failed()
	{
		
		$session_id = $this->session->userdata('session_id');
		$order = $this->Order_model->get_paypal_order_by_session_id($session_id);
		
		if($order){
			$data = array(
				'order_status' => 'deleted',
				'payment_status' => 'Cancelled'
			);
			#var_dump($data);
			$this->Order_model->update($order['id'],$data);
		}
		
		if( ! $this->session->userdata('cur_sign'))
		{
			$data['sign'] = '<span style="font-size:12px">AU</span> $';
			$data['cur_val'] = 1;
		}
		else 
		{
			$data['sign'] = $this->session->userdata('cur_sign');
			$data['cur_val'] = $this->session->userdata('cur_val');
		}
		
		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
	
		$data['page_title'] = "Paypal Connection Error";
		
		$this->load->view('common/header',$data);
		
		$this->load->view('store/paypal_connection_failed');
		$this->load->view('common/footer');
	}

	function paypal_response()
	{
		$result = $_REQUEST['success'];
		$paymentId = $_REQUEST['paymentId'];
		$token = $_REQUEST['token'];
		$payerId = $_REQUEST['PayerID'];

		$session_id = $this->session->userdata('session_id');
		$order = $this->Order_model->get_paypal_order_by_session_id($session_id);

		if ($result == 'false')
		{
			$data = array(
				'order_status' => 'failed',
				'payment_status' => 'Cancelled'
			);
			#var_dump($data);
			$this->Order_model->update($order['id'],$data);
		}
		else
		{
			$this->load->library('paypal_rest');
			$saleId = $this->paypal_rest->executePayment(PAYPAL_MODE, $paymentId, $payerId);

			$order_id = $order['id'];

			$today_date = date('Y-m-d');
			$send_gift = date('Y-m-d',strtotime($send_gift));

			if($today_date == $send_gift)
			{
				$this->send_ecard($order_id);
			}

			$this->add_coupon_code($order_id);
			if($order['coupon_code']!='')
			{
				$this->update_value_coupon($order['coupon_code'],$order['discount']);
			}
			$this->session->set_userdata('orderID',$order_id);
			#$order_id = $this->session->userdata('orderID');

			$txn_paypal=$this->Order_model->get_txn($session_id);

			$data_order = array(
					'order_status' => 'processed',
					'status' => 'successful',
					'txn_id' => $saleId,
					'txn_type' => 'cart',
					'payment_date' => date('Y-m-d H:i:s'),
					'payment_gross' => '',
					'payment_status' => 'Completed',
					'msg' => 'Paypal',
					'send_on' => $txn_paypal['send_gift']
				);

			#var_dump($data_order); die();
			$this->Order_model->update($order_id,$data_order);
			$user = $this->session->userdata('userloggedin');

			#$this->session->destroy();
			// update stock
			$this->updatestock($order_id);
		}
		$this->success();
	}
	
	# Old Paypal API
	function _paypal_old()
	{
		
		$this->load->library('paypal_class');
		//$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
		$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
		$this->paypal_class->add_field('currency_code', 'AUD');
		//$this->paypal_class->add_field('business', $this->config->item('bussinessPayPalAccountTest'));
		$this->paypal_class->add_field('business', $this->config->item('bussinessPayPalAccount'));
	
		$this->paypal_class->add_field('return', base_url().'cart/success'); // return url
		$this->paypal_class->add_field('rm', 2); // return url	
		$this->paypal_class->add_field('cbt', "Return to The Store"); // return url					
		//$this->paypal_class->add_field('return', base_url().'order/validatePaypal'); // return url		
		$this->paypal_class->add_field('cancel_return', base_url().'cart/cancel_paypal'); // cancel url
		$this->paypal_class->add_field('notify_url', base_url().'cart/validatePaypal'); // notify url
		//$totalPrice = $this->session->userdata('totalPrice');
		$totalPrice=10;
		
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		$user = $this->session->userdata('userloggedin');
		$i=1;
		$item_num = count($cart);
		
		$v_tot=0;
		$disc=0;
		$disc = $this->session->userdata('sdiscount') + $this->session->userdata('smember_discount');
		$disc_step=-1;
		
		if($item_num==1)
		{
												
			foreach($cart as $item) {
				$product= $this->Product_model->identify($item['product_id']);
				# If Discount same as itemprice or greater than that
				if($disc>=$item['price']){
					
					$this->paypal_class->add_field('item_name_'.$i, $product['title'].'+ Shipping ($'.round($this->session->userdata('sshipping_cost'),2).')' );
					$prices=$item['price']+round($this->session->userdata('sshipping_cost'),2);
					$this->paypal_class->add_field('amount_'.$i, $prices );
					$this->paypal_class->add_field('quantity_'.$i, $item['quantity']);
				}
				else
				{
					$this->paypal_class->add_field('item_name_'.$i, $product['title']);
					$prices=$item['price'];
					$this->paypal_class->add_field('amount_'.$i, $prices );
					$this->paypal_class->add_field('quantity_'.$i, $item['quantity']);
					$this->paypal_class->add_field('shipping_1', round($this->session->userdata('sshipping_cost'),2));
				}
			}
			$this->paypal_class->add_field('discount_amount_cart',round($disc,2) );
			$v_tot=1;
		}else{						
			if($disc>=$this->session->userdata('ssubtotal'))
			{
				$prodtext='';
				foreach($cart as $item) {	
					$product= $this->Product_model->identify($item['product_id']);
					$prodtext=$prodtext.$product['title'].' ('.$item['quantity'].' $'.$item['price'].')'.'; ';
					$amn+=$item['quantity']*$item['price'];
				}
				$this->paypal_class->add_field('item_name_'.$i, $prodtext.' + Shipping ($'.round($this->session->userdata('sshipping_cost'),2).')' );
				$prices=$amn+round($this->session->userdata('sshipping_cost'),2);
				$this->paypal_class->add_field('amount_'.$i, $prices );
				$this->paypal_class->add_field('quantity_'.$i, 1);
				$disc_step =$i;
			}else
			{
				foreach($cart as $item) {			
					$product= $this->Product_model->identify($item['product_id']);
					$this->paypal_class->add_field('item_name_'.$i, $product['title']);
					$this->paypal_class->add_field('amount_'.$i, $item['price']);
					$this->paypal_class->add_field('quantity_'.$i, $item['quantity']);
					$prices=$item['price'];
					
					if($v_tot==0 )
					{
						if($i==$item_num){					
							//$this->paypal_class->add_field('discount_amount_'.$i,round($disc,2));
							$this->paypal_class->add_field('shipping_'.$i, round($this->session->userdata('sshipping_cost'),2));
							//$this->paypal_class->add_field('tax_'.$i,-round($this->session->userdata('stax'),2));
						}
						else
						{
							
							$this->paypal_class->add_field('shipping_'.$i, 0);
							//$this->paypal_class->add_field('tax_'.$i,0);
						}
					}
					if(($item['price']*$item['quantity'])>round($disc,2)){$disc_step=$i;}
					$i++;
				}
			}
		}
		if($v_tot==0 ){
			//$this->paypal_class->add_field('discount_amount', 0);
			//$this->paypal_class->add_field('discount_amount2', round($disc,2));
			if($disc_step>-1){
				$this->paypal_class->add_field('discount_amount_'.$disc_step,round($disc,2) );
			}
			else
			{
				$this->paypal_class->add_field('discount_amount_cart',round($disc,2) );
				//$this->paypal_class->add_field('shipping_'.$i, 0);
				//$this->paypal_class->add_field('item_name_'.$i, 'Shipping');				
				//$this->paypal_class->add_field('amount_'.$i, round($this->session->userdata('sshipping_cost'),2));
				//$this->paypal_class->add_field('quantity_'.$i, 1);
				//$this->paypal_class->add_field('discount_amount_'.$i,round($disc,2) );
			}
		}
		
		$this->paypal_class->add_field('SHIPTOFIRSTNAME', $this->session->userdata('sfirstname'));
		$this->paypal_class->add_field('SHIPTOLASTNAME', $this->session->userdata('Slastname'));
		$this->paypal_class->add_field('SHIPTOCITY', $this->session->userdata('ssuburb'));
		$this->paypal_class->add_field('SHIPTOSTATE', $this->session->userdata('sstate'));
		$this->paypal_class->add_field('SHIPTOCOUNTRY', $this->session->userdata('scountry'));
		$this->paypal_class->add_field('SHIPTOSTREET', $this->session->userdata('saddress'));
		$this->paypal_class->add_field('SHIPTOZIP', $this->session->userdata('spostcode'));
		
		
		$this->paypal_class->add_field('custom', $this->session->userdata('session_id'));
		
		
		# Add order and mark it as pending
		$this->_add_order_b4_paypal();
		
		
		//$this->paypal_class->dump_fields();	  // for debugging, output a table of all the fields
		$this->paypal_class->submit_paypal_post(); // submit the fields to paypal
		//$this->paypal_class->dump_fields();	  // for debugging, output a table of all the fields
		//exit;
		
		/*
		foreach($cart as $item) {
		
			$product= $this->Product_model->identify($item['product_id']);
			$this->paypal_class->add_field('item_name_'.$i, $product['title']);
			//$this->paypal_class->add_field('item_number_'.$i, $product['id']);
			$this->paypal_class->add_field('amount_'.$i, $item['price']);
			$this->paypal_class->add_field('quantity_'.$i, $item['quantity']);
			if($i==$item_num){
				$this->paypal_class->add_field('discount_amount_'.$i, $this->session->userdata('sdiscount'));
				$this->paypal_class->add_field('shipping_'.$i, $this->session->userdata('sshipping_cost'));
				$this->paypal_class->add_field('tax_'.$i,$this->session->userdata('stax'));
			}
			else
			{
				$this->paypal_class->add_field('discount_amount_'.$i, 0);
				$this->paypal_class->add_field('shipping_'.$i, 0);
				$this->paypal_class->add_field('tax_'.$i,0);
			}
			$i++;
		}
		
		
		
		$this->paypal_class->add_field('SHIPTOFIRSTNAME', $this->session->userdata('sfirstname'));
		$this->paypal_class->add_field('SHIPTOLASTNAME', $this->session->userdata('Slastname'));
		$this->paypal_class->add_field('SHIPTOCITY', $this->session->userdata('ssuburb'));
		$this->paypal_class->add_field('SHIPTOSTATE', $this->session->userdata('sstate'));
		$this->paypal_class->add_field('SHIPTOCOUNTRY', $this->session->userdata('scountry'));
		$this->paypal_class->add_field('SHIPTOSTREET', $this->session->userdata('saddress'));
		$this->paypal_class->add_field('SHIPTOZIP', $this->session->userdata('spostcode'));
		//$this->paypal_class->add_field('item_name_'.$i, $this->session->userdata('scoupon_code'));
		//$this->paypal_class->add_field('item_number_'.$i, $this->session->userdata('scoupon_code'));
		//$this->paypal_class->add_field('amount_'.$i, $this->session->userdata('sdiscount'));
		
		//$this->paypal_class->add_field('discount_amount_cart', $this->session->userdata('sdiscount'));
		//$this->paypal_class->add_field('shipping', $this->session->userdata('sshipping_cost'));
		//$this->paypal_class->add_field('shipping2', $this->session->userdata('sshipping_cost'));
		//$this->paypal_class->add_field('tax',$this->session->userdata('stax'));
		$this->paypal_class->add_field('custom', $this->session->userdata('orderId'));
		
		$this->paypal_class->submit_paypal_post(); // submit the fields to paypal
		//$p->dump_fields();	  // for debugging, output a table of all the fields
		exit;*/
	}
	
	function pre_paypal()
	{
		$gift = $this->input->post('gift',true);
			
		if($gift == 'Y')
		{
			$gift_bg = $this->input->post('ecard_no',true);
			$rname = $this->input->post('rname',true);
			$remail = $this->input->post('remail',true);
			$send_gift = $this->input->post('send_gift',true);
			$gnote = $this->input->post('gnote',true);
			$yname = $this->input->post('yname',true);
			
			
		}
		else
		{
			$gift_bg = '-';
			$rname = '-';
			$remail = '-';
			$send_gift = '-';
			$gnote = '-';
			$gift = 'N';
			$yname='-';
		}
		
		$this->session->set_userdata('yname',$yname);
		$this->session->set_userdata('gift',$gift);
		$this->session->set_userdata('gift_bg',$gift_bg);
		$this->session->set_userdata('rname',$rname);
		$this->session->set_userdata('remail',$remail);
		$this->session->set_userdata('send_gift',$send_gift);
		$this->session->set_userdata('gnote',$gnote);
		
		# Add order and mark it as pending
		$this->_add_order_b4_paypal();
	}
	
	function cancel_paypal()
	{
		$this->_paypal_cancelled();
		redirect('cart/payment');
	}
	
	function _paypal_cancelled()
	{
		$session_id = $this->session->userdata('session_id');
		$order = $this->Order_model->get_paypal_order_by_session_id($session_id);
		if($order){
			$data = array(
				'order_status' => 'failed',
				'payment_status' => 'Cancelled'
			);
			$this->Order_model->update($order['id'],$data);
		}
	}
	
	
	function _add_order_b4_paypal()
	{
		$firstname = $this->session->userdata('sfirstname');
		$lastname = $this->session->userdata('Slastname');
		$address = $this->session->userdata('saddress');
		$address2 = $this->session->userdata('saddress2');
		$city = $this->session->userdata('ssuburb');
		$state = $this->session->userdata('sstate');
		$country = $this->session->userdata('scountry');
		$postcode = $this->session->userdata('spostcode');
		$msg = ''; //$this->input->post('pmsg',true);

		$subtotal = $this->session->userdata('ssubtotal');

		$coupon_code = $this->session->userdata('scoupon_code');
		$discount = $this->session->userdata('sdiscount');
		$member_discount = $this->session->userdata('smember_discount');			
		$tax = $this->session->userdata('stax');
		$shipping_cost = $this->session->userdata('sshipping_cost');
		
		if($this->session->userdata('store_pickup')){
			$shipping_method = 0;
		}else{
			$shipping_method = $this->session->userdata('sshipping_method');
		}
		
		if($this->session->userdata('order_note')){
			$msg = $this->session->userdata('order_note');	
		}

		$shipping_weight = $this->session->userdata('sshipping_weight');
		$shipping_weight_method = $this->session->userdata('sshipping_weight_method');
		$weight = $this->session->userdata('sweight');
		$cost_weight = $this->session->userdata('scost_weight');
		$cost_flat = $this->session->userdata('scost_flat');
		$total = $this->session->userdata('stotal');
												
		
		$gift='N';
		$gift_bg='-';
		$rname='-';
		$remail='-';
		$send_gift='-';
		$gnote='-';
		if($this->session->userdata('gift')=='Y'){
			$gift = $this->session->userdata('gift');
			$gift_bg = $this->session->userdata('gift_bg');
			$rname = $this->session->userdata('rname');
			$remail = $this->session->userdata('remail');
			$send_gift = $this->session->userdata('send_gift');
			$gnote = $this->session->userdata('gnote');
		}
		$user = $this->session->userdata('userloggedin');
		$cust = $this->Customer_model->identify($user['customer_id']);
		$user_id = $user['customer_id'];
		$cstate = $this->System_model->get_state($cust['state']);
		
		$session_id = $this->session->userdata('session_id');
		
		$data = array(
					'customer_id' => $cust['id'],
					'session_id' => $session_id,
					'order_time' => date('Y-m-d H:i:s'),
					'subtotal' => $subtotal,
					'coupon_code' => $coupon_code,
					'discount' => $discount,
					'member_discount' => $member_discount,
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
					'order_status' => 'pending',
					'payment_date' => date('Y-m-d H:i:s'),
					'payment_gross' =>$total,
					'payment_status' => 'processing',
					'message' => $msg,
					'gift' => $gift,
					'gift_bg' => $gift_bg,
					'receipt_name' => $rname,
					'receipt_email' => $remail,
					'send_on' => $send_gift,
					'gift_notes' => $gnote,
					'msg' => 'Paypal'
				);
			
		# if order is set as Pick up from store	
		if($this->session->userdata('store_pickup')){
			$data['store_pickup'] = 1;
		}
		
		$order_id = $this->Order_model->add($data);	
		$this->session->set_userdata('b4_paypal_order_id',$order_id);
	}
	
	/*function success()	
	{
		$this->load->library('paypal_class');
		$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
		//$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
		$data= $this->paypal_class->validate_ipn();
		
		
		
		if($data['payment_status']='Completed')
		{												
			
			
			$data_entry=array(				
				'txn_id' => 	$data['txn_id'],
				'txn_type' => 	$data['txn_type'],
				'payment_date' => 	$data['payment_date'],
				'payment_gross' => 	$data['payment_gross'],
				'payment_status' => 	$data['payment_status'],
				'custom' => $data['custom']
			);
			$this->Order_model->update_paypal_txn($data['custom'],$data_entry);
			
			$firstname = $this->session->userdata('sfirstname');
			$lastname = $this->session->userdata('Slastname');
			$address = $this->session->userdata('saddress');
			$address2 = $this->session->userdata('saddress2');
			$city = $this->session->userdata('ssuburb');
			$state = $this->session->userdata('sstate');
			$country = $this->session->userdata('scountry');
			$postcode = $this->session->userdata('spostcode');
			$msg = ''; //$this->input->post('pmsg',true);

			$subtotal = $this->session->userdata('ssubtotal');

			$coupon_code = $this->session->userdata('scoupon_code');
			$discount = $this->session->userdata('sdiscount');
			$member_discount = $this->session->userdata('smember_discount');			
			$tax = $this->session->userdata('stax');
			$shipping_cost = $this->session->userdata('sshipping_cost');
			$shipping_method = $this->session->userdata('sshipping_method');
			$shipping_weight = $this->session->userdata('sshipping_weight');
			$shipping_weight_method = $this->session->userdata('sshipping_weight_method');
			$weight = $this->session->userdata('sweight');
			$cost_weight = $this->session->userdata('scost_weight');
			$cost_flat = $this->session->userdata('scost_flat');
			$total = $this->session->userdata('stotal');
													
			
			$gift='N';
			$gift_bg='-';
			$rname='-';
			$remail='-';
			$send_gift='-';
			$gnote='-';
			if($this->session->userdata('gift')=='Y'){
				$gift = $this->session->userdata('gift');
				$gift_bg = $this->session->userdata('gift_bg');
				$rname = $this->session->userdata('rname');
				$remail = $this->session->userdata('remail');
				$send_gift = $this->session->userdata('send_gift');
				$gnote = $this->session->userdata('gnote');
			}
			$user = $this->session->userdata('userloggedin');
			$cust = $this->Customer_model->identify($user['customer_id']);
			$user_id = $user['customer_id'];
			$cstate = $this->System_model->get_state($cust['state']);
			
			$session_id = $this->session->userdata('session_id');
			$txn_id='';
			$txn_type='';
			$payment_date='';
			$payment_gross='';
			$payment_status='';
			
			$txn_paypal=$this->Order_model->get_txn($session_id);
			$txn_id=$txn_paypal['txn_id'];
			$txn_type=$txn_paypal['txn_type'];
			$payment_date=$txn_paypal['payment_date'];
			$payment_gross=$txn_paypal['payment_gross'];
			$payment_status=$txn_paypal['payment_status'];

			
			
			$data = array(
					'customer_id' => $cust['id'],
					'session_id' => $session_id,
					'order_time' => date('Y-m-d H:i:s'),
					'subtotal' => $subtotal,
					'coupon_code' => $coupon_code,
					'discount' => $discount,
					'member_discount' => $member_discount,
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
					'txn_id' =>$txn_id,
					'txn_type' =>$txn_type,
					'payment_date' =>$payment_date,
					'payment_gross' =>$payment_gross,
					'payment_status' =>$payment_status,
					
					'gift' => $gift,
					'gift_bg' => $gift_bg,
					'receipt_name' => $rname,
					'receipt_email' => $remail,
					'send_on' => $send_gift,
					'gift_notes' => $gnote,
					'msg' => 'Paypal'
				);
			

			$order_id = $this->Order_model->add($data);
			
			$today_date = date('Y-m-d');
			$send_gift = date('Y-m-d',strtotime($send_gift));
			
			if($today_date == $send_gift)
			{
				$this->send_ecard($order_id);
			}
			
			$this->add_coupon_code($order_id);
			if($coupon_code!='')
			{
				$this->update_value_coupon($coupon_code,$discount);
			}
			$this->session->set_userdata('orderID',$order_id);
			$order_id = $this->session->userdata('orderID');
			
			
			$this->Order_model->update($order_id,array('order_status'=>'processed','status' => 'successful','msg' => 'Paypal'));
			$user = $this->session->userdata('userloggedin');
			
			$this->session->destroy();
			//$this->send_order_notification_test($order_id);
			// update stock
			$this->updatestock($order_id);
			$this->send_order_confirmation($order_id);
			$this->send_order_notification($order_id);
			//$this->cart_reminder_test();
			redirect('cart/payment_successful/'.$user_id.'/'.$order_id);
		}else
		{
			redirect(base_url().'store/conf_unsuccess');

		}
			
			
			
	}*/
	
	function success()	
	{
												
		$session_id = $this->session->userdata('session_id');
		$order = $this->Order_model->get_paypal_order_by_session_id($session_id);
		$order_id = $order['id'];
		$user = $this->session->userdata('userloggedin');
		$user_id = $user['customer_id'];
		if($order['payment_status']=='Completed')
		{	
			$this->send_order_confirmation($order_id);
			$this->send_order_notification($order_id);	
			$this->session->destroy();										
			redirect('cart/payment_successful/'.$user_id.'/'.$order_id);
		}
		else
		{
			redirect(base_url().'cart/conf_unsuccess');
		}

	}
	
	# old paypal ipn validation 
	function validatePaypal() {
		
	
		$this->load->library('paypal_class');
		//$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
		$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
		$data= $this->paypal_class->validate_ipn();
		
		if($data!='INVALID')
		{												
			
			
			$data_entry=array(				
				'txn_id' => 	$data['txn_id'],
				'txn_type' => 	$data['txn_type'],
				'payment_date' => 	$data['payment_date'],
				'payment_gross' => 	$data['payment_gross'],
				'payment_status' => 	$data['payment_status'],
				'custom' => $data['custom']
			);
			$this->Order_model->update_paypal_txn($data['custom'],$data_entry);
			#update order
			$this->_update_paypal_order($data['custom']);
		}
		
		
	}
	
	function _update_paypal_order($session_id)
	{
		$order = $this->Order_model->get_paypal_order_by_session_id($session_id);
			
		$order_id = $order['id'];
		
		$today_date = date('Y-m-d');
		$send_gift = date('Y-m-d',strtotime($send_gift));
		
		if($today_date == $send_gift)
		{
			$this->send_ecard($order_id);
		}
		
		$this->add_coupon_code($order_id);
		if($order['coupon_code']!='')
		{
			$this->update_value_coupon($order['coupon_code'],$order['discount']);
		}
		$this->session->set_userdata('orderID',$order_id);
		#$order_id = $this->session->userdata('orderID');
		
		$txn_id='';
		$txn_type='';
		$payment_date='';
		$payment_gross='';
		$payment_status='';
		
		$txn_paypal=$this->Order_model->get_txn($session_id);
		$txn_id=$txn_paypal['txn_id'];
		$txn_type=$txn_paypal['txn_type'];
		$payment_date=$txn_paypal['payment_date'];
		$payment_gross=$txn_paypal['payment_gross'];
		$payment_status=$txn_paypal['payment_status'];
		
		$data_order = array(
				'order_status' => 'processed',
				'status' => 'successful',
				'txn_id' =>$txn_id,
				'txn_type' =>$txn_type,
				'payment_date' =>$payment_date,
				'payment_gross' =>$payment_gross,
				'payment_status' =>$payment_status,
				'msg' => 'Paypal'
			);
		
		$this->Order_model->update($order_id,$data_order);
		
	
	}
	
	function payment()
	{
		//echo $this->session->userdata('ssubtotal');
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
		
		$data['page_title'] = "Payment";
		
		
		$this->load->view('common/header',$data);
		
		$this->load->view('store/payment');
		$this->load->view('common/footer');
	}
	
	function list_cart() {
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
	
	function checktimeout(){
		$user = $this->session->userdata('userloggedin');
		if(count($user)>0){			
		}else{
			redirect('store');
		}
	}
	function add_coupon_code($order_id)
	{
		$orders=$this->Order_model->identify($order_id);
		$session_id = $orders['session_id'];
		$cart = $this->Cart_model->all($session_id);
		foreach($cart as $item) 
		{
			if($item['gift_card']==1)
			{
				$coupon_code = $item['gift_code'];
				$from_date = $item['send_on'];
				$to_date = date('Y-m-d',strtotime('+1 year',strtotime($from_date)));
				$value = $item['price'];
				$data=array(
				'name' => $coupon_code,
				'code' => $coupon_code,
				'permanent' => 0,
				'expirary'=>2,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'type' => 2,
				'value' => $value,
				'condition' => '0.00',
				'type_cond' => 2,
				'actived' =>1,
				'order' =>1,
				'created'=> date('Y-m-d H:i:s'),
				'modified' =>date('Y-m-d H:i:s')
				);
				$this->System_model->add_coupon($data);
			}
		}
	}
	function update_value_coupon($coupon_code,$value)
	{
		$coupon = $this->System_model->check_coupon_code($coupon_code);
		$current_value = $coupon['value'];
		if($coupon['order']==1)
		{
			$value= $current_value - $value;
			$data=array(
					'value' => $value
				);
			$this->System_model->update_coupon($coupon['id'],$data);
		}
	}

	
	function add_to_cart_giftcard()
	{
		$session_id = $this->session->userdata('session_id');
		$product_id = $this->input->post('id',TRUE);
		$sender = $this->input->post('sender',TRUE);
		$amount = $this->input->post('amount',TRUE);
		$recipient = $this->input->post('recipient',TRUE);
		$email = $this->input->post('email',TRUE);
		$send = $this->input->post('send',TRUE);
		$notes = $this->input->post('notes',TRUE);
		
		if($this->session->userdata('userloggedin'))
		{
			$user = $this->session->userdata('userloggedin');
			if($user==1){$customer_id = 1;}else{
				$customer_id = $user['customer_id'];
			}
		}
		else
		{
			$customer_id = 0;
		}
		
		//generate code
		$ndate = date('l jS \of F Y h:i:s:u A');
		//raw_code = session_id + g_card + current date for example Monday 8th of August 2005 03:12:46:00000 PM
		$raw_code = $session_id.'g_card'.$ndate;
		$enc_code = md5($raw_code);
		$code = 'SN'.substr($enc_code,0,3).substr($enc_code, -2);
		
		//echo $code;
		//exit;
		$product = $this->Product_model->identify($product_id);
		$stock_id = $product['stock_id'];
		
		$data = array(
			'session_id' => $session_id,
			'customer_id'=>$customer_id,
			'product_id' => $product_id,
			'price' => $amount,
			'quantity' => 1,
			'attributes' => '',
			'stock_id' => $stock_id,
			'order_id' => 0,
			'admin' => 0,
			'gift_card' => 1,
			'send_on' => date('Y-m-d',strtotime($send)),
			'gift_code' => $code,
			'gift_from' => $sender,
			'gift_to' => $recipient,
			'gift_email' => $email,
			'gift_notes' => $notes
		);
		
		$id = $this->Cart_model->add_cart_gift_card($data);
		
		if($id)
		{
			print "You have successfully added this item to your Shopping Bag.";
		}
		else
		{
			print "There was an error when trying to add product to your cart. Please try again later!";
		}
	}
	
	
	function addtocart() {
		$session_id = $this->session->userdata('session_id');
		$product_id = $this->input->post('product_id',TRUE);
		$quantity = 0;
		if(isset($_POST['quantity']))
		{
		$quantity = $this->input->post('quantity',TRUE);
		}
		else
		{
			$quantity = 1;
		}
		$product = $this->Product_model->identify($product_id);
		
		$user = $this->session->userdata('userloggedin');
		$this->checktimeout();
		
		if ($user['level'] == 2) 
		{
			if ($product['sale_price_trade'] > 0) 
			{ 
			$price = $product['sale_price_trade']; 
			}
			else { $price = $product['price_trade']; }
		} 
		else 
		{
			
			if ($product['sale_price'] > 0) 
			{ 
			$price = $product['sale_price']; 
			}
			else 
			{ 
			$price = $product['price']; 
			}
		}
		
		$attributes = $this->Product_model->get_attributes($product_id);
		$str = '';	
		//$temp = array();
		if(isset($_POST['attributes']))
		{
			/*
			$selected_attributes = explode('~',$_POST['attributes']);
		 //$s=explode(":",$_POST['attributes']);
		 //print_r($s);
		 for($i=0;$i<count($attributes);$i++) 
		 {
			if(!empty($_POST['attributes']))
			{
				$s=explode(":",$selected_attributes[$i]);
				
				$str .= $attributes[$i]['name'].':'.$s[1].'~';
			}
			else {
				$str .= $attributes[$i]['name'].':'.$attributes[$i]['options'][0].'~';
			}
		 }
		 */
		
		 $str =  $_POST['attributes'];
		 $get_attr = json_decode($str,true);
		 $size_text = $get_attr['Size'];
		 $p_stock_id = json_decode($product['size_stock_id'],true);
		 $stock_id = str_replace('#','',$p_stock_id[$size_text]);
		 //echo $stock_id;
		 //exit;
		 //print_r(json_decode($str));
		}
		else
		{
			 $temp = array();
			// in home page and category page
		  if($attributes != NULL)
		  {
			for($i=0;$i<count($attributes);$i++)
			{
				$options = $this->Product_model->get_attribute($attributes[$i]['id']);
				$temp = array(
				          $attributes[$i]['name'] => $options[0]
						  );
						  
			}
			//$str = json_encode($temp, JSON_FORCE_OBJECT);
			
		  }
		  if($product['multiplesize'] == 1)
	    	{
				//echo "in";
				//exit;
				$multiple_stock = json_decode($product['size'],true);
				foreach($multiple_stock as $key => $value)
				{
					if($multiple_stock[$key] > 0)
					{
			    	 $temp['Size'] = $key;
					 break;
					}
				}
			}
			$str = json_encode($temp, JSON_FORCE_OBJECT);
			$stock_id = $product['stock_id'];
		}

		if($this->session->userdata('userloggedin'))
		{
			$user = $this->session->userdata('userloggedin');
			if($user==1){$customer_id = 1;}else{
				$customer_id = $user['customer_id'];
			}
		}
		else
		{
			$customer_id = 0;
		}
		
		if($this->session->userdata('orderid'))
		{
			$orderid = $this->session->userdata('orderid');
		}
		else
		{
			$orderid = 0;
		}
		if($this->session->userdata('adminid'))
		{
			$adminid = $this->session->userdata('adminid');
		}
		else
		{
			$adminid = 0;
		}
		$data = array(
			'session_id' => $session_id,
			'customer_id'=>$customer_id,
			'product_id' => $product_id,
			'price' => $price,
			'quantity' => $quantity,
			'attributes' => $str,
			'stock_id' => $stock_id,
			'order_id' => $orderid,
			'admin' => $adminid
		);
		
		if($product['multiplesize'] == 0)
		{
			$status = $this->Cart_model->add_limited($data);
			if($status<=-2)
			{								
				print "We are sorry, this product is currently out of stock. If you would like to enquire about this product or any others please click here to <a href='".base_url()."store/page/38'>contact us</a>.";
			}
			else if ($status == -1) 
			{
				print "You have already added this product to your shopping basket. If you would like to increase the quantity <a href='".base_url()."store/cart'>click here</a>";
			} 
			else if ($status > 0) 
			{
				//print "You have successfully added $quantity products to your shopping basket";
				print "You have successfully added 1 product to your shopping basket";
			} 
			else 
			{
				print "There was an error when trying to add product to your cart. Please try again later!";
			}
		}
		else if($product['multiplesize'] == 1)
		{
			
			// do quantity check for each size if multiple size is checked
			$temp_str = json_decode($str,true);
			$multiple_stock = json_decode($product['size'],true);
			$size = $temp_str['Size'];
			if($multiple_stock[$temp_str['Size']] < $quantity)
			{
				#print "Sorry this item has low stock level in the size $size, so you just either lower the quantity or you still want to keep the amount you want to buy please contact us at ".COMPANY_SALES_EMAIL." to enquiry about the availability, please be sure to let us know how many units you require. We will be in contact shortly.";
				print "Sorry, this item is low in stock. Please reduce the quantity you’re adding to your cart";
			}
			else
			{
			  $status = $this->Cart_model->add_limited_special($data,$multiple_stock[$temp_str['Size']]);
			  if($status ==-2)
			  {		
			     #print "Sorry this item has low stock level in the size $size, so you just either lower the quantity or you still want to keep the amount you want to buy please contact us at ".COMPANY_SALES_EMAIL." to enquiry about the availability, please be sure to let us know how many units you require. We will be in contact shortly.";
				 print "Sorry, this item is low in stock. Please reduce the quantity you’re adding to your cart";
			  }
			  else if ($status == -1) 
			  {
				print "You have already added this product to your shopping basket. If you would like to increase the quantity <a href='".base_url()."cart/list_cart'>click here</a>";
			  } 
			  else if ($status > 0) 
			  {
				print "You have successfully added $quantity product to your shopping basket";
			  } 
			  else 
			  {
				print "There was an error when trying to add product to your cart. Please try again later!";
			  }
			}
			
		}
		
	}

	
	function removeitem() {
		$id = $_POST['id'];
		$this->Cart_model->delete($id);
	}
	
	function updateitems() {
		
		//$user = $this->session->userdata('userloggedin');
		$session_id = $this->session->userdata('session_id');
		$cart = $this->Cart_model->all($session_id);
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			$attributes = $this->Product_model->get_attributes($product['id']);
			$str = '';
			$stock_id = '';
			$quantity = $_POST['quantity-'.$item['id']];
			
			if($quantity > 0)
			{
				$valid = true;
				$temp = array();
				$name = $product['title'];
				if($product['multiplesize'] == 1)
				{
					
					$multiple_stock = json_decode($product['size'],true);
					$multiple_stock_id = json_decode($product['size_stock_id'],true);
					//print_r($multiple_stock_id);
					
					if($_POST['sizeproduct-'.$item['id']])
					{
						$size = $_POST['sizeproduct-'.$item['id']];
						//echo $size;
						//exit;
						if($multiple_stock[$_POST['sizeproduct-'.$item['id']]] < $quantity)
						{
							$valid = false;
							$message = "Sorry the item $name has low stock level in the size $size, so you just either lower the quantity or you still want to keep the amount you want to buy please contact us at sales@bared.com.au to enquiry about the availability, please be sure to let us know how many units you require. We will be in contact shortly.";
							$this->session->set_flashdata('error_product_quantity',$message);
							
						}
						else
						{
							$temp['Size'] = $_POST['sizeproduct-'.$item['id']];
							$stock_id = $multiple_stock_id[$_POST['sizeproduct-'.$item['id']]];
							$stock_id = str_replace('#','',$stock_id);
						}
					}
				}
				else
				{
					if($product['stock'] < $quantity)
					{
						$valid = false;
						$message = "Sorry the item $name has low stock level, so you just either lower the quantity or you still want to keep the amount you want to buy please contact us at sales@bared.com.au to enquiry about the availability, please be sure to let us know how many units you require. We will be in contact shortly.";
							$this->session->set_flashdata('error_product_quantity',$message);
							
					}
				}
				for($i=0;$i<count($attributes);$i++) 
				{
					//$str = $attributes[$i]['name'].':'.$_POST['attribute-'.$item['id'].'-'.$i].'~';
				
				    $options = $this->Product_model->get_attribute($attributes[$i]['id']);
					$temp = array(
					 $attributes[$i]['name'] =>  $_POST['attribute-'.$item['id'].'-'.$i]
					 );
							
				}
				$str = json_encode($temp, JSON_FORCE_OBJECT);
				
				$data = array(
					 'quantity' => $quantity,
					 'attributes' => $str,
					 'stock_id' => $stock_id
				);
				if($valid)
				{
				$this->Cart_model->update($item['id'],$data);
				}
			}
			else
			{
				$message = "Sorry, product quantity cannot less than 1";
				$this->session->set_flashdata('error_product_quantity',$message);
			}
		}
		redirect('cart/list_cart');
	}
	
	function status($result="") {
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
		if(!$this->session->userdata('userloggedin'))
		{
			redirect('store');
		}
		$data['result'] = $result;
		$data['page_title'] = "Order Status";
		$this->load->view('common/header',$data);
		//$this->load->view('common/leftbar');
		$this->load->view('store/status');
		$this->load->view('common/footer');
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
	function process_eWay($order_id,$firstname,$lastname,$email,$address,$postcode,$cardname,$cardnumber,$expmonth,$expyear,$cvv,$total) {
		
		# Payment config
		//$eWAY_CustomerID = "87654321"; // eWAY Customer ID for test
		//$eWAY_CustomerID = "17042327";
		//$eWAY_PaymentMethod = 'REAL_TIME_CVN'; // payment gatway to use (REAL_TIME, REAL_TIME_CVN or GEO_IP_ANTI_FRAUD)
		//$eWAY_UseLive = false; // true to use the live gateway
		
		$eWAY_CustomerID = "14612908";
		$eWAY_PaymentMethod = 'REAL_TIME_CVN'; // payment gatway to use (REAL_TIME, REAL_TIME_CVN or GEO_IP_ANTI_FRAUD)
		$eWAY_UseLive = true;
		
		$this->load->model('Eway_model');			
		$this->Eway_model->init($eWAY_CustomerID, $eWAY_PaymentMethod, $eWAY_UseLive);
		
		//$total = $total*100;//round($total);
		
		//echo $total;
		
		# Set the payment details
		$this->Eway_model->setTransactionData("TotalAmount", $total); //mandatory field
		$this->Eway_model->setTransactionData("CustomerFirstName", $firstname);
		$this->Eway_model->setTransactionData("CustomerLastName", $lastname);
		$this->Eway_model->setTransactionData("CustomerEmail", $email);
		$this->Eway_model->setTransactionData("CustomerAddress", $address);
		$this->Eway_model->setTransactionData("CustomerPostcode", $postcode);
		$this->Eway_model->setTransactionData("CustomerInvoiceDescription", "Bared Online Store");
		$this->Eway_model->setTransactionData("CustomerInvoiceRef", "INV".$order_id);
		$this->Eway_model->setTransactionData("CardHoldersName", $cardname); //mandatory field
		$this->Eway_model->setTransactionData("CardNumber", $cardnumber); //mandatory field
		$this->Eway_model->setTransactionData("CardExpiryMonth", $expmonth); //mandatory field
		$this->Eway_model->setTransactionData("CardExpiryYear", $expyear); //mandatory field
		$this->Eway_model->setTransactionData("TrxnNumber", "TRXN".$order_id);
		$this->Eway_model->setTransactionData("Option1", "");
		$this->Eway_model->setTransactionData("Option2", "");
		$this->Eway_model->setTransactionData("Option3", "");
		$this->Eway_model->setTransactionData("CVN", $cvv);
		$this->Eway_model->setCurlPreferences(CURLOPT_SSL_VERIFYPEER, 0); // Require for Windows hosting
						
		$ewayResponseFields = $this->Eway_model->doPayment();
		//print_r($ewayResponseFields);
			
		if (strtolower($ewayResponseFields["EWAYTRXNSTATUS"])=="false") {
			#return false;
			//$out = ''; #"Transaction Error: " . $ewayResponseFields["eWAYresponseText"] . "<br>\n";		
			//foreach($ewayResponseFields as $key => $value)
			//	$out .= "\n<br>\$ewayResponseFields[\"$key\"] = $value";
			//return $out;
			return $ewayResponseFields;
		}
		
		else if (strtolower($ewayResponseFields["EWAYTRXNSTATUS"])=="true") {
			#return true;
			//$out = ''; #"Transaction Success: " . $ewayResponseFields["eWAYresponseText"]  . "<br>\n";
			//foreach($ewayResponseFields as $key => $value)
			//	$out .= "\n<br>\$ewayResponseFields[\"$key\"] = $value";
			//return $out;
			return $ewayResponseFields;
		}
		else {
			print "Error: An invalid response was recieved from the payment gateway.";
			return;
		}		
	}
	function send_order_confirmation($order_id) {
		$order = $this->Order_model->identify($order_id);
		$cart = $this->Cart_model->all($order['session_id']);
		$cust = $this->Customer_model->identify($order['customer_id']);
		$products_info = '';
		$header='';
		$header .='
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
		<table width="630" align="center"><tr><td></td></tr>
			<tr>
				<td>
				<span style="font-family:Arial, sans-serif; font-size:18px; font-weight:400; ">
				Thank you for shopping with Bared. You should receive your shoes within four to eight working days (or often sooner!), and we hope you really love them.<br><br>
				
				If for any reason you\'re not completely happy, please call (03) 9509 5771 or email info@bared.com.au.<br><br>
				
				We\'ll happily send you another pair (or two!), at no cost to you, to help you compare sizes or styles, and we\'ll pay the return postage for any or all pairs if they\'re still not quite right.<br><br>
				
				Yours,<br> 
				The Bared Team
				</span>
				</td>
			</tr><tr><td>&nbsp;</td></tr>';
		$footer ='';
		$footer .='
				<table width="630" align="center">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">Message : </span>'; 
					if($order['message']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$order['message'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">How did you hear about us : </span>'; 
					if($cust['heard_us']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$cust['heard_us'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				
				<tr>
				<td align="center"> 
				<br>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700; color:#000!important; text-decoration:none; ">WWW.BARED.COM.AU </span><br> 
				</td>
		</tr></table>';
		$content='';
		if(!$order['store_pickup']){
			$s = $this->System_model->get_shipping($order['shipping_method']);
		}else{
			$s['name'] = 'Store Pickup';	
		}

		
		
		if($order['msg']=='Paypal'){			
		
		$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Paypal TXN ID: '.$order['txn_id'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
		}else{
			if($order['msg']=='30 Days Invoice')
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: 30 Days Invoice<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
			else
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Credit Card Credit Card Number: '.$order['cardnumber'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
		
		}
		
		$state_cust = $this->System_model->get_state($cust['state']);
		$state_order = $this->System_model->get_state($order['state']);
		$country = $this->System_model->get_country($order['country']);
		
		$order_customer_name = 'Bared Footwear';
		if(!$order['store_pickup']){
			$order_customer_name = $order['firstname'].'<br>'.$order['lastname'];
		}
		
		$content.='<tr><td>&nbsp;&nbsp;</td></tr>
		<tr bgcolor="#F1F2F2"><td>
			<table width="100%">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> BILL TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$cust['firstname'].'<br>
						 '.$cust['lastname'].'<br>
						 '.$cust['address'].'<br>
						 '.$cust['address2'].'<br>
						 '.$cust['city'].'<br>
						 '.$state_cust.'<br>
						 '.$cust['postcode'].'<br>
						 '.$cust['country'].'<br>
						 '.$cust['mobile'].'<br>	</span>					 
					</td>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> ' . ($order['store_pickup'] ? 'PICKUP ADDRESS' : 'SHIP TO') .' : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
						 '. $order_customer_name . '<br> 
						 '.$order['address'].'<br>
						 '.$order['address2'].'<br>
						 '.$order['city'].'<br>
						 '.$state_order.'<br>
						 '.$order['postcode'].'<br>
						 '.$country.'<br>	</span>					 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td></tr></table>';
		$content.='
		<table width="630" align="center">
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">CODE </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRODUCT NAME </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">QTY </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRICE </span></td>
				<td align="right"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">SUBTOTAL </span></td>
			</tr>';
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			$var = json_decode($item['attributes'],true);
			//$attributes = json_decode($item['attributes'],true);
			
			if($product['multiplesize'] == 1)
			{
				if($var['Size'] == '65us')
				{
					$size_text = '6.5us';
				}
				elseif($var['Size'] == '75us')
				{
					$size_text = '7.5us';
				}
				elseif($var['Size'] == '85us')
				{
					$size_text = '8.5us';
				}
				elseif($var['Size'] == '95us')
				{
					$size_text = '9.5us';
				}
				elseif($var['Size'] == '105us')
				{
					$size_text = '10.5us';
				}
				else
				{
					$size_text = $var['Size'];
				}
				
				$size = 'Size: '.$size_text;
			}
			else
			{
				$size = '';
			}
			$size = strtoupper($size);
			
			$size ='&nbsp;'.$size;
			$content.='
			<tr>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['id'].'  </span></td>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['title'].' '.$product['short_desc'].' '.$size.' </span></td>
				<td align="center"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$item['quantity'].'</span> </td>
				<td>
				<table cellpadding="0" cellspacing="0" ><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['price'],2,'.',',').' </span></td></tr></table></td>
				
				<td align="right">
					<table cellpadding="0" cellspacing="0" align="right"><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['quantity'] * $item['price'],2,'.',',').' </span></td></tr></table></td>
			</tr>';
						
		}
		$order_id = sprintf('%04d',$order_id);
		$order_time = date('l dS F Y',strtotime($order['order_time']));

		$content.='
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		</table>
		
		<table width=" 630" cellpadding="0" cellspacing="0" align="center">
		<tr>
		<td width="50%">&nbsp;</td>
		<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">ITEMS SUB TOTAL:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['subtotal'].'</span></td>
		</tr>';
		if($order['gift_card']>0){
		$content.='
			<tr>
			<td width="50%">&nbsp;</td>
			<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">GIFT CARD:</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['gift_card'].'</span></td>
			</tr>'; 
		}
		$content.='
		<tr>
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Shipping:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['shipping_cost'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Discount:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">-AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['discount'].'</span></td>
		</tr>
		<tr>
		<td width="50%">&nbsp;</td>
		<td style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">GST 10%</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">AUD$</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">'.$order['tax'].'</span></td>
		</tr>
		<tr style="border-bottom:4px solid #000;">
		<td width="50%">&nbsp;</td>
		<td  style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">TOTAL AMOUNT:</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400;margin-top:5px;">AUD$</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">'.$order['total'].'</div></td>
		</tr>
		
		</table>
		';			
		$message = $header.$content.$footer;
		#echo $message;exit;
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from('noreply@bared.com.au','Bared');
		$this->email->to($order['email']);		
		#$this->email->bcc('rseptiane@gmail.com');
		$this->email->subject('Order Confirmation @ Bared');
		$this->email->message($message);
		$this->email->send();
		
		
		/*$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'propagate.au@gmail.com', // change it to yours
		  'smtp_pass' => 'm0r3m0n3Y', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('propagate.au@gmail.com','Bared Order Test'); // change it to yours
		$this->email->to('kaushtuv@propagate.com.au');// change it to yours
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send()	;	
		echo $message;
	*/
	}		
	
	function send_order_notification($order_id) {
		$order = $this->Order_model->identify($order_id);
		$cart = $this->Cart_model->all($order['session_id']);
		$cust = $this->Customer_model->identify($order['customer_id']);
		$products_info = '';
		$header='';
		$header .='
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
		<table width="630" align="center"><tr><td></td></tr><tr><td>&nbsp;</td></tr>';
		$footer ='';
		$footer .='
				<table width="630" align="center">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">Message : </span>'; 
					if($order['message']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$order['message'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">How did you hear about us : </span>'; 
					if($cust['heard_us']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$cust['heard_us'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
				Thank you for shopping at Bared. <br><br>
				Please retain this invoice as a record of your purchase. Please check your goods carefully and refer to our <br>
				Terms & Conditions and Warranty & Returns policy. You will be charged in Australian dollars. <br><br>
				Unfortunately we cannot accept returns or exchanges on sale items.
				</span>
				</td>
				</tr>
				<tr>
				<td align="center"> 
				<br>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700; color:#000!important; text-decoration:none; ">WWW.BARED.COM.AU </span><br> 
				<span style="font-family:Times New Roman, Times, serif; font-size:10px; font-weight:400; ">BARED </span></td>
		</tr></table>';
		$content='';
		
		if(!$order['store_pickup']){
			$s = $this->System_model->get_shipping($order['shipping_method']);
		}else{
			$s['name'] = 'Store Pickup';	
		}

					
		if($order['msg']=='Paypal'){			
		
		$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Paypal TXN ID: '.$order['txn_id'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
		}else{
			if($order['msg']=='30 Days Invoice')
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: 30 Days Invoice<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
			else
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Credit Card Credit Card Number: '.$order['cardnumber'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
		
		}
		
		$state_cust = $this->System_model->get_state($cust['state']);
		$state_order = $this->System_model->get_state($order['state']);
		$country = $this->System_model->get_country($order['country']);
		
		$order_customer_name = 'Bared Footwear';
		if(!$order['store_pickup']){
			$order_customer_name = $order['firstname'].'<br>'.$order['lastname'];
		}
		
		$content.='<tr><td>&nbsp;&nbsp;</td></tr>
		<tr bgcolor="#F1F2F2"><td>
			<table width="100%">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> BILL TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$cust['firstname'].'<br>
						 '.$cust['lastname'].'<br>
						 '.$cust['address'].'<br>
						 '.$cust['address2'].'<br>
						 '.$cust['city'].'<br>
						 '.$state_cust.'<br>
						 '.$cust['postcode'].'<br>
						 '.$cust['country'].'<br>
						 '.$cust['mobile'].'<br>	</span>					 
					</td>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> ' . ($order['store_pickup'] ? 'PICKUP ADDRESS' : 'SHIP TO') .' : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
						 '. $order_customer_name . '<br>
						 '.$order['address'].'<br>
						 '.$order['address2'].'<br>
						 '.$order['city'].'<br>
						 '.$state_order.'<br>
						 '.$order['postcode'].'<br>
						 '.$country.'<br>
						 <br>	</span>					 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td></tr></table>';
		$content.='
		<table width="630" align="center">
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">CODE </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRODUCT NAME </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">QTY </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRICE </span></td>
				<td align="right"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">SUBTOTAL </span></td>
			</tr>';
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			$var = json_decode($item['attributes'],true);
			//$attributes = json_decode($item['attributes'],true);
			
			if($product['multiplesize'] == 1)
			{
				if($var['Size'] == '65us')
				{
					$size_text = '6.5us';
				}
				elseif($var['Size'] == '75us')
				{
					$size_text = '7.5us';
				}
				elseif($var['Size'] == '85us')
				{
					$size_text = '8.5us';
				}
				elseif($var['Size'] == '95us')
				{
					$size_text = '9.5us';
				}
				elseif($var['Size'] == '105us')
				{
					$size_text = '10.5us';
				}
				else
				{
					$size_text = $var['Size'];
				}
				
				$size = 'Size: '.$size_text;
			}
			else
			{
				$size = '';
			}

			$size = strtoupper($size);
			$size = '&nbsp;'.$size;
			$content.='
			<tr>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['id'].'  </span></td>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['title'].' '.$product['short_desc'].' '.$size.' </span></td>
				<td align="center"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$item['quantity'].'</span> </td>
				<td>
				<table cellpadding="0" cellspacing="0" ><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['price'],2,'.',',').' </span></td></tr></table></td>
				
				<td align="right">
					<table cellpadding="0" cellspacing="0" align="right"><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['quantity'] * $item['price'],2,'.',',').' </span></td></tr></table></td>
			</tr>';
						
		}
		$order_id = sprintf('%04d',$order_id);
		$order_time = date('l dS F Y',strtotime($order['order_time']));

		$content.='
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		</table>
		
		<table width=" 630" cellpadding="0" cellspacing="0" align="center">
		<tr>
		<td width="50%">&nbsp;</td>
		<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">ITEMS SUB TOTAL:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['subtotal'].'</span></td>
		</tr>';
		if($order['gift_card']>0){
		$content.='
			<tr>
			<td width="50%">&nbsp;</td>
			<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">GIFT CARD:</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['gift_card'].'</span></td>
			</tr>'; 
		}
		$content.='
		<tr>
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Shipping:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['shipping_cost'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Discount:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['discount'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">GST 10%</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">AUD$</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">'.$order['tax'].'</span></td>
		</tr>	
		<tr style="border-bottom:4px solid #000;">
		<td width="50%">&nbsp;</td>
		<td  style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">TOTAL AMOUNT:</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400;margin-top:5px;">AUD$</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">'.$order['total'].'</div></td>
		</tr>
		
		</table>
		';			
		$message = $header.$content.$footer;
		
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from($order['email']);
        
		$emailo = $this->System_model->get_email('name','order');
		$email_o = json_decode($emailo['address'],true);
		if ($email_o) 
		{
			$this->email->to($email_o[0]);			
			
			if(count($email_o) > 1)
			{
			 for($i=1;$i<count($email_o);$i++) 
			 {
				$this->email->cc($email_o[$i]);
			 }
			}
			$this->email->bcc('kaushtuv@propagate.com.au');
		} 
		else 
		{
			$this->email->to('kaushtuv@propagate.com.au');
		}
		
		$this->email->subject('New Order @ Bared Online Store');
		$this->email->message($message);
		$this->email->send();
		
		/*$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'propagate.au@gmail.com', // change it to yours
		  'smtp_pass' => 'm0r3m0n3Y', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('propagate.au@gmail.com','Bared Order Test'); // change it to yours
		$this->email->to('kaushtuv@propagate.com.au');// change it to yours
		$this->email->subject('New Order @ Bared Online Store');
		$this->email->message($message);
		$this->email->send()	;	
		echo $message;*/
	
	}		
	
	function send_order_notification_test($order_id) {
		$order = $this->Order_model->identify($order_id);
		$cart = $this->Cart_model->all($order['session_id']);
		$cust = $this->Customer_model->identify($order['customer_id']);
		$products_info = '';
		$header='';
		$header .='
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
		<table width="630" align="center"><tr><td></td></tr><tr><td>&nbsp;</td></tr>';
		$footer ='';
		$footer .='
				<table width="630" align="center">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">Message : </span>'; 
					if($order['message']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$order['message'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">How did you hear about us : </span>'; 
					if($cust['heard_us']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$cust['heard_us'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
				Thank you for shopping at Bared. <br><br>
				Please retain this invoice as a record of your purchase. Please check your goods carefully and refer to our <br>
				Terms & Conditions and Warranty & Returns policy. You will be charged in Australian dollars. <br><br>
				Unfortunately we cannot accept returns or exchanges on sale items.
				</span>
				</td>
				</tr>
				<tr>
				<td align="center"> 
				<br>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700; color:#000!important; text-decoration:none; ">WWW.BARED.COM.AU </span><br> 
				<span style="font-family:Times New Roman, Times, serif; font-size:10px; font-weight:400; ">BARED </span></td>
		</tr></table>';
		$content='';
		$s = $this->System_model->get_shipping($order['shipping_method']);

					
		if($order['msg']=='Paypal'){			
		
		$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Paypal TXN ID: '.$order['txn_id'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
		}else{
			if($order['msg']=='30 Days Invoice')
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: 30 Days Invoice<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
			else
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Credit Card Credit Card Number: '.$order['cardnumber'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
		
		}
		
		$state_cust = $this->System_model->get_state($cust['state']);
		$state_order = $this->System_model->get_state($order['state']);
		$country = $this->System_model->get_country($order['country']);
		$content.='<tr><td>&nbsp;&nbsp;</td></tr>
		<tr bgcolor="#F1F2F2"><td>
			<table width="100%">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> BILL TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$cust['firstname'].'<br>
						 '.$cust['lastname'].'<br>
						 '.$cust['address'].'<br>
						 '.$cust['address2'].'<br>
						 '.$cust['city'].'<br>
						 '.$state_cust.'<br>
						 '.$cust['postcode'].'<br>
						 '.$cust['country'].'<br>
						 '.$cust['mobile'].'<br>	</span>					 
					</td>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> SHIP TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$order['firstname'].'<br>
						 '.$order['lastname'].'<br>
						 '.$order['address'].'<br>
						 '.$order['address2'].'<br>
						 '.$order['city'].'<br>
						 '.$state_order.'<br>
						 '.$order['postcode'].'<br>
						 '.$country.'<br>
						 <br>	</span>					 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td></tr></table>';
		$content.='
		<table width="630" align="center">
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">CODE </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRODUCT NAME </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">QTY </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRICE </span></td>
				<td align="right"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">SUBTOTAL </span></td>
			</tr>';
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			$var = json_decode($item['attributes'],true);
			//$attributes = json_decode($item['attributes'],true);
			
			if($product['multiplesize'] == 1)
			{
				if($var['Size'] == '65us')
				{
					$size_text = '6.5us';
				}
				elseif($var['Size'] == '75us')
				{
					$size_text = '7.5us';
				}
				elseif($var['Size'] == '85us')
				{
					$size_text = '8.5us';
				}
				elseif($var['Size'] == '95us')
				{
					$size_text = '9.5us';
				}
				elseif($var['Size'] == '105us')
				{
					$size_text = '10.5us';
				}
				else
				{
					$size_text = $var['Size'];
				}
				
				$size = 'Size: '.$size_text;
			}
			else
			{
				$size = '';
			}

			$size = strtoupper($size);
			$size = '&nbsp;'.$size;
			$content.='
			<tr>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['id'].'  </span></td>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['title'].' '.$product['short_desc'].' '.$size.' </span></td>
				<td align="center"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$item['quantity'].'</span> </td>
				<td>
				<table cellpadding="0" cellspacing="0" ><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['price'],2,'.',',').' </span></td></tr></table></td>
				
				<td align="right">
					<table cellpadding="0" cellspacing="0" align="right"><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['quantity'] * $item['price'],2,'.',',').' </span></td></tr></table></td>
			</tr>';
						
		}
		$order_id = sprintf('%04d',$order_id);
		$order_time = date('l dS F Y',strtotime($order['order_time']));

		$content.='
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		</table>
		
		<table width=" 630" cellpadding="0" cellspacing="0" align="center">
		<tr>
		<td width="50%">&nbsp;</td>
		<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">ITEMS SUB TOTAL:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['subtotal'].'</span></td>
		</tr>';
		if($order['gift_card']>0){
		$content.='
			<tr>
			<td width="50%">&nbsp;</td>
			<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">GIFT CARD:</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['gift_card'].'</span></td>
			</tr>'; 
		}
		$content.='
		<tr>
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Shipping:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['shipping_cost'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Discount:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['discount'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">GST 10%</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">AUD$</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">'.$order['tax'].'</span></td>
		</tr>	
		<tr style="border-bottom:4px solid #000;">
		<td width="50%">&nbsp;</td>
		<td  style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">TOTAL AMOUNT:</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400;margin-top:5px;">AUD$</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">'.$order['total'].'</div></td>
		</tr>
		
		</table>
		';			
		$message = $header.$content.$footer;
		
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from($order['email']);
        
		
		$this->email->to('raquel@propagate.com.au');
		
		
		$this->email->subject('New Order @ Bared Online Store');
		$this->email->message($message);
		$this->email->send();
	}		
	

	function cart_reminder()
	{
		$all_cust = $this->Customer_model->all();
		foreach($all_cust as $cust)
		{
			$items = $this->Cart_model->all_save2($cust['id']);			
			if(count($items)>0)
			{
				$text = '';
				$text .= 'Hi '. $cust['firstname']. ' ' . $cust['lastname'] . ', <br/><br/>';
				$text .= 'Just a little reminder that you still have some items in your Bared Footwear shopping bag waiting for you to take home! <br/><br/>';
				$text .= '<table>';
				$text .= '<tr>';
				$text .='
				<th style="width: 8.33%">
					<span style="font-size: 18px; font-weight: 700;">ITEMS</span>
				</th>
				<th style="width: 19%; text-align:left; padding-left:2%">
					<span style="font-size: 18px; font-weight: 700; ">PRODUCTS</span>
				</th>
				<th style="width: 20.65%; text-align:left;">
					<span style="font-size: 18px; font-weight: 700; ">DESCRIPTION</span>
				</th>
				<th style="width: 10.33%">
					<span style="font-size: 18px; font-weight: 700;">SIZE</span>
				</th>
				<th style="width: 10.99%">
					<span style="font-size: 18px; font-weight: 700; text-align: center">QTY</span>
				</th>
				<th style="width: 13.67%; text-align: center">
					<span style="font-size: 18px; font-weight: 700;">UNIT PRICE</span>
				</th>
				<th style="width: 15%; text-align: center">
					<span style="font-size: 18px; font-weight: 700;">STORED DATE</span>
				</th>';
				
									
				$text .= '</tr>';
				
				$sent_something = 0;
				foreach($items as $item)
				{
					if($item['sent'] == 0)
					{
						$prod = $this->Product_model->identify($item['product_id']);
						$hero = $this->Product_model->get_hero($item['product_id']);
						
						$text .= '<tr>';
							if($hero)
							{
								$text .= '<td><img src="<?=base_url()?>uploads/products/'.md5('mbb'.$pro['id']).'/thumb2/'.$hero['name'].'"/></td>';
							}
							else
							{
								$text .= '<td><img style="" src="http://placehold.it/89x97"/></td>';
							}
							
							$text .= '<td style="padding-left:2%">'.$prod['title'].'</td>';
							$text .= '<td>'.$prod['short_desc'].'</td>';
							$text .= '<td style="text-align:center">N/A</td>';
							$text .= '<td style="text-align:center">'.$item['quantity'].'</td>';
							$text .= '<td style="text-align:center">AU$ '.$item['price'].'</td>';
							$text .= '<td style="text-align:center">'.date('jS M Y',strtotime($item['created'])).'</td>';
						$text .= '</tr>';
						$sent_something++;
					}
				}
				$text .= '</table><br/>';
				$text .= 'To complete your transaction please log onto <a target="_blank" href="'.base_url().'store/signin">https://bared.com.au/store/signin</a><br/><br/>';
				$text .= 'Love Bared';
				
				$sent = 0;
				if($sent_something>0)
				{
					echo $text.'<br/><br/><br/><br/><br/>';
					
					
					$this->load->library('email');
					$config['mailtype'] = 'html';	
					$this->email->initialize($config);	
					$this->email->from('reminder@bared.com.au','Bared Online Store');
					$this->email->to($cust['email']);
					$this->email->bcc('raquel@propagate.com.au');
					$this->email->subject('Order Reminder @ Bared Online Store');
					$this->email->message($text);
					$sent = $this->email->send();
					
					echo 'sent:'.$sent.'<br/>';
				}
				
				if($sent == 1)
				{
					foreach($items as $item)
					{
						if($item['sent'] == 0)
						{
							$ndata = array();
							$ndata['sent'] = 1;
							$this->Cart_model->update($item['id'],$ndata);
						}
					}
				}
			}
		}
	}
	
	
	
	/* News letter susbscription  */
	function newsletter_subscribe()
	{
		$email = $this->input->post('email',true);
		if($email){
			//if valid email
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				//check if email is already in the subscription list
				if($this->Subscribe_model->exist($email)){
					$msg = -1;	
				}
				else{
					$data = array(
								'email' => $email,
								'active' => 1,
								'date' => date('Y-m-d h:i:s') 
								);	
					$this->Subscribe_model->add($data);
					$msg = 1;
				}
				
			}
			
		}
		echo $msg;
	}
	
	function cart_reminder_test($order_id)
	{
		
		
				$text = '';
				$text .= 'Hi Raquel Septiane, <br/><br/>';
				$text .= 'Just a little reminder that you still have some items in your Bared Footwear shopping bag waiting for you to take home! <br/><br/>';
				$text .= '<table>';
				$text .= '<tr>';
				$text .='
				<th style="width: 8.33%">
					<span style="font-size: 18px; font-weight: 700;">ITEMS</span>
				</th>
				<th style="width: 19%; text-align:left; padding-left:2%">
					<span style="font-size: 18px; font-weight: 700; ">PRODUCTS</span>
				</th>
				<th style="width: 20.65%; text-align:left;">
					<span style="font-size: 18px; font-weight: 700; ">DESCRIPTION</span>
				</th>
				<th style="width: 10.33%">
					<span style="font-size: 18px; font-weight: 700;">SIZE</span>
				</th>
				<th style="width: 10.99%">
					<span style="font-size: 18px; font-weight: 700; text-align: center">QTY</span>
				</th>
				<th style="width: 13.67%; text-align: center">
					<span style="font-size: 18px; font-weight: 700;">UNIT PRICE</span>
				</th>
				<th style="width: 15%; text-align: center">
					<span style="font-size: 18px; font-weight: 700;">STORED DATE</span>
				</th>';
				
									
				$text .= '</tr>';
				
				$sent_something = 0;
				
						$prod = $this->Product_model->identify(106);
						$hero = $this->Product_model->get_hero(106);
						
						$text .= '<tr>';
							if($hero)
							{
								$text .= '<td><img src="<?=base_url()?>uploads/products/'.md5('mbb'.$pro['id']).'/thumb2/'.$hero['name'].'"/></td>';
							}
							else
							{
								$text .= '<td><img style="" src="http://placehold.it/89x97"/></td>';
							}
							
							$text .= '<td style="padding-left:2%">'.$prod['title'].'</td>';
							$text .= '<td>'.$prod['short_desc'].'</td>';
							$text .= '<td style="text-align:center">N/A</td>';
							$text .= '<td style="text-align:center">'.$item['quantity'].'</td>';
							$text .= '<td style="text-align:center">AU$ '.$item['price'].'</td>';
							$text .= '<td style="text-align:center">'.date('jS M Y',strtotime($item['created'])).'</td>';
						$text .= '</tr>';
						$sent_something++;
				
				$text .= '</table><br/>';
				$text .= 'To complete your transaction please log onto <a target="_blank" href="'.base_url().'store/signin">https://bared.com.au/store/signin</a><br/><br/>';
				$text .= 'Love Bared'.'<br><br>'.$order_id;
				$text .= '<div style="text-align:left; width:150px;font-family:Century Gothic,sans-serif;color:1F497D;font-size:9px;">
				<img src="'.base_url().'img/bared-email.png"><br>
				<p style="text-align:center;">
				<span style="font-weight:800;font-size:12px;">Bared Footwear</span><br>
          		Bared Pty Ltd<br>
      			1098 High Street<br>
    			Armadale VIC 3143<br>
       			P: (03) 95095771<br>
     			<a href="https://bared.com.au">www.bared.com.au</a><br>
				</p>
				</div>';
				
				$sent = 0;
				if($sent_something>0)
				{
					echo $text.'<br/><br/><br/><br/><br/>';
					
					
					$this->load->library('email');
					$config['mailtype'] = 'html';	
					$this->email->initialize($config);	
					$this->email->from('reminder@bared.com.au','Bared Online Store');
					$this->email->to('raquel@propagate.com.au');
					$this->email->subject('Order Reminder @ Bared Online Store');
					$this->email->message($text);
					$sent = $this->email->send();
					
					echo 'sent:'.$sent.'<br/>';
				}
				
				if($sent == 1)
				{
					echo'good';
				}
			
	}
	
	
	# get tax for store pick
	function _get_store_pickup_tax()
	{
		$cmp_profile = $this->Company_profile_model->get_profile();
		$tax = $this->System_model->get_tax_country($cmp_profile['country_id']);	
		return $tax;	
	}
}
?>