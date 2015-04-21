<script src="<?=base_url()?>js/jquery.cycle2.js"></script>
<script src="<?=base_url()?>js/jquery.cycle2.carousel.js"></script>
<script>$.fn.cycle.defaults.autoSelector = '.slideshow';</script>
<?php
	$url_pages=$_SERVER['REQUEST_URI'];
	$ex_pages=explode("/",$url_pages);
	$curr_cat=$ex_pages[4];
?>
<script>
var line1 = 1;
var line2 = 0;
var line3 = 0;

function click_line(id)
{
	
	if(id == 1 && line1 == 0)
	{
		line1 = 1;
		line2 = 0;
		line3 = 0;
	}
	
	if(id == 2 && line2 == 0)
	{
		line1 = 0;
		line2 = 1;
		line3 = 0;
	}
	
	if(id == 3 && line3 == 0)
	{
		line1 = 0;
		line2 = 0;
		line3 = 1;
	}
	
	if(line1 == 1)
	{
		$('#line1-down').show();
		$('#line1-right').hide();
	}
	else
	{
		$('#line1-right').show();
		$('#line1-down').hide();
	}
	
	if(line2 == 1)
	{
		$('#line2-down').show();
		$('#line2-right').hide();
	}
	else
	{
		$('#line2-right').show();
		$('#line2-down').hide();
	}
	
	if(line3 == 1)
	{
		$('#line3-down').show();
		$('#line3-right').hide();
	}
	else
	{
		$('#line3-right').show();
		$('#line3-down').hide();
	}
}

function addtocart() {
	var quantity=1;
	if(quantity == '')
	{
	alert('Please enter a valid number for quantity');
	return false;
	}
	else
	{
	if(isNaN(quantity))
	{
	alert('Please enter a valid number for quantity');
	return false;
	}
	else
	{
	if(quantity <=0 )
	{
	alert('Please enter a valid number for quantity');
	return false;
	}
	}
	}
	var attributes = '';
	
	var myObject = new Object();
	var num = 0;
	
	$.ajax({
	url: '<?=base_url()?>store/addtocart',
	type: 'POST',
	data: ({quantity:quantity,product_id:<?=$product['id']?>}),
	dataType: "html",
	success: function(html) {
	
			jQuery('#any_message').html(html);
			$('#anyModal').modal('show');
			
			
			$.ajax({
			url: '<?=base_url()?>store/count_cart',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
			
					jQuery('.tot_shopbag').text(html);
					$('#anyModal').modal('show');
			
			}
			});
	
	}
	})
} 

function add_towishlist()
{
	var product_id = <?=$product['id']?>;
	var cat_name = '<?=$curr_cat?>';
	//alert(cat_name);
	
	$.ajax({
	url: '<?=base_url()?>store/add_towishlist',
	type: 'POST',
	data: ({cat_name:cat_name,product_id:product_id}),
	dataType: "html",
	success: function(html) {
		
		if(html > 0)
		{
			jQuery('#any_message').html('This item has been successfully saved in your wishlist');
		}
		else
		{
			jQuery('#any_message').html('You must login first before put this product into your wishlist');
		}
		
		
		$('#anyModal').modal('show');
		
		$.ajax({
			url: '<?=base_url()?>store/count_wishlist',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
			
					jQuery('.tot_wishlist').text(html);
					$('#anyModal').modal('show');
			
			}
			});
	}
	})
}
</script>
<style>
div.vertical-big { height: 435px !important}
div.vertical-small { height: 370px !important}
div.vertical-tablet { height: 260px !important}

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
	font-size:14px;
	padding-bottom:0px;
	padding-top:2px;
	line-height: 20px
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


.vertical .carousel-inner {
  height: 100%;
}

.carousel.vertical .item {
  -webkit-transition: 0.6s ease-in-out top;
     -moz-transition: 0.6s ease-in-out top;
      -ms-transition: 0.6s ease-in-out top;
       -o-transition: 0.6s ease-in-out top;
          transition: 0.6s ease-in-out top;
}

.carousel.vertical .active {
  top: 0;
}

.carousel.vertical .next {
  top: 100%;
}

.carousel.vertical .prev {
  top: -100%;
}

.carousel.vertical .next.left,
.carousel.vertical .prev.right {
  top: 0;
}

.carousel.vertical .active.left {
  top: -100%;
}

.carousel.vertical .active.right {
  top: 100%;
}

