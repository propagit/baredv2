<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" rel="stylesheet" media="screen" />
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/popup.css' />
<script>
$j(function() {
	$j('.thumb a').lightBox();	
});
function upload() {
	document.uploadForm.submit();
	centerPopup();
	loadPopup();
}
function deletebanner(id) {
	if (confirm('Are you sure you want to delete this banner?')) {
		window.location = '<?=base_url()?>admin/store/deletebanner/' + id;
	}
}
</script>
<div id="popup-box" class="loading">
	<h1>uploading...</h1>
    <p><img src="<?=base_url()?>img/loading.gif" /></p>
</div>
<div id="background-popup"></div>

    	<div class="left">
        	<h1>Store Management</h1>
            <div class="bar">

            	<div class="text">Manage Banners</div>
            	<div class="cr"></div>
            </div>
            <div class="box">
            	<h3>Add new banner</h3>
                <p class="desc">Add new banner by browsing your computer and uploading them. Please upload an image with size of <b>671 pixel width</b> and <b>298 pixel</b> height for the best view.</p><br />
                <form name="uploadForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/store/uploadbanner">
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
            <div class="box bgw">
            	<?php foreach($banners as $banner) { ?>
            	<div class="banner">
                	<div class="thumb"><a href="<?=base_url()?>uploads/banners/<?=$banner['name']?>"><img width="315" height="117" src="<?=base_url()?>uploads/banners/thumb/<?=$banner['name']?>" /></a></div>
                    <div class="action">
                    	<form method="post" action="<?=base_url()?>admin/store/updatebanner">
                        <input type="hidden" name="banner_id" value="<?=$banner['id']?>" />
                    	<p>Link to when click (<?=$banner['hit']?> times)</p>
                        <p><input type="text" class="textfield rounded" name="url" value="<?=$banner['url']?>" /></p>
                        <p><input type="submit" class="button rounded" value="Update" /></p>
                        </form>
                        <div class="icon">
                        	<a href="<?=base_url()?>admin/store/activebanner/<?=$banner['id']?>" title="Active this banner"><img src="<?=base_url()?>img/backend/icon-<?php if(!$banner['actived']) print 'in'; ?>actived.png" /></a>
                            <a href="javascript:deletebanner(<?=$banner['id']?>)"><img src="<?=base_url()?>img/backend/icon-delete.png" /></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        
