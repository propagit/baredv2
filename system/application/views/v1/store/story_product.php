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
.active_opt{
	color:#F0F;
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
</style>
<?php
	
	$url_pages=$_SERVER['REQUEST_URI'];
	$ex_pages=explode("/",$url_pages);
	
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
	$cat_name = 'Handbags';
	$scat_name = 'all';
	
?>
<div class="container">
	<div style="height:20px;"></div>         
     <div class="row hidden-phone"> 
    	<div class="span5">
            <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase">
			    <li><a href="<?=base_url()?>">HOME  </a> <span class="divider">></span></li>
			   <li><a href="<?=base_url()?>store/stories_new/all">The Magazine  </a> </li>
               <!--
				<? if($ex_pages[4] == 'all' || $ex_pages[4] == 'archive' ){ ?>
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
						
						if($ex_pages[4] == 'all' || $ex_pages[4] == 'archive'){ 
							echo strtoupper('The Bagazine');
                        
						}
						else{
							if($ex_pages[4]=='single'){
								$str=$this->System_model->get_story_id($ex_pages[5]);
								?>
								<a href="<?=base_url()?>store/stories_new/single/<?=$ex_pages[5]?>"><?=strtoupper($str['title'])?></a>
							<? }else{
						?>
							
                            <a href="<?=base_url()?>store/stories_new/<?=$ex_pages[4]?>"><?=strtoupper($ex_pages[4])?></a>
					   <? } }
					}
					else
					{
						echo strtoupper('search results');
					}
			    	?>
                	
			    </li>
			   -->
		    </ul>
        </div>
        <div class="span7">
            <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase; padding-right: 2px">
                <li class="active"><a href="<?=base_url()?>store/story_product_new/<?=$ex_pages[4]?>/<?=$ex_pages[5]?>/latest">SORT BY LATEST</a> <span class="divider">|</span></li>
                <li class="active"><a href="<?=base_url()?>store/story_product_new/<?=$ex_pages[4]?>/<?=$ex_pages[5]?>/price">PRICE</a> <span class="divider">|</span></li>
                <li class="active"><a href="<?=base_url()?>store/story_product_new/<?=$ex_pages[4]?>/<?=$ex_pages[5]?>/title">NAME</a></li>
            
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
                <li style="float:right" class="active"><a href="<?=base_url()?>store/story_product_new/<?=$ex_pages[4].'/'.$ex_pages[5].'/latest/36'?>">36</a> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?>store/story_product_new/<?=$ex_pages[4].'/'.$ex_pages[5].'/latest/24'?>">24</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active"><a href="<?=base_url()?>store/story_product_new/<?=$ex_pages[4]?>/<?=$ex_pages[5]?>">12</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active">VIEW <span class="divider" style="padding:2px;">&nbsp;</span></li>
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
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	<!--<div class="row-fluid  " >            
        <div class="span12">
            <div class="row-fluid">
                <div class="span3 hidden-phone">
                    <div class="accordion" id="accordion2">
                         <div class="accordion-group"  style="border-top:none!important;">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                    SHOP BY
                                </a>
                            </div>
                            <div id="collapseOne" class="accordion-body collapse  <? if($curr_page=='shop_by'){echo 'in';}?>">
                                                           
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
                                	<a <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?> href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>">
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/pre-order" <? if($curr_opt=='pre-order'){echo 'class="active_opt"'; }?>>
                                    Pre-Order
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/4_wheels" <? if($curr_opt=='4_wheels'){echo 'class="active_opt"'; }?> >
                                    4 Wheels
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/2_wheels" <? if($curr_opt=='2_wheels'){echo 'class="active_opt"'; }?>>
                                    2 Wheels
                                    </a>
                                </div>                                
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/expandable" <? if($curr_opt=='expandable'){echo 'class="active_opt"'; }?>>
                                    Expandable
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/extendable_handle" <? if($curr_opt=='extendable_handle'){echo 'class="active_opt"'; }?>>
                                    Extendable Handle
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/lightweight" <? if($curr_opt=='lightweight'){echo 'class="active_opt"'; }?>>
                                    Lightweight
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/business" <? if($curr_opt=='business'){echo 'class="active_opt"'; }?>>
                                    Business
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/tsa_locks" <? if($curr_opt=='tsa_locks'){echo 'class="active_opt"'; }?>>
                                    TSA Locks
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Wallets'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/pre-order" <? if($curr_opt=='pre-order'){echo 'class="active_opt"'; }?>>
                                    Pre-Order
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/leather" <? if($curr_opt=='leather'){echo 'class="active_opt"'; }?>>
                                    Leather
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/faux-leather" <? if($curr_opt=='faux-leather'){echo 'class="active_opt"'; }?>>
                                    Faux-Leather
                                    </a>
                                </div>                                
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/applique" <? if($curr_opt=='applique'){echo 'class="active_opt"'; }?>>
                                    Applique
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/sparkles" <? if($curr_opt=='sparkles'){echo 'class="active_opt"'; }?>>
                                    Sparkles
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Handbags'){

									?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/pre-order" <? if($curr_opt=='pre-order'){echo 'class="active_opt"'; }?>>
                                    Pre-Order
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/leather" <? if($curr_opt=='leather'){echo 'class="active_opt"'; }?>>
                                    Leather
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/faux-leather" <? if($curr_opt=='faux-leather'){echo 'class="active_opt"'; }?>>
                                    Faux-Leather
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/fabric" <? if($curr_opt=='fabric'){echo 'class="active_opt"'; }?>>
                                    Fabric
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/stripe" <? if($curr_opt=='stripe'){echo 'class="active_opt"'; }?>>
                                    Stripe
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/froral" <? if($curr_opt=='froral'){echo 'class="active_opt"'; }?>>
                                    Floral
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/applique" <? if($curr_opt=='applique'){echo 'class="active_opt"'; }?>>
                                    Applique
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/embroidery" <? if($curr_opt=='embroidery'){echo 'class="active_opt"'; }?>>
                                    Embroidery
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/crystals" <? if($curr_opt=='crystal'){echo 'class="active_opt"'; }?>>
                                    Crystals
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/metallic" <? if($curr_opt=='metallic'){echo 'class="active_opt"'; }?>>
                                    Metallic
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/limited" <? if($curr_opt=='limited'){echo 'class="active_opt"'; }?>>
                                    Limited
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/first_edition" <? if($curr_opt=='first_edition'){echo 'class="active_opt"'; }?>>
                                    First Edition
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/frame" <? if($curr_opt=='frame'){echo 'class="active_opt"'; }?>>
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
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/small" <? if($curr_opt=='small'){echo 'class="active_opt"'; }?>>
                                    Small
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/medium" <? if($curr_opt=='medium'){echo 'class="active_opt"'; }?>>
                                    Medium
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/size/large" <? if($curr_opt=='large'){echo 'class="active_opt"'; }?>>
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
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/beige" <? if($curr_opt=='beige'){echo 'class="active_opt"'; }?>>
                                	Beige
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/black" <? if($curr_opt=='black'){echo 'class="active_opt"'; }?>>
                                    Black
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/blue" <? if($curr_opt=='blue'){echo 'class="active_opt"'; }?>>
                                    Blue
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/brown" <? if($curr_opt=='brown'){echo 'class="active_opt"'; }?>>
                                    Brown
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/copper" <? if($curr_opt=='copper'){echo 'class="active_opt"'; }?>>
                                    Copper
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/cream" <? if($curr_opt=='cream'){echo 'class="active_opt"'; }?>>
                                    Cream
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/gold" <? if($curr_opt=='gold'){echo 'class="active_opt"'; }?>>
                                    Gold
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/green" <? if($curr_opt=='green'){echo 'class="active_opt"'; }?>>
                                    Green
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/grey" <? if($curr_opt=='grey'){echo 'class="active_opt"'; }?>>
                                    Grey
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/lavender" <? if($curr_opt=='lavender'){echo 'class="active_opt"'; }?>>
                                    Lavender
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/lilac" <? if($curr_opt=='lilac'){echo 'class="active_opt"'; }?>>
                                    Lilac
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/maroon" <? if($curr_opt=='maroon'){echo 'class="active_opt"'; }?>>
                                    Maroon
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/orange" <? if($curr_opt=='orange'){echo 'class="active_opt"'; }?>>
                                    Orange
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/pink" <? if($curr_opt=='pink'){echo 'class="active_opt"'; }?>>
                                    Pink
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/purple" <? if($curr_opt=='purple'){echo 'class="active_opt"'; }?>>
                                    Purple
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/red" <? if($curr_opt=='red'){echo 'class="active_opt"'; }?>>
                                    Red
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/silver" <? if($curr_opt=='silver'){echo 'class="active_opt"'; }?>>
                                    Silver
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/white" <? if($curr_opt=='white'){echo 'class="active_opt"'; }?>>
                                    White 
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>/yellow" <? if($curr_opt=='yellow'){echo 'class="active_opt"'; }?>>
                                    Yellow
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Travel'){?>
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
                                	<a href="<?=base_url()?>store/story_product_new/<?=$cat_story_link?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/99-199" <? if($curr_opt=='99-199'){echo 'class="active_opt"'; }?>>
                                	$99 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/199" <? if($curr_opt=='199'){echo 'class="active_opt"'; }?>>
                                    $199 and above
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Travel'){?>
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
                                <? } ?>
                                
                                <? if($cat_name == 'Wallets'){?>
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
                                <? } ?>
                                
                                <? if($cat_name == 'Handbags'){?>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/0-99" <? if($curr_opt=='0-99'){echo 'class="active_opt"'; }?>>
                                    $0 - $99
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/99-199" <? if($curr_opt=='99-199'){echo 'class="active_opt"'; }?>>
                                    $99 - $199
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/199-299" <? if($curr_opt=='199-299'){echo 'class="active_opt"'; }?>>
                                    $199 - $299
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/299-399" <? if($curr_opt=='299-399'){echo 'class="active_opt"'; }?>>
                                    $299 - $399
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/399-499" <? if($curr_opt=='399-499'){echo 'class="active_opt"'; }?>>
                                    $399 - $499
                                    </a>
                                </div>
                                <div class="accordion-inner">
                                	<a href="<?=base_url()?>story_product_new/<?=$cat_story_link?>/499" <? if($curr_opt=='499'){echo 'class="active_opt"'; }?>>
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
						if(count($products>0))
						{
                		$on = 0;
                		foreach($products as $product)
						{
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
								$catprod = $this->Category_model->identify($product['main_category']);
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
									<div class="row-fluid">                        
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
				                            <a href="<?=base_url()?>store/detail_product/<?=$catprod['title']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <img class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>"/>
				                            	<img class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>
	                                            <? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><span style="font-size: 18px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></div>
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
											<img class="hidden-phone" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$catprod['title']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <img class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>"/>
				                            	<img class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>											
	                                            <? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><span style="font-size: 18px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></div>
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
											<img class="hidden-phone" style="position: absolute" src="<?=base_url()?>img/ssale-sign.png" />
											<img class="visible-phone" style="position: absolute" src="<?=base_url()?>img/sale-sign.png" />
											<?php
											}
				                        	?>
				                            <a href="<?=base_url()?>store/detail_product/<?=$catprod['title']?>/<?=$product['id_title']?>">
				                            	<? if($hero){?>
	                                            <img class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>"/>
				                            	<img class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/> 
												<? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <div class="prod_title" style="font-family: buenard; font-size: 14px;"><span style="font-size: 18px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></div>
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
						
						}
                	?>
                	           
                   
                    
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
		                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$ex_pages[4].'/'.$ex_pages[5].'/'.'/36'?>">36</a> </li>
		                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$ex_pages[4].'/'.$ex_pages[5].'/'.'/24'?>">24</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
		                <li style="float:right" class="active"><a href="<?=base_url()?><?=$ex_pages[2].'/'.$ex_pages[3].'/'.$ex_pages[4].'/'.$ex_pages[5]?>">12</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
		                <li style="float:right" class="active">VIEW <span class="divider" style="padding:2px;">&nbsp;</span></li>
		            </ul>
		        </div>
         	</div>  -->                      
            
    <? $cat_name = 'Womens'; ?>
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
                            	<a style="display: block" onclick="click_line(1)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                	<div class="a-secondary" style="float:left;">STYLE</div>
									<div id="line1-down" style="float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line1-right" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseTwo" class="accordion-body collapse <?php if($curr_page=='shop_by' || $curr_page=='style') {echo "in";}?>">                                                                
                                
                                <? if($cat_name == 'Womens'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>">
                                    View All
                                    </a>
                                </div>
                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/new_arrivals" <? if($curr_opt=='new_arrivals'){echo 'class="active_opt"'; }?> >
                                    New arrivals
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/ballets_flat" <? if($curr_opt=='ballets_flats'){echo 'class="active_opt"'; }?>>
                                    Ballet Flats
                                    </a>
                                </div>                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/lace_up" <? if($curr_opt=='lace_ups'){echo 'class="active_opt"'; }?>>
                                    Lace Ups
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/loafers" <? if($curr_opt=='loafers'){echo 'class="active_opt"'; }?>>
                                    Loafers
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/ankle_boot" <? if($curr_opt=='ankle_boots'){echo 'class="active_opt"'; }?>>
                                    Ankle Boots
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/knee_high_boot" <? if($curr_opt=='kee_high_boots'){echo 'class="active_opt"'; }?>>
                                    Knee High Boots
                                    </a>
                                </div>
                                <!-- <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/sandal" <? if($curr_opt=='sandals'){echo 'class="active_opt"'; }?>>
                                    Sandals
                                    </a>
                                </div> -->
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/wedge" <? if($curr_opt=='wedges'){echo 'class="active_opt"'; }?>>
                                    Wedges
                                    </a>
                                </div>
                                <!-- <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/heel" <? if($curr_opt=='heels'){echo 'class="active_opt"'; }?>>
                                    Heels
                                    </a>
                                </div> -->
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/casual" <? if($curr_opt=='casual'){echo 'class="active_opt"'; }?>>
                                    Casual
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/accessories" <? if($curr_opt=='accessories'){echo 'class="active_opt"'; }?>>
                                    Accessories
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/gift_card" <? if($curr_opt=='gift_cards'){echo 'class="active_opt"'; }?>>
                                    Gift Cards
                                    </a>
                                </div>
                                <? } ?>
                                
                                <? if($cat_name == 'Mens'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/new_arrivals" <? if($curr_opt=='new_arrivals'){echo 'class="active_opt"'; }?>>
                                    New arrivals
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/brogues" <? if($curr_opt=='brogues'){echo 'class="active_opt"'; }?>>
                                    Brogues
                                    </a>
                                </div>                                
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/boat_shoe" <? if($curr_opt=='boat_shoes'){echo 'class="active_opt"'; }?>>
                                    Boat Shoes
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/loafers" <? if($curr_opt=='loafers'){echo 'class="active_opt"'; }?>>
                                    Loafers
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/derby_oxford" <? if($curr_opt=='derby_oxford'){echo 'class="active_opt"'; }?>>
                                    Derby &amp; Oxfords
                                    </a>
                                </div>
                                <!-- <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/work" <? if($curr_opt=='work'){echo 'class="active_opt"'; }?>>
                                    Work
                                    </a>
                                </div> -->
                                <!-- <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/boot" <? if($curr_opt=='boots'){echo 'class="active_opt"'; }?>>
                                    Boots
                                    </a>
                                </div> -->
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/dress_shoes" <? if($curr_opt=='dress_shoes'){echo 'class="active_opt"'; }?>>
                                    Dress Shoes
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/accessories" <? if($curr_opt=='accessories'){echo 'class="active_opt"'; }?>>
                                    Accessories
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/style/gift_card" <? if($curr_opt=='gift_card'){echo 'class="active_opt"'; }?>>
                                    Gift Card
                                    </a>
                                </div>
                                <? } ?>
                                
                                
                            </div>                              
                         </div>
                         <? } ?>
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
                            	
                                
                                <? if($cat_name == 'Womens'){?>
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
                                
                                <? } ?>
                                
                                <? if($cat_name == 'Mens'){?>
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
                                <? } ?>                      
                                                                
                           	</div>
                         </div>
                         <? } ?>
                         
                         
                         <? if($cat_name == 'Womens') { ?>
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
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/tan-brown" <? if($curr_opt=='tan-brown'){echo 'class="active_opt"'; }?>>
                                    Tan / Brown
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/olive-green" <? if($curr_opt=='olive-green'){echo 'class="active_opt"'; }?>>
                                    Olive / Green
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/red-pink-orange" <? if($curr_opt=='red-pink-orange'){echo 'class="active_opt"'; }?>>
                                    Red / Pink / Orange
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
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/blue" <? if($curr_opt=='blue'){echo 'class="active_opt"'; }?>>
                                    Blue
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/colour/metallic" <? if($curr_opt=='metallic'){echo 'class="active_opt"'; }?>>
                                    Metallic
                                    </a>
                                </div>
                                
                                <? } ?>
                                
                                
                                                                                                                                
                             </div>
                         </div>
                         <? } ?>
                         
                         <? if($cat_name == 'Womens') { ?>
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
                            	
								<? if($cat_name == 'Womens'){?>
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
                                
                                <? } ?>
                                
                                
                                                                                                                                
                             </div>
                         </div>
                         <? } ?>
                         
                         <? if($cat_name == 'Mens') { ?>
                         <div class="accordion-group">
                         	<div class="accordion-heading shopby-Font">
                            	<a onclick="click_line(3)" style="display: block" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
                                	<div style="float:left;">GENERIC</div>
									<div id="line3-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
									<div id="line3-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
									<div style="clear: both"></div>
                                </a>
                            </div>
                            <div id="collapseSix" class="accordion-body collapse  <? if($curr_page=='features'){echo 'in';}?>">
                            	
								<? if($cat_name == 'Mens'){?>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by_reset/<?=$cat_name?>/<?=$scat_name?>" <? if($curr_opt=='view_all'){echo 'class="active_opt"'; }?>>
                                    View All
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/generic/newin" <? if($curr_opt=='newin'){echo 'class="active_opt"'; }?>>
                                	New In
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/generic/men" <? if($curr_opt=='men'){echo 'class="active_opt"'; }?>>
                                    Men's
                                    </a>
                                </div>
                                <div class="accordion-inner shopby-Font">
                                	<a href="<?=base_url()?>store/product_by/<?=$cat_name?>/<?=$scat_name?>/generic/women" <? if($curr_opt=='women'){echo 'class="active_opt"'; }?>>
                                    Women's
                                    </a>
                                </div>
                                
                                <? } ?>
                                
                                
                                                                                                                                
                             </div>
                         </div>
                         <? } ?>
                         
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
                <div class="span9" style="float:right;">         
                	
                	<?php
                		$on = 0;
						
						
                		foreach($products as $product)
						{
							
							
							if($product['status']==1 && $product['deleted']==0 )
							{
								$on++;
							}
						}
                		if(count($products)==0 || $on==0){echo "<div class='body-copy-Font'>The system was unable to find any search results. Please try again.</div>";}
						$now = 1;
                		foreach($products as $product)
						{
							if($product['status']==1 && $product['deleted']==0 )
							{
								$hero = $this->Product_model->get_hero($product['id']);
								
								$modal = $this->Product_model->get_modal($product['id']);
								
								$category = $this->Category_model->identify($product['main_category']);
							
								$title = explode('-',$product['title']);
								
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
													$hrimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/'.$hero['name'];
													
													if($modal)
													{
														$mdimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$modal['name'];
														$mdimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/'.$modal['name'];
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
				                            <!-- <div class="prod_title secondFont font14normal" style="font-size: 14px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><span class="font18bold"><?=trim($title[0])?></span> <?=trim($title[1])?></a></div> -->
				                            <div class="feauture-title" style="font-size: 14px;"><a class="link_title" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><?=$product['title']?></a></div>
				                            <div class="feauture-desc" style="font-size: 14px;"><?=$product['short_desc']?></div>
				                            <?php
				                            if($product['gift_card'] != 1)
											{
				                            ?>
					                            <div class="feauture-price" style="font-size: 14px;">
					                            	<?php
					                            		if($product['sale_price'] < $product['price'])
														{
														?>
															<span class="color_active" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($bef_price * $cur_val,2,'.',',');?></span>
															&nbsp;
															<span class="primarylink"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></span>
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
				                            <?php
				                            }
				                            ?>
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
													$hrimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/'.$hero['name'];
													
													if($modal)
													{
														$mdimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$modal['name'];
														$mdimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/'.$modal['name'];
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
				                            	<img class="visible-phone" src="<?=$hrimg_big?>"/>		 -->									
	                                            <? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <!-- <div class="prod_title secondFont font14normal" style="font-size: 14px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><span class="font18bold"><?=trim($title[0])?></span> <?=trim($title[1])?></a></div> -->
				                            <div class="feauture-title" style="font-size: 14px;"><a class="link_title" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><?=$product['title']?></a></div>
				                            <div class="feauture-desc" style="font-size: 14px;"><?=$product['short_desc']?></div>
				                            <div class="feauture-price" style="font-size: 14px;">
				                            	<?php
				                            		if($product['sale_price'] < $product['price'])
													{
													?>
														<span class="color_active" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($bef_price * $cur_val,2,'.',',');?></span>
														&nbsp;
														<span class="primarylink"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></span>
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
													$hrimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/'.$hero['name'];
													
													if($modal)
													{
														$mdimg_ltl = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/thumb5/'.$modal['name'];
														$mdimg_big = base_url().'uploads/products/'.md5('mbb'.$product['id']).'/'.$modal['name'];
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
				                            	<img class="visible-phone" src="<?=$hrimg_big?>"/>  -->
												<? } else { ?>
												<img class="hidden-phone" src="http://placehold.it/241x262" alt="">
	                                            
	                                            <img class="visible-phone" src="http://placehold.it/710x775" alt="">
												<? }?>
				                            </a>
				                            <div style="height:10px;"></div>
				                            <!-- <div class="prod_title secondFont font14normal" style="font-size: 14px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><span class="font18bold"><?=trim($title[0])?></span> <?=trim($title[1])?></a></div> -->
				                            <div class="feauture-title" style="font-size: 14px;"><a class="link_title" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>"><?=$product['title']?></a></div>
				                            <div class="feauture-desc" style="font-size: 14px;"><?=$product['short_desc']?></div>
				                            <div class="feauture-price" style="font-size: 14px;">
				                            	<?php
				                            		if($product['sale_price'] < $product['price'])
													{
													?>
														<span class="color_active" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($bef_price * $cur_val,2,'.',',');?></span>
														&nbsp;
														<span class="primarylink"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></span>
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
		            <!--
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
		                
                        <li style="float:right" class="active"><a class="a-secondary" href="<?=base_url()?><?='store/products/'.$cat_name.'/'.$scat_name.'/'.$look_by.'/'.$text_key.'/'.'/36'?>">36</a> </li>
                		<li style="float:right" class="active"><a class="a-secondary" href="<?=base_url()?><?='store/products/'.$cat_name.'/'.$scat_name.'/'.$look_by.'/'.$text_key.'/'.'/24'?>">24</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active"><a class="a-secondary" href="<?=base_url()?><?='store/products/'.$cat_name.'/'.$scat_name.'/'.$look_by.'/'.$text_key.'/'.'/12'?>">12</a> <span class="divider" style="padding:2px;">&nbsp;</span> </li>
                <li style="float:right" class="active">VIEW <span class="divider" style="padding:2px;">&nbsp;</span></li>
		            </ul>
                    -->
		        </div>
         	</div>
            
       </div>                                                                         
  	</div>
    
    <!-- Menu for desktop and Ipad end -->
    
    
		
        
   