<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<? if (isset($pages['meta_description']))
{
	?>
    <? if($pages['meta_description']!='') {?><meta name="description" content="<?=$pages['meta_description']?>" /><? } else{?>
    <meta name="description" content="<?=META_DESC?>" /><? }?>
<?    
}
else 
{
	?><meta name="description" content="<?=META_DESC?>" /><?
}
?>



<? if (isset($pages['meta_title']))
{
	?>
    <? if($pages['meta_title']!='') {?><meta name="keywords" content="<?=$pages['meta_title']?>" /><? } else{?>
    <meta name="keywords" content="<?=META_KEYWORDS?>" /><? }?>

    <title>
	<?php
	if($pages['meta_title']!='')
	{
		echo $pages['meta_title'];
	}
	else 
	{
		echo META_TITLE;
	}
	?>
	</title>
	<?
}
else 
{
	?><title><? echo META_TITLE;?></title>
	<meta name="keywords" content="<?=META_KEYWORDS?>" /><? 
	
	
}
?>



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
<link href="<?=base_url()?>css/bared-product.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bared-page.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bared-footer.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/competition.css" rel="stylesheet" media="screen">
<link href='//fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
<!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">-->
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<meta name="google-site-verification" content="Nd2vOX7BNVofZbQ45ojv8-BXcZPdNRXrB_chmUwnbnE" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37760446-1']);
  _gaq.push(['_setDomainName', 'bared.com.au']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
var yotpo_app_key = "87cmugsJWWCvn4YdAy3U9AcGnlYiUwvpv1TKwE5Z";
(function(){function e(){var e=document.createElement("script");e.type="text/javascript",e.async=!0,e.src="//staticwww.yotpo.com/js/yQuery.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)}window.attachEvent?window.attachEvent("onload",e):window.addEventListener("load",e,!1)})();
</script>
<script>
function open_window(url) {
	day = new Date();
	id = day.getTime();	
	URL = url;
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=825,height=600,left = 240,top = 125');");
}

</script>

</head>



<body>
	
<script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>js/jquery.js"></script>
<script src="<?=base_url()?>js/bootstrap.js"></script>
<script src="<?=base_url()?>js/select2/select2.js"></script>
<script src="<?=base_url()?>js/zoome.js"></script>
<script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
<script src="<?=base_url()?>js/jquery.placeholder.js"></script>
<script src="<?=base_url()?>js/magiczoom.js"></script>
<!-- <fb:login-button show-faces="true" width="200" max-rows="1"></fb:login-button> -->

<script>

$j = $.noConflict();
function change_currency()
{
	var cur = $('#currency_select').val();
			
	jQuery.ajax({
		url: '<?=base_url()?>store/change_currency/'+cur,
		type: 'POST',
		dataType: "html",
		success: function(html) {
			location.reload(); 
		}
	})	
}

function change_currency1()
{
	var cur = $('#currency_select1').val();
	
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
    <!-- Website mode 1200px -->
	<!-- <div class="navbar navbar-fixed-top" id="main-header"> -->
		<div class=" hidden-phone">
			<div class="container">
    			<div class="row-fluid">
        			<div class="span12">						                        
                    	<div id="top-gap"></div>
						
                        <div id="currency-container">
                                <select id="currency_select" onchange="change_currency()">
                                    <option <?php if($sign == '<span style="font-size:12px">AU</span> $') {echo 'selected="selected"';}?> value="aud">AUD</option>
                                    <option <?php if($sign == '<span style="font-size:12px">US</span> $') {echo 'selected="selected"';}?> value="usa">USA</option>
                                    <option <?php if($sign == '<span style="font-size:12px">€UR</span>') {echo 'selected="selected"';}?> value="eur">EUR</option>
                                    <option <?php if($sign == '<span style="font-size:12px">GB£</span>') {echo 'selected="selected"';}?> value="gbp">GBP</option>
                                    <option <?php if($sign == '<span style="font-size:12px">JP¥</span>') {echo 'selected="selected"';}?> value="jpy">JPY</option>
                                </select>
                                
                                <div class="header-Font" id="free-shipping-text">
                                	Free shipping Australia wide<br/>on orders over $150!
                                </div>
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
                        <div class="header-Font" id="welcome-container">
                        	<?php
                        	if($user['level'] == 1)
							{
							?>
								Welcome, <a href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
							<?
							}
							
							else if($user['level'] == 2)
							{
							?>
								Welcome, <a href="<?=base_url()?>store/edit_detail_trade/<?=$cust['id']?>"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
							<?
							}
							if($user == 1)
							{
							?>
								Welcome, <a  href="#"><?=$cust['firstname']?> <?=$cust['lastname']?></a>
							<?
							}
                        	?>
                        	
                        </div>
                        <?php
                        }
                        ?>
                        
                    
                    	<div style="clear:both;"></div>
                        
                        
                        
                        <div id="header_logo"> <!-- Logo as background image in css -->
                        	<div onclick="window.location='<?=base_url()?>'"  class="home-click">&nbsp;	</div>                            
                            <div class="header-Font" id="sbag-wlist">
                                <div id="sbag-cont">
                                	<a class="link_title" href="<?=base_url()?>cart/list_cart"><div id="img-sbag"></div></a>
                                	<div id="text-sbag"><a class="link_title" href="<?=base_url()?>cart/list_cart">Shopping Cart</a></div>
                                	<div id="count-sbag">
                                		<a class="link_title" href="<?=base_url()?>cart/list_cart">
                                			<span class="tot_shopbag">
                                			<?php 
                                				if($count_shopbag >= 0)
												{
													echo $count_shopbag;
												}
												else 
												{
													echo "00";
												}
                                			?>
                                			</span>
                                		</a>
                                	</div>
                                	<div class="clear-div"></div>
                                </div>
                                <div id="wlist-cont">
                                	<a class="link_title" href="<?=base_url()?>cart/wishlist"><div id="img-wlist"></div></a>
                                	<div id="text-wlist">Wish List</div>
                                	<div id="count-wlist">
                                		<a class="link_title" href="<?=base_url()?>cart/wishlist">
                                			<span class="tot_wishlist">
                                			<?php 
                                				if($count_wishlist >= 0)
												{
													echo $count_wishlist;
												}
												else 
												{
													echo "00";
												}
                                			?>
                                			</span>
                                		</a>
                                	</div>
                                	<div class="clear-div"></div>
                                </div>
                                
                                <div id="reg-login">
                                	<a class="link_title" href="<?=base_url()?>store/register">Register</a> 
                                	/
                                	<?php
                                	if($this->session->userdata('userloggedin'))
									{
										?>
										<a class="link_title" href="<?=base_url()?>store/signout">Logout</a>
										<?
									}
									else 
									{
										?>
										<a class="link_title" href="<?=base_url()?>store/signin">Login</a>
										<?
									}
                                	?>
                                	
                                </div>
                                
                                <div>
                                	<form style="margin-bottom: 10px;" method="post" action="<?=base_url()?>store/search">
                                	<div class="input-append">
									    <input id="inp-header-src" class="span2 inputp" id="appendedInputButton" type="text" placeholder="Enter Keyword" name="keyword">
									    <button id="btn-header-src" class="btn btn-info" type="submit"><i class="icon-search"></i></button>
								    </div>
								    </form>
                                </div>
                            </div>  
                     			<!--<div style="width:50px;float:left;"><a href="<?=base_url()?>store/wishlist"><div class="text-shopping">WISH LIST</div></a></div>
							   <div style="width:80px;float:left;"><a href="<?=base_url()?>store/cart"><div class="text-shopping">SHOPPING BAG</div></a></div>-->
                        </div>
                    
                    	<div style="clear:both;"></div>   
        			</div>					
    			</div>
    			<div class="row-fluid" id="header-menu-container">
    				<div class="span12">
    					<div class="span6">
    						<div class="span3 header-menu" id="only_home">
    							<div onclick="window.location='<?=base_url()?>'" class="header-menu-title menu-Font">&nbsp;&nbsp;&nbsp;&nbsp;HOME</div>
                                <!---->
    						</div>
    						<div class="span3 header-menu">
    							<div class="header-menu-title menu-Font">WOMEN'S</div>
    							
                                <?php 
									$categories = $this->Category_model->get(2);
									//print_r($categories);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										//$categories = $this->Category_model->get(2);
											foreach($categories as $ct)
											{
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{
														$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>    								
    								</div>
    							</div>
                                <? 	} ?>
                                
                                
    						</div>
    						<div class="span3 header-menu">
    							<div class="header-menu-title menu-Font">MEN'S</div>
    							
                                
                                <?php 
									$categories = $this->Category_model->get(3);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										//$categories = $this->Category_model->get(3);
											foreach($categories as $ct)
											{
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Mens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Mens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{
														$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>
    								</div>
    							</div>
                                <? 	} ?>
                                
    						</div>
    						<div class="span3 header-menu">
    							<div onclick="window.location='<?=base_url()?>store/products/sale/all'" class="header-menu-title menu-Font">SALE</div>
                                <?php 
									$categories = $this->Category_model->get(4);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										//$categories = $this->Category_model->get(4);
											foreach($categories as $ct)
											{
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{
														$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>
    								</div>
    							</div>
                                <? 	} ?>
    						</div>
    					</div>
    					<div class="span6">
    						<div class="span3 header-menu">
    							<div class="header-menu-title menu-Font">WHY BARED?</div>
                                <?php 
									$categories = $this->Category_model->get(5);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										//$categories = $this->Category_model->get(5);
											foreach($categories as $ct)
											{
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{
														$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>
    								</div>
    							</div>
                                <? 	} ?>
    						</div>
    						<div class="span3 header-menu">
    							<div class="header-menu-title menu-Font">GALLERY</div>
    							
                                <?php 
									$categories = $this->Category_model->get(6);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										$categories = $this->Category_model->get(6);
											foreach($categories as $ct)
											{
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{
														$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>
    								</div>
    							</div>
                                <? 	} ?>
    						</div>
    						<div class="span3 header-menu">
    							<div class="header-menu-title menu-Font">PRESS</div>
                                
                                <?php 
									$categories = $this->Category_model->get(7);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										$categories = $this->Category_model->get(7);
											foreach($categories as $ct)
											{
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{
														$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>
    								</div>
    							</div>
                                <? 	} ?>
    						</div>
    						<div class="span3 header-menu">
    							<div class="header-menu-title menu-Font">CONTACT US</div>
                                
                                <?php 
									$categories = $this->Category_model->get(8);
									if(count($categories)>0){?>
                                	<div class="header-submenu">
    								<img class="triangle" alt="" src="<?=base_url()?>img/header/submenu-triangle.png"/>
    								<div class="header-submenu-content-list sub-menu-Font">
    									<?php
    										$categories = $this->Category_model->get(8);
											foreach($categories as $ct)
											{
												
												if($ct['type']==0)
												{
													$texts=$this->Product_model->get_name_keyword($ct['title']);											
													if(1)
													{
														$cat = $this->Category_model->identify_by_title($ct['title']);
														if(count($cat)>0)
														{
															$catid = $cat['id'];
														}
														else 
														{
															$catid= '';
														}
		                                    		?>		
		                                    		<?php
			                                    		if($ct['show_all'] == 1)
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/all"><?=$ct['title']?></a>
															</div>
														<?
														}
														else 
														{
														?>
															<div class="header-submenu-list">
																<a href="<?=base_url()?>store/product/Womens/<?=$ct['name']?>"><?=$ct['title']?></a>
															</div>
														<?
														}
													}
												}
												else
												{
													if($ct['external_link']!='')
													{
												
														?><div class="header-submenu-list"><a href="<?=$ct['external_link']?>"><?=$ct['title']?></a></div><?
													}
													else
													{	$pages = $this->Menu_model->getpage($ct['id_page']);
														?><div class="header-submenu-list"><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></div><?
													}
												}
											}
    									?>
    								</div>
    							</div>
                                <? 	} ?>
    						</div>
    					</div>    				
    				</div>
    			</div>
				<div style="clear:both;"></div>     
    			

			</div>

			
			

		</div>
		
		<div class=" visible-phone" >
			<div class="row-fluid">
				<div class="span12" style="text-align: center; margin-bottom: 20px;">
					
					<form method="post" action="<?=base_url()?>store/search">
						<input class="span10" type="text" placeholder="Looking for something" style="display: none;" id="header-search" name="keyword"/>
					</form>
					<a href="<?=base_url()?>"><img style="margin-left: 10%; margin-right: 10%; width: 30%" src="<?=base_url()?>img/header/Logo.png"/></a>
					<div style="clear: both; margin-bottom: 20px;"></div>
					
					<div style="float:left; width:45%; font-size:14px; font-weight: 600;">
						<img alt="" src="<?=base_url()?>img/header/shopbag-black-small.png"/>
						<div>Shopping Bag 0</div>
					</div>
					<div style="float:left; width:10%;">
						&nbsp;
					</div>
					<div style="float:left; width:45%; font-size:14px; font-weight: 600;">
						<img alt="" src="<?=base_url()?>img/header/wishList-black-small.png"/>
						<div>Wishlist 0</div>
					</div>
					
					<!-- <div class="text-header" style="font-size: 20px"><img src="<?=base_url()?>/img/header/handbag-luggage-accessories.png" alt="" /></div>
					<div style="clear: both; margin-bottom: 10px;"></div> -->
					<!-- <div style="float: left; width: 5%; font-size: 8px">
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
					</div> -->
					<div style="clear: both; height: 15px;"></div>
					
					<?php
						if($this->session->userdata('userloggedin'))
						{
						?>
							<input onclick="window.location='<?=base_url()?>store/signout'" class="button_primary button-Font left-side button_header" type="button" value="Sign Out">
						<?
						}
						else 
						{
						?>
							<input onclick="window.location='<?=base_url()?>store/signin'" class="button_primary button-Font left-side button_header" type="button" value="Sign In">
						<?
						}
					?>
					
					<div style="float: left; width: 10%">&nbsp;</div>
					<input onclick="window.location='<?=base_url()?>store/register'" class="button_primary button-Font left-side button_header" type="button" value="Register">
					
					
					
					<!-- <div style="float: left; width: 5%; font-size: 8px">
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
							
						</div>
						<div style="width: 90%; height: 18px; background:#aea8a5; color: #fff; line-height: 18px; ">
							<a href="<?=base_url()?>store/register" style="color: #fff; display: block">REGISTER</a>
						</div>
					</div>
					<div style="float: left; width: 15%; text-align: center; margin-top: -9px;">
						<div onclick="window.location='<?=base_url()?>cart/wishlist'" style="font-size: 10px; height: 33px; line-height: 43px; margin: 0 auto; text-align: center; width: 25px; background: url('<?=base_url()?>img/mobile-wlist.png');">
							<span class="tot_wishlist"><?=$count_wishlist?></span>
						</div>
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">WISH<br/>LIST</div>
						
					</div>
					<div style="float: left; width: 20%; text-align: center; margin-top: -9px;">
						<div onclick="window.location='<?=base_url()?>cart/list_cart'" style="font-size: 10px; height: 33px; line-height: 43px; margin: 0 auto; text-align: center; width: 33px; background: url('<?=base_url()?>img/mobile-sbag.png');">
							<span class="tot_shopbag"><?=$count_shopbag?></span>
						</div>
						
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">SHOPPING<br/>BAG</div>
					</div>
					<div style="float: left; width: 15%; text-align: center; margin-top: -1px;">
						<div><img src="<?=base_url()?>img/mobile-store.png"/></div>
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">FIND<br/>STORE</div>
					</div>
					<div style="float: left; width: 15%; text-align: center; cursor: pointer; margin-top: 0px" onclick="$('#header-search').slideDown('slow').focus();">
						<div><img src="<?=base_url()?>img/mobile-search.png"/></div>
						<div style="color:#aea8a5; font-size: 10px; line-height: 11px; margin-top: 4px">SEARCH</div>
					</div> -->
					<div style="clear: both; height:20px"></div>
					
					<form style="margin-bottom: 10px;" method="post" action="<?=base_url()?>store/search">
                	<div class="input-append">
					    <input id="inp-header-src" class="span2 inputp" id="appendedInputButton" type="text" placeholder="Enter Keyword" name="keyword">
					    <button id="btn-header-src" class="btn btn-info" type="submit"><i class="icon-search"></i></button>
				    </div>
				    </form>
					
				</div>
			</div>
		</div>

		<div class="container visible-phone" style="background: #000; border: 1px solid #000; width: inherit">

				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#nav-collapse-header" style="float: right; color: #fff; background: #000; border-color: #000">

		        	
		        	
		        	<i class="icon icon-chevron-down"></i>

		        </button>

		        <a class="brand" href="#" style="color: #fff; font-weight: 700; margin-left: 15px; line-height: 24px;">MENU</a>

		        <div class="nav-collapse collapse" id="nav-collapse-header" >

		            <ul class="nav">

		            	

		              <li><a class="a-nav" href="<?=base_url()?>" style="color:#fff !important">HOME</a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/products/Womens/all" style="color:#fff !important;font-weight:400; display: block"> WOMEN'S </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/products/Mens/all" style="color:#fff !important;font-weight:400; display: block"> MEN'S </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/products/sale/all" style="color:#fff !important;font-weight:400; display: block"> SALE </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/page/20" style="color:#fff !important;font-weight:400; display: block"> WHY BARED? </a></li>

		              <li><a class="a-nav" href="#" style="color:#fff !important;font-weight:400; display: block"> JOURNAL </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>store/page/24" style="color:#fff !important;font-weight:400; display: block"> PRESS </a></li>

		              <li><a class="a-nav" href="<?=base_url()?>page/Contact-Us" style="color:#fff !important;font-weight:400; display: block"> CONTACT US </a></li>
		              
		              
		              
		              

		            </ul>

		            

		          </div>   

			</div>
		

	<!-- </div> -->
	
	
	
	<script>
	
	jQuery(function ($) {
    // Invoke the plugin
    $('.inputp').placeholder();
    // That’s it, really.
    // Now display a message if the browser supports placeholder natively
    
   });
	</script>