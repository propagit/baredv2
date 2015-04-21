<style>
h1 {
    font-size: 20px !important;
    font-weight: 900;
}
</style>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1 style="padding-left:7px;">
				Edit Shipping Method
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/shipping'">Back To Shipping Method List</button>
			<div style="height: 20px"></div>
			<?php if($this->session->flashdata('updated')) { ?>
			    <div class="alert alert-success">
			    	<button type="button" class="close" onclick="$('.alert-success').fadeOut('slow');">&times;</button>
					<strong>Shipping Method Updated!</strong>
				</div>
			<?php }?>
			<form method="post" action="<?=base_url()?>admin/system/updateshippingmethod">
				<h2 style="padding-left:7px;">
					Basic Information
				</h2>
				<input type="hidden" name="shipping_id" value="<?=$shipping['id']?>" />
				<div style="padding-left:7px;">
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Method name</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value="<?=$shipping['name']?>"/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div style="padding-left:7px;">
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Description</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="description" value="<?=$shipping['description']?>"/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Set as default</div>
					<div style="width: 80%; float: right">
						<input type="checkbox" name="default" /> This shipping method will be chosen as default at check out page
					</div>
				</div>
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div class="line-between">&nbsp;</div>
				<h2>
					Shipping Cost
				</h2>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Price type</div>
					<div style="width: 80%; float: right">
						<input type="hidden" name="price_type" id="price_type" value="1" />
						<div style="float: left; height: 30px; line-height: 30px; width: 120px;">
						Based of weight
						</div>
		                <div style="float: left" class="input-prepend input-append">
		                	<span id="money" class="add-on">$</span>
							<input class="span2" id="appendedInput" name="price_value" type="text" value="<?=$shipping['price_value']?>">
							<span id="percent" class="add-on">/ Kg</span>
						</div>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
						<input type="hidden" name="price_type_v2" id="price_type_v2" value="2" value="<?=$shipping2['price_value']?>"/>
						<div style="float: left; height: 30px; line-height: 30px; width: 120px;">
							Flat Rate
						</div>
						<div style="float: left" class="input-prepend">
		                  	<span id="money" class="add-on">$</span>
							<input class="span2" id="appendedInput" name="price_value_v2" style="width:190px" type="text">
						</div>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<h5>
					Shipping Cost by Condition
				</h5>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Cost</div>
					<div style="width: 80%; float: right" id="allcond">
						<!-- <div id="condition-0"style="margin-bottom: 10px;">
							<div class="input-prepend" style="margin-bottom: 0">
			                  	<span id="money" class="add-on">$</span>
								<input class="span2" id="appendedInput" name="prices[]" type="text">
							</div>
							&nbsp;&nbsp;&nbsp;if they spend more than
							&nbsp;&nbsp;&nbsp;
							<div class="input-prepend" style="margin-bottom: 0">
			                  	<span id="money" class="add-on">$</span>
								<input class="span2" id="appendedInput" name="conditions[]" type="text">
							</div>
							&nbsp;&nbsp;&nbsp;
							<button type="button" id="add-0" class="btn btn-primary"  onclick="add_cond(0);"><i class="icon-plus"></i></button>
							<button type="button" id="minus-0" class="btn btn-primary" style="display: none;" onclick="minus_cond(0);"><i class="icon-minus"></i></button>
						</div> -->
					</div>
				</div>
				
				
				
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div class="line-between">&nbsp;</div>
				<h2>
					Locations
				</h2>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Countries</div>
					<div style="width: 80%; float: right">
						<select name="countries[]" multiple="multiple" size="10" style="height:auto;">
                        <?php foreach($countries as $ct) { ?>
                            <option <?php if($this->System_model->shipping_country($shipping['id'],$ct['id'])) print ' selected="selected"'; ?> value="<?=$ct['id']?>"><?=$ct['name']?></option>
                        <?php } ?>
                        </select>
					</div>
				</div>
				
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available States</div>
					<div style="width: 80%; float: right">
						<select name="states[]" multiple="multiple" size="10" style="height:auto;">
                        <?php foreach($states as $st) { ?>
                            <option <?php if($this->System_model->shipping_state($shipping['id'],$st['id'])) print ' selected="selected"'; ?> value="<?=$st['id']?>"><?=$st['name']?></option>
                        <?php } ?>
                        </select>
					</div>
				</div>
				
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
					    <button class="btn btn-primary" type="submit">Update</button>
					</div>
				</div>
			</form>
			<div style="height: 0px; clear: both">&nbsp;</div>
			<!-- end here -->
		</div>
	</div>
