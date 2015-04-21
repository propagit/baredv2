<script>
$(function() {
	jQuery('.selectpicker').selectpicker();
	$('#datetimepicker1').datetimepicker({
		pickTime: false
	});
	$('#datetimepicker4').datetimepicker({
        pickTime: false
    });
	
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
	var nums = 0;	
	if(count==1){
		save_coupon();
	}
	for (var i=1;i<=count;i++)
	{		

		if(jQuery('#cond_option'+i).length==1)
		{
			nums=nums+1;
		}
	}
	if(nums==0)
	{
		jQuery.ajax({
			url: '<?=base_url()?>admin/system/add_condition_layout/'+count,
			type: 'POST',		
			dataType: "html",
			success: function(html) {		
				jQuery('#condition-layout').append(html);
			}
		});
	}
	else
	{
		jQuery('#any_message').html("You still have Condition Options below");
		$('#anyModal').modal('show');
	}

}
function display_condition(id)
{
	var option = jQuery('#cond_option'+id).val();
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
function remove_cond(id)
{
	jQuery('#cond'+id).remove();
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/remove_condition/'+id,
		type: 'POST',			
		dataType: "html",		
		success: function(html) {		
			jQuery('#cond'+id).remove();
			save_coupon();
		}
	});
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
	var id_cond=jQuery('#id_cond_product').val();
	/*
	if ($("#all_prod").is(":checked")) {		
		jQuery('#all_products' +id_cond).html(jQuery('#list_products').html());
		jQuery('#all_products'+id_cond+' .cb').hide();
		jQuery('#all_products'+id_cond+' .remove').show();
		var countheight=0;
		countheight=310+jQuery('#cond'+id_cond).height();

		jQuery('#cond'+id_cond).css('height',countheight+'px');
	}
	else
	{*/		
		jQuery('#all_products'+id_cond).html('');
		$('.single_product').each(function () {			
   			if($(this).is(':checked'))
			{				
				var id= $(this).parent().parent().attr("id");				
				dtrp=id.replace('product-','');
				jQuery('#all_products'+id_cond).append('<tr class="detailtrp" id="dtrp'+dtrp+'">'+$(this).parent().parent().html()+'</tr>');									
				count=count+1;		
			}
			jQuery('#all_products'+id_cond+' .cb').hide();
			jQuery('#all_products'+id_cond+' .remove').show();
 		});
		var countheight=0;
		countheight=(count*35)+jQuery('#cond'+id_cond).height();

		jQuery('#cond'+id_cond).css('height',countheight+'px');
		
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
function save_category()
{
	var count=0;
	var id_cond=jQuery('#id_cond').val();
	var saveid=0;
	
	/*
	if ($("#all_cat").is(":checked")) {		
		jQuery('#all_categories' +id_cond).html(jQuery('#all_page').html());
		jQuery('#all_categories'+id_cond+' .cb').hide();

		jQuery('#all_categories'+id_cond+' .remove').show();
	}
	else
	{*/
		jQuery('#all_categories'+id_cond).html('');
		$('.head_category_cb').each(function () {			
   			if($(this).is(':checked'))
			{
				
				//jQuery('#all_categories'+id_cond).append('<tr>'+$(this).parent().parent().html()+'</tr>');
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
						jQuery('#all_categories'+id_cond).append('<tr class="detailtr" id="dtr'+dtr+'">'+$(this).parent().parent().html()+'</tr>');
						//jQuery('#all_categories'+id_cond).append('<tr class="cat">'+$(this).parent().parent().html()+'</tr>');
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
		
	//}
}

function save_coupon()
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
	var values = jQuery('#appendedInput').val();
	var condition = jQuery('#condition').val();
	var count=0;
	$('.cond').each(function () {	
		count=count+1;		
	});

	var cond_type=[];
	var cond_value=[];
	var cond_cat_type=[];
	var cond_product_type=[];
	var cond_cat=[];
	var cond_product=[];
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
		}
		//number product
		if(cond_type[i]==4)
		{
			cond_value[i]=jQuery('#numberproduct'+j).val();
			cond_cat_type[i]=0;
			cond_cat[i]=0;
			cond_product_type[i]=0;
			cond_product[i]=0;
		}
		//couponcode
		if(cond_type[i]==5)
		{
			cond_value[i]=jQuery('#couponcode'+j).val();
			cond_cat_type[i]=0;
			cond_cat[i]=0;
			cond_product_type[i]=0;
			cond_product[i]=0;
		}
		
	}
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/addcoupon/',
		type: 'POST',	
		data: {coupon_name:coupon_name,from_date:from_date,to_date:to_date,expirary:expirary,discount_type:discount_type,values:values,condition:condition,count:count,cond_type:cond_type,cond_value:cond_value,cond_cat_type:cond_cat_type,cond_product_type:cond_product_type,cond_product:cond_product,cond_cat:cond_cat},	
		dataType: "html",		
		success: function(html) {		
			//alert('added successfully');
			jQuery('#any_message').html("This coupon has been successfully added");
			$('#anyModal').modal('show');
			$('#anyModal').on('hidden', function () {
  				window.location='<?=base_url()?>admin/system/coupon/edit/'+html;
			})
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
function remove_category_cond(id)
{
	jQuery('#dtr'+id).fadeOut();
	jQuery('#dtr'+id).remove();
	update_list_cond_category(id);
}

</script>
<style>
.cond
{
	background-color:#DDF3FA;
	min-height:50px;
	width:100%;
}
</style>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Add Coupon &amp; Discount
			</h1>
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/coupon'">Back To Coupon List</button>
			<div style="height: 20px"></div>
			<?php if($this->session->flashdata('duplicate')) { ?>
			    <div class="alert alert-error">
			    	<button type="button" class="close" onclick="$('.alert-error').fadeOut('slow');">&times;</button>
					<strong>ERROR!</strong> This code has been used in the system.
				</div>
			<?php }?>
			<form method="post" action="<?=base_url()?>admin/system/addcoupon">
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Coupon Name</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value=""/>
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
                        <input type="radio" name="optionsRadios" id="optionsType1" value="1" onChange="check_expirary_type()" checked style="margin-top:0px!important;"> Once ( This coupon code will be valid for once per customer )
						</div>
                        <div style="margin-top:5px;">
		                <input type="radio" name="optionsRadios" id="optionsType2" value="2" onChange="check_expirary_type()" style="margin-top:0px!important;"> Date Range ( This coupon code will be valid as long as date range )
                        </div>
                        <div style="margin-top:5px;">
		                <input type="radio" name="optionsRadios" id="optionsType3" value="3" onChange="check_expirary_type()" style="margin-top:0px!important;"> Permanent ( This coupon code will be valid as long as it is actived )
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
                                <input data-format="dd-MM-yyyy" type="text" name="from_date" id="from_date"></input>
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
	                    	<option value="1" onclick="$('#money').hide(); $('#percent').show();">Percentage</option>
	                        <option value="2" onclick="$('#money').show(); $('#percent').hide();">Absolute</option>
	                    </select>
	                    
	                    &nbsp;&nbsp;&nbsp;
	                    <div class="input-prepend input-append">
	                    	<span id="money" style="display: none" class="add-on">$</span>
							<input class="span2" id="appendedInput"  name="values" type="text">
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
                        <select id="condition" style="display:none;">
                        <option value="1">ALL</option>
                        <!--<option value="2">ANY</option>-->
                        </select>
                        
                        </div>
                        <div style="float:left; margin-left:0px;">
                          <button class="btn btn-primary" type="button" onclick="add_condition()">Add Condition</button>
                        </div>
                     </div>
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div id="condition-layout">
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div class="line-between">&nbsp;</div>
                <div style="height: 10px; clear: both">&nbsp;</div>
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
					    <button class="btn btn-primary" type="button" onclick="save_coupon()">Create</button>
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
		   {
				if($sc['id']!=9 && $sc['id']!=21 && $sc['id']!=29 && $sc['id']!=35){?>
                <tr id="detail_category_tr<?=$sc['id']?>" class="detail_category<?=$ct['id']?> detail_cat">
                <? $check_cats = $this->System_model->check_category_coupon($sc['id'],0);?>									                
				<td class="cb"><input type="checkbox" value="<?=$sc['id']?>" class="detail_category_cb<?=$ct['id']?> detail_category_cb" <? if($check_cats==1){?> disabled="disabled" <? }?>></td>
				<td style="text-align: left;">
					<span style="margin-left:10px;"><?=$sc['name']?></span>
				</td>
				<td class="remove" style="display:none;"><div style="cursor:pointer;" onclick="remove_category_cond(<?=$sc['id']?>);"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></div></td>                 
				</tr>
                <?}
		 	}        
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
                	<? $check_prods = $this->System_model->check_product_coupon($product['id'],0);?>
                	<td class="cb"><input type="checkbox" value="1" class="single_product" id="single_product<?=$product['id']?>" <? if($check_prods==1){?> disabled="disabled" <? }?> ></td>
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