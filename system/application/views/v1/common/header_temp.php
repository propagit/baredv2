<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="keywords" content="" />

<meta name="description" content="" />

<title>Bared</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/select2.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/zoome-min.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">
<link rel="stylesheet" href="<?=base_url()?>css/magiczoom.css">
<link href="<?=base_url()?>css/font-style.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bared.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bared-footer.css" rel="stylesheet" media="screen">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41974815-1', 'odessa.net.au');
  ga('send', 'pageview');
	
</script>

<script>
function open_window(url) {
	day = new Date();
	id = day.getTime();
	//URL = '<?=base_url()?>admin/new_store/productgallery/' + product_id;
	URL = url;
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=825,height=600,left = 240,top = 125');");
}
</script>


<script>
//Detect browser and write the corresponding name

var new_style = '';
if (navigator.userAgent.search("MSIE") >= 0){
    //alert('"MS Internet Explorer ');
    var position = navigator.userAgent.search("MSIE") + 5;
    var end = navigator.userAgent.search("; Windows");
    var version = navigator.userAgent.substring(position,end);
    if(version < 9)
    {
    	alert(version + '"');
    }
}
else if (navigator.userAgent.search("Chrome") >= 0){
	//alert('"Google Chrome ');// For some reason in the browser identification Chrome contains the word "Safari" so when detecting for Safari you need to include Not Chrome
	
	// new_style += '<style> ';
	// new_style += '.container {margin-top: 30px;} ';
	// new_style += 'body{margin-top:-65px;} ';
	// new_style += 'html{padding-top: 0px ! important;} ';
	// new_style += '</style>';
	
	new_style += '<style> ';
	//new_style += '.lshop{margin-left: 1.0em;} ';
	//new_style += '.lwish{margin-left: 1.8em;} ';
	new_style += '</style>';
	
	document.write(new_style);
    
}
else if (navigator.userAgent.search("Firefox") >= 0){
    //alert('"Mozilla Firefox ');
    
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0){//<< Here
    //alert('"Apple Safari ');
    
    new_style += '<style> ';
	new_style += '#mymenutop8{padding-right: 3px;} ';
	new_style += '#mymenutop18{padding-right: 4px;}';
	new_style += '@media (max-width: 1200px){';
	new_style += '#mymenutop8{width:110px;}';
	new_style += '}';
	new_style += '@media (max-width: 979px){';
	new_style += '#mymenutop18{width:80px;}';
	new_style += '}';
	new_style += '</style>';
	
	document.write(new_style);
}
else if (navigator.userAgent.search("Opera") >= 0){
    //alert('"Opera ');
    
}
else{
    //alert('"Other"');
}
</script>

</head>



<body>
	

	
	

