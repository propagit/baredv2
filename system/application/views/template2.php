<script>
	
  $('[id^="myCarousel"]').carousel();


</script>  
<style>
/*	
.navbar-fixed-top, .navbar-fixed-bottom 
{
	position:relative;
	
}
.navbar-fixed-top {
	margin-bottom:0px;
}
.thumbnail {
    line-height: 15px!important;
}

@media (min-width: 1200px) {
	.row-fluid .span4 {
	  
	   width: 32.8%;
	}
	.row-fluid [class*="span"] {
	
		float: left;
		margin-left: -2.5%;
	}
	.row-fluid .span8 {
		width: 66.4%;
	}
	
	.cindicator
	{
		right:390px; top: 565px;
	}
}

@media (min-width: 979px) and (max-width:1200px){
	.row-fluid .span4 {
		width: 32.3%;
	}
	.row-fluid [class*="span"] {
	
		float: left;
		margin-left: -2.5%;
	}
	.row-fluid .span8 {
		width: 66.4%;
	}
	.cindicator
	{
		right:315px; top: 450px;
	}
}
@media (max-width: 979px) {
	.cindicator
	{
		right:225px; top: 340px;
	}

}
*/	
</style>

<script>
//alert(navigator.userAgent + "<br>");

//Detect browser and write the corresponding name

