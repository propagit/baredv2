<script src="<?=base_url()?>js/jquery.cycle2.js"></script>
<script src="<?=base_url()?>js/jquery.cycle2.carousel.js"></script>
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
	<? if($product['multiplesize']==1){?>
	if($('#sizeproduct').val() == '--')
	{
		$('#any_message').html("Please Choose Your Size");
		$('#anyModal').modal('show');
		return false;
	}
	<? } ?>
	var attributes = '';
	
	var myObject = new Object();
	var num = 0;
	
	<?php for($i=0;$i<count($attributes);$i++) 
	{ ?>
	 // use json javascript generator and pass value in json format(by Hieu)
	 //myArray[<?=$i?>] = $('#attribute-<?=$i?>').val();
	 myObject.<?=$attributes[$i]['name']?> = $('#attribute-<?=$i?>').val();
	<?php } ?>
	if($('#sizeproduct').length)
	{
	  mul_size = $('#sizeproduct').val();
	
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
	
			$('#any_message').html(html);
			$('#anyModal').modal('show');
			
			
			$.ajax({
			url: '<?=base_url()?>cart/count_cart',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
					//var adding = "<br/><br/>Note: This product will stay in your shopping cart for only 1hour. If you think you may take longer to check out place in your Wish List";
					$('.tot_shopbag').text(html);
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
	
	if($('#sizeproduct').val() == '--')
	{
		$('#any_message').html("Please Choose Your Size");
		$('#anyModal').modal('show');
		return false;
	}
	var attributes = '';
	
	var myObject = new Object();
	var num = 0;
	
	<?php for($i=0;$i<count($attributes);$i++) 
	{ ?>
	 // use json javascript generator and pass value in json format(by Hieu)
	 //myArray[<?=$i?>] = $('#attribute-<?=$i?>').val();
	 myObject.<?=$attributes[$i]['name']?> = $('#attribute-<?=$i?>').val();
	<?php } ?>
	if($('#sizeproduct').length)
	{
	  mul_size = $('#sizeproduct').val();
	
		myObject.Size = mul_size;
	}
	//var myObject = toObject(myArray);
	attributes = JSON.stringify(myObject);
	
	$.ajax({
	url: '<?=base_url()?>cart/add_towishlist',
	type: 'POST',
	data: ({cat_name:cat_name,product_id:product_id,attributes:attributes}),
	dataType: "html",
	success: function(html) {
		
		if(html > 0)
		{
			$('#any_message').html('You have successfully saved <br>this item to your Wish List.');
		}
		else
		{
			$('#any_message').html('Please login to your member account to add this product to your wish list <br> Click <a href="<?=base_url()?>store/signin"> here </a> to sign up or login to your member account.');
		}
		
		
		$('#anyModal').modal('show');
		
		$.ajax({
			url: '<?=base_url()?>cart/count_wishlist',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
			
					$('.tot_wishlist').text(html);
					$('#anyModal').modal('show');
			
			}
			});
	}
	})
}

//window.onresize = function(){ location.reload(); }

var active_id = 1;
function active(id)
{
	if(active_id == id)
	{
		active_id = 0;
	}
	else
	{
		active_id = id;
	}
	
	// inactive all
	$('#accordion-headtitle1').removeClass('accordion-active');
	$('#accordion-headsign1').removeClass('accordion-active');
	$('#accordion-headtitle2').removeClass('accordion-active');
	$('#accordion-headsign2').removeClass('accordion-active');
	$('#accordion-headtitle3').removeClass('accordion-active');
	$('#accordion-headsign3').removeClass('accordion-active');
	
	
	
	$('#sign-active1').hide();
	$('#sign-active2').hide();
	$('#sign-active3').hide();
	
	
	$('#sign-inactive1').show();
	$('#sign-inactive2').show();
	$('#sign-inactive3').show();
	
	
	//active the id
	if(active_id != 0)
	{
		$('#accordion-headtitle'+active_id).addClass('accordion-active');
		$('#accordion-headsign'+active_id).addClass('accordion-active');
		$('#sign-active'+active_id).show();
		$('#sign-inactive'+active_id).hide();
	}
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
    <div class="col-sm-12">
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
    <div class="col-sm-12">
 
        <div class="col-sm-1  hidden-xs">
    		
    		<div style="margin-bottom: 10px">			    
			    <a href=# id=prev3><img src="<?=base_url()?>img/grey-up-arrow.png" alt=""/></a>
			</div>
            
			<div class="slideshow product-gallery" 
			    data-cycle-fx=carousel
			    data-cycle-timeout=0
			    data-cycle-next="#prev3"
			    data-cycle-prev="#next3"
			    data-cycle-pager="#pager3"
			    data-cycle-carousel-visible=3
			    data-cycle-carousel-vertical=true
			    >
			    <?php
					foreach($photos as $photo)
					{
						if(isset($photo))
						{
							$p = $photo;
							if($p['id'] != $hero['id'])
							{
							?>
								<img onclick="load_image('<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$p['name']?>')" src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb4/<?=$p['name']?>"/>
							<?							
							}
						}
	
					}
			    ?>
			    
			</div>
			
			<div style=" margin-top: 10px">			   
			    <a href=# id=next3><img src="<?=base_url()?>img/grey-down-arrow.png" alt=""/></a>
			</div>
			
    		<div style="display: none" class="cycle-pager" id=pager4></div>
    	
    	</div>
        
        <!-- mobile gallery -->
        <div class="col-sm-6 visible-xs">
        	<?php $this->load->view('store/product/gallery_view'); ?>
        </div>
        <!-- mobile gallery -->

    	<div class="col-sm-6 hidden-xs">    		
    		<?php
    		if($product['sale_price'] < $product['price'])
			{
			?>
				<img style="position: absolute; z-index: 9;" src="<?=base_url()?>img/sale-sign.png" />
			<?php
			}
    		?>
            <span id="prod-hero-shot">
            	<?php if(isset($hero['name'])){ ?>
            	<a href="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>" class="MagicZoom" rel="zoom-position: inner">
                    <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$hero['name']?>"/>
                </a>
                <?php } ?>
            </span>

    		
    		<div class="body-copy-Font" id="hover-zoom">
    			Hover To Zoom
    		</div>
    	</div>
    	<div class="col-sm-5 push product push-text product-detail-view">
    		<div style="font-size: 16px; font-weight: 700">
    			<?php
    			$title = explode('-',$product['title']);
				$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
				$normal_price = number_format($product['price'] * $cur_val,2);
				$sale_price = number_format($product['sale_price'] * $cur_val,2);
				$normal_price_arr = explode('.',$normal_price);
				$sale_price_arr = explode('.',$sale_price);
				
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
                
               
               <div class="product-info <?=$on_sale;?>">
                    <h3>
						<?=$product['title'];?>
                    	<div class="yotpo bottomLine"
                            data-appkey="87cmugsJWWCvn4YdAy3U9AcGnlYiUwvpv1TKwE5Z"
                            data-domain="bared.com.au"
                            data-product-id="<?=$product['review_category']?>"
                            data-product-models="<?=$product['title']?>"
                            data-name="<?=$product['title']?> <?=$product['short_desc']?>"
                            data-url="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>"
                            data-image-url="The product image url. Url escaped"
                            data-description="<?=$product['long_desc']?>"
                            data-bread-crumbs="Product categories"
                            data-images-star_empty="<?=base_url()?>img/star_empty.png"
                            data-images-star_half="<?=base_url()?>img/star_half.png"
                            data-images-star_full="<?=base_url()?>img/star_full.png">                                                                            
                       </div>
                    </h3> 
                    
                    <h4><?=$product['short_desc'];?></h4>
                    <h4><span class="currency"><?=$sign?></span> 
                      <span class="price">
                          <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                          <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                      </span>
                    </h4>
                </div>
    			
    		</div>
            <?php if(0){ ?>
            
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

    		
    			
    		</div>
            
            <?php } ?>
            <div style="height: 15px;"></div>
    		<div style="border-top:1px solid #d9d9d9;"></div>
    		
    		<div style="height: 5px;"></div>
            <? $other = $this->Product_model->get_other_product_same_cat($product['title'],$product['id'],$product['short_desc']); 
			
					if(count($other)>0){
				?>
    		
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
            <div style="height: 5px;"></div>
            <div style="border-top:1px solid #d9d9d9;"></div>
            <div style="height: 15px;"></div>
            <!--<div class="product-header-info-Font product-header-info">Descriptions</div>-->
            

            
            <div class="accordion" id="accordion-product">
				<div class="accordion-group" style="border-top:none!important;">
					<div class="accordion-heading product-header-info-Font product-header-info" style="border-bottom:1px solid #ccc;">
						<a style="text-decoration:none;" onclick="active(1);" class="accordion-toggle left-side accordion-active" id="accordion-headtitle1" data-toggle="collapse" data-parent="#accordion-product" href="#collapseOne">
							Description
						</a>
						<a onclick="active(1);" class="accordion-toggle right-side accordion-active" id="accordion-headsign1" data-toggle="collapse" data-parent="#accordion-product" href="#collapseOne">
							<div id="sign-active1">
								<i class="icon icon-check-minus" style="font-size:14px;"></i>
							</div>
							<div id="sign-inactive1" style="display: none;font-size:14px;">
								<i class="icon icon-plus-sign-alt" style="font-size:14px;"></i>
							</div>
							
						</a>
						<div style="clear: both"></div>
					</div>
					<div id="collapseOne" class="accordion-body collapse in">
						<div class="accordion-inner" style="padding-left:0px!important;">							
							<div class="left-side accordion-desc product-info-Font product-info"><?=$product['long_desc']?></div>
							<div class="cleardiv accordion-desc-gap"></div>							
							<div style="clear: both"></div>
						</div>
					</div>
				</div>    
                <div class="accordion-group"  style="border-top:none!important;">
					<div class="accordion-heading product-header-info-Font product-header-info" style="border-bottom:1px solid #ccc;">
						<a style="text-decoration:none;" onclick="active(2);" class="accordion-toggle left-side collapsed" id="accordion-headtitle2" data-toggle="collapse" data-parent="#accordion-product" href="#collapseTwo">
							Features
						</a>
						<a onclick="active(2);" class="accordion-toggle right-side collapsed" id="accordion-headsign2" data-toggle="collapse" data-parent="#accordion-product" href="#collapseTwo">
							<div id="sign-active2" style="display: none">
								<i class="icon icon-check-minus" style="font-size:14px;"></i>
							</div>
							<div id="sign-inactive2">
								<i class="icon icon-plus-sign-alt" style="font-size:14px;"></i>
							</div>
							
						</a>
						<div style="clear: both"></div>
					</div>
					<div id="collapseTwo" class="accordion-body collapse" style="height:0px;">
						<div class="accordion-inner" style="padding-left:0px!important;">							
							<div class="left-side accordion-desc product-info-Font product-info">
								<ul>
								<?php
								$feats = $product['features'];
								/*
								$feats = explode(';', $feats);
								echo "<ul style= 'list-style-type: circle !important;'>";
								foreach($feats as $f)
								{
									echo "<li>";
									echo $f;
									echo "</li>";
								}
								echo "</ul>";
								*/
								echo $feats;
                				?>
                                </ul>
                            </div>
							<div class="cleardiv accordion-desc-gap"></div>							
							<div style="clear: both"></div>
						</div>
					</div>
				</div>                            
            
    		
            <div style="height: 10px;clear: both;"></div>
            <? if($product['multiplesize']==1){?>
            <div class="product-header-info-Font product-header-info" style="float:left;">Size</div>
            
            <div class="product-info-Font product-info" style="float:right;">
                <?php $multiple_stock = json_decode($product['size'],true);?>
                <!-- Please change as well in cart page-->
                <select class="product-size form-control" name="sizeproduct" id="sizeproduct"  >
                	<option value="--">Please Select</option>
					<?php if($multiple_stock['34eu']>0){?><option value="34eu">34 EU</option><?php }?>
                    <?php if($multiple_stock['35eu']>0){?><option value="35eu">35 EU</option><?php }?>
                    <?php if($multiple_stock['36eu']>0){?><option value="36eu">36 EU</option><?php }?>
                    <?php if($multiple_stock['37eu']>0){?><option value="37eu">37 EU</option><?php }?>
                    <?php if($multiple_stock['38eu']>0){?><option value="38eu">38 EU</option><?php }?>
                    <?php if($multiple_stock['39eu']>0){?><option value="39eu">39 EU</option><?php }?>
                    <?php if($multiple_stock['40eu']>0){?><option value="40eu">40 EU</option><?php }?>
                    <?php if($multiple_stock['41eu']>0){?><option value="41eu">41 EU</option><?php }?>
                    <?php if($multiple_stock['42eu']>0){?><option value="42eu">42 EU</option><?php }?>
                    <?php if($multiple_stock['43eu']>0){?><option value="43eu">43 EU</option><?php }?>
                    <?php if($multiple_stock['44eu']>0){?><option value="44eu">44 EU</option><?php }?>
                    <?php if($multiple_stock['45eu']>0){?><option value="45eu">45 EU</option><?php }?>
                    <?php if($multiple_stock['46eu']>0){?><option value="46eu">46 EU</option><?php }?>
                    <?php if($multiple_stock['47eu']>0){?><option value="47eu">47 EU</option><?php }?>
                    <?php if($multiple_stock['48eu']>0){?><option value="48eu">48 EU</option><?php }?>
                    <?php if($multiple_stock['5us']>0){?><option value="5us">5 US</option><?php }?>
                    <?php if($multiple_stock['6us']>0){?><option value="6us">6 US</option><?php }?>
                    <?php if($multiple_stock['65us']>0){?><option value="65us">6.5 US</option><?php }?>
                    <?php if($multiple_stock['7us']>0){?><option value="7us">7 US</option><?php }?>
                    <?php if($multiple_stock['75us']>0){?><option value="75us">7.5 US</option><?php }?>
                    <?php if($multiple_stock['8us']>0){?><option value="8us">8 US</option><?php }?>
                    <?php if($multiple_stock['85us']>0){?><option value="85us">8.5 US</option><?php }?>
                    <?php if($multiple_stock['9us']>0){?><option value="9us">9 US</option><?php }?>
                    <?php if($multiple_stock['95us']>0){?><option value="95us">9.5 US</option><?php }?>
                    <?php if($multiple_stock['10us']>0){?><option value="10us">10 US</option><?php }?>
                    <?php if($multiple_stock['105us']>0){?><option value="105us">10.5 US</option><?php }?>
                    <?php if($multiple_stock['11us']>0){?><option value="11us">11 US</option><?php }?>
                    <?php if($multiple_stock['12us']>0){?><option value="12us">12 US</option><?php }?>
                    <?php if($multiple_stock['13us']>0){?><option value="13us">13 US</option><?php }?>
                </select>
                
                <!--
                Dimension: <?=$product['dimension']?><br/>
                <?php
                if($product['length'] != '0')
                {
                ?>
                    Handle Length: <?=$product['length']?><br/>
                <?
                }
                ?>
                
                <?php
                if($product['show_weight'])
                {
                ?>
                    Weight: <?=$product['weight']?> Kg
                <?
                }
                ?>
                -->
                
            </div>
            <div style="height: 0px;clear: both;"></div>
            <div class="product-info-Font product-info" style="float:left;"><a href="<?=base_url()?>store/page/39">What size am I?</a></div>
            <? } ?>
            <div style="height: 20px;clear: both;"></div>
            
            
            
            
            
				<div class="accordion-group" style="border-top:none!important;">
					<div class="accordion-heading product-header-info-Font product-header-info" style="border-bottom:1px solid #ccc;">
						<a style="text-decoration:none;" onclick="active(3);" class="accordion-toggle left-side collapsed" id="accordion-headtitle3" data-toggle="collapse" data-parent="#accordion-product" href="#collapseReview">
							Ratings
						</a>
						<a onclick="active(3);" class="accordion-toggle right-side collapsed" id="accordion-headsign3" data-toggle="collapse" data-parent="#accordion-product" href="#collapseReview">
							<div id="sign-active3" style="display: none;font-size:14px;">
								<i class="icon icon-check-minus" style="font-size:14px;"></i>
							</div>
							<div id="sign-inactive3" style="font-size:14px;">
								<i class="icon icon-plus-sign-alt" style="font-size:14px;"></i>
							</div>
							
						</a>
						<div style="clear: both"></div>
					</div>
					<div id="collapseReview" class="accordion-body collapse">
						<div class="accordion-inner" style="padding-left:0px!important;">							
							<div class="left-side accordion-desc product-info-Font product-info" style="width:104%;">
                            	<div class="yotpo reviews"
                                    data-appkey="87cmugsJWWCvn4YdAy3U9AcGnlYiUwvpv1TKwE5Z"
                                    data-domain="bared.com.au"
                                    data-product-id="<?=$product['review_category']?>"
                                    data-product-models="<?=$product['title']?>"
                                    data-name="<?=$product['title']?> <?=$product['short_desc']?>"
                                    data-url="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>"
                                    data-image-url="The product image url. Url escaped"
                                    data-description="<?=$product['long_desc']?>"
                                    data-bread-crumbs="Product categories"
                                    data-images-star_empty="<?=base_url()?>img/star_empty.png"
                                    data-images-star_half="<?=base_url()?>img/star_half.png"
    								data-images-star_full="<?=base_url()?>img/star_full.png">                                    
                                </div>
                            </div>
							<div class="cleardiv accordion-desc-gap"></div>							
							<div style="clear: both"></div>
						</div>
					</div>
				</div>    
                
            </div>
            
            
            
            <div style="height: 0px;clear: both;"></div>
            <div class="product-info-Font product-info" style="float:right;"></div>
            <div style="clear:both; height: 10px;"></div>
            <div style="height: 15px;clear: both;"></div>
            <button class="button-Font button_primary button_size_full" onclick="addtocart();">Add To Shopping Bag</button>
    		<div style="height: 5px;"></div>
    		<button class="button-Font button_secondary button_size_full" onclick="add_towishlist();">Add To Wish List</button>    		
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
                <i onclick="$('#emailModal').modal('show');"  style="cursor: pointer; margin-right: 0px; font-size: 22px;color: grey;" class="fa fa-envelope"></i>					
                
                
                
                <div style="clear: both"></div>
			</div>   
             
    		
    	</div>
    </div>
   
    <div class="app-container relative bar social col-xs-12 x-gutters">
        <div class="segment hidden-xs"><hr></div>
        <div class="segment">
            <h2>you may also like</h2>
        </div>
        <div class="segment hidden-xs"><hr></div>
    </div>
    <?php 
		$this->load->view('common/products/featured_products',array('feature_products' => $cross_sale)); 
	?>
  
    
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          	  <div class="modal-header x-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
          	<div class="modal-body mybody-modal">
                <form method="post" action="<?=base_url()?>store/send_friend_email">
					<input type="hidden" name="prod_id" value="<?=$product['id']?>">
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
                </form>
            </div>
         
        </div>
      </div>
    </div>
    
    <script>
   
    
    
    
    
    $( document ).ready(function() {
		console.log( "ready!" );
		$('.cycle-carousel-wrap').css('top','-255px');
	});
   	</script>
    
    <!-- Menu for phone mode -->
    
    
    <script>
	
	function load_image(path)
	{
		//console.log(path);
		var new_image = '<a href="'+ path + '" class="MagicZoom" rel="zoom-position: inner"><img src="' + path + '"/></a>';	
		$('#prod-hero-shot').html(new_image);
		MagicZoom.start();
	}
	
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
    
    <style>
		.MagicZoomHint{
			display:none!important;
		}
		
		.yotpo, .yotpo div, .yotpo span, .yotpo p, .yotpo a, .yotpo img, .yotpo i, .yotpo strong, .yotpo sup, .yotpo ul, .yotpo li, .yotpo form, .yotpo label {
			font-family: 'Lato', sans-serif!important;
			letter-spacing:0.4pt!important;
			color:#000!important;
		}
		.yotpo .yoBottom, .yotpo .yoQuestionsBottom, .yotpo-testimonails .yoBottom, .yotpo-testimonails .yoQuestionsBottom {
			float:left!important;
		}
		.number_results{
			display:none!important;
		}
		.yotpo .yoNumber_like .yoLiking, .yotpo .yoLike:hover, .yotpo-testimonails .yoNumber_like .yoLiking, .yotpo-testimonails .yoLike:hover {
    		background: url("https://bared.com.au/img/vote_like.png") no-repeat scroll right top rgba(0, 0, 0, 0);
		}
		.yotpo .yoNumber_unlike .yoUnliking, .yotpo .yoUnlike:hover, .yotpo-testimonails .yoNumber_unlike .yoUnliking, .yotpo-testimonails .yoUnlike:hover {
    		background: url("https://bared.com.au/img/vote_unlike.png") no-repeat scroll right top rgba(0, 0, 0, 0);
		}
		.yotpo .yoForm, .yotpo-testimonails .yoForm {
			color:#000!important;
		}
	</style>   