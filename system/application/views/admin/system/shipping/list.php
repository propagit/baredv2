<script>
jQuery(function() {
	jQuery('.edit-ship').tooltip({
		showURL: false
	});
	
	jQuery('.delete-ship').tooltip({
		showURL: false
	});
	
	jQuery('.active-ship').tooltip({
		showURL: false
	});
	
	jQuery('.de-active-ship').tooltip({
		showURL: false
	});
	
});
function duplicate(id)
{
	jQuery('#hidden_id').val(id);
	$('#duplicateModal').modal('show');
}
</script>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
				<h1 style="padding-left: 7px;">
					Shipping Method
				</h1>
			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">

			    			<th style="width: 40%">Method Name</th>
			    			<th style="width: 10%; text-align: center;">Created</th>
			    			<th style="width: 10%; text-align: center;">Type</th>
                            <th style="width: 10%; text-align: center;">Duplicate</th>
			    			<th style="width: 10%; text-align: center;">Edit</th>
			    			<th style="width: 10%; text-align: center;">Active</th>
			    			<th style="width: 10%; text-align: center;">Delete</th>

			    		</tr>

			    	</thead>

			    	<tbody>

			    		<?php foreach($shippings as $ship) { $created = date('d-m-Y',strtotime($ship['created']));?>

			    			<tr id="ship-<?=$ship['id']?>">

			    				<td>Type <?=$ship['zone']?> - <?=$ship['name']?></td>

			    				<td style="text-align: center;"><?=$created?></td>

			    				<td style="text-align: center;">
                                	<?
                                    	if($ship['price_type']==1){echo 'Based on Weight';}
										else 
										if($ship['price_type']==3){echo 'Based on Volume';}
										else
										{echo 'Flat Rate';}
									?>
                                </td>
			    				<td style="text-align: center;">
			    					<div class="edit-ship" data-toggle="tooltip" title="Duplicate Shipping" style="cursor: pointer" onclick="duplicate(<?=$ship['id']?>)">
			    						<i class="icon-copy icon-2x"></i>
			    					</div>
			    				</td>
			    				
                                <td style="text-align: center;">
			    					<div class="edit-ship" data-toggle="tooltip" title="Edit Shipping" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/system/shipping/edit/<?=$ship['id']?>'">
			    						<i class="icon-edit icon-2x"></i>
			    					</div>
			    				</td>
			    				<td style="text-align: center;">
			    					<?php if($ship['actived'] == 1) { ?>
			    						<div class="de-active-ship" data-toggle="tooltip" title="De-actived Shipping" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/system/activeshipping/<?=$ship['id']?>'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-ship" data-toggle="tooltip" title="Actived Shipping" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/system/activeshipping/<?=$ship['id']?>'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>

			    				<td style="text-align: center;">
			    					<div class="delete-ship" data-toggle="tooltip" title="Delete Shipping" style="cursor: pointer" onclick="delete_shipping(<?=$ship['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    					</div>
			    				</td>

			    			</tr>

			    		<?php }?>

			    	</tbody>

			    </table>
			    
			    <div style="height: 20px"></div>
			    <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/system/shipping/add'">Create A Shipping Method</button>

			<!-- end here -->

		</div>

	</div>

</div>

<script>
function delete_shipping(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal').modal('show');
}
function deleteshipping(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/deleteshipping/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#ship-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This shipping method has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
}
</script>
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Shipping Method</h3>
</div>
<div class="modal-body">
    <p>Are you sure to delete this shipping method?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deleteshipping(choose)">Delete</button>

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

<div id="duplicateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Duplicate Shipping Method </h3>
</div>
<form name="formDuplicate" id="formDuplicate" method="post" action="<?=base_url()?>admin/system/duplicate_shipping">
<input type="hidden" id="hidden_id" name="hidden_id" val="" />
<div class="modal-body">
    <p> Name: </p>
    <input style="width: 97%" type="text" class="textfield rounded" id="name_duplicate" name="name_duplicate" value=""/>
</div>
<div class="modal-footer">
<button class="btn btn-primary" type="submit">Save</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
</form>
</div>
</div>