<?php

/**
	@author kaushtuvgurung@gmail.com
*/


class Company_profile_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	
	
	function get_profile($profile_id = 1)
	{
		$profile = $this->db->where('company_profile_id',$profile_id)
						 ->get('company_profile')
						 ->row_array();
	
		return $profile;	
	}
	
	
}
?>