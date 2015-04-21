<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bared Footwear</title>


<?php if(ENVIRONMENT == 'development'){ ?>

<link rel="stylesheet" href="<?=base_url() . ASSETS;?>bootstrap-3.2.2/css/bootstrap.min.css">
<!-- FA -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>font-awesome-4.3.0/css/font-awesome.min.css">
<?php }else{ ?>
    <!-- BS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- FA -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<?php } ?>


<!-- app css -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>css/app.css">


<!-- Load Scripts -->

<?php if(ENVIRONMENT == 'development'){ ?>
<!-- jQuery -->
<script src="<?=base_url() . ASSETS;?>js/jquery-1.11.2.min.js"></script>
<!-- BSJS-->
<script src="<?=base_url() . ASSETS;?>bootstrap-3.2.2/js/bootstrap.min.js"></script>

<?php }else{ ?>  
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- BSJS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<?php } ?>
<!-- jquery touch -->
<script type="text/javascript" src="<?=base_url() . ASSETS;?>js/jquery.mobile.custom.min.js"></script>
<!--app js-->
<script type="text/javascript" src="<?=base_url() . ASSETS;?>js/app/app.js"></script>


</head>

<body>

<header>
	<div id="header" class="app-container">
        <div class="col-md-5 hdr-block lt">
        	<span class="h6 block">
            	<span class="fw-700 block">Free Shipping</span>
            	Australia wide on order voer $150!
            </span>
            
            
            <div class="form-group has-feedback col-xs-5 x-gutters">
              <input type="text" class="form-control app-form-control" id="search-product" placeholder="Search Products...">
              <span class="form-control-feedback pointer"><i class="fa fa-search"></i></span>
            </div>
        </div>
        
        <div class="col-md-2 logo-wrap">
            <img src="<?=base_url() . ASSETS;?>img/bared-logo.png" alt="bared-logo.png" title="Bared Footwear Logo">
        </div>
        
        <div class="col-md-5 hdr-block rt">
        	<span class="h6 fw-700 block acc-access"><i class="fa fa-unlock-alt"></i> <a class="app-link" href="#">Register</a> / <a class="app-link" href="#">Login</a></span>
            
            <ul class="acc-info h6">
                <li><i class="fa fa-heart"></i> Wish List <span class="badge app-badge wish-list">19</span></li>
                <li><i class="fa fa-shopping-cart"></i> Shopping Cart <span class="badge app-badge shopping-cart-items">2</span></li>
            </ul>
        </div>
    </div>
</header> 

<nav>
	<div id="top-nav" class="app-container">
    	<ul class="nav navbar-nav">
        	<li><a href="#">new arrivals</a></li>
            <li><a href="#">women's</a></li>
            <li><a href="#">men's</a></li>
            <li><a href="#">sale</a></li>
            <li><a href="#">why bared?</a></li>
            <li><a href="#">gallery</a></li>
            <li><a href="#">press</a></li>
            <li><a href="#">contact us</a></li>
        </ul>
    </div>
</nav>

<div id="banners" class="app-container carousel slide" data-ride="carousel">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <div class="item active">
              <a href="#">
                  <img src="<?=base_url() . ASSETS;?>img/dummy/banner2.jpg" />
                  <div class="carousel-caption visible-xs">
                      <h3>Mobile Caption</h3>
                  </div>
              </a>
          </div>
          
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#banners" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#banners" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>

<div class="app-container tiles br-top">
	<?php 
		$btn = array('shop new','MICAH GIANELLI’S TOP PICKS','SUMMER CMPAIGN OUT NOW');
		$caption = array("'parrot' monk - in navy", "micah gianelli hot pring", "summer flip flops");
		for($i = 1; $i < 4; $i++){
	?>
	<div class="col-md-4 tile">
    	<img src="<?=base_url() . ASSETS;?>img/dummy/tile<?=$i;?>.jpg">
        <div class="tile-btn-wrap"><button class="btn-tile"><?=$btn[$i-1];?></button></div>
        <div class="caption">
        	<h3><?=$caption[$i-1];?></h3>
        </div>
    </div>
    <?php } ?> 
</div>
<div class="app-container relative bar bg-black text-white"><h3>our latest range</h3></div>
<div id="featured" class="app-container br-top carousel slide multi-carousel featured" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php for($i = 1;$i < 7; $i++){ ?>
          <div class="item <?=$i == 1 ? 'active' : '';?>">
              <a href="#">
              <div class="col-md-2 product">
                  <img src="<?=base_url() . ASSETS;?>img/dummy/feature<?=$i;?>.jpg" />
                  <div class="carousel-caption product-info <?=$i == 3 ? ' on-sale' : '';?>">
                      <h3>Kiwi 2</h3>
                      <h4>Back & Patent</h4>
                      <h4>au 
                      	<span class="price">
                      		<span class="normal-price">$229.<sub>00</sub></span>
                            <span class="sale-price">$179.<sub>00</sub></span>
                        </span>
                      </h4>
                  </div>
              </div>
              </a>
          </div>
          <?php } ?>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#featured" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>

