<script>

var choose = 0;

</script>

<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

				<h1 style="padding-left: 7px;">

					Edit Product Attributes

				</h1>

				<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/attribute'" style="padding-left: 7px;">Back To Attribute List</button>

				<div style="height: 10px;"></div>

			    <form id="form1" method="post" action="<?=base_url()?>admin/system/updateattribute">

			    	<input type="hidden" name="attribute_id" value="<?=$attribute['id']?>"/>

				    <div class="well" id="attlist" style="padding-left: 7px;">

				    	<div>

				    		Attribute: <span id="att_title" style="font-weight: 700"><?=$attribute['name']?></span> (Add option by the input field below)

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

				    		<button class="btn btn-primary" type="button" onclick="submit1();">Update</button>

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

	//var title = $('#name').val().trim();

	//$('#name123').val(title);

	//alert(title);

	$('#form1').submit();

	

}



function reset()

{

	$('#btnreset').fadeOut('slow');

	$('#name').removeAttr("readonly"); 

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

		$('#btnstart').attr("readonly", true); 

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



function load_att_item(input)

{

	//alert('aa');

	var text = '';

	text += '<div id="list'+cc+'" class="alert alert-info" style="margin-bottom: 0px;">';

	text += '<button type="button" onclick="close_list('+cc+');" class="close">&times;</button>';

	text += input;

	text += '<input type="hidden" name="options[]" value="'+input+'"/>';

	text += '</div>';

	

	$('#att_list').append(text);

	cc++;

	jQuery('#att_item').val('');

}



<?php

	$options = $attribute['options'];

	$n = count($options);

	

	for($i=0;$i<$n;$i++)

	{

		$tt = $options[$i];

		echo "load_att_item('$tt');";

	}

?>



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