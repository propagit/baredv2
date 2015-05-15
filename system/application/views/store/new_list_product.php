<?php
	
	$curr_page = $look_by;
	$curr_opt = $text_key;
	
	

	$url_pages=$_SERVER['REQUEST_URI'];
	$ex_pages=explode("/",$url_pages);
	
	if($ex_pages[3]!='search_result')
	{
		if($curr_page=='' && $curr_opt=='')
		{
			$curr_page='shop_by';
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

<div class="app-container">
	<div style="height:10px;"></div>     
    
    <div class=" hidden-xs"> 
    	<div class="col-sm-5">
            <ul class="breadcrum-Font breadcrumb" style="font-size: 11px; text-transform:capitalize;padding-left:15px;">
			    <li><a class="a-secondary" href="<?=base_url()?>">Home</a> <span class="divider">></span></li>
			    <? if($ex_pages[5] != 'all'){ ?>
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
						
						$url = base_url().'store/products/'.$ex_pages[4].'/all';
						
						if($ex_pages[5] != 'all'){ ?>
							<a class="a-secondary" href="<?=$url?>"><?=strtoupper($ex_pages[4])?></a>
                        <?
						}
						else{
							echo $ex_pages[4];
						}
					}
					else
					{
						echo 'Search Results';
					}
			    	?>
                	<? if($ex_pages[5] != 'all'){ ?>    
                    <span class="divider">></span>
                    <? } ?>
			    </li>
			    <? if($ex_pages[5] != 'all'){ ?>
                <li class="active">
                	<?php
                	echo $scate;
                	?>
                </li>
                <? } ?>
		    </ul>
        </div>
        <div class="col-sm-7 visible-sm">
          
            
            <ul class="breadcrum-Font breadcrumb" >
              
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
               
                <li style="float:right; margin-right: 30px;" class="active"><a href="javascript:void(0);" onclick="sort_by_name()">Name</a></li>
                <li style="float:right" class="active"><a href="javascript:void(0);" onclick="sort_by_price()">Price</a> <span class="divider">|</span></li>
                
                <li style="float:right" class="active">Sort by: <span class="divider">&nbsp;</span></li>
            </ul>
        </div>        
        <div class="col-sm-7 hidden-desktop">
            <ul class="breadcrumb" style="font-size: 10px; text-transform: uppercase; padding-right: 2px">
               
                
                <li class="active"><a class="a-secondary" href="javascript:void(0);" onclick="sort_by_latest()">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a class="a-secondary" href="javascript:void(0);" onclick="sort_by_price()">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a class="a-secondary" href="javascript:void(0);" onclick="sort_by_name()">NAME</a></li>
            
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
               
                
            </ul>
        </div>        
    </div>
    
    
   
	<div style="height:10px;"></div>
	<?php
	$url_pages=$_SERVER['REQUEST_URI'];
	?>
	<div class=" visible-xs"> 
    	<div class="col-sm-5" style="text-align: center">
            <ul class="breadcrumb">
                <li class="active"><a class="a-secondary" href="javascript:void(0);" onclick="sort_by_latest()">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a class="a-secondary" href="javascript:void(0);" onclick="sort_by_price()">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a class="a-secondary" href="javascript:void(0);" onclick="sort_by_name()">NAME</a></li>
            </ul>
        </div>        
    </div>
	<div style="height:10px;"></div>
    
    
    
    <!-- Menu Phone End-->
    <?php $curr_opt = $text_key; if($curr_opt == '0') {$curr_opt = '';}?>
    <!-- Menu and Product List for desktop and Ipad version -->
   	<div class="" >            
        <div class="col-sm-12">
            <div class="">
                <div class="col-sm-2 hidden-xs">
                    <div class="accordion" id="accordion2">
                         <div class="accordion-group"  style="border-top:none!important;">
                            <div class="accordion-heading filter-heading">
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
                                     
                                                                
                           	</div>
                         </div>
                         <? } ?>
                         
                         
                 
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
                            	
								<? if($cat_name == 'Womens'){?>
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
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/tan-bn" <? if($curr_opt=='tan-bn'){echo 'class="active_opt"'; }?>>
                                    Bn / Tan
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
                                
                                <? }else{ ?>
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
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/tan-bn" <? if($curr_opt=='tan-bn'){echo 'class="active_opt"'; }?>>
                                    Bn / Tan
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/olive-green" <? if($curr_opt=='olive-green'){echo 'class="active_opt"'; }?>>
                                    Green / Olive
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/red" <? if($curr_opt=='red'){echo 'class="active_opt"'; }?>>
                                    Red 
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/sand" <? if($curr_opt=='sand'){echo 'class="active_opt"'; }?>>
                                    Sand
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/navy" <? if($curr_opt=='navy'){echo 'class="active_opt"'; }?>>
                                    Navy
                                    </a>
                                </div>                                
                                <? } ?>
                                
                                                                                                                                
                             </div>
                         </div>
   
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
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/features/nar_feet" <? if($curr_opt=='nar_feet'){echo 'class="active_opt"'; }?>>
                                    Best for Nar Feet
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
                    </div>                                                    
                </div>
                <div class="col-sm-10 xs-x-gutters" style="float:right;">         
                	
                	<?php
                		$on = 0;			
                		foreach($products as $pt)
						{
							if($def=='pos'){$product=$this->Position_model->identify_product($pt['id']);}
							else{$product=$this->Position_model->identify_product($pt['id']);}
							
							if($product['status']==1 && $product['deleted']==0 )
							{
								$on++;
							}
						}
                		if(count($products)==0 || $on==0){echo "<div class='body-copy-Font'>The system was unable to find any search results. Please try again.</div>";}
						$now = 1;
						$counter = 1;
                		foreach($products as $pt)
						{
							if($def=='pos'){$product=$this->Position_model->identify_product($pt['id']);}else{$product=$this->Position_model->identify_product($pt['id']);}
							if($product['status']==1 && $product['deleted']==0 )
							{
								$hero = $this->Product_model->get_hero($product['id']);
								$modal = $this->Product_model->get_modal($product['id']);
								$category = $this->Category_model->identify($product['main_category']);
								$title = explode('-',$product['title']);
								$cur_user = $this->session->userdata('userloggedin');
								
								$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
								$normal_price_arr = explode('.',$product['price']);
								$sale_price_arr = explode('.',$product['sale_price']);
					
								
								?>
                                 <div class="col-xs-6 col-sm-4 col-md-3 product list-view">
                                 <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
                                      <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
                                 </a>
                                      <div class="product-info <?=$on_sale;?>">
                                          <h3><?=$product['title'];?></h3>
                                          <h4><?=$product['short_desc'];?></h4>
                                          <h4><span class="currency"><?=$sign?></span> 
                                            <span class="price">
                                                <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                                                <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                                            </span>
                                          </h4>
                                          <div class="rating">
                                                <div class="yotpo bottomLine"
                                                    data-appkey="87cmugsJWWCvn4YdAy3U9AcGnlYiUwvpv1TKwE5Z"
                                                    data-domain="bared.com.au"
                                                    data-product-id="<?=$product['review_category']?>"
                                                    data-product-models="<?=$product['title']?>"
                                                    data-name="<?=$product['title']?> <?=$product['short_desc']?>"
                                                    data-url="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"
                                                    data-image-url="The product image url. Url escaped"
                                                    data-description="<?=$product['long_desc']?>"
                                                    data-bread-crumbs="Product categories"
                                                    data-images-star_empty="<?=base_url()?>img/star_empty.png"
                                                    data-images-star_half="<?=base_url()?>img/star_half.png"
                                                    data-images-star_full="<?=base_url()?>img/star_full.png">                                                                            
                                               </div>
                                          </div>
                                      </div>
                                  </div>
                                 
                                 
                                <?php
									if($counter%2 == 0){
										echo '<div class="break-list"></div>';	
									}
									$counter++;
								?> 
                                 
                                <?php	
							}
							
						}
                	?>
                	           
                   
                    
                </div>
                <div class="col-sm-5">
            
        		</div>
		        <div class="col-sm-7" style="float: right;  margin-right: 0px;">
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
		               
		            </ul>
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
    
    