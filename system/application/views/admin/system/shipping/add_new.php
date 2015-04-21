<script>
$(function() {       
	jQuery('.overwrite').tooltip({
		showURL: false
	});
	
	
	jQuery('.selectpicker').selectpicker();
	
		if ($("#optionsType1").is(":checked")) {
			jQuery('#based-weight').show();
			jQuery('#flat-rate').hide();
			jQuery('#based-volume').hide();
		}
		else
		if ($("#optionsType2").is(":checked")) {
			jQuery('#based-weight').hide();
			jQuery('#based-volume').hide();
			jQuery('#flat-rate').show();
		}
		else
		if ($("#optionsType3").is(":checked")) {
			jQuery('#based-weight').hide();
			jQuery('#flat-rate').hide();
			jQuery('#based-volume').show();
		}

	jQuery('#detail-shipping').hide();
	
});
function check_shipping_type()
{
	if ($("#optionsType1").is(":checked")) {
		jQuery('#based-weight').show();
		jQuery('#flat-rate').hide();
		jQuery('#based-volume').hide();
	}
	else
	if ($("#optionsType2").is(":checked")) {
		jQuery('#based-weight').hide();
		jQuery('#based-volume').hide();
		jQuery('#flat-rate').show();
	}
	else
	if ($("#optionsType3").is(":checked")) {
		jQuery('#based-weight').hide();
		jQuery('#flat-rate').hide();
		jQuery('#based-volume').show();
	}
}
function create_shipping()
{
	var zone = jQuery('#zone').val();
	var name = jQuery('#name').val();
	if ($('#default').is(':checked')) {
		var default_shipping =1;
	} else {
		var default_shipping =0;
	} 
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/create_shipping',
		type: 'POST',
		data: ({zone:zone,name:name,default_shipping:default_shipping}),
		dataType: "html",
		success: function(html) {
			jQuery('#shipping_id').val(html);
			jQuery('#detail-shipping').show();
		}
	})	
}
function change_suburb()
{
	var state = jQuery('#states').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/change_state/'+state,
		type: 'POST',
		dataType: "html",
		success: function(html) {
			jQuery('#suburb-default').html(html);
		}
	})	
}
function change_zone_suburb()
{
	var shipping_id = jQuery('#shipping_id').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/change_zone_suburb/'+shipping_id,
		type: 'POST',
		dataType: "html",
		success: function(html) {
			jQuery('#suburb-zone').html(html);
		}
	})	
}

function set_suburb()
{
	var zone=jQuery('#zone').val();
	var shipping_id = jQuery('#shipping_id').val();
	
	if( jQuery('#suburbs :selected').length > 0){
        //build an array of selected values
        var selectedsuburbs = [];
        jQuery('#suburbs :selected').each(function(i, selected) {
            selectedsuburbs[i] = jQuery(selected).val();
        });
		jQuery.ajax({
			url: '<?=base_url()?>admin/system/addzonesuburb',
			type: 'POST',
			data: {zone:zone,shipping_id:shipping_id,suburbs:JSON.stringify(selectedsuburbs)},
			dataType: "html",
			success: function(html) {			
				change_zone_suburb();
			}
		})
	}
	else
	{
		alert('Please select suburbs first');
	}
}
function remove_suburb()
{
	var zone=jQuery('#zone').val();
	var shipping_id = jQuery('#shipping_id').val();
	if( jQuery('#suburbs_zone :selected').length > 0){
        //build an array of selected values
        var selectedsuburbs = [];
        jQuery('#suburbs_zone :selected').each(function(i, selected) {
            selectedsuburbs[i] = jQuery(selected).val();
        });
		jQuery.ajax({
			url: '<?=base_url()?>admin/system/removezonesuburb',
			type: 'POST',
			data: {zone:zone,shipping_id:shipping_id,suburbs:JSON.stringify(selectedsuburbs)},
			dataType: "html",
			success: function(html) {			
				change_zone_suburb();
			}
		})
	}
	else
	{
		alert('Please select suburbs first');
	}
}


