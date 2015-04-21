<script>
function update_story()
{
	var title = jQuery('#title').val();
	var story_description = jQuery('#story_description').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/updating_story/',
		type: 'POST',
		data: {id:<?=$story['id']?>,title:title,story_description:story_description},			
		dataType: "html",
		success: function(html) {								
			jQuery('#any_message').html("This story has been successfully updated");
			$('#anyModal').modal('show');
		}
	})
}
function modal_tile()
{
	jQuery('#id_story').val(jQuery('#story_id').val());
	$('#storyTile').modal('show');
}
function modal_hero()
{
	jQuery('#id_story').val(jQuery('#story_id').val());
	$('#storySlide').modal('show');
}
function modal_secondary()
{
	jQuery('#id_story').val(jQuery('#story_id').val());
	$('#storySecond').modal('show');
}
function modal_product()
{
	jQuery('#id_story').val(jQuery('#story_id').val());
	$('#anyProducts').modal('show');
}

function search_product()
{
	var keyword=jQuery('#keyword').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/search_product/',
		type: 'POST',	
		data: {keyword:keyword},	
		dataType: "html",		
		success: function(html) {		
			jQuery('#list_products').html(html);
		}
	})
}
function check_all_product()
{
	if ($("#all_prod").is(":checked")) {		
		$('.single_product').prop('checked', true);		
	}
	else
	{
		$('.single_product').prop('checked', false);		
	}
}
function uncheck_all_product()
{

	$('#all_prod').prop('checked', false);
	$('.single_product').prop('checked', false);	
}
function save_product()
{
	var count=0;
	var id_story=jQuery('#id_story').val();
	/*
	if ($("#all_prod").is(":checked")) {		
		jQuery('#all_products' +id_cond).html(jQuery('#list_products').html());
		jQuery('#all_products'+id_cond+' .cb').hide();
		jQuery('#all_products'+id_cond+' .remove').show();
		var countheight=0;
		countheight=310+jQuery('#cond'+id_cond).height();

		jQuery('#cond'+id_cond).css('height',countheight+'px');
	}
	else
	{*/		
		jQuery('#all_products'+id_story).html('');
		$('.single_product').each(function () {			
   			if($(this).is(':checked'))
			{				
				var id= $(this).parent().parent().attr("id");				
				dtrp=id.replace('product-','');
				jQuery('#all_products'+id_cond).append('<tr class="detailtrp" id="dtrp'+dtrp+'">'+$(this).parent().parent().html()+'</tr>');									
				count=count+1;		
			}
			jQuery('#all_products'+id_cond+' .cb').hide();
			jQuery('#all_products'+id_cond+' .remove').show();
 		});
		var countheight=0;
		countheight=(count*35)+jQuery('#cond'+id_cond).height();

		jQuery('#cond'+id_cond).css('height',countheight+'px');
	//}
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
				Edit Story
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/story'">Back To Story List</button>
			<div style="height: 20px"></div>
			<input type="hidden" name="story_id" id="story_id" value="<?=$story['id']?>">
			<form method="post" action="<?=base_url()?>admin/system/updatingstory">
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Story Title</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value="<?=$story['title']?>"/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Story Description</div>
					<div style="width: 80%; float: right">
						
                        <textarea style="width: 97%" id="story_description" name="story_description"><?=$story['description']?></textarea>
					</div>
				</div>
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;"><button class="btn btn-primary" type="button" onclick="update_story()">Update</button></div>
					<div style="width: 80%; float: right">
					    
					</div>
				</div>
			</form>
            	<div id="image-display" >
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div style="float:none;">
                        <div style="float:left;">
                            <button class="btn btn-primary" type="button" onclick="modal_tile()">
                                Add Story Home Page Image Tile
                            </button>
                        </div>
                        <div style="float:right;">
                            
                            <div id="tile-home">
                                <? 	$tiles = $this->System_model->check_image($story['id'],'tile');
                                    if(count($tiles)>0)
                                    {
                                            ?>
                                                <img src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$tiles['name']?>" width="150px">
                                            <?
                                        
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div style="float:none;">
                        <div style="float:left;">
                            <button class="btn btn-primary" type="button" onclick="modal_hero()">
                                Add Story Hero Slide
                            </button>
						</div>
						<div style="float:right;">                                                   
                            <div id="hero-story">
                                <? 	$tiles = $this->System_model->check_image($story['id'],'hero');
                                    if(count($tiles)>0)
                                    {
                                        
                                            ?>
                                                <img src="<?=base_url()?>uploads/stories/hero/<?=md5('hero'.$story['id'])?>/<?=$tiles['name']?>" width="150px">
                                            <?
                                        
                                    }
                                ?>
                            </div>
						</div>
					</div>                                                    
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div style="float:none;">
                        <div style="float:left;">
                            <button class="btn btn-primary" type="button" onclick="modal_secondary()">
                                Add Story Secondary Slide
                            </button>
						</div>
                        <div style="float:right;">                           
                            <div id="secondary-slide">
                                <? 	$tiles = $this->System_model->check_image($story['id'],'secondary');
                                    if(count($tiles)>0)
                                    {
                                       
                                            ?>
                                                <img src="<?=base_url()?>uploads/stories/secondary/<?=md5('secondary'.$story['id'])?>/<?=$tiles['name']?>" width="150px">
                                            <?
                                        
                                    }
                                ?>
                            </div>
                    	</div>
					</div>                        		
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>          
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    	<button class="btn btn-primary" type="button" onclick="modal_product()">
                              Add Product
                        </button>                        
                        <div style="height: 10px; clear: both">&nbsp;</div>
                        <div style="width: 100%; float: left; line-height: 50px;">
                                <div style="margin-top:10px;">
                                <script>jQuery(".selectpicker").selectpicker();</script>
                                <style>#category_type{margin-top:10px!important;}#cond'.$id.'{min-height:200px;}</style>                                
                                <table class="table table-hover" width="100%">
                                    <thead>
                                        <tr style="font-size: 15px">
                                            <th style="width: 40%">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_products" class="all_prod">
                                        <tr>
                                            <td align="center">No items defined</td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                        </div>                        
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>               	
                </div>
              	
                <div style="height: 50px; clear: both">&nbsp;</div>
			
			<div style="height: 0px; clear: both">&nbsp;</div>
			<!-- end here -->
		</div>
	</div>
</div>

<div id="anyProducts" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Products</h3>
</div>
<div class="modal-body" >
    <input type="hidden" name="id_story" id="id_story"  value="<?=$story['id']?>" />
    <?php if($links) { ?>
      <!--  <div class="pagination"><?=$links?></div>-->
    <?php } ?>
    <div>
         <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Search</div>
         <div style="width: 80%; float: right">
            <div style="float:left;">
            	<input type="text" name="keyword" id="keyword" onblur="search_product();"/>            
            </div>
            <div style="float:left; margin-left:20px;">
              <button class="btn btn-primary" type="button" onclick="search_product()">Search</button>
            </div>
         </div>
    </div>
    <div style="height: 5px; clear: both">&nbsp;</div>
    <div class="line-between">&nbsp;</div>
    <div style="height: 5px; clear: both">&nbsp;</div>
    <table class="table table-hover">

            <thead>

                <tr style="font-size: 15px">
					<th style="width: 10%"><input type="checkbox" value="1" onclick="check_all_product()" id="all_prod"></th>
                    <th style="width: 80%">Product Name </th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="list_products">
                <?php foreach($products as $product) { ?>
                <tr id="product-<?=$product['id']?>" class="detail_prod">
                	<td class="cb"><input type="checkbox" value="1" class="single_product" id="single_product<?=$product['id']?>"></td>
                    <td style="text-align: left;">
                        <a href="<?=base_url()?>admin/new_cms/product/edit/<?=$product['id']?>" target="_blank"><?=$product['title']?></a>
                    </td>
                    <td class="remove" style="display:none;"><div style="cursor:pointer;" onclick="remove_prod_cond(<?=$product['id']?>);"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></div></td>                 
                </tr>
                <?php }?>
            </tbody>
    </table>
</div>
<div class="modal-footer">
<button class="btn btn-primary" onclick="save_product();">Save</button>
<button class="btn" onclick="uncheck_all_product()">Cancel</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>

<div id="storyTile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Story Home Page Image Tile</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/system/add_home_tile">
    <input type="hidden" name="id_story" id="id_story"  value="<?=$story['id']?>" />
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
<h3 id="myModalLabel">Add Story Hero Slide</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoHeroForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/system/add_home_slide">
    <input type="hidden" name="id_story" id="id_story"  value="<?=$story['id']?>" />
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


<div id="storySecond" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Story Secondary Slide</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoSecondForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/system/add_home_second">
    <input type="hidden" name="id_story" id="id_story"  value="<?=$story['id']?>" />
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
            <button class="btn btn-primary" type="button" onclick="document.addPhotoSecondForm.submit()">Add Image</button>
        </div>
    </div>
</div>
<div class="modal-footer">
<button class="btn btn-primary" type="submit" >Save</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
</form>
</div>
</div>
<div id="anyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Message</h3>
</div>
<div class="modal-body">
    <p id="any_message"></p>
</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>