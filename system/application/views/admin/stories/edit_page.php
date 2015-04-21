<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
            <div style="float:none;">
                <div style=" float:left">
                    <h1>
                        Edit Page <?=$pages['title']?>
        
                    </h1>
                </div>
            
                <div style="float:right; margin-top:15px;margin-right:10px;" >
                    
                    
                    <a style="text-decoration:none" target="_blank" href="<?=base_url()?>admin/cms/edit_story/<?=$pages['story_id']?>">
                    	<button class="btn btn-primary" type="button">Preview</button>
                    </a>
                    
                    <button class="btn btn-primary" onclick="window.location='<?=base_url()?>admin/cms/edit_story/<?=$pages['story_id']?>'" type="button">Back</button>
                </div>
            </div>
            <div style="clear:both;"></div>
			<form name="updateForm" method="post" action="<?=base_url()?>admin/store/updatepagehtml" enctype="multipart/form-data">

			<input type="hidden" id="id" name="id" value="<?=$pages['id']?>">
            <input type="hidden" id="story_id" name="story_id" value="<?=$pages['story_id']?>">

			
			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Title</div>

				<div style="width: 80%; float: right">

					<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value="<?=$pages['title']?>"/>

				</div>

			</div>
                        

			<div style="height: 20px; clear: both">&nbsp;</div>

			<div>

				<textarea style="height: 300px" class="ckeditor" name="content_text"><?=$pages['content']?></textarea>

			</div>

			
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