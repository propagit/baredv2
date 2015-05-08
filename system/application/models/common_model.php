<?php

/**
	@author kaushtuvgurung@gmail.com
*/


class Common_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	/**
		
	*/
	
	function shoes_colors($gender)
	{
		$colors[WOMEN] = array(
								array('label' => 'View All','value' => 'view_all'),
								array('label' => 'Black','value' => 'black'),
								array('label' => 'Bn / Tan','value' => 'tan-bn'),
								array('label' => 'Beige / Taupe','value' => 'beige-taupe'),
								array('label' => 'White','value' => 'white'),
								array('label' => 'Green ? Olive','value' => 'olive-green'),
								array('label' => 'Yellow / Mustard','value' => 'yellow-mustard'),
								array('label' => 'Red / Orange','value' => 'red-orange'),
								array('label' => 'Pink','value' => 'pink'),
								array('label' => 'Blue / Purple','value' => 'blue-purple'),
								array('label' => 'Metallic','value' => 'metallic')
							);
							
		$colors[MEN] = array(
								array('label' => 'View All','value' => 'view_all'),
								array('label' => 'Black','value' => 'black'),
								array('label' => 'Bn / Tan','value' => 'tan-bn'),
								array('label' => 'Green ? Olive','value' => 'olive-green'),
								array('label' => 'Red','value' => 'red'),
								array('label' => 'Sand','value' => 'sand'),
								array('label' => 'Navy','value' => 'navy')
							);
		return $colors[$gender];				
		
	}
	
	function shoe_features()
	{
		return array(
						array('label' => 'View All','value' => 'view_all'),
						array('label' => 'Orthotic Friendly','value' => 'orthotic_friendly'),
						array('label' => 'Best for Wide Feet','value' => 'wide_feet'),
						array('label' => 'Best for Nar Feet','value' => 'nar_feet')
					);	
	}
	
	function price_Range()
	{
		return array(
						array('label' => 'View All','value' => 'view_all'),
						array('label' => '$0 - $100','value' => '0-100'),
						array('label' => '$100 - $200','value' => '100-200'),
						array('label' => '$200 - $300','value' => '200-300'),
						array('label' => '$300 +','value' => '300')
					);		
	}
}
?>