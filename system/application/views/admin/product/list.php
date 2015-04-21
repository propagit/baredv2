<script>
jQuery(function() {
	jQuery('.all_tt').tooltip({
		showURL: false
	});
});
</script>
<style>
h1{
	font-weight : 900;
	font-size:20px!important;
}
</style>
<script>
var choose = 0;
var check = 0;
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<?php if($this->session->flashdata('upload_csv_er')) { ?>
			    <div class="alert alert-error">
			    	<button type="button" class="close" onclick="$('.alert-error').fadeOut('slow');">&times;</button>
					<strong>ERROR! </strong><?=$this->session->flashdata('upload_csv_er')?>
				</div>
			<?php }?>
			<?php if($this->session->flashdata('upload_csv_sc')) { ?>
			    <div class="alert alert-success">
			    	<button type="button" class="close" onclick="$('.alert-success').fadeOut('slow');">&times;</button>
					<strong>SUCCESS! </strong><?=$this->session->flashdata('upload_csv_sc')?>
				</div>
			<?php }?>
			<h1>Manage Products</h1>
			<button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/product/add';">Add New Product</button>
			<button class="btn btn-primary" onclick="export_csv();"><i class="icon-upload"></i>&nbsp;Export Product</button>
			
				<button class="btn btn-primary" onclick="$('#importModal').modal('show');"><i class="icon-download"></i>&nbsp;Import Product</button>
				
			</form>
			<div>
				<h1>Search Product</h1>
				<form id="addProduct" method="post" action="<?=base_url()?>admin/cms/searchproduct">
				<div style="float: left; width: 150px; height: 30px; line-height: 30px;">Keyword</div>
				<div style="float: left;">
					<input type="text" class="textfield rounded" id="name" name="keyword" value=""/>
				</div>
				<div style="clear: both; height:10px;"></div>
				<div style="float: left; width: 150px; height: 30px; line-height: 30px;">Category</div>
				<div style="float: left;">
					<select class="selectpicker" id="cat" name="category">
                    	<option value="0">All categories</option>		
                    	<?php foreach($main as $maincat) { ?>
                    		<option value="<?=$maincat['id']?>"><?=$maincat['title']?></option>        
                    	<?php }?>
                    					
                        <!-- <?php foreach($main as $maincat) { ?>
                        <?php $sub = $this->Category_model->get($maincat['id']);
							if(count($sub)>0){
							foreach($sub as $subcat) { ?>
                            <option value="<?=$subcat['id']?>"><?=$maincat['title']?> &raquo; <?=$subcat['title']?></option>
                            <?php 
							}
							}else{ ?>
						    <option value="<?=$maincat['id']?>"><?=$maincat['title']?></option>                    
                         	<?php }
							} 
						 ?> -->
                    </select>
				</div>
				<div style="clear: both; height:10px;"></div>
				<div style="float: left; width: 150px; height: 30px; line-height: 30px;">Status</div>
				<div style="float: left;">
					<select class="selectpicker" id="cat" name="status">
                    	<option value="all">All</option>
                    	<option value="active">Active</option>
                    	<option value="inactive">Inactive</option>		
                    </select>
				</div>
				<div style="clear: both; height:10px;"></div>
				<div style="float: left; width: 150px; height: 30px; line-height: 30px;">Sort By</div>
				<div style="float: left;">
					<select class="selectpicker" id="cat" name="sort">
                    	<option value="title">Name</option>	
                    	<option value="date">Recently Added</option>		
                    </select>
                    <script>jQuery(".selectpicker").selectpicker();</script>
                    <div style="clear: both;  height:10px;"></div>
                    <button class="btn" onclick="">Search</button>
				</div>
				</form>
				<div style="clear: both; height:10px;"></div>
			</div>
			<div style="float: left">
				<h1>Product List</h1>
				<?php if($links) { ?>
					<div class="pagination"><?=$links?></div>
				<?php } ?>
			</div>
			<form method="post" action="<?=base_url()?>admin/cms/actionall" id="action_all_form">
			<div style="float: right; padding-top: 20px;">
				<button type="button" onclick="check_all();" id="btn_select_all"style="margin-bottom: 10px" class="btn btn-inverse">Select All</button>&nbsp;&nbsp;
				<select class="selectpicker" id="cat" name="action" >
					<option value="0">Choose Action</option>
					<option value="1">Activate All</option>
					<option value="2">Deactive All</option>
					<option value="3">Delete All</option>
				</select>&nbsp;&nbsp;
				<button type="button" onclick="$('#action_all_form').submit();" style="margin-bottom: 10px" class="btn btn-inverse">Submit</button>
				<script>jQuery(".selectpicker").selectpicker();</script>
			</div>
			<div style="clear: both">
			</div>
			<table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 12px">
							<th style="width: 3%; font-size: 12px !important">&nbsp;</th>
			    			<th style="width: 47%; font-size: 12px !important">Product Name (Stock ID)</th>
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Stock</th>
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Clone</th>
			    			<!-- <th style="width: 6.25%; text-align: center; font-size: 12px !important">Crosssale</th> -->
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Categories</th>
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Images</th>
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Sale</th>
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Retail</th>
			    			<!--<th style="width: 6.25%; text-align: center; font-size: 12px !important">Trade</th>-->
			    			<th style="width: 6.25%; text-align: center; font-size: 12px !important">Delete</th>
			    			<!-- <th style="width: 60%; text-align: center;" colspan="6">Quick Functions</th> -->
			    		</tr>
			    		
			    	</thead>
			    	<tbody>
			    		<?php foreach($products as $product) { if($product['deleted'] == 0){?>
			    		<tr id="product-<?=$product['id']?>">
			    			<td style="width: 3%; ">
			    				<input type="checkbox" class="check_product" name="check_ed[]" value="<?=$product['id']?>"/>
			    			</td>
			    			<td style="width: 47%; ">
                            
                            	<?
                                $num_desc = strlen($product['short_desc']);
								if($num_desc==''){$word_desc='';}
								$word_desc='- '.$product['short_desc'];
								if($num_desc > 20)
								{
									$word_desc='- '.substr($product['short_desc'],0, 15).'...';	
								}
								?>
			    				<a href="<?=base_url()?>admin/cms/product/edit/<?=$product['id']?>"><?=$product['title']?> <?=$word_desc?>(<?=$product['stock_id']?>)</a>&nbsp;&nbsp;&nbsp;
			    				<a target="_blank" style="text-decoration: none" href="<?=base_url()?>store/detail_product/preview/<?=$product['id_title']?>"><i class="icon icon-search"></i></a>
			    			</td>
			    			<td style="width: 6.25%; text-align: center">
			    				<div id="stock<?=$product['id']?>" class="all_tt" data-toggle="tooltip" title="Update Stock" style="cursor: pointer; text-align: center" onclick="update_stock(<?=$product['id']?>);"><?=$product['stock']?></div>
			    			</td>
			    			<td style="width: 6.25%; ">
			    				<div class="all_tt" data-toggle="tooltip" title="Duplicate" style="cursor: pointer; text-align: center" onclick="copy_product(<?=$product['id']?>);"><i class="icon-share icon-2x"></i></div>
			    			</td>
			    			<!-- <td style="width: 6.25%; ">
			    				<div class="all_tt" data-toggle="tooltip" title="Edit Cross Sale" style="cursor: pointer; text-align: center" onclick="crosssale(<?=$product['id']?>);"><i class="icon-paper-clip icon-2x"></i></div>
			    			</td> -->
			    			<td style="width: 6.25%; ">
			    				<div class="all_tt" data-toggle="tooltip" title="Edit Category" style="cursor: pointer; text-align: center" onclick="show_category(<?=$product['id']?>);"><i class="icon-folder-open icon-2x"></i></div>
			    			</td>
			    			<td style="width: 6.25%; ">
			    				<div style="cursor: pointer; text-align: center" class="all_tt" data-toggle="tooltip" title="Edit Gallery" onclick="gallery(<?=$product['id']?>);"><i class="icon-picture icon-2x"></i></div>
			    			</td>
			    			<td style="width: 6.25%; ">
			    				<div class="all_tt" data-toggle="tooltip" title="Sale Price" style="text-align: center; cursor: pointer; <?php if($product['price'] > $product['sale_price']) {echo "color:#C70520;";}?>" onclick="sale_click(<?=$product['id']?>);">
			    					<i class="icon-tag icon-2x"></i>
			    				</div>
			    			</td>
			    			<td style="width: 6.25%; ">
			    				<?php if($product['status'] == 1) { ?>
		    						<div class="all_tt" data-toggle="tooltip" title="De-actived Product" style="text-align: center; cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/switchstatus/<?=$product['id']?>'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
		    					<?php 
								}
		    					else
		    					{
		    					?>
		    						<div class="all_tt" data-toggle="tooltip" title="Actived Product" style="text-align: center; cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/switchstatus/<?=$product['id']?>'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
		    					<?php	
		    					}
		    					?>
			    			</td>
                            <!--
			    			<td style="width: 6.25%; ">
			    				<?php if($product['status_trade'] == 1) { ?>
		    						<div class="all_tt" data-toggle="tooltip" title="De-actived Product" style="text-align: center; cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/switchstatus_trade/<?=$product['id']?>'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
		    					<?php 
								}
		    					else
		    					{
		    					?>
		    						<div class="all_tt" data-toggle="tooltip" title="Actived Product" style="text-align: center; cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/switchstatus_trade/<?=$product['id']?>'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
		    					<?php	
		    					}
		    					?>
			    			</td>
                            -->
			    			<td style="width: 6.25%; ">
			    				<div class="all_tt" data-toggle="tooltip" title="Delete Product" style="cursor: pointer; text-align: center" onclick="delete_product(<?=$product['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    				</div>
			    			</td>
			    		</tr>
			    		<?php }}?>
			    	</tbody>
			</table>
			</form>
			<!-- end here -->
		</div>
	</div>