.carousel.vertical .item {
    left: 0;
}
}

@media (min-width: 980px) and (max-width: 1199px) {
	
	div.show-small
	{
		display:block !important;
	}
	
	div.hide-small
	{
		display:none !important;
	}
	 
	 }
	 
@media (min-width: 1200px) {
	
	div.show-small
	{
		display:none !important;
	}
	
	div.hide-small
	{
		display:block !important;
	}
	 
	 }
	 
	 
	 .social-icon
	 {
	 	float:left; margin-right:24px;
	 }
	 
	 .left-img
	 {
	 	/*cursor:pointer;*/
	 }

</style>





<div class="container">
	<div style="height:10px;"></div>     
    <div class="row-fluid">
    	<div class="span12">
    		<ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase">
			    <li><a href="<?=base_url()?>">HOME</a> <span class="divider">></span></li>
			    <?php
			    	$cat = $this->Category_model->identify($product['main_category']);
					$cat_name = $cat['name'];
					$mid = 0;
					if($cat_name == 'Handbags') {$mid = 2;}
					if($cat_name == 'Wallets') {$mid = 3;}
					if($cat_name == 'Travel') {$mid = 4;}
					if($cat_name == 'Accessories') {$mid = 5;}
					if($cat_name == 'Sale') {$mid = 6;}
					if($cat_name == 'Stylefile') {$mid = 7;}
					if($cat_name == 'News') {$mid = 8;}
					
					if($mid != 0)
					{
						$url = base_url().'store/product/'.$cat_name.'/'.$mid;
					}
					else
					{
						$url = base_url().'store/product/'.$cat_name;
					}
			    ?>
			    <li><a href="<?=$url?>">
			    	<?=strtoupper($cat['title'])?>
			    </a> <span class="divider">></span></li>
			    <li class="active"><?=$product['title']?></li>
		    </ul>
		</div>
    </div>
    <div style="height:10px;"></div>     
    <div class="row-fluid">
    	<div class="span2  hidden-phone">
    		
    		<div style="margin-left: 15%; margin-bottom: 10px">
			    <!-- <a href=# id=prev3><i class="icon-chevron-up icon-2x"></i></a> -->
			    <a href=# id=prev3><img src="<?=base_url()?>img/grey-up-arrow.png" alt=""/></a>
			</div>
			
			
    		
    		<div class="slideshow vertical-big hidden-tablet hide-small" 
			    data-cycle-fx=carousel
			    data-cycle-timeout=0
			    data-cycle-next="#prev3"
			    data-cycle-prev="#next3"
			    data-cycle-pager="#pager3"
			    data-cycle-carousel-visible=3
			    data-cycle-carousel-vertical=true
			    >
			    <?php
			    	if($this->session->userdata('prod_hero_'.$product['id']))
					{
						$now_hero_id = $this->session->userdata('prod_hero_'.$product['id']);
					}
					else 
					{
						$now_hero_id = $hero['id'];
					}
					for($i=0;$i<4;$i++)
					{
						if(isset($photos[$i]))
						{
							$photo = $photos[$i];
							if($photo['id'] != $now_hero_id)
							{
							?>
								<img onclick="change_img(<?=$photo['id']?>)" style="cursor:pointer; margin-bottom: 15px !important;" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb2/<?=$photo['name']?>"/>
							<?
							}
							else
							{
							?>
								<img style="margin-bottom: 15px !important;" src="<?=base_url()?>img/110-blank.png"/>
							<?
							}
						}
						else 
						{
						?>
							<img style="margin-bottom: 15px !important;" src="<?=base_url()?>img/110-blank.png"/>
						<?
						}
					}
			    ?>
			    
			    
			</div>
			
			<div class="slideshow vertical-small hidden-tablet show-small" 
			    data-cycle-fx=carousel
			    data-cycle-timeout=0
			    data-cycle-next="#prev3"
			    data-cycle-prev="#next3"
			    data-cycle-pager="#pager3"
			    data-cycle-carousel-visible=3
			    data-cycle-carousel-vertical=true
			    >
			    <?php
			    	if($this->session->userdata('prod_hero_'.$product['id']))
					{
						$now_hero_id = $this->session->userdata('prod_hero_'.$product['id']);
					}
					else 
					{
						$now_hero_id = $hero['id'];
					}
					for($i=0;$i<4;$i++)
					{
						if(isset($photos[$i]))
						{
							$photo = $photos[$i];
							if($photo['id'] != $now_hero_id)
							{
							?>
								<img onclick="change_img(<?=$photo['id']?>)" style="cursor:pointer; margin-bottom: 18px !important" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb3/<?=$photo['name']?>"/>
							<?
							}
							else
							{
							?>
								<img style="margin-bottom: 18px !important" src="<?=base_url()?>img/89-blank.png"/>
							<?
							}
						}
						else 
						{
						?>
							<img style="margin-bottom: 18px !important" src="<?=base_url()?>img/89-blank.png"/>
						<?
						}
					}
			    ?>
			    
			</div>
			
			<div class="slideshow vertical-tablet visible-tablet" 
			    data-cycle-fx=carousel
			    data-cycle-timeout=0
			    data-cycle-next="#prev3"
			    data-cycle-prev="#next3"
			    data-cycle-pager="#pager3"
			    data-cycle-carousel-visible=3
			    data-cycle-carousel-vertical=true
			    >
			    <?php
			    	if($this->session->userdata('prod_hero_'.$product['id']))
					{
						$now_hero_id = $this->session->userdata('prod_hero_'.$product['id']);
					}
					else 
					{
						$now_hero_id = $hero['id'];
					}
					for($i=0;$i<4;$i++)
					{
						if(isset($photos[$i]))
						{
							$photo = $photos[$i];
							if($photo['id'] != $now_hero_id)
							{
							?>
								<img onclick="change_img(<?=$photo['id']?>)" style="cursor:pointer; margin-bottom: 18px !important" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb4/<?=$photo['name']?>"/>
							<?
							}
							else
							{
							?>
								<img style="margin-bottom: 18px !important" src="<?=base_url()?>img/67-blank.png"/>
							<?
							}
						}
						else 
						{
						?>
							<img style="margin-bottom: 18px !important" src="<?=base_url()?>img/67-blank.png"/>
						<?
						}
					}
			    ?>
			    
			</div>
			
			<div style="margin-left: 15%; margin-top: 10px">
			    <!-- <a href=# id=next3><i class="icon-chevron-down icon-2x"></i></a> -->
			    <a href=# id=next3><img src="<?=base_url()?>img/grey-down-arrow.png" alt=""/></a>
			</div>

    		<!-- <div class="cycle-pager" id=pager3></div> -->
    	
    	</div>
    	<div class="span5">
    		<!-- <img src="<?=base_url()?>img/temp_product.jpg"/> -->
    		<!-- <img  src="http://placehold.it/472x515"/>
    		<img  src="http://placehold.it/710x775"/> -->
    		<?php
    		if($product['sale_price'] < $product['price'])
			{
			?>
			<img style="position: absolute; z-index: 1000000;" src="<?=base_url()?>img/sale-sign.png" />
			<?php
			}
    		?>
    		<?php
    		//echo $product['id'];
    		if(isset($hero['name']))
			{
				if($this->session->userdata('prod_hero_'.$product['id']))
				{
					$cur_hero = $this->Product_model->get_photo($this->session->userdata('prod_hero_'.$product['id']));
					if(isset($cur_hero['name']))
					{
				?>
					<img id="main_hero"  class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$cur_hero['name']?>" />
    				<img id="main_hero2" class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$cur_hero['name']?>" />
				<?
					}
					else 
					{
					?>
					<img id="main_hero"  class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>" />
    				<img id="main_hero2" class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>" />
					<?
					}
				}
				else
				{	
			?>
				<img id="main_hero"  class="hidden-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>" />
    			<img id="main_hero2" class="visible-phone" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>" />
			<?php
				}
			}
			else
			{
			?>
				<img id="main_hero3" class="hidden-phone" src="http://placehold.it/472x515" />
    			<img class="visible-phone" src="http://placehold.it/710x775" />
			<?php	
			}
    		?>
    		
    		<div style="width: 100%; margin-top: 10px; margin-bottom: 10px; text-align: center; font-family: 'open sans'; font-size: 12px">
    			HOVER TO ZOOM
    		</div>
    		<!-- <div class="row-fluid  hidden-phone">
    			<?php
    			if(isset($hero['name']))
				{
				?>
					<div class="span3">
	    				<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>"/>
	    			</div>
	    			<div class="span3">
	    				<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>"/>
	    			</div>
	    			<div class="span3">
	    				<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>"/>
	    			</div>
	    			<div class="span3">
	    				<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb1/<?=$hero['name']?>"/>
	    			</div>
				<?php
				}
				else 
				{
				?>
					<div class="span3">
	    				<img src="http://placehold.it/472x515"/>
	    			</div>
	    			<div class="span3">
	    				<img src="http://placehold.it/472x515"/>
	    			</div>
	    			<div class="span3">
	    				<img src="http://placehold.it/472x515"/>
	    			</div>
	    			<div class="span3">
	    				<img src="http://placehold.it/472x515"/>
	    			</div>
				<?php
				}
    			?>
    			
    		</div> -->
    	</div>
    	<div class="span5">
    		<div style="font-size: 16px; font-weight: 700">
    			<?php
    			$title = explode('-',$product['title']);
				
				
				if($product['limited'] == 'Y')
				{
				?>
					<img style="margin-right: 5px; margin-top:-5px" src="<?=base_url()?>img/limited.png" />
				<?
				}
				
				?>
				
				<?php
				if($product['first_edition'] == 'Y')
				{
				?>
					<img src="<?=base_url()?>img/first-small.png" />
				<?
				}
				else if($first!='')
				{
				?>
					<!-- <div style="float: right; padding-left: 10px; border-left: 2px solid #333"> -->
						<a href="<?=base_url()?>store/detail_product/First-Edition/<?=$first?>"><img src="<?=base_url()?>img/first-small.png" /></a>
					<!-- </div> -->
				<?
				} 
				else
				{
				?>
					
				<?
				}
				?>
    			
    			<span style="font-family: buenard; font-size: 22px;"><?=$title[0]?></span> 
    			<span style="font-family: buenard; font-size: 16px; font-weight: 400"><?=$title[1]?></span>
    		</div>
    		<div style="height: 3px"></div>
    		<div style="font-family: buenard; font-size: 16px; font-weight: 400"><?=$product['short_desc']?></div>
    		<div style="height: 3px"></div>
    		<?php
    				$cur_user = $this->session->userdata('userloggedin');
					
					//echo $cur_user['level'];
					$lprice = 0;
					if($cur_user['level'] == 1)
					{
						if($product['sale_price'] < $product['price'])
						{
							$cur_price = $product['sale_price'];
							$lprice = $product['price'];
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
							$lprice = $product['price'];
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
							$lprice = $product['price'];
						}
						else 
						{
							$cur_price = $product['price'];
						}
					}
    			 
    				$prc =  number_format($cur_price * $cur_val,2,'.',',');
					$lprc =  number_format($lprice * $cur_val,2,'.',',');
    			?>
    		
    		<div style="font-family: buenard; font-size: 24px; font-weight: 400">
    			<?php
    				if($lprice == 0)
					{
						echo $sign.$prc;
					}
					else 
					{
					?>
						<span style="text-decoration: line-through"><?=$sign?><?=$lprc?></span>  <span style="color: #E4006F"><?=$sign?><?=$prc?></span>
					<?
					}
    			?>
    			<!-- <?=$sign?><?=$prc?> -->
    		<div style="height: 20px"></div>
    			
    		</div>
    		<!-- <div onclick="addtocart();" class="hidden-phone" style="background: none repeat scroll 0 0 #000000; color: #FFFFFF; height: 30px; line-height: 30px; text-align: center; width: 180px; cursor: pointer">ADD TO SHOPPING BAG</div> -->
    		<div onclick="addtocart();" style="font-size:12px; font-weight: 700; letter-spacing: 2px; background: none repeat scroll 0 0 #070707; color: #FFFFFF; height: 30px; line-height: 30px; text-align: center; width: 100%; cursor: pointer">ADD TO SHOPPING BAG</div>
    		<div style="height: 5px;"></div>
    		<!-- <div class="hidden-phone" style="background: none repeat scroll 0 0 #000000; color: #FFFFFF; height: 30px; line-height: 30px; text-align: center; width: 180px; cursor: pointer">ADD TO WISH LIST</div> -->
    		<div onclick="add_towishlist()" style="font-size:12px; font-weight: 700; letter-spacing: 2px; background: none repeat scroll 0 0 #878382; color: #FFFFFF; height: 30px; line-height: 30px; text-align: center; width: 100%; cursor: pointer">ADD TO WISH LIST</div>
    		<div style="height: 15px;"></div>
    		<div style="height: 10px; border-top: dashed 1px #000;"></div>
    		<div style="font-size: 16px; font-weight: 400; font-family: 'open sans'">
    			<!-- OTHER COLOURS -->
    			<div style="float: left; line-height: 20px; height: 20px;">
    			OTHER COLOURS
    			</div>
    				<?php
    				if($product['first_edition'] == 'Y')
					{
					?>
						<div style="float: right; padding-left: 10px; border-left: 2px solid #333">
							<img height="20" src="<?=base_url()?>img/First-Edition-Logo.png" />
						</div>
					<?
					}
					else if($first!='')
					{
					?>
						<div style="float: right; padding-left: 10px; border-left: 2px solid #333">
							<a href="<?=base_url()?>store/detail_product/First-Edition/<?=$first?>"><img height="20" src="<?=base_url()?>img/First-Edition-Logo.png" /></a>
						</div>
					<?
					} 
					else
					{
					?>
						<div style="float: right; padding-left: 10px;">
							<div style="height: 20px; width: 61px">&nbsp;</div>
						</div>
					<?
					}
    				?>
    			<div style="clear: both"></div>
    		</div>
    		<div style="height: 10px;"></div>
    		<div class="accordion" id="accordion2">
    			<div class="accordion-group">
					<div class="accordion-heading">
					<a onclick="click_line(1)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
						<div style="float:left; font-size: 16px; font-weight: 400; font-family: 'open sans'">DESIGNER NOTES</div>
						<div id="line1-down" style="float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
						<div id="line1-right" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
						<div style="clear: both"></div>
					</a>
					</div>
					<div id="collapseOne" class="accordion-body collapse in">
						<div class="accordion-inner">
							<div style="font-family: buenard">
								<?=$product['long_desc']?>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a onclick="click_line(2)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne1">
							<!-- <span style="font-size: 16px; font-weight: 400; font-family: 'open sans'">FEATURES</span> -->
							<div style="float:left; font-size: 16px; font-weight: 400; font-family: 'open sans'">FEATURES</div>
							<div id="line2-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
							<div id="line2-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
							<div style="clear: both"></div>
						</a>
					</div>
					<div id="collapseOne1" class="accordion-body collapse">
						<div class="accordion-inner">
							<div style="font-family: buenard">
								<?=$product['features']?>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a onclick="click_line(3)" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
							<!-- <span style="font-size: 16px; font-weight: 400; font-family: 'open sans'">SIZE</span> -->
							<div style="float:left; font-size: 16px; font-weight: 400; font-family: 'open sans'">SIZE</div>
							<div id="line3-down" style="display:none; float: right; margin-top: 5px"> <i class="icon icon-angle-down"></i> </div>
							<div id="line3-right" style="float: right; margin-top: 5px"> <i class="icon icon-angle-right"></i> </div>
							<!-- <div id="line3" style="float: right; margin-top: 5px"> <i class="icon icon-chevron-right"></i> </div> -->
							<div style="clear: both"></div>
						</a>
					</div>
					<div id="collapseOne2" class="accordion-body collapse">
						<div class="accordion-inner">
							<div style="font-family: buenard">
								Dimension: <?=$product['dimension']?><br/>
								Length: <?=$product['length']?><br/>
								Weight: <?=$product['weight']?> Kg
							</div>
						</div>
					</div>
				</div>
				<div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding-top: 10px; padding-bottom: 10px">
					<img class="social-icon" src="<?=base_url()?>img/fb-like.png" />
					<img class="social-icon" src="<?=base_url()?>img/fb-send.png" />
					<img class="social-icon" src="<?=base_url()?>img/t.png" />
					<img class="social-icon" src="<?=base_url()?>img/tweet.png" />
					<img class="social-icon" src="<?=base_url()?>img/pinit.png" />
					<img class="social-icon" src="<?=base_url()?>img/gplus.png" />
					<img class="social-icon" src="<?=base_url()?>img/sms.png" />
					<img style="margin-right: 0px;" class="social-icon" src="<?=base_url()?>img/mail.png" />
					<div style="clear: both"></div>
				</div>
    		</div>
    		
    		
    	</div>
    </div>
    <div style="height: 20px;"></div>
    <div class="row hidden-phone">
    	<div class="span12">
    		<div style="font-size: 22px; font-weight: 400; text-align: center">YOU MAY ALSO LIKE...</div>
    	</div>
    </div>
    <div style="height: 10px;"></div>
    <div class="hidden-phone" style="height: 10px;"></div>
    <div class="row hidden-phone">
        <div class="carousel slide span12 hidden-phone" id="myCarousel3">
            <div class="carousel-inner">
              <div class="item active">
                    <ul class="thumbnails">
                    	
                        <!-- <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-1.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-2.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-3.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-4.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-5.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-6.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li> -->
                        
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
		                                <div class="feat_title" style="text-align:center; font-family: buenard; font-size: 12px;"><span style="font-size: 16px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></div>
		                                <div class="feat_desc" style="text-align:center; font-family: buenard; font-size: 12px;"><?=$prod['short_desc']?></div>
		                                <div class="feat_price" style="text-align:center; font-family: buenard; font-size: 16px;"><?=$sign?><?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		                            </div>
		                        </li>
							<?php
						}
                    	
                    	?>
                        
                        
                    </ul>
              </div>
              
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
		                                <div class="feat_title" style="text-align:center; font-family: buenard; font-size: 12px;"><span style="font-size: 16px; font-weight: 700"><?=trim($title[0])?></span> <?=trim($title[1])?></div>
		                                <div class="feat_desc" style="text-align:center; font-family: buenard; font-size: 12px;"><?=$prod['short_desc']?></div>
		                                <div class="feat_price" style="text-align:center; font-family: buenard; font-size: 16px;"><?=$sign?><?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		                            </div>
		                        </li>
							<?php
						}
                    	
                    	?>
                        <!-- <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-7.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-8.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-9.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-10.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-11.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li>
                        <li class="span2">
                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                <img src="<?=base_url()?>img/product-12.jpg" alt="" width="156px">
                                <div style="height:10px;"></div>     
                                <div class="feat_title">title</div>
                                <div class="feat_desc">short desc</div>
                                <div class="feat_price">$ 0.00</div>
                            </div>
                        </li> -->
                     </ul>
              </div>
               
            </div>
           
            <!-- <a data-slide="prev" href="#myCarousel3" class="left carousel-control">‹</a>
            <a data-slide="next" href="#myCarousel3" class="right carousel-control">›</a> -->
            
            <a class="left carousel-control" data-slide="prev" href="#myCarousel3" style="background: none; border: none; opacity: 1">
								<img src="<?=base_url()?>img/grey-left-arrow.png"/>
							</a>
							<a class="right carousel-control" data-slide="next" href="#myCarousel3" style="background: none; border: none; opacity: 1">
								<img src="<?=base_url()?>img/grey-right-arrow.png"/>
							</a>
        </div>
    </div>
    
    
    <div id="anyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Message</h3>
	</div>
	<div class="modal-body">
	    <p id="any_message"></p>
	</div>
	<div class="modal-footer">
	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	
	</div>
	</div>
    
    <script>
    $("#main_hero").zoome({showZoomState:true,zoomRange:[1,5],zoomStep:0.5,defaultZoom:1.5,magnifierSize:[220,220]});
    $("#main_hero2").zoome({showZoomState:true,zoomRange:[1,5],zoomStep:0.5,defaultZoom:1.5,magnifierSize:[220,220]});
    //$("#main_hero3").zoome({showZoomState:true,zoomRange:[1,5],zoomStep:0.5,defaultZoom:1.5,magnifierSize:[220,220]});
    
    
    
    
    $( document ).ready(function() {
		console.log( "ready!" );
		$('.cycle-carousel-wrap').css('top','-255px');
	});
   	</script>
    
    <!-- Menu for phone mode -->
    
    
    <script>
	
	
	function change_img(id)
	{
		//var new_src = $('#left-img'+id).attr('src');
		//$("#main_hero3").attr('src',new_src);
		//$("#main_hero3").zoome({showZoomState:true,zoomRange:[1,5],zoomStep:0.5,defaultZoom:1.5,magnifierSize:[220,220]});
		var cur_id = <?=$product['id']?>;
		var photo_id = id;
		
		
		
		$.ajax({
		url: '<?=base_url()?>cart/set_temp_hero',
		type: 'POST',
		data: ({prod_id:cur_id,photo_id:photo_id}),
		dataType: "html",
		success: function(html) {
		
				//jQuery('.tot_shopbag').text(html);
				//$('#anyModal').modal('show');
				
				location.reload(); 
		
		}
		});
	}
	</script>
    
    
    
    
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    
    <!-- End Product for Iphone -->
		
        
   