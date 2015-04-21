<?php
class Lightspeed_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	function list_stock_lightspeed()
	{
		$query = $this->db->get('lightspeed_stock');
		return $query->result_array();
		
	}
	function get_product_stock_lightspeed($stock_id)
	{
		$this->db->like('size_stock_id',$stock_id);		
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	
	function get_order($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('orders');
		return $query->first_row('array');
	}
	function get_order_last($limit)
	{	
		$this->db->where('lightspeed_order_id',0);
		$this->db->where('status','successful');
		$this->db->where('id >=',1258);
		#$this->db->where('id = ',1218);
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$query = $this->db->get('orders');		
		return $query->result_array();		
	}
	
	function get_order_push($customer_id,$limit)
	{
		$this->db->where('lightspeed_order_id','open');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('status','successful');
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$query = $this->db->get('orders');		
		return $query->result_array();	
	}

	function get_order_push_test($customer_id,$limit)
	{
		#$this->db->where('lightspeed_order_id','open');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('status','successful');
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$query = $this->db->get('orders');		
		return $query->result_array();	
	}
	
	function get_all_customer(){
		$this->db->where('lightspeed_id',0);
		$query = $this->db->get('customers');
		return $query->result_array();		
	}
	
	function get_customer($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('customers');
		return $query->first_row('array');
	}
	function get_cart($session_id) {
		$this->db->where('session_id',$session_id);
		$this->db->order_by('id','asc');
		$query = $this->db->get('carts');
		return $query->result_array();
	}
	function update($id,$data) {
		$this->db->where('id',$id);
		$this->db->update('orders',$data);
	}
	function get_product_stock_id_lightspeed($size,$pid)
	{
		$this->db->like('size_stock_id','"'.$size.'"');		
		$this->db->where('id',$pid);
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	
	
	function get_customer_lightspeed($email) {
		$this->db->where('email',$email);
		$query = $this->db->get('lightspeed_customers');
		return $query->first_row('array');
	}
}