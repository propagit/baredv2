<?php

# Controller: Cron

class Cron extends Controller {

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
	
	function send_giftcard()
	{
		
		
		$ndate = date('Y-m-d',strtotime('-1 day'));
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
								<span style="font-weight: 700; font-size: 18px;">'.$l['gift_code'].'</span><br/>
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
							'.$l['gift_from'].' has sent you a Gift Voucher to spend on something special from Bared Footwear. Your Gift Voucher can be redeemed online at <a href="'.base_url().'">www.bared.com.au</a> and is valid for 12 months.<br/>
							<br/>
							Now you just need to choose your gift, wait for your delivery, and enjoy!<br/><br/>
							xo Bared Footwear<br/>
							<br/>
							<br/>
							<span style="font-weight: 700">HOW TO REDEEM YOUR GIFT VOUCHER</span><br/>
							Your Gift Voucher has a unique code, which is required to ‘pay’ for your item. <br/>
							<ol>
								<li>Go to <a href="'.base_url().'">www.bared.com.au</a></li>
								<li>Select the item you wish to purchase.</li>
								<li>Add to Shopping Bag.</li>
								<li>To purchase, go to your Shopping Bag, located in the top right of the screen, and follow the prompts. You will be required to sign in or register with us, and we will also ask you for a ‘Billing address’, even though you may not be required to pay any extra for your item. If there is an outstanding balance, you will be required to give your credit card details also.</li>
								<li>When you get to the ORDER SUMMARY page, you will need to add your Gift Voucher Code into the area allocated and select UPDATE.</li>
								<li>Follow the prompts through to place your order.</li>
								<li>Wait for your delivery to arrive!</li>
							</ol>
							<br/>
							If there is a difference between the amount on the Gift Voucher and the order total you may need to add your credit card details to pay any extra amount.<br/><br/>
							If there is an amount left over, it will remain available on your Gift Voucher for future use.<br/><br/>
							Gift Vouchers are valid for 12 months from the date of purchase and can only be used in the Bared Footwear.<br/>
						</td>
					</tr>
				</table>
				
				<table cellspacing="0" cellpadding="0" width="630" align="center" style="margin-top: 20px">			
					<tr>
						
						
					</tr>
				</table>
				<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; color: #403c3c; font-family: times; border-top: 5px solid #000">
					<tr>
						<td>
						</td>
					</tr>
				</table>';
				
			echo $msg;
			
			$this->load->library('email');
			$config['mailtype'] = 'html';	
			$this->email->initialize($config);	
			$this->email->from('noreply@bared.com.au','Bared Footwear');
			$this->email->to($l['gift_email']);
			//$this->email->to('peteryo11@gmail.com');
			
			$this->email->subject('Bared Footwear - Gift Voucher @ Bared Footwear');
			$this->email->message($msg);
			#$sent = $this->email->send();
			$this->email->send();
			$this->email->clear();

			#$data = array();
			#$data['gift_sent'] = 1;
			#$cid=$l['id'];
			#$this->Cart_model->update($cid,$data);
			$this->Cart_model->update($l['id'],array('gift_sent' => 1));
		}
	}
	
	function cart_reminder()
	{
		$all_cust = $this->Customer_model->all();
		foreach($all_cust as $cust)
		{
			if($cust['id'] == 1)
			{
				$items = array();
			}
			else
			{
				$items = $this->Cart_model->all_save2($cust['id']);
				//echo $this->db->last_query().'<br/>';
			}
			
			//echo "<pre>".print_r($items,true)."</pre>";
			if(count($items)>0)
			{
				echo $cust['id'].'<br/>';
				//echo 1;
				$text = '';
				$text .= 'Hi,'. $cust['firstname']. ' ' . $cust['lastname'] . '<br/><br/>';
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
						$var = json_decode($item['attributes'],true);
						//echo $prod['title'].'<br/>';
						$text .= '<tr>';
							if($hero)
							{
								$text .= '<td><img src="'.base_url().'uploads/products/'.md5('mbb'.$prod['id']).'/thumb2/'.$hero['name'].'"/></td>';
							}
							else
							{
								$text .= '<td><img style="" src="http://placehold.it/89x97"/></td>';
							}
							
							$text .= '<td style="padding-left:2%">'.$prod['title'].'</td>';
							$text .= '<td>'.$prod['short_desc'].'</td>';
							if($prod['multiplesize'] == 1)
							{
								$text .= '<td style="text-align:center">'.$var['Size'].'</td>';
							}
							else
							{
								$text .= '<td style="text-align:center">N/A</td>';
							}
							
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
					$this->email->from('reminder@bared.com.au','Bared Footwear');
					$this->email->to($cust['email']);
					$this->email->bcc('raquel@propagate.com.au');
					
					$this->email->subject('Order Reminder @ Bared Footwear');
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
	
	
	
	
	
	function add_contactlist_simplysuite() {
		
		#List Groups:
		#Subscriber = 1385
		#Trader Australia = 1386
		#Trader International = 1387
		#Trader ACT = 1388
		#Trader NSW = 1389
		#Trader NT = 1390
		#Trader QLD = 1391
		#Trader SA = 1392
		#Trader TAS = 1393
		#Trader VIC = 1394
		#Trader WA = 1395
		#Retailer Australia = 1396
		#Retailer International = 1397
		#Retailer ACT = 1398
		#Retailer NSW = 1399
		#Retailer NT = 1400
		#Retailer QLD = 1401
		#Retailer SA = 1402
		#Retailer TAS= 1403
		#Retailer VIC = 1404
		#Retailer WA = 1405
		
		$customers = $this->Customer_model->get_updated_customer_cronsimply();
		foreach($customers as $cust)
		{
			if($cust['dealer']==0){$type='retailer';}else{$type='trader';}
			$country=$cust['country'];
			$state=$cust['state'];
			$phone=$cust['mobile'];						
			$firstname=$cust['firstname'];
			$lastname=$cust['lastname'];
			$email=$cust['email'];
		
			$group_ids=array();
			
			if($type=='subscriber')
			{
				$group_ids[]=1385;
			}
			if($country!='Australia' && $type!='subscriber')
			{
				if($type=='retailer')
				{
					$group_ids[]=1397;
				}
				if($type=='trader')
				{
					$group_ids[]=1387;
				}
			}
			
			if($country=='Australia' && $type!='subscriber')
			{
				if($type=='retailer')
				{
					$group_ids[]=1396;
				}
				if($type=='trader')
				{
					$group_ids[]=1386;
				}
				
				if($state==1)	#Victoria
				{
					if($type=='retailer')
					{
						$group_ids[]=1404;
					}
					if($type=='trader')
					{
						$group_ids[]=1394;
					}
				}
				if($state==2)	#NSW
				{
					if($type=='retailer')
					{
						$group_ids[]=1399;
					}
					if($type=='trader')
					{
						$group_ids[]=1389;
					}
				}
				if($state==3)	#QLD
				{
					if($type=='retailer')
					{
						$group_ids[]=1401;
					}
					if($type=='trader')
					{
						$group_ids[]=1391;
					}
				}
				if($state==4)	#WA
				{
					if($type=='retailer')
					{
						$group_ids[]=1405;
					}
					if($type=='trader')
					{
						$group_ids[]=1395;
					}
				}
				if($state==5)	#Tasmania
				{
					if($type=='retailer')
					{
						$group_ids[]=1403;
					}
					if($type=='trader')
					{
						$group_ids[]=1393;
					}
				}
				if($state==6)	#NT
				{
					if($type=='retailer')
					{
						$group_ids[]=1400;
					}
					if($type=='trader')
					{
						$group_ids[]=1390;
					}
				}
				if($state==8)	#SA
				{
					if($type=='retailer')
					{
						$group_ids[]=1402;
					}
					if($type=='trader')
					{
						$group_ids[]=1392;
					}
				}
				if($state==9)	#ACT
				{
					if($type=='retailer')
					{
						$group_ids[]=1398;
					}
					if($type=='trader')
					{
						$group_ids[]=1388;
					}
				}
			}
		
			//get post information
			$this->load->library('curl');	
			$user_id 	= '295';
			$firstname 	= $this->db->escape_str($firstname);
			$lastname 	= $this->db->escape_str($lastname);
			$mobile 	= $this->db->escape_str($phone);
			$email 		= $this->db->escape_str($email);
			foreach($group_ids as $gid)
			{
				$data = array(
					'user'		=> $user_id,
					'group'		=> $gid,
					'firstname'	=> $firstname,
					'lastname'	=> $lastname,
					'mobile'	=> $mobile,
					'email'		=> $email																	
				);		
			
				/*print_r($data);
				if($type=='subscriber'){echo $this->curl->simple_post('https://email.simplysuite.com.au/simply_services/addsub',$data);}
				else
				{
					//echo $this->curl->simple_post('https://email.simplysuite.com.au/simply_services/addcontact',$data);
					print_r($data);
					echo '<br>';
				}*/
				//print_r($data);
				//echo '<br>';
				//echo $this->curl->simple_post('http://simplysuite.com.au/email/simply_services/spencer_addcontact',$data);
				//echo '<br>';
			}
		}
				
	}
	

	function import_stockist()
	{
		//$this->System_model->delete_all_stockist();
		
		$handle1 = fopen(base_url().'myob/CustomerExport.csv', "r");
		$cc = 0; 
		while (($data = fgetcsv($handle1, 5000, ","))!== FALSE) 
		{
			if($cc != 0)
			{
				if($data[5] == 'TRUE')
				{
					//stockist
					echo "<pre>".print_r($data,true)."</pre>";
					$name = trim($data[13]);
					$address = trim($data[23]);
					$address2 = trim($data[24]);
					$suburb = trim($data[26]);
					$state = trim($data[27]);
					$pcode = trim($data[28]);
					$country = trim($data[29]);
					$phone = trim($data[30]);
					$status = trim($data[5]);
					
					$ndata = array();
					$ndata['name'] = $name;
					$ndata['address'] = $address;
					$ndata['address2'] = $address2;
					$ndata['suburb'] = $suburb;
					$ndata['state'] = $state;
					$ndata['postcode'] = $pcode;
					$ndata['country'] = $country;
					$ndata['phone'] = $phone;
					$ndata['status'] = $status;
					
					$this->System_model->add_stockist($ndata);
				}
				else
				{
					echo "<pre>".print_r($data,true)."</pre>";
					$rmid = trim($data[0]);
					$email = trim($data[33]);
					$ms = trim($data[2]);
					if($ms == 1)
					{
						$membership_status = 3;
					}
					if($ms == 2)
					{
						$membership_status = 2;
					}
					if($ms == 3)
					{
						$membership_status = 1;
					}
					$birthday = date('Y-m-d',strtotime(trim($data[10])));
					$firstname = trim($data[11]);
					$lastname = trim($data[10]);
					$tradename = trim($data[13]);
					$address = trim($data[23]);
					$address2 = trim($data[24]);
					$suburb = trim($data[24]);
					
					$st = trim($data[27]);
					if($st == 'VIC') {$state = 1;}
					if($st == 'NSW') {$state = 2;}
					if($st == 'QLD') {$state = 3;}
					if($st == 'WA') {$state = 4;}
					if($st == 'TAS') {$state = 5;}
					if($st == 'NT') {$state = 6;}
					if($st == 'SA') {$state = 8;}
					if($st == 'ACT') {$state = 9;}
					
					$country = trim($data[29]);
					$postcode = trim($data[28]);
					$phone = trim($data[30]);
					$mobile = trim($data[32]);
					$title = trim($data[14]);
					$abn = trim($data[34]);
					$barcode = trim($data[1]);
					$month_dob = date('m',strtotime(trim($data[10])));
					$date_dob = date('d',strtotime(trim($data[10])));
					$modified = date('Y-m-d',strtotime(trim($data[9])));
					$created = date('Y-m-d',strtotime(trim($data[37])));
					
					
					$ndata = array();
					$ndata['email'] = $email;
					$ndata['membership_status'] = $membership_status;
					$ndata['birthday'] = $birthday;
					$ndata['firstname'] = $firstname;
					$ndata['lastname'] = $lastname;
					$ndata['tradename'] = $tradename;
					$ndata['address'] = $address;
					$ndata['address'] = $address2;
					$ndata['suburb'] = $suburb;
					$ndata['$state'] = $state;
					$ndata['country'] = $country;
					$ndata['postcode'] = $postcode;
					$ndata['phone'] = $phone;
					$ndata['mobile'] = $mobile;
					$ndata['title'] = $title;
					$ndata['abn'] = $abn;
					$ndata['barcode'] = $barcode;
					$ndata['rmid'] = $rmid;
					$ndata['month_dob'] = $month_dob;
					$ndata['date_dob'] = $date_dob;
					$ndata['modified'] = $modified;
					$ndata['joined'] = $joined;
					
					$customer_id = $this->Customer_model->add($ndata);
					if ($customer_id) 
					{
						$user['customer_id'] = $customer_id;
						$user['username'] = $email;
						$user['password'] = md5('changeme123');
						if($tradename != '')
						{
							//trade
							$user['level'] = 2;
							$user['active'] = 0;
						}
						else 
						{
							//retail
							$user['level'] = 1;
							$user['active'] = 1;
						}
						$user_id = $this->User_model->add($user);
					}
				}
				
			}
			$cc++;
		}
	}

	

	function trial_list_folder()
	{
		//error_reporting(E_ALL);
		$dir    = 'stock';
		$files1 = scandir($dir);
		
		$files = array();
		
		foreach($files1 as $fl)
		{
			if(strpos($fl,'StockExport') !== false)
			{
				//$fl=str_replace('.csv', '', $fl);
				array_push($files,$fl);
			}
		}
		
		if(count($files) > 0)
		{
			rsort($files);
			//print_r($files);
			echo $files[0];
		}
		else 
		{
			echo "none";
		}
		
	}

	function trial_xls()
	{
		
		ini_set('include_path', ini_get('include_path').';../Classes/');
		
		/** Include PHPExcel */
		require_once 'PHPExcel/Classes/PHPExcel.php';
		include 'PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
		
		// Create new PHPExcel object
		echo date('H:i:s') . " Create new PHPExcel object\n";
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		echo date('H:i:s') . " Set properties\n";
		$objPHPExcel->getProperties()->setCreator("SR Web");
		$objPHPExcel->getProperties()->setLastModifiedBy("SR Web");
		$objPHPExcel->getProperties()->setTitle("XLS Order Document");
		$objPHPExcel->getProperties()->setSubject("XLS Order Document");
		$objPHPExcel->getProperties()->setDescription("Order");
		
		
		// Add some data
		echo date('H:i:s') . " Add some data\n";
		$objPHPExcel->setActiveSheetIndex(0);
		//header//
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'line_type');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'orders_id');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'customer_barcode');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'customers_first_name');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'customers_last_name');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'customers_company');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'customers_street_address');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'customers_suburb');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'customers_city');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'customers_state');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'customers_postcode');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'customers_country');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'customers_telephone');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'customers_email_address');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'delivery_name');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'delivery_company');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'delivery_street_address');
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'delivery_suburb');
		$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'delivery_city');
		$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'delivery_state');
		$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'delivery_postcode');
		$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'delivery_country');
		$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'comments');
		$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'billing_name');
		$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'billing_company');
		$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'billing_street_address');
		$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'billing_suburb');
		$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'billing_city');
		$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'billing_state');
		$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'billing_postcode');
		$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'billing_country');
		$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'currency');
		$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'currency_value');
		$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'payment_method');
		$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'cc_type');
		$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'date_purchased');
		
		// Rename sheet
		echo date('H:i:s') . " Rename sheet\n";
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		
				
		// Save Excel 2007 file
		echo date('H:i:s') . " Write to Excel2007 format\n";
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('myob/order.xls');
		
		// Echo done
		echo date('H:i:s') . " Done writing file.\r\n";
	}
	
	function create_order_xls()
	{
		exit;
		// spreadsheet data
		//Create new COM object – excel.application
		
		
		ini_set('include_path', ini_get('include_path').';../Classes/');
		
		/** Include PHPExcel */
		require_once 'PHPExcel/Classes/PHPExcel.php';
		include 'PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
		
		
		
		
		
		
		
		//require_once "excel/php-export-data.class.php";
		
		$orders = $this->Order_model->all_not_export();
		
		foreach($orders as $order)
		{
			
			// Create new PHPExcel object
			echo date('H:i:s') . " Create new PHPExcel object\n";
			$objPHPExcel = new PHPExcel();
			
			// Set properties
			echo date('H:i:s') . " Set properties\n";
			$objPHPExcel->getProperties()->setCreator("SR Web");
			$objPHPExcel->getProperties()->setLastModifiedBy("SR Web");
			$objPHPExcel->getProperties()->setTitle("XLS Order Document");
			$objPHPExcel->getProperties()->setSubject("XLS Order Document");
			$objPHPExcel->getProperties()->setDescription("Order");
			
			
			// Add some data
			echo date('H:i:s') . " Add some data\n";
			$objPHPExcel->setActiveSheetIndex(0);
			
			
			
			//$order = $this->Order_model->identify(22);
			$cust = $this->Customer_model->identify($order['customer_id']);
			$state_order = $this->System_model->get_state($order['state']);
			$state_billing = $this->System_model->get_state($cust['state']);
			$country_order = $this->System_model->get_country($order['country']);
			if($order['msg'] == 'Paypal')
			{
				$py_type = 'Paypal';
			}
			else
			{
				$py_type = 'Credit Card';
			}
	
			$ship = $this->System_model->get_shipping($order['shipping_method']);
			
			$cart = $this->Cart_model->all($order['session_id']);
			
			
			//header//
		
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'line_type');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'orders_id');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'customer_barcode');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'customers_first_name');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'customers_last_name');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'customers_company');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'customers_street_address');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'customers_suburb');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'customers_city');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'customers_state');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'customers_postcode');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'customers_country');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'customers_telephone');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'customers_email_address');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'delivery_name');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'delivery_company');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'delivery_street_address');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'delivery_suburb');
			$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'delivery_city');
			$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'delivery_state');
			$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'delivery_postcode');
			$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'delivery_country');
			$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'comments');
			$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'billing_name');
			$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'billing_company');
			$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'billing_street_address');
			$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'billing_suburb');
			$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'billing_city');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'billing_state');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'billing_postcode');
			$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'billing_country');
			$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'currency');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'currency_value');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'payment_method');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'cc_type');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'date_purchased');
			
			//order header//
			
			
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', '1');
			$objPHPExcel->getActiveSheet()->SetCellValue('C2', $order['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D2', $cust['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E2', $order['firstname']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F2', $order['lastname']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G2', '');
			$objPHPExcel->getActiveSheet()->SetCellValue('H2', $order['address']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I2', $order['city']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J2', $order['city']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K2', $state_order);
			$objPHPExcel->getActiveSheet()->SetCellValue('L2', $order['postcode']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M2', $country_order);
			$objPHPExcel->getActiveSheet()->SetCellValue('N2', '');
			$objPHPExcel->getActiveSheet()->SetCellValue('O2', $order['email']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P2', $order['firstname'].' '.$order['lastname']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q2', '');
			$objPHPExcel->getActiveSheet()->SetCellValue('R2', $order['address']);
			$objPHPExcel->getActiveSheet()->SetCellValue('S2', $order['city']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T2', $order['city']);
			$objPHPExcel->getActiveSheet()->SetCellValue('U2', $state_order);
			$objPHPExcel->getActiveSheet()->SetCellValue('V2', $order['postcode']);
			$objPHPExcel->getActiveSheet()->SetCellValue('W2', $country_order);
			$objPHPExcel->getActiveSheet()->SetCellValue('X2', $order['message']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y2', $cust['firstname'].' '.$cust['lastname']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z2', $cust['tradename']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA2', $cust['address']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB2', $cust['suburb']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AC2', $cust['suburb']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AD2', $state_billing);
			$objPHPExcel->getActiveSheet()->SetCellValue('AE2', $cust['postcode']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AF2', $cust['country']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AG2', 'AUD');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH2', '1.00');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI2', $py_type);
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ2', $order['cardtype']);
			$objPHPExcel->getActiveSheet()->SetCellValue('AK2', date('d/m/Y H:i',strtotime($order['order_time'])));
			
			
			//header cart
			$objPHPExcel->getActiveSheet()->SetCellValue('B3', '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'orders_id');
			$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'stock_id');
			$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'products_quantity');
			$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'text(optional)');
			$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'products_price_ex');
			$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'products_tax%');
			$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'tax_code');
			
			$line = 4;
			
			//cart
			 foreach($cart as $c)
			 {
			 	$p = $this->Product_model->identify($c['product_id']);
			 	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '2');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $order['id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, $p['stock_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, $c['quantity']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, $p['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, $c['price']);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$line, '10');
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$line, 'EXP');
				
				$line++;
			 }
			
			//header order footer
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, 'orders_id');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, 'stock_id');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, 'title');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, 'text(optional)');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, 'value');
			$line++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '3');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $order['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, 'Sub-Total:');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, $order['total'].'(AUD)');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, $order['total']);
			$line++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '4');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $order['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, $order['coupon_code']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, '<b>-'.$order['discount'].'(AUD)</b>');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, $order['discount']);
			$line++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '5');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $order['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, '0');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, $ship['name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, $order['shipping_cost'].'(AUD)');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, $order['shipping_cost']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$line, '0');
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$line, 'N-T');
			$line++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '6');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $order['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, 'Tax');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, $order['tax'].'(AUD)');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, $order['tax']);
			$line++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, '7');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $order['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, 'Total:');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, $order['total'].'(AUD)');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, $order['total']);
			$line++;
			
			
			$this->db->where('id',1);
			$query = $this->db->get('system_save');
			$ss = $query->first_row('array');
			
			$ordern = $ss['order_export_order'];
			$long = strlen($ordern);
			$zero = 8 - $long;
			for($i = 0; $i < $zero; $i++)
			{
				$ordern = '0'.$ordern;
			}
			
			// Rename sheet
			echo date('H:i:s') . " Rename sheet\n";
			$objPHPExcel->getActiveSheet()->setTitle("order_export_".$ordern);
			
					
			// Save Excel 2007 file
			echo date('H:i:s') . " Write to Excel2007 format\n";
			$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
			$objWriter->save("myob/order_export_".$ordern.".xls");
			
			// Echo done
			echo date('H:i:s') . " Done writing file.\r\n";
			
			$ndata = array();
			$ndata['order_export_order'] = $ss['order_export_order'] + 1;
			$this->db->where('id',1);
			$this->db->update('system_save',$ndata);
			
			//$excel = new ExportDataExcel('file');
			//$excel->filename = "order/order_export_id_".$order['id'].".xls";
			
			// $excel->initialize();
			// $row = array('line_type','orders_id','customer_barcode','customers_first_name','customers_last_name','customers_company','customers_street_address','customers_suburb','customers_city','customers_state','customers_postcode','customers_country','customers_telephone','customers_email_address','delivery_name','delivery_company','delivery_street_address','delivery_suburb','delivery_city','delivery_state','delivery_postcode','delivery_country','comments','billing_name','billing_company','billing_street_address','billing_suburb','billing_city','billing_state','billing_postcode','billing_country','currency','currency_value','payment_method','cc_type','date_purchased');
			// $excel->addRow($row);
			// $row = array('1',$order['id'],$cust['barcode'],$order['firstname'],$order['lastname'],'',$order['address'],$order['city'],$order['city'],$state_order,$order['postcode'],$country_order,'',$order['email'],$order['firstname'].' '.$order['lastname'],'',$order['address'],$order['city'],$order['city'],$state_order,$order['postcode'],$country_order,$order['message'],$cust['firstname'].' '.$cust['lastname'],$cust['tradename'],$cust['address'],$cust['suburb'],$cust['suburb'],$state_billing,$cust['postcode'],$cust['country'],'AUD','1.00',$py_type,$order['cardtype'],date('d/m/Y H:i',strtotime($order['order_time'])));
			// $excel->addRow($row);
			// $row = array('','orders_id','stock_id','products_quantity','text(optional)','products_price_ex','products_tax%','tax_code');
			// $excel->addRow($row);
// 			
			// //cart
			// foreach($cart as $c)
			// {
				// $p = $this->Product_model->identify($c['product_id']);
				// $row = array('2',$order['id'],$p['stock_id'],$p['title'],$c['price'],'10%','EXP');
				// $excel->addRow($row);
			// }
// 			
			// $row = array('','orders_id','stock_id','title','text(optional)','value');
			// $excel->addRow($row);
			// $row = array('3',$order['id'],'','Sub-Total:',$order['total'].'(AUD)',$order['total']);
			// $excel->addRow($row);
			// $row = array('4',$order['id'],'',$order['coupon_code'],'<b>-'.$order['discount'].'(AUD)</b>',$order['discount']);
			// $excel->addRow($row);
			// $row = array('5',$order['id'],'',$ship['name'],$order['shipping_cost'].'(AUD)',$order['shipping_cost']);
			// $excel->addRow($row);
			// $row = array('6',$order['id'],'','Tax',$order['tax'].'(AUD)',$order['tax']);
			// $excel->addRow($row);
			// $row = array('7',$order['id'],'','Total:',$order['total'].'(AUD)',$order['total']);
			// $excel->addRow($row);
			// $excel->finalize();
			
			$ndata = array();
			$ndata['export'] = 1;
			$this->Order_model->update($order['id'],$ndata);
			
			echo $order['id']."<br/>";
			
		}
		
		

	}

	function create_order_xls_per_id($id)
	{
		// spreadsheet data
		//Create new COM object – excel.application
		require_once "excel/php-export-data.class.php";
		
		
		
		$order = $this->Order_model->identify($id);
		$cust = $this->Customer_model->identify($order['customer_id']);
		$state_order = $this->System_model->get_state($order['state']);
		$state_billing = $this->System_model->get_state($cust['state']);
		$country_order = $this->System_model->get_country($order['country']);
		if($order['msg'] == 'Paypal')
		{
			$py_type = 'Paypal';
		}
		else
		{
			$py_type = 'Credit Card';
		}

		$ship = $this->System_model->get_shipping($order['shipping_method']);
		
		$cart = $this->Cart_model->all($order['session_id']);
		
		$excel = new ExportDataExcel('file');
		$excel->filename = "order/order_export_id_".$order['id'].".xls";
		
		$excel->initialize();
		$row = array('line_type','orders_id','customer_barcode','customers_first_name','customers_last_name','customers_company','customers_street_address','customers_suburb','customers_city','customers_state','customers_postcode','customers_country','customers_telephone','customers_email_address','delivery_name','delivery_company','delivery_street_address','delivery_suburb','delivery_city','delivery_state','delivery_postcode','delivery_country','comments','billing_name','billing_company','billing_street_address','billing_suburb','billing_city','billing_state','billing_postcode','billing_country','currency','currency_value','payment_method','cc_type','date_purchased');
		$excel->addRow($row);
		$row = array('1',$order['id'],$cust['barcode'],$order['firstname'],$order['lastname'],'',$order['address'],$order['city'],$order['city'],$state_order,$order['postcode'],$country_order,'',$order['email'],$order['firstname'].' '.$order['lastname'],'',$order['address'],$order['city'],$order['city'],$state_order,$order['postcode'],$country_order,$order['message'],$cust['firstname'].' '.$cust['lastname'],$cust['tradename'],$cust['address'],$cust['suburb'],$cust['suburb'],$state_billing,$cust['postcode'],$cust['country'],'AUD','1.00',$py_type,$order['cardtype'],date('d/m/Y H:i',strtotime($order['order_time'])));
		$excel->addRow($row);
		$row = array('','orders_id','stock_id','products_quantity','text(optional)','products_price_ex','products_tax%','tax_code');
		$excel->addRow($row);
		
		//cart
		foreach($cart as $c)
		{
			$p = $this->Product_model->identify($c['product_id']);
			$row = array('2',$order['id'],$p['stock_id'],$p['title'],$c['price'],'10%','EXP');
			$excel->addRow($row);
		}
		
		$row = array('','orders_id','stock_id','title','text(optional)','value');
		$excel->addRow($row);
		$row = array('3',$order['id'],'','Sub-Total:',$order['total'].'(AUD)',$order['total']);
		$excel->addRow($row);
		$row = array('4',$order['id'],'',$order['coupon_code'],'<b>-'.$order['discount'].'(AUD)</b>',$order['discount']);
		$excel->addRow($row);
		$row = array('5',$order['id'],'',$ship['name'],$order['shipping_cost'].'(AUD)',$order['shipping_cost']);
		$excel->addRow($row);
		$row = array('6',$order['id'],'','Tax',$order['tax'].'(AUD)',$order['tax']);
		$excel->addRow($row);
		$row = array('7',$order['id'],'','Total:',$order['total'].'(AUD)',$order['total']);
		$excel->addRow($row);
		$excel->finalize();

	}
	
	function collect_update_stock()
	{
		//echo 123;
		
		$dir    = 'myob';
		$files1 = scandir($dir);
		
		$files = array();
		
		foreach($files1 as $fl)
		{
			if(strpos($fl,'StockExport') !== false)
			{
				//$fl=str_replace('.csv', '', $fl);
				array_push($files,$fl);
			}
		}
		
		if(count($files) > 0)
		{
			rsort($files);
			//print_r($files);
			
			//echo $files[0];
			//exit;
			
			$handle1 = fopen(base_url().'myob/'.$files[0], "r");
			$cc = 0; 
			while (($data = fgetcsv($handle1, 5000, ","))!== FALSE) 
			{
				if($cc != 0)
				{
					$temp = trim($data[28]) * 1;
					//echo $temp.'<br/>';
					if(is_int($temp))
					{
						//echo "<pre>".print_r($data,true)."</pre>";
						$ndata = array();
						$ndata['stock'] = $temp;
						$this->Product_model->update_with_stock_id($data[0],$ndata);
					}
				}
				$cc++;
			}
		}
		else 
		{
			echo "none";
		}
		
		
		
	}
	function update_customer()
	{
		exit;
		
		ini_set('include_path', ini_get('include_path').';../Classes/');
		
		/** Include PHPExcel */
		require_once 'PHPExcel/Classes/PHPExcel.php';
		include 'PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
		
		$customer_retailer = $this->Customer_model->get_updated_customer_cron();

		if(count($customer_retailer)>0)
		{
			foreach($customer_retailer as $cr)
			{
				// Create new PHPExcel object
				$state = $this->System_model->get_state($cr['state']);
				
				echo date('H:i:s') . " Create new PHPExcel object\n";
				$objPHPExcel = new PHPExcel();
				
				// Set properties
				echo date('H:i:s') . " Set properties\n";
				$objPHPExcel->getProperties()->setCreator("SR Web");
				$objPHPExcel->getProperties()->setLastModifiedBy("SR Web");
				$objPHPExcel->getProperties()->setTitle("XLS Order Document");
				$objPHPExcel->getProperties()->setSubject("XLS Order Document");
				$objPHPExcel->getProperties()->setDescription("Order");
				
				
				// Add some data
				echo date('H:i:s') . " Add some data\n";
				$objPHPExcel->setActiveSheetIndex(0);
				
				//header//
		
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'line_type');
				$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'orders_id');
				$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'customer_barcode');
				$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'customers_first_name');
				$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'customers_last_name');
				$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'customers_company');
				$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'customers_street_address');
				$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'customers_suburb');
				$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'customers_city');
				$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'customers_state');
				$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'customers_postcode');
				$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'customers_country');
				$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'customers_telephone');
				$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'customers_email_address');
				$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'delivery_name');
				$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'delivery_company');
				$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'delivery_street_address');
				$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'delivery_suburb');
				$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'delivery_city');
				$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'delivery_state');
				$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'delivery_postcode');
				$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'delivery_country');
				$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'comments');
				$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'billing_name');
				$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'billing_company');
				$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'billing_street_address');
				$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'billing_suburb');
				$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'billing_city');
				$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'billing_state');
				$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'billing_postcode');
				$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'billing_country');
				$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'currency');
				$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'currency_value');
				$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'payment_method');
				$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'cc_type');
				$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'date_purchased');
				
				//order header//
				
				
				
				$objPHPExcel->getActiveSheet()->SetCellValue('B2', '1');
				$objPHPExcel->getActiveSheet()->SetCellValue('C2', '0');
				$objPHPExcel->getActiveSheet()->SetCellValue('D2', $cr['id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E2', $cr['firstname']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F2', $cr['lastname']);
				$objPHPExcel->getActiveSheet()->SetCellValue('G2', $cr['tradename']);
				$objPHPExcel->getActiveSheet()->SetCellValue('H2', $cr['address']);
				$objPHPExcel->getActiveSheet()->SetCellValue('I2', $cr['suburb']);
				$objPHPExcel->getActiveSheet()->SetCellValue('J2', $cr['suburb']);
				$objPHPExcel->getActiveSheet()->SetCellValue('K2', $state);
				$objPHPExcel->getActiveSheet()->SetCellValue('L2', $cr['postcode']);
				$objPHPExcel->getActiveSheet()->SetCellValue('M2', $cr['country']);
				$objPHPExcel->getActiveSheet()->SetCellValue('N2', $cr['phone']);
				$objPHPExcel->getActiveSheet()->SetCellValue('O2', $cr['email']);
				$objPHPExcel->getActiveSheet()->SetCellValue('P2', $cr['firstname'].' '.$cr['lastname']);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q2', $cr['tradename']);
				$objPHPExcel->getActiveSheet()->SetCellValue('R2', $cr['address']);
				$objPHPExcel->getActiveSheet()->SetCellValue('S2', $cr['suburb']);
				$objPHPExcel->getActiveSheet()->SetCellValue('T2', $cr['suburb']);
				$objPHPExcel->getActiveSheet()->SetCellValue('U2', $state);
				$objPHPExcel->getActiveSheet()->SetCellValue('V2', $cr['postcode']);
				$objPHPExcel->getActiveSheet()->SetCellValue('W2', $cr['country']);
				$objPHPExcel->getActiveSheet()->SetCellValue('X2', '');
				$objPHPExcel->getActiveSheet()->SetCellValue('Y2', $cr['firstname'].' '.$cr['lastname']);
				$objPHPExcel->getActiveSheet()->SetCellValue('Z2', $cr['tradename']);
				$objPHPExcel->getActiveSheet()->SetCellValue('AA2', $cr['address']);
				$objPHPExcel->getActiveSheet()->SetCellValue('AB2', $cr['suburb']);
				$objPHPExcel->getActiveSheet()->SetCellValue('AC2', $cr['suburb']);
				$objPHPExcel->getActiveSheet()->SetCellValue('AD2', $state);
				$objPHPExcel->getActiveSheet()->SetCellValue('AE2', $cr['postcode']);
				$objPHPExcel->getActiveSheet()->SetCellValue('AF2', $cr['country']);
				$objPHPExcel->getActiveSheet()->SetCellValue('AG2', 'AUD');
				$objPHPExcel->getActiveSheet()->SetCellValue('AH2', '1.00');
				$objPHPExcel->getActiveSheet()->SetCellValue('AI2', '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AJ2', '');
				$objPHPExcel->getActiveSheet()->SetCellValue('AK2', date('d/m/Y H:i'));
				
				$this->db->where('id',1);
				$query = $this->db->get('system_save');
				$ss = $query->first_row('array');
				
				$ordern = $ss['order_export_order'];
				$long = strlen($ordern);
				$zero = 8 - $long;
				for($i = 0; $i < $zero; $i++)
				{
					$ordern = '0'.$ordern;
				}
				
				// Rename sheet
				echo date('H:i:s') . " Rename sheet\n";
				$objPHPExcel->getActiveSheet()->setTitle("order_export_".$ordern);
				
						
				// Save Excel 2007 file
				echo date('H:i:s') . " Write to Excel2007 format\n";
				$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
				$objWriter->save("myob/order_export_".$ordern.".xls");
				
				// Echo done
				echo date('H:i:s') . " Done writing file.\r\n";
				
				$ndata = array();
				$ndata['order_export_order'] = $ss['order_export_order'] + 1;
				$this->db->where('id',1);
				$this->db->update('system_save',$ndata);
			}
		}
	}
	
	function update_customer0()
	{
		$customer_retailer = $this->Customer_model->get_updated_customer_cron();
		if(count($customer_retailer)>0){
			$csvname = 'Customer'.'-'.date('dmY H:i:s').'.csv';
			$path = "./exportcsv/myob/";
			$dir = $path;
		   
			$this->load->helper('file');
			
			$fp = fopen($dir.'/'.$csvname,'w+');
			$strip = array("\r\n", "\n", "\r", ",");
					
			
			$headings = array('customer_id','barcode','grade','notes','comments','status','custom1','custom2','inactive','date_modified','surname','given_names','position','company','salution','account','opened_id','openedby','owner_id','accountmanager','limit','days','fromEOM','addr1','addr2','addr3','suburb','state','postcode','country','phone','fax','mobile','email','abn','overseas','external','date_created','is_barcode_printed','document_delivery_type','group_email_exclusion_id');
					
			//add headings in
					
			fputs($fp,implode($headings,',')."\n");
			
			foreach($customer_retailer as $cr)
			{
				
				$customer_id = $cr['webid'];
				$barcode = $cr['webid'];
				if($cr['membership_status'] == 1)
				{
					$grade=3;
				}
				if($cr['membership_status'] == 2)
				{
					$grade=2;
				}
				if($cr['membership_status'] == 3)
				{
					$grade=1;
				}
				$notes='';
				$comments='';
				$status = 0;
				if($cr['membership_status'] == 1)
				{
					$custom1 = 'Chic Addict';
				}
				if($cr['membership_status'] == 2)
				{
					$custom1 = 'Style Queen';
				}
				if($cr['membership_status'] == 3)
				{
					$custom1 = 'Glamour Icon';
				}
				
				$custom2 = $cr['date_dob'].'/'.$cr['month_dob'];
				$inactive = $cr['deleted'];
				$date_modified= $cr['modified'];
				$surname=$cr['lastname'];			
				$given_names=$cr['firstname'];
				if($cr['membership_status'] == 1)
				{
					$position = 'Chic Addict';
				}
				if($cr['membership_status'] == 2)
				{
					$position = 'Style Queen';
				}
				if($cr['membership_status'] == 3)
				{
					$position = 'Glamour Icon';
				}
				
				$company=$cr['tradename'];
				$salution = $cr['title'];
				$account = 0;
				$opened_id=0;
				$openedby=0;
				$owner_id=0;
				$accountmanager=0;
				$limit = '$0.00';
				$days=0;
				$fromEOM= 0;
				$addr1 = '"'.$cr['address'].'"';			
				$addr2 = '"'.$cr['address2'].'"';			
				$addr3 ='';
				$state= $this->System_model->get_state_code($cr['state']);
				$suburb= $cr['suburb'];
				$country= $cr['country'];
				$postcode= '"'.$cr['postcode'].'"';			
				$phone = $cr['phone'];
				$fax='';
				$mobile= $cr['mobile'];			
				$email = $cr['email'];
				$abn = $cr['abn'];
				if($country == 'Australia')
				{
					$overseas = 0;
				}
				else 
				{
					$overseas = 1;
				}
				$external = 0;
				$date_created = $cr['joined'];
				$is_barcode_printed = 0;
				$document_delivery_type = 0;
				$group_email_exclusion_id = 0;
				
				fputs($fp,implode(array($customer_id,$barcode,$grade,$notes,$comments,$status,$custom1,$custom2,$inactive,$date_modified,$surname,$given_names,$position,$company,$salution,$account,$opened_id,$openedby,$owner_id,$accountmanager,$limit,$days,$fromEOM,$addr1,$addr2,$addr3,$suburb,$state,$postcode,$country,$phone,$fax,$mobile,$email,$abn,$overseas,$external,$date_created,$is_barcode_printed,$document_delivery_type,$group_email_exclusion_id), ',')."\n");             
						
			}
			
			fclose($fp);
			
		}
	}
	function update_customer_bu()
	{
		$customer_retailer = $this->Customer_model->get_updated_customer_retailer();
		$csvname = 'Customer - retailer '.'-'.date('dmY').'.csv';
		$path = "./exportcsv/customer/retailer";
		$dir = $path;
	   
		$this->load->helper('file');
		
		$fp = fopen($dir.'/'.$csvname,'w+');
		$strip = array("\r\n", "\n", "\r", ",");
				
		$headings = array('ID','MEMBERSHIP STATUS','TITLE','FIRST NAME','SURNAME','BIRTH DATE','EMAIL','MOBILE','PHONE','ADDRESS','ADDRESS 2','STATE','COUNTRY','POSTCODE','SUBURB');

				
		//add headings in
				
		fputs($fp,implode($headings,',')."\n");
		
		foreach($customer_retailer as $cr)
		{
			
			$id = $cr['id'];
			if($cr['membership_status']==1){$membership_status = 'STATUS 1';}
			if($cr['membership_status']==2){$membership_status = 'STATUS 2';}
			if($cr['membership_status']==3){$membership_status = 'STATUS 3';}
			
			$title=$cr['title'];
			$first_name=$cr['firstname'];
			$surname=$cr['lastname'];			
			$birth_date = $cr['birthday'];
			$email = $cr['email'];
			$mobile= $cr['mobile'];			
			$phone = $cr['phone'];
			$address= '"'.$cr['address'].'"';			
			$address2= '"'.$cr['address2'].'"';			
			$state= $cr['state'];
			$suburb= $cr['suburb'];
			$country= $cr['country'];
			$postcode= '"'.$cr['postcode'].'"';			
						
			fputs($fp,implode(array($id,$membership_status,$title,$first_name,$surname,$birth_date,$email,$mobile,$address,$address2,$state,$country,$postcode,$suburb), ',')."\n");             
					
		}
		
		fclose($fp);
		
		$customer_trade = $this->Customer_model->get_updated_customer_trade();
		
		$csvname = 'Customer - trade '.'-'.date('dmY').'.csv';
		$path = "./exportcsv/customer/trade";
		$dir = $path;
	   
		$this->load->helper('file');
		
		$fp = fopen($dir.'/'.$csvname,'w+');
		$strip = array("\r\n", "\n", "\r", ",");
				
		$headings = array('ID','MEMBERSHIP STATUS','TITLE','FIRST NAME','SURNAME','BIRTH DATE','EMAIL','MOBILE','PHONE','ADDRESS','ADDRESS 2','STATE','COUNTRY','POSTCODE','SUBURB');
				
		//add headings in
				
		fputs($fp,implode($headings,',')."\n");
		
		foreach($customer_trade as $cr)
		{
			
			$id = $cr['id'];
			if($cr['membership_status']==1){$membership_status = 'STATUS 1';}
			if($cr['membership_status']==2){$membership_status = 'STATUS 2';}
			if($cr['membership_status']==3){$membership_status = 'STATUS 3';}
			
			$title=$cr['title'];
			$first_name=$cr['firstname'];
			$surname=$cr['lastname'];			
			$birth_date = $cr['birthday'];
			$email = $cr['email'];
			$mobile= $cr['mobile'];			
			$phone = $cr['phone'];
			$address= '"'.$cr['address'].'"';			
			$address2= '"'.$cr['address2'].'"';			
			$state= $cr['state'];
			$suburb= $cr['suburb'];
			$country= $cr['country'];
			$postcode= '"'.$cr['postcode'].'"';			
						
			fputs($fp,implode(array($id,$membership_status,$title,$first_name,$surname,$birth_date,$email,$mobile,$address,$address2,$state,$country,$postcode,$suburb), ',')."\n");             
					
		}
		
		fclose($fp);
	}

	function send_ecard_everyday()
	{
		//every 00:01 AM
		$today = date('Y-m-d');
		//echo $today;
		$sql = "select * from orders where send_on = '$today' and gift = 'Y'";
		//echo $sql;
		$query = $this->db->query($sql);
		$result = $query->result_array('array');
		
		foreach($result as $rs)
		{
			$this->send_ecard($rs['id']);
			//echo $rs['id'];
		}
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
							A gorgeous gift has been sent to you from Spencer &amp; Rutherford - Handbags Luggage and Accessories. It will be sent to '.$add.' within the next 14 days and will arrive by courier or eParcel.<br/>
							<br/>
							We Hope you enjoy your gift<br/>
							xo Spencer &amp; Rutherford
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
							<img alt="" src="'.base_url().'img/footer-ecard.png"/><br/>
							WWW.SPENCERANDRUTHERFORD.COM.AU
						</td>
					</tr>
				</table>';
				
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from($order['email']);
        
		$this->email->to($order['receipt_email']);
		$this->email->bcc('hans@propagate.com.au,peteryo11@gmail.com');
		
		$this->email->subject('Ecard @ Spencer and Rutherford Online Store');
		$this->email->message($msg);
		$this->email->send();
	}	
	
	function test_up()
	{
		$updata = array();
					$updata['webid'] = 'W109';
					$this->Customer_model->update('',$updata);
	}
	
	function read_cust_p()
	{
		//$myFile = base_url()."stock/1000.CUS";
		//$fh = fopen($myFile, 'r');
		$count = 0;
		$handle = @fopen(base_url()."stock/1000.CUS", "r");
		if ($handle) {
		    while (($buffer = fgets($handle, 4096)) !== false) {
		        //echo $buffer.'<br/>';
				$line = $buffer;
				$data = array();
				//$data = explode('\t', $line);
				$data = explode("\t", $line);
				//echo "<pre>".print_r($data,true)."</pre>";
				if($count == 0)
				{
					echo "<pre>".print_r($data,true)."</pre>";
					$count++;
				}
				if($data[3]=='A')
				{
					$ndata = array();
					$udata = array();
					
					$ndata['email'] = $data[7];
					$email = $data[7];
					$ndata['title'] = $data[4];
					$ndata['firstname'] = $data[5];
					$ndata['lastname'] = $data[6];
					$ndata['address'] = $data[9];
					$ndata['address2'] = $data[10];
					$ndata['suburb'] = $data[11];
					$state = $data[12];
					if($state == 'VIC')
					{
						$ndata['state'] = 1;
					}
					if($state == 'NSW')
					{
						$ndata['state'] = 2;
					}
					if($state == 'QLD')
					{
						$ndata['state'] = 3;
					}
					if($state == 'WA')
					{
						$ndata['state'] = 4;
					}
					if($state == 'TAS')
					{
						$ndata['state'] = 5;
					}
					if($state == 'NT')
					{
						$ndata['state'] = 6;
					}
					if($state == 'SA')
					{
						$ndata['state'] = 8;
					}
					if($state == 'ACT')
					{
						$ndata['state'] = 9;
					}
					
					$ndata['country'] = 'Australia';
					$ndata['postcode'] = $data[14];
					$ndata['phone'] = $data[8];
					$ndata['mobile'] = '';
					$ndata['month_dob'] = date('m',strtotime($data[7]));
					$ndata['date_dob'] = date('d',strtotime($data[7]));
					
					$nid = $data[0];
					$sql = "select spend from cs_spend where oid = '$nid'";
					$query = $this->db->query($sql);
					$row = $query->first_row('array');
					
					
					$ndata['total_spend'] = $row['spend'];
					if($data[2] == 'Chic Addict')
					{
						$ndata['membership_status'] = 1;
						echo "<pre>".print_r($ndata,true)."</pre>";
					}
					if($data[2] == 'Style Queen')
					{
						$ndata['membership_status'] = 2;
						echo "<pre>".print_r($ndata,true)."</pre>";
						//$count++;
					}
					if($data[2] == 'Glamour Icon')
					{
						$ndata['membership_status'] = 3;
						echo "<pre>".print_r($ndata,true)."</pre>";
					}
					
					//$customer_id = $this->Customer_model->add($ndata);
					//echo $customer_id;
					$updata = array();
					//$updata['webid'] = 'W'.$customer_id;
				//	print_r($updata);
					//$this->Customer_model->update($customer_id,$updata);
					
					
					
					//$udata['customer_id'] = $customer_id;
					$udata['username'] = $email;
					$udata['password'] = md5('changeme123');
					$udata['level'] = 1;
					$udata['activated'] = 1;
					$udata['banned'] = 0;
					//$user_id = $this->User_model->add($udata);
					
					$count++;
				}
		    }
		    if (!feof($handle)) {
		        echo "Error: unexpected fgets() fail\n";
		    }
		    fclose($handle);
			
			echo $count;
		}
	}
	
	function update_order_detail2()
	{
		$data['today_income'] = $this->Order_model->sales_date(date('Y-m-d'));
		$data['yesterday_income'] = $this->Order_model->sales_date(date('Y-m-d',strtotime('-1 day')));
		
		$data['this_month_income'] = $this->Order_model->sales_month(date('Y-m'));
		$data['last_month_income'] = $this->Order_model->sales_month(date('Y-m',strtotime('-1 month')));
		
		$data['this_year_income'] = $this->Order_model->sales_year(date('Y'));
		$data['last_year_income'] = $this->Order_model->sales_year(date('Y',strtotime('-1 year')));
		
		$data['best_product'] = $this->System_model->best_product();
		$data['best_category'] = $this->System_model->best_category();
		$data['best_customer'] = $this->System_model->best_customer();
		
		
		$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
		
		$alldate = "['1'";
		
		for($i = 1; $i<$num; $i++)
		{
			$j = $i+1;
			$alldate .= ",'$j'";
		}
		$alldate .= "]"; 
		//echo  $alldate;
		
		$data['listdate_month'] = $alldate;
		
		$listincome = "[";
		for($i = 1; $i<=$num; $i++)
		{
			if(strlen($i)==1) {$j = '0'.$i;} else {$j = $i;}
			$tday = date('Y-m-').$j;
			//echo $tday.'<br/>';
			$tincome = $this->Order_model->sales_date($tday);
			
			if($i==1)
			{
				$listincome .= "$tincome";
			}
			else
			{
				$listincome .= ",$tincome";
			}
			//echo $tincome.'<br/>';
		}
		$listincome .= "]";
		
		$data['listincome_month'] = $listincome;
		
		// every months this year
		
		$data['listmonth_year'] = "['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']";
		
		$listincome = "[";
		for($i = 1; $i<=12; $i++)
		{
			if(strlen($i)==1) {$j = '0'.$i;} else {$j = $i;}
			$tday = date('Y-').$j;
			//echo $tday.'<br/>';
			$tincome = $this->Order_model->sales_month($tday);
			
			if($i==1)
			{
				$listincome .= "$tincome";
			}
			else
			{
				$listincome .= ",$tincome";
			}
			//echo $tincome.'<br/>';
		}
		$listincome .= "]";
		
		$data['listincome_year'] = $listincome;
		
		$data['list_order_today'] = json_encode($this->Order_model->sales_date_list(date('Y-m-d')));
		
		
		
		$this->System_model->update_order_detail($data);
		
		// $edata['income'] = $this->Order_model->sales_date(date('Y-m-d',strtotime('-1 day')));
		// $edata['date'] = date('Y-m-d',strtotime('-1 day'));
		// $this->System_model->add_everyday_income($edata);
		
		
		//$this->statistic();
		
		//redirect('admin/order/statistic');
	}

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
	    // takes two dates formatted as YYYY-MM-DD and creates an
	    // inclusive array of the dates between the from and to dates.
	
	    // could test validity of dates here but I'm already doing
	    // that in the main script
	
	    $aryRange=array();
	
	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
	
	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}
	
	function refresh_dashboard()
	{
		$data['c_cat'] = count($this->Category_model->any());
		$data['all_cat_prod'] = count($this->Category_model->all_prod());
		$data['all_cat_page'] = count($this->Category_model->all_page());
		$data['all_galleries'] = count($this->Gallery_model->get_galleries());
		$data['all_banners'] = count($this->Content_model->get_banners());
		
		$data['all_prod'] =count($this->Product_model->all());
		$data['all_prod_config'] =count($this->Product_model->all_on_sale());
		$data['all_prod_in_stock'] =count($this->Product_model->all_in_stock());
		$data['all_prod_active'] =count($this->Product_model->all_active());
		$data['all_prod_disable'] =count($this->Product_model->all_disable());
		$data['all_prod_out_of_stock'] =count($this->Product_model->all_out_of_stock());
		$data['all_prod_hidden'] =count($this->Product_model->all_hidden());
		
		$data['all_retail_aus'] = count($this->Customer_model->all_retailer_aus());
		$data['all_new_retail_aus'] = count($this->Customer_model->all_retailer_aus_this_month(date('Y-m')));
		$data['all_retail_int'] = count($this->Customer_model->all_retailer_int());
		$data['all_new_retail_int'] = count($this->Customer_model->all_retailer_int_this_month(date('Y-m')));
		$data['all_trade'] = count($this->Customer_model->all_dealer());
		$data['all_new_trade'] = count($this->Customer_model->all_dealer_this_month(date('Y-m')));
		$data['all_subscribe'] = count($this->Subscribe_model->all());
		$data['all_new_subscribe'] = count($this->Subscribe_model->subscribe_this_month(date('Y-m')));
		
		$this->System_model->update_order_detail($data);
		
	}
	
	function update_order_daily()
	{
		$data['today_income'] = $this->Order_model->sales_date(date('Y-m-d'));
		$data['yesterday_income'] = $this->Order_model->sales_date(date('Y-m-d',strtotime('-1 day')));
		$data['list_order_today'] = json_encode($this->Order_model->sales_date_list(date('Y-m-d')));
		$this->System_model->update_order_detail($data);
	}
	
	function update_order_yearly()
	{
		
		$dbet = $this->createDateRangeArray(date('Y-m-d',strtotime('01-01-2013')), date('Y-m-d',strtotime('31-12-2013')));
		//echo "<pre>".print_r($dbet,true)."</pre>";
		
		//exit;
		$all_income = '';
		$cc = 0;
		
		foreach($dbet as $g)
		{
			if($cc  == 0)
			{
				$all_income .= $this->Order_model->sales_date(date('Y-m-d',strtotime($g)));
			}
			else 
			{
				$all_income .= ', '.$this->Order_model->sales_date(date('Y-m-d',strtotime($g)));
			}
			$cc++;
		}
		
		//echo "<pre>".print_r($get,true)."</pre>";
		
		$data['all_income'] = $all_income;
		$data['yyear_f'] = date('Y');
		$data['header_year_f'] = "This Year's Income";
		
		//echo $all_income;
		
		$this->System_model->update_order_detail($data);
	}
	
	
	function best_customer()
	{
		$data['best_customers'] = json_encode($this->System_model->best_customers());
		$data['earliest_date'] = $this->System_model->get_ealiest_income();
		$data['best_products'] = json_encode($this->System_model->best_products());
		$data['best_categories'] = json_encode($this->System_model->best_categories());
		
		$this->System_model->update_order_detail($data);
	}
	
	function last_month_income()
	{
		$list_last_month = $this->System_model->best_products_last_month();
		
		$list_date_lmonth = '';
		
		for($i=30; $i>=1; $i--)
		{
			$dt = date('d/m',strtotime('-'.$i.'days'));
			if($i == 30)
			{
				$list_date_lmonth.="'$dt'";
			}
			else
			{
				$list_date_lmonth.=",'$dt'";
			}
			
			
		}
		$data['list_date_lmonth']=$list_date_lmonth;
		
		foreach($list_last_month as $ac)
		{
			$prod = $this->Product_model->identify($ac['product_id']);
			$list_lmonth_income_arr[$cc]['prod_title'] = $prod['title'];
			$list_lmonth_income_arr[$cc]['income'] = "[";
			for($i=30; $i>=1; $i--)
			{
				$dt = date('Y-m-d',strtotime('-'.$i.'days'));
				//echo $tday.'<br/>';
				$tincome = $this->System_model->total_prod_per_day($ac['product_id'],$dt);
				//echo $tincome;
				if(!$tincome)
				{
					$tincome = 0;
				}
				if($i==30)
				{
					$list_lmonth_income_arr[$cc]['income'] .= "$tincome";
				}
				else
				{
					$list_lmonth_income_arr[$cc]['income'] .= ",$tincome";
				}
				//echo $tincome.'<br/>';
			}
			$list_lmonth_income_arr[$cc]['income'] .= "]";
			
			$cc++;
		}
		
		//echo "<pre>".print_r($list_lmonth_income_arr,true)."</pre>";

		$data['list_lmonth_income_arr'] = json_encode($list_lmonth_income_arr);
		
		$data['sales_all'] = $this->Order_model->sales_total();
		
		$this->System_model->update_order_detail($data);
	}
	
	function sales_date_per_cat()
	{
		
		
		$all_categories = $this->System_model->best_categories();
		
		$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
		
		$listincome_arr = Array();
		
		
		
		$cc = 0;
		
		foreach($all_categories as $ac)
		{
			$cat = $this->Category_model->identify($ac['category_id']);
			$listincome_arr[$cc]['cat_title'] = $cat['title'];
			$listincome_arr[$cc]['income'] = "[";
			
			for($i = 1; $i<=$num; $i++)
			{
				if($i<=date('j'))
				{
					if(strlen($i)==1) {$j = '0'.$i;} else {$j = $i;}
					$tday = date('Y-m-').$j;
					//echo $tday.'<br/>';
					$tincome = $this->System_model->sales_date_per_cat($tday,$ac['category_id']);
				}
				else
				{
					$tincome = '0.00';
				}
				
				
				if($i==1)
				{
					$listincome_arr[$cc]['income'] .= "$tincome";
				}
				else
				{
					$listincome_arr[$cc]['income'] .= ",$tincome";
				}
				//echo $tincome.'<br/>';
			}
			
			$listincome_arr[$cc]['income'] .= "]";
			
			$cc++;
		}
		
		$data['listincome_arr'] = json_encode($listincome_arr);
		
		$this->System_model->update_order_detail($data);
		print_r($listincome_arr);
		echo '<br/>'.$this->db->last_query();
	}
	function update_currency()
	{
		$this->update_currency_v2();

		/*
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
		*/
	}
	
	function update_currency_v2()
	{
		$countries = array(
							'usa' => 'USD',
							'eur' => 'EUR',
							'gbp' => 'GBP',
							'jpy' => 'JPY'
							);
							
		foreach($countries as $key=>$val){
			$exchange_rate = $this->_get_exchange_rate($val);
			if($exchange_rate){
				$data[$key] = round($exchange_rate,2);	
			}
		}
		#echo '<pre>'.print_r($data).'</pre>';
		$this->System_model->update_currency($data);
	}
	
	function _get_exchange_rate($currency_to,$currency_from = "AUD")
	{
		$api_key = "947279672175d684ef7f2b2c272b54b8659e2d92";
		$url = "http://currency-api.appspot.com/api/" . $currency_from . "/" . $currency_to .".json?key=" . $api_key;
		$result = file_get_contents($url);
		$result = json_decode($result);
		if ($result->success){
			return $result->rate;
		}
		return false;

	}
}