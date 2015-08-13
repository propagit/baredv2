<script>
	
  $('[id^="myCarousel"]').carousel();
jQuery(function() {
	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			jQuery(this).removeClass('active');
		}
	});
	jQuery('#id'+<?=$id_active?>).toggleClass("active");
});

</script> 
<style>
.thumbnails > li{
	margin-bottom:0px!important;
}

.thumbnails > ul{
	margin-bottom:0px!important;
}
@media (min-width: 1200px) {

.span4 {
    width: 383px;
}
[class*="span"] {

    margin-left: 10px;
}
. [class*="span"]:first-child {
    margin-left: 30px;
}
}

@media (min-width: 979px) and (max-width:1200px){
.hidden-div{
	width:0px!important;
}
.span4 {
    width: 306px;
}
[class*="span"] {

    margin-left: 10px;
}
. [class*="span"]:first-child {
    margin-left: 20px;
}
}
@media (max-width: 767px) {
.span4{
	margin-top:10px;
}
}
@media (max-width: 480px) {
.span4{
	margin-top:10px;
}
}	

</style>
	<div class="app-container">
		<div style="height: 10px;"></div>
       
		<div class="">
			<div class="col-sm-12">
				<div id="myCarousel2" class="carousel slide">
                    <ol class="carousel-indicators" style="right:590px; top: 455px">
                        <? 
                        $i=0;
                        foreach($promotions as $promo){?>
                            <? if($i==0){?>
                            <li class="active" data-slide-to="0" data-target="#myCarousel"></li>
                            <? } else {?>
                            <li class="" data-slide-to="<?=$i?>" data-target="#myCarousel"></li>
                            <? }?>
                        <? 
                        $i++;
                        }?>
                        
                        
                    </ol>
                    <div class="carousel-inner">
                        <? 
                        $i=0;
						
                        foreach($promotions as $promo){?>
                            <? if($i==0){?>
                            <div class="item active" id="id<?=$promo['id']?>">
                            <? } else {?>
                            <div class="item" id="id<?=$promo['id']?>">
                            <? }
                                $pr_image = $this->System_model->check_image_promotions($promo['id'],'hero'); 
								if($promo['url']!='0' && $promo['url']!=''){									
								?>											
                                	<a href="<?=$promo['url']?>" target="_blank"> <? } ?>							
                                			<? if($pr_image){?>
                                            <img src="<?=base_url()?>uploads/promotions/hero/<?=md5('hero'.$promo['id'])?>/<?=$pr_image['name']?>" alt="" />                                                        
                                            <? } else {?>
                                            <img src="http://placehold.it/1200x600" alt="" />                                                        
                                            <? }?>
								<? if($promo['url']!='0' && $promo['url']!=''){									
								?>											
                                	</a> <? } ?>							
                                <div class="carousel-caption">
                                    <h1 style="color:#fff;!important;"><?=$promo['title']?></h1>
                                    <p><?=$promo['description']?> </p>
                                </div>                                
                            </div>
                        <? 
                        $i++; 
                        }?>  
                        
                        <div class="item" id="id10">
                        	<div class="" style="height:400px; background-image:url(http://odessa.net.au/cart_v1/uploads/images/honey_im_subtle.png);">
<div class="span4">
<div style="text-align: center; margin: 10px 0 10px 0; padding: 10px 0 10px 0;"><img alt="" src="http://odessa.net.au/cart_v1/uploads/images/bag2(1).png" style="height:auto; width:270px" /></div>
</div>

<div class="span4">
<div style="text-align: center; font-family: parisienne; font-size:22px;">
<p>&nbsp;</p>

<p>&nbsp;</p>

<p>Unique &bull; Glamour &bull; Luxury</p>
</div>
</div>

<div class="span4">
<div style="text-align: left; font-family: buenard; font-size:16px; margin:5%x; padding:5%;">
<p><a href="#" style="line-height: 1.6em; color: rgb(236, 0, 140);">Cassidy</a> is a medium size trapeze shaped shopper tote, spacious enough to store magazines, documents and other essentials. This versatile design is made to meet the demands of a busy schedule and is crafted from chevron pattern in chocolate bn and hot pink fabric.</p>

<p>She featuring faux-leather flap with zigzag trim and an enamel coated button masking a magnetic closure and long shoulder handles for ease of wear. She also features a hidden zipper at the top of the bag to safeguard belongings.<br />
<a href="#"><img alt="" src="http://odessa.net.au/cart_v1/uploads/images/button.png" style="border-style:solid; border-width:0px; height:33px; padding:15px 5px 0 0; width:130px" /></a></p>
</div>
</div>
</div>

                        <!--
                        <div class="carousel-caption">
                                    <h1 style="color:#fff;!important;"></h1>
                                    <p></p>
                        </div>        
                        -->
                        </div>
                        
                                                     
                    </div>
                    <div style="clear:both"></div>
                    <!-- <a class="left carousel-control" data-slide="prev" href="#myCarousel2">‹</a>
                    <a class="right carousel-control" data-slide="next" href="#myCarousel2">›</a> -->
                    <a class="left carousel-control" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1">
								<img src="<?=base_url()?>img/white-left-ar.png"/>
							</a>
							<a class="right carousel-control" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1">
								<img src="<?=base_url()?>img/white-right-ar.png"/>
							</a>
				</div>
                        
                
                
                <!--<img class="hidden-xs" src="<?=base_url()?>img/big1.jpg" alt="" />-->
				
				
				
				<!--<img class="visible-xs" src="<?=base_url()?>img/big2.jpg" alt="" />-->
			</div>
		</div>
		

        
   