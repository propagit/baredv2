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
.indi{
right:590px; top: 455px;
}
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
.indi{
right:444px; top: 360px;
}
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
.big-font{
	font-size:20px;
	line-height : 20px;
}
}
@media (max-width: 979px) {
	.indi{
right:345px; top: 230px;
}
}
@media (max-width: 767px) {
.indi{
right:46%; top: 70%;
}	
.span4{
	margin-top:10px;
}
.big-font{
	font-size:14px;
	line-height : 10px;
}
}
@media (max-width: 480px) {
.indi{
right:63%; top: 42%;
}	
.span4{
	margin-top:10px;
}
.big-font{
	font-size:14px;
	line-height : 15px;
}
}	

</style>
	<div class="app-container">
		<div style="height: 10px;"></div>
       
		<div class="">
			<div class="col-sm-12">
				<div id="myCarousel2" class="carousel slide">
                    <ol class="carousel-indicators indi" >
                        <? 
                        $i=0;
                        foreach($stories as $story){?>
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
						
                        foreach($stories as $story){?>
                            <? if($i==0){?>
                            <div class="item active" id="id<?=$story['id']?>">
                            <? } else {?>
                            <div class="item" id="id<?=$story['id']?>">
                            <? }
                                $pr_image = $this->System_model->check_image($story['id'],'hero'); ?>
											
                                	<a href="<?=base_url()?>cart/story_product/<?=$story['id']?>"> 					
                                		<!--<img src="<?=base_url()?>uploads/stories/hero/<?=md5('hero'.$story['id'])?>/<?=$pr_image['name']?>" alt="" />  -->
                                        <? if($pr_image){?>
                                            <img src="http://placehold.it/1200x600/000000/000000" alt="" />
                                            <!--<img alt="" src="<?=base_url()?>uploads/stories/hero/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>"  />-->
                                        <? }else{ ?>
                                            <img src="http://placehold.it/1200x600/000000/000000" alt="" />
                                        <? } ?>                                                     																							
                                	</a>
                                <div class="carousel-caption">
                                    <h1 style="color:#fff;!important;" class="big-font"><?=$story['title']?></h1>
                                    <p><?=$story['description']?> </p>
                                </div>                                
                            </div>
                        <? 
                        $i++; 
                        }?>                               
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
				
				
				
				<!--<img class="visible-phone" src="<?=base_url()?>img/big2.jpg" alt="" />-->
			</div>
		</div>
		

        
   