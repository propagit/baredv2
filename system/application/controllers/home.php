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
		
		$landing_page = $this->Landing_page_model->get_all();
		$data['landing_pages'] = $landing_page;
		$this->load->view('common/header',$data);
		$this->load->view('home/landing_view',$data);
		$this->load->view('common/footer');	
	}
	
	function men()
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
		
		# get mens tiles
		$data['tiles'] = $this->Tiles_model->get_active_tiles(MEN);
		$data['banners'] = $this->Content_model->get_active_banners_by_category(MEN);
		$data['feature_products'] = $this->Product_model->get_features_by_category(MEN);
		$data['instagram_gallery'] = $this->Instagram_gallery_model->get_active_instagram_gallery(MEN);
		$this->load->view('common/header',$data);
		$this->load->view('home/main_view',isset($data) ? $data : NULL);
		$this->load->view('common/footer');	
	}
	
	function women()
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
		
		$data['tiles'] = $this->Tiles_model->get_active_tiles(WOMEN);
		$data['banners'] = $this->Content_model->get_active_banners_by_category(WOMEN);
		$data['feature_products'] = $this->Product_model->get_features_by_category(WOMEN);
		$data['instagram_gallery'] = $this->Instagram_gallery_model->get_active_instagram_gallery(WOMEN);
		$this->load->view('common/header',$data);
		$this->load->view('home/main_view',isset($data) ? $data : NULL);
		$this->load->view('common/footer');		
	}
	
	function get_instagram_product()
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
		$instagram_gallery_id = $this->input->post('instagram_gallery_id');
		$product_id = $this->input->post('product_id');	
		$data['gallery'] = $this->Instagram_gallery_model->get_gallery_item($instagram_gallery_id);
		$data['product'] = $this->Product_model->identify($product_id);
		$data['next_prev'] = $this->get_next_prev($instagram_gallery_id);
		echo $this->load->view('home/common/instagram_modal_view', $data, true);
	}
	
	function _test_tumbler()
	{
		$this->load->view('home/tumbler');
	}
	
	function get_next_prev($instagram_gallery_id)
	{
		$instagram =  $this->Instagram_gallery_model->get_gallery_item($instagram_gallery_id);
		$category = $instagram['home_category'];
		$instagram_gallery = $this->Instagram_gallery_model->get_active_instagram_gallery($category);
		$item_counter = 0;
		$total = count($instagram_gallery);
		foreach($instagram_gallery as $gallery){ 
			if($instagram_gallery_id == $gallery['instagram_gallery_id']){
				# populate next and prev
				if(!$item_counter){
					# if this is the first item
					# next item will be the second
					$next_item = $instagram_gallery[$item_counter + 1];
					# last item
					$prev_item = $instagram_gallery[$total - 1];
				}else if($item_counter >= ($total - 1)){
					# if last item reached
					# next item will be the firs item
					$next_item = $instagram_gallery[0];
					# prev item will be the second last item
					$prev_item = $instagram_gallery[$item_counter - 1];
				}else{
					$next_item = $instagram_gallery[$item_counter+1];
					$prev_item = $instagram_gallery[$item_counter-1];
				}
			}
			$item_counter++;
		}
		
		return array(
						'next_instagram_gallery_id' => $next_item['instagram_gallery_id'],
						'next_instagram_product_id' => $next_item['product_id'],
						'prev_instagram_gallery_id' => $prev_item['instagram_gallery_id'],
						'prev_instagram_product_id' => $prev_item['product_id'],
					);
	}
	
	
	# to test new pages etc
	function test()
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
		$this->load->view('dump/test',isset($data) ? $data : NULL);
		$this->load->view('common/footer');			
	}
	
	function bared_difference()
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
		$this->load->view('dump/bared_difference',isset($data) ? $data : NULL);
		$this->load->view('common/footer');			
	}
	
}