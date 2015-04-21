<?php
class Store extends Controller {
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
		$data['orders'] = $this->Order_model->last(4);
		
		$products = $this->System_model->best_products();
		$categories = $this->Category_model->any();
		$bestcategories = array();
		foreach($categories as $category) {
			$total = 0;
			foreach($products as $bproduct) {
				if ($this->Product_model->product_category($bproduct['product_id'],$category['id'])) {
					$total += $bproduct['total'];
				}
			}
			$cat_title = $category['title'];
			if ($category['parent_id'] > 0) {
				$parent = $this->Category_model->identify($category['parent_id']);
				$cat_title = $parent['title'].' &raquo; '.$cat_title;
			}
			$bestcategories[] = array(
				'total' => $total,
				'category' => $cat_title
			);
		}
		arsort($bestcategories);
		$max = 0;
		$bestcategory = 'N/A';
		foreach($bestcategories as $cat) {
			if ($cat['total'] > $max) {
				$max = $cat['total'];
				$bestcategory = to_short($cat['category'],33).' ('.$max.')';
			}
		}
		$data['bestcategory'] = $bestcategory;
		$this->load->view('admin/common/header');
		$this->load->view('admin/system/dashboard',$data);
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}

	function product($action="",$product_id="") {
		$data['main'] = $this->Category_model->get_main();
		$this->load->view('admin/common/header');
		if($action == "add") {
			$data['attributes'] = $this->System_model->get_attributes();
			$this->load->view('admin/product/add',$data);
		} else if($action == "edit") {
			$data['product'] = $this->Product_model->identify($product_id);
			$data['attributes'] = $this->System_model->get_attributes();
			$data['product_attributes'] = $this->Product_model->get_attributes($product_id);			
			$this->load->view('admin/product/edit',$data);
		} else if($action == "search") {
			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/store/product/search/";
			$config['total_rows'] = count($this->Product_model->search($this->session->userdata('keyword'),$this->session->userdata('category'),false));
			$config['per_page'] = '10';
			$config['num_links'] = 4;
			$config['uri_segment'] = 5;
			$config['cur_tag_open'] = '&nbsp;<span class="active">';
			$config['cur_tag_close'] = '</span>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($product_id!="") { $row = $product_id; }
			$data['products'] = $this->Product_model->search_group($row,10,$this->session->userdata('keyword'),$this->session->userdata('category'),0,false);
			$this->load->view('admin/product/list',$data);
		} else {
			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/store/product/";
			$config['total_rows'] = count($this->Product_model->all());
			$config['per_page'] = '10';
			$config['num_links'] = 4;
			$config['uri_segment'] = 4;
			$config['cur_tag_open'] = '&nbsp;<span class="active">';
			$config['cur_tag_close'] = '</span>';
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$row = 0;
			if ($action!="") { $row = $action; }
			$data['products'] = $this->Product_model->group($row);
			$this->load->view('admin/product/list',$data);
		}
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}

	function category($action="") {
		if ($action == "add") {
			if (!isset($_POST['title'])) { redirect('admin/store/category'); }
			$parent_id = $_POST['parent_id'];
			$this->session->set_userdata('parent_category',$parent_id);
			
			$order = $_POST['order'];
			$title = $_POST['title'];
			if($title == "") {
				$this->session->set_flashdata('error_input','Please enter a title for new sub category');
				redirect('admin/store/category');
			}
			
			$name = str_replace(" ","-",strtolower($title));
			$data = array(
				'parent_id' => $parent_id,
				'name' => $name,
				'title' => $title,
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
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
			redirect('admin/store/category');
		}
		$data['main_categories'] = $this->Category_model->get_main();
		$this->load->view('admin/common/header');
		$this->load->view('admin/product/category',$data);
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}

	function addmaincat()
	{
		$name = $_POST['name'];
		
		$data['parent_id'] = 0;
		$data['order'] = 0;
		$data['name'] = $name;
		$data['title'] = $name;
		$data['created'] = date('Y-m-d');
		$data['modified'] = date('Y-m-d');
		
		$this->Category_model->add($data);
		
		redirect('admin/store/category');
		
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
	} // Ajax function 
	function getsubcat() {
		$parent_id = $_POST['id'];
		$categories = $this->Category_model->get($parent_id);
		$out = '';
		if ($categories) {
			$n = 0;
			foreach($categories as $cat) {
				$n++;
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
				$out .= '</div>';
			}        
		} else {
			$out .= '<div class="row-item"><div class="cat-name">There is no sub category yet!</div></div>';
		}
		print $out;
	}
	
	function delcat($cat_id) {
		$cat = $this->Category_model->identify($cat_id);
		$this->session->set_userdata('parent_category',$cat['parent_id']);
		$this->Category_model->delete($cat['id']);
		$this->Category_model->remove_products($cat['id']);
		redirect('admin/store/category');
	}
	function updatecat() {
		$id = $_POST['id'];
		$cat = $this->Category_model->identify($id);
		$this->session->set_userdata('parent_category',$cat['parent_id']);
		$title = $_POST['title'];
		$name = str_replace(" ","-",strtolower($title));
		$data = array(
			'name' => $name,
			'title' => $title,
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
		redirect('admin/store/category');
	}
	function swap($one,$two) {
		$this->Category_model->update($one['id'],array('order' => $two['order']));
		$this->Category_model->update($two['id'],array('order' => $one['order']));
	}
	
	function searchproduct() {
		$keyword = $_POST['keyword'];
		$category = $_POST['category'];
		$this->session->set_userdata('keyword',$_POST['keyword']);
		$this->session->set_userdata('category',$_POST['category']);
		redirect('admin/store/product/search');
	}
	function addproduct() {	
		# Collect basic product data
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
			
		if($_POST['typeproduct']=="no")
		{
			
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
			'multiplesize' =>0,
			'stock' => $stock,
			'size' => ''
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
		redirect('admin/store/product');
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
			'pack_size' =>$_POST['product_pack_size'],
			'weight' => $_POST['weight'],
			'modified' => date('Y-m-d H:i:s'),
			'multiplesize' =>0,
			'stock' => $_POST['product_stock'],
			'size' => ''
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
			'pack_size' =>$_POST['product_pack_size'],
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
		
		redirect('admin/store/product/edit/'.$id);
	}
	
	function switchstatus() {
		$id = $_POST['id'];
		$product = $this->Product_model->identify($id);
		$out = '';
		if ($product['status'] == 0) {
			$this->Product_model->update($id,array('status' => 1));
			$out = '<a href="javascript:switchstatus('.$id.')" title="De-active this product"><img src="'.base_url().'img/backend/icon-actived.png" /></a>';
		} else if($product['status'] == 1) {
			$this->Product_model->update($id,array('status' => 0));
			$out = '<a href="javascript:switchstatus('.$id.')" title="Active this product"><img src="'.base_url().'img/backend/icon-inactived.png" /></a>';
		}
		print $out;
	} // Ajax function
	function deleteproduct($id="") {
		$this->Product_model->remove_related($id);
		$this->Product_model->remove_attributes($id);
		$this->Product_model->remove_categories($id);
		$this->Product_model->remove_features($id);
		$this->Product_model->delete($id);
		$this->delete_directory('./uploads/products/'.md5('mbb'.$id));
		redirect('admin/store/product');
	}
	
	function delete_directory($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
			 	else
					$this->delete_directory($dirname.'/'.$file);    
		  	}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}
	
	function productgallery($product_id="") {
		$data['product'] = $this->Product_model->identify($product_id);
		$data['hero'] = $this->Product_model->get_hero($product_id);
		$data['photos'] = $this->Product_model->get_photos($product_id);
		$this->load->view('admin/product/gallery',$data);
	}
	function uploadimage() {
		$product_id = $_POST['product_id'];
		$directory = md5('mbb'.$product_id);
		$config['upload_path'] = "./uploads/products/".$directory;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4096'; // 4 MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) {
			$this->session->set_flashdata('error_upload',$this->upload->display_errors());
			redirect('admin/store/productgallery/'.$product_id);		
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];
			$width = $data['upload_data']['image_width'];
			$height = $data['upload_data']['image_height'];
			# Add details to database			
			$photo = array(
				'product_id' => $product_id,
				'name' => $name,
				'created' => date('Y-m-d H:i:s')
			);
			$photo_id = $this->Product_model->add_photo($photo);
			$this->Product_model->update_photo($photo_id,array('order' => $photo_id));					
			# Create thumbnails
			//$this->resizephoto($name,"./uploads/products/".$directory,"thumb1",324,382);
			//$this->resizephoto($name,"./uploads/products/".$directory,"thumb2",113,133);
			//$this->resizephoto($name,"./uploads/products/".$directory,"thumb3",77,91);
			//$this->resizephoto($name,"./uploads/products/".$directory,"thumb4",54,64);
			$this->advanced_resizephoto($data,"./uploads/products/".$directory,"thumb1",$width,$height,472,515);
			$this->advanced_resizephoto($data,"./uploads/products/".$directory,"thumb2",$width,$height,223,221);
			$this->advanced_resizephoto($data,"./uploads/products/".$directory,"thumb3",$width,$height,101,105);
			$this->advanced_resizephoto($data,"./uploads/products/".$directory,"thumb4",$width,$height,88,81);
			$this->advanced_resizephoto($data,"./uploads/products/".$directory,"thumb5",$width,$height,110,120);
			
		}
		redirect('admin/store/productgallery/'.$product_id);
	}
	function resizephoto($name,$directory,$sub,$width,$height) {
		$config = array();
		$config['source_image'] = $directory."/".$name;
		$config['create_thumb'] = FALSE;
		$config['new_image'] = $directory."/".$sub."/".$name;
		$config['maintain_ratio'] = TRUE;
		$config['quality'] = 100;
		$config['width'] = $width;
		$config['height'] = $height;
		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		$this->image_lib->resize();		
		$this->image_lib->clear();	
	}
	function advanced_resizephoto($data,$directory,$sub,$width,$height,$resize_width,$resize_height) 
	{
		$name = $data['upload_data']['file_name'];
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
				$config['width'] = 800;
				$config['height'] = 600;
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

	function makeheroimage($photo_id) {
		$photo = $this->Product_model->get_photo($photo_id);
		$this->Product_model->hero_photo($photo['product_id'],$photo_id);
		redirect('admin/store/productgallery/'.$photo['product_id']);
	}
	function movephoto($photo_id,$step) {
		$photo = $this->Product_model->get_photo($photo_id);
		if($step == 1) {
			$next = $this->Product_model->get_next_photo($photo['product_id'],$photo['order']);
			$this->swap_photo($photo,$next);
		} else if ($step == -1) {
			$prev = $this->Product_model->get_prev_photo($photo['product_id'],$photo['order']);
			$this->swap_photo($photo,$prev);
		}
		redirect('admin/store/productgallery/'.$photo['product_id']);		
	}
	function swap_photo($one,$two) {
		$this->Product_model->update_photo($one['id'],array('order' => $two['order']));
		$this->Product_model->update_photo($two['id'],array('order' => $one['order']));
	}
	function deletephoto($photo_id) {
		$photo = $this->Product_model->get_photo($photo_id);
		unlink('./uploads/products/'.md5('mbb'.$photo['product_id']).'/'.$photo['name']);
		unlink('./uploads/products/'.md5('mbb'.$photo['product_id']).'/thumb1/'.$photo['name']);
		unlink('./uploads/products/'.md5('mbb'.$photo['product_id']).'/thumb2/'.$photo['name']);
		unlink('./uploads/products/'.md5('mbb'.$photo['product_id']).'/thumb3/'.$photo['name']);
		unlink('./uploads/products/'.md5('mbb'.$photo['product_id']).'/thumb4/'.$photo['name']);
		$this->Product_model->delete_photo($photo_id);
		redirect('admin/store/productgallery/'.$photo['product_id']);
	}
	
	function productcategories($product_id="") {
		$data['main'] = $this->Category_model->get_main();
		$data['categories'] = $this->Product_model->get_categories($product_id);
		$data['product'] = $this->Product_model->identify($product_id);
		$this->load->view('admin/product/categories',$data);
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
		redirect('admin/store/productcategories/'.$product_id);
	}
	function getsale() {
		$product_id = $_POST['product_id'];
		$product = $this->Product_model->identify($product_id);
		$sale = $product['sale_price'];
		if ($product['sale_price'] == $product['price']) { $sale = ""; }
		$out = '
		<h3>Update Sale Price</h3>
		<form method="post" action="'.base_url().'admin/store/updatesale">
		<input type="hidden" name="product_id" value="'.$product['id'].'" />
		<input type="hidden" name="current_url" value="'.$_POST['current_url'].'" />
		<dl class="three"><dt>Price</dt><dd><input type="text" class="textfield rounded" name="price" value="'.$product['price'].'" /></dd></dl>
		<dl class="three"><dt>Sale price</dt><dd><input type="text" class="textfield rounded" name="sale_price" value="'.$sale.'" /></dd></dl>
		<dl class="three"><dt>&nbsp;</dt><dd><input type="submit" class="button rounded" value="Update" /></dd></dl>
		<dl></dl>
		</form>';
		print $out;
	}
	function updatesale() {
		$product_id = $_POST['product_id'];
		$price = $_POST['price'];
		$sale_price = $_POST['sale_price'];
		if($sale_price == "") { $sale_price = $price; }
		$data = array(			
			'price' => $price,
			'sale_price' => $sale_price,
			'modified' => date('Y-m-d H:i:s')
		);
		$this->Product_model->update($product_id,$data);
		redirect($_POST['current_url']);
	}
	
	function productcrosssale($product_id="") {
		$data['main'] = $this->Category_model->get_main();		
		$data['product'] = $this->Product_model->identify($product_id);
		$data['thumb'] = $this->Product_model->thumb_photo($product_id);
		$data['crosssales'] = $this->Product_model->get_crosssales($product_id);
		$this->load->view('admin/product/crosssale',$data);
	}
	function searchcrosssale() {
		$product_id = $_POST['product_id'];
		$keyword = $_POST['keyword'];
		$category = $_POST['category'];
		$products = $this->Product_model->search($keyword,$category,true);		
		$out = '
	<div style="clear: both; border-top: 1px solid #ccc;"></div>
    <div class="box bgw">
    <form name="addCrosssale" method="post" action="'.base_url().'admin/store/addcrosssale" style="margin:0">
    <input type="hidden" name="product_id" value="'.$product_id.'" />
        <h1>Products List</h1>
        <table class="table table-hover">
        	<tr style="font-size:15px">
        		<th style="width: 80%">Product Name</th>
        		<th style="width: 20%; text-align:center">Add</th>
        	</tr>
        ';
		
		foreach($products as $related) { 
			if (!$this->Product_model->is_crosssale($product_id,$related['id']) && $product_id != $related['id']) {
			$out .= '
			<tr>
				<td>'.$related['title'].'</td>
				<td style="text-align:center"><input type="checkbox" value="'.$related['id'].'" name="products[]" /></td>
			</tr>
			';
            	} 
			}
		$out .= '
        </table>
    </div>
    <div style="clear: both; border-top: 1px solid #ccc; height:15px;"></div>
    <div class="box">
    	<p align="right">
    		<button class="btn btn-inverse" type="button" onclick="document.addCrosssale.submit()">Add products</button>
    		
    	</p>        
    </div>
    </form>';
		print $out;
	} // Ajax function
	function addcrosssale() {
		$product_id = $_POST['product_id'];
		$n = $this->Product_model->count_crosssales($product_id);
		if (isset($_POST['products'])) {
			$products = $_POST['products'];
			if ($n + count($products) > 3) {
				$this->session->set_flashdata('addcs_true',true);
			} else
				foreach($products as $related) {
					$data = array(
						'product_id' => $product_id,
						'related' => $related
					);
					$id = $this->Product_model->add_crosssale($data);
					$this->Product_model->update_crosssale($id,array('order' => $id));
				}
		}
		redirect('admin/store/productcrosssale/'.$product_id);
	}
	function removecrosssale($id) {
		$crosssale = $this->Product_model->get_crosssale($id);
		$this->Product_model->remove_crosssale($id);
		redirect('admin/store/productcrosssale/'.$crosssale['product_id']);
	}
	function movecrosssale($id,$step) {
		$crosssale = $this->Product_model->get_crosssale($id);
		if($step == 1) {
			$next = $this->Product_model->get_next_crosssale($crosssale['product_id'],$crosssale['order']);
			$this->swap_crosssale($crosssale,$next);
		} else if ($step == -1) {
			$prev = $this->Product_model->get_prev_crosssale($crosssale['product_id'],$crosssale['order']);
			$this->swap_crosssale($crosssale,$prev);
		}
		redirect('admin/store/productcrosssale/'.$crosssale['product_id']);		
	}
	function swap_crosssale($one,$two) {
		$this->Product_model->update_crosssale($one['id'],array('order' => $two['order']));
		$this->Product_model->update_crosssale($two['id'],array('order' => $one['order']));
	}
	
	

	function exportstock() {
		$csvdir = getcwd();		
		$csvname = 'CaseConstruction_Stock_'.date('d-m-Y');
		$csvname = $csvname.'.csv';		
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');	
		$stocks=$this->Product_model->all();
		$headings = array('Product ID','Product Title','Price','Size','Stock','XXXS','XXS','XS','S','M','L','XL','XXL','3XL','4XL','5XL','6XL','6','8','10','12','14','16','18','20','22');
		fputcsv($fp,$headings);
		foreach($stocks as $stock) {		
			if($stock['multiplesize']==1){
				$multiple_stock = json_decode($stock['size'],true);
				if($multiple_stock['XXXS'] >=0 && $multiple_stock['XXXS']!='' ){$XXXS=$multiple_stock['XXXS'];}else{$XXXS='-';}
				if($multiple_stock['XXS'] >=0 && $multiple_stock['XXS']!='' ){$XXS=$multiple_stock['XXS'];}else{$XXS='-';}
				if($multiple_stock['XS'] >=0 && $multiple_stock['XS']!=''  ){$XS=$multiple_stock['XS'];}else{$XS='-';}
				if($multiple_stock['S'] >=0 && $multiple_stock['S']!=''){$S=$multiple_stock['S'];}else{$S='-';}
				if($multiple_stock['M'] >=0 && $multiple_stock['M']!=''){$M=$multiple_stock['M'];}else{$M='-';}
				if($multiple_stock['L'] >=0 && $multiple_stock['L']!=''){$L=$multiple_stock['L'];}else{$L='-';}
				if($multiple_stock['XL'] >=0 && $multiple_stock['XL']!=''){$XL=$multiple_stock['XL'];}else{$XL='-';}
				if($multiple_stock['XXL'] >=0 && $multiple_stock['XXL']!=''){$XXL=$multiple_stock['XXL'];}else{$XXL='-';}
				if($multiple_stock['3XL'] >=0 && $multiple_stock['3XL']!=''){$XL3=$multiple_stock['3XL'];}else{$XL3='-';}
				if($multiple_stock['4XL'] >=0 && $multiple_stock['4XL']!=''){$XL4=$multiple_stock['4XL'];}else{$XL4='-';}
				if($multiple_stock['5XL'] >=0 && $multiple_stock['5XL']!=''){$XL5=$multiple_stock['5XL'];}else{$XL5='-';}
				if($multiple_stock['6XL'] >=0 && $multiple_stock['6XL']!=''){$XL6=$multiple_stock['6XL'];}else{$XL6='-';}
				if($multiple_stock['6'] >=0 && $multiple_stock['6']!=''){$S6=$multiple_stock['6'];}else{$S6='-';}
				if($multiple_stock['8'] >=0 && $multiple_stock['8']!=''){$S8=$multiple_stock['8'];}else{$S8='-';}
				if($multiple_stock['10'] >=0 && $multiple_stock['10']!=''){$S10=$multiple_stock['10'];}else{$S10='-';}
				if($multiple_stock['12'] >=0 && $multiple_stock['12']!=''){$S12=$multiple_stock['12'];}else{$S12='-';}
				if($multiple_stock['14'] >=0 && $multiple_stock['14']!=''){$S14=$multiple_stock['14'];}else{$S14='-';}
				if($multiple_stock['16'] >=0 && $multiple_stock['16']!=''){$S16=$multiple_stock['16'];}else{$S16='-';}
				if($multiple_stock['18'] >=0 && $multiple_stock['18']!=''){$S18=$multiple_stock['18'];}else{$S18='-';}
				if($multiple_stock['20'] >=0 && $multiple_stock['20']!=''){$S20=$multiple_stock['20'];}else{$S20='-';}
				if($multiple_stock['22'] >=0 && $multiple_stock['22']!=''){$S22=$multiple_stock['22'];}else{$S22='-';}
				
				
				fputcsv($fp,array($stock['id'],$stock['title'],$stock['price'],'Multiple Size','-',$XXXS,$XXS,$XS,$S,$M,$L,$XL,$XXL,$XL3,$XL4,$XL5,$XL6,$S6,$S8,$S10,$S12,$S14,$S16,$S18,$S20,$S22));								
			}
			else
			{
				fputcsv($fp,array($stock['id'],$stock['title'],$stock['price'],'Single Size',$stock['stock'],'-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'));								
			}
		}
        fclose($fp);		
	}


	# Manage Customer
	function customer($action="",$value="") 
	{
		
		if ($action == "search") {
			$this->session->set_userdata('name',$_POST['name']);
			$this->session->set_userdata('type',$_POST['type']);
			redirect('admin/store/customer');
		}
		$this->load->view('admin/common/header');
		if ($action == "edit") {
			$user = $this->User_model->id($value);
			$data['customer'] = $this->Customer_model->identify($user['customer_id']);
			$data['user'] = $user;
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			$this->load->view('admin/customer/edit',$data);
		} else {
			$type = 4;
					
			if ($this->session->userdata('type')) 
			{ 
				$type = $this->session->userdata('type'); 				
			}
			
			$name='';
			if ($this->session->userdata('name')){
				$name=$this->session->userdata('name');	
			}
			$data['users']=array();
			if($type == 5)
			{
				$this->load->model('Subscribe_model');
			  $data['subscribers'] = $this->Subscribe_model->all();
			}
			else
			{
				$data['subscribers'] ='';
				if(isset($name)&&!empty($name))
			  {
				$data['users'] = $this->User_model->recognize_v2($name,$type);				
			  }
			  else
			  {
				$data['users'] = $this->User_model->get($type);	
			  }
			}
			
			$this->load->view('admin/customer/list',$data);
						
		}
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}
	function updatecustomer() {
		if (!isset($_POST['id'])) { redirect('admin/store/customer'); }
		$id = $_POST['id'];
		$user = $this->User_model->id($id);
		$data = array(
			'firstname' => $_POST['firstname'],
			'lastname' => $_POST['lastname'],
			'address' => $_POST['address'],
			'city' => $_POST['city'],
			'state' => $_POST['state'],
			'country' => $_POST['country'],
			'postcode' => $_POST['postcode'],
			'phone' => $_POST['phone'],
			'email' => $_POST['email'],
			'modified' => date('Y-m-d H:i:s')
		);
		if ($_POST['password'] != "") {
			$this->User_model->update($id,array('password' => md5($_POST['password'])));
		}
		if ($this->Customer_model->update($user['customer_id'],$data)) {
			$this->session->set_flashdata('update',true);
		}
		redirect('admin/store/customer/edit/'.$id);
	}
	function updatetrader() {
		if (!isset($_POST['id'])) { redirect('admin/store/customer'); }
		$id = $_POST['id'];
		$user = $this->User_model->id($id);
		
		$email = $this->input->post('email',true);
		$username = $email;
		$storename = $this->input->post('storename',true);
		$tradename = $this->input->post('tradename',true);
		$firstname = $this->input->post('firstname',true);
		$lastname = $this->input->post('lastname',true);
		
		
		$phone= $_POST['phone'];
		$mobile = $_POST['mobile'];
		$address = $_POST['address'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		
		$postcode = $_POST['postcode'];
		
		$data = array(
			'email' => $email,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'storename' => $storename,
			'tradename' => $tradename,
			'phone' => $phone,
			'address' => $address,
			'address2' => $address2,
			'city' => $city,
			'state' => $state,
			'postcode' => $postcode,
			'phone' => $phone,
			'mobile' => $mobile,
			'modified' => date('Y-m-d H:i:s')
		);
		
		if ($_POST['password'] != "") {
			$this->User_model->update($id,array('password' => md5($_POST['password'])));
		}
		if ($this->Customer_model->update($user['customer_id'],$data)) {
			$this->session->set_flashdata('update',true);
		}
		redirect('admin/store/customer/edit/'.$id);
	}
	
	function approvetrader() {
		$id = $_POST['id'];
		$this->User_model->update($id,array('activated' => 1));
		
		if ($_POST['send'] == '1') {
			$user = $this->User_model->id($id);
			$customer = $this->Customer_model->identify($user['customer_id']);
			$subject = 'Customer Application Approval @ Case Construction Online Merchandise Store';
			$message = sprintf("
<p>Thank you %s</p>
<p>Your application to become a customer of Case Construction Online Merchandise Store has been successful. You are now able to login to the Case Construction Online Merchandise Store using the following details:</p>
<p>
Username: %s<br />
Password: this will be the password you selected when you signed up via the registration form.<br/><br>
(If you have forgotten your password please click 'forgot password' in the trade section of our website)
</p>

<p>Should you have any queries please don't hesitate to <a href='http://www.odessa.net.au/case-construction/contact'>contact us</a>.</p>


<p>Warm Regards,</p>


Case Construction Online Merchandise Store

			",$customer['firstname'],$user['username']);
			/*
			//load email content
			$data['content'] = $message;
			$message = $this->load->view('email_template',$data, TRUE);
			*/
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from('noreply@onlinemerchandise.com.au','Case Construction Online Merchandise Store');		
			$this->email->to($customer['email']);
			$this->email->bcc('rseptiane@gmail.com');
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
		}
	}
		
	function pendingtrader() {
		$id = $_POST['id'];
		$this->User_model->update($id,array('activated' => 0));
	}
	function deletecustomer($id='') 
	{
		$user = $this->User_model->id($id);
		$customer = $this->Customer_model->identify($user['customer_id']);
		$subject = 'Customer Application Decline @ Case Construction Online Merchandise Store';
		$message = sprintf("
<p>Thank you %s</p>
<p>Unfortunately, at this moment we are unable to activate you as a Customer.</p>
<p>
Sorry for any inconvenience this might cause you.  If you would like to discuss the matter please feel free to contact us
</p>

<p>Warm Regards,</p>


Case Construction Online Merchandise Store

		",$customer['firstname']);
		
		//load email content
		//$data['content'] = $message;
		//$message = $this->load->view('email_template',$data, TRUE);
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from('noreply@onlinemerchandise.com.au','Case Construction Online Merchandise Store');		
		$this->email->to($customer['email']);
		
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
			
		$user = $this->User_model->id($id);
		$this->User_model->delete($id);
		$this->Customer_model->delete($user['customer_id']);
		$this->Order_model->delete($user['customer_id']);
		
		redirect('admin/store/customer');
	}
	function deletesubscribe($id) {
		$this->load->model('Subscribe_model');
		$this->Subscribe_model->delete($id);
		redirect('admin/store/customer');
	}

	function exportcustomer() {
		$csvdir = getcwd();
		//$csvdir = $csvdir.'/csv/';
		$csvname = 'customer_'.date('d-m-Y');
		$csvname = $csvname.'.csv';
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');
		
		$type = 4;
		if ($this->session->userdata('type')) 
		{ 
		$type = $this->session->userdata('type'); 
		}
		$users = $this->User_model->get($type);
		
		if($type==4)
		{
			$headings = array('Username','First Name','Last Name','Email','Store Name','Trading Name','Address 1','Address 2','Suburb','State','Postcode','Phone Number','Mobile','Joined','Last Updated');
		fputcsv($fp,$headings);
			foreach ($users as $user) 
			{
				$customer = $this->Customer_model->identify($user['customer_id']);
				fputcsv($fp,array($user['username'],$customer['firstname'],$customer['lastname'],$customer['email'],$customer['storename'],$customer['tradename'],$customer['address'],$customer['address2'],$customer['suburb'],$customer['state'],$customer['postcode'],$customer['phone'],$customer['mobile'],$customer['joined'],$customer['modified']));
			}
		}
		else
		{
			$this->load->model('Subscribe_model');
			$subscribers = $this->Subscribe_model->all();
			$headings = array('First Name','Last Name','Mobile','Email','Date time');
			fputcsv($fp,$headings);
			foreach ($subscribers as $s) 
			{
				
				fputcsv($fp,array($s['firstname'],$s['lastname'],$s['mobile'],$s['email'],$s['date']));
			}
		}
		
        fclose($fp);
		//redirect(base_url().'csv/'.$csvname);
	}
	
	function order($action="",$period="") {
		$this->load->view('admin/common/header');
		
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
				$orders = $this->Order_model->search_v2($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4,$this->session->userdata('by_payment'));
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
			$this->load->view('admin/order/view',$data);
		} else {
			$data['orders'] = $this->Order_model->last(20);
			$this->load->view('admin/order/list',$data);
		}
		
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}
	function searchorder() {
		$this->session->set_userdata('customer_name',$_POST['customer_name']);
		$this->session->set_userdata('order_id',$_POST['order_id']);
		$this->session->set_userdata('from_date',$_POST['from_date']);
		$this->session->set_userdata('to_date',$_POST['to_date']);
		$this->session->set_userdata('by_keyword',$_POST['by_keyword']);
		$this->session->set_userdata('by_payment',$_POST['by_payment']);
		//$this->session->set_userdata('by_typecustomer',$_POST['typecustomer']);
		$status=0;
		if(isset($_POST['by_status'])&&$_POST['by_status']==1){
			$status=1;
		}
		$this->session->set_userdata('by_status',$status);
		redirect('admin/store/order/search');
	}
	function deleteorder($order_id) {
		$this->Order_model->delete($order_id);
		redirect('admin/store/order');
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
				$orders = $this->Order_model->search($this->session->userdata('customer_name'),$this->session->userdata('order_id'),$this->session->userdata('from_date'),$this->session->userdata('to_date'),$this->session->userdata('by_keyword'),$this->session->userdata('by_status'),4);
			
			}			
			
			//$headings = array('Order ID','Customer Name','Order Date','Status','Tax','Shipping Cost','Total','Product Name');
			//if($this->session->userdata('by_typecustomer')==4){
			$headings = array('Order ID','Store Name','Trade Name','Order Date','Status','Tax','Shipping Cost','Total','Product Name');
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
					fputcsv($fp,array($order['id'],$customer['storename'],$customer['tradename'],$order['order_time'],$order['status'],$order['tax'],$order['shipping_cost'],$order['total'],$productname));
				
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
	
	
	#Feature Product
	function feature() {
		$data['main'] = $this->Category_model->get_main();
		$data['features'] = $this->Product_model->get_features();
		$this->load->view('admin/common/header');
		$this->load->view('admin/product/feature',$data);
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}
	function searchfeature() {
		$keyword = $_POST['keyword'];
		$category = $_POST['category'];
		$products = $this->Product_model->search($keyword,$category,true);		
		$out = '
    <div class="box">
    <form name="featureForm" method="post" action="'.base_url().'admin/store/addfeature">
        <h3>Products List</h3>
        <div class="row-title">
            <div class="cat-name">Product name</div>
            <div class="cat-func">Add</div>
        </div>
        <div id="subcat">';
		
		foreach($products as $product) { 
			if (!$this->Product_model->is_feature($product['id'])) {
			$out .= '
			<div class="row-item">
                <div class="cat-name">'.$product['title'].'</div>
                <div class="cat-func">&nbsp; <input type="checkbox" value="'.$product['id'].'" name="products[]" /> &nbsp;</div>
            </div>';
            	} 
			}
		$out .= '
        </div><br />
    	<p align="right"><input type="button" class="button rounded" value="Add products" onClick="document.featureForm.submit()" /></p>        
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
		redirect('admin/store/feature');
	}
	function removefeature($product_id="") {
		$this->Product_model->remove_feature($product_id);
		redirect('admin/store/feature');
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
	
}
?>