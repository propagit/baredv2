<?php
class Order extends Controller {
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
	}
	
	/* 1. 0. Dashboard */
	function index() {
		
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/common/footer');
	}
	
	function email_on_the_way($id)
	{
		$order = $this->Order_model->identify($id);
		$cust = $this->Customer_model->identify($order['customer_id']);
		$header_img = base_url().'img/email-header.png';
		$header = '	<table cellpadding="0" cellspacing="0" align="center" width="632">
						<tr>
							<td>
								
							</td>
						</tr>
					';
		$content = '	<tr>
							<td>
								<br/><br/>
								<span style="font-weight:700; font-size:18px">YOUR ORDER IS ON THE WAY...</span><br/><br/>
								Thank you for your recent order from our eBoutique. Your order has been dispatched from our warehouse and is on its way to you.<br/><br/>
								Your delivery and tracking details are below.<br/><br/>
								ORDER NO:<span style="color:#e3007b">'.$order['id'].'</span><br/><br/>
								SHIPPING METHOD:<br/><br/>
								<a href="'.$order['tracking_number'].'" style="color:#e3007b">Click here</a> to track your order.<br/><br/><br/><br/>
								Thank you for shopping at Bared Footware.<br/><br/>
								Should you have any questions or concers please contact custome service by emailing <a style="color:#e3007b" href="mailto:sales@bared.com.au">sales@bared.com.au</a> or calling +61 03 9509 5771.
								<br/><br/><br/>
							</td>
						</tr>';
		$footer = '		<tr>
							<td style="text-align:center">
								<span style="font-weight:700; font-size:18px; color: #000">WWW.BARED.COM.AU</span><br/>
								
							</td>
						</tr>
					</table>';
		$message = $header.$content.$footer;
		//								TRACKING NUMBER: <span style="color:#e3007b">'.$order['id'].'</span><br/><br/>
		
		
		//echo $message;
		//exit;
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from('noreply@bared.com.au','Bared Footware');
		$this->email->to($order['email']);
		$this->email->cc('peteryo11@gmail.com');
		$this->email->subject("Your order is on it's way @ Bared Footware");
		$this->email->message($message);
		$this->email->send();
	}
	
	function login_as_client($id)
	{
		$user = $this->User_model->identify_cust_id($id);
		$this->session->set_userdata('userloggedin',$user);
		
		redirect(base_url().'cart/account_page');
	}
	
	function change_order_status()
	{
		$id = $_POST['id'];
		$order = $this->Order_model->identify($id);
		if($_POST['status'] == 'shipped')
		{
			if($order['tracking_number'] != '')
			{
				$data['order_status'] = $_POST['status'];
				
				$this->Order_model->update($id,$data);
				
				$this->email_on_the_way($id);
			}
			else 
			{
				echo $order['order_status'];
			}
		}
		else
		{
			$data['order_status'] = $_POST['status'];
			
			$this->Order_model->update($id,$data);
		}
		
	}
	
	function order_customer($cust_id)
	{
		$this->session->set_userdata('customer_name','');
		$this->session->set_userdata('order_id','');
		$this->session->set_userdata('from_date','');
		$this->session->set_userdata('to_date','');
		$this->session->set_userdata('by_keyword','');
		$this->session->set_userdata('by_status','');
		$this->session->set_userdata('by_payment','');
		$this->session->set_userdata('by_ord_status','All');
		
		$this->session->set_userdata('customer_id',$cust_id);
		redirect('admin/order/list_all/search');
	}
	
	function list_all($action="",$period="")
	{
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		
		if ($action == "search") {
			if ($period == "total") {
				$orders = $this->Order_model->search_period("total","");
			} else if ($period == "month") {
				$orders = $this->Order_model->search_period("month",date('Y-m'));
			} else if ($period == "week") {
				$orders = $this->Order_model->search_period("week","");
			} else if ($period == "day") {
				$orders = $this->Order_model->search_period("day",date('Y-m-d'));
			} 
			else
			{
				//$orders = $this->Order_model->search($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4);
				$orders = $this->Order_model->search_v2($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4,$this->session->userdata('by_payment'),$this->session->userdata('by_ord_status'),$this->session->userdata('customer_id'));
			//search_v2($customer_name,$order_id,$from_date,$to_date,$by_keyword,$by_status, $by_typecustomer,$by_payment)
			}
			
			$total = 0;
			foreach($orders as $order) {
				if ($order['status'] == 'successful') {
					$total += $order['total'];
				}
			}
			
			$data['total'] = $total;
			$data['orders'] = $orders;
			$this->load->view('admin/order/list',$data);
			
		} else if ($action == "view") {
			$order = $this->Order_model->identify($period);
			if($order == NULL)
			{
				redirect('admin/store/order');
			}
			$this->load->model('Cart_model');
			$data['cart'] = $this->Cart_model->all($order['session_id']);
			$data['shipping'] = $this->System_model->get_shipping($order['shipping_method']);
			$data['order'] = $order;		
			$data['cust'] = $this->Customer_model->identify($order['customer_id']);			
			$data['comments'] = $this->Customer_model->all_comment($order['customer_id']);
			$this->load->view('admin/order/order',$data);
		} else {
			$data['orders'] = $this->Order_model->last(20);
			//$this->load->view('admin/order/list',$data);
			$this->load->view('admin/order/list',$data);
		}
		
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}

	function searchorder() {
		$this->session->set_userdata('customer_name',$_POST['customer_name']);
		$this->session->set_userdata('customer_id',$_POST['customer_id']);
		$this->session->set_userdata('order_id',$_POST['order_id']);
		$this->session->set_userdata('from_date',$_POST['from_date']);
		$this->session->set_userdata('to_date',$_POST['to_date']);
		$this->session->set_userdata('by_keyword',$_POST['by_keyword']);
		$this->session->set_userdata('by_payment','');
		$this->session->set_userdata('by_ord_status',$_POST['by_status']);
		//$this->session->set_userdata('by_typecustomer',$_POST['typecustomer']);
		$status=0;
		if(isset($_POST['by_status'])&&$_POST['by_status']==1){
			$status=1;
		}
		$this->session->set_userdata('by_status',$status);

		# store this search params to populate search params in the view
		$this->session->set_userdata('search_params',$_POST);

		redirect('admin/order/list_all/search');
	}
	
	function deleteorder($order_id) {
		$this->Order_model->delete($order_id);
		redirect('admin/order/list_all');
	}
	
	
	
	function exportorder($type='') {
		$csvdir = getcwd();
		//$csvdir = $csvdir.'/csv/';
		$csvname = 'Order_'.date('d-m-Y');
		$csvname = $csvname.'.csv';
		//$fp = fopen($csvdir.$csvname, 'w');	
		header('Content-type: application/csv; charset=utf-8;');
       header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');	
		if ($type == "total") {
				$orders = $this->Order_model->search_period("total","");
			} else if ($type == "month") {
				$orders = $this->Order_model->search_period("month",date('Y-m'));
			} else if ($type == "week") {
				$orders = $this->Order_model->search_period("week","");
			} else if ($type == "day") {
				$orders = $this->Order_model->search_period("day",date('Y-m-d'));
			} 
			else
			{
				//$orders = $this->Order_model->search($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4);
				$orders = $this->Order_model->search_v3($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4,$this->session->userdata('by_payment'),$this->session->userdata('by_ord_status'),$this->session->userdata('customer_id'));
			}			
			
			//$headings = array('Order ID','Customer Name','Order Date','Status','Tax','Shipping Cost','Total','Product Name');
			//if($this->session->userdata('by_typecustomer')==4){
			$headings = array('Order ID','Customer Name','Order Date','Status','Tax','Shipping Cost','Total','Product Name');
			//}
			
			fputcsv($fp,$headings);
			foreach($orders as $order) {				
				$this->load->model('Cart_model');
				$carts = $this->Cart_model->all($order['session_id']);
				$this->load->model('Product_model');
				$productname='';
				foreach($carts as $cart){
					$product = $this->Product_model->identify($cart['product_id']);
					if(!empty($product['title']))
						$productname.=$product['title'].'('.$cart['quantity'].')'.'; ';
				}
				
					$customer = $this->Customer_model->identify($order['customer_id']);
					fputcsv($fp,array($order['id'],$customer['firstname'].' '.$customer['lastname'],$order['order_time'],$order['order_status'],$order['tax'],$order['shipping_cost'],$order['total'],$productname));
				
				/*
				else
				{
				fputcsv($fp,array($order['id'],$order['firstname'].' '.$order['lastname'],$order['order_time'],$order['status'],$order['tax'],$order['shipping_cost'],$order['total'],$productname));
				}
				*/
			}
        	fclose($fp);
			//redirect(base_url().'csv/'.$csvname);		
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
	
	function statistic()
	{

		//$dbet = $this->createDateRangeArray('2013-02-15', '2013-04-05');
		
		//echo "<pre>".print_r($dbet,true)."</pre>";
		
		
		
		$order_detail = $this->System_model->get_order_detail();
		
		//error_reporting(E_ALL);
		// every days this month
		
		//filter for year
		if(isset($_POST['y_f']))
		{
			$yyear_f = $_POST['yyear_f'];
			$dbet = $this->createDateRangeArray(date('Y-m-d',strtotime('01-01-'.$yyear_f)), date('Y-m-d',strtotime('31-12-'.$yyear_f)));
			//echo "<pre>".print_r($dbet,true)."</pre>";
			
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
			$data['yyear_f'] = $yyear_f;
			$data['header_year_f'] = 'Income of '.$yyear_f;
		}
		else
		{
			
			
			$data['all_income'] = $order_detail['all_income'];
			$data['yyear_f'] = $order_detail['yyear_f'];
			$data['header_year_f'] = $order_detail['header_year_f'];
		}
		
		
		
		//filter for month
		if(isset($_POST['m_f']))
		{
			$m_f = 1;
			$mmonth_f = $_POST['mmonth_f'];
			$myear_f = $_POST['myear_f'];
			$num_mf = cal_days_in_month(CAL_GREGORIAN, $mmonth_f, $myear_f); 
			$monthName = date("F", mktime(0, 0, 0, $mmonth_f, 10));
			//echo $monthName;
			$data['mfilter_header'] = 'Income '.$monthName.' '.$myear_f;
			
			$alldate_mf = "['1'";
		
			for($i = 1; $i<$num_mf; $i++)
			{
				$j = $i+1;
				$alldate_mf .= ",'$j'";
			}
			$alldate_mf .= "]"; 
			//echo  $alldate;
			
			if($_POST['mstate_f'] != '-1')
			{
				$mfilter = 1;
				$mfilter_state = $_POST['mstate_f'];
				$data['mstate_f'] = ' - '.$this->System_model->get_state($mfilter_state);
				
			}
			else
			{
				$mfilter = 0;
				$data['mstate_f'] = '';
			}
		}
		else
		{
			$m_f = 0;
			$data['mstate_f'] = '';
			$data['mfilter_header'] = "This Month's Income";
		}
		
		
		
		//filter for best cat
		if(isset($_POST['filter_bcat']))
		{
			$bcatfilter = 1;
			$bcatfrom = $_POST['from_date_bcat'];
			$bcatto = $_POST['to_date_bcat'];
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			
			$dbet = $this->createDateRangeArray(date('Y-m-d',strtotime($bcatfrom)), date('Y-m-d',strtotime($bcatto)));
			
			$alldate = "[";
			$cc = 0;
			foreach($dbet as $dbt)
			{
				$dd = date('d/m',strtotime($dbt));
				if($cc == 0)
				{
					$alldate .= "'$dd'";
				}
				else 
				{
					$alldate .= ",'$dd'";
				}
				
				$cc++;
			}
			$alldate .= "]"; 
			//echo  $alldate;
			
			$data['listdate_month_bcat'] = $alldate;
			$data['h_bcat'] = ' - '.$bcatfrom.' to '.$bcatto;
		}
		else
		{
			$bcatfilter = 0;
			$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			//$data['mstate_f'] = '';
			$data['h_bcat'] = '';
		}
		
		
		
		//filter for best prod
		if(isset($_POST['filter_prod']))
		{
			$prodfilter = 1;
			$prodfrom = $_POST['from_date_prod'];
			$prodto = $_POST['to_date_prod'];
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			
			
			$data['h_prod'] = ' - '.$prodfrom.' to '.$prodto;
		}
		else
		{
			$prodfilter = 0;
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			//$data['mstate_f'] = '';
			$data['h_prod'] = '';
		}
		
		
		//filter for best cust
		if(isset($_POST['filter_cust']))
		{
			$custfilter = 1;
			$custfrom = $_POST['from_date_cust'];
			$custto = $_POST['to_date_cust'];
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			
			
			$data['h_cust'] = ' - '.$custfrom.' to '.$custto;
		}
		else
		{
			$custfilter = 0;
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			//$data['mstate_f'] = '';
			$data['h_cust'] = '';
		}
		
		
		
		$data['states'] = $this->System_model->get_states();
		if($m_f == 0)
		{
			$data['listdate_month'] = $order_detail['listdate_month'];
		}
		else
		{
			$data['listdate_month'] = $alldate_mf;
		}
		//$data['listincome_month'] = $order_detail['listincome_month'];
		if($m_f == 0)
		{
			$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		}
		else
		{
			$num = $num_mf;	
		}
		$listincome = "[";
		for($i = 1; $i<=$num; $i++)
		{
			if(strlen($i)==1) {$j = '0'.$i;} else {$j = $i;}
			if($m_f == 1)
			{
				$tday = $myear_f.'-'.$mmonth_f.'-'.$j;
			}
			else 
			{
				$tday = date('Y-m-').$j;
			}
			//echo $tday.'<br/>';
			if($m_f == 1)
			{
				if($mfilter == 1)
				{
					$tincome = $this->Order_model->sales_date_per_state($tday,$mfilter_state);
				}
				else 
				{
					$tincome = $this->Order_model->sales_date_per_state($tday,-1);
				}
			}
			else 
			{
				$tincome = $this->Order_model->sales_date($tday);
			}
			
			
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
		$data['listmonth_year'] = $order_detail['listmonth_year'];
		$data['listincome_year'] = $order_detail['listincome_year'];
		$data['list_order_today'] = json_decode($order_detail['list_order_today'],true);
		$data['order_detail'] = $order_detail;
		
		if($prodfilter)
		{
			$bprod = $this->System_model->best_products_between_date($prodfrom,$prodto);
		}
		else 
		{
			$bprod = json_decode($order_detail['best_products'],true);
		}
		
		
		
		//echo "<pre>".print_r($bprod,true)."</pre>";
		
		$prod_list = '';
		$prod_count = '';
		$cc=0;
		foreach($bprod as $bp)
		{
			if($cc < 10)
			{
				$p = $this->Product_model->identify($bp['product_id']);
				if($cc == 0)
				{
					$prod_list .= "'".$p['title']."'";
					$prod_count .=$bp['total'];
				}
				else
				{
					$prod_list .= ",'".$p['title']."'";
					$prod_count .=','.$bp['total'];
				}	
				$cc++;
			}
		}
		
		//print_r($prod_list);
		//print_r($prod_count);
		$data['ttl_prod'] = $cc;
		$data['prod_list'] = $prod_list;
		$data['prod_count'] = $prod_count;
		
		//exit;
		
		$data['best_categories'] = json_decode($order_detail['best_categories'],true);
// 		
		$all_categories = json_decode($order_detail['best_categories'],true);
// 		
		$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
// 		
		$listincome_arr = Array();
// 		
// 		
// 		
		// $cc = 0;
		if($bcatfilter)
		{
		 foreach($all_categories as $ac)
		 {
			 $cat = $this->Category_model->identify($ac['category_id']);
			 $listincome_arr[$cc]['cat_title'] = $cat['title'];
			 $listincome_arr[$cc]['income'] = "[";
			 
				 $i =1;
				 foreach($dbet as $dbt)
				 {
					 $tday = date('Y-m-d',strtotime($dbt));
					 $tincome = $this->System_model->sales_date_per_cat($tday,$ac['category_id']);
					 if($i==1)
					 {
						 $listincome_arr[$cc]['income'] .= "$tincome";
					 }
					 else
					 {
						 $listincome_arr[$cc]['income'] .= ",$tincome";
					 }
					 $i++;
				 }
			 
			
// 			
			 $listincome_arr[$cc]['income'] .= "]";
// 			
			 $cc++;
		 }
		 $data['listincome_arr'] = $listincome_arr;
		}
		else 
		{
			$data['listincome_arr'] = json_decode($order_detail['listincome_arr'],true);
		}
		
		
		if($custfilter)
		{
			$data['best_customers'] = $this->System_model->best_customers_between_date($custfrom,$custto);
		}
		else 
		{
			$data['best_customers'] = json_decode($order_detail['best_customers'],true);
		}
		
		
		$data['earliest_date'] = $order_detail['earliest_date'];
		
		
		
		//$get = $this->System_model->get_all_income();
		
		
		
		/*
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
				
				
				
				
				$list_lmonth_income_arr = Array();
				
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
				}*/
		
		
		//echo "<pre>".print_r($list_lmonth_income_arr,true)."</pre>";
		
		$data['list_date_lmonth']=$order_detail['list_date_lmonth'];

		$data['list_lmonth_income_arr'] = json_decode($order_detail['list_lmonth_income_arr'],true);
		
		$data['sales_all'] = $order_detail['sales_all'];
		
		//echo "<pre>".print_r($data,true)."</pre>";
		//exit;
		//echo $list_date_lmonth;
		
		//exit;
		
		
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/order/statistic',$data);
		$this->load->view('admin/common/footer');
	}
	
	
	
	function statistic_old()
	{
		
		//$dbet = $this->createDateRangeArray('2013-02-15', '2013-04-05');
		
		//echo "<pre>".print_r($dbet,true)."</pre>";
		
		$order_detail = $this->System_model->get_order_detail();
		
		error_reporting(E_ALL);
		// every days this month
		
		//filter for year
		if(isset($_POST['y_f']))
		{
			$yyear_f = $_POST['yyear_f'];
			$dbet = $this->createDateRangeArray(date('Y-m-d',strtotime('01-01-'.$yyear_f)), date('Y-m-d',strtotime('31-12-'.$yyear_f)));
			//echo "<pre>".print_r($dbet,true)."</pre>";
			
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
			$data['yyear_f'] = $yyear_f;
			$data['header_year_f'] = 'Income of '.$yyear_f;
		}
		else
		{
			$dbet = $this->createDateRangeArray(date('Y-m-d',strtotime('01-01-2013')), date('Y-m-d',strtotime('31-12-2013')));
			//echo "<pre>".print_r($dbet,true)."</pre>";
			
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
		}
		
		//filter for month
		if(isset($_POST['m_f']))
		{
			$m_f = 1;
			$mmonth_f = $_POST['mmonth_f'];
			$myear_f = $_POST['myear_f'];
			$num_mf = cal_days_in_month(CAL_GREGORIAN, $mmonth_f, $myear_f); 
			$monthName = date("F", mktime(0, 0, 0, $mmonth_f, 10));
			//echo $monthName;
			$data['mfilter_header'] = 'Income '.$monthName.' '.$myear_f;
			
			$alldate_mf = "['1'";
		
			for($i = 1; $i<$num_mf; $i++)
			{
				$j = $i+1;
				$alldate_mf .= ",'$j'";
			}
			$alldate_mf .= "]"; 
			//echo  $alldate;
			
			if($_POST['mstate_f'] != '-1')
			{
				$mfilter = 1;
				$mfilter_state = $_POST['mstate_f'];
				$data['mstate_f'] = ' - '.$this->System_model->get_state($mfilter_state);
				
			}
			else
			{
				$mfilter = 0;
				$data['mstate_f'] = '';
			}
		}
		else
		{
			$m_f = 0;
			$data['mstate_f'] = '';
			$data['mfilter_header'] = "This Month's Income";
		}
		
		//filter for best cat
		if(isset($_POST['filter_bcat']))
		{
			$bcatfilter = 1;
			$bcatfrom = $_POST['from_date_bcat'];
			$bcatto = $_POST['to_date_bcat'];
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			
			$dbet = $this->createDateRangeArray(date('Y-m-d',strtotime($bcatfrom)), date('Y-m-d',strtotime($bcatto)));
			
			$alldate = "[";
			$cc = 0;
			foreach($dbet as $dbt)
			{
				$dd = date('d/m',strtotime($dbt));
				if($cc == 0)
				{
					$alldate .= "'$dd'";
				}
				else 
				{
					$alldate .= ",'$dd'";
				}
				
				$cc++;
			}
			$alldate .= "]"; 
			//echo  $alldate;
			
			$data['listdate_month_bcat'] = $alldate;
			$data['h_bcat'] = ' - '.$bcatfrom.' to '.$bcatto;
		}
		else
		{
			$bcatfilter = 0;
			$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			//$data['mstate_f'] = '';
			$data['h_bcat'] = '';
		}
		
		//filter for best prod
		if(isset($_POST['filter_prod']))
		{
			$prodfilter = 1;
			$prodfrom = $_POST['from_date_prod'];
			$prodto = $_POST['to_date_prod'];
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			
			
			$data['h_prod'] = ' - '.$prodfrom.' to '.$prodto;
		}
		else
		{
			$prodfilter = 0;
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			//$data['mstate_f'] = '';
			$data['h_prod'] = '';
		}
		
		
		//filter for best cust
		if(isset($_POST['filter_cust']))
		{
			$custfilter = 1;
			$custfrom = $_POST['from_date_cust'];
			$custto = $_POST['to_date_cust'];
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			
			
			$data['h_cust'] = ' - '.$custfrom.' to '.$custto;
		}
		else
		{
			$custfilter = 0;
			//$data['listdate_month_bcat'] = $order_detail['listdate_month'];
			//$data['mstate_f'] = '';
			$data['h_cust'] = '';
		}
		
		
		
		$data['states'] = $this->System_model->get_states();
		if($m_f == 0)
		{
			$data['listdate_month'] = $order_detail['listdate_month'];
		}
		else
		{
			$data['listdate_month'] = $alldate_mf;
		}
		//$data['listincome_month'] = $order_detail['listincome_month'];
		if($m_f == 0)
		{
			$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		}
		else
		{
			$num = $num_mf;	
		}
		$listincome = "[";
		for($i = 1; $i<=$num; $i++)
		{
			if(strlen($i)==1) {$j = '0'.$i;} else {$j = $i;}
			if($m_f == 1)
			{
				$tday = $myear_f.'-'.$mmonth_f.'-'.$j;
			}
			else 
			{
				$tday = date('Y-m-').$j;
			}
			//echo $tday.'<br/>';
			if($m_f == 1)
			{
				if($mfilter == 1)
				{
					$tincome = $this->Order_model->sales_date_per_state($tday,$mfilter_state);
				}
				else 
				{
					$tincome = $this->Order_model->sales_date_per_state($tday,-1);
				}
			}
			else 
			{
				$tincome = $this->Order_model->sales_date($tday);
			}
			
			
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
		$data['listmonth_year'] = $order_detail['listmonth_year'];
		$data['listincome_year'] = $order_detail['listincome_year'];
		$data['list_order_today'] = json_decode($order_detail['list_order_today'],true);
		$data['order_detail'] = $order_detail;
		
		if($prodfilter)
		{
			$bprod = $this->System_model->best_products_between_date($prodfrom,$prodto);
		}
		else 
		{
			$bprod = $this->System_model->best_products();
		}
		
		
		
		//echo "<pre>".print_r($bprod,true)."</pre>";
		
		$prod_list = '';
		$prod_count = '';
		$cc=0;
		foreach($bprod as $bp)
		{
			if($cc < 10)
			{
				$p = $this->Product_model->identify($bp['product_id']);
				if($cc == 0)
				{
					$prod_list .= "'".$p['title']."'";
					$prod_count .=$bp['total'];
				}
				else
				{
					$prod_list .= ",'".$p['title']."'";
					$prod_count .=','.$bp['total'];
				}	
				$cc++;
			}
		}
		
		//print_r($prod_list);
		//print_r($prod_count);
		$data['ttl_prod'] = $cc;
		$data['prod_list'] = $prod_list;
		$data['prod_count'] = $prod_count;
		
		//exit;
		
		$data['best_categories'] = $this->System_model->best_categories();
		
		$all_categories = $this->System_model->best_categories();
		
		$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
		
		$listincome_arr = Array();
		
		$cc = 0;
		
		foreach($all_categories as $ac)
		{
			$cat = $this->Category_model->identify($ac['category_id']);
			$listincome_arr[$cc]['cat_title'] = $cat['title'];
			$listincome_arr[$cc]['income'] = "[";
			if($bcatfilter)
			{
				$i =1;
				foreach($dbet as $dbt)
				{
					$tday = date('Y-m-d',strtotime($dbt));
					$tincome = $this->System_model->sales_date_per_cat($tday,$ac['category_id']);
					if($i==1)
					{
						$listincome_arr[$cc]['income'] .= "$tincome";
					}
					else
					{
						$listincome_arr[$cc]['income'] .= ",$tincome";
					}
					$i++;
				}
			}
			else 
			{
				for($i = 1; $i<=$num; $i++)
				{
					if(strlen($i)==1) {$j = '0'.$i;} else {$j = $i;}
					$tday = date('Y-m-').$j;
					//echo $tday.'<br/>';
					$tincome = $this->System_model->sales_date_per_cat($tday,$ac['category_id']);
					
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
			}
			
			$listincome_arr[$cc]['income'] .= "]";
			
			$cc++;
		}
		
		$data['listincome_arr'] = $listincome_arr;
		if($custfilter)
		{
			$data['best_customers'] = $this->System_model->best_customers_between_date($custfrom,$custto);
		}
		else 
		{
			$data['best_customers'] = $this->System_model->best_customers();
		}
		
		
		$data['earliest_date'] = $this->System_model->get_ealiest_income();
		
		
		
		//$get = $this->System_model->get_all_income();
		
		
		
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
		
		$list_lmonth_income_arr = Array();
		
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

		$data['list_lmonth_income_arr'] = $list_lmonth_income_arr;
		
		$data['sales_all'] = $this->Order_model->sales_total();
		
		//echo $list_date_lmonth;
		
		
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/order/statistic',$data);
		$this->load->view('admin/common/footer');
	}

	function update_order_detail()
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
		
		
		
		echo 1;
	}

	function get_yesterday_income()
	{
		$edata['income'] = $this->Order_model->sales_date(date('Y-m-d',strtotime('-1 day')));
		//$edata['income'] = $this->Order_model->sales_date(date('Y-m-d',strtotime('01-06-2013')));
		$edata['date'] = date('Y-m-d',strtotime('-1 day'));
		//$edata['date'] = date('Y-m-d',strtotime('01-06-2013'));
		$this->System_model->add_everyday_income($edata);
		
		
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
		
		redirect('admin/order/statistic');
	}

	
	function try_income()
	{
		$get = $this->System_model->get_ealiest_income();
		
		echo "<pre>".print_r($get,true)."</pre>";
		
		$get = $this->System_model->get_all_income();
		
		echo "<pre>".print_r($get,true)."</pre>";
	}
	
	function set_tracking_number()
	{
		$id = $_POST['id'];
		$track = $_POST['track'];
		
		$data['tracking_number'] = $track;
		
		$this->Order_model->update($id,$data);
	}
	
	function show_stat($type)
	{
		$this->session->set_userdata('stat_type',$type);
		
		redirect('admin/order/statistic');
	}

	function export_eparcel_csv($type="")
	{
		$csvname = "Bared-eParcel-orders-" . date("d-m-Y") . ".csv";
		ob_start();
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename='.$csvname);
		header('Expires: 0');
		header("Content-Transfer-Encoding: binary");
		// Generate the server headers
		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
		{
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header("Content-Transfer-Encoding: binary");
			header('Pragma: public');
		}
		else
		{
			header('Pragma: no-cache');
		}
		
		if ($type == "total") {
			$orders = $this->Order_model->search_period("total","");
		} else if ($type == "month") {
			$orders = $this->Order_model->search_period("month",date('Y-m'));
		} else if ($type == "week") {
			$orders = $this->Order_model->search_period("week","");
		} else if ($type == "day") {
			$orders = $this->Order_model->search_period("day",date('Y-m-d'));
		} 
		else
		{
			$orders = $this->Order_model->search_orders_for_eParcel($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4,$this->session->userdata('by_payment'),$this->session->userdata('by_ord_status'),$this->session->userdata('customer_id'));
		}	

		 
		#echo '<pre>' . print_r($orders,true) . '</pre>';exit;  
		$csv = "";
		if($orders){
			foreach($orders as $order){
				
				$country = $this->System_model->get_country1($order['country']);

				$csv .=  "C" . "," . 
						" " . "," . 
						" " . "," . 
						"S1" . "," . 
						" " . "," . 
						$order['firstname'] . " " . $order['lastname'] . "," . 
						" " . "," . 
						$this->_clean_csv($order['address']) . "," .
						$this->_clean_csv($order['address2']) . "," .
						" " . "," .
						" " . "," .  
						$order['city'] . "," .
						$this->System_model->get_state_code($order['state']) . "," .
						$order['postcode'] . "," .
						$country['code'] . "," .
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						"N" . "," .
						" " . "," . 
						" " . "," . 
						"N" . "," .
						" " . "," . 
						$order['order_id'] . "," .
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						"Bared Pty Ltd" . "," .
						"1098 High St" . "," .
						" " . "," . 
						" " . "," . 
						" " . "," . 
						"ARMADALE" . "," .
						"VIC" . "," .
						"3143" . "," .
						"AU" . "," .
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						$order['email'] . "," .
						"TRACKADV" . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						" " . "," . 
						"Y" . "\r\n";
						
						# new line for the same order filled with constant values
				$csv .= "A" . "," .
						"4.2" . "," .
						"32" . "," .
						"21" . "," .
						"21" . "," .
						$this->Order_model->get_order_qty($order['session_id']) . "\r\n";		
				
			}
				
		}
		echo $csv;
		ob_end_flush();
		
	}
	
	function _clean_csv($string){
		return str_replace(array("\r", "\r\n", "\n", ","), "-",$string);	
	}
}
?>