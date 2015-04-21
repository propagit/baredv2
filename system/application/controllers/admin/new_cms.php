<?php
class New_cms extends Controller {
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		$this->load->model('Menu_model'); 
        $this->load->model('Gallery_model');      
        $this->load->model('User_model'); 
		$this->load->model('Cute_model');
		$this->load->model('Cute_model2');    
		//$this->load->model('System_model');    
		$this->load->model('Content_model');   
		
		
		
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
		
		$order_detail = $this->System_model->get_order_detail();
		
		$data['listdate_month'] = $order_detail['listdate_month'];
		$data['listincome_month'] = $order_detail['listincome_month'];
		$data['listmonth_year'] = $order_detail['listmonth_year'];
		$data['listincome_year'] = $order_detail['listincome_year'];
		$data['list_order_today'] = json_decode($order_detail['list_order_today'],true);
		$data['order_detail'] = $order_detail;
		
		$last5 = $this->Order_model->last(5);
		$last5_c = $this->Customer_model->last(5);
		
		$data['last5'] = $last5;
		$data['last5_c'] = $last5_c;
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
		
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/new_common/footer');
	}
	
	function homepage()
	{
		$data['homepage'] = $this->Menu_model->get_setting();
		
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_cms/homepage',$data);
		$this->load->view('admin/new_common/footer');
	}
	function update_setting($id,$type,$value)
	{
		if($type==1){$data['promotions']=$value;}
		if($type==2){$data['stories']=$value;}
		if($type==3){
			$data['published']=0;
			$this->Menu_model->update_setting(1,$data);
			$this->Menu_model->update_setting(2,$data);
			$this->Menu_model->update_setting(3,$data);
			$data['published']=$value;
		}
		$this->Menu_model->update_setting($id,$data);
		redirect('admin/new_cms/homepage');
	}
	function preview_template($type)
	{
		//$this->check_session();
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
		
		$data['banners'] = $this->Content_model->get_active_banners();
		$data['promotions'] = $this->System_model->get_active_home_promotions();
		$data['stories'] = $this->System_model->get_active_home_stories();
		$data['features1'] = $this->Product_model->get_features1();
		$data['features2'] = $this->Product_model->get_features2();
		$data['features3'] = $this->Product_model->get_features3();
		$cc = 1;
		$first6 = array();
		$second6 = array();
		$prod12 = $this->Product_model->random12();
		//echo "<pre>".print_r($prod12,true)."</pre>";
		foreach($prod12 as $item)
		{
			if($cc<=6)
			{
				$first6[$cc-1] = $item['id'];
			}
			else
			{
				$second6[$cc-7] = $item['id'];
			}
			$cc++;
		}
		$data['first6'] = $this->Product_model->get_features1();
		$data['second6'] = $this->Product_model->get_features2();
		//echo "<pre>".print_r($first6,true)."</pre>";
		//exit;
		$this->load->view('common/header',$data);
		//$hm=$this->Menu_model->get_setting_active();
		$data['homepage']=$this->Menu_model->get_setting_type($type);
		if($type==1){$this->load->view('template1',$data);}
		if($type==2){$this->load->view('template2',$data);}
		if($type==3){$this->load->view('template3',$data);}
		$this->load->view('common/footer');
	}
	
	function page($action="",$page_id="") {
		if ($action == "") {
			//$data['locations'] = $this->Content_model->get_locations();
			$data['categories'] = $this->Content_model->get_categories();
			$data['first_cat'] = $this->Content_model->get_first_category();
			$data['id_cat']=0;
			$this->load->view('admin/new_common/header');
			$this->load->view('admin/new_common/leftbar');
			$this->load->view('admin/new_cms/page',$data);
			$this->load->view('admin/new_common/footer');
		} else if ($action == "content") {
			$data['page'] = $this->Content_model->id($page_id);			
			$this->load->view('admin/cms/pagecontent',$data);
		} else if ($action == "menu") {
			$data['page'] = $this->Content_model->id($page_id);
			$data['menu'] = $this->Menu_model->mid();
			$data['menus'] = $this->Content_model->get_menus($page_id);
			$data['staff'] = $this->Staff_model->search('');
			$data['staffs'] = $this->Content_model->get_staffs($page_id);
			$this->load->view('admin/cms/pagemenu',$data);
		} else if ($action == "gallery") {
			$page = $this->Content_model->id($page_id);
			$data['galleries'] = $this->Gallery_model->get_galleries();
			$gallery_id = $page['gallery'];
			if ($gallery_id == 0) { $gallery_id = 2; } # National gallery
			$data['photos'] = $this->Gallery_model->get_photos($gallery_id);	
			$data['page'] = $page;
			$this->load->view('admin/cms/pagegallery',$data);
		} else if ($action == "copy") {
			$data['page'] = $this->Content_model->id($page_id);
			$data['root'] = $this->Content_model->root_categories();
			//$data['locations'] = $this->Content_model->get_locations();
			$this->load->view('admin/cms/pagecopy',$data);
		}
		
	}
	function page_category($id_cat)
	{
		$data['categories'] = $this->Content_model->get_categories();
		$data['first_cat'] = $this->Content_model->get_first_category();
		$data['id_cat']=$id_cat;
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_cms/page',$data);
		$this->load->view('admin/new_common/footer');
	}
	function editpage($id='')
    {
        $data['pages'] = $this->Menu_model->getpage($id);
        $data['categories'] =$this->Menu_model->get_category_detail($data['pages']['category_id']);
		$data['menus'] =$this->Menu_model->get_menus();
        $this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
        $this->load->view('admin/new_cms/editpage',$data);
        $this->load->view('admin/new_common/footer'); 
        
    }
	
	function showpage($id='')
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
		$data['pages'] = $this->Menu_model->getpage($id);
        $this->load->view('common/header',$data);
		$this->load->view('admin/new_cms/show_new',$data);
		$this->load->view('common/footer',$data);

	}
	
	function updatepage()
    {
        $id=$this->input->post('id');
        $title=$this->input->post('title');
        $content=$this->input->post('content_text');
		$parent=$this->input->post('menu');
		$category=$this->input->post('category');
		$meta_title=$this->input->post('meta_title');
		$meta_description=$this->input->post('meta_description');

        $name='';
        if((!empty($_FILES['userfile']['name'])))
		{
			$config['upload_path'] = "uploads/pages/";
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '4096'; // 4 MB
			$config['max_width']  = '4000';
			$config['max_height']  = '4000';
			$config['overwrite'] = FALSE;
			$config['remove_space'] = TRUE;
			
			$this->load->library('upload', $config);
			
			
			if ( ! $this->upload->do_upload()) {
				$this->session->set_flashdata('error_upload',$this->upload->display_errors());
				redirect('page/index');		
			
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$name = $data['upload_data']['file_name'];
				$width = $data['upload_data']['image_width'];
				$height = $data['upload_data']['image_height'];
				//$link=base_url()."uploads/files/".$name;							
			}
		}  
		        	
		$data=array(
			'title' => $title,
			'content' => $content,
			'parent' => $parent,
			'meta_title' => $meta_title,
			'meta_description' => $meta_description,
			'category' => $category,
			'modified' => date('Y-m-d H:i:s')
		);
		if($name<>'')
		{$data['background']=$name;}
		
		
        if($this->Menu_model->updatepage($id,$data))
        {
            $this->session->set_flashdata('status','success');
            redirect('admin/new_cms/editpage/'.$id);
        }       
        
    }

	function getcats() {
		$id_cat = $_POST['id_cat'];
		$categories = $this->Content_model->get_categories();
		$category_id = $this->session->userdata('category_id');
		if($id_cat<>0){$category_id=$id_cat;}
		$out = '
			<select class="selectpicker" id="category_id" onChange="getpages()">';
		foreach($categories as $category) {
			$out .= '<option value="'.$category['id'].'"';
			if ($category_id == $category['id']) { $out .= ' selected="selected"'; }
			$out .= '>'.$category['name'].'</option>';
			$children = $this->Content_model->sub_categories($category['id']);
			if($children) {
				foreach($children as $child) {
					$out .= '<option value="'.$child['id'].'"';
					if ($category_id == $child['id']) { $out .= ' selected="selected"'; }
					$out .= '>|-- '.$child['name'].'</option>';
					$children2 = $this->Content_model->sub_categories($child['id']);
					if ($children2) {
						foreach($children2 as $child2) {
							$out .= '<option value="'.$child2['id'].'"';
							if ($category_id == $child2['id']) { $out .= ' selected="selected"'; }
							$out .= '>|-- |-- '.$child2['name'].'</option>';
            			}
					}
				}
			} 
		}
		
		$out .= '</select><script>jQuery(".selectpicker").selectpicker();</script>';
		//$out .='&nbsp; <a href="javascript:deletecat('.$category['id'].')">Delete this category</a>';
		print $out;
	}
	function getcats2() {
		//$location_id = $_POST['location_id'];
		$category_id = $_POST['category_id'];
		$categories = $this->Content_model->get_categories();
		$out = '
		<select name="parent_id" id="parent_id_new123">
			<option value="0">No parent</option>';
		foreach($categories as $category) {
			$out .= '<option value="'.$category['id'].'"';
			if ($category['id'] == $category_id) $out .= ' selected="selected"';
			$out .= '>'.$category['name'].'</option>';
			$children = $this->Content_model->sub_categories($category['id']);
			if($children) {
				foreach($children as $child) {
					$out .= '<option value="'.$child['id'].'"';
					if ($child['id'] == $category_id) $out .= ' selected="selected"';
					$out .= '>|-- '.$child['name'].'</option>';
					$children2 = $this->Content_model->sub_categories($child['id']);
					if ($children2) {
						foreach($children2 as $child2) {
							$out .= '<option value="'.$child2['id'].'"';
							if ($child2['id'] == $category_id) $out .= ' selected="selected"';
							$out .= '>|-- |-- '.$child2['name'].'</option>';
            			}
					}
				}
			} 
		}
		$out .= '</select>';
		print $out;
	}

	function getcats21() {
		//$location_id = $_POST['location_id'];
		$category_id = $_POST['category_id'];
		$categories = $this->Content_model->get_categories();
		$out = '
		<select name="parent_id" id="parent_id_new" >
			<option value="0">No parent</option>';
		foreach($categories as $category) {
			$out .= '<option value="'.$category['id'].'"';
			if ($category['id'] == $category_id) $out .= ' selected="selected"';
			$out .= '>'.$category['name'].'</option>';
			$children = $this->Content_model->sub_categories($category['id']);
			if($children) {
				foreach($children as $child) {
					$out .= '<option value="'.$child['id'].'"';
					if ($child['id'] == $category_id) $out .= ' selected="selected"';
					$out .= '>|-- '.$child['name'].'</option>';
					$children2 = $this->Content_model->sub_categories($child['id']);
					if ($children2) {
						foreach($children2 as $child2) {
							$out .= '<option value="'.$child2['id'].'"';
							if ($child2['id'] == $category_id) $out .= ' selected="selected"';
							$out .= '>|-- |-- '.$child2['name'].'</option>';
            			}
					}
				}
			} 
		}
		$out .= '</select>';
		print $out;
	}
	function addcat() {
		$data = array(
			'parent_id' => $_POST['parent_id'],
			'location_id' => 0,
			'name' => $_POST['name']
		);
		//$this->session->set_userdata('location_id',$data['location_id']);
		$category_id = $this->Content_model->add_category($data);
		redirect('admin/new_cms/page');
	}
	
	function getcatetitle()
	{
		$category_id = $_POST['category_id'];
		$cate = $this->Content_model->get_category($category_id);
		
		echo $cate['name'];
	}
	
	function deletecategory() {
		$category_id = $_POST['category_id'];
		$this->Content_model->clear($category_id);
		$this->Content_model->delete_category($category_id);		
	}
	
	function deletepage()
    {
        
		$id=$this->input->post('page_id');
		$this->Menu_model->deletepage($id);
		// if()
        // {            
            // redirect('admin/cms/listpage');
        // }
    }
	
	function getpages() {
		$category_id = $_POST['category_id'];
		if ($category_id == -1) {
			$pages = $this->Content_model->search($category_id);
			$out = '
				<h3>Page List</h3><dl></dl>
				<div class="row-title">
					<div class="menu-name">Page title</div>
					<div class="menu-func">Menu</div>
				</div>';
			foreach($pages as $page) {
				$out .= '
				<div class="row-item" id="page-'.$page['id'].'">
					<div class="menu-name" id="pagename-'.$page['id'].'"><a href="javascript:editpage('.$page['id'].',\''.$page['title'].'\')">'.$page['title'].'</a></div>
					<div class="menu-func"><a href="javascript:menu('.$page['id'].')"><img src="'.base_url().'img/admin/editmenu.png" /></a></div>
				</div>';
			}
		} 
		else {
			$galleries = $this->Gallery_model->get_galleries();
			$option = '';
			foreach($galleries as $g)
			{
				$option .= '<option value="'.$g['id'].'">'.$g['title'].'</option>';
			}
			$pages = $this->Content_model->search($category_id);
			$cate = $this->Content_model->get_category($category_id);
			$out = '';
			$out2 = '';
			foreach($pages as $page) {
				$out2 .= '
				<tr id="page-'.$page['id'].'">
					<td>
						<a href="#editModal-'.$page['id'].'" data-toggle="modal">'.$page['title'].'</a>
					</td>
					<td style="text-align:center;">
						<div class="all_tt" data-toggle="tooltip" title="Preview Page" style="cursor:pointer">
							<a style="text-decoration:none" target="_blank" href="'.base_url().'admin/new_cms/showpage/'.$page['id'].'">
							<i class="icon-search icon-2x"></i>
							</a>
						</div>
					</td>
					<td style="text-align:center;">
						<div class="all_tt" data-toggle="tooltip" title="Edit Page" style="cursor:pointer" onclick="editpage('.$page['id'].')"><i class="icon-edit icon-2x"></i></div>
					</td>
					<td style="text-align:center;">
						<div class="all_tt" data-toggle="tooltip" title="Copy Page" style="cursor:pointer" onclick="showcopymodal('.$page['id'].')"><i class="icon-share icon-2x"></i></div>
					</td>
					<td style="text-align:center;">
						<div class="all_tt" data-toggle="tooltip" title="Edit Gallery" style="cursor:pointer" onclick="showgallerymodal('.$page['id'].')"><i class="icon-camera icon-2x"></i></div>
					</td>
					<td style="text-align:center;">
						<div class="all_tt" data-toggle="tooltip" title="Delete Page" style="color:#C70520; cursor:pointer" onclick="showmodal('.$page['id'].')"><i class="icon-remove-circle icon-2x"></i></div>
					</td>
				</tr>
				
				
				';
				
				
				
				
			}
		}
		$out2.="<script>
				jQuery(function() {
					jQuery('.all_tt').tooltip({
						showURL: false
					});
				});
				</script>";
		print $out2;
	}
	
	function getpages3() {
		$category_id = $_POST['category_id'];
		if ($category_id == -1) {
			$pages = $this->Content_model->search($category_id);
			$out = '
				<h3>Page List</h3><dl></dl>
				<div class="row-title">
					<div class="menu-name">Page title</div>
					<div class="menu-func">Menu</div>
				</div>';
			foreach($pages as $page) {
				$out .= '
				<div class="row-item" id="page-'.$page['id'].'">
					<div class="menu-name" id="pagename-'.$page['id'].'"><a href="javascript:editpage('.$page['id'].',\''.$page['title'].'\')">'.$page['title'].'</a></div>
					<div class="menu-func"><a href="javascript:menu('.$page['id'].')"><img src="'.base_url().'img/admin/editmenu.png" /></a></div>
				</div>';
			}
		} 
		else {
			$galleries = $this->Gallery_model->get_galleries();
			$option = '';
			foreach($galleries as $g)
			{
				$option .= '<option value="'.$g['id'].'">'.$g['title'].'</option>';
			}
			$pages = $this->Content_model->search($category_id);
			$cate = $this->Content_model->get_category($category_id);
			$out = '';
			$out2 = '';
			foreach($pages as $page) {
				$out2 .= '
				<div id="galleryModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">'.$page['title'].' Gallery</h3>
						</div>
						<div class="modal-body">
							<p>Gallery &nbsp;&nbsp;&nbsp; <select id="gal-select-'.$page['id'].'">'.$option.'</select></p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="setgallery('.$page['id'].');">Set</button>
						</div>
					</div>
	            	
					<div id="editModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">'.$page['title'].' Edit Name</h3>
						</div>
						<div class="modal-body">
							<p>New name &nbsp;&nbsp;&nbsp; <input type="text" class="textfield rounded" id="change-name-'.$page['id'].'" name="name" /></p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="changetitle('.$page['id'].');">Change</button>
						</div>
					</div>
	            	
					<div id="deleteModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">'.$page['title'].' Delete</h3>
						</div>
						<div class="modal-body">
							<p>Are you sure to delete this page?</p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="deletepage('.$page['id'].');">Delete</button>
						</div>
					</div>
					
					<div id="copyModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">Copy '.$page['title'].'</h3>
						</div>
						<form name="copyForm-'.$page['id'].'" id="copyForm-'.$page['id'].'" method="post" action="'.base_url().'admin/new_cms/copypage">
						<div class="modal-body">
							<p>Copy page <span style="font-weight:700">'.$page['title'].'</span></p>
							<p>Category <span style="font-weight:700">'.$cate['name'].'</span></p>
							<br/>
							<p><span style="font-weight:700">New Page</span></p>
							<input type="hidden" name="page_id" value="'.$page['id'].'"/>
							<table>
								<tr>
									<td style="padding-right:10px">Category destination</td>
									<td class="cats2"></td>
								</tr>
								<tr>
									<td>Page Name</td>
									<td><input type="text" class="textfield rounded" id="new-name-'.$page['id'].'" name="name" /></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="submitcopy('.$page['id'].')">Copy</button>
						</div>
						</form>
					</div>
				
				';
				
				
				
				
			}
		}
		print $out2;
	}

	function getpages2() {
		$category_id = $_POST['category_id'];
		if ($category_id == -1) {
			$pages = $this->Content_model->search($category_id);
			$out = '
				<h3>Page List</h3><dl></dl>
				<div class="row-title">
					<div class="menu-name">Page title</div>
					<div class="menu-func">Menu</div>
				</div>';
			foreach($pages as $page) {
				$out .= '
				<div class="row-item" id="page-'.$page['id'].'">
					<div class="menu-name" id="pagename-'.$page['id'].'"><a href="javascript:editpage('.$page['id'].',\''.$page['title'].'\')">'.$page['title'].'</a></div>
					<div class="menu-func"><a href="javascript:menu('.$page['id'].')"><img src="'.base_url().'img/admin/editmenu.png" /></a></div>
				</div>';
			}
		} 
		else {
			$galleries = $this->Gallery_model->get_galleries();
			$option = '';
			foreach($galleries as $g)
			{
				$option .= '<option value="'.$g['id'].'">'.$g['title'].'</option>';
			}
			$pages = $this->Content_model->search($category_id);
			$cate = $this->Content_model->get_category($category_id);
			$out = '';
			foreach($pages as $page) {
				$out .= '
				<div class="row-item" id="page-'.$page['id'].'">
					<div style="width: 40%" class="list_data" id="listname-'.$page['id'].'">
	            		<a href="#editModal-'.$page['id'].'" data-toggle="modal">'.$page['title'].'</a>
	            	</div>
	            	<div style="width: 15%;" class="list_data list_center">
	            		<div class="list_icon"><i class="icon-edit icon-2x"></i></div>
	            	</div>
	            	<div style="width: 15%;" class="list_data list_center">
	            		<div onclick="showcopymodal('.$page['id'].')" class="list_icon"><i class="icon-share icon-2x"></i></div>
	            	</div>
	            	<div style="width: 15%;" class="list_data list_center">
	            		<div onclick="showgallerymodal('.$page['id'].')" class="list_icon"><i class="icon-camera icon-2x"></i></div>
	            	</div>
	            	<div style="width: 15%;" class="list_data list_center">
	            		<div onclick="showmodal('.$page['id'].')" class="list_icon"><i class="icon-remove-circle icon-2x"></i></div>
	            	</div>
	            	<div class="list_line"></div>
	            	
					<div id="galleryModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">'.$page['title'].' Gallery</h3>
						</div>
						<div class="modal-body">
							<p>Gallery &nbsp;&nbsp;&nbsp; <select id="gal-select-'.$page['id'].'">'.$option.'</select></p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="setgallery('.$page['id'].');">Set</button>
						</div>
					</div>
	            	
					<div id="editModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">'.$page['title'].' Edit Name</h3>
						</div>
						<div class="modal-body">
							<p>New name &nbsp;&nbsp;&nbsp; <input type="text" class="textfield rounded" id="change-name-'.$page['id'].'" name="name" /></p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="changetitle('.$page['id'].');">Change</button>
						</div>
					</div>
	            	
					<div id="deleteModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">'.$page['title'].' Delete</h3>
						</div>
						<div class="modal-body">
							<p>Are you sure to delete this page?</p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="deletepage('.$page['id'].');">Delete</button>
						</div>
					</div>
					
					<div id="copyModal-'.$page['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">Copy '.$page['title'].'</h3>
						</div>
						<form name="copyForm-'.$page['id'].'" id="copyForm-'.$page['id'].'" method="post" action="'.base_url().'admin/new_cms/copypage">
						<div class="modal-body">
							<p>Copy page <span style="font-weight:700">'.$page['title'].'</span></p>
							<p>Category <span style="font-weight:700">'.$cate['name'].'</span></p>
							<br/>
							<p><span style="font-weight:700">New Page</span></p>
							<input type="hidden" name="page_id" value="'.$page['id'].'"/>
							<table>
								<tr>
									<td style="padding-right:10px">Category destination</td>
									<td class="cats2"></td>
								</tr>
								<tr>
									<td>Page Name</td>
									<td><input type="text" class="textfield rounded" id="new-name-'.$page['id'].'" name="name" /></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
							<button class="btn btn-primary" onclick="submitcopy('.$page['id'].')">Copy</button>
						</div>
						</form>
					</div>
	            </div>
				
				';
				
				// <div class="row-item" id="page-'.$page['id'].'">
					// <div class="menu-name" id="pagename-'.$page['id'].'"><a href="javascript:editpage('.$page['id'].',\''.$page['title'].'\')">'.$page['title'].'</a></div>
					// <div class="menu-func"><a href="javascript:deletepage('.$page['id'].')"><img src="'.base_url().'img/admin/icon-delete.png" /></a></div>
					// <div class="menu-func"><a href="'.base_url().'admin/cms/editpage/'.$page['id'].'"><img src="'.base_url().'img/admin/editcontent.png" /></a></div>
					// <div class="menu-func"><a href="javascript:gallery('.$page['id'].')"><img src="'.base_url().'img/admin/gallery.png" /></a></div>					
					// <div class="menu-func"><a href="javascript:copy('.$page['id'].')"><img src="'.base_url().'img/admin/icon-dup.png" /></a></div>
				// </div>
			}
		}
		print $out;
	}

	function copypage() {
		$page = $this->Content_model->id($_POST['page_id']);
		if ($page) {
			$newpage = array(
				'category_id' => $_POST['parent_id'],
				'title' => $_POST['name'],			
				'content' => $page['content'],
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			$newpage_id = $this->Content_model->add($newpage);
		}
		
		redirect(base_url().'admin/new_cms/page');
	}
	
	function updatepagetitle() {
		if ($this->Content_model->update($_POST['id'],array('title' => $_POST['title']))) {
			print "OK";
		}
	}
	
	function updatepagegallery() {
		if ($this->Content_model->update($_POST['id'],array('gallery' => $_POST['gallery_id']))) {
			print "OK";
		}
	}
	
	function addingpage() {
		$title = $_POST['title'];
		$data = array(
			'category_id' => $_POST['category_id'],
			'title' => $title,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s')
		);
		//$this->session->set_userdata('category_id',$_POST['category_id']);
		$page_id = $this->Content_model->add($data);
		//redirect('admin/cms/page');
	}

	function updatesale() {
		$product_id = $_POST['id'];
		$sale_price = $_POST['saleprice'];
		$sale_trade_price = $_POST['saletradeprice'];
		$data = array(			
			'sale_price_trade' => $sale_trade_price,
			'sale_price' => $sale_price,
			'modified' => date('Y-m-d H:i:s')
		);
		$this->Product_model->update($product_id,$data);
		if($sale_trade_price < $sale_price)
		{
			if(!$this->Product_model->product_category($product_id,6))
			{
				$data['product_id'] = $product_id;
				$data['category_id'] = 6;
				$this->Product_model->add_category($data);
			}
		}
		else
		{
			if($this->Product_model->product_category($product_id,6))
			{
				$this->Product_model->remove_category($product_id,6);
			}
		}
		//redirect($_POST['current_url']);
	}
	
	function get_product_price($id=0)
	{
		//$id = $_POST['id'];
		$data = $this->Product_model->identify($id);
		echo $data['price'];
	}

	function get_product_saleprice($id=0)
	{
		//$id = $_POST['id'];
		$data = $this->Product_model->identify($id);
		echo $data['sale_price'];
	}
	
	function get_product_tradeprice($id=0)
	{
		//$id = $_POST['id'];
		$data = $this->Product_model->identify($id);
		echo $data['price_trade'];
	}

	function get_product_saletradeprice($id=0)
	{
		//$id = $_POST['id'];
		$data = $this->Product_model->identify($id);
		echo $data['sale_price_trade'];
	}
	
	function get_product_category($id)
	{
		$categories = $this->Product_model->get_categories($id);
		$thiscat = Array();
		foreach($categories as $category)
		{
			array_push($thiscat,$category['category_id']);
		}
		$main = $this->Category_model->get_main();
		$out = '';
		$out .= '<ul class="tree">';
		$out .= '<li style="line-height: 30px;">';
		$out .= '<a href="javascript:nothing()" role="branch" class="tree-toggle" data-toggle="branch" data-value="All_Category">';
		$out .= 'All Category';
		$out .= '</a>';
		$out .= '<ul class="branch in">';
		foreach($main as $maincat)
		{
			$sub2 = $this->Category_model->get($maincat['id']);
			$out .= '<li style="line-height: 30px;">';
			if(count($sub2) > 0)
			{
				$out .= '<a href="javascript:nothing()" role="branch" class="tree-toggle closed" data-toggle="branch" data-value="'.$maincat['title'].'">';
				if(in_array($maincat['id'],$thiscat))
				{
					$out .= '<input checked="checked" style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="'.$maincat['id'].'"/>';
				}
				else 
				{
					$out .= '<input style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="'.$maincat['id'].'"/>';
				}
				
				$out .= $maincat['title'];
				$out .= '</a>';
			}
			else 
			{
				$out .= '<a href="javascript:nothing()" role="leaf">';
				if(in_array($maincat['id'],$thiscat))
				{
					$out .= '<input checked="checked" style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="'.$maincat['id'].'"/>';
				}
				else
				{
					$out .= '<input style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="'.$maincat['id'].'"/>';
				}
				
				$out .= $maincat['title'];
				$out .= '</a>';
			}
			$out .= '<ul class="branch">';
			$sub = $this->Category_model->get($maincat['id']);
			foreach($sub as $subcat)
			{
				$out .= '<li style="line-height: 30px;">';
				$out .= '<a href="javascript:nothing()" role="leaf">';
				if(in_array($subcat['id'],$thiscat))
				{
					$out .= '<input checked="checked" style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="'.$subcat['id'].'"/>';
				}
				else 
				{
					$out .= '<input style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="'.$subcat['id'].'"/>';
				}
				
				$out .= $subcat['title'];
				$out .= '</li>';	
			}
			$out .= '</ul>';
			$out .= '</li>';
		}
		$out .= '</ul>';
		$out .= '</li>';
		$out .= '</ul>';
		
		echo $out;
	}

	function updatecategories() {
		$product_id = $_POST['product_id'];
		$this->Product_model->remove_categories($product_id);
		# Add relation product and category
		if (isset($_POST['categories'])) {
			$categories = $_POST['categories'];
			foreach($categories as $category_id) {
				$data = array(
					'product_id' => $product_id,
					'category_id' => $category_id
				);
				$this->Product_model->add_category($data);
			}
		}
		$this->session->set_flashdata('update',true);
		redirect('admin/new_cms/product');
	}
	
	function searchproduct() {
		$keyword = $_POST['keyword'];
		$status = $_POST['status'];
		$sort = $_POST['sort'];
		$category = $_POST['category'];
		$this->session->set_userdata('keyword',$_POST['keyword']);
		$this->session->set_userdata('status',$_POST['status']);
		$this->session->set_userdata('sort',$_POST['sort']);
		$this->session->set_userdata('category',$_POST['category']);
		redirect('admin/new_cms/product/search');
	}

	function export_product_for_MYOB()
	{
		//$csvdir = getcwd();
		//$csvdir = $csvdir.'/csv/';
		$path = "./exportcsv/stock";
		$dir = $path;
		//$csvdir = '/home/odessa/public_html/cart_v1/exportcsv/stock/';
		$csvname = 'stock_MYOB_'.date('Ymd_His');
		$csvname = $csvname.'.csv';
		//header('Content-type: application/csv; charset=utf-8;');
        //header("Content-Disposition: attachment; filename=$csvname");
		//$fp = fopen("php://output", 'w');
		$fp = fopen($dir.'/'.$csvname,'w+');
		
		
		$headings = array('stock_id','barcode','description','longdesc','dept_id','dept_name','cat1','cat2','cat3','CatHeader_1','CatHeader_2','CatHeader_3','PLU','costum1','costum2','sales_promt','inactive','allow_renaming','allow_fractions','package','tax_components','print_components','goods_tax','goods_tax_package','cost','sales_tax','sell','quantity','layby_qty','salesorder_qty','date_created','track_serial','static_quantity','bonus','order_threshold','order_quantity','supplier_id','supplier','date_modified','frieght','tare_weight','unitof_measure','Uofm','weighted','external','picture_file_name');
		fputcsv($fp,$headings);
		
		$prod = $this->Product_model->all_byid();
		
		foreach($prod as $p)
		{
			$lines = array();
			//$state = $this->System_model->get_state_code($c['state']);
			//$lines = array($c['id'],0,0,0,0,0,0,0,0,date('d/m/Y H:i',strtotime($c['modified'])),$c['lastname'],$c['firstname'],0,$c['tradename'],$c['title'],0,0,0,0,0,0,0,0,$c['address'],$c['address2'],0,$c['suburb'],$state,$c['postcode'],$c['country'],$c['phone'],0,$c['mobile'],$c['email'],$c['abn'],0,0,date('d/m/Y H:i',strtotime($c['joined'])),0,0,0);
			$cat=$this->Category_model->identify($p['main_category']);
			if($p['status'] == 1) {$inac = 0;}else{$inac = 1;}
			$create = date('d/m/Y',strtotime($p['created']));
			$modified = date('d/m/Y',strtotime($p['modified']));
			$lines = array($p['id'],0,$p['short_desc'],$p['long_desc'],0,0,0,0,0,$cat['title'],0,0,0,0,0,0,$inac,0,0,0,0,0,0,0,$p['price'],0,0,0,0,0,$create,0,0,0,1,0,0,0,$modified,0,$p['weight'],0,0,0,0,'-');
			fputcsv($fp,$lines);
		}
		fclose($fp);
	}

	function product($action="",$product_id="") {
		$data['main'] = $this->Category_model->get_main();
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		if($action == "add") {
			$data['attributes'] = $this->System_model->get_attributes();
			$this->load->view('admin/new_product/add',$data);
		} else if($action == "edit") {
			$data['product'] = $this->Product_model->identify($product_id);
			$data['attributes'] = $this->System_model->get_attributes();
			$data['product_attributes'] = $this->Product_model->get_attributes($product_id);			
			$this->load->view('admin/new_product/edit',$data);
		} else if($action == "search") {
			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/new_cms/product/search/";
			$config['total_rows'] = count($this->Product_model->search($this->session->userdata('keyword'),$this->session->userdata('category'),$this->session->userdata('status')));
			$config['per_page'] = '50';
			$config['num_links'] = 4;
			$config['uri_segment'] = 5;
			//$config['cur_tag_open'] = '&nbsp;<span class="active">';
			//$config['cur_tag_close'] = '</span>';
			$config['tag_open'] = '<li>';
			$config['tag_close'] = '</li>';
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($product_id!="") { $row = $product_id; }
			$data['products'] = $this->Product_model->search_group($row,50,$this->session->userdata('keyword'),$this->session->userdata('category'),$this->session->userdata('sort'),$this->session->userdata('status'));
			$this->load->view('admin/new_product/list',$data);
		}
 		else if($action == "in_stock")
 		{
 			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/new_cms/product/in_stock/";
			$config['total_rows'] = count($this->Product_model->all_in_stock());
			$config['per_page'] = '50';
			$config['num_links'] = 4;
			$config['uri_segment'] = 5;
			//$config['cur_tag_open'] = '&nbsp;<span class="active">';
			//$config['cur_tag_close'] = '</span>';
			$config['tag_open'] = '<li>';
			$config['tag_close'] = '</li>';
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($product_id!="") { $row = $product_id; }
			$data['products'] = $this->Product_model->all_in_stock();
			$this->load->view('admin/new_product/list',$data);
 		}
 		else if($action == "out_of_stock")
 		{
 			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/new_cms/product/out_of_stock/";
			$config['total_rows'] = count($this->Product_model->all_out_of_stock());
			$config['per_page'] = '50';
			$config['num_links'] = 4;
			$config['uri_segment'] = 5;
			//$config['cur_tag_open'] = '&nbsp;<span class="active">';
			//$config['cur_tag_close'] = '</span>';
			$config['tag_open'] = '<li>';
			$config['tag_close'] = '</li>';
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($product_id!="") { $row = $product_id; }
			$data['products'] = $this->Product_model->all_out_of_stock();
			$this->load->view('admin/new_product/list',$data);
 		}
		else if($action == "inactive")
 		{
 			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/new_cms/product/out_of_stock/";
			$config['total_rows'] = count($this->Product_model->all_disable());
			$config['per_page'] = '50';
			$config['num_links'] = 4;
			$config['uri_segment'] = 5;
			//$config['cur_tag_open'] = '&nbsp;<span class="active">';
			//$config['cur_tag_close'] = '</span>';
			$config['tag_open'] = '<li>';
			$config['tag_close'] = '</li>';
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($product_id!="") { $row = $product_id; }
			$data['products'] = $this->Product_model->all_disable();
			$this->load->view('admin/new_product/list',$data);
 		}
		else if($action == "on_sale")
 		{
 			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/new_cms/product/out_of_stock/";
			$config['total_rows'] = count($this->Product_model->all_on_sale());
			$config['per_page'] = '50';
			$config['num_links'] = 4;
			$config['uri_segment'] = 5;
			//$config['cur_tag_open'] = '&nbsp;<span class="active">';
			//$config['cur_tag_close'] = '</span>';
			$config['tag_open'] = '<li>';
			$config['tag_close'] = '</li>';
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($product_id!="") { $row = $product_id; }
			$data['products'] = $this->Product_model->all_on_sale();
			$this->load->view('admin/new_product/list',$data);
 		}
		else 
		{
			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/new_cms/product/";
			$config['total_rows'] = count($this->Product_model->all());
			$config['per_page'] = '50';
			$config['num_links'] = 4;
			$config['uri_segment'] = 4;
			$config['tag_open'] = '<li>';
			$config['tag_close'] = '</li>';
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($action!="") { $row = $action; }
			$data['products'] = $this->Product_model->groupq($row);
			$this->load->view('admin/new_product/list',$data);
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');
	}

	function update_stock()
	{
		$stock = $_POST['stock'];
		$id = $_POST['id'];
		
		$data['stock'] = $stock;
		
		$this->Product_model->update($id,$data);
	}

	function copy_product()
	{
		$name = $_POST['name'];
		$id = $_POST['id'];
		
		$new_id_title = str_replace(' ','-',$name);
		$new_id_title = str_replace("'","",$new_id_title);
		$new_id_title = str_replace("&","and",$new_id_title);
		$new_id_title = str_replace("+","and",$new_id_title);
		
		$data = $this->Product_model->identify($id);
		
		if($data['id_title'] == $new_id_title)
		{
			echo 0;
		}
		else 
		{
			$data['id'] = NULL;
			$data['title'] = $name;
			$data['id_title'] = $new_id_title;
			
			$new_id = $this->Product_model->add($data);
			
			$path = "./uploads/products";
			$newfolder = md5('mbb'.$new_id);
			$dir = $path."/".$newfolder;
			
			mkdir($dir,0777);
			chmod($dir,0777);
			$thumb1 = $dir."/thumb1";
			mkdir($thumb1,0777);
			chmod($thumb1,0777);
			$thumb2 = $dir."/thumb2";
			mkdir($thumb2,0777);
			chmod($thumb2,0777);
			$thumb3 = $dir."/thumb3";
			mkdir($thumb3,0777);
			chmod($thumb3,0777);
			$thumb4 = $dir."/thumb4";
			mkdir($thumb4,0777);
			chmod($thumb4,0777);
			$thumb5 = $dir."/thumb5";
			mkdir($thumb5,0777);
			chmod($thumb5,0777);
			$thumb6 = $dir."/thumb6";
			mkdir($thumb6,0777);
			chmod($thumb6,0777);
			$thumb7 = $dir."/thumb7";
			mkdir($thumb7,0777);
			chmod($thumb7,0777);
			$thumb8 = $dir."/thumb8";
			mkdir($thumb8,0777);
			chmod($thumb8,0777);
			
			echo $new_id;
		}
		
		
	}

	function actionall()
	{
		$list = $_POST['check_ed'];
		$action = $_POST['action'];
		
		//echo "<pre>".print_r($list,true)."</pre>";
		
		if($action == 1)
		{
			//active
			foreach($list as $l)
			{
				$data = Array();
				$data['status'] = 1;
				$this->Product_model->update($l,$data);
			}
		}
		elseif($action == 2)
		{
			//inactive
			foreach($list as $l)
			{
				$data = Array();
				$data['status'] = 0;
				$this->Product_model->update($l,$data);
			}
		}
		elseif($action == 3)
		{
			//delete
			foreach($list as $l)
			{
				$prod = $this->Product_model->identify($l);
		
				$data = Array();
				$data['deleted']=1;
				$data['id_title']=$prod['id_title'] . '_discontinued';
				//$data = Array();
				//$data['deleted'] = 1;
				$this->Product_model->update($l,$data);
			}
		}
		
		redirect('admin/new_cms/product');
	}

	function deleteproduct($id="") {
		
		$prod = $this->Product_model->identify($id);
		
		$data = Array();
		$data['deleted']=1;
		$data['id_title']=$prod['id_title'] . '_discontinued';
		
		//echo "<pre>".print_r($data,TRUE)."</pre>";
		//exit;
		
		$this->Product_model->update($id,$data);
		
		// $this->Product_model->remove_related($id);
		// $this->Product_model->remove_attributes($id);
		// $this->Product_model->remove_categories($id);
		// $this->Product_model->remove_features($id);
		// $this->Product_model->delete($id);
		// $this->delete_directory('./uploads/products/'.md5('mbb'.$id));
		redirect('admin/new_cms/product');
	}
	
	function switchstatus($id) {
		//$id = $_POST['id'];
		$product = $this->Product_model->identify($id);
		$out = '';
		if ($product['status'] == 0) {
			$this->Product_model->update($id,array('status' => 1));
			//$out = '<a href="javascript:switchstatus('.$id.')" title="De-active this product"><img src="'.base_url().'img/backend/icon-actived.png" /></a>';
		} else if($product['status'] == 1) {
			$this->Product_model->update($id,array('status' => 0));
			//$out = '<a href="javascript:switchstatus('.$id.')" title="Active this product"><img src="'.base_url().'img/backend/icon-inactived.png" /></a>';
		}
		redirect('admin/new_cms/product');
		//print $out;
	}
	
	function exportstock() {
		$csvdir = getcwd();		
		$csvname = 'Product_Stock_'.date('d-m-Y');
		$csvname = $csvname.'.csv';		
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');	
		$stocks=$this->Product_model->all();
		$headings = array('Product Name','Short Description','Product Code','EAN','Avail Retail','Avail Wholesale','List Price','Wholesale Price','Amount in Stock','Limited','First Edition','Field 2: Designer Notes','Field 3: Features','Field 4: Dimension','Field 4: Handle Length','Field 4: Weight','Main Category','Sub Category','Collection','Composition','Shipping Dimensions W','Shipping Dimensions H','Shipping Dimensions D','Shipping Volume','Stock ID');
		fputcsv($fp,$headings);
		foreach($stocks as $stock) 
		{
			$cat = $this->Category_model->identify($stock['main_category']);
			$subcat = $this->Category_model->identify_category_all($stock['id']);
			
			$cc = 1;
			$subcat_text='';
			foreach($subcat as $sc)
			{
				if($stock['main_category'] != $sc['category_id'])
				{
					$scat = $this->Category_model->identify($sc['category_id']);
					if($cc == 1)
					{
						$subcat_text .= $scat['title'];
					}
					else 
					{
						$subcat_text .= '; '.$scat['title'];
					}
					$cc++;
					
				}
			}
			
			
			
			fputcsv($fp,array($stock['title'],$stock['short_desc'],$stock['style_no'],$stock['ean'],$stock['available_retail'],$stock['available_wsale'],$stock['price'],$stock['price_trade'],$stock['stock'],$stock['limited'],$stock['first_edition'],$stock['long_desc'],$stock['features'],$stock['dimension'],$stock['length'],$stock['weight'],$cat['title'],$subcat_text,$stock['collection'],$stock['composition'],$stock['dimension_w'],$stock['dimension_h'],$stock['dimension_d'],$stock['volume'],$stock['stock_id']));
		}
        fclose($fp);		
	}

	function promotions() {

		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$data['promotions'] = $this->System_model->get_all_promotions();
		$this->load->view('admin/promotions/list',$data);
		$this->load->view('admin/new_common/footer');
	}
	function add_promo()
	{		
			
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/promotions/add');
		$this->load->view('admin/new_common/footer');
	}
	function edit_promo($id)
	{
		
		$data['promotions'] = $this->System_model->get_promotions_id($id);			
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/promotions/edit',$data);
		$this->load->view('admin/new_common/footer');
	}
	function activepromo($id="") {
		$this->System_model->active_promotions($id);
		redirect('admin/new_cms/promotions');
	}
	function homepromo($id="") {
		$this->System_model->home_promotions($id);
		redirect('admin/new_cms/promotions');
	}
	function deletepromo($id) {
		$this->System_model->delete_promotions($id);
		//redirect('admin/system/coupon');
	}
	function adding_promo()
	{
		$title=$this->input->post('title');
		$url = $this->input->post('links');
		$description = $this->input->post('promo_description');
		$data = array(
			'title' => $title,
			'url' => $url,
			'description' => $description,
			'created' => date('Y-m-d H:i:s')
		);
		$story_id = $this->System_model->add_promotions($data);
		echo $story_id;
	}
	function updating_promo()
	{
		$id = $this->input->post('id');
		$title=$this->input->post('title');
		$description = $this->input->post('promo_description');
		$url = $this->input->post('links');
		$data = array(
			'title' => $title,
			'url' => $url,
			'description' => $description,
			'created' => date('Y-m-d H:i:s')
		);
		$this->System_model->update_promotions($id,$data);
		
	}
	function add_home_promo_tile()
	{
		$id=$this->input->post('id_promo');
		$path = "./uploads/promotions/tiles";
		$newfolder = md5('tile'.$id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
			mkdir($dir,0777);
			chmod($dir,0777);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '8192'; //  MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['width'] = 4000;
		$config['height'] = 4000;
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/new_cms/edit_promo/'.$id);	
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];			
			# Add details to database			
			$check = $this->System_model->check_image($id,'tile');			
			$tile = array(
				'promo_id' => $id,
				'type' => 'tile',
				'name' => $name,								
				'created' => date('Y-m-d H:i:s')
			);			
			if(count($check)>0){
				$this->System_model->update_promotions_detail($check['id'],$tile);
			}
			else
			{
				$this->System_model->add_promotions_detail($tile);
			}
		}
		redirect('admin/new_cms/edit_promo/'.$id);
	}
	function add_home_promo_slide()
	{
		$id=$this->input->post('id_promo');
		$path = "./uploads/promotions/hero";
		$newfolder = md5('hero'.$id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
			mkdir($dir,0777);
			chmod($dir,0777);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '8192'; //  MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['width'] = 4000;
		$config['height'] = 4000;
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/new_cms/edit_story/'.$id);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];			
			# Add details to database			
			$check = $this->System_model->check_image_promotions($id,'hero');	
			$tile = array(
				'promo_id' => $id,
				'type' => 'hero',
				'name' => $name,								
				'created' => date('Y-m-d H:i:s')
			);			
			if(count($check)>0){
				$this->System_model->update_promotions_detail($check['id'],$tile);
			}
			else
			{
				$this->System_model->add_promotions_detail($tile);
			}
		}
		redirect('admin/new_cms/edit_promo/'.$id);
	}
	
	
	
	function stories() {

		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$data['stories'] = $this->System_model->get_all_story();
		$this->load->view('admin/stories/list',$data);
		$this->load->view('admin/new_common/footer');
	}
	function preview_story($id)
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
		$data['id_active']=$id;
		$data['stories'] = $this->System_model->get_active_stories();
		$this->load->view('common/header',$data);
		$this->load->view('admin/stories/story',$data);
		$this->load->view('common/footer');
	}
	function add_story()
	{
		$categories = $this->Category_model->get_main();
		$data['categories']=$categories;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."admin/new_cms/product/";
		$config['total_rows'] = count($this->Product_model->all());
		$config['per_page'] = '10';
		$config['num_links'] = 4;
		$config['uri_segment'] = 4;
		$config['tag_open'] = '<li>';
		$config['tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$row = 0;
		$data['products'] = $this->Product_model->groupq($row);
			
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/stories/add');
		$this->load->view('admin/new_common/footer');
	}
	function edit_story($id)
	{
		$categories = $this->Category_model->get_main();
		$data['story'] = $this->System_model->get_story_id($id);
		$data['categories']=$categories;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."admin/new_cms/product/";
		$config['total_rows'] = count($this->Product_model->all());
		$config['per_page'] = '10';
		$config['num_links'] = 4;
		$config['uri_segment'] = 4;
		$config['tag_open'] = '<li>';
		$config['tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$row = 0;
		$data['products'] = $this->Product_model->groupq($row);
			
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/stories/edit',$data);
		$this->load->view('admin/new_common/footer');
	}
	function activestory($id="") {
		$this->System_model->active_story($id);
		redirect('admin/new_cms/stories');
	}
	function homestory($id="") {
		$this->System_model->home_story($id);
		redirect('admin/new_cms/stories');
	}
	function deletestory($id) {
		$this->System_model->delete_story($id);
		//redirect('admin/system/coupon');
	}
	function adding_story()
	{
		$title=$this->input->post('title');

		$description = $this->input->post('story_description');
		$data = array(
			'title' => $title,
			'description' => $description,
			'created' => date('Y-m-d H:i:s')
		);
		$story_id = $this->System_model->add_story($data);
		echo $story_id;
	}
	function addstory_product()
	{
		$id = $this->input->post('id_story');
		$products = $this->input->post('product');
		$this->System_model->delete_story_product($id);
		
		foreach($products as $product)
		{
			if($product>0)
			{
				$data=array(
						'story_id' => $id,
						'product_id' => $product
					);
				$this->System_model->add_story_product($data);
			}
		}
	}
	function updating_story()
	{
		$id = $this->input->post('id');
		$title=$this->input->post('title');
		$description = $this->input->post('story_description');
		$data = array(
			'title' => $title,
			'description' => $description,
			'created' => date('Y-m-d H:i:s')
		);
		$this->System_model->update_story($id,$data);
		
	}
	function add_home_tile()
	{
		$id=$this->input->post('id_story');
		$path = "./uploads/stories/tiles";
		$newfolder = md5('tile'.$id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
			mkdir($dir,0777);
			chmod($dir,0777);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '8192'; //  MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['width'] = 4000;
		$config['height'] = 4000;
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/new_cms/edit_story/'.$id);	
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];			
			# Add details to database			
			$check = $this->System_model->check_image($id,'tile');			
			$tile = array(
				'story_id' => $id,
				'type' => 'tile',
				'name' => $name,								
				'created' => date('Y-m-d H:i:s')
			);			
			if(count($check)>0){
				$this->System_model->update_story_detail($check['id'],$tile);
			}
			else
			{
				$this->System_model->add_story_detail($tile);
			}
		}
		redirect('admin/new_cms/edit_story/'.$id);
	}
	function add_home_slide()
	{
		$id=$this->input->post('id_story');
		$path = "./uploads/stories/hero";
		$newfolder = md5('hero'.$id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
			mkdir($dir,0777);
			chmod($dir,0777);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '8192'; //  MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['width'] = 4000;
		$config['height'] = 4000;
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/new_cms/edit_story/'.$id);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];			
			# Add details to database			
			$check = $this->System_model->check_image($id,'hero');	
			$tile = array(
				'story_id' => $id,
				'type' => 'hero',
				'name' => $name,								
				'created' => date('Y-m-d H:i:s')
			);			
			if(count($check)>0){
				$this->System_model->update_story_detail($check['id'],$tile);
			}
			else
			{
				$this->System_model->add_story_detail($tile);
			}
		}
		redirect('admin/new_cms/edit_story/'.$id);
	}
	function add_home_second()
	{
		$id=$this->input->post('id_story');
		$path = "./uploads/stories/secondary";
		$newfolder = md5('secondary'.$id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
			mkdir($dir,0777);
			chmod($dir,0777);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '8192'; //  MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['width'] = 4000;
		$config['height'] = 4000;
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/new_cms/edit_story/'.$id);		
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];			
			# Add details to database			
			$check = $this->System_model->check_image($id,'secondary');	
			$tile = array(
				'story_id' => $id,
				'type' => 'secondary',
				'name' => $name,								
				'created' => date('Y-m-d H:i:s')
			);			
			if(count($check)>0){
				$this->System_model->update_story_detail($check['id'],$tile);
			}
			else
			{
				$this->System_model->add_story_detail($tile);
			}
		}
		redirect('admin/new_cms/edit_story/'.$id);
	}
	
	function galleries($id=null,$pid=null) 
	{
		# Check authentication and load models
		//$this->check_authentication();
		
		# load normal header view
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		
		# if not a particular gallery
		if ($id == null) {
			# Get all galleries
			$galleries = $this->Gallery_model->get_galleries();
			# Determine the thumbnail
			$thumbnails = array();
			foreach($galleries as $gallery) {
				$photos = $this->Gallery_model->get_photos($gallery['id']);
				if (count($photos) == 0) {
					$thumbnails[$gallery['id']] = '<a href="'.base_url().'admin/new_cms/galleries/'.$gallery['id'].'"><img src="'.base_url().'img/thumbnail-no-image.jpg" title="'.$gallery['title'].'" /></a>';
				} else {
					$thumbnail = $this->Gallery_model->get_gallery_thumbnail($gallery['id']);
					$thumbnails[$gallery['id']] = '<a href="'.base_url().'admin/new_cms/galleries/'.$gallery['id'].'"><img src="'.base_url().'uploads/galleries/'.md5("cdkgallery".$gallery['id']).'/thumbnails/'.$thumbnail.'" title="'.$gallery['title'].'" /></a>';
				}
			}
			
			# Pass data to the view
			$data['galleries'] = $galleries;
			$data['thumbnails'] = $thumbnails;			
			$this->load->view('admin/new_cms/galleries',$data);
		} 
		
		# Viewing a particular gallery
		else {
			# Get the gallery
			$data['gallery'] = $this->Gallery_model->get_gallery($id);
			if(!$data['gallery'])
			{
				redirect('admin/new_cms/galleries/');
			}
			# Get all photos in the gallery
			$data['photos'] = $this->Gallery_model->get_photos($id);
			# If no photo yet
			if ($pid == null) {
				$this->load->view('admin/new_cms/gallery',$data);
			} else {
				$data['photo'] = $this->Gallery_model->get_photo($pid);
				if($data['photo'])
				{
				$this->load->view('admin/new_cms/photo',$data);
				}
				else
				{
					redirect('admin/new_cms/galleries/'.$id);
				}
			}		
		}
		
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');		
	}

	function create_gallery() 
	{
		if (trim($_POST['title']) == "") {
			$this->session->set_flashdata('error_cg',true);
			redirect('admin/cms/galleries');
		}
		$data = array(
			'title' => $_POST['title'],
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s')
		);
		$gid = $this->Gallery_model->create_gallery($data);
		
		$path = "./uploads/galleries";
		$newfolder = md5('cdkgallery'.$gid);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		$dir .= "/thumbnails";
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}

		
		
		$dir = $path."/".$newfolder;
		$dir .= "/thumb1";
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}		
		
		$dir = $path."/".$newfolder;
		$dir .= "/thumbnails2";
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}	
		redirect('admin/new_cms/galleries');
	}

	function delete_gallery($id) 
	{
		//$this->check_authentication();
		$photos = $this->Gallery_model->get_photos($id);
		foreach($photos as $photo) {
			if ($this->Gallery_model->delete_photo($photo['id'])) {
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/".$photo['name']);
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/thumbnails/".$photo['name']);	
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/thumb1/".$photo['name']);				
			}
		}
		//print_r('test');
		unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/index.html");
		unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/thumbnails/index.html");
		unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/thumb1/index.html");
		
		if ($this->Gallery_model->delete_gallery($id)) {
			rmdir("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/thumb1");
			rmdir("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id)."/thumbnails");
			rmdir("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$id));
			//$this->Page_model->reset_gallery($id);
			print "Ok";
		} 
		
		else {
			print "Error";
		}
				
		
	}
	function add_photo()
	{
		
		$gid = $_POST['gallery_id'];		
		$config['upload_path'] = "./uploads/galleries/".md5('cdkgallery'.$gid);
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4096'; // 4 MB
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());			
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data['upload_data']['file_name'];
			$width = $data['upload_data']['image_width'];
			$height = $data['upload_data']['image_height'];
			$photo = array(
				'name' => $file_name,
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s'),
				'gallery_id' => $gid,
				'order' => 0
			);
			$pid = $this->Gallery_model->add_photo($photo);
			$this->Gallery_model->update_photo($pid,array('order'=>$pid));
			if($gid != 4)
			{
				//420
				if ($height != 625)
				{
				$config = array();
				// Resize image
				$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = (625 * $width) / $height;
				$config['height'] = 625;
				$config['master_dim'] = 'height';
				$this->load->library('image_lib');
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				unlink("./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name);
				rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name);
				$this->image_lib->clear();
			    }	
			}
			// Thumbnail creation
			$config = array();
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name;
			$config['create_thumb'] = TRUE;
			$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$file_name;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = 100;
			  if ($width < $height) 
			  {		
			    if(($height/$width) < (112/138))
				{
					$config['height'] = 138;
				$config['width'] = intval(138 * ($height/$width));
				$config['master_dim'] = 'height';
				}
				else
				{
				$config['width'] = 138;
				$config['height'] = intval(112 * ($height/$width));
				$config['master_dim'] = 'width';
				}
				
			  } 
			  else if($width > $height)
			  {		
			   
					
				if(($width/$height) < (138/112))
				{
					$config['width'] = 138;
					$config['height'] = intval(112 * ($width/$height));
					$config['master_dim'] = 'width';
				}
				else
				{
					$config['width'] = intval(138 * ($width/$height));
					
				$config['height'] = 112;
				$config['master_dim'] = 'height';
				}
				
				
			  }
			  else  // for square image
			  {		
			  
				$config['width'] = 138;
				$config['height'] = intval(138 * ($height/$width));
				// if the thumbnail width is longer set to width otherwise set to height
				$config['master_dim'] = 'width';
				
			  }
			
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());	
			}
			
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$file_name);
			$this->image_lib->clear();
			
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$file_name;
			
			$config['width'] = 138;
			$config['height'] = 112;
		    // really important shoud be crop from top 0 left 0
				$config['x_axis'] = 0;
				$config['y_axis'] = 0;
			$config['maintain_ratio'] = FALSE;
			
			$this->image_lib->initialize($config);
			$crop_thumbnail = $this->image_lib->crop();
			if ( ! $crop_thumbnail)
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());
			}
			unlink("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$file_name);
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$file_name);
			
			
			
			// Thumbnail frontend creation
			$config = array();
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name;
			$config['create_thumb'] = TRUE;
			$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$file_name;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = 100;
			  if ($width < $height) 
			  {		
			    if(($height/$width) < (145/225))
				{
					$config['height'] = 225;
				$config['width'] = intval(225 * ($height/$width));
				$config['master_dim'] = 'height';
				}
				else
				{
				$config['width'] = 225;
				$config['height'] = intval(145 * ($height/$width));
				$config['master_dim'] = 'width';
				}
				
			  } 
			  else if($width > $height)
			  {		
			   
					
				if(($width/$height) < (225/145))
				{
					$config['width'] = 225;
					$config['height'] = intval(145 * ($width/$height));
					$config['master_dim'] = 'width';
				}
				else
				{
					$config['width'] = intval(225 * ($width/$height));
					
				$config['height'] = 145;
				$config['master_dim'] = 'height';
				}
				
				
			  }
			  else  // for square image
			  {		
			  
				$config['width'] = 225;
				$config['height'] = intval(225 * ($height/$width));
				// if the thumbnail width is longer set to width otherwise set to height
				$config['master_dim'] = 'width';
				
			  }
			
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());	
			}
			
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$file_name);
			$this->image_lib->clear();
			
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$file_name;
			
			$config['width'] = 225;
			$config['height'] = 145;
		    // really important shoud be crop from top 0 left 0
				$config['x_axis'] = 0;
				$config['y_axis'] = 0;
			$config['maintain_ratio'] = FALSE;
			
			$this->image_lib->initialize($config);
			$crop_thumbnail = $this->image_lib->crop();
			if ( ! $crop_thumbnail)
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());
			}
			unlink("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$file_name);
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb1/".$file_name);
			
			
			// Thumbnail2 for bootstrap
			$config = array();
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name;
			$config['create_thumb'] = TRUE;
			$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$file_name;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = 100;
			  if ($width < $height) 
			  {		
			    if(($height/$width) < (150/170))
				{
					$config['height'] = 170;
				$config['width'] = intval(170 * ($height/$width));
				$config['master_dim'] = 'height';
				}
				else
				{
				$config['width'] = 170;
				$config['height'] = intval(150 * ($height/$width));
				$config['master_dim'] = 'width';
				}
				
			  } 
			  else if($width > $height)
			  {		
			   
					
				if(($width/$height) < (170/150))
				{
					$config['width'] = 170;
					$config['height'] = intval(150 * ($width/$height));
					$config['master_dim'] = 'width';
				}
				else
				{
					$config['width'] = intval(170 * ($width/$height));
					
				$config['height'] = 150;
				$config['master_dim'] = 'height';
				}
				
				
			  }
			  else  // for square image
			  {		
			  
				$config['width'] = 170;
				$config['height'] = intval(170 * ($height/$width));
				// if the thumbnail width is longer set to width otherwise set to height
				$config['master_dim'] = 'width';
				
			  }
			
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());	
			}
			
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$file_name);
			$this->image_lib->clear();
			
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$file_name;
			
			$config['width'] = 170;
			$config['height'] = 150;
		    // really important shoud be crop from top 0 left 0
				$config['x_axis'] = 0;
				$config['y_axis'] = 0;
			$config['maintain_ratio'] = FALSE;
			
			$this->image_lib->initialize($config);
			$crop_thumbnail = $this->image_lib->crop();
			if ( ! $crop_thumbnail)
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());
			}
			unlink("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$file_name);
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails2/".$file_name);
					  
			$this->session->set_flashdata('addphoto_id',$pid);
			$this->session->set_flashdata('addphoto_src',$file_name);
		}
		redirect('admin/new_cms/galleries/'.$gid);
	}

	function delete_photo($id) 
	{
		//$this->check_authentication();
		$photo = $this->Gallery_model->get_photo($id);
		//echo $id;
		//echo "<pre>". print_r($photo,true) ."</pre>";
		//exit;
		
		//if($photo['video'] == 1)
		//{
		//	$this->Gallery_model->delete_photo($id);
		//}
		//else
		//{
			if ($this->Gallery_model->delete_photo($id)) 
			{
				$this->Gallery_model->reset_thumbnail($id);
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/".$photo['name']);
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumbnails/".$photo['name']);
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumbnails2/".$photo['name']);
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumb1/".$photo['name']);
				
			} else {
				
			}
		//}
		
		
		redirect('admin/new_cms/galleries/'.$photo['gallery_id']);
	}
	
	function listorder()
    {
        
        $orders=$this->input->post('textorder');
        $id=$this->input->post('idgallery');
        if($orders<>'')
        {
            
            $order = explode(",", $orders);
            $image=array();                      
            for($i=0;$i<count($order);$i++)
            {                             
                $data=array(
                    'gallery_id' => $id,
                    'order'=> $i
                );
                $this->Gallery_model->update_photo($order[$i],$data);
                
            }   
            $this->session->set_flashdata('update',true);     
        }
        else
        {
            $this->session->set_flashdata('warning',true);
        }
        redirect('admin/new_cms/galleries/'.$id);       
    }
    
    function add_photo_title()
	{
		//$this->check_authentication();
		$id = $_POST['photo_id'];
		$data = array(
			'title' => $_POST['title'],			
			'modified' => date('Y-m-d H:i:s')
			);
		$this->Gallery_model->update_photo($id,$data);
		redirect('admin/new_cms/galleries/'.$_POST['gallery_id']);
	}
	
	function add_video()
	{
		//
		$gid = $_POST['gallery_id'];
		//$radio = $_POST['radio'];
		$link = $_POST['link'];
		$pos = strpos($link,'src="');
		$back = substr($link,$pos+5,strlen($link) - $pos);
		$pos = strpos($back,'"');
		$middle = substr($back,0,$pos);
		//echo $middle;
		
		$photo = array(
				'name' => $middle,
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s'),
				'gallery_id' => $gid,
				'order' => 0,
				'video' => 1
			);
			
		$pid = $this->Gallery_model->add_photo($photo);
		$this->Gallery_model->update_photo($pid,array('order'=>$pid));
		
		redirect('admin/new_cms/galleries/'.$gid);
		
	}
	
	#ORDER
	function login_as_admin($order_id)
	{		
		
		$this->session->destroy();		
		redirect(base_url().'store_admin/transfer_cart/'.$order_id);
	}
	
	function banner($temp=2) {
		//$data['main'] = $this->Content_model->get_main();
		$data['temp']=$temp;
		//$data['banners'] = $this->Content_model->get_banners();
		$data['banners'] = $this->Content_model->get_banners_temp($temp);
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_cms/banner',$data);
		$this->load->view('admin/new_common/footer');
	}

	function deletebanner($id="",$temp="2") {
		$banner = $this->Content_model->get_banner($id);
		unlink('./uploads/banners/'.$banner['name']);
		unlink('./uploads/banners/thumb/'.$banner['name']);
		$this->Content_model->delete_banner($id);
		redirect('admin/new_cms/banner/'.$temp);
	}
	function updatebanner() {
		$this->Content_model->update_banner($_POST['banner_id'],array('url' => $_POST['url']));
		redirect('admin/new_cms/banner');
	}

	function uploadbanner() {
		$config['upload_path'] = "./uploads/banners";
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '8192'; //  MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['width'] = 4000;
		$config['height'] = 4000;
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/cms/banner');		
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];
			$width = $data['upload_data']['image_width'];
			$height = $data['upload_data']['image_height'];
			
			//echo "<pre>". print_r($data['upload_data'],true) ."</pre>";
			//exit;
			
			# Add details to database			
			$banner = array(
				'name' => $name,
				'url' => 'http://',
				'lru' => $this->Content_model->min_lru(),
				'template' => $_POST['banner_template'],
				'created' => date('Y-m-d H:i:s')
			);
			if ($this->Content_model->add_banner($banner)) {
				# Create thumbnails
				
				$this->advanced_resizephoto($data,"./uploads/banners/","thumb",$width,$height,315,117);
				$this->resizephotobig($data,"./uploads/banners/ori","thumb",$width,$height,1200,600);
				$this->resizephotobig2($data,"./uploads/banners/ori2","thumb",$width,$height,1200,920);
				//$this->advanced_resizephoto($data,"./uploads/banners/","thumb",$width,$height,800,600);
				//$this->resizephoto($name,"./uploads/banners","thumb",315,117);			
			}
		}
		redirect('admin/new_cms/banner/'.$_POST['banner_template']);
	}
	
	function activebanner($id="",$temp="2") {
		$this->Content_model->active_banner($id);
		redirect('admin/new_cms/banner/'.$temp);
		//echo 'test';
	}
	function advanced_resizephoto($data,$directory,$sub,$width,$height,$resize_width,$resize_height) 
	{
		$name = $data['upload_data']['file_name'];
		copy($directory."/".$name,$directory."/ori/".$name);	
		copy($directory."/".$name,$directory."/ori2/".$name);					
		/* note: this is the best version working in all images, resize then crop */
		if ($width <= $resize_width && $height <= $resize_height)
		{
			    copy($directory."/".$name,$directory."/".$sub."/".$name);
		}
		else 
		{
			  if ($width > 800 || $height > 600)
			  {
				$config = array();
				// Resize image
				$config['source_image'] = $directory."/".$data['upload_data']['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = 1200;
				$config['height'] = 920;
				$config['master_dim'] = 'auto';
				$this->load->library('image_lib');
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				unlink($directory."/".$name);
				rename($directory."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$name);
				$this->image_lib->clear();
			  }
			  
			  // Thumbnail creation				
		      $config = array();
		      $config['source_image'] = $directory."/".$name;
		      $config['create_thumb'] = TRUE;
		      $config['new_image'] = $directory."/".$sub."/".$name;
		      $config['maintain_ratio'] = FALSE;
		      $config['quality'] = 100;
			  if ($width < $height) 
		      {		
		 	     if(($height/$width) < ($resize_height/$resize_width))
		         {
			      $config['height'] = $resize_height;
			      $config['width'] = intval($resize_width * ($height/$width));
			      $config['master_dim'] = 'height';
		         }
		         else
		         {
			       $config['width'] = $resize_width;
			       $config['height'] = intval($resize_height * ($height/$width));
			       $config['master_dim'] = 'width';
		         }
		      }
			  else if($width > $height) 
		      {				
			   if(($width/$height) < ($resize_width/$resize_height))
			   {
				$config['width'] = $resize_width;
				$config['height'] = intval($resize_height * ($width/$height));
				$config['master_dim'] = 'width';
			   }
			   else
			   {
				$config['width'] = intval($resize_width * ($width/$height));
			    $config['height'] = $resize_height;
			    $config['master_dim'] = 'height';
			   }
		      }
			  else
		      {				
			   $config['width'] = $resize_width;
			   $config['height'] = intval($resize_height * ($height/$width));
			   $config['master_dim'] = 'width';
		
		      }
			  $this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());	
			}
			rename($directory."/".$sub."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$sub."/".$name);
			$this->image_lib->clear();
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = $directory."/".$sub."/".$name;
			
			$config['width'] = $resize_width;
			$config['height'] = $resize_height;
		    // really important shoud be crop from top 0 left 0
				$config['x_axis'] = 0;
				$config['y_axis'] = 0;
			$config['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config);
			$crop_thumbnail = $this->image_lib->crop();
			if ( ! $crop_thumbnail)
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());
			}
			unlink($directory."/".$sub."/".$name);
			rename($directory."/".$sub."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$sub."/".$name);
			
		}
		
		
	}
	function resizephotobig($data,$directory,$sub,$width,$height,$resize_width,$resize_height) 
	{
		$name = $data['upload_data']['file_name'];
						
		/* note: this is the best version working in all images, resize then crop */
		if ($width <= $resize_width && $height <= $resize_height)
		{
			    copy($directory."/".$name,$directory."/".$sub."/".$name);
		}
		else 
		{
			 if($width > 1200 || $height > 600)
			 { 
				$config = array();
				// Resize image
				$config['source_image'] = $directory."/".$data['upload_data']['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = 1200;
				$config['height'] = 600;
				$config['master_dim'] = 'auto';
				$this->load->library('image_lib');
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				//unlink($directory."/".$name);
				//rename($directory."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$name);
				$this->image_lib->clear();
			 }
			  
			  // Thumbnail creation				
		      $config = array();
		      $config['source_image'] = $directory."/".$name;
		      $config['create_thumb'] = TRUE;
		      $config['new_image'] = $directory."/".$sub."/".$name;
		      $config['maintain_ratio'] = FALSE;
		      $config['quality'] = 100;
			  if ($width < $height) 
		      {		
		 	     if(($height/$width) < ($resize_height/$resize_width))
		         {
			      $config['height'] = $resize_height;
			      $config['width'] = intval($resize_width * ($height/$width));
			      $config['master_dim'] = 'height';
		         }
		         else
		         {
			       $config['width'] = $resize_width;
			       $config['height'] = intval($resize_height * ($height/$width));
			       $config['master_dim'] = 'width';
		         }
		      }
			  else if($width > $height) 
		      {				
			   if(($width/$height) < ($resize_width/$resize_height))
			   {
				$config['width'] = $resize_width;
				$config['height'] = intval($resize_height * ($width/$height));
				$config['master_dim'] = 'width';
			   }
			   else
			   {
				$config['width'] = intval($resize_width * ($width/$height));
			    $config['height'] = $resize_height;
			    $config['master_dim'] = 'height';
			   }
		      }
			  else
		      {				
			   $config['width'] = $resize_width;
			   $config['height'] = intval($resize_height * ($height/$width));
			   $config['master_dim'] = 'width';
		
		      }
			  $this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());	
			}
			rename($directory."/".$sub."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$sub."/".$name);
			$this->image_lib->clear();
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = $directory."/".$sub."/".$name;
			
			$config['width'] = $resize_width;
			$config['height'] = $resize_height;
		    // really important shoud be crop from top 0 left 0
				$config['x_axis'] = 0;
				$config['y_axis'] = 0;
			$config['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config);
			$crop_thumbnail = $this->image_lib->crop();
			if ( ! $crop_thumbnail)
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());
			}
			unlink($directory."/".$sub."/".$name);
			rename($directory."/".$sub."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$sub."/".$name);
			
		}
		
		
	}
	function resizephotobig2($data,$directory,$sub,$width,$height,$resize_width,$resize_height) 
	{
		$name = $data['upload_data']['file_name'];
						
		/* note: this is the best version working in all images, resize then crop */
		if ($width <= $resize_width && $height <= $resize_height)
		{
			    copy($directory."/".$name,$directory."/".$sub."/".$name);
		}
		else 
		{
			 if($width > 1200 || $height > 920) 
			 {
				$config = array();
				// Resize image
				$config['source_image'] = $directory."/".$data['upload_data']['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 100;
				$config['width'] = 1200;
				$config['height'] = 920;
				$config['master_dim'] = 'auto';
				$this->load->library('image_lib');
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				unlink($directory."/".$name);
				rename($directory."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$name);
				$this->image_lib->clear();
			 }
			  
			  // Thumbnail creation				
		      $config = array();
		      $config['source_image'] = $directory."/".$name;
		      $config['create_thumb'] = TRUE;
		      $config['new_image'] = $directory."/".$sub."/".$name;
		      $config['maintain_ratio'] = FALSE;
		      $config['quality'] = 100;
			  if ($width < $height) 
		      {		
		 	     if(($height/$width) < ($resize_height/$resize_width))
		         {
			      $config['height'] = $resize_height;
			      $config['width'] = intval($resize_width * ($height/$width));
			      $config['master_dim'] = 'height';
		         }
		         else
		         {
			       $config['width'] = $resize_width;
			       $config['height'] = intval($resize_height * ($height/$width));
			       $config['master_dim'] = 'width';
		         }
		      }
			  else if($width > $height) 
		      {				
			   if(($width/$height) < ($resize_width/$resize_height))
			   {
				$config['width'] = $resize_width;
				$config['height'] = intval($resize_height * ($width/$height));
				$config['master_dim'] = 'width';
			   }
			   else
			   {
				$config['width'] = intval($resize_width * ($width/$height));
			    $config['height'] = $resize_height;
			    $config['master_dim'] = 'height';
			   }
		      }
			  else
		      {				
			   $config['width'] = $resize_width;
			   $config['height'] = intval($resize_height * ($height/$width));
			   $config['master_dim'] = 'width';
		
		      }
			  $this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());	
			}
			rename($directory."/".$sub."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$sub."/".$name);
			$this->image_lib->clear();
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = $directory."/".$sub."/".$name;
			
			$config['width'] = $resize_width;
			$config['height'] = $resize_height;
		    // really important shoud be crop from top 0 left 0
				$config['x_axis'] = 0;
				$config['y_axis'] = 0;
			$config['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config);
			$crop_thumbnail = $this->image_lib->crop();
			if ( ! $crop_thumbnail)
			{
				$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());
			}
			unlink($directory."/".$sub."/".$name);
			rename($directory."/".$sub."/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],$directory."/".$sub."/".$name);
			
		}
		
		
	}

	function category($action="") {
		if ($action == "add") {
			if (!isset($_POST['title'])) { redirect('admin/new_cms/category'); }
			$parent_id = $_POST['parent_id'];
			$this->session->set_userdata('parent_category',$parent_id);
			
			$order = 0;
			$title = $_POST['title'];
			if($title == "") {
				$this->session->set_flashdata('error_input','Please enter a title for new sub category');
				redirect('admin/new_cms/category');
			}
			
			$name = str_replace(" ","-",strtolower($title));
			if(isset($_POST['optionsRadios']))
			{
				if($_POST['optionsRadios']==1)
				{
					$type=0;
				}
				else
				{
					$type=1;
				}
			}
			$id_page=0;
			if(isset($_POST['subcatdetail']))
			{
				$id_page=$_POST['subcatdetail'];
			}
			$external_link='';
			if(isset($_POST['external_link']))
			{
				$external_link=$_POST['external_link'];
			}
			$data = array(
				'parent_id' => $parent_id,
				'name' => $name,
				'title' => $title,
				'type' => $type,
				'external_link' => $external_link,
				'id_page' => $id_page,
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			if($type==0)
			{
				$data_new=array(
						'category_id' => $parent_id,
						'name' => $title,
						'text' => str_replace(" ","_",$title),
						'keywords' => strtolower($title)
					);
				$this->Category_model->add_keyword($data_new);
			}
			$id = $this->Category_model->add($data);
			if ($order == 0) {
				$this->Category_model->update($id,array('order' => $id));
			} else {
				$order2 = 0;
				$prev = $this->Category_model->get_previous($parent_id,$order);
				if ($prev) { $order2 = $prev['order']; }
				$order1 = ($order + $order2)/2;
				$this->Category_model->update($id,array('order' => $order1));
			}
			
			redirect('admin/new_cms/category');
		}
		$data['main_categories'] = $this->Category_model->get_main();
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_product/category',$data);
		$this->load->view('admin/new_common/footer');
	}
	function getsubcatpage()
	{
		$id=$this->input->post('id');
		$subcat = $this->Menu_model->getpage_cat($id);
		$out='<select name="subcatdetail" id="subcatdetail" class="selectpicker">';
		foreach($subcat as $sc)
		{
			$out.='<option value="'.$sc['id'].'">'.$sc['title'].'</option>';
		}
		$out.='</select><script>jQuery(".selectpicker").selectpicker();</script>';
		echo $out;
	}
	function getsubcatpage2()
	{
		$id=$this->input->post('id');
		$subcat = $this->Menu_model->getpage_cat($id);
		$out='<select name="subcatdetail" id="page_category_dtr" class="selectpicker">';
		foreach($subcat as $sc)
		{
			$out.='<option value="'.$sc['id'].'">'.$sc['title'].'</option>';
		}
		$out.='</select><script>jQuery(".selectpicker").selectpicker();</script>';
		echo $out;
	}
	function updatecat() {
		$id = $_POST['id'];
		$id_page = $_POST['page_id'];
		$cat = $this->Category_model->identify($id);
		$this->session->set_userdata('parent_category',$cat['parent_id']);
		$title = $_POST['title'];
		$name = str_replace(" ","-",strtolower($title));
		$data = array(
			'name' => $name,
			'title' => $title,
			'id_page' => $id_page,
			'modified' => date('Y-m-d H:i:s')
		);
		$this->Category_model->update($id,$data);
	}
	function movecat($cat_id,$step) {		
		$cat = $this->Category_model->identify($cat_id);
		$this->session->set_userdata('parent_category',$cat['parent_id']);
		
		if ($step == 1) {
			$other = $this->Category_model->get_next($cat['parent_id'],$cat['order']);
		} else if ($step == -1) {
			$other = $this->Category_model->get_previous($cat['parent_id'],$cat['order']);
		}
		$this->swap($cat,$other);
		redirect('admin/new_cms/category');
	}
	function update_order()
	{
		$indx=$this->input->post('indx');
		$i=1;
		foreach($indx as $in)
		{
			$data=array(
				'order' => $i,
			);
			$this->Category_model->update($in,$data);
			$i++;
		}
	}
	function delcat($cat_id) {
		$cat = $this->Category_model->identify($cat_id);
		$this->session->set_userdata('parent_category',$cat['parent_id']);
		$this->Category_model->delete($cat['id']);
		$this->Category_model->remove_products($cat['id']);
		redirect('admin/new_cms/category');
	}
	function getsubcatlist() {
		$parent_id = $_POST['id'];
		$categories = $this->Category_model->get($parent_id);
		$out = '<select name="order">';					
		foreach($categories as $cat) {
			$out .= '<option value="'.$cat['order'].'">Before - '.$cat['title'].'</option>';
		}
		$out .= '<option value="0" selected="selected">At the end</option>';
        $out .= '</select>';
		print $out;
	} // Ajax functi
	function getsubcat() {
		if(isset($_POST['id']))
		{ 
			$parent_id = $_POST['id'];
		}
		else
		{
			$parent_id = -1;
		}
		$categories = $this->Category_model->get($parent_id);
		$out = '';
		if ($categories) {
			$n = 0;
			foreach($categories as $cat) {
				$n++;
				/*
				$out .= '<div class="row-item">';
				$out .= '<div class="cat-name" id="cat-'.$cat['id'].'">'.$cat['title'].'</div>';
				if ($n==count($categories)) {
					$out .= '<div class="cat-func"><img src="'.base_url().'img/backend/icon-movedown-gray.png" title="This is already the bottom one and cannot be moved down further" /></div>';
				} else {
					$out .= '<div class="cat-func"><a href="javascript:move(1,'.$cat['id'].')"><img src="'.base_url().'img/backend/icon-movedown.png" title="Move down" /></a></div>';
				}
				if ($n==1) {
					$out .= '<div class="cat-func"><img src="'.base_url().'img/backend/icon-moveup-gray.png" title="This is already the top one and cannot be moved up further" /></div>';
				} else {
					$out .= '<div class="cat-func"><a href="javascript:move(-1,'.$cat['id'].')"><img src="'.base_url().'img/backend/icon-moveup.png" title="Move up" /></a></div>';
				}
				$out .= '<div class="cat-func"><a href="javascript:delcat('.$cat['id'].')"><img src="'.base_url().'img/backend/icon-delete.png" title="Delete this category" /></a></div>';
				$out .= '<div class="cat-func"><a href="javascript:edit('.$cat['id'].')"><img src="'.base_url().'img/backend/icon-view.png" title="Edit this category" /></a></div>';
				$out .= '</div>';*/
				
				$out .= '
				<tr id="cat-'.$cat['id'].'" class="tr_cat">
					<td id="detail_cat-'.$cat['id'].'">
						<span id="detaillink'.$cat['id'].'">
						'.$cat['title'].'
						</span>
						<span id="detail'.$cat['id'].'" style="display:none;">'.$cat['title'].'</span>
					</td>';
					/*
					if ($n==count($categories)) {
						$out .= '<td style="text-align:center;"><span style="cursor:pointer" ><i class="icon-circle-arrow-down icon-2x"></i></span></td>';
					} else {
						$out .= '<td style="text-align:center;"><span style="cursor:pointer" onclick="move(1,'.$cat['id'].')"><i class="icon-circle-arrow-down icon-2x"></i></span></td>';
					}
					if ($n==1) {
						$out .= '<td style="text-align:center;"><span style="cursor:pointer"><i class="icon-circle-arrow-up icon-2x"></i></span></td>';
					} else {
						$out .= '<td style="text-align:center;"><span style="cursor:pointer" onclick="move(-1,'.$cat['id'].')"><i class="icon-circle-arrow-up icon-2x"></i></span></td>';
					}*/					
					
					$out .= '<td style="text-align:center;"><span style="cursor:pointer" onclick="edit('.$cat['id'].')"><i class="icon-edit icon-2x"></i></span></td>';
					$out .= '<td style="text-align:center;"><span style="color:#C70520; cursor:pointer" onclick="delcat('.$cat['id'].')"><i class="icon-remove-circle icon-2x"></i></span></td>';
					/*
					<td style="text-align:center;">
						<span style="cursor:pointer" onclick="showpage('.$page['id'].')"><i class="icon-search icon-2x"></i></span>
					</td>
					<td style="text-align:center;">
						<span style="cursor:pointer" onclick="editpage('.$page['id'].')"><i class="icon-edit icon-2x"></i></span>
					</td>
					<td style="text-align:center;">
						<span style="cursor:pointer" onclick="showcopymodal('.$page['id'].')"><i class="icon-share icon-2x"></i></span>
					</td>
					<td style="text-align:center;">
						<span style="cursor:pointer" onclick="showgallerymodal('.$page['id'].')"><i class="icon-camera icon-2x"></i></span>
					</td>
					<td style="text-align:center;">
						<span style="color:#C70520; cursor:pointer" onclick="showmodal('.$page['id'].')"><i class="icon-remove-circle icon-2x"></i></span>
					</td>
					*/
					$out.='</tr>';
				
				
				
				
			}        
		} else {
			$out .= '<div class="row-item"><div class="cat-name">There is no sub category yet!</div></div>';
		}
		print $out;
	}
	function editcatpage()
	{
		$id=$_POST['id'];
		$detail = $this->Category_model->identify($id);
		$title_link='';
		$title=$detail['title'];
		$out="<input type='hidden' id='title_link_".$id."' value='".$title_link."'><input type='text' class='textfield rounded' value='".$title ."' id='title-cat-".$id."' />";
		
		if($detail['type']==1)	
		{
			if($detail['id_page']>0){
				$cats=$this->Menu_model->get_cat_from_page($detail['id_page']);
				$main_categories = $this->Category_model->get_main();
				$subcat = $this->Menu_model->getpage_cat($cats['category_id']);
			
				$out.="<br>
				<select name='page_category_dt' id='page_category_dt".$id."' class='selectpicker' onchange='change_page_detail_dt(".$id.")'>";
				foreach($main_categories as $mc) { 
					$out.="<option value='".$mc['id']."'"; if($mc['id'] == $cats['category_id']){ $out.= " selected='selected'";} $out.=" >".$mc['title']."</option>";
				}                   
				$out.="</select>";
				$out.="<br>
				<div id='dtdiv".$id."'>
				<select name='page_category_dt' id='page_category_dtr".$id."' class='selectpicker'>";
				foreach($subcat as $mc2) { 
					$out.="<option value='".$mc2['id']."'"; if($mc2['id'] == $detail['id_page']){ $out.= " selected='selected'";} $out.=" >".$mc2['title']."</option>";
				}                   
				$out.="</select></div>";
				$out.='<script>jQuery(".selectpicker").selectpicker();</script>';	
			}
		}
		
		$out.="<br><input type='button' class='btn btn-primary' value='Update' onClick='update(".$id.")' /> &nbsp;&nbsp; <input type='button' class='btn btn-primary' value='Cancel' onClick='cancel(".$id.")'/>";
		
		echo $out;
	}
	function swap($one,$two) {
		$this->Category_model->update($one['id'],array('order' => $two['order']));
		$this->Category_model->update($two['id'],array('order' => $one['order']));
	}
	function feature() {
		$data['main'] = $this->Category_model->get_main();
		$data['features'] = $this->Product_model->get_features();
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_product/feature',$data);
		$this->load->view('admin/new_common/footer');
	}
	function searchfeature() {
		$keyword = $_POST['keyword'];
		$category = $_POST['category'];
		$products = $this->Product_model->search($keyword,$category,true);		
		$out = '
    <div class="box">
    <form name="featureForm" method="post" action="'.base_url().'admin/new_store/addfeature">
        <h2 style="padding-left:7px;">Products List</h2>
        <div style="margin-top: 10px;" class="list_line"></div>
		<table class="table table-hover">
		<thead>
			<tr style="font-size: 15px">
				<th style="width: 85%">Product name</th>
				<th style="width: 15%; text-align: center;">Add</th>				
			</tr>
		</thead>
				
		<tbody id="subcat">';			        
		
		foreach($products as $product) { 
			if (!$this->Product_model->is_feature($product['id']) && $product['deleted'] == 0 && $product['status'] == 1) {
			$out .= '			
			<tr>
				<td>'.$product['title'].'</td>
				<td style="text-align: center;">
					&nbsp; <input type="checkbox" value="'.$product['id'].'" name="products[]" /> &nbsp;
				</td>
			</tr> 
			
			';
            	} 
			}
		$out .= '
		</tbody>		
		</table>

    	<p align="right">
			
			<button class="btn btn-primary" type="button" onClick="document.featureForm.submit()">Add Products</button>
		</p>        
    </div>
    </form>';
		print $out;
	}
	function addfeature() {
		$n = $this->Product_model->count_features();
		if (isset($_POST['products'])) {
			$products = $_POST['products'];
			if ($n + count($products) > 6) {
				$this->session->set_flashdata('addft_true',true);
			} else
				foreach($products as $product_id) {
					$feature_id = $this->Product_model->add_feature(array('product_id' => $product_id));
					$this->Product_model->update_feature($feature_id,array('order' => $feature_id));
				}
		}
		redirect('admin/new_store/feature');
	}
	function removefeature($product_id="") {
		$this->Product_model->remove_feature($product_id);
		redirect('admin/new_store/feature');
	}
	function movefeature($product_id,$step) {
		$feature = $this->Product_model->get_feature($product_id);
		if($step == 1) {
			$next = $this->Product_model->get_next_feature($feature['order']);
			$this->swap_feature($feature,$next);
		} else if ($step == -1) {
			$prev = $this->Product_model->get_prev_feature($feature['order']);
			$this->swap_feature($feature,$prev);
		}
		redirect('admin/store/feature');		
	}
	function swap_feature($one,$two) {
		$this->Product_model->update_feature($one['id'],array('order' => $two['order']));
		$this->Product_model->update_feature($two['id'],array('order' => $one['order']));
	}
	function get_product_att()
	{
		$id = $_POST['id'];
		$att = $this->System_model->get_attribute($id);
		echo $att['name'];
	}
	
	function addproduct() {	
		# Collect basic product data
		//$title = $_POST['title'];
		$title = $_POST['title'];
		$short_desc = $_POST['short_desc'];
		$long_desc = $_POST['long_desc'];
		$price = $_POST['price'];
		$sale_price = $_POST['sale_price'];
		if ($sale_price == "") { $sale_price = $price; }
		$price_trade = $_POST['price_trade'];
		if ($price_trade == "") { $price_trade = $price; }
		$sale_price_trade = $_POST['sale_price_trade'];
		if ($sale_price_trade == "") { $sale_price_trade = $price_trade; }
		
		$style_no = $_POST['style_no'];
		$dimension=$_POST['product_dimension'];		
		$weight = $_POST['weight'];
		$stock=$_POST['product_stock'];
		$stock_id=$_POST['product_stock_id'];
			
		if($_POST['typeproduct']=="no")
		{
			$new_id_title = str_replace(' ','-',$title);
			$new_id_title = str_replace("'","",$new_id_title);
			$new_id_title = str_replace("&","and",$new_id_title);
			$new_id_title = str_replace("+","and",$new_id_title);
			# Add new data
		   $data = array(
		    'id_title' => $new_id_title,
			'title' => $title,
			'short_desc' => $short_desc,
			'long_desc' => $long_desc,
			'price' => $price,
			'sale_price' => $sale_price,
			'price_trade' => $price_trade,
			'sale_price_trade' => $sale_price_trade,
			'style_no' => $style_no,
			'dimension'=> $dimension,
			'weight' => $weight,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s'),
			'multiplesize' =>0,
			'stock' => $stock,
			'stock_id' => $stock_id,
			'size' => '',
			'ean'=>$_POST['ean'],
			'available_retail'=>$_POST['available_retail'],
			'available_wsale'=>$_POST['available_wsale'],
			'limited'=>$_POST['limited'],
			'first_edition'=>$_POST['first_edition'],
			'features'=>$_POST['features'],
			'length'=>$_POST['length'],
			'main_category'=>$_POST['main_category'],
			'collection'=>$_POST['collection'],
			'composition'=>$_POST['composition'],
			'volume' => $_POST['volume'],
			'dimension_w' => $_POST['dimension_w'],
			'dimension_h' => $_POST['dimension_h'],
			'dimension_d' => $_POST['dimension_d'],
			'show_weight' => $_POST['show_weight']
		   );
		}
		else if($_POST['typeproduct']=="yes")
		{
			
			$multiple_stock = array(
			         'XXXS' => $_POST['XXXS'],
					 'XXS' => $_POST['XXS'],
					 'XS' => $_POST['XS'],
					 'S' => $_POST['S'],
					 'M' => $_POST['M'],
					 'L' => $_POST['L'],
					 'XL' => $_POST['XL'],
					 'XXL' => $_POST['XXL'],
					 '3XL' => $_POST['3XL'],
					 '4XL' => $_POST['4XL'],
					 '5XL' => $_POST['5XL'],
					 '6XL' => $_POST['6XL'],
					 '6' => $_POST['6'],
					 '8' => $_POST['8'],
					 '10' => $_POST['10'],
					 '12' => $_POST['12'],
					 '14' => $_POST['14'],
					 '16' => $_POST['16'],
					 '18' => $_POST['18'],
					 '20' => $_POST['20'],
					 '22' => $_POST['22']
					 );
			
			$multiple_stock_json = json_encode($multiple_stock, JSON_FORCE_OBJECT);
		    # Add new data
		   $data = array(
			'title' => $title,
			'short_desc' => $short_desc,
			'long_desc' => $long_desc,
			'price' => $price,
			'sale_price' => $sale_price,
			'price_trade' => $price_trade,
			'sale_price_trade' => $sale_price_trade,
			'style_no' => $style_no,
			'dimension'=> $dimension,
			'weight' => $weight,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s'),
			'multiplesize' =>1,
			'stock' => 0,
			'size' => $multiple_stock_json
		   );
		}
		$product_id = $this->Product_model->add($data);
		
		# Add relation product and category
		if (isset($_POST['categories'])) {
			$categories = $_POST['categories'];
			foreach($categories as $category_id) {
				$data = array(
					'product_id' => $product_id,
					'category_id' => $category_id
				);
				$this->Product_model->add_category($data);
			}
		}
		
		$data = array(
					'product_id' => $product_id,
					'category_id' => $_POST['main_category']
				);
				$this->Product_model->add_category($data);
		
		# Add product attributes
		if (isset($_POST['attributes'])&&!empty($_POST['attributes'])) {
			$attributes = $_POST['attributes'];
			foreach($attributes as $attribute_id) {
				$attribute = $this->System_model->get_attribute($attribute_id);
				$value = array();
				if (isset($_POST['options-'.$attribute_id])&&!empty($_POST['options-'.$attribute_id])) {
					$options = $_POST['options-'.$attribute_id];
					foreach($options as $opt) {
						//$value .= $opt.'~';
						$value[] = $opt;
					}
				}
				$js_encode_value = json_encode($value,JSON_FORCE_OBJECT);
					$data = array(
						'product_id' => $product_id,
						'name' => $attribute['name'],
						'value' => $js_encode_value
					);
					$this->Product_model->add_attribute($data);
				
			}
		}
		
		# Create dir for storing file related to the product
		$path = "./uploads/products";
		$newfolder = md5('mbb'.$product_id);
		$dir = $path."/".$newfolder;
		
		mkdir($dir,0777);
		chmod($dir,0777);
		$thumb1 = $dir."/thumb1";
		mkdir($thumb1,0777);
		chmod($thumb1,0777);
		$thumb2 = $dir."/thumb2";
		mkdir($thumb2,0777);
		chmod($thumb2,0777);
		$thumb3 = $dir."/thumb3";
		mkdir($thumb3,0777);
		chmod($thumb3,0777);
		$thumb4 = $dir."/thumb4";
		mkdir($thumb4,0777);
		chmod($thumb4,0777);
		$thumb5 = $dir."/thumb5";
		mkdir($thumb5,0777);
		chmod($thumb5,0777);
		$thumb6 = $dir."/thumb6";
		mkdir($thumb6,0777);
		chmod($thumb6,0777);
		$thumb7 = $dir."/thumb7";
		mkdir($thumb7,0777);
		chmod($thumb7,0777);
		$thumb8 = $dir."/thumb8";
		mkdir($thumb8,0777);
		chmod($thumb8,0777);
		redirect('admin/new_cms/product');
	}

	function editproduct() {
		$id = $_POST['id'];
		$price = $_POST['price'];
		$sale_price = $_POST['sale_price'];
		if ($sale_price == "") { $sale_price = $price; }
		$price_trade = $_POST['price_trade'];
		$sale_price_trade = $_POST['sale_price_trade'];
		if ($sale_price_trade == "") { $sale_price_trade = $price_trade; }
		if($_POST['typeproduct']=="no")
		{
		 $data = array(
			'title' => $_POST['title'],
			'short_desc' => $_POST['short_desc'],
			'long_desc' => $_POST['long_desc'],
			'price' => $price,
			'sale_price' => $sale_price,
			'price_trade' => $price_trade,
			'sale_price_trade' => $sale_price_trade,
			'style_no' => $_POST['style_no'],
			'dimension' =>$_POST['product_dimension'],
			//'pack_size' =>$_POST['product_pack_size'],
			'weight' => $_POST['weight'],
			'volume' => $_POST['volume'],
			'dimension_w' => $_POST['dimension_w'],
			'dimension_d' => $_POST['dimension_d'],
			'dimension_h' => $_POST['dimension_h'],
			'modified' => date('Y-m-d H:i:s'),
			'multiplesize' =>0,
			'stock' => $_POST['product_stock'],
			'stock_id' => $_POST['product_stock_id'],
			'size' => '',
			'ean'=>$_POST['ean'],
			'available_retail'=>$_POST['available_retail'],
			'available_wsale'=>$_POST['available_wsale'],
			'limited'=>$_POST['limited'],
			// 'numbered'=>$_POST['numbered'],
			'first_edition'=>$_POST['first_edition'],
			'features'=>$_POST['features'],
			'length'=>$_POST['length'],
			'main_category'=>$_POST['main_category'],
			'collection'=>$_POST['collection'],
			'composition'=>$_POST['composition'],
			'show_weight' => $_POST['show_weight']
		 );
		}
		else if($_POST['typeproduct']=="yes")
		{
			$multiple_stock = array(
			         'XXXS' => $_POST['XXXS'],
					 'XXS' => $_POST['XXS'],
					 'XS' => $_POST['XS'],
					 'S' => $_POST['S'],
					 'M' => $_POST['M'],
					 'L' => $_POST['L'],
					 'XL' => $_POST['XL'],
					 'XXL' => $_POST['XXL'],
					 '3XL' => $_POST['3XL'],
					 '4XL' => $_POST['4XL'],
					 '5XL' => $_POST['5XL'],
					 '6XL' => $_POST['6XL'],
					 '6' => $_POST['6'],
					 '8' => $_POST['8'],
					 '10' => $_POST['10'],
					 '12' => $_POST['12'],
					 '14' => $_POST['14'],
					 '16' => $_POST['16'],
					 '18' => $_POST['18'],
					 '20' => $_POST['20'],
					 '22' => $_POST['22']
					 );
			
			$multiple_stock_json = json_encode($multiple_stock, JSON_FORCE_OBJECT);
			$data = array(
			'title' => $_POST['title'],
			'short_desc' => $_POST['short_desc'],
			'long_desc' => $_POST['long_desc'],
			'price' => $price,
			'sale_price' => $sale_price,
			'price_trade' => $price_trade,
			'sale_price_trade' => $sale_price_trade,
			'style_no' => $_POST['style_no'],
			'dimension' =>$_POST['product_dimension'],
			//'pack_size' =>$_POST['product_pack_size'],
			'weight' => $_POST['weight'],
			'modified' => date('Y-m-d H:i:s'),
			'multiplesize' =>1,
			'stock' => 0,
			'size' =>$multiple_stock_json
		   );
		}
		if ($this->Product_model->update($id,$data)) 
		{
			$this->session->set_flashdata('update',true);
		}
		
		$this->Product_model->remove_attributes($id);
		
		# Add product attributes
		if (isset($_POST['prodattributes'])) {
			$attributes = $_POST['prodattributes'];
			$n = 1;
			foreach($attributes as $attribute_name) 
			{
				$value = array();
				if (isset($_POST['prodoptions-'.$n])) 
				{
					$options = $_POST['prodoptions-'.$n];
					foreach($options as $opt) 
					{
						//$value .= $opt.'~';
						$value[] = $opt;
					}
				}
				$js_encode_value = json_encode($value,JSON_FORCE_OBJECT);
				$data = array(
					'product_id' => $id,
					'name' => $attribute_name,
					'value' => $js_encode_value
				);
				$this->Product_model->add_attribute($data);
				$n++;
			}
		}
		
		# Add new product attributes
		if (isset($_POST['attributes'])) {
			$attributes = $_POST['attributes'];
			foreach($attributes as $attribute_id) {
				$attribute = $this->System_model->get_attribute($attribute_id);
				$value = array();
				if (isset($_POST['options-'.$attribute_id])) {
					$options = $_POST['options-'.$attribute_id];
					foreach($options as $opt) {
						//$value .= $opt.'~';
						$value[] = $opt;
					}
				}
				$js_encode_value = json_encode($value,JSON_FORCE_OBJECT);
				$data = array(
					'product_id' => $id,
					'name' => $attribute['name'],
					'value' => $js_encode_value
				);
				$this->Product_model->add_attribute($data);
			}
		}
		redirect('admin/new_cms/product/edit/'.$id);
	}

	function import_product()
	{
		//$file = $_POST['userfile'];
		
		$config['upload_path'] = "./uploads/docs_raw";
	    $config['allowed_types'] = 'csv|text|txt';
		$config['max_size']	= '8192'; // 8 MB
		$config['overwrite'] = TRUE;
	    $config['remove_space'] = TRUE;
		$errors = '';
		$break = false;
		$warnings = '';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload())
	    {
	      	//echo "good";
	      	
	      	$upload_data = array('upload_data' => $this->upload->data());
      		$file_name = $upload_data['upload_data']['file_name'];
			$error_list='';
			$err_count = 0;
			
			//validation
			$handle1 = fopen(base_url().'uploads/docs_raw/'.$file_name, "r");
			$cc = 0; 
			$line = 1;
			while (($data = fgetcsv($handle1, 5000, ","))!== FALSE) 
			{
				if($cc != 0)
				{
					$new_id_title = str_replace(' ','-',$data[0]);
					$new_id_title = str_replace("'","",$new_id_title);
					$new_id_title = str_replace("&","and",$new_id_title);
					$new_id_title = str_replace("+","and",$new_id_title);
					
					if(trim($new_id_title) == '')
					{
						$err_count++;
						$error_list .= "row#$line col#A - Product title cannot blank<br/>";
					}
					
					$check_d = $this->Product_model->identify2($new_id_title);
					
					if(count($check_d)>0)
					{
						if($check_d['deleted'] == 0)
						{
							$err_count++;
							$error_list .= "row#$line col#A - A product with this product name already exists in the system<br/>";
						}
					}
					
					$temp = trim($data[4]);
					if($temp!='Y' && $temp!='y' && $temp!='N' && $temp!='n')
					{
						$err_count++;
						$error_list .= "row#$line col#E - Invalid input, should be 'Y'or'y'or'N'or'n'<br/>";
					}
					
					$temp = trim($data[5]);
					if($temp!='Y' && $temp!='y' && $temp!='N' && $temp!='n')
					{
						$err_count++;
						$error_list .= "row#$line col#F - Invalid input, should be 'Y'or'y'or'N'or'n'<br/>";
					}
					
					$temp = $data[6];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#G - Invalid input, should be numeric<br/>";
					}
					
					$temp = $data[7];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#H - Invalid input, should be nummeric<br/>";
					}
					
					$temp = $data[8];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#I - Invalid input, should be nummeric<br/>";
					}
					
					$temp = trim($data[9]);
					if($temp!='Y' && $temp!='y' && $temp!='N' && $temp!='n')
					{
						$err_count++;
						$error_list .= "row#$line col#J - Invalid input, should be 'Y'or'y'or'N'or'n'<br/>";
					}
					
					$temp = trim($data[10]);
					if($temp!='Y' && $temp!='y' && $temp!='N' && $temp!='n')
					{
						$err_count++;
						$error_list .= "row#$line col#K - Invalid input, should be 'Y'or'y'or'N'or'n'<br/>";
					}
					
					
					$temp = $data[15];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#P - Invalid input, should be nummeric<br/>";
					}
					
					$temp = strtolower(trim($data['16']));
					$new_cat = $this->Category_model->identify_by_title($temp);
					
					if(count($new_cat) > 0)
					{
						
					}
					else 
					{
						$err_count++;
						$error_list .= "row#$line col#Q - Invalid input, This category doesn't exist in our category list<br/>";
					}
					
					$temp = strtolower(trim($data['17']));
					$new_cat = $this->Category_model->identify_by_title($temp);
					
					if(count($new_cat) > 0)
					{
						
					}
					else 
					{
						$err_count++;
						$error_list .= "row#$line col#R - Invalid input, This category doesn't exist in our category list<br/>";
					}
					
					$temp = $data[20];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#U - Invalid input, should be nummeric<br/>";
					}
					
					$temp = $data[21];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#V - Invalid input, should be nummeric<br/>";
					}
					
					$temp = $data[22];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#W - Invalid input, should be nummeric<br/>";
					}
					
					$temp = $data[23];
					if(!is_numeric($temp))
					{
						$err_count++;
						$error_list .= "row#$line col#X - Invalid input, should be nummeric<br/>";
					}
					
					$temp = $data[24];
					if(trim($temp) == '')
					{
						$err_count++;
						$error_list .= "row#$line col#Y - Stock ID cannot blank<br/>";
					}
				}
				$cc++;
				$line++;
			}
			if($err_count==0)
			{
			//save it
		      	$handle = fopen(base_url().'uploads/docs_raw/'.$file_name, "r");
				$cc = 0; 
				while (($data = fgetcsv($handle, 5000, ","))!== FALSE) 
				{
					if($cc != 0)
					{
						//echo '<pre>'.print_r($data,true).'</pre>';
						
						$new_id_title = str_replace(' ','-',$data[0]);
						$new_id_title = str_replace("'","",$new_id_title);
						$new_id_title = str_replace("&","and",$new_id_title);
						$new_id_title = str_replace("+","and",$new_id_title);
						
						$ndata = Array();
						$ndata['id_title'] = $new_id_title;
						$ndata['title'] = $data[0];
						$new_desc = $data[1];
						$new_desc = str_replace("?","'",$new_desc);
						$ndata['short_desc'] = $new_desc;
						$ndata['style_no'] = $data[2];
						$ndata['ean'] = $data[3];
						$ndata['size_ref'] = '';
						$ndata['available_retail'] = trim($data[4]);
						$ndata['available_wsale'] = trim($data[5]);
						$ndata['price'] = $data[6];
						$ndata['sale_price'] = $data[6];
						$ndata['price_trade'] = $data[7];
						$ndata['sale_price_trade'] = $data[7];
						$ndata['stock'] = $data[8];
						$ndata['limited'] = trim($data[9]);
						$ndata['first_edition'] = trim($data[10]);
						$new_desc = $data[11];
						$new_desc = str_replace("?","'",$new_desc);
						$ndata['long_desc'] = $new_desc;
						$ndata['features'] = $data[12];
						$ndata['dimension'] = $data[13];
						$ndata['length'] = $data[14];
						$ndata['weight'] = $data[15];
						
						$cat = trim($data['16']);
						
						$new_cat = $this->Category_model->identify_by_title($cat);
						
						/*
						$category_id=0;
												if($cat == 'new arrivals') {$category_id = 1;}
												if($cat == 'handbags') {$category_id = 2;}
												if($cat == 'wallets') {$category_id = 3;}
												if($cat == 'travel') {$category_id = 4;}
												if($cat == 'accessories') {$category_id = 5;}
												if($cat == 'sale') {$category_id = 6;}
												if($cat == 'stylefile') {$category_id = 7;}
												if($cat == 'news') {$category_id = 8;}*/
						
						$mcat = $new_cat['id'];
						$ndata['main_category'] = $new_cat['id'];
						
						$cat = trim($data['17']);
						
						$new_cat = $this->Category_model->identify_by_title($cat);
						$scat = $new_cat['id'];
						
						
						$ndata['collection'] = $data[18];
						$ndata['composition'] = $data[19];
						$ndata['dimension_w'] = $data[20];
						$ndata['dimension_h'] = $data[21];
						$ndata['dimension_d'] = $data[22];
						$ndata['volume'] = $data[23];
						$ndata['stock_id'] = $data[24];
						
						$product_id = $this->Product_model->add($ndata);
						
						$nprod = $this->Product_model->identify($product_id);
						$new_desc = $nprod['short_desc'];
						$new_desc = str_replace("?","'",$new_desc);
						//$ad['short_desc'] = $new_desc;
						$sd = $new_desc;
						$new_desc = $nprod['long_desc'];
						$new_desc = str_replace("?","'",$new_desc);
						$ld = $new_desc;
						//$ad['long_desc'] = $new_desc;
						
						$sql = 'update products set short_desc ="'.$sd.'", long_desc = "'.$ld.'" where id = '.$product_id;
						$query = $this->db->query($sql);
						
						
						$mcatdata['product_id'] = $product_id;
						$mcatdata['category_id'] = $mcat;
						$this->Product_model->add_category($mcatdata);
						$scatdata['product_id'] = $product_id;
						$scatdata['category_id'] = $scat;
						$this->Product_model->add_category($scatdata);
						
						
						
						//$var="'".$desc."'";
						/*
						if($category_id > 0)
												{
													$cdata = array(
														'product_id' => $product_id,
														'category_id' => $category_id
													);
													$this->Product_model->add_category($cdata);
												}*/
						
						
						# Create dir for storing file related to the product
						$path = "./uploads/products";
						$newfolder = md5('mbb'.$product_id);
						$dir = $path."/".$newfolder;
						
						mkdir($dir,0777);
						chmod($dir,0777);
						$thumb1 = $dir."/thumb1";
						mkdir($thumb1,0777);
						chmod($thumb1,0777);
						$thumb2 = $dir."/thumb2";
						mkdir($thumb2,0777);
						chmod($thumb2,0777);
						$thumb3 = $dir."/thumb3";
						mkdir($thumb3,0777);
						chmod($thumb3,0777);
						$thumb4 = $dir."/thumb4";
						mkdir($thumb4,0777);
						chmod($thumb4,0777);
						$thumb5 = $dir."/thumb5";
						mkdir($thumb5,0777);
						chmod($thumb5,0777);
						$thumb6 = $dir."/thumb6";
						mkdir($thumb6,0777);
						chmod($thumb6,0777);
						$thumb7 = $dir."/thumb7";
						mkdir($thumb7,0777);
						chmod($thumb7,0777);
						$thumb8 = $dir."/thumb8";
						mkdir($thumb8,0777);
						chmod($thumb8,0777);
						
						//echo $product_id.'<br/>';
					}
					$cc++;
				}
				
				//$this->session->set_flashdata('upload_csv_sc','your csv has been successfully Uploaded');
				$this->session->set_flashdata('upload_csv_sc',"$cc new data from your csv has been successfully Uploaded");
				
				redirect('admin/new_cms/product');
			}
			else
			{
				$this->session->set_flashdata('upload_csv_er',"sorry, currently we cannot upload your file as we found $err_count error(s):<br/>".$error_list);
				redirect('admin/new_cms/product');
			}
	    }
		else
		{
			$this->session->set_flashdata('upload_csv_er','sorry, currently we cannot upload your file');
			
			redirect('admin/new_cms/product');
		}
		

	}

	function search_all_admin()
	{
		//error_reporting(E_ALL);
		$keyword = $_POST['keyword'];
		
		//$this->session->set_userdata('keyword_all_search',$keyword);
		
		//echo count($this->Order_model->search_v2('',$keyword,'','','','','','All'));
		

		if(count($this->Product_model->search($keyword,0,false)) > 0)
		{
			$this->session->set_userdata('keyword',$keyword);
			$this->session->set_userdata('category',0);
			redirect('admin/new_cms/product/search');
		}
		elseif (count($this->Order_model->search_v2('',$keyword,'','','','','','All')) > 0) 
		{
			$this->session->set_userdata('customer_name','');
			$this->session->set_userdata('order_id',$keyword);
			$this->session->set_userdata('from_date','');
			$this->session->set_userdata('to_date','');
			$this->session->set_userdata('by_keyword','');
			$this->session->set_userdata('by_payment','All');
			
			redirect('admin/order/list_all/search');
		}
		elseif (count($this->User_model->recognize_v2($keyword,1,0)) > 0)
		{
			$this->session->set_userdata('name',$keyword);
			//$this->session->set_userdata('type',$_POST['type']);
			redirect('admin/customer/list_all');
		}
		else 
		{
			$this->session->set_flashdata('no_result_search', 'No result found, please search using different keyword.');
			redirect('admin/new_cms');
		}

	}

	function only_admin()
	{
		redirect(base_url().'admin/new_cms');
	}
}
?>