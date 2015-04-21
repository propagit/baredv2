<script type="text/javascript" src="<?=base_url()?>js/jquery-sortable.js"></script>
<script>
$(function() {       
	//getcats();
	//getcats2(); 
	
	
	// var cur_cat = 0;
	// var group = $('.sorted_table').sortable({	  
	  // containerSelector: 'tbody',
	  // itemSelector: 'tr',
	  // placeholder: '<tr class="placeholder"/>',
	  // onDrop: function(item, container, _super) {
      	// update_order();
    	// }
//     
// 	
	// });
	

	
});
</script>
<script>
function update_story()
{
	var title = jQuery('#title').val();
	var story_description = jQuery('#story_description').val();
	var category = jQuery('#category').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/updating_story/',
		type: 'POST',
		data: {id:<?=$story['id']?>,title:title,story_description:story_description,category:category},			
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
	var product=[];
	var idp=0;
	var k=0;
	$('.prod').each(function () {		
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('prod','');
		product[k]=idp;
	});


	jQuery('#no-product').remove();
	$('.single_product').each(function () {			
		if($(this).is(':checked'))
		{				
			var id= $(this).parent().parent().attr("id");				
			dtrp=id.replace('product-','');
			//alert(product.contains(dtrp));
			if(jQuery.inArray(dtrp, product)==-1)
			{
				jQuery('#all_products').append('<tr class="prod" id="prod'+dtrp+'">'+$(this).parent().parent().html()+'</tr>');									
			}
			count=count+1;		
		}
		jQuery('#all_products'+' .cb').hide();
		jQuery('#all_products'+' .remove').show();
	});
		
	var product=[];
	var idp=0;
	var k=0;
	$('.prod').each(function () {		
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('prod','');
		product[k]=idp;
	});
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/addstory_product/',
		type: 'POST',	
		data: {id_story:id_story,product:product},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}
function remove_prod_cond(id)
{
	var story_id = <?=$story['id']?>;
	jQuery('#prod'+id).remove();
	var product=[];
	var idp=0;
	var k=0;
	$('.prod').each(function () {		
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('prod','');
		product[k]=idp;
	});
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/addstory_product/',
		type: 'POST',	
		data: {id_story:story_id,product:product},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}
function addnewpage()
{
	var title = $('#title_page').val();
	var story_id = <?=$story['id']?>;
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/store/addinghtml',
		type: 'POST',
		data: ({title:title,story_id:story_id}),
		dataType: "html",
		success: function(html) {
			$('#newpageModal').modal('hide');
			location.reload();
		}
	})	
}
function deletepage(id)
{
	jQuery.ajax({
		url: '<?=base_url()?>admin/store/deletehtml',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#any_message').html('This page has been successfully deleted');
			$('#anyModal').modal('show');
		}
	})
	
	jQuery('#page-'+id).fadeOut('slow');
}

