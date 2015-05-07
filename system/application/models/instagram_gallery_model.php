<?php

/**
	@author kaushtuvgurung@gmail.com
*/


class Instagram_gallery_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	function insert($data)
	{
		$this->db->insert('instagram_gallery',$data);
		return $this->db->insert_id();
	}
	
	function update($instagram_gallery_id,$data)
	{
		$this->db->where('instagram_gallery_id',$instagram_gallery_id)
				 ->update('instagram_gallery',$data);
		return $this->db->affected_rows();	
	}
	
	function get_gallery_item($instagram_gallery_id)
	{
		$item = $this->db->where('instagram_gallery_id',$instagram_gallery_id)
						 ->get('instagram_gallery')
						 ->row_array();
	
		return $item;	
	}
	
	function get_all($status = '')
	{
		if($status){
			$this->where('status',$status);	
		}
		$this->db->order_by('sort_order','asc');
		$query = $this->db->get('instagram_gallery');
		return $query->result_array();
	}
	
	function delete($instagram_gallery_id)
	{
		$this->db->where('instagram_gallery_id',$instagram_gallery_id)
				 ->delete('instagram_gallery');
		return $this->db->affected_rows();	
	}
	
	function get_active_instagram_gallery($home_category)
	{
		$instagram_gallery = $this->db->where('status',1)
						  ->where('home_category',$home_category)
						  ->order_by('sort_order','asc')
						  ->get('instagram_gallery')
						  ->result_array();
		return $instagram_gallery;	
	}
	
	function total_active_instagram_gallery($home_category)
	{
		$sql = "SELECT COUNT(*) AS total 
				FROM instagram_gallery 
				WHERE status = 1
				AND home_category = " . $home_category;
		$record = $this->db->query($sql)
						   ->row_array();
		if($record){
			return $record['total'];	
		}
		return 0;
	}
	
	function get_instagram_gallery_by_home_category($home_category = 'all')
	{
		$sql = "SELECT * FROM instagram_gallery";
		if($home_category != 'all'){
			$sql .= " WHERE home_category = ".$home_category;	
		}
		$sql .= " ORDER BY sort_order ASC";
		return $this->db->query($sql)->result_array();
	}
}
?>