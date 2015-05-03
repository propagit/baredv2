<?php

/**
	@author zack@propagate.com.au
*/


class Landing_page_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	function insert($data)
	{
		$this->db->insert('landing_page',$data);
		return $this->db->insert_id();
	}
	
	function update($landing_page_id,$data)
	{
		$this->db->where('landing_page_id',$landing_page_id)
				 ->update('landing_page',$data);
		return $this->db->affected_rows();	
	}
	
	function get_landing_page($landing_page_id)
	{
		$landing_page = $this->db->where('landing_page_id',$landing_page_id)
						 ->get('landing_page')
						 ->row_array();
	
		return $landing_page;	
	}
	
	function get_all()
	{
		$this->db->order_by('sort_order','asc');
		$query = $this->db->get('landing_page');
		return $query->result_array();
	}
	
	function delete($landing_page_id)
	{
		$this->db->where('landing_page_id',$landing_page_id)
				 ->delete('landing_page');
		return $this->db->affected_rows();	
	}
}
?>