</div>

<script>

function check_all()
{
	if(check == 0)
	{
		//alert('check');
		check = 1;
		$('#btn_select_all').text('Unselect All');
		$('.check_product').each(function () { this.click();});
	}
	else
	{
		//alert('uncheck');
		check = 0;
		$('#btn_select_all').text('Select All');
		$('.check_product').each(function () { this.click();});
	}
}

function uncheck_all()
{
	
}

function update_stock(product_id)
{
	choose = product_id;
	var stock = $('#stock'+product_id).text();
	$('#new_stock').val(stock);
	$('#stockModal').modal('show');
}

function updatestock()
{
	$('#stockModal').modal('hide');
	var new_stock = $('#new_stock').val();
	
	if(isNaN(new_stock))
	{
		jQuery('#any_message').html("Please insert a number");
		$('#anyModal').modal('show');
	}
	else
	{
		jQuery.ajax({
		url: '<?=base_url()?>admin/cms/update_stock/',
		type: 'POST',
		data: ({id:choose,stock:new_stock}),
		dataType: "html",
		success: function(html) {
			$('#stock'+choose).text(new_stock);
		}
	});
	}
}

function copy_product(product_id)
{
	choose = product_id;
	$('#new_product_name').val('');
	$('#copyModal').modal('show');
}

