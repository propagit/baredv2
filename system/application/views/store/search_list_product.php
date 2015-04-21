<style>



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
	color:#D71D5D;
}
@media (min-width: 1200px)
{
	.prod-list
	{
		margin-left: 17px;
	}
}
@media (max-width: 1200px)
{
	.prod-list
	{
		margin-left: 0px;
	}
}
@media (max-width: 979px)
{
	.prod-list
	{
		margin-left: 0px;
	}
}
#pagin ul
{
	background: #d4d0cd;
	padding-left:10px
}
</style>

<?php
	// if($this->session->userdata('look_by'))
	// {
		// $curr_page = $this->session->userdata('look_by');
	// }
	// else 
	// {
		// $curr_page = '';
	// }
// 	
	// if($this->session->userdata('text_keyword'))
	// {
		// $curr_opt = $this->session->userdata('text_keyword');
	// }
	// else 
	// {
		// $curr_opt = '';
	// }
	
	$curr_page = $look_by;
	$curr_opt = $text_key;

	$url_pages=$_SERVER['REQUEST_URI'];
	$ex_pages=explode("/",$url_pages);
	
	if($ex_pages[3]!='search_result')
	{
		if($curr_page=='' && $curr_opt=='')
		{
			$curr_page='shop_by';
			//if($ex_pages[4]=='Handbags'){$curr_opt = 'All_Handbags';}
			//if($ex_pages[4]=='Wallets'){$curr_opt = 'All_Wallets_and_Purses';}
			//if($ex_pages[4]=='Travel'){$curr_opt = 'All_Travel_Bags';}
			//if($ex_pages[4]=='Accessories'){$curr_opt = 'All_Accessories';}
			
		}
	}
	$cat_name = 'Womens';
	$scat_name='all';
	
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
	url: '<?=base_url()?>store/product_sort_by',
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
	url: '<?=base_url()?>store/product_sort_by',
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
	url: '<?=base_url()?>store/product_sort_by',
	type: 'POST',
	data: ({by:by}),
	dataType: "html",
	success: function(html) {
		location.reload();
	}
	});
}
</script>

