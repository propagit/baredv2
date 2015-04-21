<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">

<link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet" media="screen">

<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bootstrap-tree.css" rel="stylesheet" media="screen">
<!-- <link href="<?=base_url()?>css/datepicker.css" rel="stylesheet" media="screen"> -->
<link href="<?=base_url()?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/jasny-bootstrap.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/admin.css" rel="stylesheet" media="screen">

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

<style>
h1{
	font-size: 20px !important;
    font-weight: 900;
    color: #000;
}
h2{
	font-weight : 700;
	font-size:18px!important;
	color: #333
}
.line-between
{
	height: 0px; 
	clear: both; 
	border-top:1px solid #ccc;
}
th
{
	font-weight : 700 !important;
	font-size:15px!important;
}
</style>

</head>



<body>

	<script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>

	<script src="<?=base_url()?>js/bootstrap.js"></script>
    <script src="<?=base_url()?>js/bootstrap-select.js"></script>
    <script src="<?=base_url()?>js/bootstrap-tree.js"></script>
    <script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?=base_url()?>js/jasny-bootstrap.js"></script>
    <script src="<?=base_url()?>js/ckeditor.js"></script>
    <script src="<?=base_url()?>js/config.js"></script>
    <script src="<?=base_url()?>js/styles.js"></script>
    <!-- <script src="<?=base_url()?>js/build-config.js"></script> -->
    <script src="<?=base_url()?>ckfinder/ckfinder.js"></script>
    <script src="<?=base_url()?>ckfinder/config.js"></script>
    <!-- <script src="<?=base_url()?>js/bootstrap-datepicker.js"></script> -->

	<!-- start here -->
	

<script>
function upload() {
	document.uploadForm.submit();
	centerPopup();
	loadPopup();
}
function deletephoto(id) {
	if(confirm('Are you sure you want to delete this photo?')) {
		window.location = '<?=base_url()?>admin/new_store/deletephoto/' + id;
	}
}
</script>
<div class="span12">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">		

			<h1 style="padding-left: 7px;">
				Add New Image
			</h1>
            <div style="padding-left:7px;">
            <p class="desc">Add new image by browsing your computer and uploading them. Please upload an image with size of <b>710 pixel width</b> and <b>775 pixel height</b> for the best view.</p>
            
            <form name="uploadForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/new_store/uploadimage">
            <input type="hidden" name="product_id" value="<?=$product['id']?>" />
            <div style="padding-left: 0px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Upload image</div>
                <div style="width: 80%; float: right">                                        
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                    </div>
                </div>
            </div>
            
            
            
            
            
            <div style="height: 5px; clear: both">&nbsp;</div>
            <div style="padding-left: 0px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
                <div style="width: 80%; float: right">						
                    <button class="btn btn-primary" type="button" onclick="upload()">Upload</button>
                </div>
            </div>
            <div style="height: 5px; clear: both">&nbsp;</div>                
            
            <?php if($this->session->flashdata('error_upload')) { ?>
            <div class="error"><?=$this->session->flashdata('error_upload')?></div> <?php } ?>
            
            </form>
            
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            <div style="height: 10px; clear: both;">&nbsp;</div>                
            </div>
            <?php if($hero) { ?>
            <img style="border: 1px solid #ccc; margin-left: 7px;" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>" />
            <?php } else { ?>
            	<!-- <p>No hero image</p> -->
            	<img class="hidden-phone" src="http://placehold.it/710x775"/>
            <?php } ?>
            
            <div class="thumbnails" style="padding-left:7px; margin-left: 0" >
        	<h2 style="padding-left:7px;">Product images</h2>
            <p class="desc" style="padding-left: 7px;">Your “Hero Image” is resized to accommodate all thumbnail images in the site and will be the main large image used on the product details page.You can add as many images as you like although only the hero image and the first three images will be displayed on the product details page. Other images will be available for view when a thumbnail image is clicked and the full product gallery is available.</p>
            <?php $n = 0; foreach($photos as $photo) { $n++; ?>
          	<div style="float: left; margin-right: 10px" class="photo<?php if($n>3) print ' extend'; ?>">
            	<img  src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb2/<?=$photo['name']?>" />
                <div class="nav" style="text-align: center">
                	<a style="text-decoration: none" href="<?=base_url()?>admin/new_store/makeheroimage/<?=$photo['id']?>" title="Make this hero image">
                		<!-- <img src="<?=base_url()?>img/backend/icon-hero.png" /> -->
                		<i class="icon icon-heart"></i>
                	</a>
                	<a style="text-decoration: none" href="<?=base_url()?>admin/new_store/makemodal/<?=$photo['id']?>" title="Make this image shoot model">
                		<!-- <img src="<?=base_url()?>img/backend/icon-hero.png" /> -->
                		<i <?php if($photo['modal'] == 1){echo "style='color:green'";}?> class="icon icon-flag"></i>
                	</a>
                	<a style="text-decoration: none" href="javascript:deletephoto(<?=$photo['id']?>)" title="Delete this image">
                		<!-- <img src="<?=base_url()?>img/backend/icon-delete.png" /> -->
                		<i class="icon  icon-remove-sign"></i>
                	</a>
                	<?php if($n>1) { ?>
                		<a style="text-decoration: none" href="<?=base_url()?>admin/new_store/movephoto/<?=$photo['id']?>/-1" title="Move this image to left">
                			<!-- <img src="<?=base_url()?>img/backend/icon-moveleft.png" /> -->
                			<i class="icon  icon-circle-arrow-left"></i>
                		</a>
                	<?php } if($n < count($photos)) { ?>
                		<a style="text-decoration: none" href="<?=base_url()?>admin/new_store/movephoto/<?=$photo['id']?>/1" title="Move this image to right">
                			<!-- <img src="<?=base_url()?>img/backend/icon-moveright.png" /> -->
                			<i class="icon  icon-circle-arrow-right"></i>
                		</a>
                	<?php } ?>
                </div>
          	</div>
            <?php } ?>
            <div style="clear: both"></div>
            </div>
		</div>
		
    </div>

</div>          
</body>