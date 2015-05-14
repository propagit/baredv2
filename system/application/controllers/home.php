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
		$this->load->model('Instagram_gallery_model');
	}
	
	function index()
	{
		$landing_page = $this->Landing_page_model->get_all();
		$data['landing_pages'] = $landing_page;
		$this->load->view('common/header');
		$this->load->view('home/landing_view',$data);
		$this->load->view('common/footer');	
	}
	
	function men()
	{
		# get mens tiles
		$data['tiles'] = $this->Tiles_model->get_active_tiles(MEN);
		$data['banners'] = $this->Content_model->get_active_banners_by_category(MEN);
		$data['feature_products'] = $this->Product_model->get_features_by_category(MEN);
		$data['instagram_gallery'] = $this->Instagram_gallery_model->get_active_instagram_gallery(MEN);
		$this->load->view('common/header');
		$this->load->view('home/main_view',isset($data) ? $data : NULL);
		$this->load->view('common/footer');	
	}
	
	function women()
	{
		$data['tiles'] = $this->Tiles_model->get_active_tiles(WOMEN);
		$data['banners'] = $this->Content_model->get_active_banners_by_category(WOMEN);
		$data['feature_products'] = $this->Product_model->get_features_by_category(WOMEN);
		$data['instagram_gallery'] = $this->Instagram_gallery_model->get_active_instagram_gallery(WOMEN);
		$this->load->view('common/header');
		$this->load->view('home/main_view',isset($data) ? $data : NULL);
		$this->load->view('common/footer');		
	}
	
	function get_instagram_product()
	{
		$instagram_gallery_id = $this->input->post('instagram_gallery_id');
		$product_id = $this->input->post('product_id');	
		$data['gallery'] = $this->Instagram_gallery_model->get_gallery_item($instagram_gallery_id);
		$data['product'] = $this->Product_model->identify($product_id);
		echo $this->load->view('home/common/instagram_modal_view', $data, true);
	}
	
	function test()
	{
		$this->load->view('home/tumbler');
	}
	
}