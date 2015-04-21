<script>
jQuery(function() {
	jQuery('.galleries-thumb *').tooltip({
		showURL: false
	});
	
});
var choose = 0;
function deletegallery(id)
{
	//alert(id);
	choose = id;
	$('#deleteModal').modal('show');
}
function delete_gallery(id)
{
	var url = "<?=base_url()?>admin/cms/delete_gallery/";
		url = url + id;
		//alert(url);
		
		jQuery.ajax({
		url: url,
		success: function(html) {
			if (html == 'Ok') {
						jQuery("#gallery-" + id).fadeOut("normal");
						$('#deleteModal').modal('hide');
					}
					else {
						alert("There was an error when deleting this gallery");
					}
			
		}
	})
}
</script>
<style>
.gallery-thumbs
{
	clear:both;
}
.galleries-thumb
{
	float: left; height: 175px;
    /*margin: 10px 10px 0 0;*/
    opacity: 0.8;
    text-align: center;
    width: 140px;
}
.galleries-thumb:hover
{
	opacity: 1;
}
</style>
<div class="span9">

	<div style="min-height: 433px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

			<h1 style="padding-left: 7px;">Create Image Galleries</h1>
			
            <form style="margin-left:6px" name="createGalleryForm" method="post" action="<?=base_url()?>admin/cms/create_gallery">
				<?php if ($this->session->flashdata('error_cg')) {
                    print '<span class="error">ERROR: Please enter a name for new gallery</span>';
                } ?>
                <div>
                	<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Title</div>
                    <div style="width: 80%; float: right">						
                        <!--<button class="btn btn-primary" type="button" onclick="upload()">Upload</button>-->
                        <input style="width: 97%" class="textfield rounded" type="text" name="title" />
                    </div>
            	</div>
            	<div style="height: 5px; clear: both">&nbsp;</div>                
                <div>
                    <div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
                    <div style="width: 80%; float: right">						
                        <button class="btn btn-primary" type="button" onclick="document.createGalleryForm.submit()">Create</button>
                    </div>
            	</div>
            	<div style="height: 5px; clear: both">&nbsp;</div>          
                <!--<a href="#"><input type="button" class="button rounded" value="Create" onClick="document.createGalleryForm.submit()" /></a>-->
            </form>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            
            <div class="gallery-thumbs">
				<?php foreach($galleries as $gallery)
                {//echo $thumbnails[$gallery['id']];
                   
                ?>
                         
                    <div class="galleries-thumb" id="gallery-<?=$gallery['id']?>" style="margin: 10px 15px 40px 5px !important;">
                        <div style="background-color:#fff;  border:1px solid #ccc; width:145px; height:180px; padding:3px; margin-right:3px;">
                        <?=$thumbnails[$gallery['id']]?>
                        <!--
                        <div class="icon">
                            <a href="<?=base_url()?>admin/cms/galleries/<?=$gallery['id']?>"><img src="<?=base_url()?>images/icon-box-edit.png" title="Edit this gallery" /></a>
                            <a href="#"><img src="<?=base_url()?>images/icon-box-delete.png" title="Delete this gallery" onclick="return delete_gallery(<?=$gallery['id']?>)" /></a>
                        </div>
                        -->
                         <div style="padding-top:10px;">
                         	<?php
                         		$loc1 = base_url().'admin/cms/galleries/'.$gallery['id'];
                         	?>
                                <div onclick="window.location='<?php echo $loc1; ?>'"  data-toggle="tooltip" title="Edit Gallery" style="float:left; cursor:pointer">
                                    <!--<img src="<?=base_url()?>img/pencil.png" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;">-->
                                    <i class="icon-edit icon-3x" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;"></i>
                                </div>

                                <div data-toggle="tooltip" title="Delete Gallery" onclick="return deletegallery(<?=$gallery['id']?>)" style="float:right; cursor:pointer; color:555!important;">
                                    <!--<img src="<?=base_url()?>img/bin.png" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;">-->
                                    <i class="icon-trash icon-3x" style=" border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;"></i>
                                </div>
                                <div style="clear: both"></div>
                        </div>
                        </div>
                    </div>
                    
                <?php
                   
                }
                ?>
            </div>
            <div class="gallery-end"></div>
            
			<!-- end here -->

		</div>

	</div>

</div>

<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Gallery</h3>
</div>
<div class="modal-body">
    <p>It will delete all photos and videos of this gallery. Are you sure you want to do this?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="delete_gallery(choose)">Delete</button>

</div>
</div>