<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<?php if (isset($pages['meta_description'])){?>
<?php if($pages['meta_description']!='') {?>
	<meta name="description" content="<?=$pages['meta_description']?>" />
<?php } else{?>
    <meta name="description" content="<?=META_DESC?>" /><?php }?>
<?php }else{?>
	<meta name="description" content="<?=META_DESC?>" /><?php }?>

<?php if (isset($pages['meta_title'])){?>
<?php if($pages['meta_title']!='') {?>
	<meta name="keywords" content="<?=$pages['meta_title']?>" />
<?php } else{?>
    <meta name="keywords" content="<?=META_KEYWORDS?>" /><? }?>
    
    <title>
<?php 
	if($pages['meta_title']!=''){
		echo $pages['meta_title'];
	}else{
		echo META_TITLE;
	}
?>
	</title>
<?php }else {?>
	<title><?php echo META_TITLE;?></title>
	<meta name="keywords" content="<?=META_KEYWORDS?>" />
<?php }?>

<link rel="stylesheet" href="<?=base_url() . ASSETS;?>bootstrap-3.2.2/css/bootstrap.min.css">
<!-- FA -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>font-awesome-4.3.0/css/font-awesome.min.css">

<link rel="shortcut icon" type="image/ico" href="<?=base_url() . ASSETS;?>img/bared-favicon-32x32.ico"/>

<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


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




<!-- app css -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>css/app.css">

<!-- Load Scripts -->
<!-- jQuery -->
<script src="<?=base_url() . ASSETS;?>js/jquery-1.11.2.min.js"></script>
<!-- BSJS-->
<script src="<?=base_url() . ASSETS;?>bootstrap-3.2.2/js/bootstrap.min.js"></script>
<!-- jquery touch -->
<script type="text/javascript" src="<?=base_url() . ASSETS;?>js/jquery.mobile.custom.min.js"></script>
<!--app js-->
<script type="text/javascript" src="<?=base_url() . ASSETS;?>js/app/app.js"></script>


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

<script src="<?=base_url()?>js/select2/select2.js"></script>
<script src="<?=base_url()?>js/zoome.js"></script>
<script src="<?=base_url()?>js/moment.js"></script>
<script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
<script src="<?=base_url()?>js/jquery.placeholder.js"></script>
<script src="<?=base_url()?>js/magiczoom.js"></script>
<!-- <fb:login-button show-faces="true" width="200" max-s="1"></fb:login-button> -->
<script>
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
$('.limit_tt').tooltip({
		showURL: false
});
$("#currency_select").select2({
	minimumResultsForSearch: '-2',
	formatResult: format,
	formatSelection: format,
	escapeMarkup: function(m) { return m; }
});

$("#currency_select1").select2({
	minimumResultsForSearch: '-2',
	formatResult: format,
	formatSelection: format,
	escapeMarkup: function(m) { return m; }
});

$("#currency_select2").select2({
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
	if($user){
		$count_wishlist = count($this->Cart_model->get_wishlist($user['id']));
	}
	$hdr_data = array(
						'count_shopbag' => $count_shopbag,
						'count_wishlist' => $count_wishlist
					);

?>
</head>

<body>

<header>
	<div id="top-bar" class="app-container bar bg-black hidden-xs">
    	<div class="col-sm-12 xs-x-gutters">
        	<div class="currency-converter">
            	<h6 class="hidden-xs">Currency</h6>
                <div class="currency-select">
                    <select id="currency_select" onchange="change_currency()">
                        <option <?php if($sign == '<span style="font-size:12px">AU</span> $') {echo 'selected="selected"';}?> value="aud">AUD</option>
                        <option <?php if($sign == '<span style="font-size:12px">US</span> $') {echo 'selected="selected"';}?> value="usa">USA</option>
                        <option <?php if($sign == '<span style="font-size:12px">€UR</span>') {echo 'selected="selected"';}?> value="eur">EUR</option>
                        <option <?php if($sign == '<span style="font-size:12px">GB£</span>') {echo 'selected="selected"';}?> value="gbp">GBP</option>
                        <option <?php if($sign == '<span style="font-size:12px">JP¥</span>') {echo 'selected="selected"';}?> value="jpy">JPY</option>
                    </select>
                 </div>
            </div>
            <div class="shipping-info">
            	<div class="h6 fw-700 account-access pull">
					<?php 
                        if($this->session->userdata('userloggedin')){
                        $user = $this->session->userdata('userloggedin');
                        $cust = $this->Customer_model->identify($user['customer_id']);
                    ?>
                    <a class="text-white app-visible-md" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>"><i class="fa fa-user"></i></a>
                    <a class="text-white app-hidden-md" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>"><i class="fa fa-user"></i>  Welcome - <?=$cust['firstname']?></a> /
                    <a class="text-white" href="<?=base_url()?>store/signout">Logout</a>
                    <?php }else{ 	?>
                    <i class="fa fa-unlock-alt"></i> 
                    <a class="text-white app-hidden-md" href="<?=base_url()?>store/register">Register</a> /
                    <a class="text-white" href="<?=base_url()?>store/signin">Login</a>
                    <?php } ?>
                </div>
        		<h6 class="pull app-hidden-md hidden-xs"><span class="fw-700">Free Shipping</span> Australia wide on order over $150!</h6>
                <h6 class="pull app-visible-md hidden-xs"><span class="fw-700">Free <i class="fa fa-truck"></i></span> AU wide on order over $150!</h6>
                
                
            </div>
        </div>
    </div>
	<div id="header" class="app-container">
        <div class="hidden-xs desktop"><?=$this->load->view('common/desktop_header',$hdr_data);?></div>
        <div class="visible-xs mob"><?=$this->load->view('common/mob_header',$hdr_data);?></div>
    </div>   
</header> 

<?php $this->load->view('common/nav/main_view'); ?>














