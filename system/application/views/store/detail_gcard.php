<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js?n=1"></script> -->
<!-- <script src="http://code.jquery.com/jquery-latest.min.js"    type="text/javascript"></script> -->
<!-- <script src="<?=base_url()?>js/select2/select2.js"></script> -->
<!-- <script src="<?=base_url()?>js/jquery.cycle2.js"></script>
<script src="<?=base_url()?>js/jquery.cycle2.carousel.js"></script> -->


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="http://malsup.github.io/jquery.cycle2.js"></script>
<script src="http://malsup.github.io/jquery.cycle2.carousel.js"></script>
<script>$.fn.cycle.defaults.autoSelector = '.slideshow';</script>
<?php
	$url_pages=$_SERVER['REQUEST_URI'];
	$ex_pages=explode("/",$url_pages);
	$curr_cat=$ex_pages[4];
?>
<script>

// jQuery(function() {
	// jQuery('.all_tt').tooltip({
		// showURL: false
	// });
// });


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
	else if(id == 1 && line1 == 1)
	{
		line1 = 0;
	}
	
	if(id == 2 && line2 == 0)
	{
		line1 = 0;
		line2 = 1;
		line3 = 0;
	}
	else if(id == 2 && line2 == 1)
	{
		line2 = 0;
	}
	
	if(id == 3 && line3 == 0)
	{
		line1 = 0;
		line2 = 0;
		line3 = 1;
	}
	else if(id == 3 && line3 == 1)
	{
		line3 = 0;
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
	
	if($j('#sizeproduct').val() == '--')
	{
		$j('#any_message').html("Please select your shoes's size");
		$j('#anyModal').modal('show');
		return false;
	}
	var attributes = '';
	
	var myObject = new Object();
	var num = 0;
	
	<?php for($i=0;$i<count($attributes);$i++) 
	{ ?>
	 // use json javascript generator and pass value in json format(by Hieu)
	 //myArray[<?=$i?>] = $j('#attribute-<?=$i?>').val();
	 myObject.<?=$attributes[$i]['name']?> = $j('#attribute-<?=$i?>').val();
	<?php } ?>
	if($j('#sizeproduct').length)
	{
	  mul_size = $j('#sizeproduct').val();
	
		myObject.Size = mul_size;
	}
	//var myObject = toObject(myArray);
	attributes = JSON.stringify(myObject);
	
	$.ajax({
	url: '<?=base_url()?>cart/addtocart',
	type: 'POST',
	data: ({quantity:quantity,product_id:<?=$product['id']?>,attributes:attributes}),
	dataType: "html",
	success: function(html) {
	
			$j('#any_message').html(html);
			$j('#anyModal').modal('show');
			
			
			$.ajax({
			url: '<?=base_url()?>cart/count_cart',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
					//var adding = "<br/><br/>Note: This product will stay in your shopping cart for only 1hour. If you think you may take longer to check out place in your Wish List";
					$j('.tot_shopbag').text(html);
					$j('#anyModal').modal('show');
			
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
	url: '<?=base_url()?>cart/add_towishlist',
	type: 'POST',
	data: ({cat_name:cat_name,product_id:product_id}),
	dataType: "html",
	success: function(html) {
		
		if(html > 0)
		{
			$j('#any_message').html('You have successfully saved this item to your Wish List.');
		}
		else
		{
			$j('#any_message').html('Please login to your member account to add this product to your wish list <br> Click <a href="<?=base_url()?>store/signin"> here </a> to sign up or login to your member account.');
		}
		
		
		$j('#anyModal').modal('show');
		
		$.ajax({
			url: '<?=base_url()?>cart/count_wishlist',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
			
					$j('.tot_wishlist').text(html);
					$j('#anyModal').modal('show');
			
			}
			});
	}
	})
}
</script>




<div class="app-container">
	<!-- facebook -->
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=380953882022304";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>


  //function
  
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '380953882022304', // App ID
    channelUrl : '//odessa.net.au/cart_v1/channel.html', // Channel File
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
    
  });

  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
  // for any auth related change, such as login, logout or session refresh. This means that
  // whenever someone who was previously logged out tries to log in again, the correct case below 
  // will be handled. 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most bsers unless they 
      // result from direct user interaction (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
    } else {
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
    }
  },{scope:'email,user_birthday'});
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));
  
  

  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {
    //console.log('Welcome!  Fetching your information.... ');
     //FB.api('/me', function(response) {
       //console.log('Good to see you, ' + response.email + '.');
     //});
    //window.location='<?=base_url()?>store/fb';
    //alert('login');
    $('#send-fb-btn').show();
  }
