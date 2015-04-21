<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	@author kaushtuvgurung@gmail.com
*/

class Tiles extends Controller {
	
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		  	
		$this->load->model('Tiles_model');	
	}
	
	# list tiles
	function index()
	{
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		#$data['tiles'] = $this->Tiles_model->get_all();
		$this->load->view('admin/tiles/list_view');
		$this->load->view('admin/common/footer');	
	}
	
	function ajax_get_tiles_by_category()
	{
		$category = $this->input->post('category');
		echo $this->row_view($category);	
	}
	
	function row_view($category)
	{
		$data['tiles'] = $this->Tiles_model->get_tile_by_category($category);
		return $this->load->view('admin/tiles/row_view',$data,true);
	}
	
	# loads create UI
	function create()
	{
		$data['action'] = 'insert';
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');		
		$this->load->view('admin/tiles/form_view',$data);
		$this->load->view('admin/common/footer');	
	}
	
	# do insert operation
	function insert()
	{
		$data = array(
						'name' => $this->input->post('name'),
						'btn_name' => $this->input->post('btn_name'),
						'btn_visibility' => $this->input->post('btn_visibility') ? 1 : 0,	
						'caption' => $this->input->post('caption'),
						'tile_uri' => $this->input->post('tile_uri'),
						'category' => $this->input->post('category'),
						'new_window' => $this->input->post('new_window') ? 1 : 0	
					);
		$tile_id = $this->Tiles_model->insert($data);
		
		# check if an image has been uploaded
		if($_FILES['userfile']['name']){
			$image_name = $this->_add_image($tile_id);
			if($image_name){
				$image_data['image_name'] = $image_name;
				$this->Tiles_model->update($tile_id,$image_data);	
			}
		}
		redirect('admin/tiles');
	}
	
	# loads edit UI
	function edit($tile_id)
	{
		$data['action'] = 'update';
		$tile = $this->Tiles_model->get_tile($tile_id);
		if(!$tile){
			redirect('admin/tiles');	
		}
		$data['tile'] = $tile;
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');		
		$this->load->view('admin/tiles/form_view',$data);
		$this->load->view('admin/common/footer');	
	}
	
	# do update operation
	function update()
	{
		$tile_id = $this->input->post('tile_id');
		
		$data = array(
						'name' => $this->input->post('name'),
						'btn_name' => $this->input->post('btn_name'),
						'btn_visibility' => $this->input->post('btn_visibility') ? 1 : 0,	
						'caption' => $this->input->post('caption'),
						'tile_uri' => $this->input->post('tile_uri'),
						'category' => $this->input->post('category'),
						'new_window' => $this->input->post('new_window') ? 1 : 0	,
						'modified' => date('Y-m-d H:i:s')	
					);
		$this->Tiles_model->update($tile_id,$data);
		
		# check if an image has been uploaded
		if($_FILES['userfile']['name']){
			# delete current image
			$tile = $this->Tiles_model->get_tile($tile_id);
			$this->_delete_image($tile['image_name']);
			
			$image_name = $this->_add_image($tile_id);
			if($image_name){
				$image_data['image_name'] = $image_name;
				$this->Tiles_model->update($tile_id,$image_data);	
			}
		}
		redirect('admin/tiles/edit/'.$tile_id);	
	}
	
	# change status : active -> 1, inactive -> 0
	function change_status()
	{
		$tile_id = $this->input->post('tile_id');
		$tile = $this->Tiles_model->get_tile($tile_id);
		$active_tiles = $this->Tiles_model->total_active_tiles($tile['category']);
		
		if($tile){
			# if current status is inactive then check if making this active voilates the total allowed count
			if(!$tile['status']){
				if($active_tiles >= 2){
					echo 'error';
					return;
				}
			}
			$data['status'] = $tile['status'] ? 0 : 1;
			$this->Tiles_model->update($tile_id,$data);
			echo 'success';
		}
	}
	
	#sort order
	function sort_order()
	{
		#echo '<pre>'.print_r($_POST['sort']).'</pre>';exit();
		$arrs = $_POST['sort'];
		foreach($arrs as $key=>$val){
			$data['sort_order'] = $key+1;
			$this->Tiles_model->update($val,$data);
		}
		redirect('admin/tiles');
	}
	
	# delete tile
	function delete($tile_id)
	{
		$tile = $this->Tiles_model->get_tile($tile_id);
		$this->_delete_image($tile['image_name']);
		$this->Tiles_model->delete($tile_id);
		redirect('admin/tiles');	
	}
	
	# add image
	function _add_image($tile_id)
	{
		$dir = './uploads/tiles/';
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
		$path = './uploads/tiles/'.$image_name;
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