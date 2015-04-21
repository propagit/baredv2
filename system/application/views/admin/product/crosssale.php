<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?=base_url()?>css/backend.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/popup.css' />	
<script> var $j = jQuery.noConflict(); </script>
<title><?=$product['title']?> - Product Cross Sale Items</title>
<style>
body { background:#E8EDF2; }
</style>
<script>
function removecrosssale(id) {
	if(confirm('Are you sure you want to remove this item from cross sale list?')) {
		window.location = '<?=base_url()?>admin/store/removecrosssale/' + id;
	}
}
function searchproduct() {
	var keyword = $j('#keyword').val();
	var category = $j('#category').val();
	$j.ajax({
		url: '<?=base_url()?>admin/store/searchcrosssale/',
		type: 'POST',
		data: ({product_id:'<?=$product['id']?>',keyword:keyword,category:category}),
		dataType: "html",
		success: function(html) {
			$j('#addcrosssale').html(html);
		}
	})
}
</script>
</head>

<body>
<div id="popup-box" class="loading">
	<h1>uploading...</h1>
    <p><img src="<?=base_url()?>img/loading.gif" /></p>
</div>
<div id="background-popup"></div>
<div id="bodier">
	<div class="box bgw">
    	<h3>Related Products</h3>
        <p class="desc">Add related products to work as cross sale items when this product is displayed</p><br />
        <div class="thumb1">
        	<?php if($thumb) { ?>
        	<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb2/<?=$thumb['name']?>" />
            <p><?=$product['title']?><br /><b>$<?=$product['price']?></b></p>
            <?php } else { ?>
            No image
            <?php } ?>
        </div>
        <div class="crosssale">
        	<h3>Cross sale items</h3>
            <?php $n = 0; if($crosssales) foreach($crosssales as $crosssale) { $n++; ?>
            <div class="item">
            <?php $hero = $this->Product_model->get_hero($crosssale['related']); 
				if ($hero) { ?>
                <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$hero['product_id'])?>/thumb3/<?=$hero['name']?>" />                
                <?php } else { ?>
                No image
                <?php } ?>
                <div class="nav">
                	<a href="javascript:removecrosssale(<?=$crosssale['id']?>)" title="Remove this item"><img src="<?=base_url()?>img/backend/icon-delete.png" /></a><?php if($n>1) { ?><a href="<?=base_url()?>admin/store/movecrosssale/<?=$crosssale['id']?>/-1"><img src="<?=base_url()?>img/backend/icon-moveleft.png" /></a><?php } ?><?php if($n<count($crosssales)) { ?><a href="<?=base_url()?>admin/store/movecrosssale/<?=$crosssale['id']?>/1"><img src="<?=base_url()?>img/backend/icon-moveright.png" /></a><?php } ?>
                </div>
            </div>
            <?php } ?>
            <dl></dl>
            <?php if($this->session->flashdata('addcs_true')) { ?>
            <p class="error">Error: maximum 3 cross sale items for each product</p>
            <?php } ?>
            
        </div>
        <dl></dl>
    </div>
    <hr />
    <div class="box">
    	<h3>Search Product</h3>
        <dl class="one"><dt>Keyword</dt><dd><input type="text" class="textfield rounded" id="keyword" /></dd>
            <dd class="error"><?=$this->session->flashdata('error_input')?></dd>
        </dl>
        <dl class="one"><dt>Category</dt><dd id="position">
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
        </dd><dd><input type="button" class="button rounded" value="Search" onclick="searchproduct()" /></dd></dl>
        <dl></dl>
  	</div>
    <div id="addcrosssale">
    
    </div>
</div>
</body>
</html>
