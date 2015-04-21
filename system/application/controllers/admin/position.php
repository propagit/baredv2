<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends Controller {
	
	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('kiotiahraloggedin')) {
			redirect('admin/login');
		}
		
		$this->load->model('Category_model');				
		$this->load->model('Position_model');   	
	}
	
	function index()
	{
		$data['main'] = $this->Position_model->get_main();
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/leftbar');
		$this->load->view('admin/position/position',$data); 
		$this->load->view('admin/common/footer');
	}
	function searchproductposition() {
		
		$category = $_POST['category'];
		$keyword='';
		$products = $this->Position_model->search($keyword,$category,true);		
		//<input type="checkbox" value="'.$product['id'].'" name="products[]" />
		if($category!=0)
		{
			$cats = $this->Position_model->identify_category($category);
			$cats_product=$cats['order_position'];
			
		}
		$out = '
    	<div class="box">
    		<form name="featureForm" method="post" action="'.base_url().'admin/position/updatefeature">
        	<div style="clear:both; float:none;">
			<h2 style="padding-left:7px;float:left;">Products List</h2><div id="notes" style="float:left;margin-top:22px;margin-left:20px;"></div><button class="btn btn-primary" type="button"  style="float:right;margin-top:15px;" onClick="update_product();">Update Products</button>
			</div>
			<div style="clear:both;"></div>
        	<div style="margin-top: 10px;" class="list_line"></div>
			
			<input type="hidden" name="pos_cat" id="pos_cat" value="'.$category.'">
			
			<table class="table table-striped">
			<thead>
				<tr style="font-size: 15px">
					<th style="width: 75%">Product name</th>
					<th style="width: 15%; text-align: center;">Position</th>	
					<th style="width: 10%; text-align: center;">Position</th>				
				</tr>
			</thead>
					
			<tbody id="subcat" class="sorted_table">';			        
		$prod=array();
		$prods=array();
		foreach($products as $product)
		{			
			$prods[]=$product['id'];
			
		}
		if($cats_product!='' && $category!=0)
		{
			$ind=json_decode($cats_product);
			foreach($ind as $id)
			{
				if(in_array($id, $prods) && !in_array($id, $prod)){
					$prod[]=$id;
				}
			}
			
		}

		foreach($products as $product)
		{			
			if(!in_array($product['id'], $prod)){
				$prod[]=$product['id'];
			}
		}
		$num=1;
		$ind2=json_encode($prod);
		$data=array('order_position'=>$ind2);
		$this->Position_model->update_category($category,$data);
		foreach($prod as $pt) { 
			$product=$this->Position_model->identify_product($pt);
			if ( $product['deleted'] == 0 && $product['status'] == 1) {
			$out .= '			
			<tr class="tr_cat" id="cat-'.$product['id'].'">
				<td>'.$product['title'].' '.$product['short_desc'].'</td>
				<td style="text-align: center;">
					&nbsp; <a href="#" onclick="change_position('.$product['id'].')"><i class="icon-list-ol"></i></a>  &nbsp;
				</td>
				<td style="text-align: center;"><span class="badge badge-info">'.$num.'</span>
					
				</td>
			</tr> 
			
			'; $num++;
            	} 
			
			}
		$out .= '
			</tbody>		
			</table>
	
			<p align="right">
				
				<button class="btn btn-primary" type="button" onClick="update_product();">Update Products</button>
			</p>        
			</form>
    	</div>
    	';
		print $out;
	}
	
	function update_order()
	{
		$category=$this->input->post('category');
		$index = $this->input->post('indx');
		$cat_s='';
		if($category==26){$cat_s=2;}
		if($category==33){$cat_s=3;}
		$ind2=json_encode($index);

		$data=array('order_position'=>$ind2);
		
		$this->Position_model->update_category($category,$data);
		if($cat_s==2 || $cat_s==3){
			$this->Position_model->update_category($cat_s,$data);
		}
		
	}
}