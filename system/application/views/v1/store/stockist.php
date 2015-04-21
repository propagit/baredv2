<script>
var choose = 0;
</script>
<style>
div.vertical-big { height: 530px !important}
div.vertical-small { height: 430px !important}
div.vertical-tablet { height: 320px !important}

.accordion-group {
   border: none!important;
   border-radius: 0px;
   border-top: 1px dashed #222!important;
}

.accordion-heading .accordion-toggle {
	padding-left:0px!important;
}
a {
    color: #222;
    text-decoration: none;
	font-weight:600;

}
a:hover, a:focus {
	color: #222;
    text-decoration: none;
	font-weight:600;
	
}
.accordion-inner:first-child {
	border-top: 1px dashed #222;
	padding-top:10px;
}
.accordion-inner:last-child {

	padding-bottom:10px;
}

.accordion-inner {
	/*border-top: 1px dashed #222;*/
	border-top:none;
    padding-left: 0px;
	font-size:12px;
	padding-bottom:0px;
	padding-top:2px;
}

.breadcrumb {
    background-color: transparent;
	padding-left:0px;
	font-size:12px;
	margin-bottom:0px!important;
}
.breadcrumb > .active {
    color: #222222;
}
.prod_title{
	font-size:12px;
}

.nav > li a:hover, nav >li a:focus {
	background-color:#A7A7A7;
	
}

.nav-collapse2 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}
.nav-collapse3 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}
.nav-collapse4 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}
.nav-collapse5 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}

@media (max-width: 480px) {
.accordion-heading .accordion-toggle {
	/*padding-left:15px!important;*/
}


.vertical .carousel-inner {
  height: 100%;
}

.carousel.vertical .item {
  -webkit-transition: 0.6s ease-in-out top;
     -moz-transition: 0.6s ease-in-out top;
      -ms-transition: 0.6s ease-in-out top;
       -o-transition: 0.6s ease-in-out top;
          transition: 0.6s ease-in-out top;
}

.carousel.vertical .active {
  top: 0;
}

.carousel.vertical .next {
  top: 100%;
}

.carousel.vertical .prev {
  top: -100%;
}

.carousel.vertical .next.left,
.carousel.vertical .prev.right {
  top: 0;
}

.carousel.vertical .active.left {
  top: -100%;
}

.carousel.vertical .active.right {
  top: 100%;
}

.carousel.vertical .item {
    left: 0;
}
}

@media (min-width: 980px) and (max-width: 1199px) {
	
	div.show-small
	{
		display:block !important;
	}
	
	div.hide-small
	{
		display:none !important;
	}
	 
	 }
	 
@media (min-width: 1200px) {
	
	div.show-small
	{
		display:none !important;
	}
	
	div.hide-small
	{
		display:block !important;
	}
	 
	 }

</style>

<script>
function delete_cart(id)
{
	choose = id;
	//alert(choose);
	$('#deleteModal').modal('show');
}

function deletecart(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>store/removeitem',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#cart-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This coupon has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
}

function country_change()
{
	var country = $('#country').val();
	//alert(country);
	if(country != '')
	{
		jQuery.ajax({
			url: '<?=base_url()?>store/stockist_change_country',
			type: 'POST',
			data: ({keyword:country}),
			dataType: "html",
			success: function(html) {
				//jQuery('#cart-'+id).fadeOut('slow');
				//jQuery('#any_message').html("This coupon has been successfully deleted");
				//$('#anyModal').modal('show');
				$('#state_wrap').html(html);
				
				if(country != 'AU')
				{
					$('#suburb_wrap').hide();
				}
				else
				{
					$('#suburb_wrap').show();
				}
			}
		});
	}
}

function state_change()
{
	var country = $('#country').val();
	var state = $('#state').val();
	//alert(state);
	
	if(country != '' && alert != '')
	{
		if(country == 'AU')
		{
			jQuery.ajax({
			url: '<?=base_url()?>store/stockist_change_state_au',
			type: 'POST',
			data: ({keyword:state}),
			dataType: "html",
			success: function(html) {
					$('#suburb_wrap').html(html);
				}
			});
		}
		else
		{
			jQuery.ajax({
			url: '<?=base_url()?>store/get_stockist',
			type: 'POST',
			data: ({country:country,state:state,suburb:''}),
			dataType: "html",
			success: function(html) {
					$('#result_stockist').html(html);
				}
			});
		}
	}
	
}