function set_country()
{
	var zone=jQuery('#zone').val();
	var shipping_id = jQuery('#shipping_id').val();
	
	if( jQuery('#country :selected').length > 0){
        //build an array of selected values
        var selectedsuburbs = [];
        jQuery('#country :selected').each(function(i, selected) {
            selectedsuburbs[i] = jQuery(selected).val();
        });
		jQuery.ajax({
			url: '<?=base_url()?>admin/system/addzonecountry',
			type: 'POST',
			data: {zone:zone,shipping_id:shipping_id,suburbs:JSON.stringify(selectedsuburbs)},
			dataType: "html",
			success: function(html) {			
				change_zone_country();
			}
		})
	}
	else
	{
		alert('Please select country first');
	}
}

function remove_country()
{
	var zone=jQuery('#zone').val();
	var shipping_id = jQuery('#shipping_id').val();
	if( jQuery('#country_zone :selected').length > 0){
        //build an array of selected values
        var selectedsuburbs = [];
        jQuery('#country_zone :selected').each(function(i, selected) {
            selectedsuburbs[i] = jQuery(selected).val();
        });
		jQuery.ajax({
			url: '<?=base_url()?>admin/system/removezonecountry',
			type: 'POST',
			data: {zone:zone,shipping_id:shipping_id,suburbs:JSON.stringify(selectedsuburbs)},
			dataType: "html",
			success: function(html) {			
				change_zone_country();
			}
		})
	}
	else
	{
		alert('Please select country first');
	}
}

function change_zone_country()
{
	var shipping_id = jQuery('#shipping_id').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/change_zone_country/'+shipping_id,
		type: 'POST',
		dataType: "html",
		success: function(html) {
			jQuery('#country-zone').html(html);
		}
	})	
}


