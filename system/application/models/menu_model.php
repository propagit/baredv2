<?php
class Menu_model extends Model {
	function __construct() {
		parent::__construct();
	}
    function getpage($id)
    {       
        $this->db->where('id',$id);
        $query = $this->db->get('pages');
        return $query->first_row('array');
        
    }
	function getpagetitle($id)
    {       
        $this->db->where('title_id',$id);
        $query = $this->db->get('pages');
        return $query->first_row('array');
        
    }
	function search_title($id,$title)
    {       
        $this->db->where('id !=',$id);
		$this->db->where('title',$title);
        $query = $this->db->get('pages');
        return $query->result_array();
        
    }
	function get_setting()
	{
        $query = $this->db->get('homepage');
		return $query->result_array();
	}
	
	function get_setting_trade()
	{
        $query = $this->db->get('homepage_trade');
		return $query->result_array();
	}
	
	function get_setting_active()
	{
        $this->db->where('published',1);
        $query = $this->db->get('homepage');
        return $query->first_row('array');
	}
	function get_setting_active_trade()
	{
        $this->db->where('published',1);
        $query = $this->db->get('homepage_trade');
        return $query->first_row('array');
	}
	function get_setting_type($type)
	{
        $this->db->where('type',$type);
        $query = $this->db->get('homepage');
        return $query->first_row('array');
	}
	function update_setting($id,$data)
	{
		$this->db->where('id',$id);
        return $this->db->update('homepage',$data);
	}
	
	function update_setting_trade($id,$data)
	{
		$this->db->where('id',$id);
        return $this->db->update('homepage_trade',$data);
	}
	function get_cat_from_page($id)
	{
		$this->db->where('id',$id);
        $query = $this->db->get('pages');
        return $query->first_row('array');
	}
	function getpage_cat($id_cat)
	{
		$this->db->where('category_id',$id_cat);
        $query = $this->db->get('pages');
        return $query->result_array();
	}
	function get_category_detail($id)
	{
		$this->db->where('id',$id);
        $query = $this->db->get('page_categories');
        return $query->first_row('array');
	}
	
	function get_all_parents()
	{
		 $this->db->order_by('order','asc');
		$query = $this->db->get('menus');
        return $query->result_array();
	}
	
	function get_menus()
	{
		$query=$this->db->get('main_nav');
		return $query->result_array();
	}
	
	function updatepage($id,$data)
    {
        //print_r($id);
        //print_r($data);
        $this->db->where('id',$id);
        return $this->db->update('pages',$data);
        
    }
	
	function deletepage($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('pages');
    }
	
	function get_active_stories()
	{
		$this->db->order_by('created','desc');
		$this->db->order_by('id','desc');
		$this->db->where('status',1);
		$this->db->where('archive_id',0);
		$this->db->where('category !=','LUGGAGE');
		$this->db->where('category !=','LATEST SEASON');
		$query = $this->db->get('story');
		return $query->result_array();	
	}
	function get_story_all($cat,$id)
	{						
		$sql = "SELECT story_page.*
				FROM story,story_page 
				where story_page.story_id = story.id and story.status = 1 ";
		if($cat!='all' && $cat!='archive' && $cat!='single' && $cat!='single_all'){$sql.=" and story.category='$cat' ";}		
		if($cat=='all' || $cat=='single_all' ){$sql.=" and story.archive_id=0";}
		if($cat=='archive'){$sql.=" and story.archive_id=$id ";}				
		if($cat=='single'){$sql.=" and story.id=$id ";}				
		if($cat!='luggage'){$sql.=" and story.category != 'LUGGAGE' ";}			
		if($cat!='latest season'){$sql.=" and story.category != 'LATEST SEASON' ";}				
		$sql.=" ORDER BY story.id DESC";		
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();		
	}
	function get_first_detail_story($id)
	{
		$this->db->where('story_id',$id);		
		$this->db->order_by('order','asc');		
		$query = $this->db->get('story_page');
		return $query->first_row('array');
	}
	function get_active_archive()
	{
		$this->db->order_by('id','desc');		
		$query = $this->db->get('story_archive');
		return $query->result_array();	
	}
	function get_story_cat($cat,$id)
	{
		if($cat!='all' && $cat!='archive' && $cat!='single')
		{$this->db->where('category',$cat);}
		
		if($cat=='archive')
		{$this->db->where('archive_id',$id);}
		else
		{
			if($cat=='all'){
				$this->db->where('archive_id',0);
			}
		}
		if($cat=='single'){$this->db->where('id',$id);}
		if($cat!='luggage'){$this->db->where('category !=','LUGGAGE');}		
		if($cat!='latest season'){$this->db->where('category !=','LATEST SEASON');}				
		$this->db->where('status',1);
		$this->db->order_by('created','desc');
		$this->db->order_by('order','asc');
		$query = $this->db->get('story');
		return $query->result_array();
	}
	function get_promotions($id)
	{				
		
		$sql = "SELECT promotions_page.*
				FROM promotions,promotions_page 
				where promotions_page.promotion_id = promotions.id and promotions.status = 1 and promotions.id=$id ";
		$sql.=" ORDER BY promotions_page.id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}
	function get_promotionpage($promotion_id)
	{
		$this->db->order_by('order','asc');		
		$this->db->where('promotion_id',$promotion_id);
		$query = $this->db->get('promotions_page');
		return $query->result_array();	
	}
	function get_promotionpagedetail($id)
	{
		$this->db->order_by('order','asc');		
		$this->db->where('id',$id);
		$query = $this->db->get('promotions_page');
		return $query->result_array();	
	}
	function add_promotionhtmlpage($data)
	{
		$this->db->insert('promotions_page',$data);
	}
	function get_detailpromotionhtml($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('promotions_page');
		return $query->first_row('array');
	}
	function update_promotionhtml($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('promotions_page',$data);
	}
	function delete_promotionhtml($id) {
		$this->db->where('id',$id);
		$this->db->delete('promotions_page');
	}
	function get_htmlpagedetail($id)
	{
		$this->db->order_by('order','asc');		
		$this->db->where('id',$id);
		$query = $this->db->get('story_page');
		return $query->result_array();	
	}
}
?>