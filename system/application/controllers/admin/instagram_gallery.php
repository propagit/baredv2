<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	@author kaushtuvgurung@gmail.com
*/

class Instagram_gallery extends Controller {
	
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		  	
		$this->load->model('Instagram_gallery_model');	
		$this->load->model('Product_model');	
	}
	
	
	# Main view
	function index()
	{
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/gallery/instagram/main_view');
		$this->load->view('admin/common/footer');	
	}
	
	function ajax_get_gallery_items_by_category()
	{
		$home_category = $this->input->post('home_category');
		$insta_cur_cat = $this->session->set_userdata('insta_cur_cat',$home_category);
		echo $this->row_view($home_category);	
	}
	
	function row_view($home_category)
	{
		$data['gallery_items'] = $this->Instagram_gallery_model->get_instagram_gallery_by_home_category($home_category);
		return $this->load->view('admin/gallery/instagram/gallery_items/row_view',$data,true);
	}
	
	# do insert operation
	function insert()
	{
		$data = array(
						'name' => $this->input->post('name'),
						'product_id' => $this->input->post('product_id'),
						'home_category' => $this->input->post('home_category')
					);
		$instagram_gallery_id = $this->Instagram_gallery_model->insert($data);
		
		# check if an image has been uploaded
		if($_FILES['userfile']['name']){
			$image_name = $this->_add_image($instagram_gallery_id);
			if($image_name){
				$image_data['image'] = $image_name;
				$this->Instagram_gallery_model->update($instagram_gallery_id,$image_data);	
			}
		}
		redirect('admin/instagram_gallery');
	}
	
	# do update operation
	function update()
	{
		$instagram_gallery_id = $this->input->post('instagram_gallery_id');
		
		$data = array(
						'name' => $this->input->post('name'),
						'product_id' => $this->input->post('product_id'),
						'home_category' => $this->input->post('home_category'),
						'modified' => date('Y-m-d H:i:s')	
					);
		$this->Instagram_gallery_model->update($instagram_gallery_id,$data);
		redirect('admin/instagram_gallery');	
	}
	
	# change status : active -> 1, inactive -> 0
	function change_status()
	{
		$instagram_gallery_id = $this->input->post('instagram_gallery_id');
		$item = $this->Instagram_gallery_model->get_gallery_item($instagram_gallery_id);
		
		if($item){
			$data['status'] = $tile['status'] ? 0 : 1;
			$this->Instagram_gallery_model->update($instagram_gallery_id,$data);
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
			$this->Instagram_gallery_model->update($val,$data);
		}
		redirect('admin/instagram_gallery');
	}
	
	# delete 
	function delete($instagram_gallery_id)
	{
		$item = $this->Instagram_gallery_model->get_gallery_item($instagram_gallery_id);
		$this->_delete_image($item['image']);
		$this->Instagram_gallery_model->delete($instagram_gallery_id);
		redirect('admin/instagram_gallery');	
	}
	
	# add image
	function _add_image($instagram_gallery_id)
	{
		$dir = './uploads/instagram/';
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
		$path = './uploads/instagram/'.$image_name;
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