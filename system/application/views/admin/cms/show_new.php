<link class="jsbin" href="<?=base_url()?>css/jquery-ui-1-7-2.css" rel="stylesheet" type="text/css"></link>

<script src="<?=base_url()?>js/jquery.min-1-8-0.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/jquery-ui-1-8-23.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="<?=base_url()?>js/jquery.fancybox-1.3.4.pack.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/jquery.fancybox-1.3.4.css' />

<script>

var j = jQuery.noConflict();



j(function() {
  j('.img_display').lightBox();

});
jQuery(document).ready(function() {

	jQuery(".video").click(function() {
		jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: 640,
			'height'		: 385,
			'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			'type'			: 'swf',
			'swf'			: {
			'wmode'				: 'transparent',
			'allowfullscreen'	: 'true'
			}
		});

		return false;
	});
});


</script>
<style>

@media (min-width: 1200px) 
{
	.left-page-image{float:right;width:237px;}
	.left-page-image-gap{height:50px;}
}
@media (max-width: 1200px) 
{
	.left-page-image{float:right;	width:195px;}
	.left-page-image-gap{height:35px;}
}
@media (max-width: 980px) 
{
	.left-page-image{float:right;width:147px;}
	.left-page-image-gap{height:20px;}
}
	
</style>

<div class="app-container" id="page-additional">
	<div style="height:20px;"></div>   
    <div class="col-sm-12">
	<div class="col-sm-8">		
		<?=$pages['content']?>
        <div style="clear:both"></div>
        <div style="clear:both"></div>
<div class="">
	<div class="col-sm-8">	
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
		<div style="margin-top: 20px;" class=" fluid ">
			<div class="col-sm-2">
				<?php
				if($photo['video'] == 0)
				{
				?>					
					<div class="gallery slideshow">
					<a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>" class="img_display" title="<?=$photo['title'];?>">
						<img class="visible-phone" style="width:100%;margin-bottom:10px;" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails/<?php print $photo['name'];?>"  alt="" />
                        <img class="hidden-xs" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails/<?php print $photo['name'];?>"  alt="" />
					</a>
					</div>
				<?
				}
				else
				{
					$src=  $photo['name'];
					$pos= strpos($src,'embed/');
					$new_src = substr($src,$pos+6,strlen($src)-($pos+6));
					
					
				?>
					
					
					<div class="gallery">
						<a class="video" href="//www.youtube.com/v/<?=$new_src?>?fs=1&amp;autoplay=1" title=""><img style="width:140px!important; height:100px!important;" src="http://img.youtube.com/vi/<?=$new_src?>/0.jpg"></a>
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
					<div class="gallery slideshow">
					<a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>" class="img_display" title="<?=$photo['title'];?>">
						<img class="visible-phone" style="width:100%;margin-bottom:10px;" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails/<?php print $photo['name'];?>"  alt="" />
                        <img class="hidden-xs" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails/<?php print $photo['name'];?>"  alt="" />
					</a>
					</div>
				<?
				}
				else
				{
					$src=  $photo['name'];
					$pos= strpos($src,'embed/');
					$new_src = substr($src,$pos+6,strlen($src)-($pos+6));										
				?>					
					<div class="gallery">
						<a class="video" href="//www.youtube.com/v/<?=$new_src?>?fs=1&amp;autoplay=1" title=""><img style="width:140px!important; height:100px!important;" src="http://img.youtube.com/vi/<?=$new_src?>/0.jpg"></a>
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
					<div class="gallery slideshow">
					<a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/<?php print $photo['name'];?>" class="img_display" title="<?=$photo['title'];?>">
						<img class="visible-phone" style="width:100%;margin-bottom:10px;" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails/<?php print $photo['name'];?>"  alt="" />
                        <img class="hidden-xs" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$pages['gallery']); ?>/thumbnails/<?php print $photo['name'];?>"  alt="" />
                        
					</a>
					</div>
				<?
				}
				else
				{
					$src=  $photo['name'];
					$pos= strpos($src,'embed/');
					$new_src = substr($src,$pos+6,strlen($src)-($pos+6));					
					
				?>

					<div class="gallery">
						<a class="video" href="//www.youtube.com/v/<?=$new_src?>?fs=1&amp;autoplay=1" title=""><img style="width:140px!important; height:100px!important;" src="http://img.youtube.com/vi/<?=$new_src?>/0.jpg"></a>
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
    
    <? if($pages['category_id']!=7){ ?>
    <div class="col-sm-3 hidden-xs" style="float:right;" >
    	<div class="">
        	<div class="col-sm-3"><div style="height:20px;"></div></div>
        </div>
        <div class="">
        	<div class="col-sm-3">
        		<a href="<?=base_url()?>page/The-Bared-Difference"><img class="left-page-image" src="<?=base_url()?>img/The-Bared-Difference-Orange.jpg" alt="Bared Difference"></a>        		
        	</div>
        </div>
        <div class="">
        	<div class="col-sm-3"><div class="left-page-image-gap"></div></div>
        </div>
        <div class="">
        	<div class="col-sm-3">
        		<a href="<?=base_url()?>page/Our-Famous-Footbed"><img class="left-page-image" src="<?=base_url()?>img/Famous-Footbed-Icon-ornage.jpg" alt="Famous Footbed"></a>
        	</div>        	
        </div>
        <div class="">
        	<div class="col-sm-3"><div class="left-page-image-gap"></div></div>
        </div>
        <div class="">
        	<div class="col-sm-3">
        		<a href="<?=base_url()?>page/The-Bared-Fitting-Difference"><img class="left-page-image" src="<?=base_url()?>img/Fitting-Icon-Orange.jpg" alt="Fitting System"></a>
        	</div>
        </div>
    </div>
    <? }?>
    </div>   
