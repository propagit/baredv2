<form name="featureForm" id="featureForm">
    <h2 style="padding-left:7px;">Products List</h2>
    <div style="margin-top: 10px;" class="list_line"></div>
    <table class="table table-hover">
    <thead>
        <tr style="font-size: 15px">
            <th style="width: 85%">Product name</th>
            <th style="width: 15%; text-align: center;">Add</th>				
        </tr>
    </thead>
            
    <tbody id="subcat">		        
    <?php 
	if($products){
    foreach($products as $product) { 
        if (!$this->Product_model->is_feature($product['id']) && $product['deleted'] == 0 && $product['status'] == 1) {		
	?>
        <tr>
            <td><?=$product['title'];?></td>
            <td style="text-align: center;">
                &nbsp; <input type="checkbox" value="<?=$product['id'];?>" name="products[]" /> &nbsp;
            </td>
        </tr> 
	<?php		}
            } 
        } 
	?>
    </tbody>		
    </table>

    <p align="right">
    	<select name="home_category" style="margin-bottom:0;">
            <option  value="<?=MEN?>">Male</option>
            <option  value="<?=WOMEN?>">Female</option>
        </select> 
        <button class="btn btn-primary" type="button" onclick="add_feature_products();">Add Products</button>
    </p>        
</form>



<script>
function add_feature_products(){
	$.ajax({
			url:'<?=base_url();?>admin/store/addfeature',
			type:'POST',
			dateType:'html',
			data:$('#featureForm').serialize(),
			success:function(html){
				//location.reload();
			}
		});	
}
</script>