function suburb_change()
{
	var country = $('#country').val();
	var state = $('#state').val();
	var suburb = $('#suburb').val();
	//alert(suburb);
	
	if(country != '' && alert != '' && suburb != '')
	{
		jQuery.ajax({
			url: '<?=base_url()?>store/get_stockist',
			type: 'POST',
			data: ({country:country,state:state,suburb:suburb}),
			dataType: "html",
			success: function(html) {
					$('#result_stockist').html(html);
				}
			});
	}
}
</script>

<div class="container">
	
	<div style="height: 30px;"></div>
    <?=$pages['content']?>
    <!-- <div>SPENCER &amp; RUTHERFORD STORES</div>
	<div style="height: 20px;"></div>
	
	<div class="row-fluid">
		<div class="span3">
			<div style="margin-left: 5%">
				<div>
					Spencer &amp; Rutherford<br/>
					Melbourne
				</div>
				<div style="height: 15px;"></div>
				<img src="http://placehold.it/257x173" alt="">
				<div style="height: 15px;"></div>
				<div>
					City<br/>
					<span style="font-weight: 700">Phone:</span> +61 3 9090 7053
				</div>
				<div style="height: 25px;"></div>
				<div style="background: #000; color: #fff; width: 100%; height: 30px; line-height: 30px; font-size: 16px; font-weight: 700; text-align: center">
					DETAILS
				</div>
			</div>
		</div>
		<div class="span3" style="border-left: 1px solid #696969">
			<div style="margin-left: 5%">
				<div>
					Spencer &amp; Rutherford<br/>
					Melbourne
				</div>
				<div style="height: 15px;"></div>
				<img src="http://placehold.it/257x173" alt="">
				<div style="height: 15px;"></div>
				<div>
					Armadale<br/>
					<span style="font-weight: 700">Phone:</span> +61 3 9804 3933
				</div>
				<div style="height: 25px;"></div>
				<div style="background: #000; color: #fff; width: 100%; height: 30px; line-height: 30px; font-size: 16px; font-weight: 700; text-align: center">
					DETAILS
				</div>
			</div>
		</div>
		<div class="span3" style="border-left: 1px solid #696969">
			<div style="margin-left: 5%">
				<div>
					Spencer &amp; Rutherford<br/>
					Perth
				</div>
				<div style="height: 15px;"></div>
				<img src="http://placehold.it/257x173" alt="">
				<div style="height: 15px;"></div>
				<div>
					Claremont<br/>
					<span style="font-weight: 700">Phone:</span> +61 8 6162 8663
				</div>
				<div style="height: 25px;"></div>
				<div style="background: #000; color: #fff; width: 100%; height: 30px; line-height: 30px; font-size: 16px; font-weight: 700; text-align: center">
					DETAILS
				</div>
			</div>
		</div>
		<div class="span3" style="border-left: 1px solid #696969">
			<div style="margin-left: 5%">
				<div>
					DFO OUTLET<br/>
					Melbourne
				</div>
				<div style="height: 15px;"></div>
				<img src="http://placehold.it/257x173" alt="">
				<div style="height: 15px;"></div>
				<div>
					Moorabbin<br/>
					<span style="font-weight: 700">Phone:</span> +61 3 9583 7706
				</div>
				<div style="height: 25px;"></div>
				<div style="background: #000; color: #fff; width: 100%; height: 30px; line-height: 30px; font-size: 16px; font-weight: 700; text-align: center">
					DETAILS
				</div>
			</div>
		</div>
	</div> -->
	
	
	<div style="height: 30px;"></div>
    
    <div class="row-fluid" style="background: #f6f5f5; ">
    	<div class="span12" style="padding-top: 10px; padding-bottom: 10px">
    		<div style="margin-left: 1.3%">
    			Find a Spencer &amp; Rutherford Stockist
    		</div>
    	</div>
    </div>
    <div class="row-fluid" style="background: #f6f5f5; padding-bottom: 20px">
    	<div class="span3" style="padding-top: 20px">
    		<div style="margin-left: 5%">
	    		<div>
	    			<select onchange="country_change();" id="country" style="width: 100%">
	    				<option value="">Country</option>
	    				<option value="AU">Australia</option>
	    				<option value="NZ">New Zealand</option>
	    				<option value="OT">Other</option>
	    			</select>
	    		</div>
	    		<div id="state_wrap">
	    			<select id="state" style="width: 100%">
	    				<option>State</option>
	    			</select>
	    		</div>
	    		<div id="suburb_wrap">
	    			<select id="suburb" style="width: 100%">
	    				<option>Suburb</option>
	    			</select>
	    		</div>
    		</div>
    	</div>
    	<div class="span9" id="result_stockist">
    		<!-- <div class="row-fluid" style="border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 10px">
	    		<div class="span4" style="border-left: 1px solid #696969">
		    		<div style="margin-left: 5%; padding-top: 20px">
		    			<div>
		    				Bags &amp; Bags<br/>
		    				<br/>
		    				99 Liverpool Street,<br/>
		    				Sydney 2000,<br/>
		    				Australia<br/>
		    				<b>Phone: </b>+61 2 9999 0000
		    			</div>
		    			<div style="height: 20px">
		    				
		    			</div>
		    		</div>
		    	</div>
		    	<div class="span4" style="border-left: 1px solid #696969">
		    		<div style="margin-left: 5%; padding-top: 20px">
		    			<div>
		    				Bags &amp; Bags<br/>
		    				<br/>
		    				99 Liverpool Street,<br/>
		    				Sydney 2000,<br/>
		    				Australia<br/>
		    				<b>Phone: </b>+61 2 9999 0000
		    			</div>
		    			<div style="height: 20px">
		    				
		    			</div>
		    		</div>
		    	</div>
		    	<div class="span4" style="border-left: 1px solid #696969">
		    		<div style="margin-left: 5%; padding-top: 20px">
		    			<div>
		    				Bags &amp; Bags<br/>
		    				<br/>
		    				99 Liverpool Street,<br/>
		    				Sydney 2000,<br/>
		    				Australia<br/>
		    				<b>Phone: </b>+61 2 9999 0000
		    			</div>
		    			<div style="height: 20px">
		    				
		    			</div>
		    		</div>
		    	</div>
	    	</div> -->
	    	
	    	<!-- <div class="row-fluid" style="padding-bottom: 10px; margin-bottom: 10px">
	    		<div class="span4" style="border-left: 1px solid #696969">
		    		<div style="margin-left: 5%; padding-top: 20px">
		    			<div>
		    				Bags &amp; Bags<br/>
		    				<br/>
		    				99 Liverpool Street,<br/>
		    				Sydney 2000,<br/>
		    				Australia<br/>
		    				<b>Phone: </b>+61 2 9999 0000
		    			</div>
		    			<div style="height: 20px">
		    				
		    			</div>
		    		</div>
		    	</div>
		    	<div class="span4" style="border-left: 1px solid #696969">
		    		<div style="margin-left: 5%; padding-top: 20px">
		    			<div>
		    				Bags &amp; Bags<br/>
		    				<br/>
		    				99 Liverpool Street,<br/>
		    				Sydney 2000,<br/>
		    				Australia<br/>
		    				<b>Phone: </b>+61 2 9999 0000
		    			</div>
		    			<div style="height: 20px">
		    				
		    			</div>
		    		</div>
		    	</div>
		    	<div class="span4" style="border-left: 1px solid #696969">
		    		<div style="margin-left: 5%; padding-top: 20px">
		    			<div>
		    				Bags &amp; Bags<br/>
		    				<br/>
		    				99 Liverpool Street,<br/>
		    				Sydney 2000,<br/>
		    				Australia<br/>
		    				<b>Phone: </b>+61 2 9999 0000
		    			</div>
		    			<div style="height: 20px">
		    				
		    			</div>
		    		</div>
		    	</div>
	    	</div> -->
    	</div>
    	
    </div>
    
    
		
        
   