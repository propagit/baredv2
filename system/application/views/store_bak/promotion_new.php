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
	font-size:26px;
	font-family: 'Lato', sans-serif;
}

.breadcrumb > li > .divider2 {
    color: #000000;
    padding: 0 5px;
}
</style>
	<div class="app-container">
		<div style="height: 50px;"></div>
        
       
        <div class="text-bagazine">Promotions</div>			
       
        <div style="height: 50px;"></div>
		<div class="">
			<div class="col-sm-12" style="background:#cdcdcd;">
				<div id="myCarousel2" class="carousel slide" style="padding:10px;">
                                        
                    <div class="carousel-inner">
                        <? $i=1;

						
                        foreach($pages_story as $story_html){?>
                            
                            <div class="item" id="id<?=$i?>#<?=$story_html['id']?>">
                            	<input type="hidden" id="title_story<?=$story_html['id']?>" value="<?=$story_html['title']?>" />
                                <div class="">
									<div class="col-sm-12" style="background:#cdcdcd;">
										<?=$story_html['content']?>                               
                                    </div>
                                </div>
                            </div>                            
                        <? 
                        $i++; 
                        }?>                               
                    </div>
                    
                    <div style="clear:both"></div>
                    
                    <a class="left carousel-control" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1" onclick="check_html()">
						<img src="<?=base_url()?>img/white-left-ar.png"/>
					</a>
					<a class="right carousel-control" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1" onclick="check_html_right()">
						<img src="<?=base_url()?>img/white-right-ar.png"/>
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
                
                <ul class="breadcrumb" style="margin-right:10px;font-size: 11px; text-transform: uppercase; float:right;"> 
                	<!-- <li><a href="#" onclick="share_with_friend();"> <i class="icon-envelope icon-2x"></i></a> <span class="divider2"> | </span></li> -->
                    <li><a href="<?=base_url()?>store/promotion_product_new/<?=$cat?>/<?=$id?>"> <img alt="" src="<?=base_url()?>img/icon_shopping_bag.png"  style="margin-top:-5px; vertical-align:top!important;"></a> </li>
				</ul>
               
                </div> 
                <div style="clear:both;height:10px;"></div>                                             
			</div>
		</div>
        <div style="clear:both;height:20px;"></div>                                             
		
<div id="emailModal" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="mytop-modal" onclick="$('#emailModal').modal('hide');">
    <img src="<?=base_url()?>img/close_sign.png" alt=""/>
</div>
<form method="post" action="<?=base_url()?>store/send_friend_email_story">
<input type="hidden" name="story_id" value="<?=$id?>">
<input type="hidden" name="cat" value="<?=$cat?>">
<input type="hidden" id="slide_id" name="slide_id" value="">
<input type="hidden" id="url" name="url" value="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>">
<div class="modal-body mybody-modal">
    <table>
        <tr>
            <td style="width: 150px; height: 30px; line-height: 30px; vertical-align: top" class="label-font-Font">Name of your friend</td>
            <td><input class="input-font-Font" type="text" name="friend_name"/></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top" class="label-font-Font" >E-mail of your friend</td>
            <td><input class="input-font-Font" type="email" name="friend_email" required /></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top" class="label-font-Font" >Your name</td>
            <td><input class="input-font-Font" type="text" name="name"/></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top" class="label-font-Font" >Your e-mail</td>
            <td><input class="input-font-Font" type="email" name="email" required /></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top" class="label-font-Font" >Your message</td>
            <td><textarea class="input-font-Font" id="message" name="message"><?=$story_single['title']?></textarea></td>
        </tr>
    </table>
    <div>
        <button class="btn btn-primary button-Font" aria-hidden="true" type="submit">Send</button>
    </div>
</div>
</form>
</div>
        
   