</div>

<script>
function add_cond(id)
{
	//alert(id);
	$('#add-'+id).hide();
	$('#minus-'+id).show();
	id = id + 1;
	var out = '<div id="condition-'+id+'"style="margin-bottom: 10px;">';
	out += '<div class="input-prepend" style="margin-bottom: 0">';
	out += '<span id="money" class="add-on">$</span>';
	out += '<input class="span2" id="appendedInput" name="prices[]" type="text">';
	out += '</div>';
	out += '&nbsp;&nbsp;&nbsp; if they spend more than';
	out += '&nbsp;&nbsp;&nbsp;';
	out += '<div class="input-prepend" style="margin-bottom: 0">';
	out += '<span id="money" class="add-on">$</span>';
	out += '<input class="span2" id="appendedInput" name="conditions[]" type="text">';
	out += '</div>';
	out += '&nbsp;&nbsp;&nbsp;';
	out += '<button type="button" id="add-'+id+'" class="btn btn-primary"  onclick="add_cond('+id+');"><i class="icon-plus"></i></button>';
	out += '<button type="button" id="minus-'+id+'" class="btn btn-primary" style="display: none;" onclick="minus_cond('+id+');"><i class="icon-minus"></i></button>';
	out += '</div>';	
	
	$('#allcond').append(out);					
	
}

function add_cond2(id,price,cond)
{
	//alert(id);
	$('#add-'+id).hide();
	$('#minus-'+id).show();
	id = id + 1;
	var out = '<div id="condition-'+id+'"style="margin-bottom: 10px;">';
	out += '<div class="input-prepend" style="margin-bottom: 0">';
	out += '<span id="money" class="add-on">$</span>';
	out += '<input class="span2" id="appendedInput" name="prices[]" type="text" value="'+price+'">';
	out += '</div>';
	out += '&nbsp;&nbsp;&nbsp; if they spend more than';
	out += '&nbsp;&nbsp;&nbsp;';
	out += '<div class="input-prepend" style="margin-bottom: 0">';
	out += '<span id="money" class="add-on">$</span>';
	out += '<input class="span2" id="appendedInput" name="conditions[]" type="text" value="'+cond+'">';
	out += '</div>';
	out += '&nbsp;&nbsp;&nbsp;';
	out += '<button type="button" id="add-'+id+'" class="btn btn-primary"  onclick="add_cond('+id+');"><i class="icon-plus"></i></button>';
	out += '<button type="button" id="minus-'+id+'" class="btn btn-primary" style="display: none;" onclick="minus_cond('+id+');"><i class="icon-minus"></i></button>';
	out += '</div>';	
	
	$('#allcond').append(out);					
	
}

function minus_cond(id)
{
	//alert(id);
	$('#condition-'+id).fadeOut('slow').delay(100).remove();
}

<?php
	if(count($conditions) > 0)
	{
		$cc = -1;
		foreach($conditions as $c)
		{
			$price = $c['price'];
			$cond = $c['condition'];
			echo "add_cond2($cc,$price,$cond);";
			$cc++;
		}
	}
	else
	{
		//echo "alert('aaa');";
		echo "add_cond(-1);";
	}
?>

//add_cond(-1);
</script>
