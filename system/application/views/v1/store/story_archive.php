<script>
jQuery(function() {
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
				var ids = parseInt(idps);
				jQuery('#act').html(ids);
			}
		});
		
	<? } ?>
	$('[id^="myCarousel"]').carousel('pause');
});
function share_with_friend()
{
		
	$('#emailModal').modal('show');
}
function check_html()
{

	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).attr("id");
			var n=id.split("#");
			idp=n[0].replace('id','');
			var ids = parseInt(idp)-1;
			if(ids==0){ids=<?=count($pages_story)+1?>;}
			jQuery('#act').html(ids);
		}
	});



}
function check_html_right()
{

	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).attr("id");
			var n=id.split("#");
			idp=n[0].replace('id','');
			var ids = parseInt(idp);
			ids=ids+1;
			if(ids > 1){ids=1;}
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
.text-bagazine{
	text-align:center;
	font-size:48px;
	font-family: 'Parisienne', cursive;
}
[class^="icon-"], [class*=" icon-"]
{
	vertical-align:bottom!important;
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
.nav1{
	margin-left:36%;
}
#center_pointer { margin:0 auto; margin-left:30%; }
.all_s{margin-left: -10px;}
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
.nav1{
	margin-left:36%;
}
.text-bagazine{
	text-align:center;
	font-size:42px;
	font-family: 'Parisienne', cursive;
}
#center_pointer
{
	margin:0 auto; margin-left:28%;
}
.all_s{margin-left: -10px;}
}
@media (max-width: 979px) {
	.indi{
right:345px; top: 230px;
}
.nav1{
	margin-left:25%;
}
.text-bagazine{
	text-align:center;
	font-size:40px;
	font-family: 'Parisienne', cursive;
}
#center_pointer
{
	margin:0 auto; margin-left:7%;
}
.all_s{margin-left: 10px;}
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
.nav1{
	margin-left:22%;
}
.text-bagazine{
	text-align:center;
	font-size:36px;
	font-family: 'Parisienne', cursive;
}
#center_pointer
{
	margin:0 auto; margin-left:18%;
}
.all_s{margin-left: 0px;}
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
.nav1{
	margin-left:20%;
}
.text-bagazine{
	text-align:center;
	font-size:28px;
	font-family: 'Parisienne', cursive;
}
.all_s{margin-left: 0px;}
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


.breadcrumb > li > .divider2 {
    color: #000000;
    padding: 0 5px;
}



</style>

	<div class="container">
		<div style="height: 10px;"></div>
        <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase">
			    <li><a href="<?=base_url()?>">HOME</a> <span class="divider">></span></li>
                <li><a href="<?=base_url()?>store/stories_new/all">THE BAGAZINE</a> <span class="divider">></span></li>
                <li class="active">ARCHIVE</li>
        </ul>
        <div style="height: 10px;"></div>
        <div class="text-bagazine">The Bagazine</div>			
        <div style="height: 50px;"></div>
		<div class="row">
			<div class="span12" style="background:#fafafa;">
				<div id="myCarousel2" class="carousel slide" style="padding:10px;">
                                        
                    <div class="carousel-inner">
                        <? $i=1;
							$k=1;
							$j=1;
							foreach($stories as $st){  
								
								$data_story[$k][]=$st['id'];
								if($j % 9 == 0){$k++;}
								$j++;
							}
							
							for($m=1; $m<=$k; $m++)
							{				
						?>						
                        
						<div class="item active" id="id<?=$i?>">
						<div class="row">
                            <div class="span12" style="background:#fafafa;">
                               <div class="row-fluid">
                               <div class="span12">
								<div style="height:8px; clear:both"></div>
							   <? 
							   $now=1;
							   foreach($data_story[$m] as $st){  
							   $str=$this->System_model->identify_archive($st);
							   	if($now == 4){echo '</div>';$now = 1;}
								//$pr_image = $this->System_model->check_image($st['id'],'tile'); 
								$pr_image=$str['image'];
							   	if($now == 1){   ?> 
                                		<div style="height:20px; clear:both"></div>
                                        <div class="row-fluid" >                                                                                                         
                                        
                                        <div class="span4" style="margin-left:0px!important;">
                                            <div style="text-align: center;">                                            	
                                                <a href="<?=base_url()?>store/stories_new/archive/<?=$st?>">
                                                	<? if($pr_image){?>
                                                    	<img src="<?=base_url()?>uploads/archive/<?=md5('arc'.$st)?>/<?=$pr_image?>" alt="" style="width:65%;" />

                                                    <? }else{ ?>
                                                    	<img src="http://placehold.it/710x449/000000/000000" alt="" style="width:65%;" />
                                                    <? } ?>
                                                </a>                                                
                                            	<a href="<?=base_url()?>store/stories_new/single/<?=$st?>"><div style="margin-top:10px;font-family: buenard;    font-size: 14px;    text-align: center;font-weight:600;"><?=$str['name']?></div></a>
                                            </div>
                                        </div>  
                                <? }                                                                                                            
                                
                                if($now == 2){   ?>                                                                                                           
                                        <div class="span4" style="margin-left:0px!important;">
                                            <div style="text-align: center;">
                                            	
                                                <a href="<?=base_url()?>store/stories_new/archive/<?=$st?>">
                                                	<? if($pr_image){?>
                                                    	<img src="<?=base_url()?>uploads/archive/<?=md5('arc'.$st)?>/<?=$pr_image?>" alt="" style="width:65%;" />
                                                    <? }else{ ?>
                                                    	<img src="http://placehold.it/710x449/000000/000000" alt="" style="width:65%;" />
                                                    <? } ?>
                                                </a> 
                                            	<a href="<?=base_url()?>store/stories_new/single/<?=$st?>"><div style="margin-top:10px;font-family: buenard;    font-size: 14px;    text-align: center;font-weight:600;"><?=$str['name']?></div></a>
                                            </div>                                            
                                        </div>  
                                <? }                                                                                                           
                                if($now == 3){   ?>                                                                                                           
                                        <div class="span4" style="float:left;margin-left:0px!important;">
                                            <div style="text-align: center;">
                                            	
                                                <a href="<?=base_url()?>store/stories_new/archive/<?=$st?>">
                                                	<? if($pr_image){?>
                                                    	<img src="<?=base_url()?>uploads/archive/<?=md5('arc'.$st)?>/<?=$pr_image?>" alt="" style="width:65%;" />
                                                    <? }else{ ?>
                                                    	<img src="http://placehold.it/710x449/000000/000000" alt="" style="width:65%;" />
                                                    <? } ?>
                                                </a> 
                                            	<a href="<?=base_url()?>store/stories_new/single/<?=$st?>"><div style="margin-top:10px;font-family: buenard;    font-size: 14px;    text-align: center;font-weight:600;"><?=$str['name']?></div></a>
                                            </div>                                            
                                        </div>  
                                   		
                                <? }                                                                                                             
                                $now++;
                                } 
									if($now % 3 > 0){echo '</div>';}
								?>
                            	</div>
                                <div style="height:8px; clear:both"></div>
                                </div>
                                
                            </div>                         
                        </div>
                        </div>
                        
						<?
						$i++;
							}
                        ?>                               
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
                    <li><a href="<?=base_url()?>store/stories_new/all">INDEX</a> </li>
                </ul>
                <ul class="breadcrumb" style="float:left;margin-left:35%;" id="nav1">
                    <li>
                    	<a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html()">
                    		<i class="icon icon-angle-left icon-2x" style="line-height:10px!important;"></i>
                		</a>
                	</li>
                    <li><div style="font-size: 11px; "><span id="act"></span> / <?=$index?></div></li>
                    <li><a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html_right()">
                    	<i class="icon icon-angle-right icon-2x" style="line-height:10px!important;"></i>
                		</a>  
                    </li>
                 </ul>
                 <ul class="breadcrumb" style="float:right;margin-right:10px;">
                    <li ><a href="#" onclick="share_with_friend();"> <i style="color:#a6a4a5; line-height:15px; " class="icon-envelope-alt icon-2x"></i></a> <span class="divider2" style="vertical-align:top;"> | </span></li>
                    <li><a href="<?=base_url()?>store/story_product_new/archive/0"> <img alt="" src="<?=base_url()?>img/icon_shopping_bag.png"  style="margin-top:-5px; vertical-align:top!important;"></a> </li>
				</ul>             
                -->
                <!--
                <table width="100%" style="font-size: 11px; text-transform: uppercase;font-weight:600; " align="center">
                	<tr>
                    	<td><a style="margin-left:20px" href="<?=base_url()?>store/stories_archive">ARCHIVE</a> <span class="divider2" style="font-size:22px; margin-left:8px; margin-right:3px; font-weight:lighter!important;"> | </span><a href="<?=base_url()?>store/stories_new/all">INDEX</a></td>
                        
                        
                        <td align="center">
                        	<div style="margin:0 auto; margin-left:25%;">
                            <a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html()">
                    			<i class="icon icon-angle-left icon-2x" style="line-height:10px!important;"></i>
                			</a>
                            <div style="float:left;line-height:12px; margin-left:10px; margin-right:10px;"><span id="act"></span> / <?=$index?></div>
                            <a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html_right()">
                            	<i class="icon icon-angle-right icon-2x" style="line-height:10px!important;"></i>
                            </a>
                            </div>
                        </td>
                        
                        <td align="right" valign="middle"><a href="#" onclick="share_with_friend();"> 
                        	
                            <img src="<?=base_url()?>img/envelope.png"  alt="">
                            </a> 
                        	<span class="divider2" style="vertical-align:top; font-size:22px; margin-left:8px; margin-right:3px;font-weight:lighter!important;"> | </span>
                            <a href="<?=base_url()?>store/story_product_new/archive/0"> <img src="<?=base_url()?>img/icon_shopping_bag.png" style="margin-bottom:4px;margin-right:20px;" alt=""></a>
                        </td>
                        
                    </tr>
                </table>
                -->
                <table width="100%" style="font-size: 11px; text-transform: uppercase;font-weight:600; " align="center">
                	<tr>
                		<td style="width: 33.5%; text-align: left" >
                			<a style="margin-left:20px" href="<?=base_url()?>store/stories_archive">ARCHIVE</a> 
                			<span class="divider2" style="font-size:22px; margin-left:8px; margin-right:3px; font-weight:lighter!important;"> | </span>
                			<a href="<?=base_url()?>store/stories_new/all">INDEX</a>
                		</td>
                		<td style="width: 33%; text-align: center; line-height: 11px">
                			<a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;" onclick="check_html()">
                    			<i class="icon icon-angle-left icon-2x" style="line-height:10px!important;"></i>
                			</a>
                            <span id="act"></span> / <?=$index?>
                            <a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;" onclick="check_html_right()">
                            	<i class="icon icon-angle-right icon-2x" style="line-height:10px!important;"></i>
                            </a>
                		</td>
                		<td style="width: 33.5%; text-align: right">
                			<a>
                			<img src="<?=base_url()?>img/envelope.png"  alt="">
                            </a> 
                        	<span class="divider2" style="vertical-align:top; font-size:22px; margin-left:8px; margin-right:3px;font-weight:lighter!important;"> | </span>
                            <a href="<?=base_url()?>store/story_product_new/archive/0"> <img src="<?=base_url()?>img/icon_shopping_bag.png" style="margin-bottom:4px;margin-right:20px;" alt="" ></a>
                		</td>
                	</tr>
                </table>
                </div> 
                <div style="clear:both;height:10px;"></div>                                             
			</div>
		</div>
        <div style="clear:both;height:20px;"></div>                                             
		
<div id="emailModal" class="modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="mytop-modal" onclick="$('#emailModal').modal('hide');">
    <img src="<?=base_url()?>img/close_sign.png" alt=""/>
</div>
<form method="post" action="<?=base_url()?>store/send_friend_email_story">
<input type="hidden" name="story_id" value="-1">
<input type="hidden" id="slide_id" name="slide_id" value="0">
<div class="modal-body mybody-modal-left">
    <table>
        <tr>
            <td style="width: 150px; height: 30px; line-height: 30px; vertical-align: top">Recipient Name</td>
            <td><input type="text" name="friend_name"/></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Recipient Email</td>
            <td><input type="email" name="friend_email" required /></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Your Name</td>
            <td><input type="text" name="name"/></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Your Email</td>
            <td><input type="email" name="email" required /></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Message</td>
            <td><textarea id="message" name="message">Archive - The Bagazine</textarea></td>
        </tr>
        <tr>
			<td>&nbsp;</td>
        	<td>
            <button class="btn btn-primary" aria-hidden="true" type="submit">Send</button>
            </td>
        </tr>
    </table>

</div>
</form>
</div>
        
   