<!-- <fb:login-button show-faces="true" width="200" max-rows="1"></fb:login-button> -->

	
	
	
	
	
	
	
	
	

	<script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<!-- <script src="http://code.jquery.com/jquery-1.7.1.js"    type="text/javascript"></script> -->
	<!-- <script src="http://code.jquery.com/jquery-latest.min.js"    type="text/javascript"></script> -->
	<script src="<?=base_url()?>js/bootstrap.js"></script>
	<script src="<?=base_url()?>js/select2/select2.js"></script>
	<script src="<?=base_url()?>js/zoome.js"></script>
	<script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
	<script src="<?=base_url()?>js/jquery.placeholder.js"></script>
	<script src="<?=base_url()?>js/magiczoom.js"></script>
	
	<script>
	//$.noConflict();
	$j = $.noConflict();
	function change_currency()
	{
		var cur = $('#currency_select').val();
		//alert(cur);
		
		jQuery.ajax({
			url: '<?=base_url()?>store/change_currency/'+cur,
			type: 'POST',
			// data: ({id:id}),
			dataType: "html",
			success: function(html) {
				location.reload(); 
			}
		})	
	}
	
	function change_currency1()
	{
		var cur = $('#currency_select1').val();
		//alert(cur);
		
		jQuery.ajax({
			url: '<?=base_url()?>store/change_currency/'+cur,
			type: 'POST',
			// data: ({id:id}),
			dataType: "html",
			success: function(html) {
				location.reload(); 
			}
		})	
	}
	
	function change_currency2()
	{
		var cur = $('#currency_select2').val();
		//alert(cur);
		
		jQuery.ajax({
			url: '<?=base_url()?>store/change_currency/'+cur,
			type: 'POST',
			// data: ({id:id}),
			dataType: "html",
			success: function(html) {
				location.reload(); 
			}
		})	
	}
	
	
	
	jQuery(document).ready(function() {
	function format(state) {
	    if (!state.id) return state.text; // optgroup
	    return "<img class='flag' src='<?=base_url()?>img/flag/" + state.id.toLowerCase() + ".png'/> " + state.text;
	}
	$j('.limit_tt').tooltip({
			showURL: false
	});
	$j("#currency_select").select2({
		minimumResultsForSearch: '-2',
	    formatResult: format,
	    formatSelection: format,
	    escapeMarkup: function(m) { return m; }
	});
	
	$j("#currency_select1").select2({
		minimumResultsForSearch: '-2',
	    formatResult: format,
	    formatSelection: format,
	    escapeMarkup: function(m) { return m; }
	});
	
	$j("#currency_select2").select2({
		minimumResultsForSearch: '-2',
	    formatResult: format,
	    formatSelection: format,
	    escapeMarkup: function(m) { return m; }
	});
	
	
	
	});
    
	</script>
	<?php
	$count_shopbag	= 0;
		$session_id = $this->session->userdata('session_id');
		
		$count_shopbag = count($this->Cart_model->all($session_id));	
		
		
		$count_wishlist = 0;
		
		$user = $this->session->userdata('userloggedin');
		if($user)
		{
			$count_wishlist = count($this->Cart_model->get_wishlist($user['id']));
			//$count_shopbag = count($this->Cart_model->all_save($user['customer_id']));	
		}
		else 
		{
			//$count_wishlist = 0;
			//$count_shopbag	= 0;
		}
		//$count_wishlist = str_pad($count_wishlist, 2, '0', STR_PAD_LEFT);
		//$count_shopbag = str_pad($count_shopbag, 2, '0', STR_PAD_LEFT);
	?>
	<div class="navbar navbar-fixed-top">

		<div class=" hidden-phone">

			<div class="container visible-desktop">

    			<div class="row-fluid">
        			<div class="span12">
						
                        <div style="height:10px; background:#000; width:100%;"></div>
                    	<div style="height:10px; width:100%;"></div>
						
                        <div style="height: 20px; float:left;" >
                                <select id="currency_select" onchange="change_currency()">
                                    <option <?php if($sign == '<span style="font-size:12px">AU</span> $') {echo 'selected="selected"';}?> value="aud">AUD</option>
                                    <option <?php if($sign == '<span style="font-size:12px">US</span> $') {echo 'selected="selected"';}?> value="usa">USA</option>
                                    <option <?php if($sign == '<span style="font-size:12px">€UR</span>') {echo 'selected="selected"';}?> value="eur">EUR</option>
                                    <option <?php if($sign == '<span style="font-size:12px">GB£</span>') {echo 'selected="selected"';}?> value="gbp">GBP</option>
                                    <option <?php if($sign == '<span style="font-size:12px">JP¥</span>') {echo 'selected="selected"';}?> value="jpy">JPY</option>
                                </select>
                        </div>
                        <?php
                        if($this->session->userdata('userloggedin'))
                        {
                        	$user = $this->session->userdata('userloggedin');
                        	if($user=="1"){
								$cust = $this->Customer_model->identify(1);	
								
							}else
							{
								$cust = $this->Customer_model->identify($user['customer_id']);
							}
							
							
							
                        ?>
                        <div style="float: right; height: 20px;">
                        	<?php
                        	if($user['level'] == 1)
							{
							?>
								Welcome, <a style="color:#59595C; font-weight:600;"href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
							<?
							}
							
							else if($user['level'] == 2)
							{
							?>
								Welcome, <a style="color:#59595C; font-weight:600;"href="<?=base_url()?>store/edit_detail_trade/<?=$cust['id']?>"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
							<?
							}
							if($user == 1)
							{
							?>
								Welcome, <a style="color:#59595C; font-weight:600;"href="#"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
							<?
							}
                        	?>
                        	
                        </div>
                        <?php
                        }
                        ?>
                        
                    
                    	<div style="clear:both;"></div>
                        
                        
                        
                        <div  style=" margin:0 auto; width:100%;height:100%; background:url('<?=base_url()?>img/header/Logo.png'); background-position:center;background-repeat:no-repeat; height:176px;">
                        	<div onclick="window.location='<?=base_url()?>'"  class="home-click">
                        		&nbsp;
                        	</div>                            
                            <div style="float:right; margin-top:10px;">
                                <div style="text-align:right;float:right;height:60px;" class="text-opera text-register">
                                    <div style="height:17px;"></div>
                                    <?php
                                    	if($this->session->userdata('userloggedin'))
										{
										?>
										<a href="<?=base_url()?>store/signout" class="text-opera text-register">SIGN OUT</a>
										<?php
										}
										else
										{
										?>
										<a href="<?=base_url()?>store/signin" class="text-opera text-register">SIGN IN</a>
										<?php
										}
                                    ?>
                                    
                                    <div style="height:1px; background-color:#6e7071;"></div>
                                    <a href="<?=base_url()?>store/register" class="text-opera text-register">REGISTER</a>                                    
                                </div>
                                <a href="<?=base_url()?>store/cart">
                                <div style="text-align:center;float:right; margin-right:20px;margin-left:20px;height:40px; background:url('<?=base_url()?>img/header/shopping-bag.png'); background-position:center; background-repeat:no-repeat;" >
                                	<a href="<?=base_url()?>store/cart">
                                		<div class="tot_shopbag " style="color: #4c4c4c; font-family: Buenard; font-weight: 700; font-size: 14px; line-height: 48px; text-align: center; height:45px;width: 70px;">
                                			<?php 
                                				if($count_shopbag >= 0)
												{
													echo $count_shopbag;
												}
                                			?>
                                		</div>
                                	</a>
                                    
                                	<!--<img src="<?=base_url()?>img/header/shopping-bag.png" alt="" />-->
                                	<a href="<?=base_url()?>store/cart"><div class="text-shopping" style="margin-top:-5px;">SHOPPING BAG</div></a>
                                </div>                                
                                	
                                </a>
                              <!--  <div style="position:absolute"><a href="<?=base_url()?>store/cart"><div class="text-shopping">SHOPPING BAG</div></a></div>-->
                                
                                <a href="<?=base_url()?>store/wishlist">
                                <div style="text-align:center;float:right;height:40px; background:url('<?=base_url()?>img/header/wishlist.png'); background-position:center; background-repeat:no-repeat;">
                                	<a href="<?=base_url()?>store/wishlist">
                                		<div class="tot_wishlist " style="color: #4c4c4c; font-family: Buenard; font-weight: 700; font-size: 13px; line-height: 48px; height:45px; text-align: center; width: 45px;">
                                			<?php 
                                				if($count_wishlist >= 0)
												{
													echo $count_wishlist;
												}
                                			?>
                                            
                                		</div>
                                	</a>
                                    
                                    <!--<img src="<?=base_url()?>img/header/wishlist.png" alt="" />-->
                                    <a href="<?=base_url()?>store/wishlist"><div class="text-shopping" style="margin-top:-5px;">WISH LIST</div></a>
                                </div>
                                </a>
                               
                               
                              
                            </div>  
                     			<!--<div style="width:50px;float:left;"><a href="<?=base_url()?>store/wishlist"><div class="text-shopping">WISH LIST</div></a></div>
							   <div style="width:80px;float:left;"><a href="<?=base_url()?>store/cart"><div class="text-shopping">SHOPPING BAG</div></a></div>-->
                        </div>
                    
                    	<div style="clear:both;"></div>

                        <div style="margin-top: 10px">	
                            					                       
                            <div style="float:right; margin-top:-30px; height: 40px;">
                            <form style="margin-bottom: 10px;" method="post" action="<?=base_url()?>store/search">
                            	<!-- <div style="cursor:pointer; float: right; width: 30px; height: 30px; background: #A5A7AA; color: #fff; font-size: 24px; line-height: 34px; text-align: center">
									<i class="icon-search "></i>
								</div>
                                <input type="text" placeholder="Looking for something?" name="keyword"> -->
                                    <div class="input-append" style="margin-top: 5px">
									    <input style="width: 170px; border-radius: 0px" class="span2 inputp" id="appendedInputButton" type="text" placeholder="Looking for something?" name="keyword">
									    <button style="border-radius: 0px; height: 30px; width:32px; background: url('<?=base_url()?>img/search-button.png')" class="btn btn-info" type="submit"></button>
								    </div>
                            </form>
                            </div>
                        </div>    
                    	<div style="clear:both;"></div>
        			</div>					
    			</div>
				<div style="clear:both;"></div>
				<div style="height:2px; background:#fff "></div>       
    			<div class="line_top_new">&nbsp;</div>        

				<div class="row">

					<div class="span12">

						<div class="mymenutop mymenutop_mpadding" id="mymenutop1">

							<a href="<?=base_url()?>store/product/New-Arrivals/all" class="menu-text">New Arrivals</a>
							
						</div>

						<div class="mymenutop mymenutop_mpadding" id="mymenutop2">

							<a href="#" class="menu-text"> Handbags </a>
							<div id="menutop-child2" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(2);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>		
                                    		<?php
                                    		if($catid==9)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Handbags/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Handbags/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>							    
                                        		
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
										else
										{ 
											if($ct['external_link']!='')
											{
										
												?><a class="menu-a" href="<?=$ct['external_link']?>"><?=$ct['title']?></a><br/><?
											}
											else
											{
												$pages = $this->Menu_model->getpage($ct['id_page']);
												if($pages['display']==0){
												?><a  style="color:#59595C;" href="<?=base_url()?>store/page/<?=$ct['id_page']?>"><?=$ct['title']?></a><br/><? } else {
												?>
												<a style="color:#59595C;cursor:pointer;" onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a><br/>
												<?
												}
											}
									 	}
									}
									/*
									$categories = $this->Product_model->get(2);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Handbags/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}*/
								?>
								
							</div>
						</div>

						<div class="mymenutop mymenutop_mpadding" id="mymenutop3">
							
							<a href="#" class="menu-text"> Wallets </a>
							<div id="menutop-child3" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									/*$categories = $this->Product_model->get(3);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}*/
									$categories = $this->Category_model->get(3);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>	
                                    		<?php
                                    		if($catid==21)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Wallets/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Wallets/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>									    
                                        		<!-- <a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/> -->
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
									}
								?>
							</div>
						</div>

						<div class="mymenutop mymenutop_mpadding" id="mymenutop4">

							
							<a href="#" class="menu-text"> Travel </a>
							<div id="menutop-child4" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									/*
									$categories = $this->Product_model->get(4);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Travel/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}*/
									$categories = $this->Category_model->get(4);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>	
                                    		<?php
                                    		if($catid==29)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Travel/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Travel/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>									    
                                        		<!-- <a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/> -->
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
									}
								?>
							</div>
						</div>

						<div class="mymenutop mymenutop_mpadding" id="mymenutop5">
							<a href="#" class="menu-text"> Accessories </a>
							
							<div id="menutop-child5" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									/*
									$categories = $this->Product_model->get(5);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Accessories/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}
									*/
									$categories = $this->Category_model->get(5);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>	
                                    		<?php
                                    		if($catid==35)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Accessories/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Accessories/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>									    
                                        		<!-- <a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/> -->
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
									}
								?>
							</div>
						</div>

						<div class="mymenutop mymenutop_mpadding" id="mymenutop6">

							<a href="#" class="menu-text"> Sale </a>
							<div id="menutop-child6" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(6);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/product/Sale/<?=$ct['name']?>"><?=$ct['title']?></a><br/>
									<?php
									}
								?>
							</div>
						</div>

						<div class="mymenutop mymenutop_mpadding" id="mymenutop7">

							
							<a href="#" class="menu-text"> Stylefile </a>
							<div id="menutop-child7" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(7);
									foreach($categories as $ct)
									{
									?>
										<div id="menu-<?=$ct['id']?>">
                                        	
                                            <? if($ct['id']==50){?>
											<a class="menu-a" href="#"><?=$ct['title']?> </a>
                                            <div style="position:absolute;margin-left:105px;margin-top:-25px;" class="child-menu" id="child-detail">
                                            	<div><i class="icon icon-angle-right icon-2x" style="color:#fff; float:left;"></i>
                                                <a style="margin-left:20px;float:left;line-height:26px;" class="menu-a" href="<?=base_url()?>store/stories_new/latest season">LATEST SEASON</a> </div>
                                                <div><a class="menu-a" href="<?=base_url()?>store/stories_new/luggage" style="margin-left:30px; line-height:21px;">LUGGAGE</a> </div>
                                            </div>
                                            <? }else{?>
                                            <a class="menu-a" href="<?=base_url()?><?=$ct['external_link']?>"><?=$ct['title']?></a>                                        
											<? }?>
                                        </div>
                                        
									<?php
									}
								?>
							</div>
						</div>

						<div class="mymenutop mymenutop_no_mpadding" id="mymenutop8">

							<a href="#" class="menu-text"> News </a>
							<div id="menutop-child8" class="menutop-child child8" >
								<div style="height: 5px; margin-top: -10px; margin-left:-155px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(8);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?><?=$ct['external_link']?>"><?=$ct['title']?></a><br/>
									<?php
									}
								?>
							</div>
						</div>

					</div>

				</div>
				<div class="line_top_new">&nbsp;</div> 

			</div>

			<div class="container visible-tablet">

            	<div style="margin-left: auto; margin-right: auto; width: 724px;">

        			
                    <div class="row">
        			<div class="span12">
						<div style="height:10px; background:#000; width:100%;"></div>
                    	<div style="height:10px; width:100%;"></div>

                        <div style="height: 20px; float:left;" >
                                <select style="font-weight:400!important; font-size: 14px; height: 20px; line-height: 20px;" id="currency_select1" onchange="change_currency1()">
                                    <option <?php if($sign == '<span style="font-size:12px">AU</span> $') {echo 'selected="selected"';}?> value="aud">AUD</option>
                                    <option <?php if($sign == '<span style="font-size:12px">US</span> $') {echo 'selected="selected"';}?> value="usa">USA</option>
                                    <option <?php if($sign == '<span style="font-size:12px">€UR</span>') {echo 'selected="selected"';}?> value="eur">EUR</option>
                                    <option <?php if($sign == '<span style="font-size:12px">GB£</span>') {echo 'selected="selected"';}?> value="gbp">GBP</option>
                                    <option <?php if($sign == '<span style="font-size:12px">JP¥</span>') {echo 'selected="selected"';}?> value="jpy">JPY</option>
                                </select>
                        </div>
                        <?php
                        if($this->session->userdata('userloggedin'))
                        {
                        	$user = $this->session->userdata('userloggedin');
							if($user==1){$cust = $this->Customer_model->identify(1);}
							else{
                        		$cust = $this->Customer_model->identify($user['customer_id']);
							}
                        ?>
                        <div style="float: right; height: 20px;">
                        	Welcome, <a style="color:#59595C; font-weight:600;" href="#"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
                        </div>
                        <?php
                        }
                        ?>
                    
                    	<div style="clear:both;"></div>
                        <div style="margin:-22px 0 auto; width:100%;height:100%; background:url('<?=base_url()?>img/header/Logo.png'); background-size:38%; background-position:center;background-repeat:no-repeat; height:90px;">
                            <!--<a href="<?=base_url()?>"><img src="<?=base_url()?>img/header/Logo.png" alt="" style="margin:0 auto;"/></a>-->
                            <div onclick="window.location='<?=base_url()?>'"   style="height: 84px; margin-left: 210px; position: absolute; width: 305px; cursor:pointer;">
                        		&nbsp;
                        	</div> 
                            <div style="float:right; margin-top:10px;">
                                <div style="text-align:right;float:right;height:60px;" class="text-opera text-register2">
                                    <div style="height:17px;"></div>
                                    <?php
                                    	if($this->session->userdata('userloggedin'))
										{
										?>
										<a href="<?=base_url()?>store/signout" class="text-opera text-register">SIGN OUT</a>
										<?php
										}
										else
										{
										?>
										<a href="<?=base_url()?>store/signin" class="text-opera text-register">SIGN IN</a>
										<?php
										}
                                    ?>
                                    <!-- <a href="<?=base_url()?>store/cart" class="text-opera text-register">SIGN IN</a> -->
                                    <div style="height:1px; background-color:#6e7071;"></div>
                                    <a href="<?=base_url()?>store/cart" class="text-opera text-register">REGISTER</a>
                                </div>
                                <!--
                                <div style="text-align:center;float:right; margin-right:10px;margin-left:10px;height:60px; margin-top: 8px;">
                                <a href="<?=base_url()?>store/cart">
                                	<div class="tot_shopbag lshop" style="color: #4c4c4c; font-family: Buenard; font-weight: 700; font-size: 11px; line-height: 37px; position: absolute; text-align: center; width: 19px;">
                                		<?php 
                            				if($count_shopbag >= 0)
											{
												echo $count_shopbag;
											}
                            			?>
                                	</div>
                                </a>
                                <img src="<?=base_url()?>img/header/sshopping-bag.png" alt="" />
                                <div class="text-shopping2">SHOPPING BAG</div>
                                </div>
                                -->
                                <a href="<?=base_url()?>store/cart">
                                <div style="text-align:center;float:right; margin-right:20px;margin-left:20px;height:40px; background:url('<?=base_url()?>img/header/shopping-bag.png'); background-position:center; background-repeat:no-repeat;" >
                                	<a href="<?=base_url()?>store/cart">
                                		<div class="tot_shopbag " style="color: #4c4c4c; font-family: Buenard; font-weight: 700; font-size: 14px; line-height: 48px; text-align: center; height:45px;width: 70px;">
                                			<?php 
                                				if($count_shopbag >= 0)
												{
													echo $count_shopbag;
												}
                                			?>
                                		</div>
                                	</a>
                                    
                                	<!--<img src="<?=base_url()?>img/header/shopping-bag.png" alt="" />-->
                                	<a href="<?=base_url()?>store/cart"><div class="text-shopping" style="margin-top:-5px;">SHOPPING BAG</div></a>
                                </div>        
                                </a>                        
                                <!--
                                <div style="text-align:center;float:right;height:60px; margin-top: 8px">
                                	<a href="#">
                                		<div class="tot_wishlist lwish" style="color: #4c4c4c; font-family: Buenard; font-weight: 700; font-size: 11px; line-height: 37px; position: absolute; text-align: center; width: 19px;">
                                			<?php 
	                            				if($count_wishlist >= 0)
												{
													echo $count_wishlist;
												}
	                            			?>
                                			
                                		</div>
                                	</a>
                                    <img src="<?=base_url()?>img/header/swishlist.png" alt="" />
                                    <div class="text-shopping2">WISH LIST</div>
                                </div>
                                -->
                                <a href="<?=base_url()?>store/wishlist">
                                <div style="text-align:center;float:right;height:40px; background:url('<?=base_url()?>img/header/wishlist.png'); background-position:center; background-repeat:no-repeat;">
                                	<a href="<?=base_url()?>store/wishlist">
                                		<div class="tot_wishlist " style="color: #4c4c4c; font-family: Buenard; font-weight: 700; font-size: 13px; line-height: 48px; height:45px; text-align: center; width: 45px;">
                                			<?php 
                                				if($count_wishlist >= 0)
												{
													echo $count_wishlist;
												}
                                			?>
                                            
                                		</div>
                                	</a>
                                    
                                    <!--<img src="<?=base_url()?>img/header/wishlist.png" alt="" />-->
                                    <a href="<?=base_url()?>store/wishlist"><div class="text-shopping" style="margin-top:-5px;">WISH LIST</div></a>
                                </div>
                                </a>
                            </div>                       
                        </div>
                    
                    	<div style="clear:both;"></div>

                        <div>	
                            <div class="text-header" style="font-size: 20px"><!--Handbags &bull; Luggage &bull; Accessories--> <img src="<?=base_url()?>/img/header/handbag-luggage-accessories.png" alt="" /></div>						                       
                            <div style="float:right; margin-top:-30px; height: 40px;">
                            <form method="post" action="<?=base_url()?>store/search">
                            	<!-- <input style="width: 145px" type="text" placeholder="Looking for something?" name="keyword"> -->
                            	<div class="input-append" style="margin-top: 5px">
								    <input style="border-radius:0px; width: 120px; font-size: 11px" class="span2 inputp" id="appendedInputButton" type="text" placeholder="Looking for something?" name="keyword">
								    <button style="border-radius:0px; height: 30px; width:32px; background: url('<?=base_url()?>img/search-button.png')" class="btn btn-info" type="submit"></button>
								    <!-- <button style="height: 30px; background-color: #AFABAA; background-image: linear-gradient(to bottom, #AFABAA, #AFABAA);" class="btn btn-info" type="submit"><i class="icon icon-search"></i></button> -->
							    </div>
                            </form>
                            </div>
                        </div>    
                    	<div style="clear:both;"></div>
        			</div>
					<div style="clear:both;"></div>
    			</div>


    			</div>

    			<div  style="height:3px; background:#59595C; margin-left: auto; margin-right: auto; width: 723px; margin-bottom: -1px"></div>     

				<div style="margin-left: auto; margin-right: auto; width: 724px;">

					<div class="mymenutop mymenutop_mpadding">

						<a href="<?=base_url()?>store/product/New-Arrivals/all" class="menu-text">New Arrivals</a>
						
					</div>

					<div class="mymenutop mymenutop_mpadding" id="mymenutop12">

						<a href="#" class="menu-text"> Handbags </a>
						<div id="menutop-child12" class="menutop-child">
							<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 7px;"></div>
							<?php
								//error_reporting(E_ALL);
								$categories = $this->Category_model->get(2);
								foreach($categories as $ct)
								{
								
									if($ct['type']==0){
										$texts=$this->Product_model->get_name_keyword($ct['title']);											
										if($texts){
											$cat = $this->Category_model->identify_by_title($texts['name']);
											if(count($cat)>0)
											{
												$catid = $cat['id'];
											}
											else {
												$catid= '';
											}
                                		?>		
                                		<?php
                                		if($catid==9)
										{
										?>
											<a class="menu-a" href="<?=base_url()?>store/product/Handbags/all"><?=$texts['name']?></a><br/>
										<?
										}
										else 
										{
										?>
											<a class="menu-a" href="<?=base_url()?>store/product/Handbags/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
										<?
										}
                                		?>							    
                                    		
										<? }else{ ?>
                                        <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                        <? } ?>
								<?php }
									else
									{ 
										if($ct['external_link']!='')
										{
									
											?><a class="menu-a" href="<?=$ct['external_link']?>"><?=$ct['title']?></a><br/><?
										}
										else
										{
											?><a class="menu-a" href="<?=base_url()?>store/page/<?=$ct['id_page']?>"><?=$ct['title']?></a><br/><?
										}
								 	}
								}
								/*
								$categories = $this->Product_model->get(2);
								foreach($categories as $ct)
								{
								?>
									<a class="menu-a" href="<?=base_url()?>store/products/Handbags/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
								<?php
								}*/
							?>
							
						</div>

					</div>

					<div class="mymenutop mymenutop_mpadding" id="mymenutop13">

						<a href="#" class="menu-text"> Wallets </a>
						<div id="menutop-child13" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									/*$categories = $this->Product_model->get(3);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}*/
									$categories = $this->Category_model->get(3);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>	
                                    		<?php
                                    		if($catid==21)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Wallets/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Wallets/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>									    
                                        		<!-- <a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/> -->
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
									}
								?>
							</div>

					</div>

					<div class="mymenutop mymenutop_mpadding" id="mymenutop14">

						<a href="#" class="menu-text"> Travel </a>
						<div id="menutop-child14" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									/*
									$categories = $this->Product_model->get(4);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Travel/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}*/
									$categories = $this->Category_model->get(4);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>	
                                    		<?php
                                    		if($catid==29)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Travel/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Travel/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>									    
                                        		<!-- <a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/> -->
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
									}
								?>
							</div>

					</div>

					<div class="mymenutop mymenutop_mpadding" id="mymenutop15">

						<a href="#" class="menu-text"> Accessories </a>
						<div id="menutop-child15" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									/*
									$categories = $this->Product_model->get(5);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="<?=base_url()?>store/products/Accessories/shop_by/<?=$ct['text']?>/<?=$ct['id']?>"><?=$ct['name']?></a><br/>
									<?php
									}
									*/
									$categories = $this->Category_model->get(5);
									foreach($categories as $ct)
									{
									
										if($ct['type']==0){
											$texts=$this->Product_model->get_name_keyword($ct['title']);											
											if($texts){
												$cat = $this->Category_model->identify_by_title($texts['name']);
												if(count($cat)>0)
												{
													$catid = $cat['id'];
												}
												else {
													$catid= '';
												}
                                    		?>	
                                    		<?php
                                    		if($catid==35)
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Accessories/all"><?=$texts['name']?></a><br/>
											<?
											}
											else 
											{
											?>
												<a class="menu-a" href="<?=base_url()?>store/product/Accessories/<?=$ct['name']?>"><?=$texts['name']?></a><br/>
											<?
											}
                                    		?>									    
                                        		<!-- <a class="menu-a" href="<?=base_url()?>store/products/Wallets/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/> -->
											<? }else{ ?>
                                            <a class="menu-a" href="#"><?=$ct['title']?></a><br/>
                                            <? } ?>
									<?php }
									}
								?>
							</div>

					</div>

					<div class="mymenutop mymenutop_mpadding" id="mymenutop16">

						<a href="#" class="menu-text"> Sale </a>
						<div id="menutop-child16" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(6);
									foreach($categories as $ct)
									{
									?>
										<a class="menu-a" href="#"><?=$ct['title']?></a><br/>
									<?php
									}
								?>
							</div>

					</div>

					<div class="mymenutop mymenutop_mpadding" id="mymenutop17">

						<a href="#" class="menu-text"> Stylefile </a>
						
						<div id="menutop-child17" class="menutop-child">
								<div style="height: 5px; margin-top: -10px; margin-left:-10px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(7);
									foreach($categories as $ct)
									{
									?>
										<div id="menu-<?=$ct['id']?>">
                                        	
                                            <? if($ct['id']==50){?>
											<a class="menu-a" href="#"><?=$ct['title']?> </a>
                                            <div style="position:absolute;margin-left:60px;margin-top:-18px;" class="child-menu" id="child-detail">
                                            	<div><i class="icon icon-angle-right icon-2x" style="color:#fff; float:left;"></i>
                                                <a style="margin-left:15px;float:left;line-height:18px;" class="menu-a" href="<?=base_url()?>store/stories_new/latest season">LATEST SEASON</a> </div>
                                                <div><a class="menu-a" href="<?=base_url()?>store/stories_new/luggage" style="margin-left:20px; line-height:18px;">LUGGAGE</a> </div>
                                            </div>
                                            <? }else{?>
                                            <a class="menu-a" href="<?=base_url()?><?=$ct['external_link']?>"><?=$ct['title']?></a>                                        
											<? }?>
                                        </div>
                                        
									<?php
									}
								?>
							</div>

					</div>

					<div class="mymenutop mymenutop_no_mpadding" id="mymenutop18">

						<a href="#" class="menu-text"> News </a>
						<div id="menutop-child18" class="menutop-child child18">
								<div style="height: 5px; margin-top: -10px; margin-left:-155px; background: #fff; margin-bottom: 10px;"></div>
								<?php
									//error_reporting(E_ALL);
									$categories = $this->Category_model->get(8);
									foreach($categories as $ct)
									{
									?>
										<?php
										if($ct['title'] == "What's Happening")
										{
										?>
										
											<a style="line-height: 12px;" class="menu-a" href="<?=base_url()?><?=$ct['external_link']?>"><?=$ct['title']?></a><br/>
										<?
										} 
										else 
										{
										?>
											<a class="menu-a" href="<?=base_url()?><?=$ct['external_link']?>"><?=$ct['title']?></a><br/>
										<?
										}
										?>
										
									<?php
									}
								?>
							</div>

					</div>

				</div>
				

			</div>
			<div class="visible-tablet" style="height:3px; background:#59595C; margin-left: auto; margin-right: auto; width: 723px;"></div>

		</div>

		<div class=" visible-phone" >
			<div class="row-fluid">
				<div class="span12" style="text-align: center; margin-bottom: 20px;">
					<div style="height:10px; background:#000; width:100%;"></div>
					<form method="post" action="<?=base_url()?>store/search">
						<input class="span10" type="text" placeholder="Looking for something" style="display: none;" id="header-search" name="keyword"/>
					</form>
					<a href="<?=base_url()?>"><img style="margin-left: 10%; margin-right: 10%; width: 80%" src="<?=base_url()?>img/header/SRLogo.png"/></a>
					<div style="clear: both; margin-bottom: 10px;"></div>
					<div class="text-header" style="font-size: 20px"><img src="<?=base_url()?>/img/header/handbag-luggage-accessories.png" alt="" /><!--Handbags &bull; Luggage &bull; Accessories--></div>
					<div style="clear: both; margin-bottom: 10px;"></div>
					<div style="float: left; width: 5%; font-size: 8px">
						&nbsp;
					</div>
					<div style="float:left; height: 27px; width: 20%; background: url('<?=base_url()?>img/mobile-dot.png')" >
					</div>
					<div style="float:left; width: 1.5%">&nbsp;</div>
					<a href="https://www.facebook.com/spencerandrutherford/" target="_blank"><img style="float:left; width: 7%" src="<?=base_url()?>img/fb-big.png"/></a>
					<div style="float:left; width: 3%">&nbsp;</div>
					<a href="https://twitter.com/snr_handbags/" target="_blank"><img style="float:left; width: 7%" src="<?=base_url()?>img/tweet-big.png"/></a>
					<div style="float:left; width: 3%">&nbsp;</div>
					<a id="yt_foot" href="http://youtube.com/spencerandrutherford" target="_blank"><img style="float:left; width: 7%" src="<?=base_url()?>img/yt-big.png"/></a>
					<div style="float:left; width: 3%">&nbsp;</div>
					<a id="cam_foot" href="http://instagram.com/spencerandrutherford" target="_blank"><img style="float:left; width: 7%" src="<?=base_url()?>img/camera-big.png"/></a>
					<div style="float:left; width: 3%">&nbsp;</div>
					<a id="pin_foot" href="http://pinterest.com/snrhandbags/" target="_blank"><img style="float:left; width: 7%" src="<?=base_url()?>img/pin-big.png"/></a>
					<div style="float:left; width: 1.5%">&nbsp;</div>
					<div style="float:left; height: 27px; width: 20%; background: url('<?=base_url()?>img/mobile-dot.png')" >
					</div>
					<div style="float: left; width: 5%; font-size: 8px">
						&nbsp;
					</div>
					<div style="clear: both; height: 15px;"></div>
					<div style="float: left; width: 5%; font-size: 8px">
						&nbsp;
					</div>
					<div style="float: left; width: 27%; font-size: 12px">
						<div style="width: 90%; height: 18px; background:#aea8a5;  line-height: 18px; margin-bottom: 10px;">
							<?php
                            	if($this->session->userdata('userloggedin'))
								{
								?>
								<a href="<?=base_url()?>store/signout" style="color: #fff; display: block">SIGN OUT</a>
								<?php
								}
								else
								{
								?>
								<a href="<?=base_url()?>store/signin" style="color: #fff; display: block">SIGN IN</a>
								<?php
								}
                            ?>
							<!-- <a href="<?=base_url()?>store/signin" style="color: #fff; display: block">SIGN IN</a> -->
						</div>
						<div style="width: 90%; height: 18px; background:#aea8a5; color: #fff; line-height: 18px; ">
							<a href="<?=base_url()?>store/register" style="color: #fff; display: block">REGISTER</a>
						</div>
					</div>
					<div style="float: left; width: 15%; text-align: center; margin-top: -9px;">
						<div onclick="window.location='<?=base_url()?>store/wishlist'" style="font-size: 10px; height: 33px; line-height: 43px; margin: 0 auto; text-align: center; width: 25px; background: url('<?=base_url()?>img/mobile-wlist.png');">
							<span class="tot_wishlist"><?=$count_wishlist?></span>
						</div>
						<!-- <div><img src=""/></div> -->
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">WISH<br/>LIST</div>
						
					</div>
					<div style="float: left; width: 20%; text-align: center; margin-top: -9px;">
						<div onclick="window.location='<?=base_url()?>store/cart'" style="font-size: 10px; height: 33px; line-height: 43px; margin: 0 auto; text-align: center; width: 33px; background: url('<?=base_url()?>img/mobile-sbag.png');">
							<span class="tot_shopbag"><?=$count_shopbag?></span>
						</div>
						<!-- <div><img src="<?=base_url()?>img/mobile-sbag.png"/></div> -->
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">SHOPPING<br/>BAG</div>
					</div>
					<div style="float: left; width: 15%; text-align: center; margin-top: -1px;">
						<div><img src="<?=base_url()?>img/mobile-store.png"/></div>
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">FIND<br/>STORE</div>
					</div>
					<div style="float: left; width: 15%; text-align: center; cursor: pointer; margin-top: 0px" onclick="$('#header-search').slideDown('slow').focus();">
						<div><img src="<?=base_url()?>img/mobile-search.png"/></div>
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">SEARCH</div>
					</div>
					<div style="clear: both"></div>
					
					
				</div>
				
				
			</div>
			
			<!-- <div class="row-fluid">
				<div class="span12">
					    <div class="input-append">
			    <input class="span2" id="appendedInputButton" type="text">
			    <button class="btn" type="button">Go!</button>
			    </div>
				</div>
			</div> -->
	<!-- <div class="row">

        			<div class="span12" style="height:40px;  ">

            		
            		
            		<div style="height: 50px; margin-top: 10px; margin-left: 10px; float: left">
							<select style="font-size: 14px; height: 34px; line-height: 34px;" id="currency_select2" onchange="change_currency2()">
								<option <?php if($sign == 'AU$') {echo 'selected="selected"';}?> value="aud">AUD</option>
								<option <?php if($sign == 'US$') {echo 'selected="selected"';}?> value="usa">USA</option>
								<option <?php if($sign == '€UR') {echo 'selected="selected"';}?> value="eur">EUR</option>
								<option <?php if($sign == 'GB£') {echo 'selected="selected"';}?> value="gbp">GBP</option>
								<option <?php if($sign == 'JP¥') {echo 'selected="selected"';}?> value="jpy">JPY</option>
							</select>
						</div>
						<?php
                        if($this->session->userdata('userloggedin'))
                        {
                        	$user = $this->session->userdata('userloggedin');
                        	$cust = $this->Customer_model->identify($user['customer_id']);
                        ?>
                        <div style="float: right; height: 20px; margin-top: 10px; margin-right: 10px">
                        	Welcome, <a href="#"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
                        </div>
                        <?php
                        }
                        ?>
					<div style="clear: both"></div>
        			</div>
        			
        			<div style="text-align: center">
        				<img src="<?=base_url()?>img/header/sLogo.png"/>
        			</div>

    			</div> -->

    			<!-- <div style="height:10px;"></div>
    			<div>
    				123
    			</div>        
    			<div style="height:10px;"></div> -->
				
            

		</div>
		

	</div>
	<div class="container visible-phone" style="background: #59595C; border: 1px solid #989898; width: inherit">

				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#nav-collapse-header" style="float: right; color: #fff; background: #59595C; border-color: #59595C">

		        	<!-- <span class="icon-bar"></span>

		        	<span class="icon-bar"></span>

		        	<span class="icon-bar"></span> -->
		        	
		        	<i class="icon icon-chevron-down"></i>

		        </button>

		        <a class="brand" href="#" style="color: #fff; font-weight: 700; margin-left: 15px; line-height: 24px;">MENU</a>

		        <div class="nav-collapse collapse" id="nav-collapse-header" >

		            <ul class="nav">

		            	<!-- class="active" -->

		              <li><a class="a-nav" href="<?=base_url()?>store/product/New-Arrivals/all" style="color: #fff !important">New Arrivals</a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/Handbags/all" style="color:#fff !important;font-weight:400; display: block"> Handbags </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/Wallets/all" style="color:#fff !important;font-weight:400; display: block"> Wallets </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/Travel/all" style="color:#fff !important;font-weight:400; display: block"> Travel </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/Accessories/all" style="color:#fff !important;font-weight:400; display: block"> Accessories </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/Sale/all" style="color:#fff !important;font-weight:400; display: block"> Sale </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/Stylefile/all" style="color:#fff !important;font-weight:400; display: block"> Stylefile </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/product/News/all" style="color:#fff !important;font-weight:400; display: block"> News </a></li>
		              
		              <!-- <li><a href="<?=base_url()?>store/cart" style="color:#FAFAFA;font-weight:400; display: block"> Shopping Bag : <span class="tot_shopbag"><?=$count_shopbag?></span> </a></li>
		              
		              <li><a href="<?=base_url()?>store/wishlist" style="color:#FAFAFA;font-weight:400; display: block"> Whislist : <span class="tot_wishlist"><?=$count_wishlist?></span> </a></li>
		              
		              <li><input style="width: 90%; margin-left: 10px;" type="text" placeholder="Looking for something?"></li>
		              
		              <li><a href="<?=base_url()?>store/signin" style="color:#FAFAFA;font-weight:400; display: block"> Sign In</a></li>
		              
		              <li><a href="<?=base_url()?>store/register" style="color:#FAFAFA;font-weight:400; display: block"> Register </a></li> -->
		              
		              

		            </ul>

		            <!-- <form class="navbar-form pull-right">

		              <input class="span2" type="text" placeholder="Email">

		              <input class="span2" type="password" placeholder="Password">

		              <button type="submit" class="btn">Sign in</button>

		            </form> -->

		          </div><!--/.nav-collapse -->		         

			</div>
	<script>
	
	jQuery(function ($) {
    // Invoke the plugin
    $('.inputp').placeholder();
    // That's it, really.
    // Now display a message if the browser supports placeholder natively
    
   });
	</script>