
<link href="<?=base_url()?>css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
<script src="<?=base_url()?>js/bootstrap-fileupload.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" rel="stylesheet" media="screen" />
<script> var $j = jQuery.noConflict(); </script>
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/popup.css' />

<script>
jQuery(function() {
	jQuery('.thumb a').lightBox();	
});
function upload() {
	document.uploadForm.submit();
	centerPopup();
	loadPopup();
}
function deletebanner(id) {
	if (confirm('Are you sure you want to delete this banner?')) {
		window.location = '<?=base_url()?>admin/cms/deletebanner/' + id +'/<?=$temp?>';
	}
}
function change_banner()
{
	var id=jQuery("#banner_template").val();
	//var site=jQuery("#banner_site").val();
	var site='retail';
	window.location = '<?=base_url()?>admin/cms/banner/'+id+'/'+site;
}
</script>
<style>
.fileupload {
    	margin-bottom: 0px!important;
}
</style>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

			<h1 style="padding-left: 7px;">

				Manage Banners

			</h1>
			           
            <h2 style="padding-left: 7px;">Add new banner</h2>
            <p class="desc" style="padding-left: 7px;">
            Add a new image banner by browsing your computer and uploading a file. The image files accepted for upload include, (.jpg , .gif , .png) Enter a web link in the space provided to create a click through for you image. Images can be published and unpublished by clicking the tick icon. To delete a banner click the red cross.
            </p>
            <div style="height: 10px; clear: both">&nbsp;</div>
            <form name="uploadForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/uploadbanner">
            <div style="padding-left: 7px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Upload image</div>
                <div style="width: 80%; float: right">                    
                    <!--<input style="width: 97%" class="textfield rounded" type="file" name="userfile" />-->
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
            <div style="padding-left: 7px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Template Homepage</div>
                <div style="width: 80%; float: right">						
                    <select name="banner_template" id="banner_template" onchange="change_banner()">
                    	<option value=1 <? if($temp==1){?> selected="selected" <? } ?>>Template 1 (1200 x 600)</option>
                        <option value=2 <? if($temp==2){?> selected="selected" <? } ?>>Template 2 (1200 x 920)</option>
                    </select>
                </div>
            </div>
            <div style="height: 5px; clear: both">&nbsp;</div>
            <!--
            <div style="padding-left: 7px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Template Site</div>
                <div style="width: 80%; float: right">						
                    <select name="banner_site" id="banner_site" onchange="change_banner()">
                    	<option value="Retail" <? if($site=='Retail'){?> selected="selected" <? } ?>>Retail</option>
                        <option value="Trade" <? if($site=='Trade'){?> selected="selected" <? } ?>>Trade</option>
                    </select>
                </div>
            </div>
            
            <div style="height: 5px; clear: both">&nbsp;</div>
            -->
            <div style="padding-left: 7px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
                <div style="width: 80%; float: right">						
                    <button class="btn btn-primary" type="button" onclick="upload()">Upload</button>
                </div>
            </div>
            <div style="height: 5px; clear: both">&nbsp;</div>                
            <?php if($this->session->flashdata('error_upload')) { ?>
            <dl class="two"><dt>&nbsp;</dt>
                <dd class="error"><?=$this->session->flashdata('error_upload')?></dd></dl> <?php } ?>
            <dl></dl>
            </form>
			
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            <div style="float:none;">
            	<? if($temp==2){?>
                <h2 style="float:left;">Template 2</h2>
                <div style="float:left; margin-left:10px; margin-top:22px;">
                	(1200px X 920px) - <?=$site?>
                </div>
                <? }else if($temp==1){?>
                <h2 style="float:left;">Template 1</h2>
                <div style="float:left; margin-left:10px; margin-top:22px;">
                	(1200px X 600px) - <?=$site?>
                </div>
                <? }?>
            </div>
            <div style="height: 10px; clear: both">&nbsp;</div>                
            
			<?php foreach($banners as $banner) { ?>
            <table align="center" style="padding-left: 7px;">
            	<tr>
                	<td align="center" width="80%">
                    	<a href="<?=base_url()?>uploads/banners/<?=$banner['name']?>"><img style="width:50%;height:50%;" src="<?=base_url()?>uploads/banners/ori2/<?=$banner['name']?>" /></a>
                    </td>
                    
                    <td align="center" valign="top" width="20%">
                    <div class="icon" style="margin-left:20px;">
                            <a style="text-decoration:none;" href="<?=base_url()?>admin/cms/activebanner/<?=$banner['id']?>/<?=$temp?>/retail" title="Active this banner">                            
                            <i <?php if(!$banner['actived']){echo 'style="color: #d6d6d6"';}else {echo 'style="color: #00c717"';}?> class="icon-ok-circle icon-2x"></i>
                            </a>
                            <a style="text-decoration:none;" href="javascript:deletebanner(<?=$banner['id']?>)"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></a>
                     </div>
                    </td>
                </tr>
                <tr>
                	<td align="center" width="80%">
                    	<form method="post" action="<?=base_url()?>admin/cms/updatebanner">
                        <input type="hidden" name="banner_id" value="<?=$banner['id']?>" />
                        <div style="height: 5px; clear: both">&nbsp;</div> 
                        <p>Link to when click (<?=$banner['hit']?> times)</p>
                        <input type="text" class="textfield rounded" style="margin-bottom:0px!important;" name="url" value="<?=$banner['url']?>" />
                        <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            <div style="height: 10px; clear: both">&nbsp;</div>
                                    
            <?php } ?>
            
            
            
			<!-- end here -->

		</div>

	</div>

</div>