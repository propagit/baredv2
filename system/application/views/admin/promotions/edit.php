<script>
function update_promo()
{
	var title = jQuery('#title').val();
	var links = jQuery('#link').val();
	var promo_description = jQuery('#promo_description').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/updating_promo/',
		type: 'POST',
		data: {id:<?=$promotions['id']?>,title:title,promo_description:promo_description,links:links},			
		dataType: "html",
		success: function(html) {					
			
			jQuery('#any_message').html("This promotion has been successfully updated");
			$('#anyModal').modal('show');
			
		}
	})
}
function modal_tile()
{
	jQuery('#id_promo').val(jQuery('#promo_id').val());
	$('#promoTile').modal('show');
}
function modal_hero()
{
	jQuery('#id_promo').val(jQuery('#promo_id').val());
	$('#promoSlide').modal('show');
}
function deletepage(id)
{
	jQuery.ajax({
		url: '<?=base_url()?>admin/store/deletepromotionhtml',
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
function addnewpage()
{
	var title = $('#title_page').val();
	var promotion_id = <?=$promotions['id']?>;
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/store/addingpromotionhtml',
		type: 'POST',
		data: ({title:title,promotion_id:promotion_id}),
		dataType: "html",
		success: function(html) {
			$('#newpageModal').modal('hide');
			//location.reload();
		}
	})	
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
		url: '<?=base_url()?>admin/cms/addpromotion_product/',
		type: 'POST',	
		data: {id_story:id_story,product:product},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}

function remove_prod_cond(id)
{
	var story_id = <?=$promotions['id']?>;
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
		url: '<?=base_url()?>admin/cms/addpromotion_product/',
		type: 'POST',	
		data: {id_story:story_id,product:product},	
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
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Edit Promotion
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/cms/promotions'">Back To Promotion List</button>
			<div style="height: 20px"></div>
			<input type="hidden" name="promo_id" id="promo_id" value="<?=$promotions['id']?>">
			<input type="hidden" name="story_id" id="story_id" value="<?=$promotions['id']?>">
			<form method="post" action="<?=base_url()?>admin/system/addpromo">
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Promotion Title</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value="<?=$promotions['title']?>"/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Promotion Description</div>
					<div style="width: 80%; float: right">
						
                        <textarea style="width: 97%" id="promo_description" name="promo_description"><?=$promotions['description']?></textarea>
					</div>
				</div>
                <div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Promotion Link</div>
					<div style="width: 80%; float: right">
						
                       <input style="width: 97%" type="text" class="textfield rounded" id="link" name="link" value="<?=$promotions['url']?>"/>
					</div>
				</div>
				<div style="height: 15px; clear: both">&nbsp;</div>                
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;"><button class="btn btn-primary" type="button" onclick="update_promo()">Update</button></div>
					<div style="width: 80%; float: right">
					    
					</div>
				</div>
			</form>
            	<div id="image-display" >
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    
                    <div style="float:none;">
                        <div style="float:left;">
                            <h1>Add Promotion Home Page Image Tile</h1>
                            <button class="btn btn-primary" type="button" onclick="modal_tile()">
                                Add Image
                            </button>
                        </div>
                        <div style="float:right;margin-top:20px;">
                            
                            <div id="tile-home">
                                <? 	$tiles = $this->System_model->check_image_promotions($promotions['id'],'tile');
                                    if(count($tiles)>0)
                                    {
                                            ?>
                                                <img src="<?=base_url()?>uploads/promotions/tiles/<?=md5('tile'.$promotions['id'])?>/<?=$tiles['name']?>" width="150px">
                                            <?
                                        
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <!--
                    <div style="float:none;">
                        <div style="float:left;">
                            <h1 style="float:left;">Add Promotion Page</h1>
                            <? 	$story_page = $this->Menu_model->get_promotionpage($promotions['id']);
							
							?>
                            
                            <a style="color: #fff; float:left;margin-top:10px; margin-left:20px;" href="#newpageModal"  class="btn btn-primary" data-toggle="modal">Add New Page</a>
                            
						</div>
                        <div style="height: 10px; clear: both">&nbsp;</div>
                        <table class="table table-hover">
                        <thead>
                            <tr style="font-size: 15px">
                                <th style="width: 40%">Page Title</th>
                                <th style="width: 12%; text-align: center;">Preview</th>
                                <th style="width: 12%; text-align: center;">Edit Page</th>                               
                                <th style="width: 12%; text-align: center;">Delete Page</th>
                            </tr>
                        </thead>
                        <tbody id="all_page" class="sorted_table">
                            <? 
							
							foreach($story_page as $page){?>
                            <tr class="page-str" id="page-<?=$page['id']?>">
                                <td><?=$page['title']?></td>
                                <td style="text-align: center;">
                                    <div class="all_tt" data-toggle="tooltip" title="Preview Page"><a style="text-decoration:none;" href="<?=base_url()?>admin/store/preview_promotion/html/<?=$page['id']?>"><i class="icon-search icon-2x"></i></a></div>
                                </td>
                                <td style="text-align: center;">
                                    <div class="all_tt" data-toggle="tooltip" title="Edit Page"><a style="text-decoration:none;" href="<?=base_url()?>admin/store/edit_promotionhtml/<?=$page['id']?>"><i class="icon-edit icon-2x"></i></a></div>
                                </td>                                
                                <td style="text-align: center;">
                                    <div class="all_tt" data-toggle="tooltip" title="Delete Page" style="cursor:pointer" onclick="deletepage(<?=$page['id']?>)"><i class="icon-remove-circle icon-2x"></i></div>
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
									<? $prods=$this->System_model->get_all_products_promotion($promotions['id']);
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
                    -->             	
                </div>
                    <!--
                    <div style="float:none;">
                        <div style="float:left;">
                            <h1>Add Story Hero Slide</h1>
                            <button class="btn btn-primary" type="button" onclick="modal_hero()">
                                Add Image
                            </button>
						</div>
						<div style="float:right;margin-top:20px;">                                                   
                            <div id="hero-story">
                                <? 	$tiles = $this->System_model->check_image_promotions($promotions['id'],'hero');
                                    if(count($tiles)>0)
                                    {
                                        
                                            ?>
                                                <img src="<?=base_url()?>uploads/promotions/hero/<?=md5('hero'.$promotions['id'])?>/<?=$tiles['name']?>" width="150px">
                                            <?
                                        
                                    }
                                ?>
                            </div>
						</div>
					</div>        
                    <div style="height: 20px; clear: both">&nbsp;</div>
                    <div class="line-between">&nbsp;</div>
                    <div style="height: 10px; clear: both">&nbsp;</div>
                    -->
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
    <input type="hidden" name="id_story" id="id_story"  value="<?=$promotions['id']?>" />
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

<div id="promoTile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Promotion Home Page Image Tile</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_home_promo_tile">
    <input type="hidden" name="id_promo" id="id_promo" value="<?=$promotions['id']?>"/>
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

<div id="promoSlide" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Promotion Hero Slide</h3>
</div>
<div class="modal-body" >
     <form name="addPhotoHeroForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_home_promo_slide">
    <input type="hidden" name="id_promo" id="id_promo" value="<?=$promotions['id']?>" />
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
