<script>
function save_story()
{
	var title = jQuery('#title').val();
	var links = jQuery('#link').val();
	var promo_description = jQuery('#promo_description').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/new_system/adding_promo/',
		type: 'POST',
		data: {title:title,story_description:story_description,links:links},			
		dataType: "html",
		success: function(html) {		
			
			jQuery('#image-display').show();
			jQuery('#promo_id').val(html);
		}
	})
}
function modal_tile()
{
	jQuery('#id_promo').val(jQuery('#promo_id').val());
	$('#promo').modal('show');
}

</script>
<style>
.cond
{
	background-color:#DDF3FA;
	min-height:50px;
	width:100%;
}
</style>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Add Promotion
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/new_system/promo'">Back To Story List</button>
			<div style="height: 20px"></div>
			<input type="hidden" name="promo_id" id="promo_id" value="">
			<form method="post" action="<?=base_url()?>admin/new_system/addpromo">
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Promotion Title</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Promotion Description</div>
					<div style="width: 80%; float: right">
						
                        <textarea style="width: 97%" id="promo_description" name="promo_description"></textarea>
					</div>
				</div>
                <div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Promotion Link</div>
					<div style="width: 80%; float: right">
						
                       <input style="width: 97%" type="text" class="textfield rounded" id="link" name="link" value=""/>
					</div>
				</div>
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;"><button class="btn btn-primary" type="button" onclick="save_promo()">Create</button></div>
					<div style="width: 80%; float: right">
					    
					</div>
				</div>
			</form>
            	<div id="image-display" style="display:none;">
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <button class="btn btn-primary" type="button" onclick="modal_tile()">
                        Add Story Home Page Image Tile
                    </button>
                    <div id="tile-home">
                    </div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <button class="btn btn-primary" type="button" onclick="modal_hero()">
                        Add Story Hero Slide
                    </button>
                    <div id="hero-story">
                    </div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    
                </div>
              	
                <div style="height: 50px; clear: both">&nbsp;</div>
			
			<div style="height: 0px; clear: both">&nbsp;</div>
			<!-- end here -->
		</div>
	</div>
</div>


<div id="storyTile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Promotion Home Page Image Tile</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/new_system/add_promo_home_tile">
    <input type="hidden" name="id_promo" id="id_promo" />
    <div style="height: 5px; clear: both">&nbsp;</div>
    <div>
        
        <div style="width: 80%; float: left">                    
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
    
    <div>
        
        <div style="width: 80%; float: left">						
            <button class="btn btn-primary" type="button" onclick="document.addPhotoForm.submit()">Add Image</button>
        </div>
    </div>
</div>
<div class="modal-footer">
<button class="btn btn-primary" type="submit" >Save</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
</form>
</div>
</div>

<div id="storySlide" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Promotion Hero Slide</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoHeroForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/new_system/add_promo_home_slide">
    <input type="hidden" name="id_promo" id="id_promo"  />
    <div style="height: 5px; clear: both">&nbsp;</div>
    <div>
        
        <div style="width: 80%; float: left">                    
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
    
    <div>
        
        <div style="width: 80%; float: left">						
            <button class="btn btn-primary" type="button" onclick="document.addPhotoHeroForm.submit()">Add Image</button>
        </div>
    </div>
</div>
<div class="modal-footer">
<button class="btn btn-primary" type="submit" >Save</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
</form>
</div>
</div>


