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
			url:'<?=base_url();?>admin/cms/ajax_get_feature_product_by_category',
			type:'POST',
			dateType:'html',
			data:{category:category},
			success:function(html){
				jQuery('#feature-products').html(html);
			}
		});	
}

jQuery(function(){
get_products_by_category();

});
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1 style="padding-left: 7px">Feature Products</h1>
                        <h2 style="padding-left: 7px;">Filter Banners</h2>
                        <select name="product-category" id="product-filter" onChange="get_feature_products_by_category();" style="display: inherit; margin-bottom: 10px;">
                            <option  value="all">All</option>
                            <option  value="1">Male</option>
                            <option  value="2">Female</option>
                        </select> 
                        <div id="feature-products">
            <?php $n = 0; if($features) 
					foreach($features as $product) 
					{ $n++; ?>
                  <div class="box_container" style="padding-left:7px; float: left">
                    <div class="item" style="float:left;padding-right:10px;">
                    <?php $hero = $this->Product_model->get_hero($product['id']); 
                        if ($hero) 
						{ ?>
                        <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb3/<?=$hero['name']?>" />                
                        <?php } else { ?>
                        <img src="http://placehold.it/89x97"/> 
                        <?php } ?>
                        
                    <div class="nav" style="margin-top:10px;" >
                            <a href="javascript:removefeature(<?=$product['id']?>)" style="text-decoration:none;" data-toggle="tooltip" title="Remove this item"><i class="icon-trash icon-2x"></i></a>
							<?php if($n>1) { ?><a style="text-decoration:none;" data-toggle="tooltip" title="Move this item" href="<?=base_url()?>admin/store/movefeature/<?=$product['id']?>/-1"><i class="icon-circle-arrow-left icon-2x"></i></a><?php } ?>
							<?php if($n<count($features)) { ?><a style="text-decoration:none;" data-toggle="tooltip" title="Move this item" href="<?=base_url()?>admin/store/movefeature/<?=$product['id']?>/1"><i class="icon-circle-arrow-right icon-2x"></i></a><?php } ?>
                    </div>
                    </div>
                    
                  </div>
                        </div>
                    <?php 
					} ?>
                    
                    <?php if($this->session->flashdata('addft_true')) { ?>
                    <p class="error">Error: maximum 6 features products in the homepage</p>
                    <?php 
					} ?>                    
                
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
                <div class="box bgw">
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