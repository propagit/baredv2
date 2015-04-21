<?php
class Gallery extends Controller {
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		
        $this->load->model('Gallery_model');      
		
	}
	
	function galleries($id=null,$pid=null) 
	{
		# Check authentication and load models
		//$this->check_authentication();
		
		# load normal header view
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		
		# if not a particular gallery
		if ($id == null) {
			# Get all galleries
			$galleries = $this->Gallery_model->get_galleries();
//			print_r($galleries);
			# Determine the thumbnail
			$thumbnails = array();
			
			
			# Pass data to the view
			$data['galleries'] = $galleries;
			$data['thumbnails'] = $thumbnails;			
			
			//$this->load->view('admin/gallery/admin_gallery_list',$data);
			$this->load->view('admin/gallery/admin_gallery_list', isset($data) ? $data : NULL);	
		} 
		
		# Viewing a particular gallery
		else {
			# Get the gallery
			$data['gallery'] = $this->Gallery_model->get_gallery($id);
			if(!$data['gallery'])
			{
				redirect('admin/gallery/galleries/');
			}
			# Get all photos in the gallery
			$data['photos'] = $this->Gallery_model->get_photos($id);
			# If no photo yet
			if ($pid == null) {
				$this->load->view('admin/gallery/admin_gallery_detail',$data);
			} else {
				$data['photo'] = $this->Gallery_model->get_photo($pid);
				if($data['photo'])
				{
				$this->load->view('admin/gallery/photo',$data);
				}
				else
				{
					redirect('admin/gallery/galleries/'.$id);
				}
			}		
		}
		
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/common/footer');		
	}

	function create_gallery() 
	{
		
		if (trim($_POST['title']) == "") {
			$this->session->set_flashdata('error_cg',true);
			redirect('admin/gallery/galleries');
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
		
		$dir = $path."/".$newfolder;
		$dir .= "/thumb_gal";
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}	
		
		$dir = $path."/".$newfolder;
		$dir .= "/thumb_gal/thumb";
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}	
		redirect('admin/gallery/galleries/'.$gid);
	}
	
	function update_gallery() 
	{
		$id= $this->input->post('update_id');
		if (trim($_POST['title']) == "") {
			$this->session->set_flashdata('error_cg',true);
			redirect('admin/gallery/galleries');
		}
		$data = array(
			'title' => $_POST['title'],			
			'modified' => date('Y-m-d H:i:s')
		);
		
		$this->Gallery_model->update_gallery($id,$data);						
		redirect('admin/gallery/galleries/'.$id);
	}
	
	function delete_gallery($id) 
	{
		
		//$this->check_authentication();
		$photos = $this->Gallery_model->get_photos($id);
		foreach($photos as $photo) {
			if ($this->Gallery_model->delete_photo($photo['id'])) {
				unlink("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/".$photo['name']);
				unlink("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/thumbnails/".$photo['name']);	
				unlink("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/thumb1/".$photo['name']);				
			}
		}
		//print_r('test');
		unlink("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/index.html");
		unlink("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/thumbnails/index.html");
		unlink("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/thumb1/index.html");
		
		if ($this->Gallery_model->delete_gallery($id)) {
			rmdir("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/thumb1");
			rmdir("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id)."/thumbnails");
			rmdir("/home/baredcom/public_html/uploads/galleries/".md5("cdkgallery".$id));
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
			/*if($gid != 4)
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
			}*/
			
			
			
			// Thumbnail creation
			$config = array();
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/".$file_name;
			$config['create_thumb'] = TRUE;
			$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumbnails/".$file_name;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = 100;
			
			//$width_thumb = 262;
			//$height_thumb = 132;
			  if ($width < $height) 
			  {		
			    if(($height/$width) < (132/262))
				{
					$config['height'] = 262;
					$config['width'] = intval(262 * ($height/$width));
					$config['master_dim'] = 'height';
				}
				else
				{
					$config['width'] = 262;
					$config['height'] = intval(132 * ($height/$width));
					$config['master_dim'] = 'width';
				}
				
			  } 
			  else if($width > $height)
			  {		
			   
					
				if(($width/$height) < (262/132))
				{
					$config['width'] = 262;
					$config['height'] = intval(132 * ($width/$height));
					$config['master_dim'] = 'width';
				}
				else
				{
					$config['width'] = intval(262 * ($width/$height));
					
				$config['height'] = 132;
				$config['master_dim'] = 'height';
				}
				
				
			  }
			  else  // for square image
			  {		
			  
				$config['width'] = 262;
				$config['height'] = intval(262 * ($height/$width));
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
			
			$config['width'] = 262;
			$config['height'] = 132;
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
		redirect('admin/gallery/galleries/'.$gid);
	}

	function delete_photo($id) 
	{
		
		$photo = $this->Gallery_model->get_photo($id);
		
			if ($this->Gallery_model->delete_photo($id)) 
			{
				$this->Gallery_model->reset_thumbnail($id);
				unlink("./uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/".$photo['name']);
				unlink("./uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumbnails/".$photo['name']);
				unlink("./uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumbnails2/".$photo['name']);
				unlink("./uploads/galleries/".md5("cdkgallery".$photo['gallery_id'])."/thumb1/".$photo['name']);
				
			} else {
				
			}
		
		
		
		redirect('admin/gallery/galleries/'.$photo['gallery_id']);
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
        redirect('admin/gallery/galleries/'.$id);       
    }
    
    function add_photo_title()
	{				
		$id = $_POST['photo_id'];
		$data = array(
			'title' => $_POST['title'],			
			'modified' => date('Y-m-d H:i:s')
			);
		$this->Gallery_model->update_photo($id,$data);
		redirect('admin/gallery/galleries/'.$_POST['gallery_id']);
	}
	
	function add_video()
	{				
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
		
		redirect('admin/gallery/galleries/'.$gid);
		
	}
	function switchstatuspreview($id)
	{
		$gallery = $this->Gallery_model->get_gallery($id);
		$out = '';
		if ($gallery['active_preview'] == 0) {
			$this->Gallery_model->update_gallery($id,array('active_preview' => 1));			
		} else if($gallery['active_preview'] == 1) {
			$this->Gallery_model->update_gallery($id,array('active_preview' => 0));			
		}
		redirect('admin/gallery/galleries');
	}
	function switchstatuspage($id)
	{
		$gallery = $this->Gallery_model->get_gallery($id);
		$out = '';
		if ($gallery['active_page'] == 0) {
			$this->Gallery_model->update_gallery($id,array('active_page' => 1));			
		} else if($gallery['active_page'] == 1) {
			$this->Gallery_model->update_gallery($id,array('active_page' => 0));			
		}
		redirect('admin/gallery/galleries');
	}
	
	function add_thumbnail()
	{		
		/*$id=$this->input->post('id_gallery_thumb');
		$path = "./uploads/galleries/".md5("cdkgallery".$id);
		$newfolder = 'thumb_gal';
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
			redirect('admin/gallery/galleries/'.$id);	
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$name = $data['upload_data']['file_name'];	
			$thumb_name = 'thumb_'.$name;		
			# Add details to database			
			$data = array(
				'thumb_img' => $name,
				'thumbnail' => 1				
			);
			$this->Gallery_model->update_gallery($id,$data);	
			
			$config = array();
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/".$name;
			$config['create_thumb'] = TRUE;
			//$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb_".$name;
			$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb/thumb_".$name;
			$config['maintain_ratio'] = FALSE;
			$config['quality'] = 100;
			
			//$width_thumb = 262;
			//$height_thumb = 132;
			 if ($width < $height) 
			  {		
			    if(($height/$width) < (132/262))
				{
					$config['height'] = 262;
					$config['width'] = intval(262 * ($height/$width));
					$config['master_dim'] = 'height';
				}
				else
				{
					$config['width'] = 262;
					$config['height'] = intval(132 * ($height/$width));
					$config['master_dim'] = 'width';
				}
				
			  } 
			  else if($width > $height)
			  {		
			   
					
				if(($width/$height) < (262/132))
				{
					$config['width'] = 262;
					$config['height'] = intval(132 * ($width/$height));
					$config['master_dim'] = 'width';
				}
				else
				{
					$config['width'] = intval(262 * ($width/$height));
					
				$config['height'] = 132;
				$config['master_dim'] = 'height';
				}
				
				
			  }
			  else  // for square image
			  {		
			  
				$config['width'] = 262;
				$config['height'] = intval(262 * ($height/$width));
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
			
			rename("./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb/thumb_".$data['upload_data']['raw_name'].$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb/thumb_".$name);
			$this->image_lib->clear();
			
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb_".$name;
			
			$config['width'] = 262;
			$config['height'] = 132;
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
			unlink("./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb/thumb_".$name);
			rename("./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb/thumb_".$data['upload_data']['raw_name'].$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$id)."/thumb_gal/thumb/thumb_".$name);
			
			$new = "_thumb";
			$length = strlen($name);
			$pos = substr($name,$length-4,$length);
			$string = str_replace($pos, $new.$pos ,$name);
			$data_thumb = array(
				'thumb_img' => 'thumb_'.$string,
				'thumbnail' => 1				
			);
			$this->Gallery_model->update_gallery($id,$data_thumb);	
			
			*/
			
		$gid=$this->input->post('id_gallery_thumb');
		
		$path = "./uploads/galleries";
		$newfolder = md5('cdkgallery'.$gid);
		$dir = $path."/".$newfolder;
		$dir .= "/thumb_gal/thumb";
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}	
		
		$config['upload_path'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal";
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
			/*$photo = array(
				'name' => $file_name,
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s'),
				'gallery_id' => $gid,
				'order' => 0
			);
			$pid = $this->Gallery_model->add_photo($photo);
			$this->Gallery_model->update_photo($pid,array('order'=>$pid));*/
			$photo = array(
				'thumb_img' => $file_name,
				'thumbnail' => 1				
			);
			$this->Gallery_model->update_gallery($gid,$photo);
			
			
			
			// Thumbnail creation
			$config = array();
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/".$file_name;
			$config['create_thumb'] = TRUE;
			$config['new_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$file_name;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = 100;
			
			//$width_thumb = 262;
			//$height_thumb = 132;
			  if ($width < $height) 
			  {		
			    if(($height/$width) < (132/262))
				{
					$config['height'] = 262;
					$config['width'] = intval(262 * ($height/$width));
					$config['master_dim'] = 'height';
				}
				else
				{
					$config['width'] = 262;
					$config['height'] = intval(132 * ($height/$width));
					$config['master_dim'] = 'width';
				}
				
			  } 
			  else if($width > $height)
			  {		
			   
					
				if(($width/$height) < (262/132))
				{
					$config['width'] = 262;
					$config['height'] = intval(132 * ($width/$height));
					$config['master_dim'] = 'width';
				}
				else
				{
					$config['width'] = intval(262 * ($width/$height));
					
				$config['height'] = 132;
				$config['master_dim'] = 'height';
				}
				
				
			  }
			  else  // for square image
			  {		
			  
				$config['width'] = 262;
				$config['height'] = intval(262 * ($height/$width));
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
			
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$file_name);
			$this->image_lib->clear();
			
			// Crop thumbnail			
			$config['image_library'] = 'GD2';
			$config['source_image'] = "./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$file_name;
			
			$config['width'] = 262;
			$config['height'] = 132;
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
			unlink("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$file_name);
			rename("./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$data['upload_data']['raw_name']."_thumb".$data['upload_data']['file_ext'],"./uploads/galleries/".md5('cdkgallery'.$gid)."/thumb_gal/thumb/".$file_name);
			
			
			
			// Thumbnail frontend creation
			
			
			// Thumbnail2 for bootstrap
			
		
			
			
			
			
		
			/*
			$filename = "./uploads/galleries/".md5("cdkgallery".$id)."/thumb_gal/".$name;
			
			// Set a maximum height and width
			$width = 262;
			$height = 132;
			
			// Content type
			header('Content-Type: image/jpeg');
			
			// Get new dimensions
			list($width_orig, $height_orig) = getimagesize($filename);
			
			$ratio_orig = $width_orig/$height_orig;
			
			
			if ($width/$height > $ratio_orig) {
			   $width = $height*$ratio_orig;
			} else {
			   $height = $width/$ratio_orig;
			}
			
			// Resample
			$image_p = imagecreatetruecolor($width, $height);
			$image = imagecreatefromjpeg($filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			
			// Output
			imagejpeg($image_p, "./uploads/galleries/".md5("cdkgallery".$id)."/thumb_gal/thumb".$name, 100);*/
/*			$updir = "./uploads/galleries/".md5("cdkgallery".$id)."/thumb_gal/";
			
			$thumbnail_width = 262;
			$thumbnail_height = 132;
			$thumb_beforeword = "thumb";
			$arr_image_details = getimagesize("$filename"); // pass id to thumb name
			$original_width = $arr_image_details[0];
			$original_height = $arr_image_details[1];
			if ($original_width > $original_height) {
				$new_width = $thumbnail_width;
				$new_height = intval($original_height * $new_width / $original_width);
			} else {
				$new_height = $thumbnail_height;
				$new_width = intval($original_width * $new_height / $original_height);
			}
			$dest_x = intval(($thumbnail_width - $new_width) / 2);
			$dest_y = intval(($thumbnail_height - $new_height) / 2);
			
			$old_image = imagecreatefromjpeg("$filename");
			$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
			imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
			imagejpeg($new_image, "$updir" . "$thumb_beforeword" . "$name");*/
		}
		redirect('admin/gallery/galleries/'.$gid);
	}
	function preview($cat='all',$id=0,$slide=-1)
	{
		$this->load->model('System_model');             
		$this->load->model('Category_model');
		$this->load->model('Product_model');
		$this->load->model('Menu_model');               
		
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
		
		$data['index']=1;
		$data['slide']=-1;
		$data['pages_story']=1;
		$data['id_active']=$id;
		$data['stories'] = $this->Gallery_model->get_galleries_activepreview();
		
		//$data['pages_story'] = $this->System_model->get_storypage($id);
		//if($id=='Lookbook'){$cat='latest season'; $id='';}
		
		$data['id'] = $id;
		$data['cat'] = $cat;
		$data['story_single'] = $this->Gallery_model->get_galleries();
		$data['story_parent'] = $this->Gallery_model->get_galleries();
		
						
		$data['index']=ceil(count($data['stories'])/6);
		$this->load->view('common/header',$data);
		$this->load->view('admin/gallery/admin_gallery_preview',$data);
		$this->load->view('common/footer');
	}
	function view_gallery($cat='all',$id=0,$slide=-1)
	{
		$this->load->model('System_model');             
		$this->load->model('Category_model');
		$this->load->model('Product_model');
		$this->load->model('Menu_model');               
		
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
		
		$data['index']=1;
		$data['slide']=-1;
		$data['pages_story']=1;
		$data['id_active']=$id;
		$data['stories'] = $this->Gallery_model->get_galleries_activepage();
		
		//$data['pages_story'] = $this->System_model->get_storypage($id);
		//if($id=='Lookbook'){$cat='latest season'; $id='';}
		
		$data['id'] = $id;
		$data['cat'] = $cat;
		$data['story_single'] = $this->Gallery_model->get_galleries();
		$data['story_parent'] = $this->Gallery_model->get_galleries();
		
						
		$data['index']=ceil(count($data['stories'])/6);
		$this->load->view('common/header',$data);
		$this->load->view('admin/gallery/admin_gallery_preview',$data);
		$this->load->view('common/footer');
	}
}
