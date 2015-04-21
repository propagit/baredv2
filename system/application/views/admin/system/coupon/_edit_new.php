<script>
jQuery(function() {
	jQuery('.selectpicker').selectpicker();
	jQuery('#datetimepicker1').datetimepicker({
		pickTime: false
	});
	jQuery('#datetimepicker4').datetimepicker({
        pickTime: false
    });
	
	check_expirary_type();
	switchtype();
});
function check_expirary_type()
{
	if ($("#optionsType1").is(":checked")) {		
		jQuery('#date_range').hide();
	}
	else
	if ($("#optionsType2").is(":checked")) {
		jQuery('#date_range').show();
	}
	else
	if ($("#optionsType3").is(":checked")) {
		jQuery('#date_range').hide();
	}

}
function add_condition()
{
	var count = jQuery('.cond').length;
	var idcoupon = jQuery('#idcoupon').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/add_condition_layout_update/'+count+'/'+idcoupon,
		type: 'POST',		
		dataType: "html",
		success: function(html) {		
			jQuery('#condition-layout').append(html);
		}
	})

}
function display_condition(id)
{
	var option = jQuery('#cond_option'+id).val();
	var count=0;
	$('.cond').each(function () {	
		count=count+1;		
	});
	var valid=true;
	var cond_type=[];
	for(var i=0; i< count ;i++)
	{
		j=i+1;
		cond_type[i]=jQuery('#type_cond'+j).val();
		
		if(cond_type[i]==option){valid=false;}
	}
	if(valid)
	{
		
		if(option>0)
		{
			jQuery.ajax({
				url: '<?=base_url()?>admin/system/add_detail_condition/'+id,
				type: 'POST',	
				data: {option:option},	
				dataType: "html",		
				success: function(html) {		
					jQuery('#cond'+id).html(html);
				}
			})
		}
	}
	else
	{
		jQuery('#any_message').html("This condition has been applied");
		$('#anyModal').modal('show');
		jQuery('#cond'+id).remove();
	}
}
function remove_cond(id,i)
{
	jQuery('#cond'+i).remove();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/remove_condition/'+id,
		type: 'POST',			
		dataType: "html",		
		success: function(html) {		
			//jQuery('#cond'+id).html(html);
			location.reload();
		}
	})
}
function add_product(id)
{
	jQuery('#id_cond_product').val(id);
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



function add_categoty(id)
{
	jQuery('#id_cond').val(id);
	$('#anyCategories').modal('show');
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
	var product=[];
	var idp=0;
	var k=0;
	$('.detailtrp').each(function () {			
		count=count+1;	
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('dtrp','');
		product[k]=idp;	
	});	
	var id_cond=jQuery('#id_cond_product').val();	
	//jQuery('#all_products'+id_cond).html('');
	$('.single_product').each(function () {			
		if($(this).is(':checked'))
		{				
			var id= $(this).parent().parent().attr("id");				
			dtrp=id.replace('product-','');
			if(jQuery.inArray(dtrp, product)==-1){
				jQuery('#all_products'+id_cond).append('<tr class="detailtrp" id="dtrp'+dtrp+'">'+$(this).parent().parent().html()+'</tr>');									
			}
			//count=count+1;		
		}
		jQuery('#all_products'+id_cond+' .cb').hide();
		jQuery('#all_products'+id_cond+' .remove').show();
	});
	
	update_list_cond_product(id_cond);
	
	/*
	var countheight=0;
	var product=[];
	var idp=0;
	var k=0;
	$('.detailtrp').each(function () {			
		count=count+1;	
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('dtrp','');
		product[k]=idp;	
	});	
	countheight=(count*50)+100;

	jQuery('#cond'+id_cond).css('height',countheight+'px');
	var list_product = product.join(",");
	var id_coupon_cond = jQuery('#id_type_cond').val();	
	var cond_prod= jQuery('#product_type').val();
	if(id_coupon_cond){
		jQuery.ajax({
			url: '<?=base_url()?>admin/new_system/addcond_product/',
			type: 'POST',	
			data: {id_coupon_cond:id_coupon_cond,list_product:list_product,cond_prod:cond_prod},	
			dataType: "html",		
			success: function(html) {		
				
			}
		})	
	}*/
}

function save_category()
{
	
	
	var count=0;
	var id_cond=jQuery('#id_cond').val();	
	var category=[];
	var idp=0;
	var k=0;
	$('.detailtr').each(function () {					
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('dtr','');
		category[k]=idp;	
	});	
	//jQuery('#all_categories'+id_cond).html('');
	$('.single_category').each(function () {			
		if($(this).is(':checked'))
		{				
			var id= $(this).parent().parent().attr("id");				
			dtrp=id.replace('detail_category_tr','');
			if(jQuery.inArray(dtrp, category)==-1)
			{
				jQuery('#all_categories'+id_cond).append('<tr class="detailtr" id="dtr'+dtrp+'">'+$(this).parent().parent().html()+'</tr>');												
			}
		}
		jQuery('#all_categories'+id_cond+' .cb').hide();
		jQuery('#all_categories'+id_cond+' .remove').show();
		//jQuery('.mleft').css('margin-left','0px');
	});
	
	var countheight=0;
	var category=[];
	var idp=0;
	var k=0;
	$('.detailtr').each(function () {			
		count=count+1;	
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('dtr','');
		category[k]=idp;	
	});	
	countheight=(count*50)+100;
	
	jQuery('#cond'+id_cond).css('height',countheight+'px');
	var list_category = category.join(",");
	var id_coupon_cond = jQuery('#id_type_cond_cat').val();	
	var cond_category= jQuery('#category_type').val();
	if(id_coupon_cond){
		jQuery.ajax({
			url: '<?=base_url()?>admin/system/addcond_category/',
			type: 'POST',	
			data: {id_coupon_cond:id_coupon_cond,list_category:list_category,cond_category:cond_category},	
			dataType: "html",		
			success: function(html) {		
				
			}
		})
	}
	
	//}
}

function uncheck_all()
{

	$('#all_cat').prop('checked', false);
	$('.head_category').prop('checked', false);
	$('.detail_category').prop('checked', false);

}
function check_all_category()
{
	if ($("#all_cat").is(":checked")) {		
		$('.head_category').prop('checked', true);
		$('.detail_category_cb').prop('checked', true);
	}
	else
	{
		$('.head_category').prop('checked', false);
		$('.detail_category_cb').prop('checked', false);
	}
}
function check_all_subcategory(id)
{
	if ($(".head_category"+id).is(":checked")) {		
		$('.detail_category_cb'+id).prop('checked', true);
	}
	else
	{
		$('.detail_category_cb'+id).prop('checked', false);
	}
}
/*
function save_category()
{
	var count=0;
	var id_cond=jQuery('#id_cond').val();
	var saveid=0;
	
		jQuery('#all_categories'+id_cond).html('');
		$('.head_category_cb').each(function () {			
   			if($(this).is(':checked'))
			{
				
				
				var id= $(this).parent().parent().attr("id");
				
				id=id.replace('head_category_tr','');
				$('.detail_category_cb'+id).each(function () {
					if($(this).is(':checked'))
					{
						var dtr=$(this).parent().parent().attr("id");
						dtr=dtr.replace('detail_category_tr','');
						jQuery('#all_categories'+id_cond).append('<tr class="detailtr" id="dtr'+dtr+'">'+$(this).parent().parent().html()+'</tr>');
						count=count+1;
						
					}
				});
				
				
			}
			else
			{
				
				var id= $(this).parent().parent().attr("id");
				id=id.replace('head_category_tr','');
				$('.detail_category_cb'+id).each(function () {
					if($(this).is(':checked'))
					{
			
						var dtr=$(this).parent().parent().attr("id");
						dtr=dtr.replace('detail_category_tr','');
						jQuery('#all_categories'+id_cond).append('<tr class="detailtr" id="dtr"'+dtr+'>'+$(this).parent().parent().html()+'</tr>');
						
						count=count+1;													
			
					}
				});
				
			}
			jQuery('#all_categories'+id_cond+' .cb').hide();
			jQuery('#all_categories'+id_cond+' .remove').show();
 		});
		var countheight=0;
		countheight=(count*40)+jQuery('#cond'+id_cond).height();

		jQuery('#cond'+id_cond).css('height',countheight+'px');
	
}
*/
function update_coupon()
{
	var coupon_name = jQuery('#name').val();
	var from_date='';
	var to_date='';
	if ($("#optionsType1").is(":checked")) {		
		var expirary=1;
	}
	else
	if ($("#optionsType2").is(":checked")) {
		var expirary=2;
		var from_date=jQuery('#from_date').val();
		var to_date=jQuery('#to_date').val();
	}
	else
	if ($("#optionsType3").is(":checked")) {
		var expirary=3;
	}
	var discount_type = jQuery('#coupontype').val();
	var values = jQuery('#values').val();
	var condition = jQuery('#condition').val();
	var count=0;
	$('.cond').each(function () {	
		count=count+1;		
	});
	
	var idcoupon=jQuery('#idcoupon').val()
	var cond_type=[];
	var cond_value=[];
	var cond_cat_type=[];
	var cond_product_type=[];
	var cond_cat=[];
	var cond_product=[];
	var cond_new=[];
	for(var i=0; i< count ;i++)
	{
		j=i+1;
		cond_type[i]=jQuery('#type_cond'+j).val();
		
		//spend amount
		if(cond_type[i]==1)
		{
			cond_value[i]=jQuery('#valuecondition'+j).val();
			cond_cat_type[i]=0;
			cond_cat[i]=0;
			cond_product_type[i]=0;
			cond_product[i]=0;
			if(jQuery('#id_type_cond_spend'+j).length>0)
			{cond_new[i]=0;}
			else
			{cond_new[i]=1;}
			//var id_old=jQuery('#id_type_cond_spend'+j).val();
			//if(id_old==0){cond_new[i]=1;}else{cond_new[i]=0;}
		}
		//category
		if(cond_type[i]==2)
		{
			cond_value[i]=jQuery('#valuecondition'+j).val();
			cond_product_type[i]=0;
			cond_product[i]=0;
			var cat_code = '';
			cond_cat_type[i]=jQuery('#category_type').val();
			$('.detailtr').each(function () {	
				var d_id=this.id;
				co = d_id.replace('dtr','');
				cat_code = cat_code+co+',';
			});
			cond_cat[i]=cat_code;
			//var id_old=jQuery('#id_type_cond_cat').val();
			//if(id_old==0){cond_new[i]=1;}else{cond_new[i]=0;}
			if(jQuery('#id_type_cond_cat').length>0)
			{cond_new[i]=0;}
			else
			{cond_new[i]=1;}
		}
		//product
		if(cond_type[i]==3)
		{
			cond_value[i]=jQuery('#valuecondition'+j).val();
			cond_cat_type[i]=0;
			cond_cat[i]=0;
			var prod_code = '';
			var num=0;
			cond_product_type[i]=jQuery('#product_type').val();
			$('.detailtrp').each(function () {	
				var d_id2=this.id;
				co = d_id2.replace('dtrp','');
				prod_code = prod_code+co+',';
			});
			
			cond_product[i]=prod_code;
			//var id_old=jQuery('#id_type_cond_prod').val();
			//if(id_old==0){cond_new[i]=1;}else{cond_new[i]=0;}
			if(jQuery('#id_type_cond_prod').length>0)
			{cond_new[i]=0;}
			else
			{cond_new[i]=1;}
		}
		//number product
		if(cond_type[i]==4)
		{
			cond_value[i]=jQuery('#numberproduct'+j).val();
			cond_cat_type[i]=0;
			cond_cat[i]=0;
			cond_product_type[i]=0;
			cond_product[i]=0;
			if(jQuery('#id_type_cond_spend'+j).length>0)
			{cond_new[i]=0;}
			else
			{cond_new[i]=1;}
			//var id_old=jQuery('#id_type_cond_spend'+j).val();
			//if(id_old==0){cond_new[i]=1;}else{cond_new[i]=0;}
		}
		//couponcode
		if(cond_type[i]==5)
		{
			cond_value[i]=jQuery('#couponcode'+j).val();
			cond_cat_type[i]=0;
			cond_cat[i]=0;
			cond_product_type[i]=0;
			cond_product[i]=0;
			if(jQuery('#id_type_cond_spend'+j).length>0)
			{cond_new[i]=0;}
			else
			{cond_new[i]=1;}
			//var id_old=jQuery('#id_type_cond_spend'+j).val();
			//if(id_old==0){cond_new[i]=1;}else{cond_new[i]=0;}
		}
		
	}
	
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/updatecoupon_new/',
		type: 'POST',	
		data: {idcoupon:idcoupon,coupon_name:coupon_name,from_date:from_date,to_date:to_date,expirary:expirary,discount_type:discount_type,values:values,condition:condition,count:count,cond_type:cond_type,cond_value:cond_value,cond_cat_type:cond_cat_type,cond_product_type:cond_product_type,cond_product:cond_product,cond_cat:cond_cat,cond_new:cond_new},	
		dataType: "html",		
		success: function(html) {		
			jQuery('#any_message').html("This coupon has been successfully updated");
			$('#anyModal').modal('show');
		}
	})
	
	
}
function update_list_cond_product(id_cond)
{
	var count=0;
	var countheight=0;
	var product=[];
	var idp=0;
	var k=0;
	$('.detailtrp').each(function () {			
		count=count+1;	
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('dtrp','');
		product[k]=idp;	
	});	
	countheight=(count*50)+100;

	jQuery('#cond'+id_cond).css('height',countheight+'px');
	var list_product = product.join(",");
	var id_coupon_cond = jQuery('#id_type_cond_prod').val();	
	var cond_prod= jQuery('#product_type').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/addcond_product/',
		type: 'POST',	
		data: {id_coupon_cond:id_coupon_cond,list_product:list_product,cond_prod:cond_prod},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}
