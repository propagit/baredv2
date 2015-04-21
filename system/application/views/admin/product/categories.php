<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?=base_url()?>css/backend.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script> var $j = jQuery.noConflict(); </script>
<script>
function expand(id) {
	$j('#maincat-' + id).show();
	$j('#act-' + id).html('<a href="javascript:collapse(' + id +')"><img src="<?=base_url()?>img/backend/minus.gif" /></a>');
}
function collapse(id) {
	$j('#maincat-' + id).hide();
	$j('#act-' + id).html('<a href="javascript:expand(' + id +')"><img src="<?=base_url()?>img/backend/plus.gif" /></a>');
}
function switchall() {
	var cond = $j('#allcat:checked').val();
	if (cond) {  
		$j('[id^=category-]').attr('checked',true);
	} else { 
		$j('[id^=category-]').attr('checked',false);
	}
}
function overwrite(id,parent) {
	var cond = $j('#category-' + id + ':checked').val();
	if (cond) {
		$j('#category-' + parent).attr('checked',true);
	}
}
</script>
<title><?=$product['title']?> - Product Categories</title>
<style>
#catwrap { margin:0; height:460px; overflow:auto; overflow-x:hidden; }
div.update { position:absolute; bottom:0; background:#d9e7ff; padding:0 5px 5px 5px; width:490px; }
div.update span { padding:0 0 0 10px; color:green; }
</style>
</head>
<body>
<form method="post" action="<?=base_url()?>admin/store/updatecategories">
<input type="hidden" name="product_id" value="<?=$product['id']?>" />
<div id="catwrap">
    <div class="level1"><input type="checkbox" onchange="switchall()" id="allcat" /> All categories</div>
    <?php foreach($main as $maincat) { ?>
    <div class="level2"><input type="checkbox" name="categories[]" value="<?=$maincat['id']?>" id="category-<?=$maincat['id']?>" class="cat-check"<?php if($this->Product_model->product_category($product['id'],$maincat['id'])) print ' checked="checked"'; ?> /> <span id="act-<?=$maincat['id']?>"><a href="javascript:collapse(<?=$maincat['id']?>)"><img src="<?=base_url()?>img/backend/minus.gif" /></a></span> <?=$maincat['title']?></div>
    <div id="maincat-<?=$maincat['id']?>">
    <?php $sub = $this->Category_model->get($maincat['id']);
        foreach($sub as $subcat) { ?>
        <div class="level3"><input type="checkbox" name="categories[]" value="<?=$subcat['id']?>" id="category-<?=$subcat['id']?>" class="cat-check"<?php if($this->Product_model->product_category($product['id'],$subcat['id'])) print ' checked="checked"'; ?> onchange="overwrite(<?=$subcat['id']?>,<?=$maincat['id']?>)" /> <?=$subcat['title']?></div>
        <?php } ?>
    </div>
    <?php } ?>    
</div>
<div class="update">
	<input type="submit" class="button rounded" value="Update" />
    <?php if($this->session->flashdata('update')) { ?>
    <span>You have updated successfully!</span>
    <?php } ?>
</div>
</form>
</body>
</html>