function duplicate_product()
{
	$('#copyModal').modal('hide');
	var new_name = $('#new_product_name').val();
	//alert(new_name);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/copy_product/',
		type: 'POST',
		data: ({id:choose,name:new_name}),
		dataType: "html",
		success: function(html) {
			if(html != 0)
			{
				window.location = "<?=base_url()?>admin/cms/product/edit/"+html;
			}
			else
			{
				jQuery('#any_message').html("This name has already exist in the list");
				$('#anyModal').modal('show');
			}
		}
	});
}

function crosssale(product_id) {
	day = new Date();
	id = day.getTime();
	URL = '<?=base_url()?>admin/store/productcrosssale/' + product_id;
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=640,height=700,left = 240,top = 125');");
}

function gallery(product_id) {
	day = new Date();
	id = day.getTime();
	URL = '<?=base_url()?>admin/new_store/productgallery/' + product_id;
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=825,height=600,left = 240,top = 125');");
}
function nothing()
{
	
}
function show_category(id)
{
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/get_product_category/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#list_cat').html(html);
			jQuery('#c_pid').val(id);
			$('#categoryModal').modal('show');
		}
	});
	//$('#categoryModal').modal('show');
}
function setsale()
{
	$('#saleModal').modal('hide');
	var saleprice = jQuery('#saleprice').val();
	var saletradeprice = jQuery('#saletradeprice').val();
	var normalprice = jQuery('#normalprice').html();
	//alert(normalprice);
	jQuery.ajax({
	url: '<?=base_url()?>admin/cms/updatesale',
	type: 'POST',
	data: ({id:choose,saleprice:saleprice,saletradeprice:saletradeprice,normalprice:normalprice}),
	dataType: "html",
	success: function(html) {
		//jQuery('#saletradeprice').val(html);
		//$('#saleModal').modal('show');
		//jQuery('#any_message').html("This new sale price has been set");
		//$('#anyModal').modal('show');
		
		location.reload();
		}
	});
}

