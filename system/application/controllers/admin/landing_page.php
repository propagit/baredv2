<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	@author zack@propagate.com.au
*/

class Landing_page extends Controller {
	
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		  	
		$this->load->model('Landing_page_model');	
	}
	
	# list landing_page parts
	function index()
	{
		$landing_page = $this->Landing_page_model->get_all();
		$data['landing_pages'] = $landing_page;
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/landing_page/list_view',$data);
		$this->load->view('admin/common/footer');	
	}
	
	
	
	
	
	# loads edit UI
	function edit($landing_page_id)
	{
		$data['action'] = 'update';
		$landing_page = $this->Landing_page_model->get_landing_page($landing_page_id);
		if(!$landing_page){
			redirect('admin/landing_page');	
		}
		$data['landing_page'] = $landing_page;
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');		
		$this->load->view('admin/landing_page/form_view',$data);
		$this->load->view('admin/common/footer');	
	}
	
	# do update operation
	function update()
	{
		$landing_page_id = $this->input->post('landing_page_id');
		
		$data = array(
						'name' => $this->input->post('name'),
						'url' => $this->input->post('url'),
						'modified' => date('Y-m-d H:i:s')	
					);
		$this->Landing_page_model->update($landing_page_id,$data);
		
		# check if an image has been uploaded
		if($_FILES['userfile']['name']){
			# delete current image
			$landing_page = $this->Landing_page_model->get_landing_page($landing_page_id);
			$this->_delete_image($landing_page['image_name']);
			
			$image_name = $this->_add_image($landing_page_id);
			if($image_name){
				$image_data['image_name'] = $image_name;
				$this->Landing_page_model->update($landing_page_id,$image_data);	
			}
		}
		redirect('admin/landing_page/edit/'.$landing_page_id);	
	}
	
	
	
	#sort order
	function sort_order()
	{
		#echo '<pre>'.print_r($_POST['sort']).'</pre>';exit();
		$arrs = $_POST['sort'];
		foreach($arrs as $key=>$val){
			$data['sort_order'] = $key+1;
			$this->Landing_page_model->update($val,$data);
		}
		redirect('admin/landing_page');
	}
	
	
	
	# add image
	function _add_image($landing_page_id)
	{
		$dir = './uploads/landing_page/';
		$this->_create_dir($dir);
		
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
	
		if ($this->upload->do_upload()) {
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];
		}else{			
			#return $this->upload->display_errors();
			return false;	
		}
	}
	
	# delete image
	function _delete_image($image_name)
	{
		$path = './uploads/landing_page/'.$image_name;
		unlink($path);	
	}
	
	# check if dir exist and create a new one if it does not
	function _create_dir($dir){
		if(!is_dir($dir)){
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}	
	}
	
	
	
}
?>