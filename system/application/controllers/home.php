<?php

# Controller: Home

class Home extends Controller {
	
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
	
	function index()
	{
		$landing_page = $this->Landing_page_model->get_all();
		$data['landing_pages'] = $landing_page;
		$this->load->view('common/header');
		$this->load->view('home',$data);
		$this->load->view('common/footer');	
	}
	
	function men()
	{
		$this->load->view('common/header');
		$this->load->view('home/men');
		$this->load->view('common/footer');	
	}
	
	function women()
	{
		$this->load->view('common/header');
		$this->load->view('home/women');
		$this->load->view('common/footer');		
	}
	
}