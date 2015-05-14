<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="<?=base_url()?>js/jquery.prettyPhoto.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/prettyPhoto.css' />
<script>



$(function() {
  //$('.img_display').lightBox();
  //$(".vidbox").jqvideobox({'width' : 400, 'height': 300, 'getimage': false, 'navigation': false});
 
    
});



</script>
<style>

@media (min-width: 1200px) 
{
	.left-page-image
	{
		float:right;
		width:237px;
		
	}
	.left-page-image-gap
	{
		height:50px;
	}
}
@media (max-width: 1200px) 
{
	.left-page-image
	{
		float:right;
		width:195px;
		
	}
	.left-page-image-gap
	{
		height:35px;
	}
}
@media (max-width: 980px) 
{
	.left-page-image
	{
		float:right;
		width:147px;
		
	}
	.left-page-image-gap
	{
		height:20px;
	}
}
	
</style>

<div class="app-container" id="page-additional" style="padding-bottom:50px;">
	<div style="height:20px;"></div>   
    <div class="col-sm-12">
	<div class="col-sm-12 body-content">	
		
		<?=$pages['content']?>	
		<!-- <h1 style="font-family: lato; font-size: 36px; font-weight: 700;">CONTACT US</h1> -->
		<p style="font-family: lato;">
			<!-- Bared Pty Ltd<br/>
			<br/>
			Bared Pty Ltd Tft Bared Trading Trust Owns and Operates The Website<br/>
			<br/>
			<table>
				<tr>
					<td style="width: 100px; font-weight: 700; vertical-align: top">Address</td>
					<td style="vertical-align: top">1098 High Street<br/>Armadale VIC 3143 Australia</td>
				</tr>
				<tr>
					<td style="width: 100px; font-weight: 700; vertical-align: top">ABN</td>
					<td style="vertical-align: top">76 843 320 186</td>
				</tr>
				<tr>
					<td style="width: 100px; font-weight: 700; vertical-align: top">Phone</td>
					<td style="vertical-align: top">+61 03 9509 5771</td>
				</tr>
				<tr>
					<td style="width: 100px; font-weight: 700; vertical-align: top">Email</td>
					<td style="vertical-align: top"><a href="mailto:info@bared.com.au">info@bared.com.au</a></td>
				</tr>
				<tr>
					<td style="width: 100px; font-weight: 700; vertical-align: top">Website</td>
					<td style="vertical-align: top"><a href="<?=base_url()?>">www.bared.com.au</a></td>
				</tr>
			</table> -->
			<!-- <br/>
			<br/>
			Alternatively, complete the form below<br/>
			<br/>
			<span style="font-style: italic; font-size: 11px"><span style="color: red">*</span>All form fields are mandatory</span> -->
			<script>
			<?php
		    if($this->session->flashdata('cu_submit'))
			{
				?>
					jQuery('#any_message_footer').html('Thank you for contacting us, we will back to you soon');
					jQuery('#anyModalFooter').modal('show');
				<?
			}
		    ?>
			function check_contact_us()
			{
				var name = jQuery('#name').val();
				var email = jQuery('#email').val();
				var subject = jQuery('#subject').val();
				var message= jQuery('#message').val();
				var valid = true;
				
				var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				
				if(name==''){valid = false;}
				if(email==''){valid = false;}
				valid = re.test(email);
				if(subject==''){valid = false;}
				if(message==''){valid = false;}
				
				if(!valid)
				{
					jQuery('#any_message_footer').html('Please insert with a valid input for every mandatory fields');
					jQuery('#anyModalFooter').modal('show');
				}
				
				return valid;
			}
			</script>
			<form method="post" action="<?=base_url()?>store/submit_contact_us" onsubmit="return check_contact_us();">
				<table class="col-sm-10 x-gutters">
					<tr>
						<td class="col-sm-3 ucase x-gutters" style="padding-bottom: 10px;">Your name<span style="color: red">*</span></td>
						<td style="padding-bottom: 10px;"><input class="col-sm-6 form-control" style="margin:0px;" type="text" name="name" id="name"/></td>
					</tr>
					<tr>
						<td class="col-sm-3 ucase x-gutters" style="padding-bottom: 10px">Your email<span style="color: red">*</span></td>
						<td style="padding-bottom: 10px;"><input class="col-sm-6 form-control" style="margin:0px;" type="text" name="email" id="email"/></td>
					</tr>
					<tr>
						<td class="col-sm-3 ucase x-gutters" style="padding-bottom: 10px">Your phone</td>
						<td style="padding-bottom: 10px;"><input class="col-sm-6 form-control" style="margin:0px;" type="text" name="phone" id="phone"/></td>
					</tr>
					<tr>
						<td class="col-sm-3 ucase x-gutters" style="padding-bottom: 10px">Subject<span style="color: red">*</span></td>
						<td style="padding-bottom: 10px;"><input class="col-sm-6 form-control" style="margin:0px;" type="text" name="subject" id="subject"/></td>
					</tr>
					<tr>
						<td class="col-sm-3 ucase x-gutters" style="padding-bottom: 10px; vertical-align: top; padding-top: 7px">Message<span style="color: red">*</span></td>
						<td style="padding-bottom: 10px;">
							<textarea class="col-sm-6 form-control" id="message" name="message" s="3">
							</textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><button type="submit" class="button-Font button_primary button_size_full">Send</button></td>
					</tr>
				</table>
			</form>
		</p>
        <div style="clear:both"></div>
        <div style="clear:both"></div>
