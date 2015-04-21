<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends Controller {
	
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Menu_model'); 
        $this->load->model('Gallery_model');      
        $this->load->model('User_model'); 
		$this->load->model('Cute_model');
		$this->load->model('Cute_model2');    
		//$this->load->model('System_model');    
		$this->load->model('Content_model');      		
	}
	
	#Dashboard
	function index()
	{
		$this->check_authentication();
		$this->load->view('admin/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/navigation');
		$this->load->view('admin/footer');
	}
	
	
	# Page Management
	function page($action="",$page_id="") {
		if ($action == "") {
			//$data['locations'] = $this->Content_model->get_locations();
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/cms/page');
			$this->load->view('admin/common/rightbar');
			$this->load->view('admin/common/footer');
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

	function getcats() {
		//$location_id = $_POST['location_id'];
		$categories = $this->Content_model->get_categories();
		$category_id = $this->session->userdata('category_id');
		$out = '
			<select id="category_id" onChange="getpages()">';
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
		$out .= '</select>&nbsp; <a href="javascript:deletecat('.$category['id'].')">Delete this category</a>';
		print $out;
	}

	function getcats2() {
		//$location_id = $_POST['location_id'];
		$category_id = $_POST['category_id'];
		$categories = $this->Content_model->get_categories();
		$out = '
		<select name="parent_id">
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
			$pages = $this->Content_model->search($category_id);
			$out = '
				<dl><dd><a href="javascript:addpage()">Add new page</a></dd></dl>
				<h3>Page List</h3><dl></dl>
				<div class="row-title">
					<div class="menu-name">Page title</div>
					<div class="menu-func">Delete</div>
					<div class="menu-func">Content</div>
					<div class="menu-func">Gallery</div>
					<div class="menu-func">Copy</div>
				</div>';
			foreach($pages as $page) {
				$out .= '
				<div class="row-item" id="page-'.$page['id'].'">
					<div class="menu-name" id="pagename-'.$page['id'].'"><a href="javascript:editpage('.$page['id'].',\''.$page['title'].'\')">'.$page['title'].'</a></div>
					<div class="menu-func"><a href="javascript:deletepage('.$page['id'].')"><img src="'.base_url().'img/admin/icon-delete.png" /></a></div>
					<div class="menu-func"><a href="'.base_url().'admin/cms/editpage/'.$page['id'].'"><img src="'.base_url().'img/admin/editcontent.png" /></a></div>
					<div class="menu-func"><a href="javascript:gallery('.$page['id'].')"><img src="'.base_url().'img/admin/gallery.png" /></a></div>					
					<div class="menu-func"><a href="javascript:copy('.$page['id'].')"><img src="'.base_url().'img/admin/icon-dup.png" /></a></div>
				</div>';
			}
		}
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
		redirect('admin/cms/page');
	}
	function deletecategory() {
		$category_id = $_POST['category_id'];
		$this->Content_model->clear($category_id);
		$this->Content_model->delete_category($category_id);		
	}
	function addpage() {
		$category_id = $_POST['category_id'];
		$category = $this->Content_model->get_category($category_id);
		//$this->session->set_userdata('location_id',$category['location_id']);
		$this->session->set_userdata('category_id',$category_id);
		$out = '
		<form name="addPageForm" method="post" action="'.base_url().'admin/cms/addingpage">
		<input type="hidden" name="category_id" value="'.$category_id.'" />
		<div class="row-item">
			<div class="page-name"><input type="text" class="textfield rounded" name="title" id="title" /></div>
			<div class="page-button">
				<input type="button" class="button rounded" value="Add" onClick="addingpage()" />
				<input type="button" class="button rounded" value="Cancel" onClick="cancel()" />
			</div>
		</div>
		</form>';
		print $out;
	}
	
	function addingpage() {
		$title = $_POST['title'];
		$data = array(
			'category_id' => $_POST['category_id'],
			'title' => $title,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s')
		);
		$this->session->set_userdata('category_id',$_POST['category_id']);
		$page_id = $this->Content_model->add($data);
		redirect('admin/cms/page');
	}

	function editpage($id='')
    {
        $data['pages'] = $this->Menu_model->getpage($id);
        $data['categories'] =$this->Menu_model->get_all_parents();
		$data['menus'] =$this->Menu_model->get_menus();
        $this->load->view('admin/common/header');
        $this->load->view('admin/page/content/edit',$data);
        $this->load->view('admin/common/rightbar');
        $this->load->view('admin/common/footer'); 
        
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
            redirect('admin/cms/editpage/'.$id);
        }       
        
    }

	function updatepagetitle() {
		if ($this->Content_model->update($_POST['id'],array('title' => $_POST['title']))) {
			print "OK";
		}
	}
	
	function copypage() {
		$page = $this->Content_model->id($_POST['page_id']);
		if ($page) {
			$newpage = array(
				'category_id' => $_POST['category_id'],
				'title' => $_POST['title'],			
				'content' => $page['content'],
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			);
			$newpage_id = $this->Content_model->add($newpage);
		}
	}
	
	function deletepage()
    {
        
		$id=$this->input->post('page_id');
		if($this->Menu_model->deletepage($id))
        {            
            redirect('admin/cms/listpage');
        }
    }
	
	function galleries($id=null,$pid=null) 
	{
		# Check authentication and load models
		//$this->check_authentication();
		
		# load normal header view
		$this->load->view('admin/new_common/header');
		
		# if not a particular gallery
		if ($id == null) {
			# Get all galleries
			$galleries = $this->Gallery_model->get_galleries();
			# Determine the thumbnail
			$thumbnails = array();
			foreach($galleries as $gallery) {
				$photos = $this->Gallery_model->get_photos($gallery['id']);
				if (count($photos) == 0) {
					$thumbnails[$gallery['id']] = '<a href="'.base_url().'admin/cms/galleries/'.$gallery['id'].'"><img src="'.base_url().'img/thumbnail-no-image.jpg" title="'.$gallery['title'].'" /></a>';
				} else {
					$thumbnail = $this->Gallery_model->get_gallery_thumbnail($gallery['id']);
					$thumbnails[$gallery['id']] = '<a href="'.base_url().'admin/cms/galleries/'.$gallery['id'].'"><img src="'.base_url().'uploads/galleries/'.md5("cdkgallery".$gallery['id']).'/thumbnails/'.$thumbnail.'" title="'.$gallery['title'].'" /></a>';
				}
			}
			
			# Pass data to the view
			$data['galleries'] = $galleries;
			$data['thumbnails'] = $thumbnails;			
			//$this->load->view('admin/cms/galleries',$data);
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
		
		$this->load->view('admin/new_common/rightbar');
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
		redirect('admin/cms/galleries');
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
		  
			$this->session->set_flashdata('addphoto_id',$pid);
			$this->session->set_flashdata('addphoto_src',$file_name);
		}
		redirect('admin/cms/galleries/'.$gid);
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
				unlink("/home/odessa/public_html/cart_v1/uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumb1/".$photo['name']);
				
			} else {
				
			}
		//}
		
		
		redirect('admin/cms/galleries/'.$photo['gallery_id']);
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
        redirect('admin/cms/galleries/'.$id);       
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
		redirect('admin/cms/galleries/'.$_POST['gallery_id']);
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
		
		redirect('admin/cms/galleries/'.$gid);
		
	}
	# Banner Management
	function banner() {
		//$data['main'] = $this->Content_model->get_main();
		$data['banners'] = $this->Content_model->get_banners();
		$this->load->view('admin/common/header');
		$this->load->view('admin/banner',$data);
		$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');
	}

	function deletebanner($id="") {
		$banner = $this->Content_model->get_banner($id);
		unlink('./uploads/banners/'.$banner['name']);
		unlink('./uploads/banners/thumb/'.$banner['name']);
		$this->Content_model->delete_banner($id);
		redirect('admin/cms/banner');
	}
	function updatebanner() {
		$this->Content_model->update_banner($_POST['banner_id'],array('url' => $_POST['url']));
		redirect('admin/cms/banner');
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
		redirect('admin/cms/banner');
	}
	
	function activebanner($id="") {
		$this->Content_model->active_banner($id);
		redirect('admin/cms/banner');
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

	function search_all_admin()
	{
		$keyword = $_POST['keyword'];
		echo $keyword;
	}
	
}
?>