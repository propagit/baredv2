<?php
	$active_products = $this->Product_model->all_active();;
?>

<form id="tile-form" enctype="multipart/form-data" method="post" action="<?=base_url();?>admin/instagram_gallery/insert">
    <input type="hidden" name="tile_id" value="<?=isset($tile['tile_id']) ? $tile['tile_id'] : '';?>">              
    <div class="form-group">
        <div class="form-label">Name</div>
        <div class="form-control">
            <input type="text" class="rounded" id="name" name="name" value=""/>
        </div>
    </div>
    <div class="form-group">
        <div class="form-label">Products</div>
        <div class="form-control">
            <select class="app-select2" name="product_id">
                <?php 
					foreach($active_products as $product){ 
					$hero = $this->Product_model->get_hero($product['id']);
				?>
                	<optgroup><option value="<?=$product['id']?>" data-hero="<?=$hero['name'];?>"><?=$product['title'] . ' - ' . $product['short_desc'];?></option></optgroup>
                <?php } ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <div class="form-label">Category</div>
        <div class="form-control">
            <select name="home_category" id="home_category">
                <option value="<?=MEN?>">Male</option>
                <option value="<?=WOMEN?>">Female</option>
            </select> 
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
          </div>
    </div>            
    <div class="form-group">
        <div class="form-label">&nbsp;</div>
        <div class="form-control">
              <button class="btn btn-primary" type="button" id="submit-data">Create</button>
        </div>
    </div>
</form>
	

<script>
$(function(){
	$('#submit-data').click(function(){
		if(validate_form()){
			$('#tile-form').submit();	
		}
	});
	
	$('.app-select2').select2();
	
	
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