function update_list_cond_category(id_cond)
{
	var count=0;
	var countheight=0;
	var category=[];
	var idp=0;
	var k=0;
	$('.detailtr').each(function () {			
		count=count+1;	
		k=k+1;
		var id= $(this).attr("id");				
		idp=id.replace('dtr','');
		category[k]=idp;	
	});	
	countheight=(count*50)+100;

	jQuery('#cond'+id_cond).css('height',countheight+'px');
	var list_category = category.join(",");
	var id_coupon_cond = jQuery('#id_type_cond_cat').val();	
	var cond_category= jQuery('#category_type').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/addcond_category/',
		type: 'POST',	
		data: {id_coupon_cond:id_coupon_cond,list_category:list_category,cond_category:cond_category},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}
function remove_cond_prod(id)
{
	jQuery('#dtrp'+id).fadeOut();
	jQuery('#dtrp'+id).remove();
	update_list_cond_product(id);
}
function remove_prod_cond(id)
{
	jQuery('#dtrp'+id).fadeOut();
	jQuery('#dtrp'+id).remove();
	update_list_cond_product(id);
}
function remove_cond_cat(id)
{
	jQuery('#dtr'+id).fadeOut();
	jQuery('#dtr'+id).remove();
	update_list_cond_category(id);
}

function save_spend(id)
{
	var id_coupon_cond= jQuery("#id_type_cond_spend"+id).val();
	var value = jQuery('#valuecondition'+id).val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/updatecond_spend/',
		type: 'POST',	
		data: {id_coupon_cond:id_coupon_cond,value:value},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}

