<?php
class Order_model extends Model {
	function __construct() {
		parent::Model();
	}
	function add($data) {
		$this->db->insert('orders',$data);
		return $this->db->insert_id();
	}
	function add_paypal_txn($data) {
		$this->db->insert('paypal_txn',$data);
		return $this->db->insert_id();
	}
	function update_paypal_txn($id,$data) {
		$this->db->where('session_id',$id);
		$this->db->update('paypal_txn',$data);
	}
	function save_paypal($data) {
		$this->db->insert('paypal_txn',$data);
		return $this->db->insert_id();
	}
	function get_txn($id) {
		$this->db->where('custom',$id);
		$query = $this->db->get('paypal_txn');
		return $query->first_row('array');
	}
	function get_txn_session($id) {
		$this->db->where('session_id',$id);
		$query = $this->db->get('paypal_txn');
		return $query->first_row('array');
	}
	function identify($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('orders');
		return $query->first_row('array');
	}
	function all_not_export()
	{
		$this->db->where('export',0);
		$this->db->where('status','successful');		
		$query = $this->db->get('orders');
		return $query->result_array();
	}
	function identify_promotioncode($code,$custid) {
		$this->db->where('coupon_code',$code);	
		$this->db->where('customer_id',$custid);
		$this->db->where('status','successful');	
		$query = $this->db->get('orders');
		return $query->result_array();
	}
	function update($id,$data) {
		$this->db->where('id',$id);
		$this->db->update('orders',$data);
	}
	function delete($id) {
		$this->db->where('id',$id);
		$this->db->delete('orders');
	}
	function delete_all($customer_id) {
		$this->db->where('customer_id',$customer_id);
		$this->db->delete('orders');
	}
	function last($limit) {
		$this->session->set_userdata('by_typecustomer',1);
		$this->db->where('order_status !=','deleted');
		$this->db->order_by('id','desc');
		$this->db->limit($limit);
		$query = $this->db->get('orders');
		/*$type=$this->session->userdata('by_typecustomer');
		if(empty($type))
			$type=1;
		$sql="select orders.*  top $limit from orders, users where users.customer_id=orders.customer_id and users.level='$type' LIMIT $limit";
		$query=$this->db->query($sql);*/
		return $query->result_array();
	}
	function search($customer_name,$order_id,$from_date,$to_date,$by_keyword,$by_status, $by_typecustomer) {
		#$sql = "SELECT * FROM `orders` WHERE";
		if($customer_name || $order_id || $from_date || $to_date || $by_keyword)
		{
			$sql = "Select DISTINCT orders.* from orders,products,carts, users WHERE orders.session_id = carts.session_id AND products.id = carts.product_id AND orders.customer_id = users.customer_id and users.level='$by_typecustomer' ";
			
			if ($customer_name != "")
			{
				$sql .= " AND orders.firstname LIKE '$customer_name'";
			
				//$this->db->like('firstname',$customer_name);
				//$this->db->or_like('lastname',$customer_name);
				#$sql .= " (`firstname` LIKE '%$customer_name%' OR `lastname` LIKE '%$customer_name%')";
			} 
			
			if ($order_id != "")
			{
				$sql .= " AND orders.id = '$order_id'";
											
				//$this->db->where('id',$order_id);
				#$sql .= " `id` = $order_id";
			}
			
						
			if ($from_date != "") {
				//$this->db->where("DATEDIFF(DATE(`order_time`),DATE('$from_date')) >",0);
				$sql .= " AND DATEDIFF(DATE(`order_time`),DATE('$from_date'))>=0";
			}
			
			if ($to_date != "") {
				//$this->db->where("DATEDIFF(DATE('$to_date'),DATE(`order_time`)) >",0);
				$sql .= " AND DATEDIFF(DATE('$to_date'),DATE(`order_time`))>=0";
			}
						
			
			if ($by_keyword != "") {
				//do this query - by Haydn
				$sql .= " AND products.title LIKE '%$by_keyword%'";
			}
			if($by_status==1)
				$sql.= " AND orders.status ='successful'";
			$sql.=" order by orders.id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}	
		else
		{			
			$sql="select orders.* from orders, users where users.customer_id=orders.customer_id and users.level='$by_typecustomer' order by orders.id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	}
	function search_v2($customer_name,$order_id,$from_date,$to_date,$by_keyword,$by_status, $by_typecustomer,$by_payment,$by_ord_status,$cust_id) {
		#$sql = "SELECT * FROM `orders` WHERE";
		if($customer_name || $order_id || $from_date || $to_date || $by_keyword || $by_payment || $cust_id || $by_ord_status)
		{
			//$sql = "Select DISTINCT orders.* from orders,products,carts, users WHERE orders.session_id = carts.session_id AND products.id = carts.product_id AND orders.customer_id = users.customer_id and users.level='$by_typecustomer' ";
			// $sql = "Select DISTINCT orders.* from orders,products,carts,customers, users WHERE orders.session_id = carts.session_id AND products.id = carts.product_id AND orders.customer_id = users.customer_id and users.customer_id = customers.id";
			$sql = "Select orders.customer_id, orders.id, orders.total, orders.order_status, orders.order_time
					from orders,customers, products, carts
					where orders.customer_id = customers.id
					and orders.session_id = carts.session_id AND products.id = carts.product_id
					and orders.order_status != 'deleted'";
			if ($customer_name != "")
			{
				$sql .=" AND (CONCAT(customers.firstname, ' ', customers.lastname) LIKE '%$customer_name%' OR customers.lastname LIKE '%$customer_name%' OR customers.firstname LIKE '%$customer_name%')";
				
				/*$cust_name=explode(' ',$customer_name);
				if(count($cust_name)>1){
					$sql .= " AND customers.firstname = '$cust_name[0]' and customers.lastname = '$cust_name[1]'";
				}
				else{
					$sql .= " AND customers.firstname LIKE '%$customer_name%' or customers.lastname LIKE '%$customer_name%'";
				}*/
			
				//$this->db->like('firstname',$customer_name);
				//$this->db->or_like('lastname',$customer_name);
				#$sql .= " (`firstname` LIKE '%$customer_name%' OR `lastname` LIKE '%$customer_name%')";
			} 
			
			if ($order_id != "")
			{
				$sql .= " AND orders.id = '$order_id'";
											
				//$this->db->where('id',$order_id);
				#$sql .= " `id` = $order_id";
			}
			
						
			if ($from_date != "") {
				//$this->db->where("DATEDIFF(DATE(`order_time`),DATE('$from_date')) >",0);
				$from_date=date('Y-m-d',strtotime($from_date));
				$sql .= " AND DATEDIFF(DATE(`order_time`),DATE('$from_date'))>=0";
			}
			
			if ($to_date != "") {
				//$this->db->where("DATEDIFF(DATE('$to_date'),DATE(`order_time`)) >",0);
				$to_date=date('Y-m-d',strtotime($to_date));
				$sql .= " AND DATEDIFF(DATE('$to_date'),DATE(`order_time`))>=0";
			}
						
			
			if ($by_keyword != "") {
				//do this query - by Haydn
				$sql .= " AND (products.id = '$by_keyword' or products.title like '%$by_keyword%')";
			}
			if ($cust_id != "") {
				//do this query - by Haydn
				$sql .= " AND orders.customer_id = $cust_id";
			}
			/*
			if ($by_payment != "All") {
				//do this query - by Haydn
				$sql .= " AND orders.cardtype = '$by_payment'";
			}
			*/
			if ($by_ord_status != "All") {
				//do this query - by Haydn
				$sql .= " AND orders.order_status = '$by_ord_status'";
			}
			if($by_status==1)
				$sql.= " AND orders.status ='successful'";
			$sql.=" group by orders.customer_id, orders.id, orders.total, orders.order_status, orders.order_time order by orders.id desc
			limit 20";
			
			//echo $sql;
			$query = $this->db->query($sql);
			
			return $query->result_array();
		}	
		else
		{			
			//$sql="select orders.* from orders, users where users.customer_id=orders.customer_id and users.level='$by_typecustomer' order by orders.id desc";
			$sql="select orders.* from orders, users where users.customer_id=orders.customer_id and orders.order_status != 'deleted' order by orders.id desc limit 20";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	}
	
	/* 
		IMPORTANT 
			- To the Developer doing the maintenance
				- If you make change to the the function "search_v3" - Make sure the changes are reflected on the function "search_orders_for_eParcel"
				- The search_orders_for_eParcel is exaclty the same but it returns all the order details for csv export for eparcel.
					- Since it returns all the records, we do not want to change the search_v3 as it might be resource heavy for normal use.
					- search_orders_for_eParcel does not have a limit of 20 and grabs all the records
	
	*/

	function search_v3($customer_name,$order_id,$from_date,$to_date,$by_keyword,$by_status, $by_typecustomer,$by_payment,$by_ord_status,$cust_id) {
		#$sql = "SELECT * FROM `orders` WHERE";
		if($customer_name || $order_id || $from_date || $to_date || $by_keyword || $by_payment || $cust_id || $by_ord_status)
		{
			//$sql = "Select DISTINCT orders.* from orders,products,carts, users WHERE orders.session_id = carts.session_id AND products.id = carts.product_id AND orders.customer_id = users.customer_id and users.level='$by_typecustomer' ";
			// $sql = "Select DISTINCT orders.* from orders,products,carts,customers, users WHERE orders.session_id = carts.session_id AND products.id = carts.product_id AND orders.customer_id = users.customer_id and users.customer_id = customers.id";
			$sql = "Select orders.customer_id, orders.id, orders.total, orders.order_status, orders.order_time, orders.tax, orders.shipping_cost, orders.session_id
					from orders,customers, products, carts
					where orders.customer_id = customers.id
					and orders.session_id = carts.session_id AND products.id = carts.product_id
					and orders.order_status != 'deleted'";
			if ($customer_name != "")
			{
				$sql .=" AND (CONCAT(customers.firstname, ' ', customers.lastname) LIKE '%$customer_name%' OR customers.lastname LIKE '%$customer_name%' OR customers.firstname LIKE '%$customer_name%')";
				
				/*$cust_name=explode(' ',$customer_name);
				if(count($cust_name)>1){
					$sql .= " AND customers.firstname = '$cust_name[0]' and customers.lastname = '$cust_name[1]'";
				}
				else{
					$sql .= " AND customers.firstname LIKE '%$customer_name%' or customers.lastname LIKE '%$customer_name%'";
				}*/
			
				//$this->db->like('firstname',$customer_name);
				//$this->db->or_like('lastname',$customer_name);
				#$sql .= " (`firstname` LIKE '%$customer_name%' OR `lastname` LIKE '%$customer_name%')";
			} 
			
			if ($order_id != "")
			{
				$sql .= " AND orders.id = '$order_id'";
											
				//$this->db->where('id',$order_id);
				#$sql .= " `id` = $order_id";
			}
			
						
			if ($from_date != "") {
				//$this->db->where("DATEDIFF(DATE(`order_time`),DATE('$from_date')) >",0);
				$from_date=date('Y-m-d',strtotime($from_date));
				$sql .= " AND DATEDIFF(DATE(`order_time`),DATE('$from_date'))>=0";
			}
			
			if ($to_date != "") {
				//$this->db->where("DATEDIFF(DATE('$to_date'),DATE(`order_time`)) >",0);
				$to_date=date('Y-m-d',strtotime($to_date));
				$sql .= " AND DATEDIFF(DATE('$to_date'),DATE(`order_time`))>=0";
			}
						
			
			if ($by_keyword != "") {
				//do this query - by Haydn
				$sql .= " AND (products.id = '$by_keyword' or products.title like '%$by_keyword%')";
			}
			if ($cust_id != "") {
				//do this query - by Haydn
				$sql .= " AND orders.customer_id = $cust_id";
			}
			/*
			if ($by_payment != "All") {
				//do this query - by Haydn
				$sql .= " AND orders.cardtype = '$by_payment'";
			}
			*/
			if ($by_ord_status != "All") {
				//do this query - by Haydn
				$sql .= " AND orders.order_status = '$by_ord_status'";
			}
			if($by_status==1)
				$sql.= " AND orders.status ='successful'";
			$sql.=" group by orders.customer_id, orders.id, orders.total, orders.order_status, orders.order_time order by orders.id desc
			limit 20";
			
			//echo $sql;
			$query = $this->db->query($sql);
			
			return $query->result_array();
		}	
		else
		{			
			//$sql="select orders.* from orders, users where users.customer_id=orders.customer_id and users.level='$by_typecustomer' order by orders.id desc";
			$sql="select orders.* from orders, users where users.customer_id=orders.customer_id and orders.order_status != 'deleted' order by orders.id desc limit 20";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	}

	function search_orders_for_eParcel($customer_name,$order_id,$from_date,$to_date,$by_keyword,$by_status, $by_typecustomer,$by_payment,$by_ord_status,$cust_id) {
		if($customer_name || $order_id || $from_date || $to_date || $by_keyword || $by_payment || $cust_id || $by_ord_status)
		{
			$sql = "SELECT orders.* 
					FROM orders,customers, products, carts
					WHERE orders.customer_id = customers.id
					AND orders.session_id = carts.session_id AND products.id = carts.product_id
					and orders.order_status != 'deleted'";
			if ($customer_name != "")
			{
				$sql .=" AND (CONCAT(customers.firstname, ' ', customers.lastname) LIKE '%$customer_name%' OR customers.lastname LIKE '%$customer_name%' OR customers.firstname LIKE '%$customer_name%')";
			} 
			
			if ($order_id != "")
			{
				$sql .= " AND orders.id = '$order_id'";
			}
			
						
			if ($from_date != "") {
				$from_date=date('Y-m-d',strtotime($from_date));
				$sql .= " AND DATEDIFF(DATE(`order_time`),DATE('$from_date'))>=0";
			}
			
			if ($to_date != "") {
				$to_date=date('Y-m-d',strtotime($to_date));
				$sql .= " AND DATEDIFF(DATE('$to_date'),DATE(`order_time`))>=0";
			}
						
			
			if ($by_keyword != "") {
				$sql .= " AND (products.id = '$by_keyword' or products.title like '%$by_keyword%')";
			}
			if ($cust_id != "") {
				$sql .= " AND orders.customer_id = $cust_id";
			}
			if ($by_ord_status != "All") {
				$sql .= " AND orders.order_status = '$by_ord_status'";
			}
			if($by_status==1){
				$sql.= " AND orders.status ='successful'";
				
			}
				$sql.=" group by orders.customer_id, orders.id, orders.total, orders.order_status, orders.order_time order by orders.id desc";

			$query = $this->db->query($sql);
			
			return $query->result_array();
		}	
		else
		{			
			$sql="select orders.* from orders, users where users.customer_id=orders.customer_id and orders.order_status != 'deleted' order by orders.id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	}

	function search_period($period,$value) {
		if($period == "total") {
			$sql = "SELECT * FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')";
		} else if ($period == "month") {
			$sql = "SELECT * FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND `order_time` LIKE '$value%'";
		} else if ($period == "week") {
			$sql = "SELECT * FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND DATEDIFF(CURDATE(),DATE(`order_time`)) <= 7";
		} else if ($period == "day") {
			$sql = "SELECT * FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND date_format(`order_time`, '%Y-%m-%d') = '$value'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function sales_total() {
		$sql = "SELECT sum(`total`) as `sales` FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if ($result['sales'] != NULL) {
			return $result['sales'];
		}
		return '0.00';
	}
	function sales_month($month) {
		$sql = "SELECT sum(`total`) as `sales` FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND `order_time` LIKE '$month%'";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if ($result['sales'] != NULL) {
			return $result['sales'];
		}
		return '0.00';
	}
	function sales_year($year) {
		$sql = "SELECT sum(`total`) as `sales` FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND `order_time` LIKE '$year%'";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if ($result['sales'] != NULL) {
			return $result['sales'];
		}
		return '0.00';
	}
	function sales_week() {
		$sql = "SELECT sum(`total`) as `sales` FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND DATEDIFF(CURDATE(),DATE(`order_time`)) <= 7";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if ($result['sales'] != NULL) {
			return $result['sales'];
		}
		return '0.00';
	}
	function sales_date($date) {

		$sql = "SELECT sum(`total`) as `sales` FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND date_format(`order_time`, '%Y-%m-%d') = '$date'";
		
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if($result['sales'] != NULL) {
			return $result['sales'];
		}
		
		return '0.00';
	}
	
	function sales_date_per_state($date,$state) {
		if($state == -1)
		{
			$sql = "SELECT sum(`total`) as `sales` FROM `orders` a, `customers` b WHERE (a.`status` = 'successful' or a.status = '30 days trade')
				AND date_format(a.`order_time`, '%Y-%m-%d') = '$date' and a.customer_id = b.id";
		}
		else
		{
			$sql = "SELECT sum(`total`) as `sales` FROM `orders` a, `customers` b WHERE (a.`status` = 'successful' or a.status = '30 days trade')
				AND date_format(a.`order_time`, '%Y-%m-%d') = '$date' and a.customer_id = b.id and a.state = $state";
		}
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if($result['sales'] != NULL) {
			return $result['sales'];
		}
		
		return '0.00';
	}
	
	function sales_date_list($date) {

		$sql = "SELECT * FROM `orders` WHERE (`status` = 'successful' or status = '30 days trade')
				AND date_format(`order_time`, '%Y-%m-%d') = '$date'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array('array');
		// if($result['sales'] != NULL) {
			// return $result['sales'];
		// }
		
		return $result;
	}

	function get_paypal_order_by_session_id($sesson_id)
	{
		$order = $this->db->where('session_id',$sesson_id)
						 ->where('msg','Paypal')
						 ->order_by('id','desc')
						 ->get('orders')
						 ->first_row('array');
		return $order;
	}

	function get_order_qty($session_id)
	{
		$sql = "SELECT SUM(quantity) as qty
				FROM carts c 
				WHERE c.session_id = '" . $session_id . "'";
		$row = $this->db->query($sql)->row_array();
		if($row){
			return $row['qty'];	
		}
		return 0;
	}
}
?>