var new_style = '';
if (navigator.userAgent.search("MSIE") >= 0){
    //alert('"MS Internet Explorer ');
    var position = navigator.userAgent.search("MSIE") + 5;
    var end = navigator.userAgent.search("; Windows");
    var version = navigator.userAgent.substring(position,end);
    if(version < 9)
    {
    	alert(version + '"');
    }
}
else if (navigator.userAgent.search("Chrome") >= 0){
	//alert('"Google Chrome ');// For some reason in the browser identification Chrome contains the word "Safari" so when detecting for Safari you need to include Not Chrome
	
	// new_style += '<style> ';
	// new_style += '.container {margin-top: 30px;} ';
	// new_style += 'body{margin-top:-65px;} ';
	// new_style += 'html{padding-top: 0px ! important;} ';
	// new_style += '</style>';
	
	new_style += '<style> ';
	//new_style += '.lshop{margin-left: 1.0em;} ';
	//new_style += '.lwish{margin-left: 1.8em;} ';
	new_style += '</style>';
	
	document.write(new_style);
    
}
else if (navigator.userAgent.search("Firefox") >= 0){
    //alert('"Mozilla Firefox ');
    
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0){//<< Here
    //alert('"Apple Safari ');
    
    new_style += '<style> ';
    
    new_style += '@media (max-width: 767px) {';
	new_style += '.cindicator';
	new_style += '{';
	new_style += 'right:49%;';
	new_style += 'top:95%;';
	new_style += '}';
	new_style += '}';
    
	new_style += '@media (max-width: 480px) {';
	new_style += '.cindicator';
	new_style += '{';
	new_style += 'right:46%;';
	new_style += 'top:91%;';
	new_style += '}';
	new_style += '}';
	
	new_style += '</style>';
	
	document.write(new_style);
}
else if (navigator.userAgent.search("Opera") >= 0){
    //alert('"Opera ');
    
}
else{
    //alert('"Other"');
}
</script>

    <div class="container">
		<div style="height:10px;"></div>            
        <div class="row-fluid hidden-phone" >
            <div class="span12">
                <div class="row-fluid">
                    <div class="span8">
                       
                        
                        <div id="myCarousel" class="carousel slide banners">
							<? if(count($banners)>1){?>
                            <ol class="carousel-indicators cindicator">
								<? 
								$i=0;
								foreach($banners as $banner){?>
                                	<? if($i==0){?>
                                    <li class="active" data-slide-to="0" data-target="#myCarousel"></li>
                                    <? } else {?>
                                    <li class="" data-slide-to="<?=$i?>" data-target="#myCarousel"></li>
                                    <? }?>
                                <? 
								$i++;
								}?>
								
								
							</ol>
                            <? } ?>
							<div class="carousel-inner">
								<? 
								$i=0;
								$j=0;
								foreach($banners as $banner){
								$j++;
								?>
                                	<? if($i==0){?>
                                    <div class="item active">
                                    <? } else {?>
                                    <div class="item">
                                    <? }?>
                                       
                                        <a href="<?=$banner['url']?>"><img src="<?=base_url()?>uploads/banners/<?=$banner['name']?>" alt="" /></a>
                                        <!-- <img src="http://placehold.it/1200x600" alt="" /> -->
                                       
									</div>
                                <? 
								$i++;
								}?>
                                
							</div>
                            <? if(count($banners)>1){?>
							<a class="left carousel-control" data-slide="prev" href="#myCarousel" style="background: none; border: none; opacity: 1">
								<img src="<?=base_url()?>img/white-left-arrow.png"/>
							</a>
							<a class="right carousel-control" data-slide="next" href="#myCarousel" style="background: none; border: none; opacity: 1">
								<img src="<?=base_url()?>img/white-right-arrow.png"/>
							</a>
                            <? } ?>
						</div>
                        
                    </div>
                   	<!--offer1_desktop -->
                    <? if($homepage['promotions']==1)
					{
						$i=1;
					foreach($promotions as $promo)
					{
                    	$pr_image = $this->System_model->check_image_promotions($promo['id'],'tile');
						if($i<=3){
					?>	
                    <div class="span4" style="float:right;" ><a href="<?=$promo['url']?>" target="_blank"> <img style="float:right; <? if($i>1){echo 'margin-top:10px';}?>" src="<?=base_url()?>uploads/promotions/tiles/<?=md5('tile'.$promo['id'])?>/<?=$pr_image['name']?>" alt="" /> </a></div>
                   
					<? }
						$i++;
					}
					}
					?>
                    
                    
                    
                </div>
            </div>
        </div>
        
        
		<div class="row visible-phone">
			<div class="span12">
				<div id="myCarousel2" class="carousel slide ">
                    <? if(count($banners)>1){?>
                    <ol class="carousel-indicators cindicator">
                        <? 
                        $i=0;
                        foreach($banners as $banner){?>
                            <? if($i==0){?>
                            <li class="active" data-slide-to="0" data-target="#myCarousel2"></li>
                            <? } else {?>
                            <li class="" data-slide-to="<?=$i?>" data-target="#myCarousel2"></li>
                            <? }?>
                        <? 
                        $i++;
                        }?>
                        
                        
                    </ol>
                    <? } ?>
                    <div class="carousel-inner">
                        <? 
                        $i=0;
                        foreach($banners as $banner){?>
                            <? if($i==0){?>
                            <div class="item active">
                            <? } else {?>
                            <div class="item">
                            <? }?>
                                <a href="<?=$banner['url']?>"><img class="visible-phone" src="<?=base_url()?>uploads/banners/<?=$banner['name']?>" alt="" /></a>
                                <a href="<?=$banner['url']?>"><img class="hidden-phone" src="<?=base_url()?>uploads/banners/<?=$banner['name']?>" alt="" /></a>
                                
                            </div>
                        <? 
                        $i++;
                        }?>                               
                    </div>
                   
                    <? if(count($banners)>1){?>
                    <a class="left carousel-control" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1">
								<img class="visible-phone" src="<?=base_url()?>img/swhite-left-arrow.png"/>
								<img class="hidden-phone" src="<?=base_url()?>img/white-left-arrow.png"/>
                    </a>
                    <a class="right carousel-control" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1">
                        <img style="margin-left: 25px" class="visible-phone" src="<?=base_url()?>img/swhite-right-arrow.png"/>
                        <img class="hidden-phone" src="<?=base_url()?>img/white-right-arrow.png"/>
                    </a>
                    <? }?>
				</div>
                        
               
			</div>
		</div>
        
		
        <? if($homepage['promotions']==1){?>
		<!--
        <div style="height: 10px;" class="hidden-desktop hidden-phone"></div>
        
		<div class="row hidden-phone visible-tablet">
			
            <? 
			$i=1;
			foreach($promotions as $promo)
			{
				$pr_image = $this->System_model->check_image_promotions($promo['id'],'tile');
				if($i<=3){
			?>	
			<div class="span4" style="float:right;" ><a href="<?=base_url()?>store/promotion/<?=$promo['id']?>"> <img src="<?=base_url()?>uploads/promotions/tiles/<?=md5('tile'.$promo['id'])?>/<?=$pr_image['name']?>" alt="" /> </a></div>
			
			<? }
				$i++;
			}?>
		</div>
		-->
		<div class="row visible-phone hidden-tablet">
			
            <? 
			$i=1;
			foreach($promotions as $promo)
			{
				$pr_image = $this->System_model->check_image_promotions($promo['id'],'tile');
				if($i<=3){
			?>	
			<div class="span4" style="margin-top: 10px;"><a href="<?=$promo['url']?>"> <img src="<?=base_url()?>uploads/promotions/tiles/<?=md5('tile'.$promo['id'])?>/<?=$pr_image['name']?>" alt="" /> </a></div>
			
			<? }
				$i++;
			}?>
		</div>
		
		<? }?>
        <? if($homepage['stories']==1){?>
        
        <div style="height: 10px;"></div>
		
		
        <div class="row">
			<?
        	$i=1;
			foreach($stories as $story)
			{
                $pr_image = $this->System_model->check_image($story['id'],'tile'); ?>				
                
                <div class="span4 hidden-phone">
                    <a href="<?=base_url()?>store/stories_new/single_all/<?=$story['id']?>">
                    	<? if($pr_image){?>
                            <img alt="" src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>" <? if($i==3){echo 'style="float:right;"';}?>  />
                        <? }else{ ?>
                            <img src="http://placehold.it/710x449/000000/000000" alt="" <? if($i==3){echo 'style="float:right;"';}?> />
                        <? } ?>
                    	<!--<img <? if($i==3){echo 'style="float:right;"';}?> src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>" alt="" />-->
                    </a>
                </div>	
                
                <div style="margin-top: 10px" class="span4 visible-phone">
                    <a href="<?=base_url()?>store/stories_new/single_all/<?=$story['id']?>">
                    	<? if($pr_image){?>
                            <img alt="" src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>" <? if($i==3){echo 'style="float:right;"';}?>  />
                        <? }else{ ?>
                            <img src="http://placehold.it/710x449/000000/000000" alt="" <? if($i==3){echo 'style="float:right;"';}?>  />
                        <? } ?>
                        <!--<img <? if($i==3){echo 'style="float:right;"';}?> src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>" alt="" />-->
                    </a>
                </div>		
            <? $i++;
			}?>
            
		</div>
        <? } ?>

	    <?php 
			# if tiles is active display tiles
			if($homepage['tiles']){
				$this->load->view('common/home/tiles');
     		} 
		?>

        <div class="visible-phone" ><img src="<?=base_url()?>img/latest.png"></div>
        <div style="height: 30px;"></div>
        <div class="hidden-phone"><img src="<?=base_url()?>img/latest.png"></div>
        <div style="height: 10px;"></div>
		<div class="row">
        <div class="carousel slide span12 hidden-phone" id="myCarousel3">
            <div class="carousel-inner">
              <div class="item active">
                    <ul class="thumbnails">
                    	                    	
                    	<?php
                    	
                    	foreach($first6 as $item)
						{
							//echo $item;
							$prod = $this->Product_model->identify($item['id']);
							$hero = $this->Product_model->get_hero($item['id']);
							$title = explode('-',$prod['title']);
							?>
								<li class="span2">
		                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
		                            	<?php
							    		if($prod['sale_price'] < $prod['price'])
										{
										?>
										<img style="position: absolute; z-index: 1000000;" src="<?=base_url()?>img/ssale-sign.png" />
										<?php
										}
							    		?>
		                                <?php
		                                	if($hero)
		                                	{
		                                	?>
		                                		<a href="<?=base_url()?>store/detail_product/quick_link/<?=$prod['id_title']?>"><img class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/thumb5/<?=$hero['name']?>"/></a>
		                                	<?
		                                	}
											else
											{
											?>
												<a href="<?=base_url()?>store/detail_product/quick_link/<?=$prod['id_title']?>"><img src="http://placehold.it/223x262" alt=""></a>											
											<?
											}
											
											$cur_user = $this->session->userdata('userloggedin');
											if($cur_user['level'] == 1)
											{
												if($prod['sale_price'] < $prod['price'])
												{
													$cur_price = $prod['sale_price'];
												}
												else 
												{
													$cur_price = $prod['price'];
												}
											}
											elseif($cur_user['level'] == 2)
											{
												if($prod['sale_price_trade'] < $prod['price_trade'])
												{
													$cur_price = $prod['sale_price_trade'];
												}
												else 
												{
													$cur_price = $prod['price_trade'];
												}
											}
											else
											{
												if($prod['sale_price'] < $prod['price'])
												{
													$cur_price = $prod['sale_price'];
												}
												else 
												{
													$cur_price = $prod['price'];
												}
											}
		                                ?>
		                                
		                                <div style="height:10px;"></div>     		                                
		                               <div class="primaryFont feauture-title"><?=trim($title[0])?> <?=trim($title[1])?></div>
		                                <div class="primaryFont feauture-desc"><?=$prod['short_desc']?></div>
		                                <div class="primaryFont feauture-price">
										<?
                                        if($prod['sale_price'] < $prod['price'])
                                        {
                                        ?>
                                            <span class="color_active" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($prod['price'] * $cur_val,2,'.',',');?></span>
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
										</div>
		                            </div>
		                        </li>
							<?php
						}
                    	
                    	?>
                    	                        
                    </ul>
              </div>
              <? if(count($second6)>0){?>
              <div class="item">
                    <ul class="thumbnails">
                    	<?php
                    	
                    	foreach($second6 as $item)
						{
							//echo $item;
							$prod = $this->Product_model->identify($item['id']);
							$hero = $this->Product_model->get_hero($item['id']);
							$title = explode('-',$prod['title']);
							?>
								<li class="span2">
		                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
		                            	<?php
							    		if($prod['sale_price'] < $prod['price'])
										{
										?>
										<img style="position: absolute; z-index: 1000000;" src="<?=base_url()?>img/ssale-sign.png" />
										<?php
										}
							    		?>
		                                <?php
		                                	if($hero)
		                                	{
		                                	?>
		                                		<a href="<?=base_url()?>store/detail_product/quick_link/<?=$prod['id_title']?>"><img class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/thumb5/<?=$hero['name']?>"/></a>
		                                	<?
		                                	}
											else
											{
											?>
												<a href="<?=base_url()?>store/detail_product/quick_link/<?=$prod['id_title']?>"><img src="http://placehold.it/223x262" alt=""></a>											
											<?
											}
											$cur_user = $this->session->userdata('userloggedin');
											if($cur_user['level'] == 1)
											{
												if($prod['sale_price'] < $prod['price'])
												{
													$cur_price = $prod['sale_price'];
												}
												else 
												{
													$cur_price = $prod['price'];
												}
											}
											elseif($cur_user['level'] == 2)
											{
												if($prod['sale_price_trade'] < $prod['price_trade'])
												{
													$cur_price = $prod['sale_price_trade'];
												}
												else 
												{
													$cur_price = $prod['price_trade'];
												}
											}
											else
											{
												if($prod['sale_price'] < $prod['price'])
												{
													$cur_price = $prod['sale_price'];
												}
												else 
												{
													$cur_price = $prod['price'];
												}
											}
		                                ?>
		                                
		                                <div style="height:10px;"></div>     
		                                <div class="primaryFont feauture-title"><?=trim($title[0])?> <?=trim($title[1])?></div>
		                                <div class="primaryFont feauture-desc"><?=$prod['short_desc']?></div>
		                                <div class="primaryFont feauture-price">
										<?
                                        if($prod['sale_price'] < $prod['price'])
                                        {
                                        ?>
                                            <span class="color_active" style="text-decoration:line-through "><?=$sign?> <?php echo number_format($prod['price'] * $cur_val,2,'.',',');?></span>
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
                                        </div>
										
		                            </div>
		                        </li>
							<?php
						}
                    	
                    	?>
                        
                       </ul>
              </div>
              <? } ?> 
            </div>
           <? if(count($second6)>0){?>
            <a data-slide="prev" href="#myCarousel3" class="left carousel-control" style="background: none; border: none; opacity: 1">
            	<img style="margin-left: -100px" src="<?=base_url()?>img/white-left-arrow.png"/>
            </a>
            <a data-slide="next" href="#myCarousel3" class="right carousel-control" style="background: none; border: none; opacity: 1">
            	<img style="margin-right: -100px" src="<?=base_url()?>img/white-right-arrow.png"/>
            </a>
            <? } ?>
        </div>
    </div>
        
   