function save_purchase(id)
{
	var id_coupon_cond= jQuery("#id_type_cond_spend"+id).val();
	var value = jQuery('#numberproduct'+id).val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/updatecond_spend/',
		type: 'POST',	
		data: {id_coupon_cond:id_coupon_cond,value:value},	
		dataType: "html",		
		success: function(html) {		
			
		}
	})
}

function save_couponcode(id)
{
	var id_coupon_cond= jQuery("#id_type_cond_spend"+id).val();
	var value = jQuery('#couponcode'+id).val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/updatecond_spend/',
		type: 'POST',	
		data: {id_coupon_cond:id_coupon_cond,value:value},	
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
.detailtr .mleft{
	margin-left:0px;
}
.mleft{
	margin-left:10px;
}
</style>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Edit Coupon &amp; Discount
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/coupon'">Back To Coupon List</button>
			<div style="height: 20px"></div>
			<?php if($this->session->flashdata('duplicate')) { ?>
			    <div class="alert alert-error">
			    	<button type="button" class="close" onclick="$('.alert-error').fadeOut('slow');">&times;</button>
					<strong>ERROR!</strong> This code has been used in the system.
				</div>
			<?php }?>
			<form method="post" action="<?=base_url()?>admin/system/updatecoupon">
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Coupon Name</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value="<?=$coupon['name']?>"/>
                        <input type="hidden" id="idcoupon" name="idcoupon" value="<?=$coupon['id']?>"/>
					</div>
				</div>
				
				<div style="display:none;">
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Coupon Code</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="code" name="code" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Expiry</div>
					<div style="width: 80%; float: right">
						<!--<input type="checkbox" name="permanent" style="margin-top:0px;" /> This coupon code will be valid as long as it is actived-->
                        <div>		
                        <input type="radio" name="optionsRadios" id="optionsType1" value="1" onChange="check_expirary_type()" <? if($coupon['expirary']==1){ echo "checked";}?> style="margin-top:0px!important;"> Once ( This coupon code will be valid for once per customer )
						</div>
                        <div style="margin-top:5px;">
		                <input type="radio" name="optionsRadios" id="optionsType2" value="2" onChange="check_expirary_type()" <? if($coupon['expirary']==2){ echo "checked";}?> style="margin-top:0px!important;"> Date Range ( This coupon code will be valid as long as date range )
                        </div>
                        <div style="margin-top:5px;">
		                <input type="radio" name="optionsRadios" id="optionsType3" value="3" onChange="check_expirary_type()" <? if($coupon['expirary']==3){ echo "checked";}?> style="margin-top:0px!important;"> Permanent ( This coupon code will be valid as long as it is actived )
                        </div>
                        <div style="height: 10px; ">&nbsp;</div>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div id="date_range" style="display:none;">
                    <div>
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">From Date</div>
                        <div style="width: 80%; float: right">
                              <div id="datetimepicker4" class="input-append">
                              <? $date_from=date('d-M-Y',strtotime($coupon['from_date']));
							  	echo $date_from;
							  ?>
                                <input data-format="dd-MM-yyyy" type="text" name="from_date" id="from_date" value=""></input>
                                <span style="cursor: pointer" class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>
                              </div>
                          
                        </div>
                    </div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    <div>
                        <div style="width: 20%; float: left; height: 30px; line-height: 30px;">To Date</div>
                        <div style="width: 80%; float: right">
                              <div id="datetimepicker1" class="input-append">
                                <input data-format="dd-MM-yyyy" type="text" name="to_date" id="to_date"></input>
                                <span style="cursor: pointer" class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>
                              </div>
                            
                        </div>
                    </div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                </div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Discount Type</div>
					<div style="width: 80%; float: right">
						<select class="selectpicker" name="type" id="coupontype" onchange="switchtype()">
	                    	<option <?php if($coupon['type'] == 1) print ' selected="selected"'; ?>value="1" onclick="$('#money').hide(); $('#percent').show();">Percentage</option>
	                        <option <?php if($coupon['type'] == 2) print ' selected="selected"'; ?>value="2" onclick="$('#money').show(); $('#percent').hide();">Absolute</option>
	                    </select>
	                    
	                    &nbsp;&nbsp;&nbsp;
	                    <div class="input-prepend input-append">
	                    	<span id="money" style="display: none" class="add-on">$</span>
							<input class="span2"  id="values" name="value" type="text" value="<?= $coupon['value']?>">
							<span id="percent" class="add-on">%</span>
						</div>
					</div>
				</div>
				
				<div style="height: 5px; clear: both">&nbsp;</div>
                <div class="line-between">&nbsp;</div>
                <div style="height: 10px; clear: both">&nbsp;</div>
				<div>
                	 <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Condition</div>
					 <div style="width: 80%; float: right">
                     	<div style="float:left;">
                        <select class="selectpicker" id="condition" ><option <?php if($coupon['type_cond'] == 1) print ' selected="selected"'; ?>value="1">ALL</option><option <?php if($coupon['type_cond'] == 2) print ' selected="selected"'; ?>value="2">ANY</option></select>
                        
                        </div>
                        <div style="float:left; margin-left:20px;">
                          <button class="btn btn-primary" type="button" onclick="add_condition()">Add Condition</button>
                        </div>
                     </div>
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div class="line-between">&nbsp;</div>
                <div style="height: 10px; clear: both">&nbsp;</div>
                <div id="condition-layout">
                <?
					$i=1;
					foreach($coupon_condition as $cc)
					{
						if($cc['type']==1)
						{
							?>
                                <div style="clear:both;"></div>
                                <div class="cond" id="cond<?=$i?>" style="margin-bottom:10px; float:none;">
                                <div style="width: 20%; float: left; height: 30px; line-height: 50px; padding-left:10px;">Spend Amounts <input type="hidden" id="type_cond<?=$i?>" value="1"><input type="hidden" id="id_type_cond_spend<?=$i?>" value="<?=$cc['id']?>"></div>
                                <div style="width: 70%; float: left; line-height: 50px;">
                                    If they spend more than &nbsp;&nbsp; 
                                        <div class="input-prepend">
                                            <span class="add-on">$</span>
                                            <input class="span2" id="valuecondition<?=$i?>" name="valuecondition<?=$i?>" type="text" value="<?=$cc['value']?>" onblur="save_spend(<?=$i?>)">
                                        </div> &nbsp;&nbsp; 
                                            Enter a number in format 00.00
                                </div>
                                <div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond(<?=$cc['id']?>,<?=$i?>);">
                                    <i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
                                </div>
                                </div>
                            <?
						}
						if($cc['type']==2)
						{
							?>
                                <div style="clear:both;"></div>
                                <div class="cond" id="cond<?=$i?>" style="margin-bottom:10px; float:none;min-height:200px;">
                                <div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;">Category Discount  <?=$cc['cond_cat']?><input type="hidden" id="type_cond<?=$i?>" value="2"> <input type="hidden" id="id_type_cond_cat" value="<?=$cc['id']?>"></div>
                                <div style="width: 70%; float: left; line-height: 50px;">
                                        <div>
                                            <select class="selectpicker" id="category_type">
                                            <option value="in" <? if($cc['cond_cat']=='in'){echo "selected='selected'";}?>>in</option>
                                            <option value="out" <? if($cc['cond_cat']=='out'){echo "selected='selected'";}?>>out</option>
                                            </select>
                                        </div>
                                        <script>jQuery(".selectpicker").selectpicker();</script>
                                        <style>#category_type{margin-top:10px!important;}#cond'.$id.'{min-height:200px;}</style>
                                        <div><button class="btn btn-primary" type="button" onclick="add_categoty(<?=$i?>)">Add Categories</button></div>
                                        <table class="table table-hover" width="100%">
                                            <thead>
                                                <tr style="font-size: 15px">
                                                    <th style="width: 40%">Name</th>
                                                </tr>
                                            </thead>
                                            <tbody id="all_categories<?=$i?>" class="all_cat">
                                                <?  $cat_ids=$cc['categories'];
													$all_cat=explode(',',$cat_ids);
													$c=0;
													if($cat_ids){
														
														foreach($all_cat as $ac)
														{
															$cat_detail=$this->Category_model->identify($ac);
															if($cat_detail){$c++;
												?>                                                           
                                                                <tr id="dtr<?=$cat_detail['id']?>" class="detailtr">
                                                                    <td align="center"><?=$cat_detail['title']?></td>
                                                                    <td class="remove">
                                                                        <div onclick="remove_cond_cat( <?=$cat_detail['id']?>);" style="cursor:pointer;">
                                                                            <i class="icon-remove-circle icon-2x" style="color: #c70520"></i>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                
                                                <? 			}
														}
													}else {?>
														 <tr>
                                                                <td align="center">No items defined</td>
                                                            </tr>
													<? }
														$height=$c*50;
														$height=$height+100;
													?>
                                            </tbody>
                                            
                                        </table>
                                </div>
                                <script>jQuery("#cond<?=$i?>").css('height','<?=$height?>px');</script>
                                <div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond(<?=$cc['id']?>,<?=$i?>);">
                                    <i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
                                </div>
                                </div>
                            <?
						}
						if($cc['type']==3)
						{
							?>
                                <div style="clear:both;"></div>
                                <div class="cond" id="cond<?=$i?>" style="margin-bottom:10px; float:none;min-height:200px;">
                                <div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;">Product Discount <input type="hidden" id="type_cond<?=$i?>" value="3"> <input type="hidden" id="id_type_cond_prod" value="<?=$cc['id']?>"></div>
                                <div style="width: 70%; float: left; line-height: 50px;">
                                        <div style="margin-top:10px;"><select class="selectpicker" id="product_type"><option value="in">in</option><option value="out">out</option></select></div>
                                        <script>jQuery(".selectpicker").selectpicker();</script>
                                        <style>#category_type{margin-top:10px!important;}#cond'.$id.'{min-height:200px;}</style>
                                        <div><button class="btn btn-primary" type="button" onclick="add_product(<?=$i?>)">Add Products</button></div>
                                        <table class="table table-hover" width="100%" >
                                            <thead>
                                                <tr style="font-size: 15px">
                                                    <th style="width: 40%">Name</th>
                                                </tr>
                                            </thead>
                                            <tbody id="all_products<?=$i?>" class="all_prod">
                                               <?  $cat_ids=$cc['products'];

													$all_pro=explode(',',$cat_ids);

													if($cat_ids){
														
														$c=0;
														
														foreach($all_pro as $ap)
														{
															$pro_detail=$this->Product_model->identify($ap);
															
															if($pro_detail && $pro_detail['status']==1 && $pro_detail['deleted']==0){
																$c++;
												?>                                                           
                                                                <tr class="detailtrp" id="dtrp<?=$pro_detail['id']?>">
                                                                    <td align="center"><?=$pro_detail['title']?></td>
                                                                    <td class="remove">
                                                                        <div onclick="remove_cond_prod( <?=$pro_detail['id']?>);" style="cursor:pointer;">
                                                                            <i class="icon-remove-circle icon-2x" style="color: #c70520"></i>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                <? 			}
														}
														if($c==0){
														?>
														<tr>
                                                                <td align="center">No items defined</td>
                                                            </tr>
														<?
														}
													}else {?>
														 <tr>
                                                                <td align="center">No items defined</td>
                                                            </tr>
													<? }
														$height=$c*50;
														$height=$height+120;
													?>
                                            </tbody>
                                            
                                        </table>
                                </div>
                                <script>jQuery("#cond<?=$i?>").css('height','<?=$height?>px');</script>
                                <div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond(<?=$cc['id']?>,<?=$i?>);">
                                    <i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
                                </div>
                                </div>
                            <?
						}
						if($cc['type']==4)
						{
							?>
                                <div style="clear:both;"></div>
                                <div class="cond" id="cond<?=$i?>" style="margin-bottom:10px; float:none;">
                                <div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;"># Product Purchased <input type="hidden" id="type_cond<?=$i?>" value="4"><input type="hidden" id="id_type_cond_spend<?=$i?>" value="<?=$cc['id']?>"></div>
                                <div style="width: 70%; float: left; line-height: 50px;">
                                    If they buy more than &nbsp;&nbsp; 
                                        <div class="input-prepend">	                    	
                                            <input style="margin-top:10px;" class="span2" id="numberproduct<?=$i?>" name="numberproduct<?=$i?>" type="text" value="<?=$cc['value']?>" onblur="save_purchase(<?=$i?>);">
                                        </div> 
                
                                </div>
                                <div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond(<?=$cc['id']?>,<?=$i?>);">
                                    <i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
                                </div>
                                </div>
                            <?
						}
						if($cc['type']==5)
						{
							?>
                                <div style="clear:both;"></div>
                                <div class="cond" id="cond<?=$i?>" style="margin-bottom:10px; float:none;">
                                <div style="width: 20%; float: left; height: 30px; line-height: 50px;padding-left:10px;">Add a Coupon Code <input type="hidden" id="type_cond<?=$i?>" value="5"><input type="hidden" id="id_type_cond_spend<?=$i?>" value="<?=$cc['id']?>"></div>
                                <div style="width: 70%; float: left; line-height: 50px;">
                                    <input class="span2" style="margin-top:10px;" id="couponcode<?=$i?>" name="couponcode<?=$i?>" type="text" value="<?=$cc['value']?>" onblur="save_couponcode(<?=$i?>);">					
                                </div>
                                <div style="float: left; line-height: 50px; margin-top:10px;cursor:pointer;" onclick="remove_cond(<?=$cc['id']?>,<?=$i?>);">
                                    <i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
                                </div>
                                </div>
                            <?
						}
						$i++;
					}
				?>
                </div>
                
				
                
                <!--
                <div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Condition</div>
					<div style="width: 80%; float: right">
						If they spend more than &nbsp;&nbsp; 
						<div class="input-prepend">
	                    	<span class="add-on">$</span>
							<input class="span2" id="appendedInput" name="condition" type="text">
						</div> &nbsp;&nbsp; 
						    Enter a number in format 00.00
					</div>
				</div>
				
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
						<input type="checkbox" name="sale_exclude" /> &nbsp;&nbsp; Sale items exclude
					</div>
				</div>
				 -->
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
					    <button class="btn btn-primary" type="button" onclick="update_coupon()">Update</button>
					</div>
				</div>
              	<div style="height: 50px; clear: both">&nbsp;</div>
			</form>
			<div style="height: 0px; clear: both">&nbsp;</div>
			<!-- end here -->
		</div>
	</div>
</div>
<div id="anyCategories" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Categories</h3>
</div>
<div class="modal-body" >
    <input type="hidden" id="id_cond" val=""/>
    <table class="table table-hover">
    <thead>
        <tr style="font-size: 15px">
            <th style="width: 10%"><input type="checkbox" value="1" onclick="check_all_category()" id="all_cat"></th>
            <th style="width: 70%; text-align: left;">Categories</th>
            <th style="width: 20%; text-align: left;"></th>
           
        </tr>
    </thead>
    <tbody id="all_page">
        <? foreach($categories as $ct){?>
        <tr id="head_category_tr<?=$ct['id']?>" class="head_category">
            <td class="cb"><input type="checkbox" value="<?=$ct['id']?>" class="head_category_cb head_category head_category<?=$ct['id']?>" onchange="check_all_subcategory(<?=$ct['id']?>)"></td>
            <td style="text-align: left;">
                <b><?=$ct['name']?></b>
            </td>
            <td style="text-align: center;">
                
            </td>
        </tr>
        <? $sub_categories = $this->Category_model->get($ct['id']);
		   foreach($sub_categories as $sc)
		   {?>
				<tr id="detail_category_tr<?=$sc['id']?>" class="detail_category<?=$ct['id']?> detail_cat">
                <? $check_cats = $this->System_model->check_category_coupon($sc['id'],$coupon['id']);?>
				<td class="cb"><input type="checkbox" value="<?=$sc['id']?>" class="single_category" id="single_category<?=$sc['id']?>" <? if($check_cats==1){?> disabled="disabled" <? }?>></td>
				<td style="text-align: left;">
					<span class="mleft"><?=$sc['name']?></span>
				</td>
				<td class="remove" style="display:none;"><div style="cursor:pointer;" onclick="remove_category_cond(<?=$sc['id']?>);"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></div></td>                 
				</tr>
		<? }        
         } ?>
    </tbody>
    
    </table>
</div>
<div class="modal-footer">
<button class="btn btn-primary" onclick="save_category();">Save</button>
<button class="btn" onclick="uncheck_all()">Cancel</button>
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>


<div id="anyProducts" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add Products</h3>
</div>
<div class="modal-body" >
    <input type="hidden" id="id_cond_product" val=""/>
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
                	<? $check_prods = $this->System_model->check_product_coupon($product['id'],$coupon['id']);?>
                    <td class="cb"><input type="checkbox" value="1" class="single_product" id="single_product<?=$product['id']?>" <? if($check_prods==1){?> disabled="disabled" <? }?>></td>
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

<script>
function switchtype()
{
	var val = $('#coupontype').val();
	
	if(val == 1)
	{
		$('#money').hide(); $('#percent').show();
	}
	else
	{
		$('#money').show(); $('#percent').hide();
	}
}
</script>