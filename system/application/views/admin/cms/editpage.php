<script>
function check_title()
{
	var title = jQuery('#title').val();
	var title_hide = jQuery('#title_hide').val();
	
	var id = jQuery('#id').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/search_page_title',
		type: 'POST',
		data: ({title:title,id:id}),
		dataType: "html",
		success: function(html) {
			if(html==1){alert('The page title has already exist.'); jQuery('#title').val(title_hide);}
			
		}
	})
}
</script>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
            <div style="float:none;">
                <div style=" float:left">
                    <h1> 
                        <?=$categories['name']?>
                    </h1>
                    <h2>
                        Edit Page <?=$pages['title']?>
        
                    </h2>
                </div>
            
                <div style="float:right; margin-top:15px;margin-right:10px;" >
                    
                    
                    <a style="text-decoration:none" target="_blank" href="<?=base_url()?>admin/cms/showpage/<?=$pages['id']?>">
                    <button class="btn btn-primary" type="button">Preview</button>
                    </a>
                    
                    <button class="btn btn-primary" onclick="window.location='<?=base_url()?>admin/cms/page_category/<?=$categories['id']?>'" type="button">Back</button>
                </div>
            </div>
            <div style="clear:both;"></div>
			<form name="updateForm" method="post" action="<?=base_url()?>admin/cms/updatepage" enctype="multipart/form-data">

			<input type="hidden" id="id" name="id" value="<?=$pages['id']?>">

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Meta Keyword (Max 70)</div>

				<div style="width: 80%; float: right">

					<input style="width: 97%" type="text" class="textfield rounded" id="meta_title" name="meta_title" maxlength="70" value="<?=$pages['meta_title']?>"/>
                    

				</div>

			</div>

			<div style="height: 5px; clear: both">&nbsp;</div>

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Meta Description (Max 150)</div>

				<div style="width: 80%; float: right">

					<input style="width: 97%" type="text" class="textfield rounded" id="meta_description" name="meta_description" maxlength="150" value="<?=$pages['meta_description']?>"/>

				</div>

			</div>

			<div style="height: 5px; clear: both">&nbsp;</div>

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Title</div>

				<div style="width: 80%; float: right">

					<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value="<?=$pages['title']?>" onchange="check_title();"/>
                    <input style="width: 97%" type="hidden" class="textfield rounded" id="title_hide" name="title_hide" maxlength="70" value="<?=$pages['title']?>"/>

				</div>

			</div>
            
            <div style="height: 5px; clear: both">&nbsp;</div>

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Display</div>

				<div style="width: 80%; float: right">

					<input type="radio" value="0" name="display" id="display_normal" <? if($pages['display']==0){echo "checked='cehecked'";}?> style="margin-top:0px;"/> Standard
                    <input type="radio" value="1" name="display" id="display_popout" <? if($pages['display']==1){echo "checked='cehecked'";}?> style="margin-top:0px;margin-left:10px;" /> Pop Out

				</div>

			</div>

			<div style="height: 20px; clear: both">&nbsp;</div>

			<div>

				<textarea style="height: 300px" class="ckeditor" name="content_text"><?=$pages['content']?></textarea>

			</div>

			<!-- <div style="height: 20px; clear: both">&nbsp;</div>

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Background</div>

				<div style="width: 80%; float: right">

					<div class="fileupload fileupload-new" data-provides="fileupload">

						<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">

							<img id="background" src="<?=base_url()?>uploads/pages/<?=$pages['background']?>"  />

						</div>

						<div>

							<span class="btn btn-file">

								<span class="fileupload-new">Select image</span>

								<span class="fileupload-exists">Change</span>

								<input type="file" name="userfile" />

							</span>

							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>

						</div>

					</div>

				</div>

				<script>$('.fileupload').fileupload();</script>

			</div> -->

			<div style="height: 20px; clear: both">&nbsp;</div>

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;"><button class="btn btn-primary" type="submit">Update</button></div>

				<div style="width: 80%; float: right">

					&nbsp;

				</div>

			</div>

			</form>

			<div style="height: 5px; clear: both">&nbsp;</div>

			<!-- end here -->

		</div>

	</div>

</div>

<script>

	var editor = CKEDITOR.replace( 'content_text' );

	CKFinder.setupCKEditor( editor, '<?=base_url()?>ckfinder/' );

</script>