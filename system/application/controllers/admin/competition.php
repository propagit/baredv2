<?php

# Controller: Competition

class Competition extends Controller {

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
		
		$this->load->model('Competition_entry_model');
		$this->load->model('Competition_invites_model');
		$this->load->model('Competition_pool_model');
		#error_reporting(E_ALL);

	}
	
	
	/*
	
		The competion entries is currently showed in the Customers Section
		This controller has been written for future expansion 
	
	function index()
	{
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/competition/main_view');
		$this->load->view('admin/common/footer');	
	}
	*/
	
	function export_csv()
	{
		$csvdir = getcwd();
		$csvname = 'competition_'.date('d-m-Y');
		$csvname = $csvname.'.csv';
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');
		
		$headings = array('First Name', 'Last Name', 'Email', 'Customer ID', 'State', 'Country', 'Entry Date');
		fputcsv($fp,$headings);
		
		$competition_entry = $this->Competition_entry_model->get_all();
		
		foreach ($competition_entry as $entry){
			$clean_entry = $this->clean_text($entry);
			fputcsv($fp,array(
						$clean_entry['firstname'],$clean_entry['lastname'],$clean_entry['email'],$clean_entry['customer_id'],$clean_entry['state'],$clean_entry['country'],date('d/m/Y',strtotime($clean_entry['created_on']))
					));
		}
		fclose($fp);	
	}
	
	function clean_text($array){
		foreach($array as $key=>$val){
			$array[$key] = str_replace(array("\r", "\r\n", "\n", ","), "-",$val);	
		}
		return $array;
	}
	
	function export_competition()
	{
		$csvdir = getcwd();
		$csvname = 'competition_'.date('d-m-Y');
		$csvname = $csvname.'.csv';
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');
		
		$headings = array('First Name', 'Last Name', 'Email', 'Customer ID', 'State', 'Country', 'Friends Invited', 'Friends Entered', 'Pool Count');
		fputcsv($fp,$headings);
		$competition_entry = $this->Competition_entry_model->get_all('asc');
		foreach($competition_entry as $entry){
			$all_invites = $this->Competition_invites_model->get_invites_for_csv($entry['entry_id']);	
			$friends_entered = $this->Competition_entry_model->get_entry_by_inviter_token_for_csv($entry['user_token']);
			$pool_count = $this->Competition_pool_model->get_pool_count($entry['entry_id']);
			
			$clean_entry = $this->clean_text($entry);
			fputcsv($fp,array(
						$clean_entry['firstname'],$clean_entry['lastname'],$clean_entry['email'],$clean_entry['customer_id'],$clean_entry['state'],$clean_entry['country'],$this->_get_string($all_invites,'invitee_email'),$this->_get_string($friends_entered,'email'),$pool_count
					));
		}
		fclose($fp);	
	}
	
	function _get_string($array,$field){
		$str = '-';
		if($array){
			foreach($array as $arr){
				$str .= $arr[$field].'; ';	
			}
		}
		return trim($str,'; ');
	}
	
}