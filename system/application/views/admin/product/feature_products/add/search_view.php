<form name="featureForm" method="post" action="<?=base_url();?>admin/store/addfeature">
    <h2 style="padding-left:7px;">Products List</h2>
    <div style="margin-top: 10px;" class="list_line"></div>

    
    <div class="app-list">
    	<div class="th">
        	<div class="td td-name"><strong>Product name</strong></div>
            <div class="td td-checkbox"><strong>Add</strong></div>
        </div>
        
        <?php 
		if($products){
		#echo '<pre>'.print_r($products,true).'</pre>';exit;
		foreach($products as $product) { 
			if (!$this->Product_model->is_feature($product['id']) && $product['deleted'] == 0 && $product['status'] == 1) {		
		?>
        
        	<div class="tr">
                <div class="td td-name"><?=$product['title'] . ' - ' . $product['short_desc'];?></div>
                <div class="td td-checkbox"><input type="checkbox" value="<?=$product['id'];?>" name="products[]" /></div>
            </div>
		<?php		}
				} 
			} 
	?>
    	
    </div>
    

    <p align="right">
    	<select name="home_category" style="margin-bottom:0;">
            <option  value="<?=MEN?>">Male</option>
            <option  value="<?=WOMEN?>">Female</option>
        </select> 
        <button class="btn btn-primary" type="button" onClick="document.featureForm.submit()">Add Products</button>
    </p>        
</form>
