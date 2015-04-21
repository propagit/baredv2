<script>

var choose = 0;

</script>

<script>
jQuery(function() {
	jQuery('.edit-tax').tooltip({
		showURL: false
	});
	
	jQuery('.delete-tax').tooltip({
		showURL: false
	});
	
	jQuery('.active-tax').tooltip({
		showURL: false
	});
	
	jQuery('.de-active-tax').tooltip({
		showURL: false
	});
	
});
</script>

<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

				<h1 style="padding-left: 7px;">

					Manage Taxes

				</h1>

			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">

			    			<th style="width: 50%">Tax Name</th>

			    			<th style="width: 20%; text-align: center;">Cost</th>

			    			<th style="width: 10%; text-align: center;">Edit</th>

			    			<th style="width: 10%; text-align: center;">Active</th>

			    			<th style="width: 10%; text-align: center;">Delete</th>

			    		</tr>

			    	</thead>

			    	<tbody>

			    		<?php foreach($taxes as $tax) { ?>

			    			<tr id="tax-<?=$tax['id']?>">

			    				<td><?=$tax['name']?></td>

			    				<td style="text-align: center;"><?php if($tax['type'] == 1) print $tax['value'].'%'; ?></td>

			    				<td  style="text-align: center;">

			    					<div class="edit-tax" data-toggle="tooltip" title="Edit Tax"  style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/system/tax/edit/<?=$tax['id']?>'">

			    						<i class="icon-edit icon-2x"></i>

			    					</div>

			    				</td>

			    				<td style="text-align: center;">

			    					<?php if($tax['actived'] == 1) { ?>

			    						<div class="edit-tax" data-toggle="tooltip" title="De-actived Tax" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/system/activetax/<?=$tax['id']?>'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>

			    					<?php 

									}

			    					else

			    					{

			    					?>

			    						<div class="edit-tax" data-toggle="tooltip" title="Actived Tax" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/system/activetax/<?=$tax['id']?>'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>

			    					<?php	

			    					}

			    					?>

			    				</td>

			    				<td style="text-align: center;">

			    					<div class="edit-tax" data-toggle="tooltip" title="Delete Tax" style="cursor: pointer" onclick="delete_tax(<?=$tax['id']?>);">

			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>

			    					</div>

			    				</td>

			    			</tr>

			    		<?php }?>

			    	</tbody>

			    </table>

			    <div style="height: 20px"></div>

			    <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/system/tax/add'">Create A Tax</button>

			<!-- end here -->

		</div>

	</div>

</div>

<script>

function delete_tax(id)

{

	choose = id;

	//alert(id);

	$('#deleteModal').modal('show');

}

function deletetax(id)

{

	$('#deleteModal').modal('hide');

	//alert(id);

	

	jQuery.ajax({

		url: '<?=base_url()?>admin/system/deletetax/'+id,

		type: 'POST',

		//data: (),

		dataType: "html",

		success: function(html) {

			jQuery('#tax-'+id).fadeOut('slow');

			jQuery('#any_message').html("This tax has been successfully deleted");

			$('#anyModal').modal('show');

			

		}

	})

}

</script>

<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

<h3 id="myModalLabel">Delete Taxes</h3>

</div>

<div class="modal-body">

    <p>Are you sure to delete this Tax?</p>

</div>

<div class="modal-footer">

<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

<button class="btn btn-primary" onclick="deletetax(choose)">Delete</button>



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