function update_order(){
	//alert('aa');
	
	var indx=[];
	var i=1;
	jQuery('.page-str').each(function () {
		var id = $(this).attr("id");
		dtrp=id.replace('page-','');
		indx[i]=dtrp;
		i=i+1;
		
	});
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/update_order_story_page/',
		type: 'POST',
		data: ({indx:indx}),
		dataType: "html",
		success: function(html) {
			
		}
	})
	
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
<style>
body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}
.sorted_table tr {
    cursor: pointer;
}
.sorted_table tr.placeholder {
    background: none repeat scroll 0 0 red;
    border: medium none;
    display: block;
    margin: 0;
    padding: 0;
    position: relative;
}
.sorted_table tr.placeholder:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: transparent -moz-use-text-color transparent red;
    border-image: none;
    border-style: solid none solid solid;
    border-width: 5px medium 5px 5px;
    content: "";
    height: 0;
    left: -5px;
    margin-top: -5px;
    position: absolute;
    width: 0;
}
.list_header
{
	height: 45px; line-height: 45px; font-weight: 900; font-size: 15px; float: left;
}
.list_data
{
	height: 45px; line-height: 45px; font-size: 14px; float: left;
}
.list_icon
{
	padding-top: 8px; cursor: pointer;
}
.list_center
{
	text-align: center;
}
.list_line
{
	clear: both; border-top: 1px solid #dedede;
}
</style>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Edit Story
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/cms/stories'">Back To Story List</button>
			<div style="height: 20px"></div>
			<input type="hidden" name="story_id" id="story_id" value="<?=$story['id']?>">
			<form method="post" action="<?=base_url()?>admin/cms/updatingstory">
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
                <div style="height: 5px; clear: both">&nbsp;</div>
                <?php if(0) { ?>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Story Category</div>
					<div style="width: 80%; float: right">
						<select id="category" name="category" class="selectpicker" >
                            <!-- <option value="STYLEFILE" <? if($story['category']=='STYLEFILE'){echo 'selected=selected';}?>>STYLEFILE</option> -->
                            <option value="SPOTLIGHTS" <? if($story['category']=='SPOTLIGHTS'){echo 'selected=selected';}?>>SPOTLIGHTS</option>
                            <option value="FEATURES" <? if($story['category']=='FEATURES'){echo 'selected=selected';}?>>FEATURES</option>
                            <option value="LOOKBOOKS" <? if($story['category']=='LOOKBOOKS'){echo 'selected=selected';}?>>LOOKBOOKS</option>
                            <option value="LATEST SEASON" <? if($story['category']=='LATEST SEASON'){echo 'selected=selected';}?>>LATEST SEASON</option>
                            <option value="LUGGAGE" <? if($story['category']=='LUGGAGE'){echo 'selected=selected';}?>>LUGGAGE</option>
                            <option value="STYLE VIDEOS" <? if($story['category']=='STYLE VIDEOS'){echo 'selected=selected';}?>>STYLE VIDEOS</option>
                            <option value="NEWS" <? if($story['category']=='NEWS'){echo 'selected=selected';}?>>NEWS</option>
                            <option value="THE BAGAZINE" <? if($story['category']=='THE BAGAZINE'){echo 'selected=selected';}?>>THE BAGAZINE</option>
                            <option value="WHAT'S HAPPENING" <? if($story['category']=="WHAT'S HAPPENING"){echo 'selected=selected';}?>>WHAT'S HAPPENING</option>
                            <option value="IN THE PRESS" <? if($story['category']=='IN THE PRESS'){echo 'selected=selected';}?>>IN THE PRESS</option>                            
                        </select>
                        <script>jQuery(".selectpicker").selectpicker();</script>
					</div>
				</div>
                <?php } ?>
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;"><button class="btn btn-primary" type="button" onclick="update_story()">Update</button></div>
					<div style="width: 80%; float: right">
					    
					</div>
				</div>
			</form>
            	<div id="image-display" >
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>

                    <div style="float:none;">
                        <div style="float:left;">
                            <h1>Add Story Thumbnail</h1>
                            <button class="btn btn-primary" type="button" onclick="modal_tile()">
                                Add Image
                            </button>
                        </div>
                        <div style="float:right; margin-top:20px;">
                            
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
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>

                    <div style="float:none;">
                        <div style="float:left;">
                            <h1 style="float:left;">Add Story Pages</h1>
                            <a style="color: #fff; float:left;margin-top:10px; margin-left:20px;" href="#newpageModal"  class="btn btn-primary" data-toggle="modal">Add New Page</a>
						</div>
                        <div style="height: 10px; clear: both">&nbsp;</div>
                        <table class="table table-hover">
                        <thead>
                            <tr style="font-size: 15px">
                                <th style="width: 40%">Page Title</th>
                                <th style="width: 12%; text-align: center;">Preview</th>
                                <th style="width: 12%; text-align: center;">Edit Page</th>
                                <!--<th style="width: 12%; text-align: center;">Copy Page</th>
                                <th style="width: 12%; text-align: center;">Add Gallery</th>-->
                                <th style="width: 12%; text-align: center;">Delete Page</th>
                            </tr>
                        </thead>
                        <tbody id="all_page" class="sorted_table">
                            <? 
							$story_page = $this->System_model->get_storypage($story['id']);
							foreach($story_page as $page){?>
                            <tr class="page-str" id="page-<?=$page['id']?>">
                                <td><?=$page['title']?></td>
                                <td style="text-align: center;">
                                    <a target="_blank" href="<?=base_url()?>admin/cms/preview_story/html/<?=$page['id']?>"><div class="all_tt" data-toggle="tooltip" title="Preview Page"><i class="icon-search icon-2x"></i></div></a>
                                </td>
                                <td style="text-align: center;">
                                    <div class="all_tt" data-toggle="tooltip" title="Edit Page"><a style="text-decoration:none;" href="<?=base_url()?>admin/store/edit_html/<?=$page['id']?>"><i class="icon-edit icon-2x"></i></a></div>
                                </td>                                
                                <td style="text-align: center;">
                                    <div class="all_tt" data-toggle="tooltip" title="Delete Page" style="cursor:pointer; color: #C70520" onclick="deletepage(<?=$page['id']?>)"><i class="icon-remove-circle icon-2x"></i></div>
                                </td>
                            </tr>
                            <? } ?>
                        </tbody>
                        
                        </table>
                        <div id="all_div">
                        </div>
						
					</div>                                                    
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <?php if(0) { 
						/* disabled for this project */
					?>
                    <div style="float:none;">
                        <div style="float:left;">
                            <h1>Add Story Secondary Slide</h1>
                            <button class="btn btn-primary" type="button" onclick="modal_secondary()">
                                Add Image
                            </button>
						</div>
                        <div style="float:right; margin-top:10px;">                           
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
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div> 
                    
                    <?php } ?>  
                           
                    <div style="height: 20px; clear: both">&nbsp;</div>
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
									<? $prods=$this->System_model->get_all_products($story['id']);
										if(count($prods)>0){
                                      		foreach($prods as $pro){
                                            	$pros=$this->Product_model->identify( $pro['product_id']);
												if($pros['status']==1 && $pros['deleted']==0){
												?>
												<tr class="prod" id="prod<?=$pro['product_id']?>">
                                                	<td style="text-align: left;">
	                                                    <a target="_blank" href="<?=base_url()?>admin/cms/product/edit/<?=$pro['product_id']?>"><?=$pros['title']?></a>
                                                    </td>
                                                    <td class="remove">
                                                    	<div onclick="remove_prod_cond( <?=$pro['product_id']?>);" style="cursor:pointer;">
                                                        	<i class="icon-remove-circle icon-2x" style="color: #c70520"></i>
                                                        </div>
                                                    </td>
                                                </tr>		
                                                
                                            <? }
												}
										}else{
									?>
                                    
                                        <tr id="no-product">
                                            <td align="center">No items defined</td>
                                        </tr>
                                    <? }?>
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

<div id="newpageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add New Page</h3>
</div>
<div class="modal-body">
    <p>Title</p>
    <p><input type="text" class="textfield rounded" id="title_page" name="title_page" /></p>
	    
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="addnewpage();">Save</button>
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
                        <a href="<?=base_url()?>admin/cms/product/edit/<?=$product['id']?>" target="_blank"><?=$product['title']?></a>
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
     <form name="addPhotoForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_home_tile">
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
     <form name="addPhotoHeroForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_home_slide">
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
     <form name="addPhotoSecondForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_home_second">
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