<div class="">
	<div class="col-sm-12">	
<?php
	$photos = $this->Gallery_model->get_photos($pages['gallery']);
	if(count($photos) > 0)
	{
	$cc=1;
	foreach($photos as $photo)
	{
		if($cc == 5){$cc=1;}
		if($cc == 1)
		{
		?>
		<div style="margin-top: 20px;" class=" ">
			<div class="col-sm-2">
				<?php
				if($photo['video'] == 0)
				{
				?>
					<!-- <a class="img_display" title="<?=$photo['title'];?>" href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>">
						<img src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails2/<?php print $photo['name'];?>" alt=""/>
					</a> -->
					<div class="gallery slideshow">
					<a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>" rel="prettyPhoto[pp_gal]" title="<?=$photo['title'];?>">
						<img class="hidden-xs" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails2/<?php print $photo['name'];?>"  alt="" />
                        <img class="visible-phone"style="margin-bottom:20px;"  src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>"  alt="" />
					</a>
					</div>
				<?
				}
				else
				{
					$src=  $photo['name'];
					$pos= strpos($src,'embed/');
					$new_src = substr($src,$pos+4,strlen($src)-($pos+4));
					//echo $src.'<br/>'.$new_src;
					
				?>
					<!-- <iframe style="width: inherit" src="<?php print $photo['name'];?>" frameborder="0" allowfullscreen></iframe> -->
					
					<div class="gallery">
					<a href="http://www.youtube.com/watch?v=<?=$new_src?>" rel="prettyPhoto" title=""><img src="http://img.youtube.com/vi/<?=$new_src?>/0.jpg"></a>
					</div>
					
				<?
				}
				?>
			</div>
		<?
		}
		elseif($cc == 4)
		{
		?>
			<div class="col-sm-2">
				<?php
				if($photo['video'] == 0)
				{
				?>
					<!-- <a class="img_display" title="<?=$photo['title'];?>" href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>">
						<img src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails2/<?php print $photo['name'];?>" alt=""/>
					</a> -->
					<div class="gallery slideshow">
					<a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>" rel="prettyPhoto[pp_gal]" title="<?=$photo['title'];?>">
						<img class="hidden-xs" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails2/<?php print $photo['name'];?>"  alt="" />
                        <img class="visible-phone"  src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>"  alt="" />
					</a>
					</div>
				<?
				}
				else
				{
					$src=  $photo['name'];
					$pos= strpos($src,'embed/');
					$new_src = substr($src,$pos+4,strlen($src)-($pos+4));
					//echo $src.'<br/>'.$new_src;
					
				?>
					<!-- <iframe style="width: inherit" src="<?php print $photo['name'];?>" frameborder="0" allowfullscreen></iframe> -->
					
					<div class="gallery">
					<a href="http://www.youtube.com/watch?v=<?=$new_src?>" rel="prettyPhoto" title=""><img src="http://img.youtube.com/vi/<?=$new_src?>/0.jpg"></a>
					</div>
					
				<?
				}
				?>
			</div>
		</div>
		<?
		}
		else 
		{
		?>
			<div class="col-sm-2">
				<?php
				if($photo['video'] == 0)
				{
				?>
					<!-- <a class="img_display" title="<?=$photo['title'];?>" href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>">
						<img src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails2/<?php print $photo['name'];?>" alt=""/>
					</a> -->
					<div class="gallery slideshow">
					<a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>" rel="prettyPhoto[pp_gal]" title="<?=$photo['title'];?>">
						<img class="hidden-xs" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails2/<?php print $photo['name'];?>"  alt="" />
                        <img class="visible-phone" style="margin-bottom:20px;" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>"  alt="" />
					</a>
					</div>
				<?
				}
				else
				{
					$src=  $photo['name'];
					$pos= strpos($src,'embed/');
					$new_src = substr($src,$pos+4,strlen($src)-($pos+4));
					//echo $src.'<br/>'.$new_src;
					
				?>
					<!-- <iframe style="width: inherit" src="<?php print $photo['name'];?>" frameborder="0" allowfullscreen></iframe> -->
					<div class="gallery">
					<a href="http://www.youtube.com/watch?v=<?=$new_src?>" rel="prettyPhoto" title=""><img src="http://img.youtube.com/vi/<?=$new_src?>/0.jpg"></a>
					</div>
				<?
				}
				?>
			</div>
		
		<?
		}
		$cc++;
	}
	
	if($cc!=5)
	{
		$cc = 4 - $cc;
		for($i=0;$i<$cc;$i++)
		{
		?>
			<div class="col-sm-2">
				&nbsp;
			</div>
		<?
		}
		?>
		</div>
		<?
	}
	}
