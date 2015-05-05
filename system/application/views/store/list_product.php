<style>
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
}
.active_opt{
	color:#F0F;
}
</style>

<?php
	$url_pages=$_SERVER['REQUEST_URI'];
	$ex_pages=explode("/",$url_pages);
	if(isset($ex_pages[5]))
	{
		$curr_page=$ex_pages[5];
	}
	else {
		$curr_page = '';
	}
	
	if(isset($ex_pages[6]))
	{
		$curr_opt=$ex_pages[6];
	}
	else {
		
		$curr_opt = '';
	}
	if($ex_pages[3]!='search_result')
	{
		if($curr_page=='' && $curr_opt=='')
		{
			$curr_page='shop_by';
			if($ex_pages[4]=='Handbags'){$curr_opt = 'All_Handbags';}
			if($ex_pages[4]=='Wallets'){$curr_opt = 'All_Wallets_and_Purses';}
			if($ex_pages[4]=='Travel'){$curr_opt = 'All_Travel_Bags';}
			if($ex_pages[4]=='Accessories'){$curr_opt = 'All_Accessories';}
			
		}
	}
	
	
?>
<script>
<?php if($curr_page!='size' && $curr_page!='colour' && $curr_page!='price') { ?>
var line1 = 1;
<? }
else
{ ?>
var line1 = 0;
<? }?>

<?php if($curr_page=='size') { ?>
var line2 = 1;
<? }
else
{ ?>
var line2 = 0;
<? }?>

<?php if($curr_page=='colour') { ?>
var line3 = 1;
<? }
else
{ ?>
var line3 = 0;
<? }?>

<?php if($curr_page=='price') { ?>
var line4 = 1;
<? }
else
{ ?>
var line4 = 0;
<? }?>


	

function click_line(id)
{
	
	if(id == 1 && line1 == 0)
	{
		line1 = 1;
		line2 = 0;
		line3 = 0;
		line4 = 0;
	}
	else if(id == 1 && line1 == 1)
	{
		line1 = 0;
	}
	
	if(id == 2 && line2 == 0)
	{
		line1 = 0;
		line2 = 1;
		line3 = 0;
		line4 = 0;
	}
	else if(id == 2 && line2 == 1)
	{
		line2 = 0;
	}
	
	if(id == 3 && line3 == 0)
	{
		line1 = 0;
		line2 = 0;
		line3 = 1;
		line4 = 0;
	}
	else if(id == 3 && line3 == 1)
	{
		line3 = 0;
	}
	
	if(id == 4 && line4 == 0)
	{
		line1 = 0;
		line2 = 0;
		line3 = 0;
		line4 = 1;
	}
	else if(id == 4 && line4 == 1)
	{
		line4 = 0;
	}
	
	if(line1 == 1)
	{
		$('#line1-down').show();
		$('#line1-right').hide();
	}
	else
	{
		$('#line1-right').show();
		$('#line1-down').hide();
	}
	
	if(line2 == 1)
	{
		$('#line2-down').show();
		$('#line2-right').hide();
	}
	else
	{
		$('#line2-right').show();
		$('#line2-down').hide();
	}
	
	if(line3 == 1)
	{
		$('#line3-down').show();
		$('#line3-right').hide();
	}
	else
	{
		$('#line3-right').show();
		$('#line3-down').hide();
	}
	
	if(line4 == 1)
	{
		$('#line4-down').show();
		$('#line4-right').hide();
	}
	else
	{
		$('#line4-right').show();
		$('#line4-down').hide();
	}
}

function sort_by_latest()
{
	var by = 'latest';
	$.ajax({
	url: '<?=base_url()?>store/sort_by',
	type: 'POST',
	data: ({by:by}),
	dataType: "html",
	success: function(html) {
	location.reload();
	}
	});
	//alert('latest');
}
function sort_by_price()
{
	var by = 'price';
	$.ajax({
	url: '<?=base_url()?>store/sort_by',
	type: 'POST',
	data: ({by:by}),
	dataType: "html",
	success: function(html) {
		location.reload();
	}
	});
}
function sort_by_name()
{
	var by = 'name';
	$.ajax({
	url: '<?=base_url()?>store/sort_by',
	type: 'POST',
	data: ({by:by}),
	dataType: "html",
	success: function(html) {
		location.reload();
	}
	});
}
</script>

