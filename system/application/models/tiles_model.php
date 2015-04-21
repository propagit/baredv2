<?php

/**
	@author kaushtuvgurung@gmail.com
*/


class Tiles_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	function insert($data)
	{
		$this->db->insert('tiles',$data);
		return $this->db->insert_id();
	}
	
	function update($tile_id,$data)
	{
		$this->db->where('tile_id',$tile_id)
				 ->update('tiles',$data);
		return $this->db->affected_rows();	
	}
	
	function get_tile($tile_id)
	{
		$tile = $this->db->where('tile_id',$tile_id)
						 ->get('tiles')
						 ->row_array();
	
		return $tile;	
	}
	
	function get_all($status = '')
	{
		if($status){
			$this->where('status',$status);	
		}
		$this->db->order_by('sort_order','asc');
		$query = $this->db->get('tiles');
		return $query->result_array();
	}
	
	function delete($tile_id)
	{
		$this->db->where('tile_id',$tile_id)
				 ->delete('tiles');
		return $this->db->affected_rows();	
	}
	
	function get_active_tiles($category)
	{
		$tiles = $this->db->where('status',1)
						  ->where('category',$category)
						  ->order_by('sort_order','asc')
						  ->get('tiles')
						  ->result_array();
		return $tiles;	
	}
	
	function total_active_tiles($category)
	{
		$sql = "SELECT COUNT(*) AS total 
				FROM tiles 
				WHERE status = 1
				AND category = " . $category;
		$record = $this->db->query($sql)
						   ->row_array();
		if($record){
			return $record['total'];	
		}
		return 0;
	}
	
	function get_tile_by_category($category = 'all')
	{
		$sql = "SELECT * FROM tiles";
		if($category != 'all'){
			$sql .= " WHERE category = ".$category;	
		}
		$sql .= " ORDER BY sort_order ASC";
		return $this->db->query($sql)->result_array();
	}
}
?>