<script>
function save_story()
{
	var title = jQuery('#title').val();
	var story_description = jQuery('#story_description').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/adding_story/',
		type: 'POST',
		data: {title:title,story_description:story_description},			
		dataType: "html",
		success: function(html) {		
			
			jQuery('#image-display').show();
			jQuery('#story_id').val(html);
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
				Add Story
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/story'">Back To Story List</button>
			<div style="height: 20px"></div>
			<input type="hidden" name="story_id" id="story_id" value="">
			<form method="post" action="<?=base_url()?>admin/system/addstory">
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Story Title</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Story Description</div>
					<div style="width: 80%; float: right">
						
                        <textarea style="width: 97%" id="story_description" name="story_description"></textarea>
					</div>
				</div>
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;"><button class="btn btn-primary" type="button" onclick="save_story()">Create</button></div>
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
                    <button class="btn btn-primary" type="button" onclick="modal_secondary()">
                        Add Story Secondary Slide
                    </button>
                    <div id="secondary-slide">
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
<div id="anyCategories" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Categories</h3>
</div>
<div class="modal-body" >
    <input type="hidden" id="id_cond" val=""/>
    <table class="table table-hover">
    <thead>
        <tr style="font-size: 15px">
            <th style="width: 10%"><input type="checkbox" value="1" onclick="check_all_category()" id="all_cat"></th>
            <th style="width: 70%; text-align: left;">Categories</th>
            <th style="width: 20%; text-align: left;"></th>
           
        </tr>
    </thead>
    <tbody id="all_page">
        <? foreach($categories as $ct){?>
        <tr id="head_category_tr<?=$ct['id']?>" class="head_category">
            <td class="cb"><input type="checkbox" value="<?=$ct['id']?>" class="head_category_cb head_category head_category<?=$ct['id']?>" onchange="check_all_subcategory(<?=$ct['id']?>)"></td>
            <td style="text-align: left;">
                <b><?=$ct['name']?></b>
            </td>
            <td style="text-align: center;">
                
            </td>
        </tr>
        <? $sub_categories = $this->Category_model->get($ct['id']);
		   foreach($sub_categories as $sc)
		   {?>
				<tr id="detail_category_tr<?=$sc['id']?>" class="detail_category<?=$ct['id']?> detail_cat">
				<td class="cb"><input type="checkbox" value="<?=$sc['id']?>" class="detail_category_cb<?=$ct['id']?> detail_category_cb"></td>
				<td style="text-align: left;">
					<span style="margin-left:10px;"><?=$sc['name']?></span>
				</td>
				<td class="remove" style="display:none;"><div style="cursor:pointer;" onclick="remove_category_cond(<?=$sc['id']?>);"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></div></td>                 
				</tr>
		<? }        
         } ?>
    </tbody>
    
    </table>
</div>
<div class="modal-footer">
<button class="btn btn-primary" onclick="save_category();">Save</button>
<button class="btn" onclick="uncheck_all()">Cancel</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>


<div id="anyProducts" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Products</h3>
</div>
<div class="modal-body" >
    <input type="hidden" id="id_cond_product" val=""/>
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
    <input type="hidden" name="id_story" id="id_story" />
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
    <input type="hidden" name="id_story" id="id_story"  />
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
    <input type="hidden" name="id_story" id="id_story"  />
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
<script>
function switchtype()
{
	var val = $('#coupontype').val();
	
	if(val == 1)
	{
		$('#money').hide(); $('#percent').show();
	}
	else
	{
		$('#money').show(); $('#percent').hide();
	}
}
</script>