<div class="app-container">
	<div style="height:10px;"></div>     
    
    <div class=" hidden-xs"> 
    	<div class="col-sm-5">
            <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase">
			    <li><a href="<?=base_url()?>">HOME</a> <span class="divider">></span></li>
			    <? if( !isset($sub_category)){ ?>
                <li class="active">
                <? } else {?><li> <? }?>
			    	<?php
			    	if(isset($ex_pages[4]))
					{
						$mid=0;
						if($ex_pages[4] == 'Handbags') {$mid = 2;}
						if($ex_pages[4] == 'Wallets') {$mid = 3;}
						if($ex_pages[4] == 'Travel') {$mid = 4;}
						if($ex_pages[4] == 'Accessories') {$mid = 5;}
						if($ex_pages[4] == 'Sale') {$mid = 6;}
						if($ex_pages[4] == 'Stylefile') {$mid = 7;}
						if($ex_pages[4] == 'News') {$mid = 8;}
						$url = base_url().'store/product/'.$cat_name.'/'.$mid;
						if($mid==0){
						$url = base_url().'store/product/'.$cat_name;
						}
						if(isset($sub_category)){ ?>
							<a href="<?=$url?>"><?=strtoupper($ex_pages[4])?></a>
                        <?
						}
						else{
							echo strtoupper($ex_pages[4]);
						}
					}
					else
					{
						echo strtoupper('search results');
					}
			    	?>
                	<? if(isset($sub_category)){ ?>    
                    <span class="divider">></span>
                    <? } ?>
			    </li>
			    <? if( isset($sub_category)){ ?>
                <li class="active">
                	<?=$sub_category?>
                </li>
                <? } ?>
		    </ul>
        </div>
        <div class="span7">
            <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase">
                <li class="active"><a href="javascript:sort_by_latest();">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a href="javascript:sort_by_price();">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a href="javascript:sort_by_name();">NAME</a></li>
            
            	<li style="float:right">
				<? if (isset($links))
                {
                    echo $links; 
                }
                ?>
                </li>                                                
                <?
	              	$url_pages=$_SERVER['REQUEST_URI'];
					$ex_pages=explode("/",$url_pages);
					//print_r($ex_pages);
				?>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$ex_pages[4].'/'.$ex_pages[5].'/'.$ex_pages[6].'/'.$ex_pages[7].'/'.$ex_pages[8].'/36'?>">36</a> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$ex_pages[4].'/'.$ex_pages[5].'/'.$ex_pages[6].'/'.$ex_pages[7].'/'.$ex_pages[8].'/24'?>">24</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$ex_pages[4].'/'.$ex_pages[5].'/'.$ex_pages[6].'/'.$ex_pages[7].'/'.$ex_pages[8]?>">12</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active">VIEW <span class="divider" style="padding:2px;">&nbsp;</span></li>
            </ul>
        </div>        
    </div>
    
    
    <!-- Menu for phone mode -->
    <div class=" visible-phone navbar" >
		<div class="app-container visible-phone" style="background: #fff; border: 1px solid #989898; margin-left: 5%; margin-right: 5%">
			<!-- <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#nav-collapse-header"> -->
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#list-prod-nav">
	        	<!-- <span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span> -->
	        	<i class="icon icon-chevron-down"></i>
	        </button>
	        <a class="brand" href="#" style="color:#989898; font-weight: 700">Shop By</a>
	        <div class="nav-collapse collapse" id="list-prod-nav">
	            <ul class="nav">
	              <?
	              	$url_pages=$_SERVER['REQUEST_URI'];
					$ex_pages=explode("/",$url_pages);
	              	 if($ex_pages[3]!='search_result')
					 {
	              foreach($shop_by as $shopby){ ?>                  
                  <li>
                  		<a class="a-nav" href="<?=base_url()?>store/products/<?=$cat_name?>/shop_by/<?=$shopby['text']?>/<?=$shopby['id']?>">
							<?=$shopby['name']?>
                        </a>
                  </li>

                  <? }}?>
	            </ul>
	        </div>
		</div>
	</div>
	<div style="height:10px;"></div>
	<?php
	$url_pages=$_SERVER['REQUEST_URI'];
	?>
	<div class=" visible-phone"> 
    	<div class="col-sm-5" style="text-align: center">
            <ul class="breadcrumb">
                <li class="active"><a href="javascript:sort_by_latest();">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a href="javascript:sort_by_price();">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a href="javascript:sort_by_name();">NAME</a></li>
            </ul>
        </div>        
    </div>
	<div style="height:10px;"></div>
    
    <!-- <div style="height:10px;"></div>
    <div class=" visible-phone" style="background: #000;">
		<div class="app-container visible-phone" style="background: #000;padding-left:15px;">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse3" style="float:right;">
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        </button>
	        <a class="brand" href="#" style="color: #fff; line-height:30px;">STYLE</a>
            <div class="nav-collapse3 collapse">
                <ul class="nav">
                  <li><a style="text-shadow: none; color: #fff" href="#">Glamoure </a></li>
                </ul>
            </div>
		</div>
	</div>
    
    <div style="height:10px;"></div>
    <div class=" visible-phone" style="background: #000;">
		<div class="app-container visible-phone" style="background: #000;padding-left:15px;">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse4" style="float:right;">
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        </button>
	        <a class="brand" href="#" style="color:#fff;line-height:30px;">SIZE</a>
            <div class="nav-collapse4 collapse">
                <ul class="nav">
                  <li><a style="text-shadow: none; color: #fff" href="#">XS - S </a></li>
                </ul>
            </div>
		</div>
	</div>
    
    <div style="height:10px;"></div>
    <div class=" visible-phone" style="background: #000; margin-bottom: 20px">
		<div class="app-container visible-phone" style="background: #000;padding-left:15px;">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse5" style="float:right;">
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        </button>
	        <a class="brand" href="#" style="color:#fff;line-height:30px;">PRICE</a>
            <div class="nav-collapse5 collapse">
                <ul class="nav">
                  <li><a style="text-shadow: none; color: #fff" href="#">$100 - $200 </a></li>
                </ul>
            </div>
		</div>
	</div> -->
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	<div class="" >            
        <div class="col-sm-12">
            <div class="">
                <div class="span3 hidden-xs">
                    <div class="accordion" id="accordion2">
                         <div class="accordion-group"  style="border-top:none!important;">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                    SHOP BY
                                </a>
                            </div>
                            <div id="collapseOne" class="accordion-body collapse  <? if($curr_page=='shop_by'){echo 'in';}?>">
                                 <?
                                 $url_pages=$_SERVER['REQUEST_URI'];
					$ex_pages=explode("/",$url_pages);
	              	 if($ex_pages[3]!='search_result')
					 { 
                                 foreach($shop_by as $shopby){ ?>
                  
                  					<!-- <div class="accordion-inner">
                                    	<a href="<?=base_url()?>store/products/<?=$cat_name?>/shop_by/<?=$shopby['text']?>/<?=$shopby['id']?>" 
										<? if($curr_opt==$shopby['text']){echo 'class="active_opt"'; }?>>
											<?=$shopby['name']?>
                                        </a>
                                    </div> -->

                  				<? }}?>                                
                            </div>
                         </div>
                         <? if($cat_name != 'Accessories'){?>
                         <div class="accordion-group">
                         	<div class="accordion-heading">
                            	<a style="display: block" onclick="click_line(1)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                	<div style="float:left;">STYLE</div>
									<div id="line1-down" style="float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line1-right" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseTwo" class="accordion-body collapse <?php if($curr_page!='size' && $curr_page!='colour' && $curr_page!='price') {echo "in";}?>">                                                                
                                
                                <? if($cat_name == 'Travel'){?>
                                <div class="accordion-inner">
                                	<a <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?> href="<?=base_url()?>store/products/<?=$cat_name?>/style/view_all">
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/pre-order" <? if($curr_opt=='pre-order'){echo 'class="active_opt"'; }?>>
                                    Pre-Order
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/4_wheels" <? if($curr_opt=='4_wheels'){echo 'class="active_opt"'; }?> >
                                    4 Wheels
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/2_wheels" <? if($curr_opt=='2_wheels'){echo 'class="active_opt"'; }?>>
                                    2 Wheels
                                    </a>
                                </div>                                
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/expandable" <? if($curr_opt=='expandable'){echo 'class="active_opt"'; }?>>
                                    Expandable
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/extendable_handle" <? if($curr_opt=='extendable_handle'){echo 'class="active_opt"'; }?>>
                                    Extendable Handle
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/lightweight" <? if($curr_opt=='lightweight'){echo 'class="active_opt"'; }?>>
                                    Lightweight
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/business" <? if($curr_opt=='business'){echo 'class="active_opt"'; }?>>
                                    Business
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/tsa_locks" <? if($curr_opt=='tsa_locks'){echo 'class="active_opt"'; }?>>
                                    TSA Locks
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Wallets'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/pre-order" <? if($curr_opt=='pre-order'){echo 'class="active_opt"'; }?>>
                                    Pre-Order
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/leather/<?=$ex_pages[7]?>/<?=$ex_pages[8]?>" <? if($curr_opt=='leather'){echo 'class="active_opt"'; }?>>
                                    Leather
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/faux-leather" <? if($curr_opt=='faux-leather'){echo 'class="active_opt"'; }?>>
                                    Faux-Leather
                                    </a>
                                </div>                                
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/applique" <? if($curr_opt=='applique'){echo 'class="active_opt"'; }?>>
                                    Applique
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/sparkles" <? if($curr_opt=='sparkles'){echo 'class="active_opt"'; }?>>
                                    Sparkles
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Handbags'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/pre-order" <? if($curr_opt=='pre-order'){echo 'class="active_opt"'; }?>>
                                    Pre-Order
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/leather/<?=$ex_pages[7]?>/<?=$ex_pages[8]?>" <? if($curr_opt=='leather'){echo 'class="active_opt"'; }?>>
                                    Leather
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/faux-leather" <? if($curr_opt=='faux-leather'){echo 'class="active_opt"'; }?>>
                                    Faux-Leather
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/fabric" <? if($curr_opt=='fabric'){echo 'class="active_opt"'; }?>>
                                    Fabric
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/stripe" <? if($curr_opt=='stripe'){echo 'class="active_opt"'; }?>>
                                    Stripe
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/floral" <? if($curr_opt=='floral'){echo 'class="active_opt"'; }?>>
                                    Floral
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/applique" <? if($curr_opt=='applique'){echo 'class="active_opt"'; }?>>
                                    Applique
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/embroidery" <? if($curr_opt=='embroidery'){echo 'class="active_opt"'; }?>>
                                    Embroidery
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/crystals" <? if($curr_opt=='crystals'){echo 'class="active_opt"'; }?>>
                                    Crystals
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/metallic" <? if($curr_opt=='metallic'){echo 'class="active_opt"'; }?>>
                                    Metallic
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/limited" <? if($curr_opt=='limited'){echo 'class="active_opt"'; }?>>
                                    Limited
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/first_edition" <? if($curr_opt=='first_edition'){echo 'class="active_opt"'; }?>>
                                    First Edition
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/style/frame" <? if($curr_opt=='frame'){echo 'class="active_opt"'; }?>>
                                    Frame
                                    </a>
                                </div>
                                <? } ?>
                            </div>                              
                         </div>
                         <? } ?>
                         <? if($cat_name != 'Accessories'){?>
                         <div class="accordion-group">
                         	<div class="accordion-heading">
                                <a style="display: block" onclick="click_line(2)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            		<div style="float:left;">SIZE</div>
									<div id="line2-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line2-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseThree" class="accordion-body collapse  <? if($curr_page=='size'){echo 'in';}?>">
                            	
                                
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/size/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/size/small" <? if($curr_opt=='small'){echo 'class="active_opt"'; }?>>
                                    Small
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/size/medium" <? if($curr_opt=='medium'){echo 'class="active_opt"'; }?>>
                                    Medium
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/size/large" <? if($curr_opt=='large'){echo 'class="active_opt"'; }?>>
                                    Large
                                    </a>
                                </div>                          
                                                                
                           	</div>
                         </div>
                         <? } ?>
                         
                         <div class="accordion-group">
                         	<div class="accordion-heading">
                            	<a onclick="click_line(3)" style="display: block" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
                                	<div style="float:left;">COLOUR</div>
									<div id="line3-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line3-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseSix" class="accordion-body collapse  <? if($curr_page=='colour'){echo 'in';}?>">
                            	
								<? if($cat_name == 'Accessories' || $cat_name == 'Wallets' || $cat_name == 'Handbags'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/beige" <? if($curr_opt=='beige'){echo 'class="active_opt"'; }?>>
                                	Beige
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/black" <? if($curr_opt=='black'){echo 'class="active_opt"'; }?>>
                                    Black
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/blue" <? if($curr_opt=='blue'){echo 'class="active_opt"'; }?>>
                                    Blue
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/bn" <? if($curr_opt=='bn'){echo 'class="active_opt"'; }?>>
                                    Bn
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/copper" <? if($curr_opt=='copper'){echo 'class="active_opt"'; }?>>
                                    Copper
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/cream" <? if($curr_opt=='cream'){echo 'class="active_opt"'; }?>>
                                    Cream
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/gold" <? if($curr_opt=='gold'){echo 'class="active_opt"'; }?>>
                                    Gold
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/green" <? if($curr_opt=='green'){echo 'class="active_opt"'; }?>>
                                    Green
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/grey" <? if($curr_opt=='grey'){echo 'class="active_opt"'; }?>>
                                    Grey
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/lavender" <? if($curr_opt=='lavender'){echo 'class="active_opt"'; }?>>
                                    Lavender
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/lilac" <? if($curr_opt=='lilac'){echo 'class="active_opt"'; }?>>
                                    Lilac
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/maroon" <? if($curr_opt=='maroon'){echo 'class="active_opt"'; }?>>
                                    Maroon
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/orange" <? if($curr_opt=='orange'){echo 'class="active_opt"'; }?>>
                                    Orange
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/pink" <? if($curr_opt=='pink'){echo 'class="active_opt"'; }?>>
                                    Pink
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/purple" <? if($curr_opt=='purple'){echo 'class="active_opt"'; }?>>
                                    Purple
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/red" <? if($curr_opt=='red'){echo 'class="active_opt"'; }?>>
                                    Red
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/silver" <? if($curr_opt=='silver'){echo 'class="active_opt"'; }?>>
                                    Silver
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/white" <? if($curr_opt=='white'){echo 'class="active_opt"'; }?>>
                                    White 
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/yellow" <? if($curr_opt=='yellow'){echo 'class="active_opt"'; }?>>
                                    Yellow
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Travel'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/black_multi" <? if($curr_opt=='black_multi'){echo 'class="active_opt"'; }?>>
                                    Black Multi
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/pink_multi" <? if($curr_opt=='pink_multi'){echo 'class="active_opt"'; }?>>
                                    Pink Muti
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/colour/red_multi" <? if($curr_opt=='red_multi'){echo 'class="active_opt"'; }?>>
                                    Red Multi
                                    </a>
                                </div>
                                <? } ?>
                                                                                                                                
                             </div>
                         </div>
                         
                         <div class="accordion-group">
                         	<div class="accordion-heading">
                            	<a style="display: block" onclick="click_line(4)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
                                	<div style="float:left;">PRICE</div>
									<div id="line4-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line4-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseFour" class="accordion-body collapse  <? if($curr_page=='price'){echo 'in';}?>">
                            	
								<? if($cat_name == 'Accessories'){?>
								<div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/99-199" <? if($curr_opt=='99-199'){echo 'class="active_opt"'; }?>>
                                	$99 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/199" <? if($curr_opt=='199'){echo 'class="active_opt"'; }?>>
                                    $199 and above
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Travel'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/99-259" <? if($curr_opt=='99-259'){echo 'class="active_opt"'; }?>>
                                    $99 - $259
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/259-359" <? if($curr_opt=='259-359'){echo 'class="active_opt"'; }?>>
                                    $259 - $359
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/359" <? if($curr_opt=='359'){echo 'class="active_opt"'; }?>>
                                    $359 and above
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Wallets'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/99-159" <? if($curr_opt=='99-159'){echo 'class="active_opt"'; }?>>
                                    $99 - $159
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/159-199" <? if($curr_opt=='159-199'){echo 'class="active_opt"'; }?>>
                                    $159 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/199" <? if($curr_opt=='199'){echo 'class="active_opt"'; }?>>
                                    $199 and above
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Handbags'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/view_all" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/99-199" <? if($curr_opt=='99-199'){echo 'class="active_opt"'; }?>>
                                    $99 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/199-299" <? if($curr_opt=='199-299'){echo 'class="active_opt"'; }?>>
                                    $199 - $299
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/299-399" <? if($curr_opt=='299-399'){echo 'class="active_opt"'; }?>>
                                    $299 - $399
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/399-499" <? if($curr_opt=='399-499'){echo 'class="active_opt"'; }?>>
                                    $399 - $499
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/products/<?=$cat_name?>/price/499" <? if($curr_opt=='499'){echo 'class="active_opt"'; }?>>
                                    $499 and above
                                    </a>
                                </div>
                                <? } ?>
                             </div>
                         </div>
                    </div>                                                    
                </div>
                <div class="span9" style="float:right;">         
                	
                	<?php
                		$on = 0;
                		foreach($products as $product)
						{
							
							//echo $product['status'].$product['deleted'].'<br>';
							if($product['status']==1 && $product['deleted']==0)
							{
								$on++;
							}
						}
                		if(count($products)==0 || $on==0){echo "The system was unable to find any search results. Please try again.";}
						$now = 1;
                		foreach($products as $product)
						{
							if($product['status']==1 && $product['deleted']==0)
							{
								$hero = $this->Product_model->get_hero($product['id']);
							
								$title = explode('-',$product['title']);
								
								$cur_user = $this->session->userdata('userloggedin');
					
								//echo $cur_user['level'];
								
								if($cur_user['level'] == 1)
								{
									if($product['sale_price'] < $product['price'])
									{
										$cur_price = $product['sale_price'];
									}
									else 
									{
										$cur_price = $product['price'];
									}
								}
								elseif($cur_user['level'] == 2)
								{
									if($product['sale_price_trade'] < $product['price_trade'])
									{
										$cur_price = $product['sale_price_trade'];
									}
									else 
									{
										$cur_price = $product['price_trade'];
									}
								}
								else
								{
									if($product['sale_price'] < $product['price'])
									{
										$cur_price = $product['sale_price'];
									}
									else 
									{
										$cur_price = $product['price'];
									}
								}
								//$hero = $this->Product_model->get_hero($product['product_id']);
								//$pro = $this->Product_model->identify($product['product_id']);
								if($now == 4){$now = 1;}
								if($now == 1)
								{
								?>
									<div class="">                        
				                        <div class="span4" style="float:left; text-align: center">
				                        	<?php
				                        	if($product['sale_price'] < $product['price'])
											{
											?>
											<img class="hidden-xs" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <img class="hidden-xs" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>"/>
				                            	<img class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>
	                                            <? } else { ?>
												<img class="hidden-xs" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><span style="font-size: 18px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></a></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><?=$product['short_desc']?></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
				                        </div>      
								<?php
								}
								if($now == 2)
								{
								?>
										<div class="span4" style="float:left; text-align: center">
											<?php
				                        	if($product['sale_price'] < $product['price'])
											{
											?>
											<img class="hidden-xs" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <img class="hidden-xs" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>"/>
				                            	<img class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>											
	                                            <? } else { ?>
												<img class="hidden-xs" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><span style="font-size: 18px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></a></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><?=$product['short_desc']?></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
				                        </div>   
								<?php
								}
								if($now == 3)
								{
								?>
										<div class="span4" style="float:left; text-align: center">
											<?php
				                        	if($product['sale_price'] < $product['price'])
											{
											?>
											<img class="hidden-xs" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <img class="hidden-xs" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>"/>
				                            	<img class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/> 
												<? } else { ?>
												<img class="hidden-xs" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><span style="font-size: 18px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></a></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><?=$product['short_desc']?></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
				                        </div> 
				                	</div>
				                	<div style="height:20px;"></div>
								<?php
								}
								$now ++;
							}
							
						}
						if($now == 2)
						{
						?>
								<div class="span4" style="float:left;">
		                            
		                        </div> 
		                        <div class="span4" style="float:right;">
		                            
		                        </div> 
		                	</div>
		                	<div style="height:20px;"></div>
						<?php
						}
						if($now == 3)
						{
						?>
								<div class="span4" style="float:right;">
		                            
		                        </div> 
		                	</div>
		                	<div style="height:20px;"></div>
						<?php
						}
                	?>
                	           
                    <!-- <div class="">                        
                        <div class="span4" style="float:left;">
                            <img src="<?=base_url()?>img/product1_large.jpg" alt="">
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour</div>
                            <div class="prod_title">Description $199</div>
                        </div>                        
                        <div class="span4" style="float:right;">
                            <img src="<?=base_url()?>img/product2_large.jpg" alt="">
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour</div>
                            <div class="prod_title">Description $199</div>
                        </div>                        
                        <div class="span4" style="float:right;">
                            <img src="<?=base_url()?>img/product3_large.jpg" alt="">
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour</div>
                            <div class="prod_title">Description $199</div>
                        </div>      
                    </div>   --> 
                     
                    <!-- <div class="">                        
                        <div class="span4" style="float:left;">
                            <img src="<?=base_url()?>img/product4_large.jpg" alt="">
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour1</div>
                            <div class="prod_title">Description $199</div>
                        </div>      
                        <div class="span4" style="float:right;">
                            <img src="http://placehold.it/240x283" alt="">                            
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour2</div>
                            <div class="prod_title">Description $199</div>
                        </div>      
                        <div class="span4" style="float:right;">
                            <img src="<?=base_url()?>img/product5_large.jpg" alt="">
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour3</div>
                            <div class="prod_title">Description $199</div>
                        </div> 
                    </div> -->
                    <!-- <div style="height:20px;"></div>
                    <div class="">    
                        <div class="span4" style="float:left;">
                            <img src="http://placehold.it/240x283" alt="">
                            <div style="height:10px;"></div>
                            <div class="prod_title">Name - Colour2</div>
                            <div class="prod_title">Description $199</div>
                        </div>     
                        <div class="span4" style="float:right;"></div>
                        <div class="span4" style="float:right;"></div>

                    </div>
                    <div style="height:20px;"></div> -->
                    
                </div>
         	</div>                        
       </div>                                                                         
  	</div>
  	
  	<script>
  	if(line1 == 1)
	{
		$('#line1-down').show();
		$('#line1-right').hide();
	}
	else
	{
		$('#line1-right').show();
		$('#line1-down').hide();
	}
	
	if(line2 == 1)
	{
		$('#line2-down').show();
		$('#line2-right').hide();
	}
	else
	{
		$('#line2-right').show();
		$('#line2-down').hide();
	}
	
	if(line3 == 1)
	{
		$('#line3-down').show();
		$('#line3-right').hide();
	}
	else
	{
		$('#line3-right').show();
		$('#line3-down').hide();
	}
	
	if(line4 == 1)
	{
		$('#line4-down').show();
		$('#line4-right').hide();
	}
	else
	{
		$('#line4-right').show();
		$('#line4-down').hide();
	}
  	</script>
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    <!-- <div class=" visible-phone">
    	<div style="height:10px;"></div>
        <div class="">
            <div class="span3">
                <img src="<?=base_url()?>img/product1_large.jpg" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div>
            <div style="height:20px;"></div>
            <div class="span3">
                <img src="<?=base_url()?>img/product2_large.jpg" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div>
            <div style="height:20px;"></div>
            <div class="span3">
                <img src="<?=base_url()?>img/product3_large.jpg" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div>
            <div style="height:20px;"></div>
            <div class="span3">
                <img src="<?=base_url()?>img/product4_large.jpg" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div>            
            <div style="height:20px;"></div>
            <div class="span3">
                <img src="<?=base_url()?>img/product5_large.jpg" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div>
            <div style="height:20px;"></div>
            <div class="span3">
                <img src="http://placehold.it/480x530" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div> 
            <div style="height:20px;"></div>       
            <div class="span3">
                <img src="http://placehold.it/480x530" alt="">
                <div class="prod_title">Name - Colour</div>
                <div class="prod_title">Description $199</div>
            </div> 
        </div>
    	<div style="height:20px;"></div>
    </div> -->
    <!-- End Product for Iphone -->