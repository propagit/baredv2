<script>
jQuery(function() {
	$('.item').first().toggleClass("active");
	
	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).attr("id");
			var n=id.split("#");
			idp=n[0].replace('id','');
			var ids = parseInt(idp);
			jQuery('#act').html(ids);
			
		}
	});
	<?
	if($slide > -1)
	{
	?>
		$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			jQuery(this).removeClass('active');
		}
		});
		
		$('.item').each(function () {			
			var id= $(this).attr("id");
			var n=id.split("#");
			idp=n[1];			
			if(idp==<?=$slide?>)
			{
				jQuery(this).toggleClass("active");				
				idps=n[0].replace('id','');
				idstory = n[1];
				var ids = parseInt(idps);
				jQuery('#act').html(ids);								
			}
		});
		
	<? } ?>
	$('[id^="myCarousel"]').carousel('pause');
});
function share_with_friend()
{
	
	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).attr("id");
			var n=id.split("#");
			idp=n[1];

			jQuery('#slide_id').val(idp);
			jQuery('#message').val(jQuery('#title_story'+idp).val());
			
		}
	});
	$('#emailModal').modal('show');
}
function check_html()
{
	var idsp=1;
	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).attr("id");
			var n=id.split("#");
			idp=n[0].replace('id','');
			var ids = parseInt(idp)-1;
			
			if(ids==0){idsp=0;ids=<?=count($pages_story)+$index?>;}
			jQuery('#act').html(ids);
		}
	});
	
	
	
}
function check_html_right()
{

	var idsp=1;
	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).attr("id");
			var n=id.split("#");			
			idp=n[0].replace('id','');
			var ids = parseInt(idp);
			ids=ids+1;
			if(ids > <?=count($pages_story)+$index?>){idsp=0;ids=1;}			
			jQuery('#act').html(ids);			
		}
	});
	

}
</script> 
<style>
.thumbnails > li{
	margin-bottom:0px!important;
}

.thumbnails > ul{
	margin-bottom:0px!important;
}
a {
    color: #222;
    text-decoration: none;
	

}
a:hover, a:focus {
	color: #222;
    text-decoration: none;
	
	
}
@media (min-width: 1200px) {
.indi{
right:590px; top: 375px;
}
.span4 {
    width: 383px;
}
[class*="span"] {

    margin-left: 10px;
}
.row [class*="span"]:first-child {
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
.row [class*="span"]:first-child {
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
.breadcrumb {
    background-color: transparent;
	padding-left:0px;
	font-size:12px;
	margin-bottom:0px!important;
	font-weight:600;
}
.breadcrumb > .active {
    color: #222222;
	font-weight:400;
}
.text-bagazine{
	text-align:center;
	font-size:48px;
	font-family: 'Parisienne', cursive;
}

.breadcrumb > li > .divider2 {
    color: #000000;
    padding: 0 5px;
}
</style>
	<div class="container">
		<div style="height: 50px;"></div>
        
       
        <div class="text-bagazine">Promotions</div>			
       
        <div style="height: 50px;"></div>
		<div class="row">
			<div class="span12" style="background:#cdcdcd;">
				<div id="myCarousel2" class="carousel slide" style="padding:10px;">
                                        
                    <div class="carousel-inner">
                        <? $i=1;

						if(count($pages_story)>0){
                        foreach($pages_story as $story_html){?>
                            
                            <div class="item" id="id<?=$i?>#<?=$story_html['id']?>">
                            	<input type="hidden" id="title_story<?=$story_html['id']?>" value="<?=$story_html['title']?>" />
                                <div class="row">
									<div class="span12" style="background:#cdcdcd;">
										<?=$story_html['content']?>                               
                                    </div>
                                </div>
                            </div>                            
                        <? 
                        $i++; 
                        }
						}?>                               
                    </div>
                    
                    <div style="clear:both"></div>
                    
                    <a class="left carousel-control" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1" onclick="check_html()">
						<img src="<?=base_url()?>img/white-left-arrow.png"/>
					</a>
					<a class="right carousel-control" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1" onclick="check_html_right()">
						<img src="<?=base_url()?>img/white-right-arrow.png"/>
					</a>
				</div>
                
                <div style="height: 20px;"></div>                
                <div style="float:none">
                <!--
                <ul class="breadcrumb" style="margin-left:20px;font-size: 11px; text-transform: uppercase; float:left;"> 
                	<li><a href="<?=base_url()?>store/stories_archive">ARCHIVE</a> <span class="divider2"> | </span></li>
                    <li><a href="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>">INDEX</a> </li>
				</ul>      
                -->
                <a class="left" data-slide="prev" href="#myCarousel2" style="margin-left:50%;background: none; border: none; opacity: 1;float:left;" onclick="check_html()">
                    <i class="icon icon-angle-left icon-2x"></i>
                </a>
                <div class="breadcrumb" style="font-size: 11px; text-transform: uppercase;float:left; margin-left:15px;line-height:normal;"><span id="act"></span> / <?=count($pages_story)+$index?></div>
                <a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html_right()">
                    <i class="icon icon-angle-right icon-2x"></i>
                </a>        
                <!--
                <ul class="breadcrumb" style="margin-right:10px;font-size: 11px; text-transform: uppercase; float:right;"> 
                	<li><a href="#" onclick="share_with_friend();"> <i class="icon-envelope icon-2x"></i></a> <span class="divider2"> | </span></li>
                    <li><a href="<?=base_url()?>store/story_product_new/<?=$cat?>/<?=$id?>"> <i class="icon-envelope icon-2x"></i></a> </li>
				</ul>
                -->
                </div> 
                <div style="clear:both;height:10px;"></div>                                             
			</div>
		</div>
        <div style="clear:both;height:20px;"></div>                                             
		

        
   