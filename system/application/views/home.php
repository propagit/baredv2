<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bared Footwear</title>

<link rel="stylesheet" href="<?=base_url() . ASSETS;?>bootstrap-3.2.2/css/bootstrap.min.css">
<!-- FA -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>font-awesome-4.3.0/css/font-awesome.min.css">
<!-- app css -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>css/app.css">
<!-- landing css -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>css/home.css">

<!-- Load Scripts -->
<!-- jQuery -->
<script src="<?=base_url() . ASSETS;?>js/jquery-1.11.2.min.js"></script>
<!-- BSJS-->
<script src="<?=base_url() . ASSETS;?>bootstrap-3.2.2/js/bootstrap.min.js"></script>
<!-- jquery touch -->
<script type="text/javascript" src="<?=base_url() . ASSETS;?>js/jquery.mobile.custom.min.js"></script>
<!--app js-->
<script type="text/javascript" src="<?=base_url() . ASSETS;?>js/app/app.js"></script>


</head>

<body>

<header>
	<div id="header" class="app-container">
    	<div class="hidden-xs"><?=$this->load->view('common/desktop_header');?></div>
    	<div class="visible-xs mob-header"><?=$this->load->view('common/mob_header');?></div>
        </div>    
</header> 

<?php $this->load->view('common/nav/main_view'); ?>
      <div class="app-container tiles br-top landing_page">
<?php foreach($landing_pages as $landing_page){ ?>
        <div class="col-lg-6 tile">
            <img src="<?= base_url();?>uploads/landing_page/<?= $landing_page['image_name'];?>"/>
            <div class="tile-btn-wrap">
                <button class="btn-tile"><?= $landing_page['name']; ?></button>
            </div>
        </div> 
<?php } ?>
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
                
                <div class="col-sm-4">
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
                <div class="col-sm-4">
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
                <div class="col-sm-4">
                    <ul class="quick-links">
        				<li><h5>your account</h5></li>
                        <li><a href="#">login</a></li>
                        <li><a href="#">shopping basket</a></li>
                        <li><a href="#">wish list</a></li>
                    </ul>  
                </div>
                
                <hr>
                <div class="col-sm-12">
                    <p class="disclaimer">
                        &copy; BARED PTY LTD,ABN 76 843 320 186 (Bared Trading Trust Owns & Operates The Website) 	<br>
                        1098 HIGH STREET ARMADALE VIC 3143 AUSTRALIA
                    </p> 
                </div>  
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