<div class="app-container relative bar social col-xs-12 x-gutters">
	<div class="segment"><hr></div>
	<div class="segment">
        <h2>use #baredfootwear <i class="fa fa-instagram"></i></h2>
        <h4>to show us how your wear bared on instagram</h4>
    </div>
    <div class="segment"><hr></div>
</div>

<div id="instagram" class="app-container br-top carousel slide multi-carousel gallery" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php for($i = 1;$i < 7; $i++){ ?>
          <div class="item <?=$i == 1 ? 'active' : '';?>">
              <a href="#" data-toggle="modal" data-target="#myModal">
              <div class="col-md-2">
                  <img src="<?=base_url() . ASSETS;?>img/dummy/instagram<?=$i;?>.jpg" />
              </div>
              </a>
          </div>
          <?php } ?>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#instagram" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#instagram" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>


<div class="modal fade app-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        	<div class="col-md-8 x-gutters left">
            	<img src="<?=base_url() . ASSETS;?>img/dummy/instagram-featured.jpg">
            </div>
            <div class="col-md-4 x-gutters right">
            	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 
                 <div class="product">
                 	<img src="<?=base_url() . ASSETS;?>img/dummy/instagram-featured-thumb.jpg">
                    <div class="product-info">
                        <h3>starling</h3>
                        <h4>gold leopard calf hair smoking loafer</h4>
                        <h4>au 
                            <span class="price">
                                <span class="normal-price">$229.<sub>00</sub></span>
                                <span class="sale-price">$179.<sub>00</sub></span>
                            </span>
                        </h4>
                        <span class="raiting">
                        	<i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star off"></i>
                        </span>
                    </div>
                    
                    <button class="btn btn-app">buy now</button>
                 </div>
            </div>
      </div>
    </div>
  </div>
</div>


<footer>
	<div id="footer" class="app-container">
        <div class="container">
            <div id="goto-top"><i class="fa fa-angle-up"></i></div>
            
            	<h5>join us on</h5>
                <ul class="social-links">
                    <li><a href="<?=PINTEREST;?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                    <li><a href="<?=FACEBOOK;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="<?=INSTAGRAM;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                </ul>
                
                <div class="subscribe-box">
                    <h5>subscribe to our vip mailing list</h5>
                    <div class="form-group has-feedback col-xs-5 x-gutters">
                      <input type="text" class="form-control app-form-control" id="subscribe" placeholder="your email...">
                      <span class="form-control-feedback pointer"><i class="fa fa-envelope"></i></span>
                    </div>
                </div>
                
                <hr>
                
                <div class="col-md-4">
                    <ul class="quick-links">
        				<li><h5>customer care</h5></li>
                        <li><a href="#">shipping information</a></li>
                        <li><a href="#">return &amp; exchanges</a></li>
                        <li><a href="#">payment security</a></li>
                        <li><a href="#">faq</a></li>
                        <li><a href="#">shoe care instructions</a></li>
                        <li><a href="#">promotion t&amp;c's</a></li>
                        <li><a href="#">competitions</a></li>
                    </ul>   
                </div>
                <div class="col-md-4">
                    <ul class="quick-links">
        				<li><h5>fitting options</h5></li>
                        <li><a href="#">fitting options</a></li>
                        <li><a href="#">orthotics</a></li>
                        <li><a href="#">wide feet</a></li>
                        <li><a href="#">narrow feet</a></li>
                        <li><a href="#">orthotic friendly shoes</a></li>
                        <li><a href="#">size chart</a></li>
                    </ul>   
                </div>
                <div class="col-md-4">
                    <ul class="quick-links">
        				<li><h5>your account</h5></li>
                        <li><a href="#">login</a></li>
                        <li><a href="#">shopping basket</a></li>
                        <li><a href="#">wish list</a></li>
                    </ul>  
                </div>
                
                <hr>
                
                <p class="disclaimer">
                    &copy; BARED PTY LTD,ABN 76 843 320 186 (Bared Trading Trust Owns & Operates The Website) 	<br>
                    1098 HIGH STREET ARMADALE VIC 3143 AUSTRALIA
                </p>   
        </div>
    </div>
</footer>
<script>
$(function(){
	$('.carousel[data-type="multi"] .item').each(function(){
	  var next = $(this).next();
	  if (!next.length) {
		next = $(this).siblings(':first');
	  }
	  next.children(':first-child').clone().appendTo($(this));
	  
	  for (var i=0;i<4;i++) {
		next=next.next();
		if (!next.length) {
			next = $(this).siblings(':first');
		}
		
		next.children(':first-child').clone().appendTo($(this));
	  }
	});
});	
</script>




