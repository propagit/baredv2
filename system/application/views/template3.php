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
	right:580px; top: 860px;
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
	right:460px; top: 680px;
}

}
@media (max-width: 979px) {
	.cindicator
	{
		right:370px; top: 530px;
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
        <div class="row-fluid hidden-tablet hidden-phone" >
            <div class="span12">
                <div class="row-fluid">
                    <div class="span12">
                       
                        
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
                                       
                                        <a href="<?=$banner['url']?>"><img src="<?=RETAIL_SITE?>uploads/banners/<?=$banner['name']?>" alt="" /></a>
                                        
                                       
									</div>
                                <? 
								$i++;
								}?>
                                
							</div>
                            <? if(count($banners)>1){?>
							<a class="left carousel-control" data-slide="prev" href="#myCarousel" style="background: none; border: none; opacity: 1">
								<img src="<?=RETAIL_SITE?>img/white-left-arrow.png"/>
							</a>
							<a class="right carousel-control" data-slide="next" href="#myCarousel" style="background: none; border: none; opacity: 1">
								<img src="<?=RETAIL_SITE?>img/white-right-arrow.png"/>
							</a>
                            <? } ?>
						</div>
                        
                    </div>
                   	
                    
                    
                    
                    
                </div>
            </div>
        </div>
        
        
		<div class="row hidden-desktop">
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
                                <a href="<?=$banner['url']?>"><img class="visible-phone" src="<?=RETAIL_SITE?>uploads/banners/<?=$banner['name']?>" alt="" /></a>
                                <a href="<?=$banner['url']?>"><img class="hidden-phone" src="<?=RETAIL_SITE?>uploads/banners/<?=$banner['name']?>" alt="" /></a>
                                
                            </div>
                        <? 
                        $i++;
                        }?>                               
                    </div>
                   
                    <? if(count($banners)>1){?>
                    <a class="left carousel-control" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1">
                        <img class="visible-phone" src="<?=RETAIL_SITE?>img/white-left-arrow.png"/>
                        <img class="hidden-phone" src="<?=RETAIL_SITE?>img/white-left-arrow.png"/>
                    </a>
                    <a class="right carousel-control" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1">
                        <img style="margin-left: 25px" class="visible-phone" src="<?=RETAIL_SITE?>img/white-right-arrow.png"/>
                        <img class="hidden-phone" src="<?=RETAIL_SITE?>img/white-right-arrow.png"/>
                    </a>
                    <? } ?>
				</div>
                        
               
			</div>
		</div>
        
		
        <? if($homepage['promotions']==1){?>
		
		<div style="height: 10px;" ></div>
		<div class="row">
        	<?
        	$i=1;
			foreach($promotions as $promo)
			{
                $pr_image = $this->System_model->check_image_promotions($promo['id'],'tile'); ?>				
                
                <div class="span4">
                    <a href="<?=$promo['id']?>" target="_blank"><img src="<?=RETAIL_SITE?>uploads/promotions/tiles/<?=md5('tile'.$promo['id'])?>/<?=$pr_image['name']?>" alt="" /></a>
                </div>		
                <div class="visible-phone" style="height: 5px;" ></div>
            <? 
			}?>
		</div>
        <? } ?>
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
                    	<img <? if($i==3){echo 'style="float:right;"';}?> src="<?=RETAIL_SITE?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>" alt="" />
                    </a>
                </div>	
                
                <div style="margin-top: 10px" class="span4 visible-phone">
                    <a href="<?=base_url()?>store/stories_new/single_all/<?=$story['id']?>">
                    	<img <? if($i==3){echo 'style="float:right;"';}?> src="<?=RETAIL_SITE?>uploads/stories/tiles/<?=md5('tile'.$story['id'])?>/<?=$pr_image['name']?>" alt="" />
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

		 
        <div style="height: 30px;" class="visible-phone"></div>
   