?>
</div>
</div>
    </div>
    <div class="col-sm-1" >
    	<div class="">&nbsp;</div>
    </div>
    <div class="col-sm-3 hidden-xs hide" style="float:right;" >

     		<div class="col-xs-12"><div class="left-page-image-gap"></div></div>
        	<div class="col-xs-12">
        		<a href="<?=base_url()?>store/page/34"><img class="left-page-image" src="<?=base_url()?>img/The-Bared-Difference-Orange.jpg" alt="Bared Difference"></a>
        		<!-- <img class="left-page-image visible-desktop show-medium hidden-large" style="width:80%" src="<?=base_url()?>img/logo/bared-difference.png" alt="Bared Difference"> -->
        		<!-- <img class="left-page-image visible-tablet" src="<?=base_url()?>img/The-Bared-Difference-Orange.jpg" alt="Bared Difference"> --> 
        	</div>


        	<div class="col-xs-12"><div class="left-page-image-gap"></div></div>

   
        	<div class="col-xs-12">
        		<a href="<?=base_url()?>store/page/36"><img class="left-page-image" src="<?=base_url()?>img/Famous-Footbed-Icon-ornage.jpg" alt="Famous Footbed"></a>
        	</div>
        	<!-- <div class="col-sm-3"><img class="left-page-image visible-tablet" src="<?=base_url()?>img/Famous-Footbed-Icon-ornage.jpg" alt="Famous Footbed"> </div> -->
            
            <div class="col-xs-12"><div class="left-page-image-gap"></div></div>
 
    
        	<div class="col-xs-12">
        		<a href="<?=base_url()?>store/page/37"><img class="left-page-image" src="<?=base_url()?>img/Fitting-Icon-Orange.jpg" alt="Fitting System"></a>
        	</div>
        </div>
 
        	
        	<!-- <div class="col-sm-3"><img class="left-page-image visible-tablet" src="<?=base_url()?>img/Fitting-Icon-Orange.jpg" alt="Fitting System"> </div> -->
 
    </div>
    </div>   
</div>

<script>
$(function(){$(".gallery:not(.slideshow) a[rel^='prettyPhoto']").prettyPhoto()});
$(".gallery.slideshow a[rel^='prettyPhoto']").prettyPhoto({slideshow:5000, autoplay_slideshow:true});
</script>
