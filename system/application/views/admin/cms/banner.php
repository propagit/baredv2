<link href="<?=base_url()?>css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
<script src="<?=base_url()?>js/bootstrap-fileupload.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" rel="stylesheet" media="screen" />
<script> var $j = jQuery.noConflict(); </script>
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/popup.css' />


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
            <span><em>Ideal image size: 1300px x 610px<br>All image should be of same width & height for optimum result.</em></span><br><br>
            
           Add a new image banner by browsing your computer and uploading a file. The image files accepted for upload include, (.jpg , .gif , .png) Enter a web link in the space provided to create a click through for you image. Images can be published and unpublished by clicking the tick icon. To delete a banner click the red cross.
           	
            
            </p>
            
            <div style="height: 10px; clear: both">&nbsp;</div>
            <form name="uploadForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/uploadbanner"> 
            <div style="padding-left: 7px;">
                <div style="width: 20%; float: left; height: 30px;">Banner Category</div>
                <div style="width: 80%; float: right">                    
                    <select name="banners-category">
                      <option  value="<?=MEN?>">Male</option>
                      <option  value="<?=WOMEN?>">Female</option>
                     </select>    
                </div>
            </div>
            <div style="height: 10px; clear: both">&nbsp;</div>
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
            <div style="padding-left: 7px;">
                <div style="width: 20%; float: left; height: 30px; line-height: 52px;">Set Caption</div>
                <div style="width: 80%; float: right">                    
                <input type="text" class="textfield rounded" style="margin-bottom:0px!important;" name="caption" value="" />   
                    
                </div>
            </div>
            <div style="height: 5px; clear: both">&nbsp;</div>
            <?php if(1){?>
            <div style="padding-left: 7px; display:none;">
                <div style="width: 20%; float: left; height: 30px; line-height: 30px; display:none;">Template Homepage</div>
                <div style="width: 80%; float: right; display:none;">						
                    <select name="banner_template" id="banner_template" onchange="change_banner()">
                    	<option value="1" <? if($temp==1){?> selected="selected" <? } ?>>Template 1 (1200 x 600)</option>
                        <option value="2" <? if($temp==2){?> selected="selected" <? } ?>>Template 2 (1200 x 920)</option>
                    </select>
                </div>
            </div>
            <div style="height: 5px; clear: both">&nbsp;</div>
            <?php } ?>
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
            <?php if(0){ ?>
            <!--<div style="float:none;">
            	<? if($temp==2){?>
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
            <div style="height: 10px; clear: both">&nbsp;</div> --> 
            <?php } ?>
            <div style="padding-left:7px;"> 
            <div>        
           	  <h2>Filter Banners</h2>
              <?php
			  $banner_cur_cat = 'all'; 
			  if($this->session->userdata('banner_cur_category')){
				  $banner_cur_cat = $this->session->userdata('banner_cur_category');
			  }
			  ?>
              <select id="banners-filter" onChange="get_banners_by_category();">
                  <option  value="all" <?=$banner_cur_cat == 'all' ? 'selected="selected"' : '';?>>All</option>
                  <option  value="<?=MEN?>" <?=$banner_cur_cat == MEN ? 'selected="selected"' : '';?>>Male</option>
                  <option  value="<?=WOMEN?>" <?=$banner_cur_cat == WOMEN ? 'selected="selected"' : '';?>>Female</option>
         	  </select> 
              
              <div style="height: 20px; clear: both; border-top:1px solid #ccc; padding-top:20px; margin-top:20px;">&nbsp;</div>
            </div>   
			<table>
            	<tbody id="banners-rows">
                
                </tbody>
            </table>
            </div>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            <div style="height: 10px; clear: both">&nbsp;</div>
			<!-- end here -->

		</div>

	</div>

</div>
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
    
function get_banners_by_category(){
	var category = jQuery('#banners-filter').val();
	jQuery.ajax({
			url:'<?=base_url();?>admin/cms/ajax_get_banners_by_category',
			type:'POST',
			dateType:'html',
			data:{category:category},
			success:function(html){
				jQuery('#banners-rows').html(html);
			}
		});	
}

jQuery(function(){
	get_banners_by_category();
});


function update_banner(banner_id)
{
	jQuery.ajax({
			url:'<?=base_url()?>admin/cms/updatebanner',
			type:'POST',
			dateType:'html',
			data:jQuery('#update-form-'+banner_id).serialize(),
			success:function(html){
				if(html == 'ok'){
					jQuery('#update-msg-'+banner_id).removeClass('hide');
					setTimeout(function(){
						jQuery('#update-msg-'+banner_id).addClass('hide');	
					},3000)	
				}
			}
		});	
}

function change_status(banner_id)
{
	jQuery.ajax({
			url:'<?=base_url()?>admin/cms/activebanner',
			type:'POST',
			dateType:'html',
			data:{banner_id:banner_id},
			success:function(html){
				if(html == 'ok'){
					get_banners_by_category();
				}
			}
		});	
}


</script>


