<script>
function removefeature(id) {
	if(confirm('Are you sure you want to remove this item from feature list?')) {
		window.location = '<?=base_url()?>admin/cms/removefeature/' + id;
	}
}
function searchproduct() {
	var keyword = jQuery('#keyword').val();
	var category = jQuery('#category').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/searchfeature',
		type: 'POST',
		data: ({keyword:keyword,category:category}),
		dataType: "html",
		success: function(html) {
			jQuery('#addfeature').html(html);
		}
	})
}
function get_feature_products_by_category(){
	var category = jQuery('#product-filter').val();
	jQuery.ajax({
			url:'<?=base_url();?>admin/cms/feature_product_view',
			type:'POST',
			dateType:'html',
			data:{category:category},
			success:function(html){
				jQuery('#feature-products').html(html);
			}
		});	
}

jQuery(function(){
	get_feature_products_by_category();
});
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1 style="padding-left: 7px">Feature Products</h1>
                        <h2 style="padding-left: 7px;">Filter</h2>
                        <?php
						  $feature_product_cur_filter = MEN; 
						  if($this->session->userdata('feature_product_cur_filter')){
							  $feature_product_cur_filter = $this->session->userdata('feature_product_cur_filter');
						  }
						?>
                        <select name="product-category" id="product-filter" onChange="get_feature_products_by_category();" style="display: inherit; margin-bottom: 10px;">
                        	 <option  value="0" <?=$feature_product_cur_filter == 0 ? 'selected="selected"' : '';?>>Select One</option>
                             <option  value="<?=MEN?>" <?=$feature_product_cur_filter == MEN ? 'selected="selected"' : '';?>>Male</option>
                 			 <option  value="<?=WOMEN?>" <?=$feature_product_cur_filter == WOMEN ? 'selected="selected"' : '';?>>Female</option>
                        </select> 
                        <div id="feature-products">
                            
                        </div>
                
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
                <div class="bgw">
            		<h2 style="padding-left:7px;">Search Product</h3>
                
                    <div style="padding-left: 7px;">
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Keyword</div>
                        <div style="width: 80%; float: right">                                        
                            <input type="text" class="textfield rounded" id="keyword" />
                        </div>
                    </div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    <div class="error"><?=$this->session->flashdata('error_input')?></div> 
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    <div style="padding-left: 7px;">
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Category</div>
                        <div style="width: 80%; float: right">                                        
                            <select id="category">
                            <option value="0">All categories</option>
                            <?php foreach($main as $maincat) { ?>
                            <option value="<?=$maincat['id']?>"><?=$maincat['title']?></option>
                            <?php $sub = $this->Category_model->get($maincat['id']);
                                foreach($sub as $subcat) { ?>
                                <option value="<?=$subcat['id']?>"><?=$maincat['title']?> &raquo; <?=$subcat['title']?></option>
                                <?php } ?>                        
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    <div style="padding-left: 7px;">
                    <div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
                    <div style="width: 80%; float: right">						
                        <button class="btn btn-primary" type="button" onclick="searchproduct()">Search</button>
                    </div>
            	</div>
                    
                
            </div>
            <div style="height: 25px; clear: both">&nbsp;</div>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>  
            <div id="addfeature">
    
            </div>
			<!-- end here -->
		</div>
	</div>
</div>