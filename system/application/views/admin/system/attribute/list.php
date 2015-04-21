<script>

var choose = 0;

jQuery(function() {
	jQuery('.edit-att').tooltip({
		showURL: false
	});
	
	jQuery('.delete-att').tooltip({
		showURL: false
	});
	
});

</script>

<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

				<h1 style="padding-left: 7px;">

					Product Attributes

				</h1>

			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">

			    			<th style="width: 70%">Attribute Name</th>

			    			<th style="width: 15%; text-align: center;">Edit</th>

			    			<th style="width: 15%; text-align: center;">Delete</th>

			    		</tr>

			    	</thead>

			    	<tbody>

			    		<?php foreach($attributes as $att) { ?>

			    			<tr id="att-<?=$att['id']?>">

			    				<td><?=$att['name']?></td>

			    				<td style="text-align: center;">

			    					<span class="edit-att" data-toggle="tooltip" title="Edit Attribute" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/system/attribute/edit/<?=$att['id']?>'">

			    						<i class="icon-edit icon-2x"></i>

			    					</span>

			    				</td>

			    				<td style="text-align: center;">

			    					<span class="delete-att" data-toggle="tooltip" title="Delete Attribute" style="cursor: pointer" onclick="delete_att(<?=$att['id']?>);">

			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>

			    					</span>

			    				</td>

			    			</tr>

			    		<?php }?>

			    	</tbody>

			    </table>

			    <div style="height: 10px"></div>

			    <div style="padding-left: 7px;">

			    	<span style="font-size: 16px; font-weight: 700">Create Product Attribute</span><br/>

			    	Please enter an attribute name such as Colour that is used to identify your option when you create a product.

			    </div>

			    <div style="height: 10px"></div>

			    <form id="form1" method="post" action="<?=base_url()?>admin/system/addattribute">

			    	<input type="hidden" id="name123" name="name123" value=""/>

				    <div style="padding-left: 7px;">

				    	<input style="margin:0px;" type="text" class="textfield rounded" id="name" name="namea" value=""/>

				    	<button class="btn btn-primary" id="btnstart" type="button" onclick="start();">Start</button>

				    	<button style="display: none" class="btn btn-danger" type="button" id="btnreset" onclick="reset1();">Reset</button>

				    </div>

				    <div style="height: 10px"></div>

				    

				    <div class="well" id="attlist" style="display: none;padding-left:7px;">

				    	<div>

				    		Attribute: <span id="att_title" style="font-weight: 700">aa</span> (Add option by the input field below)

				    	</div>

				    	<div style="margin-top: 5px;">

				    		<div style="float: left; width: 50%">

			    			    <div class="input-append" style="width:100%">

								    <input class="span2"  id="att_item" type="text" style="width:80%">

								    <button style="height: 30px;" class="btn" type="button" onclick="new_att_item();" type="button"><i class="icon-chevron-right"></i></button>

							    </div>

				    		</div>

				    		<div style="float: right; width: 50%" id="att_list">

	

				    		</div>

				    	</div>

				    	<div style="clear: both"></div>

				    	<div style="float: right; margin-top: 10px">

				    		<button class="btn btn-primary" type="button" onclick="submit1();">Complete</button>

				    	</div>

				    	<div style="clear: both"></div>

				    </div>

			    </form>

			<!-- end here -->

		</div>

	</div>

</div>

<script>

var cc= 1;



function submit1()

{

	var title = $('#name').val().trim();

	$('#name123').val(title);

	//alert(title);

	$('#form1').submit();

	

}



function reset1()

{

	//alert('aa');

	$('#btnreset').fadeOut('slow');

	$('#name').removeAttr("disabled"); 

	$('#name').val('');

	$('#btnstart').removeAttr("disabled"); 

	$('#attlist').fadeOut('slow');

}



function start()

{

	var title = $('#name').val().trim();

	if(title != '')

	{

		$('#name').attr("disabled", true); 

		$('#btnstart').attr("disabled", true); 

		$('#attlist').fadeIn('slow');

		$('#btnreset').fadeIn('slow');

		$('#att_title').html(title);

	}

	else

	{

		jQuery('#any_message').html("Please insert an attribute name");

		$('#anyModal').modal('show');

	}

}



function close_list(cc)

{

	$('#list'+cc).remove();

}

function new_att_item()

{

	//alert('aa');

	var text = '';

	var name = jQuery('#att_item').val();

	//alert(name);

	if(name.trim() != '')

	{

		text += '<div id="list'+cc+'" class="alert alert-info" style="margin-bottom: 0px;">';

		text += '<button type="button" onclick="close_list('+cc+');" class="close">&times;</button>';

		text += name;

		text += '<input type="hidden" name="options[]" value="'+name+'"/>';

		text += '</div>';

		

		$('#att_list').append(text);

		cc++;

		jQuery('#att_item').val('');

	}

	else

	{

		jQuery('#any_message').html("Please insert an attribute name");

		$('#anyModal').modal('show');

	}

}



function delete_att(id)

{

	choose = id;

	//alert(id);

	$('#deleteModal').modal('show');

}

function deleteatt(id)

{

	$('#deleteModal').modal('hide');

	//alert(id);

	

	jQuery.ajax({

		url: '<?=base_url()?>admin/system/deleteattribute/'+id,

		type: 'POST',

		//data: (),

		dataType: "html",

		success: function(html) {

			jQuery('#att-'+id).fadeOut('slow');

			jQuery('#any_message').html("This attribute has been successfully deleted");

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

    <p>Are you sure to delete this Attribute?</p>

</div>

<div class="modal-footer">

<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

<button class="btn btn-primary" onclick="deleteatt(choose)">Delete</button>



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