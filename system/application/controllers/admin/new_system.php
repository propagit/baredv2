<?php
class New_system extends Controller {
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		$this->load->model('System_model');
		$this->load->model('Content_model');
		$this->load->model('Category_model');
		$this->load->model('Product_model');
	}
	
	function index() {
		redirect('admin');
	}
	
	/* 2. 1. Product Attribute module */
	function attribute($action="",$attribute_id="") {
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		if ($action == "edit") {
			$data['attribute'] = $this->System_model->get_attribute($attribute_id);
			$this->load->view('admin/new_system/attribute/edit',$data);
		} else {
			$data['attributes'] = $this->System_model->get_attributes();
			//$this->load->view('admin/system/attribute/main',$data);
			$this->load->view('admin/new_system/attribute/list',$data);
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');
	}
	function addattribute() {
		$name = $_POST['name123'];
		$value = array();
		if (isset($_POST['options'])) {
			$options = $_POST['options'];
			foreach($options as $opt) 
			{
				//$value .= $opt.'~';
				$value[] = $opt; // store in an array
			}
		}
		$js_encode_value = json_encode($value,JSON_FORCE_OBJECT); // use json encode as object updated by Hieu
		$data = array(
			'name' => $name,
			'value' => $js_encode_value
		);
		$this->System_model->add_attribute($data);
		redirect('admin/new_system/attribute');
	}
	
	function getattributes() {
		$id = $_POST['id'];
		$attribute = $this->System_model->get_attribute($id);
		$options = $attribute['options'];
		$n = count($options);
		$out = '<div class="optwrap" id="attr-'.$id.'"><div class="title">Attribute: <b>'.$attribute['name'].'</b> (You can still customsie this attribute by adding/removing options below) <a href="javascript:removeattr('.$id.')">Remove</a></div>
				<input type="hidden" name="attributes[]" value="'.$id.'" id="attribute-'.$id.'" />
                    <div class="input">
                    	<dl class="four"><dd><input type="text" class="textfield rounded" id="optval-'.$id.'" /></dd><dd id="optbutton-'.$id.'"><input type="button" class="button rounded" value="&raquo;" onclick="addoption('.$id.','.($n + 1).')" /></dd></dl>
                        <dl></dl>
                    </div>
                    <div class="label" id="options-'.$id.'">';
			for($i=0;$i<$n;$i++) {
				$out .='<dl class="five" id="opt-'.$id.'-'.($i+1).'"><dt>'.$options[$i].'</dt><dd><a href="javascript:removeoption('.$id.','.($i+1).')"><img src="'.base_url().'img/backend/icon-delete-small.png" /></a></dd><input type="hidden" name="options-'.$id.'[]" value="'.$options[$i].'" /></dl>';
			}
		$out .='</div>
        <dl></dl>
		</div>';
		print $out;
	} 
	
	// Ajax function
	function deleteattribute($id="") {
		$this->System_model->delete_attribute($id);
		//redirect('admin/system/attribute');
	}
	function updateattribute() {
		$attribute_id = $_POST['attribute_id'];
		$value = array();
		if (isset($_POST['options'])) {
			$options = $_POST['options'];
			foreach($options as $opt) {
				//$value .= $opt.'~';
				$value[] = $opt; // store in an array
			}
		}
		$js_encode_value = json_encode($value,JSON_FORCE_OBJECT); // use json encode as object updated by Hieu
		$this->System_model->update_attribute($attribute_id,array('value' => $js_encode_value));
		redirect('admin/new_system/attribute');
	}
	function updateattributename() {
		$id = $_POST['id'];
		$this->System_model->update_attribute($id,array('name' => $_POST['name']));
	}
	
	
	# Shipping Management
	
	function shipping_v2($action="",$shipping_id="") {
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		if ($action == "add2") {
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			//print_r($data['states']);
			$this->load->view('admin/new_system/shipping/add2',$data);
		}
		else if ($action == "add") {
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			//print_r($data['states']);
			$this->load->view('admin/new_system/shipping/add',$data);
		} else if ($action == "edit") {
			$data['shipping'] = $this->System_model->get_shipping($shipping_id);
			$data['shipping2'] = $this->System_model->get_shipping_v2($shipping_id);
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			$conditions = $this->System_model->get_shipping_conditions($shipping_id);
			if (count($conditions) == 0) {
				$conditions[0] = array('price' => 0,'condition' => 0);
			}
			$data['conditions'] = $conditions;
			$this->load->view('admin/new_system/shipping/edit',$data);
		} else {
			$data['shippings'] = $this->System_model->get_shippings();
			//$this->load->view('admin/system/shipping/list',$data);
			$this->load->view('admin/new_system/shipping/list',$data);
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');
	}
		function addshippingmethod_v2() {
		if ($_POST['name'] == "") { redirect('admin/new_system/shipping'); }
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'default' => 0,
			'price_type' => $_POST['price_type'],
			'price_value' => $_POST['price_value'],
			'created' => date('Y-m-d H:i:s')
		);
		$data2 = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'default' => 0,
			'price_type' => $_POST['price_type_v2'],
			'price_value' => $_POST['price_value_v2'],
			'created' => date('Y-m-d H:i:s')
		);
		$shipping_id = $this->System_model->add_shipping($data);
		$shipping_id2 = $this->System_model->add_shipping_v2($data2);
		if (isset($_POST['default'])) { $this->System_model->default_shipping($shipping_id); }
		
		if (isset($_POST['countries'])) {
			$countries = $_POST['countries'];
			$states = $_POST['states'];
			foreach($countries as $ct) {
				foreach($states as $st) {			
				$data = array(
					'shipping_id' => $shipping_id,
					'country_id' => $ct,
					'state_id' => $st
				);
				$this->System_model->add_shipping_country($data);
				}
			}
		}
		$prices = $_POST['prices'];
		$conditions = $_POST['conditions'];
		for($i=0;$i<count($prices);$i++) {
			$price = str_replace('$','',$prices[$i]);
			$condition = str_replace('$','',$conditions[$i]);
			if ($price != "" && $condition != "") {
				$data = array(
					'shipping_id' => $shipping_id,
					'price' => floatval($price),
					'condition' => floatval($condition)
				);
				$this->System_model->add_shipping_condition($data);
			}
		}
		redirect('admin/new_system/shipping');
	}
	function updateshippingmethod_v2() {
		$shipping_id = $_POST['shipping_id'];
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'price_type' => $_POST['price_type'],
			'price_value' => $_POST['price_value']
		);
		$data2 = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'price_type' => $_POST['price_type_v2'],
			'price_value' => $_POST['price_value_v2']
		);
		$this->System_model->update_shipping($shipping_id,$data);
		$this->System_model->update_shipping_v2($shipping_id,$data2);
		
		if (isset($_POST['default'])) { $this->System_model->default_shipping($shipping_id); }
		$this->System_model->remove_shipping_countries($shipping_id);
		if (isset($_POST['countries'])) {
			$countries = $_POST['countries'];
			$states = $_POST['states'];
			foreach($countries as $ct) {
				foreach($states as $st) {			
				$data = array(
					'shipping_id' => $shipping_id,
					'country_id' => $ct,
					'state_id' => $st
				);
				$this->System_model->add_shipping_country($data);
				}
			}
		}
		$this->System_model->remove_shipping_conditions($shipping_id);
		$prices = $_POST['prices'];
		$conditions = $_POST['conditions'];
		for($i=0;$i<count($prices);$i++) {
			$price = str_replace('$','',$prices[$i]);
			$condition = str_replace('$','',$conditions[$i]);
			if ($price != "" && $condition != "") {
				$data = array(
					'shipping_id' => $shipping_id,
					'price' => floatval($price),
					'condition' => floatval($condition)
				);
				$this->System_model->add_shipping_condition($data);
			}
		}		
		$this->session->set_flashdata('updated',true);
		redirect('admin/new_system/shipping/edit/'.$shipping_id);
	}
	function activeshipping_v2($id="") {
		$this->System_model->active_shipping($id);
		$this->System_model->active_shipping_v2($id);
		redirect('admin/new_system/shipping');
	}
	function deleteshipping_v2($id="") {
		$this->System_model->remove_shipping_countries($id);
		$this->System_model->remove_shipping_conditions($id);
		$this->System_model->delete_shipping($id);
		$this->System_model->delete_shipping_v2($id);
		//redirect('admin/system/shipping');
	}
	function shipping($action="",$shipping_id="") {
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		if ($action == "add") {
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			$data['suburbs'] = $this->System_model->get_suburbs(1);
			$data['shipping_zone'] = $this->System_model->get_last_zone();
			//print_r($data['states']);
			$this->load->view('admin/new_system/shipping/add_new',$data);
		} else if ($action == "edit") {
			$shipping = $this->System_model->get_shipping($shipping_id);
			$data['shipping'] = $shipping;
			$data['shipping2'] = $this->System_model->get_shipping_v2($shipping_id);
			$data['countries'] = $this->System_model->get_countries();
			$data['states'] = $this->System_model->get_states();
			$data['suburbs'] = $this->System_model->get_suburbs(1);
			$ship_ct= $this->System_model->get_shipping_countries_all_detail($shipping_id);
			$data['ship_ct_id']=$ship_ct['country_id'];
			$data['ship_st_id']=$ship_ct['state_id'];
			
			$conditions = $this->System_model->get_shipping_conditions($shipping_id);
			if (count($conditions) == 0) {
				$conditions[0] = array('price' => 0,'condition' => 0);
			}
			$data['conditions'] = $conditions;
			$this->load->view('admin/new_system/shipping/edit_new',$data);
		} else {
			$data['shippings'] = $this->System_model->get_shippings();
			//$this->load->view('admin/system/shipping/list',$data);
			$this->load->view('admin/new_system/shipping/list',$data);
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');
	}
	function change_state($state)
	{
		$suburbs = $this->System_model->get_suburbs($state);
		$out='<select name="suburbs" multiple="multiple" id="suburbs" style="height:250px;width:250px;">';
		foreach($suburbs as $sb)
		{
			$out.='<option value="'.$sb['id'].'">'.$sb['name'].' - '.$sb['postcode'].'</option>';                                    
		}
        $out.="</select>";
		echo $out;
	}
	function change_zone_suburb($shipping_id)
	{
		$suburbs = $this->System_model->get_suburbs_zone($shipping_id);
		$out='<select name="suburbs_zone" multiple="multiple" id="suburbs_zone" style="height:250px;width:250px;">';
		foreach($suburbs as $st)
		{
			$sb = $this->System_model->get_suburb_detail($st['suburb_id']);
			$out.='<option value="'.$sb['id'].'">'.$sb['name'].' - '.$sb['postcode'].'</option>';                                    
		}
        $out.="</select>";
		echo $out;
	}
	function addzonesuburb()
	{
		$suburbs=$this->input->post('suburbs');
		$zone=$this->input->post('zone');
		$shipping_id=$this->input->post('shipping_id');
		$multiple_subs = json_decode($suburbs,true);

		foreach($multiple_subs as $key => $value)
		{
			if($multiple_subs[$key] > 0)
			{

			 	$check = $this->System_model->check_suburb($value,$shipping_id);
				if(count($check)==0){
					$data=array('zone' => $zone, 'suburb_id' => $value, 'shipping_id' => $shipping_id);
			
			 		$this->System_model->add_zone_suburb($data);			
				}
			}
		}	
	}
	function removezonesuburb()
	{
		$suburbs=$this->input->post('suburbs');
		$zone=$this->input->post('zone');
		$multiple_subs = json_decode($suburbs,true);
		$shipping_id=$this->input->post('shipping_id');			
		foreach($multiple_subs as $key => $value)
		{
			if($multiple_subs[$key] > 0)
			{

//			 $data=array('zone' => $zone, 'suburb' => $value);
			
			 $this->System_model->delete_zone_suburb($shipping_id,$value);			
			}
		}	
	}
	function create_shipping()
	{
		$zone=$this->input->post('zone');
		$name=$this->input->post('name');
		$default_shipping=$this->input->post('default_shipping');
		$data=array(
				'name' => $name,
				'zone' => $zone,
				'description' => '',
				'default' => $default_shipping,
				'price_type' => '',
				'price_value' => '',
				'created' => date('Y-m-d H:i:s')
			);
		$shipping_id = $this->System_model->add_shipping($data);
		echo $shipping_id;
	}
	function update_shipping()
	{
		$name=$this->input->post('name');
		$shipping_id = $this->input->post('shipping_id');
		$default_shipping = $this->input->post('default_shipping');
		$country_id = $this->input->post('country_id');
		$state_id = $this->input->post('state_id');
		$price_type = $this->input->post('price_type');
		$price_value = $this->input->post('price_value');
		$data= array(
				'name' => $name,
				'default' => $default_shipping,
				'price_type' => $price_type,
				'price_value' => $price_value
			);
		$this->System_model->update_shipping($shipping_id,$data);
		

		$data = array(
				'shipping_id' => $shipping_id,
				'country_id' => $country_id,					
				'state_id' => $state_id,					
			);
		$this->System_model->add_shipping_country($data);
		
		$this->System_model->remove_shipping_conditions($shipping_id);
		$prices = $this->input->post('prices');
		$conditions = $this->input->post('conditions');
		//print_r($prices);
		for($i=0;$i<count($prices);$i++) {
			$price = str_replace('$','',$prices[$i]);
			$condition = str_replace('$','',$conditions[$i]);
			if ($price != "" && $condition != "") {
				$data = array(
					'shipping_id' => $shipping_id,
					'price' => floatval($price),
					'condition' => floatval($condition)
				);
				$this->System_model->add_shipping_condition($data);
			}
		}
		
	}
	function duplicate_shipping()
	{
		$shipping_id = $this->input->post('hidden_id');
		$name = $this->input->post('name_duplicate');
		
		#detail of shipping method
		$ship_detail = $this->System_model->get_shipping($shipping_id);
		$data= array(
			'name' => $name,
			'default' => 0,
			'zone' => $ship_detail['zone']+1,
			'price_type' => $ship_detail['price_type'],
			'price_value' => $ship_detail['price_value'],
			'created' => date('Y-m-d H:i:s')
		);
		$shipping_id_new = $this->System_model->add_shipping($data);
		
		#detail of shipping country
		$shipping_countries = $this->System_model->get_shipping_countries_all($shipping_id);
		foreach($shipping_countries as $sc)
		{
			$data = array(
					'shipping_id' => $shipping_id_new,
					'country_id' => $sc['country_id'],					
					'state_id' => $sc['state_id']
				);
			$this->System_model->add_shipping_country($data);
		}
		
		#detail of shipping conditions
		$ship_conditions = $this->System_model->get_shipping_conditions($shipping_id);
		
		foreach($ship_conditions as $sc)
		{		
			$data = array(
				'shipping_id' => $shipping_id_new,
				'price' => $sc['price'],
				'condition' => $sc['condition']
			);
			$this->System_model->add_shipping_condition($data);
		}
		
		#detail of shipping suburbs
		$ship_suburbs = $this->System_model->get_suburbs_zone($shipping_id);
		foreach($ship_suburbs as $ss)
		{
			$data=array(
				'zone' => $ship_detail['zone'], 
				'suburb_id' => $ss['suburb_id'], 
				'shipping_id' => $shipping_id_new
			);			
			$this->System_model->add_zone_suburb($data);	
		}		
		redirect('admin/new_system/shipping');
	}
	function addshippingmethod() {
		if ($_POST['name'] == "") { redirect('admin/new_system/shipping'); }
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'default' => 0,
			'price_type' => $_POST['price_type'],
			'price_value' => $_POST['price_value'],
			'created' => date('Y-m-d H:i:s')
		);
		$data2 = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'default' => 0,
			'price_type' => $_POST['price_type_v2'],
			'price_value' => $_POST['price_value_v2'],
			'created' => date('Y-m-d H:i:s')
		);
		$shipping_id = $this->System_model->add_shipping($data);
		$shipping_id2 = $this->System_model->add_shipping_v2($data2);
		if (isset($_POST['default'])) { $this->System_model->default_shipping($shipping_id); }
		
		if (isset($_POST['countries'])) {
			$countries = $_POST['countries'];
			$states = $_POST['states'];
			foreach($countries as $ct) {
				foreach($states as $st) {			
				$data = array(
					'shipping_id' => $shipping_id,
					'country_id' => $ct,
					'state_id' => $st
				);
				$this->System_model->add_shipping_country($data);
				}
			}
		}
		$prices = $_POST['prices'];
		$conditions = $_POST['conditions'];
		for($i=0;$i<count($prices);$i++) {
			$price = str_replace('$','',$prices[$i]);
			$condition = str_replace('$','',$conditions[$i]);
			if ($price != "" && $condition != "") {
				$data = array(
					'shipping_id' => $shipping_id,
					'price' => floatval($price),
					'condition' => floatval($condition)
				);
				$this->System_model->add_shipping_condition($data);
			}
		}
		redirect('admin/new_system/shipping');
	}
	function updateshippingmethod() {
		$shipping_id = $_POST['shipping_id'];
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'price_type' => $_POST['price_type'],
			'price_value' => $_POST['price_value']
		);
		$data2 = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'price_type' => $_POST['price_type_v2'],
			'price_value' => $_POST['price_value_v2']
		);
		$this->System_model->update_shipping($shipping_id,$data);
		$this->System_model->update_shipping_v2($shipping_id,$data2);
		
		if (isset($_POST['default'])) { $this->System_model->default_shipping($shipping_id); }
		$this->System_model->remove_shipping_countries($shipping_id);
		if (isset($_POST['countries'])) {
			$countries = $_POST['countries'];
			$states = $_POST['states'];
			foreach($countries as $ct) {
				foreach($states as $st) {			
				$data = array(
					'shipping_id' => $shipping_id,
					'country_id' => $ct,
					'state_id' => $st
				);
				$this->System_model->add_shipping_country($data);
				}
			}
		}
		$this->System_model->remove_shipping_conditions($shipping_id);
		$prices = $_POST['prices'];
		$conditions = $_POST['conditions'];
		for($i=0;$i<count($prices);$i++) {
			$price = str_replace('$','',$prices[$i]);
			$condition = str_replace('$','',$conditions[$i]);
			if ($price != "" && $condition != "") {
				$data = array(
					'shipping_id' => $shipping_id,
					'price' => floatval($price),
					'condition' => floatval($condition)
				);
				$this->System_model->add_shipping_condition($data);
			}
		}		
		$this->session->set_flashdata('updated',true);
		redirect('admin/new_system/shipping/edit/'.$shipping_id);
	}
	function activeshipping($id="") {
		$this->System_model->active_shipping($id);
		//$this->System_model->active_shipping_v2($id);
		redirect('admin/new_system/shipping');
	}
	function deleteshipping($id="") {
		$this->System_model->remove_shipping_countries($id);
		$this->System_model->remove_shipping_conditions($id);
		$this->System_model->delete_shipping($id);
		//$this->System_model->delete_shipping_v2($id);
		//redirect('admin/system/shipping');
	}
	
	
	/* 2. 3. Coupon Methods */
	/*
	function coupon($action="",$coupon_id="") {
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		if ($action == "add") {
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
			//if ($action!="") { $row = $action; }
			$data['products'] = $this->Product_model->groupq($row);
			
			
			$this->load->view('admin/new_system/coupon/add',$data);
		} else if ($action == "edit") {
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
			//if ($action!="") { $row = $action; }
			$data['products'] = $this->Product_model->groupq($row);
			
			$data['coupon'] = $this->System_model->get_coupon($coupon_id);
			$data['coupon_condition'] = $this->System_model->get_coupon_condition($coupon_id);
			$this->load->view('admin/new_system/coupon/edit_new',$data);
		} else {
			$data['coupons'] = $this->System_model->get_coupons();
			//$this->load->view('admin/system/coupon/list',$data);
			$this->load->view('admin/new_system/coupon/list',$data);
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');
	}
	function coupon_edits($coupon_id="")
	{
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$data['coupon'] = $this->System_model->get_coupon($coupon_id);
		$data['coupon_condition'] = $this->System_model->get_coupon_condition($coupon_id);
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
		//if ($action!="") { $row = $action; }
		$data['products'] = $this->Product_model->group($row);
		$this->load->view('admin/new_system/coupon/edit_new',$data);
		$this->load->view('admin/new_common/footer');
	}
	function addcond_product()
	{
		$id = $this->input->post('id_coupon_cond');
		$products = $this->input->post('list_product');
		$cond_prod = $this->input->post('cond_prod');
		$data=array(
			'products' => $products,
			'cond_prod' => $cond_prod
		);
		$this->System_model->update_coupon_condition($id,$data);
		
	}
	function addcond_category()
	{
		$id = $this->input->post('id_coupon_cond');
		$categories = $this->input->post('list_category');
		$cond_cat = $this->input->post('cond_category');
		$data=array(
			'categories' => $categories,
			'cond_cat' => $cond_cat
		);
		$this->System_model->update_coupon_condition($id,$data);
	}
	function updatecond_spend()
	{
		$id = $this->input->post('id_coupon_cond');
		$value = $this->input->post('value');
		
		$data=array(
			'value' => $value			
		);
		$this->System_model->update_coupon_condition($id,$data);
	}
	
	function remove_condition($id)
	{
		$this->System_model->remove_condition($id);
	}
	
	function search_product()
	{
		$keyword=$this->input->post('keyword');
		$row=0;
		$products = $this->Product_model->search_groupq($row,10,$keyword,0,0,false);
		$out='';
		foreach($products as $product) { 
                
			$out.='	<tr id="product-'.$product['id'].'" class="detail_prod">
                		<td class="cb"><input type="checkbox" value="1" onclick="check_product()" class="single_product" id="single_product'.$product['id'].'"></td>
                    	<td style="text-align:left; ">
                        	<a href="'.base_url().'admin/new_cms/product/edit/'.$product['id'].'" target="_blank">'.$product['title'].'</a>
                    	</td>
                    	             
                	</tr>';
				
	    }
		echo $out;
	}
	#display option for conditions 
	function add_condition_layout($id)
	{
		$id=$id+1;
		$out='	<div class="cond" id="cond'.$id.'">
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
						<select class="selectpicker" style="margin-top:10px; margin-bottom:10px;" onChange="display_condition('.$id.')" id="cond_option'.$id.'">	
							<option value="0">Please Select</option>
							<option value="1">Spend Amounts</option>
							<option value="2">Categories</option>
							<option value="3">Products</option>
							<option value="4">Number of products </option>
							<option value="5">Add Coupon Code </option>
						</select>
						<script>jQuery(".selectpicker").selectpicker();</script>
						<style>#cond_option'.$id.'{margin-top:10px!important;}</style>
					</div>
				</div><div style="height: 5px; clear: both">&nbsp;</div>';
		echo $out;
	}
	function add_condition_layout_update($id,$idcoupon)
	{
		$id=$id+1;
		$out='	<div class="cond" id="cond'.$id.'">
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
						<select class="selectpicker" style="margin-top:10px; margin-bottom:10px;" onChange="display_condition('.$id.')" id="cond_option'.$id.'">	
							<option value="0">Please Select</option>
							<option value="1">Spend Amounts</option>
							<option value="2">Categories</option>
							<option value="3">Products</option>
							<option value="4">Number of products </option>
							<option value="5">Add Coupon Code </option>
						</select>
						<script>jQuery(".selectpicker").selectpicker();</script>
						<style>#cond_option'.$id.'{margin-top:10px!important;}</style>
					</div>
				</div><div style="height: 5px; clear: both">&nbsp;</div>';
		echo $out;
	}
	function add_detail_condition($id)
	{
		$option = $this->input->post('option');
		if($option==1) #spend amount
		$out='
				<div style="width: 20%; float: left; height: 30px; line-height: 50px; padding-left:10px;">Spend Amounts <input type="hidden" id="type_cond'.$id.'" value="1"></div>
				<div style="width: 70%; float: left; line-height: 50px;">
					If they spend more than &nbsp;&nbsp; 
						<div class="input-prepend">
	                    	<span class="add-on">$</span>
							<input class="span2" id="valuecondition'.$id.'" name="valuecondition'.$id.'" type="text">
						</div> &nbsp;&nbsp; 
						    Enter a number in format 00.00
				</div>
				<div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond('.$id.');">
					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
				</div>
			';
		if($option==2) #categories
		$out='
				<div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;">Category Discount <input type="hidden" id="type_cond'.$id.'" value="2"></div>
				<div style="width: 70%; float: left; line-height: 50px;">
						<div><select class="selectpicker" id="category_type"><option value="in">in</option><option value="out">out</option></select></div>
						<script>jQuery(".selectpicker").selectpicker();</script>
						<style>#category_type{margin-top:10px!important;}#cond'.$id.'{min-height:200px;}</style>
						<div><button class="btn btn-primary" type="button" onclick="add_categoty('.$id.')">Add Categories</button></div>
						<table class="table table-hover" width="100%">
							<thead>
								<tr style="font-size: 15px">
									<th style="width: 40%">Name</th>
								</tr>
							</thead>
							<tbody id="all_categories'.$id.'" class="all_cat">
								<tr>
									<td align="center">No items defined</td>
								</tr>
							</tbody>
							
						</table>
				</div>
				<div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond('.$id.');">
					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
				</div>
			';
		if($option==3) #products
		$out='
				<div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;">Product Discount <input type="hidden" id="type_cond'.$id.'" value="3"></div>
				<div style="width: 70%; float: left; line-height: 50px;">
						<div style="margin-top:10px;"><select class="selectpicker" id="product_type"><option value="in">in</option><option value="out">out</option></select></div>
						<script>jQuery(".selectpicker").selectpicker();</script>
						<style>#category_type{margin-top:10px!important;}#cond'.$id.'{min-height:200px;}</style>
						<div><button class="btn btn-primary" type="button" onclick="add_product('.$id.')">Add Products</button></div>
						<table class="table table-hover" width="100%">
							<thead>
								<tr style="font-size: 15px">
									<th style="width: 40%">Name</th>
								</tr>
							</thead>
							<tbody id="all_products'.$id.'" class="all_prod">
								<tr>
									<td align="center">No items defined</td>
								</tr>
							</tbody>
							
						</table>
				</div>
				<div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond('.$id.');">
					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
				</div>
			';
		if($option==4) #number of product
		$out='
				<div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;"># Product Purchased <input type="hidden" id="type_cond'.$id.'" value="4"></div>
				<div style="width: 70%; float: left; line-height: 50px;">
					If they buy more than &nbsp;&nbsp; 
						<div class="input-prepend">	                    	
							<input style="margin-top:10px;" class="span2" id="numberproduct'.$id.'" name="numberproduct'.$id.'" type="text">
						</div> 

				</div>
				<div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond('.$id.');">
					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
				</div>
			';
		if($option==5) #add a coupon code
		$out='
				<div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;">Add a Coupon Code <input type="hidden" id="type_cond'.$id.'" value="5"></div>
				<div style="width: 70%; float: left; line-height: 50px;">
					<input class="span2" style="margin-top:10px;" id="couponcode'.$id.'" name="couponcode'.$id.'" type="text">					
				</div>
				<div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond('.$id.');">
					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
				</div>
			';
		echo $out;
	}
	function addcoupon_new() {
		
		$name=$this->input->post('coupon_name');
		$code=$name;
		$expirary = $this->input->post('expirary');
		$from_date ='';
		$to_date ='';
		if($expirary==2){
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		}
		$discount_type = $this->input->post('discount_type');
		$values = $this->input->post('values');
		$type_cond = $this->input->post('condition');
		$data = array(
			'name' => $name,
			'code' => $code,
			'permanent' => 0,
			'expirary' => $expirary,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'type' => $discount_type,
			'value' => $values,
			'type_cond' => $type_cond,
			'sale_exclude' => 0,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s')
		);
		$coupon_id = $this->System_model->add_coupon($data);
		$count = $this->input->post('count');
		for($i=0; $i<$count; $i++)
		{
			$cond_type[$i] = $_POST['cond_type'][$i];
			$cond_value[$i]=$_POST['cond_value'][$i];
			$cond_cat_type[$i]=$_POST['cond_cat_type'][$i];
			$cond_cat[$i]=$_POST['cond_cat'][$i];
			$cond_product_type[$i]=$_POST['cond_product_type'][$i];;
			$cond_product[$i]=$_POST['cond_product'][$i];
			$data=array(
					'id_coupon' => $coupon_id,
					'type' => $cond_type[$i],
					'value' => $cond_value[$i],
					'cond_cat' => $cond_cat_type[$i],
					'categories' => $cond_cat[$i],
					'cond_prod' => $cond_product_type[$i],
					'products' => $cond_product[$i]
				);
			$this->System_model->add_coupon_condition($data);
		}
		
	}
	function updatecoupon_new() {
		
		$idcoupon=$this->input->post('idcoupon');
		$name=$this->input->post('coupon_name');
		$code=$name;
		$expirary = $this->input->post('expirary');
		$from_date ='';
		$to_date ='';
		if($expirary==2){
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		}
		$discount_type = $this->input->post('discount_type');
		$values = $this->input->post('values');
		$type_cond = $this->input->post('condition');
		$data = array(
			'name' => $name,
			'code' => $code,			
			'expirary' => $expirary,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'type' => $discount_type,
			'value' => $values,
			'type_cond' => $type_cond,
			'modified' => date('Y-m-d H:i:s')
		);
		$this->System_model->update_coupon($idcoupon,$data);
		$count = $this->input->post('count');
		for($i=0; $i<$count; $i++)
		{
			$cond_type[$i] = $_POST['cond_type'][$i];
			$cond_value[$i]=$_POST['cond_value'][$i];
			$cond_cat_type[$i]=$_POST['cond_cat_type'][$i];
			$cond_cat[$i]=$_POST['cond_cat'][$i];
			$cond_product_type[$i]=$_POST['cond_product_type'][$i];;
			$cond_product[$i]=$_POST['cond_product'][$i];
			$cond_new[$i]=$_POST['cond_new'][$i];
			$data=array(
					'id_coupon' => $idcoupon,
					'type' => $cond_type[$i],
					'value' => $cond_value[$i],
					'cond_cat' => $cond_cat_type[$i],
					'categories' => $cond_cat[$i],
					'cond_prod' => $cond_product_type[$i],
					'products' => $cond_product[$i]
				);
			if($cond_new[$i]==1){$this->System_model->add_coupon_condition($data);}
		}
		
	}
	function addcoupon() {
		if(!isset($_POST['name'])) { redirect('admin/system/coupon/add'); }
		$name = $_POST['name'];
		$code = $_POST['code'];
		if ($this->System_model->check_coupon_code($code)) {
			$this->session->set_flashdata('duplicate',true);
			redirect('admin/new_system/coupon/add');
		}
		$permanent = 0;
		if (isset($_POST['permanent'])) { $permanent = 1; }
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$type = $_POST['type'];
		$value = $_POST['value'];
		$condition = $_POST['condition'];
		$sale_exclude = 0;
		if (isset($_POST['sale_exclude'])) { $sale_exclude = 1; }
		$data = array(
			'name' => $name,
			'code' => $code,
			'permanent' => $permanent,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'type' => $type,
			'value' => $value,
			'condition' => $condition,
			'sale_exclude' => $sale_exclude,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s')
		);
		$coupon_id = $this->System_model->add_coupon($data);
		redirect('admin/new_system/coupon');
	}
	function updatecoupon() {
		if(!isset($_POST['id'])) { redirect('admin/system/coupon'); }
		$id = $_POST['id'];
		$name = $_POST['name'];
		$code = $_POST['code'];
		if ($this->System_model->check_coupon_code_update($id,$code)) {
			$this->session->set_flashdata('duplicate',true);
			redirect('admin/new_system/coupon/edit/'.$id);
		}
		$permanent = 0;
		if (isset($_POST['permanent'])) { $permanent = 1; }
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$type = $_POST['type'];
		$value = $_POST['value'];
		$condition = $_POST['condition'];
		$sale_exclude = 0;
		if (isset($_POST['sale_exclude'])) { $sale_exclude = 1; }
		$data = array(
			'name' => $name,
			'code' => $code,
			'permanent' => $permanent,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'type' => $type,
			'value' => $value,
			'condition' => $condition,
			'sale_exclude' => $sale_exclude,
			'modified' => date('Y-m-d H:i:s')
		);
		if($this->System_model->update_coupon($id,$data)) {
			$this->session->set_flashdata('updated',true);
		}
		redirect('admin/new_system/coupon/edit/'.$id);
	}
	function activecoupon($id="") {
		$this->System_model->active_coupon($id);
		redirect('admin/new_system/coupon');
	}
	function deletecoupon($id) {
		$this->System_model->delete_coupon($id);
		$this->System_model->remove_condition_coupon($id);
		//redirect('admin/system/coupon');
	}
	*/
	/* 2. 4. Manage Taxes */
	function tax($action="",$tax_id="") {
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		if ($action == "add") {
			$data['countries'] = $this->System_model->get_shipping_countries();
			$this->load->view('admin/new_system/tax/add',$data);
		} else if($action == "edit") {
			$data['countries'] = $this->System_model->get_shipping_countries();
			$data['tax'] = $this->System_model->get_tax($tax_id);			
			$this->load->view('admin/new_system/tax/edit',$data);
		} else {
			$data['taxes'] = $this->System_model->get_taxes();
			//$this->load->view('admin/system/tax/list',$data);
			$this->load->view('admin/new_system/tax/list',$data);
		}
		//$this->load->view('admin/common/rightbar');
		$this->load->view('admin/new_common/footer');
	}
	function addtax() {
		if(!isset($_POST['countries'])) {
			$this->session->set_flashdata('error',true);
			redirect('admin/system/tax/add');
		}
		$countries = $_POST['countries'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$type = 1;
		$value = $_POST['value'];
		$included = 0;
		if (isset($_POST['included'])) { $included = 1; }
		$tradetax=0;
		if(isset($_POST['tradetax'])){$tradetax=1;}
		$data = array(
			'name' => $name,
			'description' => $description,
			'type' => $type,
			'value' => $value,
			'included' => $included,
			'created' => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s'),
			'tradetax' => $tradetax
		);
		$tax_id = $this->System_model->add_tax($data);
		foreach($countries as $country_id) {
			$this->System_model->add_tax_country(array('country_id' => $country_id,'tax_id' => $tax_id));
		}
		
		redirect('admin/new_system/tax');
	}
	function updatetax() {
		$tax_id = $_POST['tax_id'];
		if(!isset($_POST['countries'])) {
			$this->session->set_flashdata('error',true);
			redirect('admin/system/tax/edit/'.$tax_id);
		}
		$countries = $_POST['countries'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$type = 1;
		$value = $_POST['value'];
		$included = 0;
		if (isset($_POST['included'])) { $included = 1; }
		$data = array(
			'name' => $name,
			'description' => $description,
			'type' => $type,
			'value' => $value,
			'included' => $included,
			'modified' => date('Y-m-d H:i:s')
		);
		$this->System_model->update_tax($tax_id,$data);
		$this->System_model->remove_tax_countries($tax_id);
		foreach($countries as $country_id) {
			$this->System_model->add_tax_country(array('country_id' => $country_id,'tax_id' => $tax_id));
		}
		$this->session->set_flashdata('updated',true);
		redirect('admin/new_system/tax/edit/'.$tax_id);
	}
	function deletetax($id="") {
		$this->System_model->remove_tax_countries($id);
		$this->System_model->delete_tax($id);
		//redirect('admin/system/tax');
	}
	function activetax($id="") {
		$this->System_model->active_tax($id);
		redirect('admin/new_system/tax');
	}
	
	function update_currency()
	{
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=USD');
		$response = json_decode($response);
		$data['usa'] = round($response->rate,2);
		
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=EUR');
		$response = json_decode($response);
		$data['eur'] = round($response->rate,2);
		
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=GBP');
		$response = json_decode($response);
		$data['gbp'] = round($response->rate,2);
		
		$response = file_get_contents('http://rate-exchange.appspot.com/currency?from=AUD&to=JPY');
		$response = json_decode($response);
		$data['jpy'] = round($response->rate,2);
		
		$this->System_model->update_currency($data);
	}
	
	function set_currency()
	{
		$nation = $_POST['nation'];
		$val = $_POST['val'];
		
		$data[$nation]=$val;
		$this->System_model->update_currency($data);
	}
	
	function currency() {		
		
		$cur = $this->System_model->get_currency();
		
		//echo '<pre>'.print_r($cur,true).'</pre>';
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_system/currency',$data);
		$this->load->view('admin/new_common/footer');
	}
	
	function email() {
		//$data['signup'] = $this->System_model->get_email('name','signup');
		$data['order'] = $this->System_model->get_email('name','order');
		$data['contact'] = $this->System_model->get_email('name','contact');
		$data['trade'] = $this->System_model->get_email('name','trade');
		$data['stock'] = $this->System_model->get_email('name','stock');
		// $this->load->view('admin/common/header');
		// $this->load->view('admin/system/email/main',$data);
		// $this->load->view('admin/common/rightbar');
		// $this->load->view('admin/common/footer');
		
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$this->load->view('admin/new_system/email',$data);
		$this->load->view('admin/new_common/footer');
	}
	function updateemails() {
		if(!isset($_POST['order']) || !isset($_POST['contact']) || !isset($_POST['stock'])|| !isset($_POST['trade'])) {
			$this->session->set_flashdata('updated','<br /><span class="error">ERROR: Invalid references</span>');
			redirect('admin/new_system/email');
		}
		//$this->System_model->delete_emails('name','signup');
		//$this->System_model->delete_emails('name','trade');
		//$this->System_model->delete_emails('name','order');
		//$this->System_model->delete_emails('name','contact');
		//$this->System_model->delete_emails('name','stock');
		//$email_ss = explode(',',$_POST['signup']);
		$email_tt = explode(',',$_POST['trade']);
		$email_oo = explode(',',$_POST['order']);
		$email_cc = explode(',',$_POST['contact']);
		$email_st = explode(',',$_POST['stock']);
		$msg0 = '';
		$msg1 = '';
		$msg2 = '';
		$msg3 = '';
		$msg4 = '';
		$this->load->helper('email');
		/*
		foreach($email_ss as $email_s) {
			$this->System_model->add_email(array('name' => 'signup','address' => $email_s));
			if (valid_email($email_s)) {
				$email_signup = $this->System_model->get_email('name','signup');
				if ($email_s != $email_signup['address']) {
					$this->System_model->update_email(3,array('address' => $email_s,'modified' => date('Y-m-d H:i:s')));
					$msg0 = '<span class="green">New Customer email has been updated successfully.</span>';
				} else { $msg0 = '<span>New Cusomter email is still the same</span>'; }
			} else { $msg0 = '<span class="error">New Customer email is invalid and was not updated.</span>'; }
			
		}
		*/
		$temp1= array();
		foreach($email_tt as $email_t) {
			//$this->System_model->add_email(array('name' => 'trade','address' => $email_t));
			/*if (valid_email($email_t)) {
				$email_trade = $this->System_model->get_email('name','trade');
				if ($email_t != $email_trade['address']) {
					$this->System_model->update_email(4,array('address' => $email_t,'modified' => date('Y-m-d H:i:s')));
					$msg3 = '<span class="green">New Trader email has been updated successfully.</span>';
				} else { $msg3 = '<span>New Trader email is still the same</span>'; }
			} else { $msg3 = '<span class="error">New Trader email is invalid and was not updated.</span>'; }*/
			$temp1[] = $email_t;
		}
		
		$this->System_model->update_email(1,array('name' => 'trade','address' => json_encode($temp1,JSON_FORCE_OBJECT)));
		$temp2= array();
		foreach($email_oo as $email_o) {
			
			/*if (valid_email($email_o)) {
				$email_order = $this->System_model->get_email('name','order');
				if ($email_o != $email_order['address']) {
					$this->System_model->update_email(1,array('address' => $email_o,'modified' => date('Y-m-d H:i:s')));	
					$msg1 = '<span class="green">Shop Order email has been updated successfully.</span>';
				} else { $msg1 = '<span>Shop Order email is still the same</span>'; }
			} else { $msg1 = '<span class="error">Shop Order email is invalid and was not updated.</span>'; }*/
			$temp2[] = $email_o;
		}
		$this->System_model->update_email(2,array('name' => 'order','address' => json_encode($temp2,JSON_FORCE_OBJECT)));
		$temp3= array();
		foreach($email_cc as $email_c) {
			
			/*if (valid_email($email_c)) {
				$email_contact = $this->System_model->get_email('name','contact');
				if ($email_c != $email_contact['address']) {
					$this->System_model->update_email(2,array('address' => $email_c,'modified' => date('Y-m-d H:i:s')));	
					$msg2 = '<span class="green">Website Contact email has been updated successfully.</span>';
				} else { $msg2 = '<span>Website Contact email is still the same</span>'; }
			} else { $msg2 = '<span class="error">Website Contact email is invalid and was not updated</span>'; }*/
			$temp3[] = $email_c;
		}
		$this->System_model->update_email(3,array('name' => 'contact','address' => json_encode($temp3,JSON_FORCE_OBJECT)));
		$temp4= array();
		foreach($email_st as $email_s) {
			
			/*if (valid_email($email_c)) {
				$email_contact = $this->System_model->get_email('name','contact');
				if ($email_c != $email_contact['address']) {
					$this->System_model->update_email(2,array('address' => $email_c,'modified' => date('Y-m-d H:i:s')));	
					$msg2 = '<span class="green">Website Contact email has been updated successfully.</span>';
				} else { $msg2 = '<span>Website Contact email is still the same</span>'; }
			} else { $msg2 = '<span class="error">Website Contact email is invalid and was not updated</span>'; }*/
			$temp4[] = $email_s;
		}
		$this->System_model->update_email(4,array('name' => 'stock','address' => json_encode($temp4,JSON_FORCE_OBJECT)));
		#$this->session->set_flashdata('updated','<br />'.$msg0.'<br />'.$msg3.'<br />'.$msg1.'<br />'.$msg2);
		redirect('admin/new_system/email');
		
	}	
	
	/*function to create story*/
	function story($coupon_id="")
	{
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');
		$data['stories'] = $this->System_model->get_all_story();
		$this->load->view('admin/new_system/story/list',$data);
		$this->load->view('admin/new_common/footer');
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
		$data['products'] = $this->Product_model->group($row);
			
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/new_system/story/add');
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
		$data['products'] = $this->Product_model->group($row);
			
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/new_system/story/edit',$data);
		$this->load->view('admin/new_common/footer');
	}
	function activestory($id="") {
		$this->System_model->active_story($id);
		redirect('admin/new_system/story');
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
			redirect('admin/new_system/edit_story/'.$id);	
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
		redirect('admin/new_system/edit_story/'.$id);
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
			redirect('admin/new_system/edit_story/'.$id);
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
		redirect('admin/new_system/edit_story/'.$id);
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
			redirect('admin/new_system/edit_story/'.$id);		
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
		redirect('admin/new_system/edit_story/'.$id);
	}
	
	function webstat()
	{
		$webstat = $this->System_model->get_webstat(1);
		$this->load->library('gapi', array( 'email' => $webstat['web_email'],'password' => $webstat['web_password'] ));
				
		$data['webstat'] = $webstat;
		$this->load->view('admin/new_common/header');
		$this->load->view('admin/new_common/leftbar');		
		$this->load->view('admin/new_system/webstat',$data);
		$this->load->view('admin/new_common/footer');
	}
	
	function set_webstat()
	{
		$data= array(
				'web_email' => $this->input->post('email',true),
				'web_password' => $this->input->post('password',true),
				'profile_id' => $this->input->post('profile_id',true)
			);
		$this->System_model->update_webstat(1,$data);
	}
	
}
?>