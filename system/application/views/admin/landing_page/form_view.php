<div class="span9">
	<div class="box">
          <h1>
              <?=isset($landing_page['landing_page_id']) ? 'Edit' : 'Add' ?> Landing page
          </h1>
          
          <button class="btn" onclick="window.location = '<?=base_url()?>admin/landing_page'">Back To Landing page</button>
          <div style="height: 20px"></div>

          <form id="tile-form" enctype="multipart/form-data" method="post" action="<?=base_url();?>admin/landing_page/<?=$action;?>">
          	  <input type="hidden" name="landing_page_id" value="<?=isset($landing_page['landing_page_id']) ? $landing_page['landing_page_id'] : '';?>">              
              <div class="form-group">
                  <div class="form-label">Name</div>
                  <div class="form-control">
                      <input type="text" class="rounded" id="name" name="name" value="<?=isset($landing_page['name']) ? $landing_page['name'] : '';?>"/>
                  </div>
              </div>
              <div class="form-group">
                  <div class="form-label">URL</div>
                  <div class="form-control">
                     <input type="text" class="rounded" id="url" name="url" value="<?=isset($landing_page['url']) ? $landing_page['url'] : '';?>"/>
                  </div>
              </div> 
              <div class="form-group">
              		<div class="form-label">Image</div>
                    <div class="form-control">
                    	<div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
                                <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
                                <input type="file" name="userfile"></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                        </div>
                        <span><em>Ideal image width: 750px - 643px<br>All image should be of same width & height for optimum result.</em></span>
                    </div>
              </div>
              
              
              <?php 
			  	# if tile has current image, display it.
			  	if(isset($landing_page['image_name']) && $landing_page['image_name']) { 
			  ?>
              <div class="form-group">
              	  	<div class="form-label">Current Image</div>
                    <div class="form-control">
                    	<img class="tile-thumb" src="<?=base_url();?>uploads/landing_page/<?=$landing_page['image_name'];?>">
                    </div>
              </div>
              <?php } ?>
              
                            
              <div class="form-group vgap">
                  <div class="form-label">
                  		<button class="btn btn-primary" type="button" id="submit-data"><?=isset($landing_page['landing_page_id']) ? 'Update' : 'Create' ?></button>
                  </div>
              </div>
              
          </form>
	
	</div>
</div>

<script>
$(function(){
	$('#submit-data').click(function(){
		if(validate_form()){
			$('#tile-form').submit();	
		}
	});
	
	
}); //ready

function validate_form(){
	var name = $('#name');
	var valid = true;
	if(!name.val()){
		valid = false;	
		name.addClass('error');
	}else{
		name.removeClass('error');	
	}
	
	return valid;
}



</script>