function update_shipping()
{
	var shipping_id = jQuery('#shipping_id').val();
	var name = jQuery('#name').val();
	var zone = jQuery('#zone').val();
	if ($("#optionsType1").is(":checked")) {
		var price_type = 1;
		var price_value =jQuery('#price_value1').val();
	}
	else
	if ($("#optionsType2").is(":checked")) {
		var price_type = 2;
		var price_value =jQuery('#price_value2').val();
	}
	else
	if ($("#optionsType3").is(":checked")) {
		var price_type = 3;
		var price_value =jQuery('#price_value3').val();
	}
	
	var prices = new Array();
	$("input[name=prices]").each(function() {
	   prices.push($(this).val());
	});
	var base_rate = jQuery('#base_rate').val();
	var conditions = new Array();
	$("input[name=conditions]").each(function() {
	   conditions.push($(this).val());
	});
	if ($('#default').is(':checked')) {
		var default_shipping =1;
	} else {
		var default_shipping =0;
	} 
	
	var country_id = jQuery('#countries').val();
	var state_id = jQuery('#states').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/update_shipping',
		type: 'POST',
		data: {country_id:country_id,state_id:state_id,name:name,zone:zone,default_shipping:default_shipping,shipping_id:shipping_id,price_type:price_type,price_value:price_value,prices:prices,conditions:conditions,base_rate:base_rate},
		dataType: "html",
		success: function(html) {		
			
			window.location="<?=base_url()?>admin/system/shipping";
		}
	})
	
}
function change_country()
{
	if(jQuery('#countries').val()!=13){
		jQuery('#a_states').hide();
		jQuery('#b_states').show();
	}else
	{
		jQuery('#a_states').show();
		jQuery('#b_states').hide();
	}
}
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Add Shipping Method
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/shipping'">Back To Shipping Method List</button>
			<div style="height: 20px"></div>			
                <div>
                	<div style="float:left;width: 20%;">Create</div>	
                    <div style="float:left; ">	
                    	<? if(count($shipping_zone)==0){$zone=1;}else{$zone=$shipping_zone['zone']+1;}?>
                    	<div style="margin-top:6px;">Type <?=$zone;?></div>
                        <input type="hidden" name="zone" id="zone" value="<?=$zone;?>"/>
                    </div>
                    <div style="float:left; margin-left:20px;"><input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value=""/></div>
                    <div style="float:left; margin-left:20px;"><button class="btn btn-primary" type="button" onClick="create_shipping();">Create</button></div>
                </div>
                
                <input type="hidden" id="shipping_id" name="shipping_id">
          
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div >
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Set as default</div>
					<div style="width: 80%; float: right">
						<input type="checkbox" name="default" id="default" style="margin-top:0px!important;" /> This shipping method will be chosen as default at check out page
					</div>
				</div>
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div class="line-between">&nbsp;</div>
                <div style="height: 10px; clear: both">&nbsp;</div>
                
                
                <div style="display:none;" id="detail-shipping"> 
                    <h2>
                        Shipping Cost
                    </h2>
                    <div>
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Shipping type</div>
                        <div style="width: 80%; float: right">						
                            <div>		
                            <input type="radio" name="optionsRadios" id="optionsType1" value="1" onChange="check_shipping_type()" checked style="margin-top:0px!important;"> Based of weight
                            </div>
                            <div style="margin-top:5px;">
                            <input type="radio" name="optionsRadios" id="optionsType2" value="2" onChange="check_shipping_type()" style="margin-top:0px!important;"> Flat Rate
                            </div>
                            <div style="margin-top:5px;">
                            <input type="radio" name="optionsRadios" id="optionsType3" value="3" onChange="check_shipping_type()" style="margin-top:0px!important;"> Based on volume
                            </div>
                            <div style="height: 5px; ">&nbsp;</div>
                        </div>
                    </div>
					<div style="height: 5px; clear: both">&nbsp;</div>
                    <div id="based-volume">
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Price type</div>
                        <div style="width: 80%; float: right">
                            
                            <div style="float: left; height: 30px; line-height: 30px; width: 120px;">
                            Based on volume
                            </div>
                            <div style="float: left" class="input-prepend input-append">
                                <span id="money" class="add-on">$</span>
                                <input class="span2" id="price_value3" name="price_value_v3" type="text" value="">
                                <span id="percent" class="add-on">/ Vol</span>
                            </div>
                        </div>
                    </div>
                    <div id="based-weight">
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Price type</div>
                        <div style="width: 80%; float: right">
                            
                            <div style="float: left; height: 30px; line-height: 30px; width: 120px;">
                            Based of weight
                            </div>
                            <div style="float: left" class="input-prepend input-append">
                                <span id="money" class="add-on">$</span>
                                <input class="span2" id="price_value1" name="price_value" type="text">
                                <span id="percent" class="add-on">/ Kg</span>
                            </div>
                        </div>
                    </div>
				
                    <div id="flat-rate">
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Price type</div>
                        <div style="width: 80%; float: right">
                            
                            <div style="float: left; height: 30px; line-height: 30px; width: 120px;">
                                Flat Rate
                            </div>
                            <div style="float: left" class="input-prepend">
                                <span id="money" class="add-on">$</span>
                                <input style="width: 190px;" class="span2" id="price_value2" name="price_value_v2" type="text">
                            </div>
                        </div>
                    </div>
                    <div id="base-rate">
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;&nbsp;</div>
                        <div style="width: 80%; float: right">
                            
                            <div style="float: left; height: 30px; line-height: 30px; width: 120px;">
                                Base Rate
                            </div>
                            <div style="float: left" class="input-prepend">
                                <span id="money" class="add-on">$</span>
                                <input style="width: 190px;" class="span2" id="base_rate" name="base_rate" type="text" >
                            </div>
                        </div>
                    </div>
                	<div style="height: 20px; clear: both">&nbsp;</div>
					<div class="line-between">&nbsp;</div>
					<div style="height: 5px; clear: both">&nbsp;</div>
                    <h2>
                        Shipping Condition <span class="overwrite" data-toggle="tooltip" title="This condition will overwrite the shipping cost. You can use this function to set up free shipping if the user spends over a certain amount." style="cursor: pointer"><i class="icon-question-sign 2x"></i> </span>
                    </h2>
                    <div>
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Shipping Cost</div>
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
                        Zones
                    </h2>
                    <div>
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Countries</div>
                        <div style="width: 80%; float: right">
                            <select name="countries" id="countries" class="selectpicker" onChange="change_country()">
                            <?php foreach($countries as $ct) { 
                                if($ct['id'] == 13 || $ct['id'] == 238)
                                {
                            ?>
                                <option value="<?=$ct['id']?>" <? if($ct['id']==13){echo 'selected=selected';}?> ><?=$ct['name']?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
				
					<div style="height: 5px; clear: both">&nbsp;</div>
				
                    <!-- int -->
                    <div id="b_states" style="display: none">
                        <div style="height: 5px; clear: both">&nbsp;</div>
                        <div >
                            <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Countries</div>
                            <div style="margin-left:242px; width: 20%; float: left; height: 30px; line-height: 30px;">Available Countries</div>
                        </div>
                        <div style="height: 5px; clear: both">&nbsp;</div>
                        <div>
                        
                            <div style="width:250px; float:left;" id="country-default">
                                
                                <select name="country" multiple="multiple" id="country" style="height:250px;width:250px;"> 
                                <?php foreach($countries as $ct) { 
                                    if($ct['id'] != 13 || $ct['id'] != 238)
                                    {?>
                                    <option value="<?=$ct['id']?>"><?=$ct['name']?></option>
                                <?php }} ?>
                                </select>
                            </div>
                            
                            <div style="float:left; margin-left:50px; margin-right:50px;">
                                <div style="margin-top:100px;">
                                    <div style="float:left;margin-right:20px; cursor:pointer;" onClick="remove_country();"><i class="icon-double-angle-left icon-2x"></i></div>
                                    <div style="float:left; cursor:pointer;" onClick="set_country();"><i class="icon-double-angle-right icon-2x"></i></div>
                                </div>
                            </div>
                            <div style="width:250px; float:left;" id="country-zone">
                                <select name="country_zone" multiple="multiple" id="country_zone" style="height:250px;width:250px;"> 
                                </select>
                            </div>
                        </div>
                    </div>
				
                    <!-- aus -->
                    <div id="a_states">
                        <div >
                            <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available States</div>
                            <div style="width: 80%; float: right">
                                <select name="states" class="selectpicker" id="states" onChange="change_suburb();">
                                <?php foreach($states as $st) { ?>
                                    <option value="<?=$st['id']?>" <? if($st['id']==1){echo "selected=selected";}?> ><?=$st['name']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div style="height: 5px; clear: both">&nbsp;</div>
                        <div >
                            <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Suburbs</div>
                            <div style="margin-left:242px; width: 20%; float: left; height: 30px; line-height: 30px;">Available Suburbs</div>
                        </div>
                        <div style="height: 5px; clear: both">&nbsp;</div>
                        <div>
                        
                            <div style="width:250px; float:left;" id="suburb-default">
                                
                                <select name="suburbs" multiple="multiple" id="suburbs" style="height:250px;width:250px;"> 
                                <?php foreach($suburbs as $sb) { ?>
                                    <option value="<?=$sb['id']?>"><?=$sb['name']?> - <?=$sb['postcode']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            
                            <div style="float:left; margin-left:50px; margin-right:50px;">
                                <div style="margin-top:100px;">
                                    <div style="float:left;margin-right:20px; cursor:pointer;" onClick="remove_suburb();"><i class="icon-double-angle-left icon-2x"></i></div>
                                    <div style="float:left; cursor:pointer;" onClick="set_suburb();"><i class="icon-double-angle-right icon-2x"></i></div>
                                </div>
                            </div>
                            <div style="width:250px; float:left;" id="suburb-zone">
                                <select name="suburbs_zone" multiple="multiple" id="suburbs_zone" style="height:250px;width:250px;"> 
                                </select>
                            </div>
                        </div>
                    </div>
					<div style="height: 20px; clear: both">&nbsp;</div>
                    <div>
                        <div style="width: 20%; float: right; height: 30px; line-height: 30px;">&nbsp;</div>
                        <div style="width: 80%; float: left">
                            <button class="btn btn-primary" type="button" onClick="update_shipping()" >Create</button>
                        </div>
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
	out += '<input class="span2" id="appendedInput" name="prices" type="text">';
	out += '</div>';
	out += '&nbsp;&nbsp;&nbsp; if they spend more than';
	out += '&nbsp;&nbsp;&nbsp;';
	out += '<div class="input-prepend" style="margin-bottom: 0">';
	out += '<span id="money" class="add-on">$</span>';
	out += '<input class="span2" id="appendedInput" name="conditions" type="text">';
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