<div class="container">
	<div style="height:10px;"></div>     
    
    <div class="row hidden-phone"> 
    	<div class="span5">
            <ul class="breadcrum-Font breadcrumb">
			    <li><a href="<?=base_url()?>">Home</a> <span class="divider">></span></li>
			    <li class="color_active">Search Result</li>
		    </ul>
        </div>
        <div class="span7" style="float: right">
            <ul class="breadcrum-Font breadcrumb" >
                <!-- <li class="active"><a href="<?=base_url()?>store/search_product_sort_by/<?=$s_keyword?>/<?=$look_by?>/<?=$text_key?>/latest">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a href="<?=base_url()?>store/search_product_sort_by/<?=$s_keyword?>/<?=$look_by?>/<?=$text_key?>/price">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a href="<?=base_url()?>store/search_product_sort_by/<?=$s_keyword?>/<?=$look_by?>/<?=$text_key?>/name">NAME</a></li> -->
                
                
            
            	<li style="float:right" id="pagin">
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
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$s_keyword.'/'.$look_by.'/'.$text_key.'/36'?>">36</a> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$s_keyword.'/'.$look_by.'/'.$text_key.'/24'?>">24</a> <span class="divider" style="padding:2px;">|</span> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$s_keyword.'/'.$look_by.'/'.$text_key.'/12'?>">12</a> <span class="divider" style="padding:2px;">|</span> </li>
                <li style="float:right" class="active">View <span class="divider" style="padding:2px;">&nbsp;</span></li>
                
                <li style="float:right; margin-right: 30px;" class="active"><a href="javascript:void(0);" onclick="sort_by_name()">Name</a></li>
                <li style="float:right" class="active"><a href="javascript:void(0);" onclick="sort_by_price()">Price</a> <span class="divider">|</span></li>
                
                <li style="float:right" class="active">Sort by: <span class="divider">&nbsp;</span></li>
            </ul>
        </div>        
    </div>
    
    
    <!-- Menu for phone mode -->
    <div class=" visible-phone navbar" >
		<div class="container visible-phone" style="background: #fff; border: 1px solid #989898; margin-left: 5%; margin-right: 5%">
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
                  		<a class="a-nav" href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/shop_by/<?=$shopby['text']?>/<?=$shopby['id']?>">
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
	<div class="row visible-phone"> 
    	<div class="span5" style="text-align: center">
            <ul class="breadcrumb">
                
                
                <li class="active"><a href="javascript:void(0);" onclick="sort_by_latest()">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a href="javascript:void(0);" onclick="sort_by_price()">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a href="javascript:void(0);" onclick="sort_by_name()">NAME</a></li>
            </ul>
        </div>        
    </div>
	<div style="height:10px;"></div>
    
   
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	<div class="row-fluid" >            
        <div class="span12">
            <div class="row-fluid">
                <div class="span3 hidden-phone">
                    <div class="accordion" id="accordion2">
                         <div class="accordion-group"  style="border-top:none!important;">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                    Filter By
                                </a>
                            </div>
                            <div id="collapseOne" class="accordion-body collapse  <? if($curr_page=='shop_by'){echo 'in';}?>">
                                                           
                            </div>
                         </div> 
                         <? if($cat_name != 'Accessories'){?>
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                                <a style="display: block" onclick="click_line(2)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            		<div style="float:left;">SIZE</div>
									<div id="line2-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line2-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseThree" class="accordion-body collapse  <? if($curr_page=='size'){echo 'in';}?>">
                            	
                                
                                <? //if($cat_name == 'Womens'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?> href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>">
                                    View All
                                    </a>
                                </div>
                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/34" <? if($curr_opt=='34'){echo 'class="active_opt"'; }?> >
                                    34
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/35" <? if($curr_opt=='35'){echo 'class="active_opt"'; }?> >
                                    35
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/36" <? if($curr_opt=='36'){echo 'class="active_opt"'; }?> >
                                    36
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/37" <? if($curr_opt=='37'){echo 'class="active_opt"'; }?> >
                                    37
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/38" <? if($curr_opt=='38'){echo 'class="active_opt"'; }?> >
                                    38
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/39" <? if($curr_opt=='39'){echo 'class="active_opt"'; }?> >
                                    39
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/40" <? if($curr_opt=='40'){echo 'class="active_opt"'; }?> >
                                    40
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/41" <? if($curr_opt=='41'){echo 'class="active_opt"'; }?> >
                                    41
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/42" <? if($curr_opt=='42'){echo 'class="active_opt"'; }?> >
                                    42
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/43" <? if($curr_opt=='43'){echo 'class="active_opt"'; }?> >
                                    43
                                    </a>
                                </div>
                                
                                <? // } ?>
                                
                                <? //if($cat_name == 'Mens'){?>
                                <!--
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/40" <? if($curr_opt=='40'){echo 'class="active_opt"'; }?> >
                                    40
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/41" <? if($curr_opt=='41'){echo 'class="active_opt"'; }?> >
                                    41
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/42" <? if($curr_opt=='42'){echo 'class="active_opt"'; }?> >
                                    42
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/43" <? if($curr_opt=='43'){echo 'class="active_opt"'; }?> >
                                    43
                                    </a>
                                </div>-->
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/44" <? if($curr_opt=='44'){echo 'class="active_opt"'; }?> >
                                    44
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/45" <? if($curr_opt=='45'){echo 'class="active_opt"'; }?> >
                                    45
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/46" <? if($curr_opt=='46'){echo 'class="active_opt"'; }?> >
                                    46
                                    </a>
                                </div>
                                <? //} ?>                      
                                                                
                           	</div>
                         </div>
                         <? } ?>
                         
                         
                         <? //if($cat_name == 'Womens') { ?>
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                            	<a onclick="click_line(3)" style="display: block" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
                                	<div style="float:left;">COLOUR</div>
									<div id="line3-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line3-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseSix" class="accordion-body collapse  <? if($curr_page=='colour'){echo 'in';}?>">
                            	
								<? //if($cat_name == 'Womens'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/black" <? if($curr_opt=='black'){echo 'class="active_opt"'; }?>>
                                	Black
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/tan-brown" <? if($curr_opt=='tan-brown'){echo 'class="active_opt"'; }?>>
                                    Brown / Tan
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/beige-taupe" <? if($curr_opt=='beige-taupe'){echo 'class="active_opt"'; }?>>
                                    Beige / Taupe
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/white" <? if($curr_opt=='white'){echo 'class="active_opt"'; }?>>
                                    White
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/olive-green" <? if($curr_opt=='olive-green'){echo 'class="active_opt"'; }?>>
                                    Green / Olive
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/yellow-mustard" <? if($curr_opt=='yellow-mustard'){echo 'class="active_opt"'; }?>>
                                    Yellow / Mustard
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/red-orange" <? if($curr_opt=='red-orange'){echo 'class="active_opt"'; }?>>
                                    Red / Orange
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/pink" <? if($curr_opt=='pink'){echo 'class="active_opt"'; }?>>
                                    Pink
                                    </a>
                                </div> 
                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/blue-purple" <? if($curr_opt=='blue-purple'){echo 'class="active_opt"'; }?>>
                                    Blue / Purple
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/metallic" <? if($curr_opt=='metallic'){echo 'class="active_opt"'; }?>>
                                    Metallic
                                    </a>
                                </div>
                                
                                <? //} ?>
                                
                                
                                                                                                                                
                             </div>
                         </div>
                         <? //} ?>
                         
                         <? //if($cat_name == 'Womens') { ?>
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                            	<a onclick="click_line(3)" style="display: block" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseNine">
                                	<div style="float:left;">FEATURES</div>
									<div id="line3-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line3-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseNine" class="accordion-body collapse  <? if($curr_page=='features'){echo 'in';}?>">
                            	
								<? //if($cat_name == 'Womens'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/features/orthotic_friendly" <? if($curr_opt=='orthotic_friendly'){echo 'class="active_opt"'; }?>>
                                	Orthotic Friendly
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/features/wide_feet" <? if($curr_opt=='wide_feet'){echo 'class="active_opt"'; }?>>
                                    Best for Wide Feet
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/features/narrow_feet" <? if($curr_opt=='narrow_feet'){echo 'class="active_opt"'; }?>>
                                    Best for Narrow Feet
                                    </a>
                                </div>
                                
                                <? //} ?>
                                
                                
                                                                                                                                
                             </div>
                         </div>
                         <? //} ?>
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                            	<a style="display: block" onclick="click_line(4)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
                                	<div style="float:left;">PRICE</div>
									<div id="line4-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line4-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseFour" class="accordion-body collapse  <? if($curr_page=='price'){echo 'in';}?>">
                            	
								
								<div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/0-100" <? if($curr_opt=='0-100'){echo 'class="active_opt"'; }?>>
                                    $0 - $100
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/100-200" <? if($curr_opt=='100-200'){echo 'class="active_opt"'; }?>>
                                	$100 - $200
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/200-300" <? if($curr_opt=='200-300'){echo 'class="active_opt"'; }?>>
                                    $200 - $300
                                    </a>
                                </div>   
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/300" <? if($curr_opt=='300'){echo 'class="active_opt"'; }?>>
                                    $300 +
                                    </a>
                                </div>                                
                             </div>
                         </div>
                         
                                                 
                         <? //if($cat_name != 'Accessories'){?>
                         <!--
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                            	<a style="display: block" onclick="click_line(1)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                	<div style="float:left;">FABRIC</div>
									<div id="line1-down" style="float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line1-right" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseTwo" class="accordion-body collapse <?php if($curr_page!='size' && $curr_page!='colour' && $curr_page!='price') {echo "in";}?>">                                                                
                                
                                <? //if($cat_name == 'Travel'){?>
                                <div class="accordion-inner">
                                	<a <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?> href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>">
                                    View All
                                    </a>
                                </div>
                                
                                <? //} ?>
                                
                                <? //if($cat_name == 'Wallets'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                
                                <? //} ?>
                                
                                <? //if($cat_name == 'Handbags'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Leather
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Feaux Leather
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Patant Leather
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Suede
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Cotton
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Cloth
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                    <a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    Lycra
                                    </a>
                                </div>
                                
                                <? //} ?>
                            </div>                              
                         </div>
                         <? //} ?>
                         <? //if($cat_name != 'Accessories'){?>
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                                <a style="display: block" onclick="click_line(2)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            		<div style="float:left;">FEATURE</div>
									<div id="line2-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line2-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseThree" class="accordion-body collapse  <? if($curr_page=='size'){echo 'in';}?>">
                            	
                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/size/small" <? if($curr_opt=='small'){echo 'class="active_opt"'; }?>>
                                    Buckle
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/size/medium" <? if($curr_opt=='medium'){echo 'class="active_opt"'; }?>>
                                    Zip
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/size/large" <? if($curr_opt=='large'){echo 'class="active_opt"'; }?>>
                                    Steal
                                    </a>
                                </div>                          
                                                                
                           	</div>
                         </div>
                         <? //} ?>
                         
                         <div class="accordion-group shopby-Font">
                         	<div class="accordion-heading">
                            	<a onclick="click_line(3)" style="display: block" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
                                	<div style="float:left;">COLOUR</div>
									<div id="line3-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line3-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseSix" class="accordion-body collapse  <? if($curr_page=='colour'){echo 'in';}?>">
                            	
								<? //if($cat_name == 'Accessories' || $cat_name == 'Wallets' || $cat_name == 'Handbags'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/beige" <? if($curr_opt=='beige'){echo 'class="active_opt"'; }?>>
                                	Black
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/black" <? if($curr_opt=='black'){echo 'class="active_opt"'; }?>>
                                    Black Patent
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by>/colour/blue" <? if($curr_opt=='blue'){echo 'class="active_opt"'; }?>>
                                    Black Suede
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/brown" <? if($curr_opt=='brown'){echo 'class="active_opt"'; }?>>
                                    Cherry Patent
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/copper" <? if($curr_opt=='copper'){echo 'class="active_opt"'; }?>>
                                    Champagne
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/cream" <? if($curr_opt=='cream'){echo 'class="active_opt"'; }?>>
                                    Bronze
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/gold" <? if($curr_opt=='gold'){echo 'class="active_opt"'; }?>>
                                    Gray Patent
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/green" <? if($curr_opt=='green'){echo 'class="active_opt"'; }?>>
                                    Red
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/grey" <? if($curr_opt=='grey'){echo 'class="active_opt"'; }?>>
                                    Taupe
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/colour/lavender" <? if($curr_opt=='lavender'){echo 'class="active_opt"'; }?>>
                                    Silver
                                    </a>
                                </div>
                                
                                <? //} ?>
                                
                                <? //if($cat_name == 'Travel'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/black_multi" <? if($curr_opt=='black_multi'){echo 'class="active_opt"'; }?>>
                                    Black Multi
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/pink_multi" <? if($curr_opt=='pink_multi'){echo 'class="active_opt"'; }?>>
                                    Pink Muti
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/red_multi" <? if($curr_opt=='red_multi'){echo 'class="active_opt"'; }?>>
                                    Red Multi
                                    </a>
                                </div>
                                <? //} ?>
                                                                                                                                
                             </div>
                         </div>
                         
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                            	<a style="display: block" onclick="click_line(4)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
                                	<div style="float:left;">PRICE</div>
									<div id="line4-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line4-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseFour" class="accordion-body collapse  <? if($curr_page=='price'){echo 'in';}?>">
                            	
								<? //if($cat_name == 'Accessories'){?>
								<div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/99-199" <? if($curr_opt=='99-199'){echo 'class="active_opt"'; }?>>
                                	$99 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/199" <? if($curr_opt=='199'){echo 'class="active_opt"'; }?>>
                                    $199 and above
                                    </a>
                                </div>
                                <? //} ?>
                                
                                <? //if($cat_name == 'Travel'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/99-259" <? if($curr_opt=='99-259'){echo 'class="active_opt"'; }?>>
                                    $99 - $259
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/259-359" <? if($curr_opt=='259-359'){echo 'class="active_opt"'; }?>>
                                    $259 - $359
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/359" <? if($curr_opt=='359'){echo 'class="active_opt"'; }?>>
                                    $359 and above
                                    </a>
                                </div>
                                <? //} ?>
                                
                                <? //if($cat_name == 'Wallets'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/99-159" <? if($curr_opt=='99-159'){echo 'class="active_opt"'; }?>>
                                    $99 - $159
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/159-199" <? if($curr_opt=='159-199'){echo 'class="active_opt"'; }?>>
                                    $159 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/price/199" <? if($curr_opt=='199'){echo 'class="active_opt"'; }?>>
                                    $199 and above
                                    </a>
                                </div>
                                <? //} ?>
                                
                                <? //if($cat_name == 'Handbags'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/reset_search_product_by" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/price/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/price/100-199" <? if($curr_opt=='100-199'){echo 'class="active_opt"'; }?>>
                                    $100 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/price/200-299" <? if($curr_opt=='200-299'){echo 'class="active_opt"'; }?>>
                                    $200 - $299
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/search_product_by/price/300" <? if($curr_opt=='300'){echo 'class="active_opt"'; }?>>
                                    $300+
                                    </a>
                                </div>
                                
                                <? //} ?>
                             </div>
                         </div>-->
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
                		if(count($products)==0 || $on==0){echo "<div class='body-copy-Font'>The system was unable to find any search results. Please try again.</div>";}
						$now = 1;
                		foreach($products as $product)
						{
							if($product['status']==1 && $product['deleted']==0)
							{
								$hero = $this->Product_model->get_hero($product['id']);
								
								$modal = $this->Product_model->get_modal($product['id']);
								
								$category = $this->Category_model->identify($product['main_category']);
							
								//$title = explode('-',$product['title']);
								
								
								
								$cur_user = $this->session->userdata('userloggedin');
					
								//echo $cur_user['level'];
								
								if($cur_user['level'] == 1)
								{
									$bef_price = $product['price'];
								}
								elseif($cur_user['level'] == 2)
								{
									$bef_price = $product['price_trade'];
								}
								else
								{
									$bef_price = $product['price'];
								}
								
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
									<div class="row-fluid prod-list">                        
				                        <div class="span4" style="float:left; text-align: center">
				                        	<?php
				                        	if($product['sale_price'] < $product['price'])
											{
											?>
											<img class="hidden-phone" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <?php
				                            	
				                            		$hrimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$hero['name'];
													$hrimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).$hero['name'];
													
													if($modal)
													{
														$mdimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$modal['name'];
														$mdimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).$modal['name'];
													}
													else
													{
														$mdimg_ltl = $hrimg_ltl;
														$mdimg_big = $hrimg_big;
													}
				                            	
				                            	?>
	                                            <img onmouseover="this.src='<?=$mdimg_ltl?>'" onmouseout="this.src='<?=$hrimg_ltl?>'" class="hidden-phone" src="<?=$hrimg_ltl?>"/>
				                            	<img onmouseover="this.src='<?=$mdimg_big?>'" onmouseout="this.src='<?=$hrimg_big?>'" class="visible-phone" src="<?=$hrimg_big?>"/>
				                            	<!-- <img class="hidden-phone" src="<?=$hrimg_ltl?>"/>
				                            	<img class="visible-phone" src="<?=$hrimg_big?>"/> -->
	                                            <? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="feauture-title " ><a class="link_title" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><?=$product['title']?></a></div>
				                            <div class="feauture-desc" ><?=$product['short_desc']?></div>
				                            <!-- <div class="feauture-price" ><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?><? if($product['stock'] == 0){?> <span class="active_opt"> </span><? } ?></div> -->
				                            <div class="feauture-price" style="font-size: 14px;">
				                            	<?php
				                            		if($product['sale_price'] < $product['price'])
													{
													?>
														<span class="" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($bef_price * $cur_val,2,'.',',');?></span>
														&nbsp;
														<span class="primarylink color_active"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></span>
													<?
													}
													else
													{
													?>
														<?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?>
													<?
													}
				                            	?>
				                            	<!-- <?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?><? if($product['stock'] == 0){?> <span class="active_opt"> Out of stock</span><? } ?> -->
				                            </div>
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
											<img class="hidden-phone" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <?php
				                            	
				                            		$hrimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$hero['name'];
													$hrimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).$hero['name'];
													
													if($modal)
													{
														$mdimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$modal['name'];
														$mdimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).$modal['name'];
													}
													else
													{
														$mdimg_ltl = $hrimg_ltl;
														$mdimg_big = $hrimg_big;
													}
				                            	
				                            	?>
	                                            <img onmouseover="this.src='<?=$mdimg_ltl?>'" onmouseout="this.src='<?=$hrimg_ltl?>'" class="hidden-phone" src="<?=$hrimg_ltl?>"/>
				                            	<img onmouseover="this.src='<?=$mdimg_big?>'" onmouseout="this.src='<?=$hrimg_big?>'" class="visible-phone" src="<?=$hrimg_big?>"/>		
				                            	<!-- <img class="hidden-phone" src="<?=$hrimg_ltl?>"/>
				                            	<img class="visible-phone" src="<?=$hrimg_big?>"/>			 -->						
	                                            <? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="feauture-title " ><a class="link_title" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><?=$product['title']?></a></div>
				                            <div class="feauture-desc" ><?=$product['short_desc']?></div>
				                            <!-- <div class="feauture-price" ><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?><? if($product['stock'] == 0){?> <span class="active_opt"> </span><? } ?></div> -->
				                            <div class="feauture-price" style="font-size: 14px;">
				                            	<?php
				                            		if($product['sale_price'] < $product['price'])
													{
													?>
														<span class="" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($bef_price * $cur_val,2,'.',',');?></span>
														&nbsp;
														<span class="primarylink color_active"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></span>
													<?
													}
													else
													{
													?>
														<?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?>
													<?
													}
				                            	?>
				                            	<!-- <?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?><? if($product['stock'] == 0){?> <span class="active_opt"> Out of stock</span><? } ?> -->
				                            </div>
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
											<img class="hidden-phone" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <?php
				                            	
				                            		$hrimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$hero['name'];
													$hrimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).$hero['name'];
													
													if($modal)
													{
														$mdimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$modal['name'];
														$mdimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).$modal['name'];
													}
													else
													{
														$mdimg_ltl = $hrimg_ltl;
														$mdimg_big = $hrimg_big;
													}
				                            	
				                            	?>
	                                            <img onmouseover="this.src='<?=$mdimg_ltl?>'" onmouseout="this.src='<?=$hrimg_ltl?>'" class="hidden-phone" src="<?=$hrimg_ltl?>"/>
				                            	<img onmouseover="this.src='<?=$mdimg_big?>'" onmouseout="this.src='<?=$hrimg_big?>'" class="visible-phone" src="<?=$hrimg_big?>"/> 
				                            	<!-- <img class="hidden-phone" src="<?=$hrimg_ltl?>"/>
				                            	<img class="visible-phone" src="<?=$hrimg_big?>"/> -->
												<? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="feauture-title " ><a class="link_title" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><?=$product['title']?></a></div>
				                            <div class="feauture-desc" ><?=$product['short_desc']?></div>
				                            <!-- <div class="feauture-price" ><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?><? if($product['stock'] == 0){?> <span class="active_opt"> </span><? } ?></div> -->
				                            <div class="feauture-price" style="font-size: 14px;">
				                            	<?php
				                            		if($product['sale_price'] < $product['price'])
													{
													?>
														<span class="" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($bef_price * $cur_val,2,'.',',');?></span>
														&nbsp;
														<span class="primarylink color_active"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></span>
													<?
													}
													else
													{
													?>
														<?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?>
													<?
													}
				                            	?>
				                            	<!-- <?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?><? if($product['stock'] == 0){?> <span class="active_opt"> Out of stock</span><? } ?> -->
				                            </div>
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
                	           
                    <!-- <div class="row-fluid">                        
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
                     
                    <!-- <div class="row-fluid">                        
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
                    <div class="row-fluid">    
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
                <div class="span5">
            
        		</div>
		        <div class="span7" style="float: right;  margin-right: 0px;">
		            <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase; padding-right: 2px">
		            
		            	<li style="float:right" id="pagin">
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
		                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$s_keyword.'/'.$look_by.'/'.$text_key.'/36'?>">36</a> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$s_keyword.'/'.$look_by.'/'.$text_key.'/24'?>">24</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$s_keyword.'/'.$look_by.'/'.$text_key.'/12'?>">12</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active">VIEW <span class="divider" style="padding:2px;">&nbsp;</span></li>
		            </ul>
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
    <!-- <div class="row visible-phone">
    	<div style="height:10px;"></div>
        <div class="row-fluid">
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