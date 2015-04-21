<script type="text/javascript" src="<?=base_url();?>js/city_states.js"></script>
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
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/shipping'">Back To Shipping Method List</button>
			<div style="height: 20px"></div>
			<form method="post" action="<?=base_url()?>admin/system/addshippingmethod">
				<h1>
					Basic Information
				</h1>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Method name</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Description</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="description" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Set as default</div>
					<div style="width: 80%; float: right">
						<input type="checkbox" name="default" /> This shipping method will be chosen as default at check out page
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<h1>
					Shipping Cost
				</h1>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Price type</div>
					<div style="width: 80%; float: right">
						<input type="hidden" name="price_type" id="price_type" value="1" />
						<div style="float: left; height: 30px; line-height: 30px; width: 120px;">
						Based of weight
						</div>
		                <div style="float: left" class="input-prepend input-append">
		                	<span id="money" class="add-on">$</span>
							<input class="span2" id="appendedInput" name="price_value" type="text">
							<span id="percent" class="add-on">/ Kg</span>
						</div>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
						<input type="hidden" name="price_type_v2" id="price_type_v2" value="2" />
						<div style="float: left; height: 30px; line-height: 30px; width: 120px;">
							Flat Rate
						</div>
						<div style="float: left" class="input-prepend">
		                  	<span id="money" class="add-on">$</span>
							<input style="width: 190px;" class="span2" id="appendedInput" name="price_value_v2" type="text">
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
				
				<div style="height: 5px; clear: both">&nbsp;</div>
				<h1>
					Locations
				</h1>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Region</div>
					<div style="width: 80%; float: right">
						<select onchange="set_country(this,country,city_state)" size="1" name="region">
							<option value="" selected="selected">SELECT REGION</option>
							<option value=""></option>
							<script type="text/javascript">
								setRegions(this);
							</script>
						</select>
					</div>
				</div>
				
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Country</div>
					<div style="width: 80%; float: right">
						<select name="country" size="1" disabled="disabled" onchange="set_city_state(this,city_state)"></select>
					</div>
				</div>
				
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">City/State</div>
					<div style="width: 80%; float: right">
						<select name="city_state" size="1" disabled="disabled" onchange="print_city_state(country,this)"></select>
					</div>
				</div>
				
				
				
				<!-- <div style="height: 5px; clear: both">&nbsp;</div>
				<h1>
					Locations
				</h1>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Countries</div>
					<div style="width: 80%; float: right">
						<select name="countries[]" multiple="multiple" size="10" style="height:auto;">
                        <?php foreach($countries as $ct) { ?>
                            <option value="<?=$ct['id']?>"><?=$ct['name']?></option>
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
                            <option value="<?=$st['id']?>"><?=$st['name']?></option>
                        <?php } ?>
                        </select>
					</div>
				</div> -->
				
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
					    <button class="btn btn-primary" type="submit">Create</button>
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

function minus_cond(id)
{
	//alert(id);
	$('#condition-'+id).fadeOut('slow').delay(100).remove();
}

add_cond(-1);
</script>
