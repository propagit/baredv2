<?php
class Product_model extends Model {
	function __construct() {
		parent::Model();
	}
	
	function add($data) {
		$this->db->insert('products',$data);
		return $this->db->insert_id();
	}
	function random12()
	{
		$sql = "SELECT * FROM products ORDER BY RAND() LIMIT 12";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}
	function all_product() {
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all_in_stock() {
		$this->db->where('stock >',0);
		$this->db->where('deleted',0);
		$this->db->where('status',1);
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all_out_of_stock() {
		$this->db->where('stock',0);
		$this->db->where('deleted',0);
		$this->db->where('status',1);
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all_active() {
		$this->db->where('deleted',0);
		$this->db->where('status',1);
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all_on_sale() {
		$this->db->where('deleted',0);
		$this->db->where('status',1);
		$this->db->where('(sale_price < price OR sale_price_trade < price_trade)');
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all_disable() {
		$this->db->where('deleted',0);
		$this->db->where('status',0);
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all_hidden() {
		$this->db->where('deleted',1);
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function all() {
		$this->db->where('deleted',0);
		$this->db->order_by('title','asc');
		
		$query = $this->db->get('products');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	function all_byid() {
		$this->db->where('deleted',0);
		$this->db->order_by('id','asc');
		
		$query = $this->db->get('products');
		return $query->result_array();		
	}
	function group($row) {
		$sql = "SELECT * FROM `products` where deleted = 0 ORDER BY `title` ASC LIMIT $row,10";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function groupq($row) {
		$sql = "SELECT * FROM `products` where deleted = 0  and status=1 ORDER BY `title` ASC LIMIT $row,50";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function groupq2($row) {
		$sql = "SELECT * FROM `products` where deleted = 0  ORDER BY `title` ASC LIMIT $row,50";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	// function search($keyword,$category,$status) {	
		// if ($category == 0) {
			// $sql = "SELECT * FROM `products` WHERE (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' OR `products`.`collection` LIKE '%$keyword%')";
		// } else {
			// $sql = "SELECT `products`.* FROM `products`,`products_categories`
					// WHERE `products_categories`.`category_id` = $category
					// AND `products_categories`.`product_id` = `products`.`id`
					// AND (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' )";
		// }
		// if ($status == 'active') 
		// {
			// $sql .= " AND `products`.`status` = 1";
		// }
		// elseif ($status == 'inactive') 
		// {
			// $sql .= " AND `products`.`status` = 0";
		// }
		// $sql .= " AND `products`.`deleted` = 0";
		// $query = $this->db->query($sql);
		// return $query->result_array();		
	// }
	// function search_group($row,$per_page,$keyword,$category,$sort_type,$status) {	
		// if ($category == 0) {
			// $sql = "SELECT * FROM `products` WHERE (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' OR `products`.`collection` LIKE '%$keyword%')";
		// } else {
			// $sql = "SELECT `products`.* FROM `products`,`products_categories`
					// WHERE `products_categories`.`category_id` = $category
					// AND `products_categories`.`product_id` = `products`.`id`
					// AND (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%')";
		// }
		// if ($status == 'active') 
		// {
			// $sql .= " AND `products`.`status` = 1";
		// }
		// elseif ($status == 'inactive') 
		// {
			// $sql .= " AND `products`.`status` = 0";
		// }
		// $sql .= " AND `products`.`deleted` = 0";
		// if ($sort_type == 'title') {
			// $sql .= " ORDER BY `products`.`title` ASC";
		// } else if ($sort_type == 'date') {
			// $sql .= " ORDER BY `products`.`id` DESC";
		// } else {
			// $sql .= " ORDER BY `products`.`title` ASC";
		// }
		// $sql .= " LIMIT $row,$per_page";
		// $query = $this->db->query($sql);
		// //echo $sql;
		// return $query->result_array();		
	// }
	
	function search($keyword,$category,$status) {	
		if ($category == 0) {
			$sql = "SELECT * FROM `products` WHERE (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' OR `products`.`collection` LIKE '%$keyword%')";
		} 
		else 
		{
			if($category != 4)
			{
				$sql = "SELECT `products`.* FROM `products`,`products_categories`
					WHERE `products_categories`.`category_id` = $category
					AND `products_categories`.`product_id` = `products`.`id`
					AND (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' )";
			}
			else 
			{
				$sql = "SELECT distinct `products`.* FROM `products`,`products_categories`
					WHERE (`products_categories`.`category_id` = $category
					OR `products_categories`.`product_id` = `products`.`id`) AND (
					 `products`.`price` > `products`.`sale_price` OR `products`.`price_trade` > `products`.`sale_price_trade`)
					AND (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' )";
			}
			
		}
		if ($status == 'active') 
		{
			$sql .= " AND `products`.`status` = 1";
		}
		elseif ($status == 'inactive') 
		{
			$sql .= " AND `products`.`status` = 0";
		}
		$sql .= " AND `products`.`deleted` = 0";
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();		
	}
	function search_group($row,$per_page,$keyword,$category,$sort_type,$status) {	
		if ($category == 0) {
			$sql = "SELECT * FROM `products` WHERE (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' OR `products`.`collection` LIKE '%$keyword%')";
		} else {
			if($category != 4)
			{
				$sql = "SELECT `products`.* FROM `products`,`products_categories`
					WHERE `products_categories`.`category_id` = $category
					AND `products_categories`.`product_id` = `products`.`id`
					AND (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' )";
			}
			else 
			{
				$sql = "SELECT distinct `products`.* FROM `products`,`products_categories`
					WHERE (`products_categories`.`category_id` = $category OR
					`products_categories`.`product_id` = `products`.`id`) AND (
					 `products`.`price` > `products`.`sale_price` OR `products`.`price_trade` > `products`.`sale_price_trade`)
					AND (`products`.`title` LIKE '%$keyword%' OR `products`.`short_desc` LIKE '%$keyword%' OR `products`.`long_desc` LIKE '%$keyword%' )";
			}
		}
		if ($status == 'active') 
		{
			$sql .= " AND `products`.`status` = 1";
		}
		elseif ($status == 'inactive') 
		{
			$sql .= " AND `products`.`status` = 0";
		}
		$sql .= " AND `products`.`deleted` = 0";
		if ($sort_type == 'title') {
			$sql .= " ORDER BY `products`.`title` ASC";
		} else if ($sort_type == 'date') {
			$sql .= " ORDER BY `products`.`id` DESC";
		} else {
			$sql .= " ORDER BY `products`.`title` ASC";
		}
		$sql .= " LIMIT $row,$per_page";
		$query = $this->db->query($sql);
		//echo $sql;
		return $query->result_array();		
	}

	function search_groupq($row,$per_page,$keyword,$category,$sort_type,$status) {	
		if ($category == 0) {
			$sql = "SELECT * FROM `products` WHERE `products`.`title` LIKE '%$keyword%' and deleted = 0 ";}
		$sql .= " group by `products`.`id` LIMIT $row,$per_page ";
		$query = $this->db->query($sql);
		//echo $sql;
		return $query->result_array();		
	}
	function search_groupq_no_limit($keyword,$category,$sort_type,$status) {	
		if ($category == 0) {
			$sql = "SELECT * FROM `products` WHERE `products`.`title` LIKE '%$keyword%' and deleted = 0 ";}
		$sql .= " group by `products`.`id`";
		$query = $this->db->query($sql);
		//echo $sql;
		return $query->result_array();		
	}
	function identify($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	function identify2($title_id) {
		$this->db->where('id_title',$title_id);
		//$this->db->where('deleted',0);
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	function update($id,$data) {
		$this->db->where('id',$id);
		return $this->db->update('products',$data);
	}
	function update_with_stock_id($stock_id,$data) {
		$this->db->where('stock_id',$stock_id);
		return $this->db->update('products',$data);
	}
	function delete($id) {
		$this->db->where('id',$id);
		$this->db->delete('products');
	}
	
	function remove_categories($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_categories');
	}
	function remove_category($product_id,$category_id) {
		$this->db->where('product_id',$product_id);
		$this->db->where('category_id',$category_id);
		$this->db->delete('products_categories');
	}
	function add_category($data) {
		$this->db->insert('products_categories',$data);		
	}
	function get_categories($product_id) {
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('products_categories');
		return $query->result_array();
	}
	function get_categories_single($product_id) {
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('products_categories');
		return $query->first_row('array');
	}
	function product_category($product_id,$category_id) {
		$this->db->where('product_id',$product_id);
		$this->db->where('category_id',$category_id);
		$query = $this->db->get('products_categories');
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}
	
	function update_category_menu($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('category_menu',$data);
	}
	
	function get_name_keyword($title)
	{
		$this->db->where('name',$title);
		$query = $this->db->get('category_menu');
		return $query->first_row('array');
	}
	
	function get_product_by_category($category_id)
	{
		$this->db->where('category_id',$category_id);
		$query = $this->db->get('products_categories');
		return $query->result_array();
	}
	function get_product_by_category_shopby($cat_id,$order_by='',$mcat='')
	{
		
		$this->db->where('category_id',$mcat);
		$query = $this->db->get('products_categories');
		$all_prod = $query->result_array();
		
		$all_prod_id = Array();
		$cc=0;
		foreach($all_prod as $ap)
		{
			$prod_status=$this->identify($ap['product_id']); 

			if($prod_status['status']==1 && $prod_status['deleted']==0){
				$all_prod_id[$cc] = $ap['product_id'];
				$cc++;
			};
		}
		
		//echo "<pre>".print_r($all_prod,true)."</pre>";
		
		//return $query->result_array();
		
		$this->db->where('id',$cat_id);
		
		$query = $this->db->get('category_menu');
		$cat2 = $query->first_row('array');
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		
		if(count($cat2)>0)
		{
			$keyword= explode(",",$cat2['keywords']);
			//$this->db->where('status',1);
			foreach($keyword as $key)
			{
				
				/*$this->db->or_like('short_desc',trim($key));
				$this->db->or_like('long_desc',trim($key));
				*/
				$keys=trim($key);
				$this->db->where(("short_desc` LIKE '%$keys%' OR `long_desc` LIKE '%$keys%' AND `status`=1 and `deleted`=0"));
			}
			if(count($all_prod_id)>0)
			{
				$this->db->or_where_in('id', $all_prod_id);
			}
			$this->db->or_where('main_category',$mcat);
		}
		else
		{
			if(count($all_prod_id)>0)
			{
				$this->db->where_in('id', $all_prod_id);
			}
			$this->db->where('main_category',$mcat);
		}
		
		
		if($mcat == 6)
		{
			$this->db->or_where('sale_price < price');
		}
		
		
		
		if($order_by == 'name')
		{
			$this->db->order_by("title", "asc"); 
		}
		if($order_by == 'price')
		{
			$this->db->order_by("price", "asc"); 
		}
		if($order_by == 'latest')
		{
			$this->db->order_by("id", "asc"); 
		}
		
		$query = $this->db->get('products');
		if(count($all_prod_id)>0)
		{
			//$lq = $this->db->last_query();
			
			//$nlq = str_replace("AND","OR",$lq);
			
			//$query = $this->db->query($nlq);
		}
		
		//echo $this->db->last_query();
		
		return $query->result_array();
		
		//echo $this->db->last_query();
	}
	function get_product_by_category_shopby_pagination($row,$limit,$cat_id,$order_by='',$mcat='')
	{
		
		$this->db->where('category_id',$mcat);
		$query = $this->db->get('products_categories');
		$all_prod = $query->result_array();
		
		$all_prod_id = Array();
		$cc=0;
		foreach($all_prod as $ap)
		{
			$prod_status=$this->identify($ap['product_id']); 

			if($prod_status['status']==1 && $prod_status['deleted']==0){
				$all_prod_id[$cc] = $ap['product_id'];
				$cc++;
			}
		}
		
		//echo "<pre>".print_r($all_prod_id,true)."</pre>";
		
		
		//return $query->result_array();
		
		$this->db->where('id',$cat_id);
		
		$query = $this->db->get('category_menu');
		$cat2 = $query->first_row('array');
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		
		if(count($cat2)>0)
		{
			$keyword= explode(",",$cat2['keywords']);
			//$this->db->where('status',1);
			foreach($keyword as $key)
			{
				
				/*$this->db->or_like('short_desc',trim($key));
				$this->db->or_like('long_desc',trim($key));
				*/
				$keys=trim($key);
				$this->db->where(("short_desc` LIKE '%$keys%' OR `long_desc` LIKE '%$keys%' AND `status`=1 and `deleted`=0"));
			}
			if(count($all_prod_id)>0)
			{
				$this->db->or_where_in('id', $all_prod_id);
			}
			$this->db->or_where('main_category',$mcat);
		}
		else
		{
			if(count($all_prod_id)>0)
			{
				$this->db->where_in('id', $all_prod_id);
			}
			$this->db->where('main_category',$mcat);
		}
		
		
		if($mcat == 6)
		{
			$this->db->or_where('sale_price < price');
		}
		
		

		if($order_by == 'name')
		{
			$this->db->order_by("title", "asc"); 
		}
		if($order_by == 'price')
		{
			$this->db->order_by("price", "asc"); 
		}
		if($order_by == 'latest')
		{
			$this->db->order_by("id", "asc"); 
		}
		
		
		
		if($limit>0)
		{
			$this->db->limit($limit, $row);	
		}
		$query = $this->db->get('products');
		if(count($all_prod_id)>0)
		{
			//$lq = $this->db->last_query();
			
			//$nlq = str_replace("AND","OR",$lq);
				
			
			
			//$query = $this->db->query($nlq);
		}
		
		//echo $this->db->last_query();
		
		return $query->result_array();
		
		//echo $this->db->last_query();
	}
	function get_product_by_category_shopby2($cat_id,$order_by='',$scat='')
	{
		$this->db->where('id',$cat_id);
		
		$query = $this->db->get('category_menu');
		$cat2 = $query->first_row('array');
		if(count($cat2)>0)
		{
			$keyword= explode(",",$cat2['keywords']);
			//$this->db->where('status',1);
			foreach($keyword as $key)
			{
				$this->db->or_like('short_desc',trim($key));
				$this->db->or_like('long_desc',trim($key));
			}
		}
		$this->db->or_like('main_category',$mcat);
		
		if($order_by == 'name')
		{
			$this->db->order_by("title", "asc"); 
		}
		if($order_by == 'price')
		{
			$this->db->order_by("price", "asc"); 
		}
		if($order_by == 'latest')
		{
			$this->db->order_by("id", "asc"); 
		}
		
		$query = $this->db->get('products');
		return $query->result_array();
	}
	
	function get($cat_id)
	{
		$this->db->where('category_id',$cat_id);
		$query = $this->db->get('category_menu');
		return $query->result_array();
	}
	
	function get_product_by_category_style($row,$limit,$cat_id,$text,$order_by)
	{
		// $this->db->where('id',$cat_id);
		// $query = $this->db->get('category_menu');
		// $cat2 = $query->first_row('array');
		// $keyword= explode(",",$cat2['keywords']);
		if($text != 'first_edition')
		{
			$keyword2= str_replace("_"," ",$text);
			$sql="select * from products where status=1 and deleted=0 and (short_desc like '%".trim($keyword2)."%' or long_desc like '%".trim($text)."%') and main_category = $cat_id";
		}
		else 
		{
			//$keyword2= str_replace("_"," ",$text);
			$sql="select * from products where status=1 and deleted=0 and  (first_edition = 'Y' or first_edition = 'y') and main_category = $cat_id";
		}
		// $tot=count($keyword);
		// $i=0;
		// foreach($keyword as $key)
		// {
			// $sql.=" short_desc like '%".trim($key)."%' or long_desc like '%".trim($key)."%'";
			// $i++;
			// if($i<>$tot){ $sql.=" or ";}
		// }				 
		// $sql.=")";
		if($order_by == 'name')
		{
			$sql .= ' order by title';
		}
		if($order_by == 'price')
		{
			$sql .= ' order by price';
		}
		if($order_by == 'latest')
		{
			$sql .= ' order by id';
		}
		if($limit>0)
		{
			$sql .= ' Limit '.$row.','.$limit;
		}
		$query = $this->db->query($sql);
		/*$this->db->like('short_desc',trim($keyword2));
		foreach($keyword as $key)
		{
			$this->db->or_like('short_desc',trim($key));
			
		}				
		$query = $this->db->get('products');*/
		return $query->result_array();
	}
	function get_product_by_category_size($row,$limit,$cat_id,$text,$order_by='')
	{
		// $this->db->where('id',$cat_id);
		// $query = $this->db->get('category_menu');
		// $cat2 = $query->first_row('array');
		// $keyword= explode(",",$cat2['keywords']);
		
		//$keyword2= str_replace("_"," ",$text);
		//if($text=='small'){$size="'S'";$size =$size.", 'XS'";}
		//if($text=='medium'){$size="'M'";}
		//if($text=='large'){$size="'L'";$size =$size.", 'XL'";}
		if($text == 'small'){$size="short_desc like '%small%' or long_desc like '%small%'";}
		if($text == 'medium'){$size="short_desc like '%medium%' or long_desc like '%medium%'";}
		if($text == 'large'){$size="short_desc like '%large%' or long_desc like '%large%'";}
		/*foreach($keyword as $key)
		{
			$this->db->or_like('short_desc',trim($key));
			
		}				
		$this->db->where_in('size',$size);
		$query = $this->db->get('products');*/
		$sql="select * from products where ".$size." and main_category = $cat_id";
		// $tot=count($keyword);
		// $i=0;
		// foreach($keyword as $key)
		// {
			// $sql.=" short_desc like '%".trim($key)."%' or long_desc like '%".trim($key)."%'";
			// $i++;
			// if($i<>$tot){ $sql.=" or ";}
		// }				 
		// $sql.=")";
		if($order_by == 'name')
		{
			$sql .= ' order by title';
		}
		if($order_by == 'price')
		{
			$sql .= ' order by price';
		}
		if($order_by == 'latest')
		{
			$sql .= ' order by id';
		}
		if($limit>0)
		{
			$sql .= ' Limit '.$row.','.$limit;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_product_by_search($text,$order_by='')
	{
		
				
		
		/*foreach($keyword as $key)
		{
			$this->db->or_like('short_desc',trim($key));			
		}				
		$this->db->where('colour',$text);
		$query = $this->db->get('products');
		return $query->result_array();*/
		$sql="select * from products where title like '%".$text."%' or ";
		$sql.=" short_desc like '%".trim($text)."%' or long_desc like '%".trim($text)."%'";
		/*
		$tot=count($keyword);
				$i=0;
				foreach($keyword as $key)
				{
					$sql.=" short_desc like '%".trim($text)."%' or long_desc like '%".trim($text)."%'";
					$i++;
					if($i<>$tot){ $sql.=" or ";}
				}				 
				$sql.=")";*/
		
		
		if($order_by == 'name')
		{
			$sql .= ' order by title';
		}
		if($order_by == 'price')
		{
			$sql .= ' order by price';
		}
		if($order_by == 'latest')
		{
			$sql .= ' order by id';
		}
		
		//echo $sql;
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_product_by_category_colour($row,$limit,$cat_id,$text,$order_by='')
	{
		// $this->db->where('id',$cat_id);
		// $query = $this->db->get('category_menu');
		// $cat2 = $query->first_row('array');
		// $keyword= explode(",",$cat2['keywords']);
				
		
		/*foreach($keyword as $key)
		{
			$this->db->or_like('short_desc',trim($key));			
		}				
		$this->db->where('colour',$text);
		$query = $this->db->get('products');
		return $query->result_array();*/
		$sql="select * from products where ";
		$sql.=" short_desc like '%".trim($text)."%' or long_desc like '%".trim($text)."%' and main_category = $cat_id";
		// $tot=count($keyword);
		// $i=0;
		// foreach($keyword as $key)
		// {
			// $sql.=" short_desc like '%".trim($key)."%' or long_desc like '%".trim($key)."%'";
			// $i++;
			// if($i<>$tot){ $sql.=" or ";}
		// }				 
		// $sql.="";
		
		if($order_by == 'name')
		{
			$sql .= ' order by title';
		}
		if($order_by == 'price')
		{
			$sql .= ' order by price';
		}
		if($order_by == 'latest')
		{
			$sql .= ' order by id';
		}
		if($limit>0)
		{
			$sql .= ' Limit '.$row.','.$limit;
		}
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_product_by_category_price($row,$limit,$cat_id,$text,$order_by='')
	{
		// $this->db->where('id',$cat_id);
		// $query = $this->db->get('category_menu');
		// $cat2 = $query->first_row('array');
		// $keyword= explode(",",$cat2['keywords']);
				
		$price = explode("-",$text);
		/*$this->db->select()
			->from('users')
			->where("name != 'Joe' AND (age < 69 OR id > 50) ");
			*/
		/*foreach($keyword as $key)
		{
			$this->db->or_like('short_desc',trim($key));			
			//$sqls.=" short_desc like '%'".trim($key)."'%' ";
		}				
		$this->db->where('price >=',$price[0]);
		if(isset($price[1])){$this->db->where('price <=',$price[1]);}
		$query = $this->db->get('products');
		return $query->result_array();*/
		$sql="select * from products where price >=".$price[0]." and main_category = $cat_id"; 
		if(isset($price[1])){$sql.=" and price <=".$price[1];}
		// $sql.=" and (";
		// $tot=count($keyword);
		// $i=0;
		// foreach($keyword as $key)
		// {
			// $sql.=" short_desc like '%".trim($key)."%' or long_desc like '%".trim($key)."%'";
			// $i++;
			// if($i<>$tot){ $sql.=" or ";}
		// }				 
		// $sql.=")";
		if($order_by == 'name')
		{
			$sql .= ' order by title';
		}
		if($order_by == 'price')
		{
			$sql .= ' order by price';
		}
		if($order_by == 'latest')
		{
			$sql .= ' order by id';
		}
		if($limit>0)
		{
			$sql .= ' Limit '.$row.','.$limit;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function random_new12($title,$other)
	{
		/*$sql = "SELECT * FROM products where ORDER BY RAND() LIMIT 12";
		$query = $this->db->query($sql);
		return $query->result_array();		*/
		if(count($other)>0)
		{
			$this->db->where_not_in('id',$other);
		}
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		//$this->db->where('stock >',0);
		$this->db->order_by('id','random');		
		$query = $this->db->get('products');
		return $query->result_array();		
	}
	function random_new_like_other($title,$other,$main_category)
	{
		/*$sql = "SELECT * FROM products where ORDER BY RAND() LIMIT 12";
		$query = $this->db->query($sql);
		return $query->result_array();		*/
		if(count($other)>0)
		{
			$this->db->where_not_in('id',$other);
		}
		$this->db->where('main_category',$main_category);
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		$this->db->where('gift_card',0);
		//$this->db->where('stock >',0);
		$this->db->order_by('id','random');		
		$query = $this->db->get('products');
		return $query->result_array();		
	}
	
	function get_other_title_product($title,$title2,$product_id)
	{
		$this->db->like('title', trim($title),'after'); 
		//$this->db->or_like('title', trim($title2),'before'); 
		$this->db->where('id !=',$product_id);
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		$this->db->where('gift_card',0);
		//$this->db->where('stock >',0);
		$query = $this->db->get('products');
		
		return  $query->result_array();
	}
	function get_other_product($title,$product_id)
	{
		$this->db->like('title', $title); 
		$this->db->where('id !=',$product_id);
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		$this->db->where('gift_card',0);
		$query = $this->db->get('products');
		return  $query->result_array();
	}
	
	function get_other_product_same_cat($title,$product_id,$cat)
	{
		$this->db->where('title', $title); 
		//$this->db->like('title', trim($title),'after'); 
		$this->db->where('id !=',$product_id);
		//$this->db->where('short_desc =',$cat);
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		$this->db->where('gift_card',0);
		$query = $this->db->get('products');
		//print_r($this->db->last_query());
		return  $query->result_array();
	}
	
	function get_new_product_list_all($cat_id,$scat_id,$text,$by,$look_by)
	{
		
		$sql = "update products set new_ar = 0";
		$query = $this->db->query($sql);
		
		$sql = "select * from products a where deleted = 0 and status = 1 order by id desc limit 0,25";
		$query = $this->db->query($sql);
		$new_ar = $query->result_array();
		
		foreach($new_ar as $na)
		{
			$sql = "update products set new_ar = 1 where id = ".$na['id'];
			$query = $this->db->query($sql);
		}
		
		if($scat_id != 'all')
		{
			if($cat_id != 4)
			{
				$sql = "select * from products a
					where a.main_category = $cat_id 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
			else
			{
				$sql = "select * from products a
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
		}
		else
		{
			if($cat_id != 4)
			{
				if($cat_id == 1)
				{
					$sql = "select * from products a
					where deleted = 0 and status = 1 and id in (select product_id from products_categories where category_id = 171)"; 
					//where deleted = 0 and status = 1 and new_ar = 1";
				}
				else 
				{
					if($cat_id == 2)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 9)) and deleted = 0 and status = 1";
					}
					if($cat_id == 3)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 21)) and deleted = 0 and status = 1";
					}
					if($cat_id == 4)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 29)) and deleted = 0 and status = 1";
					}
					if($cat_id == 5)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 35)) and deleted = 0 and status = 1";
					}
					
				}
				
			}
			else 
			{
				$sql = "select * from products a 
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) and deleted = 0 and status = 1";
			}
		}
		
		if($look_by != '' && $look_by != '0')
		{
			if($text == 'first_edition')
			{
				$sql .= " and (first_edition = 'Y' or first_edition = 'y')";
			}
			elseif($look_by == 'price')
			{
				$price = explode("-",$text);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			else 
			{
				$text = str_replace("_", " ", $text);
				if($text=='leather')
				{
					//$sql .= " and (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
					$sql .= " and (a.features like '%leather%' ) and a.features not like '%faux-leather%' ";
				}
				else
				{
					if($look_by == 'colour')
					{
						$ltext = explode('-', $text);
						if($ltext)
						{
							$tcolour = '';
							$tc=0;
							foreach($ltext as $lt)
							{
								if($tc == 0)
								{
									if($lt=='red'){$lt=' '.'red';}
									$tcolour .=" a.features like '%$lt%'";
								}
								else 
								{
									if($lt=='red'){$lt=' red';}
									$tcolour .=" or a.features like '%$lt%'";
								}
								$tc++;
							}
							$sql .= " and ($tcolour)";
						}
						else
						{
							$sql .= " and (a.features like '%$text%')";
						}
					}
					else 
					{
						$sql .= " and (a.features like '%$text%')";
					}
				}
			}
		}
		
		if($by == 'name')
		{
			$sql .= ' order by title';
		}
		if($by == 'price')
		{
			$sql .= ' order by price';
		}
		if($by == 'latest')
		{
			$sql .= ' order by id desc';
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_new_product_list_all_position($cat_id,$scat_id,$text,$by,$look_by)
	{
		
		$sql = "update products set new_ar = 0";
		$query = $this->db->query($sql);
		
		$sql = "select * from products a where deleted = 0 and status = 1 order by id desc limit 0,25";
		$query = $this->db->query($sql);
		$new_ar = $query->result_array();
		
		foreach($new_ar as $na)
		{
			$sql = "update products set new_ar = 1 where id = ".$na['id'];
			$query = $this->db->query($sql);
		}
		/*
		if($scat_id != 'all')
		{
			if($cat_id != 4)
			{
				$sql = "select * from products a
					where a.main_category = $cat_id 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
			else
			{
				$sql = "select * from products a
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
			$sql_category = "select * from categories c	where c.id = $scat_id";
		}
		else
		{
			if($cat_id != 4)
			{
				if($cat_id == 1)
				{
					$sql = "select * from products a
					where deleted = 0 and status = 1 and id in (select product_id from products_categories where category_id = 171)"; 
					//where deleted = 0 and status = 1 and new_ar = 1";
					$sql_category = "select * from categories c	where c.id =171";
				}
				else 
				{
					if($cat_id == 2)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 9)) and deleted = 0 and status = 1";
						$sql_category = "select * from categories c	where c.id = 9";
					}
					if($cat_id == 3)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 21)) and deleted = 0 and status = 1";
						$sql_category = "select * from categories c	where c.id = 21";
					}
					if($cat_id == 4)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 29)) and deleted = 0 and status = 1";
						$sql_category = "select * from categories c	where c.id = 29";
					}
					if($cat_id == 5)
					{
						$sql = "select * from products a 
						where (a.main_category = $cat_id or id in (select product_id from products_categories where category_id = 35)) and deleted = 0 and status = 1";
						$sql_category = "select * from categories c	where c.id = 35";
					}
					
				}
				
			}
			else 
			{
				$sql = "select * from products a 
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) and deleted = 0 and status = 1";
				$sql_category = "select * from categories c	where c.id = 4";
			}
		}*/
		if($scat_id != 'all')
		{
			if($cat_id != 4)
			{
				//$sql = "select a.id from products a where a.main_category = $cat_id and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
				$sql = "select a.id from products a where a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
				
			}
			else
			{
				$sql = "select a.id from products a
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
			$sql_category = "select * from categories c	where c.id = $scat_id";
			$pos_cat = $scat_id;
		}
		else
		{
			if($cat_id != 4)
			{
				if($cat_id == 1)
				{
					$sql = "select a.id from products a 
					where deleted = 0 and status = 1 and id in (select product_id from products_categories where category_id = 171)";
					$sql_category = "select * from categories c	where c.id = 171";
					$pos_cat = 171;
				}
				else 
				{
					$sql = "select a.id from products a 
					where (a.main_category = $cat_id) and deleted = 0 and status = 1 and gift_card = 0";
					//if($cat_id==2){$ccat_id=26;}
					//else					
					//if($cat_id==3){$ccat_id=33;}
					//else{$ccat_id=$cat_id;}
					$sql_category = "select * from categories c	where c.id = $cat_id";
					$pos_cat = $cat_id;
				}
			}
			else 
			{
				$sql = "select a.id from products a 
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) and deleted = 0 and status = 1";
				$sql_category = "select * from categories c	where c.id = 4";
				$pos_cat = 4;
			}
		}
		
		if($look_by != '' && $look_by != '0')
		{
			if($text == 'first_edition')
			{
				$sql .= " and (first_edition = 'Y' or first_edition = 'y')";
			}
			elseif($look_by == 'price')
			{
				$price = explode("-",$text);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			elseif($look_by=='size')
			{
				$text2=$text."eu"."\"".":"."\""."0"."\"";
				$text3=$text."eu"."\"".":"."\""."\"";
				$sql .= " and a.multiplesize=1 and (a.size like '%$text%' ) and a.size not like '%$text2%' and a.size not like '%$text3%' ";
			}
			else 
			{
				$text = str_replace("_", " ", $text);
				if($text=='leather')
				{
					//$sql .= " and (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
					$sql .= " and (a.features like '%leather%' ) and a.features not like '%faux-leather%' ";
				}
				else
				{
					if($look_by == 'colour')
					{
						$ltext = explode('-', $text);
						if($ltext)
						{
							$tcolour = '';
							$tc=0;
							foreach($ltext as $lt)
							{
								if($tc == 0)
								{
									if($lt=='red'){$lt=' '.'red';}
									$tcolour .=" a.features like '%$lt%'";
								}
								else 
								{
									if($lt=='red'){$lt=' '.'red';}
									$tcolour .=" or a.features like '%$lt%'";
								}
								$tc++;
							}
							$sql .= " and ($tcolour)";
						}
						else
						{
							$sql .= " and (a.features like '%$text%')";
						}
					}
					else 
					{
						$sql .= " and (a.features like '%$text%')";
					}
				}
			}
		}
		
		if($by == 'name')
		{
			$sql .= ' order by title';
		}
		if($by == 'price')
		{
			$sql .= ' order by price';
		}
		if($by == 'latest')
		{
			$sql .= ' order by id desc';
		}
		
		//echo $sql_category;
		
		//$query = $this->db->query($sql);
		//return $query->result_array();
		$query_category = $this->db->query($sql_category);
		
		
		$product_category= $query_category->result_array();
		foreach($product_category as $pc)
		{ $order_pos=$pc['order_position'];}
		//echo $order_pos;
		$prod = array();
		$prod_all = array();
		if($order_pos!='' && ($look_by=='' || $look_by=='0')){
			$cats_product=$order_pos;
			$ind=json_decode($cats_product);
			$prod=array();
			foreach($ind as $id)
			{
				if($id!='' && $this->check_category_product($pos_cat,$id)>0)
				{
					$prod[]=$id;
					$prod_all[]=$id;				
				}

			}
			
			$query = $this->db->query($sql);
			$prods = $query->result_array();
			foreach($prods as $ps)
			{
				if(!in_array($ps['id'],$prod_all))
				{
					$prod[]['id']=$ps['id'];
					$prod_all[]=$ps['id'];
					#$j++;
				}			
			}
			//print_r(count($prod));
			return $prod;
		}
		else
		{
			//echo 'test';
			//$sql .= ' Limit '.$row.','.$limit;
			//echo $sql;
			$query = $this->db->query($sql);

			return $query->result_array();
			
		}
	}
	
	function get_new_product_list($cat_id,$scat_id,$text,$by,$look_by,$row,$limit)
	{
		$sql = "update products set new_ar = 0";
		$query = $this->db->query($sql);
		
		$sql = "select * from products a where deleted = 0 and status = 1 order by id desc limit 0,25";
		$query = $this->db->query($sql);
		$new_ar = $query->result_array();
		
		foreach($new_ar as $na)
		{
			$sql = "update products set new_ar = 1 where id = ".$na['id'];
			$query = $this->db->query($sql);
		}
		
		
		
		if($scat_id != 'all')
		{
			if($cat_id != 4)
			{
				$sql = "select * from products a
					where a.main_category = $cat_id 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
			else
			{
				$sql = "select * from products a
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
		}
		else
		{
			if($cat_id != 4)
			{
				if($cat_id == 1)
				{
					$sql = "select * from products a 
					where deleted = 0 and status = 1 and id in (select product_id from products_categories where category_id = 171)";
				}
				else 
				{
					$sql = "select * from products a 
					where (a.main_category = $cat_id) and deleted = 0 and status = 1 and gift_card = 0";
				}
			}
			else 
			{
				$sql = "select * from products a 
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) and deleted = 0 and status = 1";
			}
		}
		
		if($look_by != '' && $look_by != '0')
		{
			if($text == 'first_edition')
			{
				$sql .= " and (first_edition = 'Y' or first_edition = 'y')";
			}
			elseif($look_by == 'price')
			{
				$price = explode("-",$text);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			else 
			{
				$text = str_replace("_", " ", $text);
				if($text=='leather')
				{
					//$sql .= " and (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
					$sql .= " and (a.features like '%leather%' ) and a.features not like '%faux-leather%' ";
				}
				else
				{
					if($look_by == 'colour')
					{
						$ltext = explode('-', $text);
						if($ltext)
						{
							$tcolour = '';
							$tc=0;
							foreach($ltext as $lt)
							{
								if($tc == 0)
								{
									if($lt=='red'){$lt=' '.'red';}
									$tcolour .=" a.features like '%$lt%'";
								}
								else 
								{
									if($lt=='red'){$lt=' '.'red';}
									$tcolour .=" or a.features like '%$lt%'";
								}
								$tc++;
							}
							$sql .= " and ($tcolour)";
						}
						else
						{
							$sql .= " and (a.features like '%$text%')";
						}
					}
					else 
					{
						$sql .= " and (a.features like '%$text%')";
					}
					
				}
			}
		}
		
		if($by == 'name')
		{
			$sql .= ' order by title';
		}
		if($by == 'price')
		{
			$sql .= ' order by price';
		}
		if($by == 'latest')
		{
			$sql .= ' order by id desc';
		}
		
		$sql .= ' Limit '.$row.','.$limit;
		
		//echo $sql;
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_new_product_list_position($cat_id,$scat_id,$text,$by,$look_by,$row,$limit)
	{
		$sql = "update products set new_ar = 0";
		$query = $this->db->query($sql);
		
		$sql = "select * from products a where deleted = 0 and status = 1 order by id desc limit 0,25";
		$query = $this->db->query($sql);
		$new_ar = $query->result_array();
		
		foreach($new_ar as $na)
		{
			$sql = "update products set new_ar = 1 where id = ".$na['id'];
			$query = $this->db->query($sql);
		}
		
		
		
		if($scat_id != 'all')
		{
			if($cat_id != 4)
			{
				//$sql = "select a.id from products a where a.main_category = $cat_id and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
				$sql = "select a.id from products a where a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
				
			}
			else
			{
				$sql = "select a.id from products a
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) 
					and a.id in (select product_id from products_categories where category_id = $scat_id) and deleted = 0 and status = 1 ";
			}
			$sql_category = "select * from categories c	where c.id = $scat_id";
			$pos_cat=$scat_id;
		}
		else
		{
			if($cat_id != 4)
			{
				if($cat_id == 1)
				{
					$sql = "select a.id from products a 
					where deleted = 0 and status = 1 and id in (select product_id from products_categories where category_id = 171)";
					$sql_category = "select * from categories c	where c.id = 171";
					$pos_cat=171;
				}
				else 
				{
					$sql = "select a.id from products a 
					where (a.main_category = $cat_id) and deleted = 0 and status = 1 and gift_card = 0";
					//if($cat_id==2){$ccat_id=26;}
					//else					
					//if($cat_id==3){$ccat_id=33;}
					//else{$ccat_id=$cat_id;}
					$sql_category = "select * from categories c	where c.id = $cat_id";
					$pos_cat=$cat_id;
				}
			}
			else 
			{
				$sql = "select a.id from products a 
					where (a.sale_price < a.price or a.sale_price_trade < a.price_trade) and deleted = 0 and status = 1";
				$sql_category = "select * from categories c	where c.id = 4";
				$pos_cat=4;
			}
		}
		
		if($look_by != '' && $look_by != '0')
		{
			if($text == 'first_edition')
			{
				$sql .= " and (first_edition = 'Y' or first_edition = 'y')";
			}
			elseif($look_by == 'price')
			{
				$price = explode("-",$text);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			elseif($look_by=='size')
			{
				$text2=$text."eu"."\"".":"."\""."0"."\"";
				$text3=$text."eu"."\"".":"."\""."\"";
				$sql .= " and a.multiplesize=1 and (a.size like '%$text%' ) and a.size not like '%$text2%' and a.size not like '%$text3%' ";
			}
			else 
			{
				$text = str_replace("_", " ", $text);
				if($text=='leather')
				{
					//$sql .= " and (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
					$sql .= " and (a.features like '%leather%' ) and a.features not like '%faux-leather%' ";
				}
				else
				{
					if($look_by == 'colour')
					{
						$ltext = explode('-', $text);
						if($ltext)
						{
							$tcolour = '';
							$tc=0;
							foreach($ltext as $lt)
							{
								if($tc == 0)
								{
									if($lt=='red'){$lt=' '.'red';}
									$tcolour .=" a.features like '%$lt%'";
								}
								else 
								{
									if($lt=='red'){$lt=' red';}
									$tcolour .=" or a.features like '%$lt%'";
								}
								$tc++;
							}
							$sql .= " and ($tcolour)";
						}
						else
						{
							$sql .= " and (a.features like '%$text%')";
						}
					}
					else 
					{
						$sql .= " and (a.features like '%$text%')";
					}
					
				}
			}
		}
		
		if($by == 'name')
		{
			$sql .= ' order by title';
		}
		if($by == 'price')
		{
			$sql .= ' order by price';
		}
		if($by == 'latest')
		{
			$sql .= ' order by id desc';
		}
				
		
		//echo $sql_category;
		
		
		$query_category = $this->db->query($sql_category);
		
		
		$product_category= $query_category->result_array();
		foreach($product_category as $pc)
		{ $order_pos=$pc['order_position'];}
		if($order_pos!='' && ($look_by=='' || $look_by == '0')){

			$cats_product=$order_pos;
			$ind=json_decode($cats_product);
			$prod=array();
			$prod_all=array();
			//if($row==0){$i=0;} else{$i=1;}
			$i=0;
			$j=1;
			//print_r($row.' '.$limit);
			foreach($ind as $id)
			{
				
				if($this->check_category_product($pos_cat,$id)>0)
				{
					if($i>=$row && $j<=$limit && $id!='')
					{
						
						$prod[]['id']=$id;
						//echo $i.' '.$j.'<br>';
						$j++;
					}
					$prod_all[]=$id;
					$i++;
				}
				
			}
			//print_r($prod);
			if($j-1 < $limit)
			{
				$j=$j-1;
				//$sql .= ' Limit '.$row.','.$limit;
				$query = $this->db->query($sql);
				$prods = $query->result_array();
				foreach($prods as $ps)
				{
					if($j<$limit && !in_array($ps['id'],$prod_all))
					{
						$prod[]['id']=$ps['id'];
						$prod_all[]=$ps['id'];
						//echo $i.' '.$j.'<br>';
						$j++;
					}
				}
			}
			
			return $prod;
		}
		else
		{
			//echo 'test';
			$sql .= ' Limit '.$row.','.$limit;
			//echo $sql;
			$query = $this->db->query($sql);
			return $query->result_array();
			
		}
	}
	function check_category_product($cat,$prod_id)
	{
		$this->db->where('product_id',$prod_id);
		$this->db->where('category_id',$cat);
		$query = $this->db->get('products_categories');
		return count($query->result_array());
	}
	
	function get_new_search_product_list_all($keyword,$text,$by,$look_by)
	{
		$lk = explode(' ', $keyword);
		
		$cc = 0;
		$ttile = ' ';
		foreach ($lk as $l) {
			if($cc == 0)
			{
				$ttile .= "a.title like '%$l%' ";
			}
			else
			{
				$ttile .= " or a.title like '%$l%' ";
			}
			$cc++;
		}
		
		$cc = 0;
		$tsd = ' ';
		foreach ($lk as $l) {
			if($cc == 0)
			{
				$tsd .= "a.short_desc like '%$l%' ";
			}
			else
			{
				$tsd .= " or a.short_desc like '%$l%' ";
			}
			$cc++;
		}
		
		$cc = 0;
		$tld = ' ';
		foreach ($lk as $l) {
			if($cc == 0)
			{
				$tld .= "a.long_desc like '%$l%' ";
			}
			else
			{
				$tld .= " or a.long_desc like '%$l%' ";
			}
			$cc++;
		}
		
		$sql = "select * from products a 
					where ($ttile or $tsd or $tld) and deleted = 0 and status = 1 ";
		
		if($look_by != '' && $look_by != 0)
		{
			if($look_by == 'price')
			{
				$price = explode("-",$text);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			else 
			{
				$text = str_replace("_", " ", $text);
				$sql = "select * from ($sql) as b where (b.features like '%$text%')";
				//$sql = "select * from ($sql) as b where (b.short_desc like '%$text%' or b.long_desc like '%$text%')";
				//$sql .= " or (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
			}
		}
		
		//echo $sql;
		
		if($by == 'name')
		{
			$sql .= ' order by title';
		}
		if($by == 'price')
		{
			$sql .= ' order by price';
		}
		if($by == 'latest')
		{
			$sql .= ' order by id desc';
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_new_search_product_list($keyword,$text,$by,$look_by,$row,$limit)
	{
		$lk = explode(' ', $keyword);
		
		$cc = 0;
		$ttile = ' ';
		foreach ($lk as $l) {
			if($cc == 0)
			{
				$ttile .= "a.title like '%$l%' ";
			}
			else
			{
				$ttile .= " or a.title like '%$l%' ";
			}
			$cc++;
		}
		
		$cc = 0;
		$tsd = ' ';
		foreach ($lk as $l) {
			if($cc == 0)
			{
				$tsd .= "a.short_desc like '%$l%' ";
			}
			else
			{
				$tsd .= " or a.short_desc like '%$l%' ";
			}
			$cc++;
		}
		
		$cc = 0;
		$tld = ' ';
		foreach ($lk as $l) {
			if($cc == 0)
			{
				$tld .= "a.long_desc like '%$l%' ";
			}
			else
			{
				$tld .= " or a.long_desc like '%$l%' ";
			}
			$cc++;
		}
		
		$sql = "select * from products a 
					where ($ttile or $tsd or $tld) and deleted = 0 and status = 1 ";
		
		if($look_by != '' && $look_by != 0)
		{
			if($look_by == 'price')
			{
				$price = explode("-",$text);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			else 
			{
				$text = str_replace("_", " ", $text);
				$sql = "select * from ($sql) as b where (b.features like '%$text%')";
				//$sql .= " or (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
			}
		}
		
		//echo $sql;
		
		if($by == 'name')
		{
			$sql .= ' order by title';
		}
		if($by == 'price')
		{
			$sql .= ' order by price';
		}
		if($by == 'latest')
		{
			$sql .= ' order by id desc';
		}
		
		$sql .= ' Limit '.$row.','.$limit;
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function add_attribute($data) {
		$this->db->insert('products_attributes',$data);
	}
	function remove_attributes($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_attributes');
	}
	function get_attributes($product_id) {
		//$attributes = array();
		$this->db->where('product_id',$product_id);
		$this->db->order_by('id','asc');
		$query = $this->db->get('products_attributes');
		return  $query->result_array();
		/*
		$result = $query->result_array();
		foreach($result as $row)
	    {
			
			$options = array();
			if($row['value'] != '')
			{
				$options = json_decode($row['value'], true);
			}
			$attributes[] = array(
				
				'name' => $row['name'],
				'options' => $options
			);			
		}
		return $attributes;
		*/
	}
	function get_attribute($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('products_attributes');
		$result = $query->first_row('array');
		//$value = explode("~",$result['value']);
		
		$options = array();
		$options = json_decode($result['value'],true);
		/*
		for($i=0;$i<count($value)-1;$i++) {
			$options[] = $value[$i];
		}
		*/
		return $options;
		
	}
	function add_photo($data) {
		$this->db->insert('products_photos',$data);
		return $this->db->insert_id();
	}
	function update_photo($id,$data) {
		$this->db->where('id',$id);
		$this->db->update('products_photos',$data);
	}
	function delete_photo($id) {
		$this->db->where('id',$id);
		$this->db->delete('products_photos');
	}
	function get_all_photos($product_id) {
		$this->db->where('product_id',$product_id);
		//$this->db->where('hero',0);
		$this->db->order_by('order','asc');
		$query = $this->db->get('products_photos');
		return $query->result_array();
	}
	function get_photos($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->where('hero',0);
		$this->db->order_by('order','asc');
		$query = $this->db->get('products_photos');
		return $query->result_array();
	}
	function get_photo($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('products_photos');
		return $query->first_row('array');
	}
	function hero_photo($product_id,$id) {
		$sql = "UPDATE `products_photos` SET `hero` = 0 WHERE `product_id` = $product_id";
		$this->db->query($sql);
		$sql = "UPDATE `products_photos` SET `hero` = 1 WHERE `id` = $id";
		$this->db->query($sql);
	}
	function modal_photo($product_id,$id) {
		$sql = "UPDATE `products_photos` SET `modal` = 0 WHERE `product_id` = $product_id";
		$this->db->query($sql);
		$sql = "UPDATE `products_photos` SET `modal` = 1 WHERE `id` = $id";
		$this->db->query($sql);
	}
	function thumb_photo($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->order_by('hero','desc');
		$query = $this->db->get('products_photos');
		return $query->first_row('array');
	}
	function get_hero($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->where('hero',1);
		$query = $this->db->get('products_photos');
		return $query->first_row('array');
	}
	function get_modal($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->where('modal',1);
		$query = $this->db->get('products_photos');
		return $query->first_row('array');
	}
	function get_next_photo($product_id,$order) {
		$sql = "SELECT * FROM `products_photos` WHERE `product_id` = $product_id
				AND `order` > $order
				ORDER BY `order` ASC";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	function get_prev_photo($product_id,$order) {
		$sql = "SELECT * FROM `products_photos` WHERE `product_id` = $product_id
				AND `order` < $order
				ORDER BY `order` DESC";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function add_crosssale($data) {
		$this->db->insert('products_crosssales',$data);
		return $this->db->insert_id();
	}
	function update_crosssale($id,$data) {	
		$this->db->where('id',$id);
		$this->db->update('products_crosssales',$data);
	}
	function remove_crosssale($id) {
		$this->db->where('id',$id);
		$this->db->delete('products_crosssales');
	}
	function remove_crosssales($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_crosssales');
	}
	function remove_related($product_id) {
		$sql = "DELETE FROM `products_crosssales` WHERE `product_id` = $product_id OR `related` = $product_id";
		$this->db->query($sql);
	}
	function is_crosssale($product_id,$related) {
		$this->db->where('product_id',$product_id);
		$this->db->where('related',$related);
		$query = $this->db->get('products_crosssales');
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}
	function count_crosssales($product_id) {
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('products_crosssales');
		return $query->num_rows();
	}
	function get_crosssale($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('products_crosssales');
		return $query->first_row('array');
	}
	function get_crosssales($product_id) {
		$sql = "SELECT `products_crosssales`.* FROM `products_crosssales`,`products`
				WHERE `products`.`id` = `products_crosssales`.`related`
				AND `products`.`status` = 1
				AND `products_crosssales`.`product_id` = '$product_id'
				ORDER BY `order` ASC";
		/*$this->db->where('product_id',$product_id);
		$this->db->order_by('order','asc');
		$query = $this->db->get('products_crosssales');*/
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_next_crosssale($product_id,$order) {
		$sql = "SELECT * FROM `products_crosssales` WHERE `product_id` = $product_id
				AND `order` > $order
				ORDER BY `order` ASC";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	function get_prev_crosssale($product_id,$order) {
		$sql = "SELECT * FROM `products_crosssales` WHERE `product_id` = $product_id
				AND `order` < $order
				ORDER BY `order` DESC";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function add_feature($data) {
		$this->db->insert('products_features',$data);
		return $this->db->insert_id();
	}
	function get_features() {
//		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` ORDER  BY `products_features`.`order` ASC ";
		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` and `products`.`deleted` = 0 and `products`.`status` = 1 ORDER  BY `products_features`.`order` ASC LIMIT 0,12";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_features1() {
//		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` ORDER  BY `products_features`.`order` ASC ";
		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` and `products`.`deleted` = 0 and `products`.`status` = 1 ORDER  BY `products_features`.`order` ASC LIMIT 0,6";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_features2() {
//		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` ORDER  BY `products_features`.`order` ASC ";
		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` and `products`.`deleted` = 0 and `products`.`status` = 1 ORDER  BY `products_features`.`order` ASC LIMIT 6,6";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_features3() {
//		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` ORDER  BY `products_features`.`order` ASC ";
		$sql = "SELECT `products`.* FROM `products`,`products_features` WHERE `products`.`id` = `products_features`.`product_id` ORDER  BY `products_features`.`order` ASC LIMIT 12,6";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function remove_feature($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_features');
	}
	function get_feature($product_id) {
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('products_features');
		return $query->first_row('array');
	}
	function update_feature($id,$data) {
		$this->db->where('id',$id);
		$this->db->update('products_features',$data);
	}
	function is_feature($product_id) {
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('products_features');
		if ($query->num_rows() > 0) { return true; }
		return false;
	}
	function count_features() {
			
		$sql = 'SELECT *
FROM products a, products_features b
WHERE a.id = b.product_id
AND a.deleted =0
AND a.status =1';
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function get_next_feature($order) {
		$sql = "SELECT * FROM `products_features` WHERE `order` > $order
				ORDER BY `order` ASC";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	function get_prev_feature($order) {
		$sql = "SELECT * FROM `products_features` WHERE `order` < $order
				ORDER BY `order` DESC";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function purchased_time($product_id) {
		$sql = "SELECT sum(`carts`.`quantity`) as `total` 
				FROM `carts`,`orders` 
				WHERE `carts`.`product_id` = ".$product_id." 
				AND `carts`.`session_id` = `orders`.`session_id` 
				AND `orders`.`status` = 'successful'";
		$query = $this->db->query($sql);
		$row = $query->first_row('array');
		$times = 0;
		if ($row['total'] != NULL) { $times = $row['total']; }
		return $times;
	}
	function remove_features($product_id) {
		$this->db->where('product_id',$product_id);
		$this->db->delete('products_features');
	}
	
	function get_first_edition($name)
	{
		$this->db->like('title',$name,'after');
		$this->db->where('limited','Y');
		$this->db->where('first_edition','Y');
		$this->db->where('stock',1);
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	
	function get_product_per_story($id)
	{
		$this->db->where('story_id',$id);
		$query = $this->db->get('story_products');
		$all_prod = $query->result_array();
		
		$cc = 0;
		$prod = Array();
		foreach($all_prod as $ap)
		{
			$prod[$cc] = $ap['product_id'];
			$cc++;
		}
		if(count($prod)==0){$prod[]=0;}
			
		$this->db->where_in('id',$prod);
		$query = $this->db->get('products');
		return $query->result_array();
		
	}
	function get_product_story($cat,$id,$sort,$limit,$row,$by)
	{
		
		if($cat=='single' || $cat=='single_all')
		{
			$this->db->where('story_id',$id);
			$query = $this->db->get('story_products');
			$all_prod = $query->result_array();					
		}
		if($cat=='all')		
		{
			$sql = "SELECT story_products.*
				FROM story,story_products 
				where story_products.story_id = story.id and story.status = 1 and story.archive_id = 0";
			$query = $this->db->query($sql);
			$all_prod = $query->result_array();		
		}
		
		if($cat=='archive')		
		{
			$sql = "SELECT story_products.*
				FROM story,story_archive,story_products 
				where story_archive.id= story.archive_id and story_products.story_id = story.id and story.status = 1 and story.archive_id = $id";
			$query = $this->db->query($sql);
			$all_prod = $query->result_array();		
		}
		
		if($cat!='all' && $cat!='archive' && $cat!='single' && $cat!='single_all')		
		{
			$cat=strtoupper($cat);
			$sql = "SELECT story_products.*
				FROM story,story_products 
				where story_products.story_id = story.id and story.status = 1 and story.archive_id = 0 and story.category='$cat'";
			$query = $this->db->query($sql);
			$all_prod = $query->result_array();		
		}
		$cc = 0;
		$prod = Array();
		foreach($all_prod as $ap)
		{
			$prod[$cc] = $ap['product_id'];
			$cc++;
		}
		if(count($prod)==0){$prod[]=0;}
		$prods_arr = implode (", ", $prod);
		//print_r($prod);
		//echo $by;
		if($by != '')
		{
			$sql = "SELECT products.*
				FROM products where id in ($prods_arr) and status= 1 and deleted = 0 ";
				
			if($by == 'first_edition')
			{
				$sql .= " and (first_edition = 'Y' or first_edition = 'y')";
			}
			elseif($by == 'price')
			{
				$price = explode("-",$by);
				$low_price = $price[0];
				if(isset($price[1]))
				{
					$high_price = $price[1];
				}
				else 
				{
					$high_price = 0;
				}
				
				$sql .= " and price >= $low_price";
				if($high_price != 0)
				{
					$sql .= " and price <= $high_price";
				}
			}
			else 
			{
				if($by=='leather')
				{
					//$sql .= " and (a.short_desc like '%$text%' or a.long_desc like '%$text%')";
					$sql .= " and (short_desc like '%leather%'  or long_desc like '%leather%' ) and short_desc not like '%faux-leather%' and long_desc not like '%faux-leather%' ";
				}
				else
				{
					$sql .= " and (short_desc like '%$by%' or long_desc like '%$by%')";
				}
			}
			//echo $sql;
			
			$query = $this->db->query($sql);

		}
		else{								
			$this->db->where_in('id',$prod);
			$this->db->where('status',1);
			$this->db->where('deleted',0);
			if($sort=='latest'){
				$this->db->order_by('id','desc');
			}
			else
			{
				$this->db->order_by($sort,'asc');
			}
			if($limit==0 && $row==0){}
			else
			{$this->db->limit($row,$limit);	}
			$query = $this->db->get('products');
		}
		return $query->result_array();
		
	}
	
	function get_product_promotion($cat,$id,$sort,$limit,$row)
	{
		$this->db->where('promotion_id',$id);
		$query = $this->db->get('promotions_product');
		$all_prod = $query->result_array();	
		
		$cc = 0;
		$prod = Array();
		foreach($all_prod as $ap)
		{
			$prod[$cc] = $ap['product_id'];
			$cc++;
		}
		if(count($prod)==0){$prod[]=0;}
		
		$this->db->where_in('id',$prod);
		$this->db->where('status',1);
		$this->db->where('deleted',0);
		if($sort=='latest'){
			$this->db->order_by('id','desc');
		}
		else
		{
			$this->db->order_by($sort,'asc');
		}
		if($limit==0 && $row==0){}
		else
		{$this->db->limit($row,$limit);	}
		$query = $this->db->get('products');
		
		return $query->result_array();
		
	}
}
?>