<script>
jQuery(function() {
	jQuery('.edit-cp').tooltip({
		showURL: false
	});
	
	jQuery('.delete-cp').tooltip({
		showURL: false
	});
	
	jQuery('.active-cp').tooltip({
		showURL: false
	});
	
	jQuery('.de-active-cp').tooltip({
		showURL: false
	});
	
});
function check_home(id,type)
{
	var i=0;
	jQuery('.icon-heart').each(function() {
		if($(this).attr("id")=='green')
		{
			i=i+1;
		}
	});
	if(i==3 && type=='gray')
	{
		jQuery('#any_message').html("You can only have 3 active promotions display on the homepage at one time. Please deselect a promotion to add a new promotion. ");
		$('#anyModal').modal('show');
	}
	else
	{
		window.location = '<?=base_url()?>admin/cms/homepromo/'+id;
	}
}
</script>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
				<h1 style="padding-left: 7px;">
					Promotions
				</h1>
			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">

			    			<th style="width: 50%">Promotion Title</th>			    			
			    			<th style="width: 20%; text-align: center;">Created</th>
			    			<th style="width: 10%; text-align: center;">Edit</th>
                            <th style="width: 10%; text-align: center;">Home</th>
			    			<th style="width: 10%; text-align: center;">Active</th>
			    			<th style="width: 10%; text-align: center;">Delete</th>

			    		</tr>

			    	</thead>

			    	<tbody>

			    		<?php foreach($promotions as $promo) { ?>

			    			<tr id="promo-<?=$promo['id']?>">

			    				<td><?=$promo['title']?> </td>

			    				<td style="text-align: center;"><?=date('d-M-Y',strtotime($promo['created']))?></td>
			    				
			    				
			    				<td style="text-align: center;">
			    					<div class="edit-cp" data-toggle="tooltip" title="Edit Promotion" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/edit_promo/<?=$promo['id']?>'">
			    						<i class="icon-edit icon-2x"></i>
			    					</div>
			    				</td>
                                <td style="text-align: center;">
			    					<?php if($promo['home'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Promotion in Homepage" style="cursor: pointer;" onclick="check_home(<?=$promo['id']?>,'green');"><i style="color: #00c717" id='green' class="icon-2x icon-heart"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Promotion in Homepage" style="cursor: pointer" onclick="check_home(<?=$promo['id']?>,'gray');"><i style="color: #d6d6d6" id='gray' class="icon-2x icon-heart"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>
			    				<td style="text-align: center;">
			    					<?php if($promo['status'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Promotion" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/activepromo/<?=$promo['id']?>'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Promotion" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/activepromo/<?=$promo['id']?>'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>
                                

			    				<td style="text-align: center;">
			    					<div class="delete-cp" data-toggle="tooltip" title="Delete Promotion" style="cursor: pointer" onclick="delete_promo(<?=$promo['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    					</div>
			    				</td>

			    			</tr>

			    		<?php }?>

			    	</tbody>

			    </table>
			    
			    <div style="height: 20px"></div>
			    <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/add_promo'">Create A Promotion</button>

			<!-- end here -->

		</div>

	</div>

</div>

<script>
function delete_promo(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal').modal('show');
}
function deletepromo(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/deletepromo/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#promo-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This coupon has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
}
</script>
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Promotion</h3>

</div>
<div class="modal-body">
    <p>Are you sure to delete this promotion?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletepromo(choose)">Delete</button>

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