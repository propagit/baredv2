<?php

# Controller: Store

class Devstore extends Controller {

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
	
	
	function product($cat_name='',$scat_name='')
	{
		$this->session->set_userdata('look_by','');
		$this->session->set_userdata('text_keyword','');
		redirect(base_url().'store/products/'.$cat_name.'/'.$scat_name);
	}

	function products($cat_name='',$scat_name='',$look_by=0,$text=0,$limit =0,$row=0)
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
		$this->load->view('dev/new_list_product');
		$this->load->view('common/footer');
		
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
		
		$this->load->view('common/header',$data);
		//$this->load->view('common/header');
		if($product['gift_card'] != 1)
		{
			$this->load->view('dev/detail_product');
		}
		else 
		{
			$this->load->view('dev/detail_gcard');
		}
		$this->load->view('common/footer');
	}
	
	
}