function sale_click(id)
{
	choose = id;
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/get_product_saleprice/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#saleprice').val(html);
			jQuery.ajax({
			url: '<?=base_url()?>admin/cms/get_product_saletradeprice/'+id,
			type: 'POST',
			//data: (),
			dataType: "html",
			success: function(html) {
				jQuery('#saletradeprice').val(html);
				
				jQuery.ajax({
				url: '<?=base_url()?>admin/cms/get_product_price/'+id,
				type: 'POST',
				//data: (),
				dataType: "html",
				success: function(html) {
					jQuery('#normalprice').html(html);
					
					jQuery.ajax({
					url: '<?=base_url()?>admin/cms/get_product_tradeprice/'+id,
					type: 'POST',
					//data: (),
					dataType: "html",
					success: function(html) {
						jQuery('#normaltradeprice').html(html);
						
						
						
						$('#saleModal').modal('show');
					}
				});

				}
			});
			
			}
		});
			
		}
	});
	
}

function export_csv() {
	$('#csvModal').modal('show');
}

function exportcsv() {
	$('#csvModal').modal('hide');
	window.location = '<?=base_url()?>admin/cms/exportstock/';
}

function delete_product(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal').modal('show');
}
function deleteproduct(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/deleteproduct/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#product-'+id).fadeOut('slow');
			jQuery('#any_message').html("This coupon has been successfully deleted");
			$('#anyModal').modal('show');
			
		}
	})
}
</script>

<div id="categoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h1 id="myModalLabel">Product Categories</h1>
</div>
<form id="addProduct" method="post" action="<?=base_url()?>admin/cms/updatecategories">
<input type="hidden" id="c_pid" name="product_id" value="">
<div class="modal-body" >
    <div style="height: 300px; overflow: auto;  overflow-x: hidden;" id="list_cat" >
    </div>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary">Set Category</button>
</form>
</div>
</div>

<div id="saleModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h1 id="myModalLabel">Sale Price</h1>
</div>
<div class="modal-body">
	<table style="width: 70%">
		<tr>
			<td style="width: 30%">&nbsp;
				
			</td>
			<td style="width: 30%; font-weight: 700">
				RRP
			</td>
			<td style="width: 30%; font-weight: 700">
				Sale Price
			</td>
		</tr>
		<tr>
			<td>
				Retail 
			</td>
			<td>
				$ <span id="normalprice"></span>
			</td>
			<td>
				<div class="input-prepend" style="margin-bottom: 0px">
				<span class="add-on">$</span>
				<input class="span2" id="saleprice" type="text">
			</div>
			</td>
		</tr>
		<tr>
			<td>
				Trade
			</td>
			<td>
				$ <span id="normaltradeprice"></span>
			</td>
			<td>
				<div class="input-prepend" style="margin-bottom: 0px">
				<span class="add-on">$</span>
				<input class="span2" id="saletradeprice" type="text">
			</div>
			</td>
		</tr>
	</table>
    <!-- <div>
    	<div style="float: left; width: 20%; height: 30px; line-height: 30px;">
    		Sale Price
    	</div>
    	<div style="float: left; width: 80%">
    		
    	</div>
    </div> -->
    <!-- <div style="clear: both; height: 15px;"></div>
    <div>
    	<div style="float: left; width: 20%; height: 30px; line-height: 30px;">
    		Sale Trade Price
    	</div>
    	<div style="float: left; width: 80%">
    		
    	</div>
    </div> -->
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="setsale(choose)">Set Price</button>

</div>
</div>

<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Product</h3>
</div>
<div class="modal-body">
    <p>Are you sure to delete this Product?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deleteproduct(choose)">Delete</button>

</div>
</div>

<div id="csvModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Export CSV Product</h3>
</div>
<div class="modal-body">
    <p>This will export the stock product list to a csv file. Do you want to continue?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="exportcsv();">Export</button>

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

<div id="importModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Import Product</h3>
</div>
<form method="post" action="<?=base_url()?>admin/cms/import_product" enctype="multipart/form-data">
<div class="modal-body">
    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select File</span><span class="fileupload-exists">Change</span>
                    <input type="file" name="userfile" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" type="submit">Upload</button>
</div>
</form>
</div>

<div id="copyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Duplicate Product</h3>
</div>
<div class="modal-body">
	<div>
    	New Product Name
    </div>
    <div>
    	<input type="text" id="new_product_name"/>
    </div>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="duplicate_product();">Copy</button>

</div>
</div>

<div id="stockModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Update Stock</h3>
</div>
<div class="modal-body">
	<div>
    	New Stock
    </div>
    <div>
    	<input type="text" id="new_stock"/>
    </div>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="updatestock();">Update</button>

</div>
</div>