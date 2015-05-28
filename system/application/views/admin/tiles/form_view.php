<div class="span9">
	<div class="box">
          <h1>
              <?=isset($tile['tile_id']) ? 'Edit' : 'Add' ?> Tile
          </h1>
          
          <button class="btn" onclick="window.location = '<?=base_url()?>admin/tiles'">Back To Tiles</button>
          <div style="height: 20px"></div>

          <form id="tile-form" enctype="multipart/form-data" method="post" action="<?=base_url();?>admin/tiles/<?=$action;?>">
          	  <input type="hidden" name="tile_id" value="<?=isset($tile['tile_id']) ? $tile['tile_id'] : '';?>">              
              <div class="form-group">
                  <div class="form-label">Name</div>
                  <div class="form-control">
                      <input type="text" class="rounded" id="name" name="name" value="<?=isset($tile['name']) ? $tile['name'] : '';?>"/>
                  </div>
              </div>
              <div class="form-group">
                  <div class="form-label">Button Name</div>
                  <div class="form-control">
                      <input type="text" class="rounded" id="btn_name" name="btn_name" value="<?=isset($tile['btn_name']) ? $tile['btn_name'] : '';?>"/>
                  </div>
              </div>
              <div class="form-group">
                  <div class="form-label">Button Visible</div>
                  <div class="form-control">
                     <input type="checkbox" name="btn_visibility" <?=isset($tile['btn_visibility']) && $tile['btn_visibility'] ? 'checked="checked"' : '';?>>
                  </div>
              </div> 
              <div class="form-group">
                  <div class="form-label">Caption</div>
                  <div class="form-control">
                      <input type="text" class="rounded" id="caption" name="caption" value="<?=isset($tile['caption']) ? $tile['caption'] : '';?>"/>
                  </div>
              </div>
              <div class="form-group">
                  <div class="form-label">URL</div>
                  <div class="form-control">
                     <input type="text" class="rounded" id="tile_uri" name="tile_uri" value="<?=isset($tile['tile_uri']) ? $tile['tile_uri'] : '';?>"/>
                  </div>
              </div> 
              <div class="form-group">
                  <div class="form-label">Category</div>
                  <div class="form-control">
                      <select name="category" id="category">
                      	  <option value="0">Select One</option>
                          <option <?=(isset($tile['category']) ? ($tile['category'] == MEN ? 'selected="selected"' : '') : 'selected="selected"');?> value="<?=MEN?>">Male</option>
                          <option <?=(isset($tile['category']) ? ($tile['category'] == WOMEN ? 'selected="selected"' : '') : '');?> value="<?=WOMEN?>">Female</option>
                      </select> 
                  </div>
              </div> 
              <div class="form-group">
                  <div class="form-label">Open in new window</div>
                  <div class="form-control">
                     <input type="checkbox" name="new_window" <?=isset($tile['new_window']) && $tile['new_window'] ? 'checked="checked"' : '';?>>
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
                        <span><em>Ideal image size: 630px - 630px<br>All image should be of same width & height for optimum result.</em></span>
                    </div>
              </div>
              
              
              <?php 
			  	# if tile has current image, display it.
			  	if(isset($tile['image_name']) && $tile['image_name']) { 
			  ?>
              <div class="form-group">
              	  	<div class="form-label">Current Image</div>
                    <div class="form-control">
                    	<img class="tile-thumb" src="<?=base_url();?>uploads/tiles/<?=$tile['image_name'];?>">
                    </div>
              </div>
              <?php } ?>
              
                            
              <div class="form-group vgap">
                  <div class="form-label">
                  		<button class="btn btn-primary" type="button" id="submit-data"><?=isset($tile['tile_id']) ? 'Update' : 'Create' ?></button>
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


