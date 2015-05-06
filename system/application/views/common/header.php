<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bared Footwear</title>

<link rel="stylesheet" href="<?=base_url() . ASSETS;?>bootstrap-3.2.2/css/bootstrap.min.css">
<!-- FA -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>font-awesome-4.3.0/css/font-awesome.min.css">



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

</head>

<body>

<header>
	<div id="header" class="app-container">
    	<div class="hidden-xs desktop"><?=$this->load->view('common/desktop_header');?></div>
    	<div class="visible-xs mob"><?=$this->load->view('common/mob_header');?></div>
    </div>    
</header> 

<?php $this->load->view('common/nav/main_view'); ?>














