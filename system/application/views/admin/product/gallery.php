<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?=base_url()?>css/backend.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/popup.css' />	
<script> var $j = jQuery.noConflict(); </script>
<title><?=$product['title']?> - Product Gallery</title>
<style>
body { background:#E8EDF2; }
</style>
<script>
function upload() {
	document.uploadForm.submit();
	centerPopup();
	loadPopup();
}
function deletephoto(id) {
	if(confirm('Are you sure you want to delete this photo?')) {
		window.location = '<?=base_url()?>admin/store/deletephoto/' + id;
	}
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
    	<h3>Add new image</h3>
        <p class="desc">Add new image by browsing your computer and uploading them. Please upload an image with size of <b>710 pixel width</b> and <b>775 pixel height</b> for the best view.</p><br />
        <form name="uploadForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/store/uploadimage">
        <input type="hidden" name="product_id" value="<?=$product['id']?>" />
        <dl class="two"><dt>Upload image</dt><dd><input type="file" name="userfile" /></dd></dl>
        <dl class="two"><dt>&nbsp;</dt>
        	<dd><input type="button" class="button rounded" value="Upload" onclick="upload()" /></dd></dl>
        <?php if($this->session->flashdata('error_upload')) { ?>
        <dl class="two"><dt>&nbsp;</dt>
        	<dd class="error"><?=$this->session->flashdata('error_upload')?></dd></dl> <?php } ?>
        <dl></dl>
        </form>
    </div>
    <hr />
    <div class="box">
    	<div class="hero">
        	<?php if($hero) { ?>
            <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>" />
            <?php } else { ?>
            	<p>No hero image</p>
            <?php } ?>
        </div>
        <div class="thumbnails">
        	<h3>Product images</h3>
            <p class="desc">Your “Hero Image” is resized to accommodate all thumbnail images in the site and will be the main large image used on the product details page.You can add as many images as you like although only the hero image and the first three images will be displayed on the product details page. Other images will be available for view when a thumbnail image is clicked and the full product gallery is available.</p>
            <?php $n = 0; foreach($photos as $photo) { $n++; ?>
          <div class="photo<?php if($n>3) print ' extend'; ?>">
            	<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb3/<?=$photo['name']?>" />
                <div class="nav">
                	<a href="<?=base_url()?>admin/store/makeheroimage/<?=$photo['id']?>" title="Make this hero image"><img src="<?=base_url()?>img/backend/icon-hero.png" /></a><a href="javascript:deletephoto(<?=$photo['id']?>)" title="Delete this image"><img src="<?=base_url()?>img/backend/icon-delete.png" /></a><?php if($n>1) { ?><a href="<?=base_url()?>admin/store/movephoto/<?=$photo['id']?>/-1" title="Move this image to left"><img src="<?=base_url()?>img/backend/icon-moveleft.png" /></a><?php } if($n < count($photos)) { ?><a href="<?=base_url()?>admin/store/movephoto/<?=$photo['id']?>/1" title="Move this image to right"><img src="<?=base_url()?>img/backend/icon-moveright.png" /></a><?php } ?>
                </div>
          </div>
            <?php } ?>
    	</div>
	</div>
</div>
</body>
</html>