</script>



	<!-- facebook -->

	<div style="height:10px;"></div>     
    <div class="">
    	<div class="col-sm-12">
    		<ul class="breadcrum-Font breadcrumb">
			    <li><a href="<?=base_url()?>">Home</a> <span class="divider">></span></li>
			    <?php
			    	$cat = $this->Category_model->identify($product['main_category']);
					$cat_name = $cat['name'];
					if($sale == 'yes')
					{
						$cat_name = 'sale';
					}
					$mid = 0;
					if($cat_name == 'Handbags') {$mid = 2;}
					if($cat_name == 'Wallets') {$mid = 3;}
					if($cat_name == 'Travel') {$mid = 4;}
					if($cat_name == 'Accessories') {$mid = 5;}
					if($cat_name == 'Sale') {$mid = 6;}
					if($cat_name == 'Stylefile') {$mid = 7;}
					if($cat_name == 'News') {$mid = 8;}
					
					if($save_sub == '')
					{
						$url = base_url().'store/products/'.$cat_name.'/all';
					}
					else
					{
						$url = base_url().'store/products/'.$cat_name;
					}
			    ?>
			    <li><a href="<?=$url?>">
			    	<?php
			    	if($sale == 'yes')
					{
						echo 'Sale';
					}
					else 
					{
						echo $cat['title'];
					}
			    	?>
			    </a> <span class="divider">></span></li>
			    <?php
			    if($save_sub != '')
				{
				?>
				<li><a href="<?=$url?>/<?=$save_sub_link?>">
			    	<?=$save_sub?>
			    </a> <span class="divider">></span></li>
				<?
				}
			    ?>
			    <li class="color_active"><?=$product['title']?></li>
		    </ul>
		</div>
    </div>
    <div style="height:10px;"></div>     
    <div class="">
    	<? if(count($photos)>3){ ?>
        <div class="col-sm-2  hidden-xs">
    		
    		<div style="margin-left: 15%; margin-bottom: 10px">			    
			    <a href=# id=prev3><img src="<?=base_url()?>img/grey-up-ar.png" alt=""/></a>
			</div>
			
			
    		
    		<div class="slideshow vertical-big hidden-xs hide-small" 
			    data-cycle-fx=carousel
			    data-cycle-timeout=0
			    data-cycle-next="#prev3"
			    data-cycle-prev="#next3"
			    data-cycle-pager="#pager3"
			    data-cycle-carousel-visible=3
			    data-cycle-carousel-vertical=true>
			    <?php
			    	if($this->session->userdata('prod_hero_'.$product['id']))
					{
						$now_hero_id = $this->session->userdata('prod_hero_'.$product['id']);
					}
					else 
					{
						$now_hero_id = $hero['id'];
					}					
					foreach($photos as $photo)
					{
						if(isset($photo))
						{
							$p = $photo;
							if($p['id'] != $now_hero_id)
							{
								?>
									<img onclick="change_img(<?=$p['id']?>)" style="cursor:pointer; margin-bottom: 15px !important;" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb2/<?=$p['name']?>"/>
								<?							
							}
							else
							{}
						}
						else 
						{}
					}
					
			    ?>
			   
			    
			</div>
            
			
			<div class="slideshow vertical-small hidden-xs show-small" 
			    data-cycle-fx=carousel
			    data-cycle-timeout=0
			    data-cycle-next="#prev3"
			    data-cycle-prev="#next3"
			    data-cycle-pager="#pager3"
			    data-cycle-carousel-visible=3
			    data-cycle-carousel-vertical=true>
			    <?php
			    	if($this->session->userdata('prod_hero_'.$product['id']))
					{
						$now_hero_id = $this->session->userdata('prod_hero_'.$product['id']);
					}
					else 
					{
						$now_hero_id = $hero['id'];
					}
					foreach($photos as $photo)
					{
						if(isset($photo))
						{
							$p = $photo;
							if($p['id'] != $now_hero_id)
							{
							?>
								<img onclick="change_img(<?=$p['id']?>)" style="cursor:pointer; margin-bottom: 18px !important;" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb3/<?=$p['name']?>"/>
							<?
							
							}
							else
							{}
						}
						else 
						{}
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
					foreach($photos as $photo)
					{
						if(isset($photo))
						{
							$p = $photo;
							if($p['id'] != $now_hero_id)
							{
							?>
								<img onclick="change_img(<?=$p['id']?>)" style="cursor:pointer; margin-bottom: 18px !important;" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb4/<?=$p['name']?>"/>
							<?							
							}
							else
							{}
						}
						else 
						{}
					}
			    ?>
			    
			</div>
			
			<div style="margin-left: 15%; margin-top: 10px">			   
			    <a href=# id=next3><img src="<?=base_url()?>img/grey-down-ar.png" alt=""/></a>
			</div>
			
    		<div style="display: none" class="cycle-pager" id=pager4></div>
    	
    	</div>
        <? } 
		else
		{
			if(count($photos)>0){
			?><div class="col-sm-2  hidden-xs"><?
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
					
				}
				
			}
			?> </div><?
            
			}
			else
			{?>
			<div class="col-sm-2  hidden-xs"></div>
			<? }
	
		}?>
    	<div class="col-sm-5">    		
    		<?php
    		if($product['sale_price'] < $product['price'])
			{
			?>
				<img style="position: absolute; z-index: 999;" src="<?=base_url()?>img/sale-sign.png" />
			<?php
			}
    		?>
    		<?php
    		
    		if(isset($hero['name']))
			{
				if($this->session->userdata('prod_hero_'.$product['id']))
				{
					$cur_hero = $this->Product_model->get_photo($this->session->userdata('prod_hero_'.$product['id']));
					if(isset($cur_hero['name']))
					{
				?>					
    				<a href="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$cur_hero['name']?>" class="MagicZoom" rel="zoom-position: inner">
    					<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$cur_hero['name']?>"/>
    				</a>
				<?
					}
					else 
					{
					?>
					
    				<a href="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>" class="MagicZoom" rel="zoom-position: inner">
    					<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>
    				</a>
					<?
					}
				}
				else
				{	
			?>
				
    			<a href="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>" class="MagicZoom" rel="zoom-position: inner">
    					<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>
    				</a>
			<?php
				}
			}
			else
			{
			?>
				<img id="main_hero3" class="hidden-xs" src="http://placehold.it/472x515" />
    			<img class="visible-phone" src="http://placehold.it/710x775" />
			<?php	
			}
    		?>
    		
    		<div class="body-copy-Font" id="hover-zoom">
    			Hover To Zoom
    		</div>
    	</div>
    	<div class="col-sm-5">
    		<div style="font-size: 16px; font-weight: 700">
    			<?php
    			$title = explode('-',$product['title']);
				
				
				if($product['limited'] == 'Y')
				{
				?>
					<img class="limit_tt" data-toggle="tooltip" title=" LIMITED HANDBAG" style="margin-right: 5px; margin-top:-5px" src="<?=base_url()?>img/limited.png" />
				<?
				}
				
				?>
				
				<?php
				if($product['first_edition'] == 'Y')
				{}
				else if($first!='')
				{} 
				else
				{}
				?>
    			<span class="product-title-Font product-title-primary"><?=$product['title']?></span> 
    			<!-- <span class="product-title-Font product-title-primary"><?=$title[0]?></span> 
    			<span class="product-title-Font product-title-secondary"><?=$title[1]?></span> -->
    		</div>
    		<div style="height: 3px"></div>
    		<div class="product-desc-Font product-desc"><?=$product['short_desc']?></div>
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
    		
    		<div class="product-price-Font product-price">
    			<?php
    				if($lprice == 0)
					{
						echo $sign.$prc;
					}
					else 
					{
					?>
						<span class="product-price-sale"><?=$sign?><?=$lprc?></span>  <span class="color_active"><?=$sign?><?=$prc?></span>
					<?
					}
    			?>    			
    		<?php
    		if($product['stock'] <= 5)
			{
				if($product['stock'] == 1)
				{
				?>
					<div style="height: 10px"></div>
		    		<div class="product-warning-Font color_active product-warning" >
		    			Low in stock, 1 item remaining
		    		</div>
		    		<div style="height: 10px"></div>
				<?
				}
				elseif($product['stock'] == 0 && $product['multiplesize'] == 0)
				{
				?>
					<div style="height: 10px"></div>
		    		<div class="product-warning-Font color_active product-warning" >
		    			Out of stock
		    		</div>
		    		<div style="height: 10px"></div>
				<?	
				}
				elseif($product['multiplesize'] == 0) 
				{
				?>
					<div style="height: 10px"></div>
		    		<div class="product-warning-Font color_active product-warning">
		    			Low in stock
		    		</div>
		    		<div style="height: 10px"></div>
				<?
				}
			}
			else 
			{
			?>
			<div style="height: 10px"></div>
			<?	
			}
    		?>
    		
    			
    		</div>
    		
    		
    		<div style="height: 15px;"></div>
            <? $other = $this->Product_model->get_other_product_same_cat($title[0],$product['id'],$product['short_desc']); 
					if(count($other)>0){
				?>
    		<div style="height: 10px;"></div>
    		<div class="product-header-info-Font product-header-info">
    			<!-- OTHER COLOURS -->
                
    			<div style="float: left; line-height: 42px; height: 42px;">
    			Other Colours
    			</div>
    			<div class="visible-desktop list-other">	
				<?
                    	
						if(count($other)>0){
							$cc = 0;
							foreach($other as $ot)
							{
								if($cc<6)
								{	
									$hero_new = $this->Product_model->get_hero($ot['id']);
									if(count($hero_new)>0){
									?>
	                                	<div style="margin-left:10px; margin-top:2px;float:left;">
	                                		<a href="<?=base_url()?>store/detail_product/<?=$cat_name?>/<?=$ot['id_title']?>">
	                                			<img style="cursor:pointer; width: 45px" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$ot['id'])?>/thumb4/<?=$hero_new['name']?>" />                                			
	                                		</a>
	                                	</div>								
	                                <?
	                                $cc++;
									}
								}
							}
						}
					?>
					</div>
                    <div style="clear:both; margin-top:10px; float:left;" class="hidden-desktop">	
                    
				<?
                    	
						if(count($other)>0){
							$cc = 0;
							foreach($other as $ot)
							{
								if($cc<6)
								{	
									$hero_new = $this->Product_model->get_hero($ot['id']);
									if(count($hero_new)>0){
									?>
	                                	<div style="margin-left:8px; margin-top:-10px;float:left;">
	                                		<a href="<?=base_url()?>store/detail_product/<?=$cat_name?>/<?=$ot['id_title']?>">
	                                			<img class="hidden-xs" style="cursor:pointer; width: 40px" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$ot['id'])?>/thumb4/<?=$hero_new['name']?>" />                                			
                                                <img class="visible-phone" style="cursor:pointer; width: 35px" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$ot['id'])?>/thumb4/<?=$hero_new['name']?>" />                                			
	                                		</a>
	                                	</div>								
	                                <?
	                                $cc++;
									}
								}
							}
						}
					?>
					</div>
                  
					<?php
    				if($product['first_edition'] == 'Y')
					{
					?>
						<div style="float: right; padding-left: 10px; border-left: 2px solid #333">
							<img class="all_tt" data-toggle="tooltip" title="This product is also availabe as a 1st Edition" height="20" src="<?=base_url()?>img/first.png" />
						</div>
					<?
					}
					else if($first!='')
					{
					?>
						<div style="float: right; padding-left: 10px; border-left: 2px solid #333">
							<a href="<?=base_url()?>store/detail_product/First-Edition/<?=$first?>"><img  height="20" src="<?=base_url()?>img/First-Edition-Logo.png"  /></a>
						</div>
					<?
					} 
					else
					{
					?> 
					<?
					}
    				?>
    			<div style="clear: both"></div>
    		</div>
              <? } ?>

            <div class="product-header-info-Font product-header-info">Descriptions</div>
            <div style="height: 10px;clear: both;"></div>
            <div class="product-info-Font product-info" >	<?=$product['long_desc']?>	</div>
            <div style="height: 10px;clear: both;"></div>
            <script>
            function show_gcard()
			{
				var id = jQuery('#g_id').val();
				var sender = jQuery('#g_from').val();
				var recipient = jQuery('#g_to').val();
				var notes = jQuery('#g_note').val();
				var amount = jQuery('#g_amount').val();
				
				
				jQuery.ajax({
					url: '<?=base_url()?>store/set_giftcard_data',
					type: 'POST',
					data: ({id:id,sender:sender,recipient:recipient,notes:notes,amount:amount}),
					dataType: "html",
					success: function(html) {
						open_window('<?=base_url()?>store/giftcard_preview');			
					}
				})
			}
			
			function addtocart() {
					
			var id = jQuery('#g_id').val();
			var sender = jQuery('#g_from').val();
			var recipient = jQuery('#g_to').val();
			var notes = jQuery('#g_note').val();
			var amount = jQuery('#g_amount').val();
			var send = jQuery('#g_send').val();
			var email = jQuery('#g_emailr').val();
			
			var valid = true;
			var error = '';
			
			if(sender == '')
			{
				valid = false;
				error = error + 'Please insert a valid sender name<br/>';
			}
			
			if(email == '')
			{
				valid = false;
				error = error + 'Please insert a valid recipient email<br/>';
			}
			
			if(recipient == '')
			{
				valid = false;
				error = error + 'Please insert a valid recipient name<br/>';
			}
			
			if(send == '')
			{
				valid = false;
				error = error + 'Please insert a valid send date<br/>';
			}
			
			if(amount == '' || amount <= 0 || isNaN(amount))
			{
				valid = false;
				error = error + 'Please insert a valid gift card amount<br/>';
			}
			
			if(valid)
			{
				$.ajax({
				url: '<?=base_url()?>cart/add_to_cart_giftcard',
				type: 'POST',
				data: ({id:id,sender:sender,recipient:recipient,notes:notes,amount:amount,send:send,email:email}),
				dataType: "html",
				success: function(html) {
				
						$j('#any_message').html(html);
						$j('#anyModal').modal('show');
						
						
						$.ajax({
						url: '<?=base_url()?>cart/count_cart',
						type: 'POST',
						data: ({}),
						dataType: "html",
						success: function(html) {
								//var adding = "<br/><br/>Note: This product will stay in your shopping cart for only 1hour. If you think you may take longer to check out place in your Wish List";
								$j('.tot_shopbag').text(html);
								$j('#anyModal').modal('show');
						
						}
						});
				
				}
				});
			}
			else
			{
				$j('#any_message').html(error);
				$j('#anyModal').modal('show');
			}
			
			
		} 
           	</script>
            <div class="product-info-Font product-info" >
            	<input type="hidden" id="g_id" name="g_id" value="<?=$product['id']?>">
            	<div class="gcard-form-label label-form-Font">Gift Amount AU$</div>
            	<div class="gcard-form-input">
            		<input id="g_amount" name="g_amount" class="gcard-input input-form-Font no-margin" type="number" required="" value="">
            	</div>
            	<div style="clear: both; height: 10px;"></div>
            	<div class="gcard-form-label label-form-Font">Send On</div>
            	<div class="gcard-form-input">
            		
            		<div id="dob1" class="input-append gcard-input" style="width: 89%; margin: 0">
						<input data-format="dd-MM-yyyy" class="input-form-Font" type="text" name="g_send" id="g_send" style="width: 95%;"></input>
						<span style="cursor: pointer" class="add-on">
						  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
						  </i>
						</span>
					</div>
					<script type="text/javascript">
						var date = new Date();
						date.setDate(date.getDate());
						
						  $j(function() {
						    $j('#dob1').datetimepicker({
						      pickTime: false,
						      startDate:date
						    });
						  });
					</script>
            	</div>
            	<div style="clear: both; height: 10px;"></div>
            	<div class="gcard-form-label label-form-Font">Recipient's Email</div>
            	<div class="gcard-form-input">
            		<input id="g_emailr" name="g_emailr" class="gcard-input input-form-Font no-margin" type="email" required="" value="">
            	</div>
            	<div style="clear: both; height: 10px;"></div>
            	<div class="gcard-form-label label-form-Font">To</div>
            	<div class="gcard-form-input">
            		<input id="g_to" name="g_to" class="gcard-input input-form-Font no-margin" type="text" required="" value="">
            	</div>
            	<div style="clear: both; height: 10px;"></div>
            	<div class="gcard-form-label label-form-Font">From</div>
            	<div class="gcard-form-input">
            		<input id="g_from" name="g_from" class="gcard-input input-form-Font no-margin" type="text" required="" value="">
            	</div>
            	<div style="clear: both; height: 10px;"></div>
            	<div class="gcard-form-label label-form-Font">Message</div>
            	<div class="gcard-form-input">
            		
            		<textarea name="g_note" id="g_note" s="3" class="gcard-input input-form-Font"></textarea>
            	</div>
            	<!-- <div style="clear: both; height: 10px;"></div> -->
            </div>
            <div style="height: 15px;clear: both;"></div>
            <button onclick="addtocart();" class="button-Font button_primary button_size_full" onclick="">Add To Shopping Bag</button>
    		<div style="height: 5px;"></div>
    		<button onclick="show_gcard();" class="button-Font button_secondary button_size_full" onclick="">Preview Gift Voucher</button>    		
            <div style="height: 15px;"></div> 
            <div style="padding-top: 10px; padding-bottom: 10px" >
										
				<?php
                
                $cat = $this->Category_model->identify($product['main_category']);
                ?>
                <div id="send-fb-btn" class="social-icon" style="width: 46px; display: none">
                    <div  class="fb-send" data-href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>" data-send="true"></div>
                </div>
                <div class="social-icon" style="width: 46px;">
                    <div class="fb-like" data-href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
                </div>
                
                <div class="social-icon" >
                    <script src="http://platform.tumblr.com/v1/share.js"></script>
                    <a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:20px; height:20px; background:url('http://platform.tumblr.com/v1/share_4T.png') top left no-repeat transparent;">Share on Tumblr</a>
                </div>
                
                
                <div class="social-icon">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>" data-count="none">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
                
                
                
                <div class="social-icon">
                    <a target="_blank" href="//pinterest.com/pin/create/button/?url=<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>&media=<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>&description=<?=$product['title']?>" data-pin-do="buttonPin" data-pin-config="none"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
                </div>
                
                
                <div class="social-icon">
                    <!-- Place this tag where you want the +1 button to render. -->
                    <div class="g-plusone" data-size="medium" data-annotation="none"></div>
                    
                    <!-- Place this tag after the last +1 button tag. -->
                    <script type="text/javascript">
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                </div>					
                <img  class="social-icon" style="cursor: pointer; margin-right: 0px;" onclick="$j('#emailModal').modal('show');" src="<?=base_url()?>img/mail.png" />
                
                
                <div style="clear: both"></div>
			</div>   
             
    		
    	</div>
    </div>
    <div style="height: 20px;"></div>
    <div class=" hidden-xs">
    	<div class="col-sm-12">
    		<div class="body-copy-Font also-like" >You may also like...</div>
    	</div>
    </div>
    <div style="height: 10px;"></div>
    <div class="hidden-xs" style="height: 10px;"></div>
    
    
    
    <div class=" hidden-xs">
        <div class="carousel slide col-sm-12 hidden-xs" id="myCarousel4">
            <div class="carousel-inner">
						<? 
						$j=0;
						$lf=array();
						foreach($like_feature as $ot)
						{
							$lf[$j]=$ot;
							$j++;														
						}
						//$ij=1;
						//if(count($like_feature)>0){
							$i=0;
							$k=0;
							//for($i=0; $i<12; $i++)
							for($i=0; $i<12; $i++)
							{																																	
								if($i==0 || $i==6 || $i==12){
								?>
                                	<div class="item <? if($i==0){?>active <? }?>">
                                    <ul class="thumbnails">  
                                    
                             <? }
							 	if($i!= 0 || $i!=7){ 
								if(isset($lf[$i])){
								$prod = $this->Product_model->identify($lf[$i]);
								$hero = $this->Product_model->get_hero($lf[$i]);
								$titles = explode('-',$prod['title']);
								}
								else {
									$prod = false;
								}
								
								if($prod)
							    {                                                          
                                    ?>
                                    <li class="col-sm-2">
		                            <div class="thumbnail" style="border:none; border-radius: none; box-shadow: none; padding: 0">
                                		<?php
							    		
										if($prod['sale_price'] < $prod['price'])
										{
										?>
										<img style="position: absolute; z-index: 999;" src="<?=base_url()?>img/ssale-sign.png" />
										<?php
										}
							    		?>
		                                <?php
		                                	if($hero)
		                                	{
		                                	?>
		                                		<a href="<?=base_url()?>store/detail_product/quick_link/<?=$prod['id_title']?>"><img class="hidden-xs" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/thumb5/<?=$hero['name']?>"/></a>
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
                                	</div>	
                                    <div style="height:10px;"></div>    
                                     <? 	//$num = strlen($titles[0])+strlen($titles[1]); 
										// $word=trim($titles[1]);
										// if($num > 20)
										// {
											// $x=20-strlen($titles[0]);
											// $word=substr($titles[1], 0, $x).'...';	
 											
										// }
										$num_desc = strlen($prod['short_desc']);
										$word_desc=$prod['short_desc'];
										if($num_desc > 20)
										{
											$word_desc=substr($prod['short_desc'],0, 15).'...';	
										}
									?> 
		                            <div class="feature-title-Font feauture-title" ><?=$prod['title']?></div>
		                                <div class="feature-desc-Font feauture-desc" ><?=$word_desc?></div>
		                                <div class="feature-price-Font feauture-price"><?=$sign?><?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
                                    </li>
                                <? }}
								
								
								if($i==5 || $i==11 ){?> 
                                    </ul>
                                    </div>					
	
                                <? }                                								
								
							}
																															
						?>			
                       						
           	</div>
            
            <a class="left carousel-control" data-slide="prev" href="#myCarousel4" style="background: none; border: none; opacity: 1">
                <img style="margin-left: -100px" src="<?=base_url()?>img/white-left-ar.png"/>
            </a>
            <a class="right carousel-control" data-slide="next" href="#myCarousel4" style="background: none; border: none; opacity: 1">
                <img style="margin-right: -100px" src="<?=base_url()?>img/white-right-ar.png"/>
            </a>
        </div>
    </div>
    
    
    <div id="anyModal" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="mytop-modal" onclick="$j('#anyModal').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
    <div class="modal-body mybody-modal">
        <p id="any_message"></p>
    </div>
    </div>
	
	
	<div id="emailModal" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="mytop-modal" onclick="$j('#emailModal').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
	<form method="post" action="<?=base_url()?>store/send_friend_email">
	<input type="hidden" name="prod_id" value="<?=$product['id']?>">
	<div class="modal-body mybody-modal-left">
	    <table>
	    	<tr>
	    		<td class="label-form-Font" style="width: 150px; height: 30px; line-height: 30px; vertical-align: top">Name of your friend</td>
	    		<td><input class="input-form-Font" type="text" name="friend_name"/></td>
	    	</tr>
	    	<tr>
	    		<td class="label-form-Font" style="height: 30px; line-height: 30px; vertical-align: top">E-mail of your friend</td>
	    		<td><input class="input-form-Font" type="email" name="friend_email" required /></td>
	    	</tr>
	    	<tr>
	    		<td class="label-form-Font" style="height: 30px; line-height: 30px; vertical-align: top">Your name</td>
	    		<td><input class="input-form-Font" type="text" name="name"/></td>
	    	</tr>
	    	<tr>
	    		<td class="label-form-Font" style="height: 30px; line-height: 30px; vertical-align: top">Your e-mail</td>
	    		<td><input class="input-form-Font" type="email" name="email" required /></td>
	    	</tr>
	    	<tr>
	    		<td class="label-form-Font" style="height: 30px; line-height: 30px; vertical-align: top">Your message</td>
	    		<td><textarea class="input-form-Font" name="message"><?=$product['title']?></textarea></td>
	    	</tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
          	    	<button class="button-Font button_primary button_size_full" aria-hidden="true" type="submit">Send</button>
                </td>
            </tr>
	    </table>



	</div>
	</form>
	</div>
    
    <script>
   
    
    
    
    
    $( document ).ready(function() {
		console.log( "ready!" );
		$('.cycle-carousel-wrap').css('top','-255px');
	});
   	</script>
    
    <!-- Menu for phone mode -->
    
    
    <script>
	
	
	function change_img(id)
	{	
		var cur_id = <?=$product['id']?>;
		var photo_id = id;						
		$.ajax({
			url: '<?=base_url()?>cart/set_temp_hero',
			type: 'POST',
			data: ({prod_id:cur_id,photo_id:photo_id}),
			dataType: "html",
			success: function(html) {		
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
		
        
   