<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="keywords" content="" />

<meta name="description" content="" />

<title>SNR</title>

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
<link href='http://fonts.googleapis.com/css?family=Parisienne|Buenard:400,700|Open+Sans:400,600italic,600' rel='stylesheet' type='text/css'>
<!--@import url(http://fonts.googleapis.com/css?family=Parisienne|Buenard:400,700|Open+Sans:600italic,600);-->
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
<style>
a{

color:#d71d5d;

}
a:hover{
color:#d71d5d;
text-decoration:none;
}

a:focus{
color:#d71d5d;
}
.a-primary
{
	color:#e3007b;
}
.flag
{
	width:15px;
	height:15px;
	margin-top:-4px;
}
.select2-result-label
{
	font-size:14px;
	line-height: 20px;
} 
.text-header{
	text-align:center;
	font-size:24px;
	font-family: 'Parisienne', cursive;
}
.text-opera{
	font-family: 'Open Sans', sans-serif;
}
.text-register{
	font-size:12px;
	text-transform:capitalize;
	font-weight:100;
	color:#6D6F70;
}
.text-register2{
	font-size:10px;
	text-transform:capitalize;
	font-weight:100;
	color:#6D6F70;
}
.text-shopping{
	font-size:9px;
	text-transform:uppercase;
	font-weight:400;
	color:#A5A7AA;
}
.text-shopping2{
	font-size:9px;
	text-transform:uppercase;
	font-weight:400;
	color:#A5A7AA;
}
a:hover{
	text-decoration:none;
	color:#d71d5d;
	
}
a.menu-text:hover{
	text-decoration:none;
	color:#fff;
	font-weight:normal;
}

a.text-register:hover{
	text-decoration:none;
	color:#d71d5d;
	font-weight:100;
	
}
.menutop-child
{
	display:none;
	background: none repeat scroll 0 0 #000000;
    padding-bottom: 10px;
    
    padding-top: 10px;
    position: absolute;
    text-align: left;
    margin-top:3px;
    /*margin-left:-7px;*/
    /*width:280px;*/
    text-transform: uppercase;
    line-height: 24px;
    border-top: 5px solid #59595C;
	z-index:1000001;
	font-weight: 400 !important;
	
}

@media (max-width: 979px)
{
	.menutop-child
	{
		display:none;
		background: none repeat scroll 0 0 #000000;
	    padding-bottom: 10px;
	    
	    padding-top: 10px;
	    position: absolute;
	    text-align: left;
	    margin-top:2px;
	    /*margin-left:-7px;*/
	    /*width:280px;*/
	    text-transform: uppercase;
	    line-height: 18px;
	    border-top: 3px solid #59595C;
		z-index:1000001;
		font-weight: 400 !important;
		
		padding-left: 10px;
		margin-left: -10px;
		width: 171px
	}
	
	
}

.mymenutop
{
	/*background : none repeat scroll 0 0 #5A5657;*/
	background : none repeat scroll 0 0 #59595C;
}


#menutop-child8
{
	/**/
}
#mymenutop2:hover #menutop-child2
{
	display:block;
}
#mymenutop3:hover #menutop-child3
{
	display:block;
}
#mymenutop4:hover #menutop-child4
{
	display:block;
}
#mymenutop5:hover #menutop-child5
{
	display:block;
}
#mymenutop6:hover #menutop-child6
{
	display:block;
}
#mymenutop7:hover #menutop-child7
{
	display:block;
}
#mymenutop8:hover #menutop-child8
{
	display:block;
}


#mymenutop12:hover #menutop-child12
{
	display:block;
}
#mymenutop13:hover #menutop-child13
{
	display:block;
}
#mymenutop14:hover #menutop-child14
{
	display:block;
}
#mymenutop15:hover #menutop-child15
{
	display:block;
}
#mymenutop16:hover #menutop-child16
{
	display:block;
}
#mymenutop17:hover #menutop-child17
{
	display:block;
}
#mymenutop18:hover #menutop-child18
{
	display:block;
}
.menu-a
{
	color: #ffffff;
	font-weight:400 !important;
	text-decoration:none;
}
.menu-a:hover
{
	/*color:#cf0055;*/
	color:#d71d5d;
	text-decoration:none;
}

.a-nav
{
	color:#989898 !important;font-weight:100 !important; display: block;
}

.a-nav:hover
{
	color:#fff !important;
}

.menu-text
{
	color:#FFFFFF;
	font-weight:400; display: block; 
	letter-spacing:1px;
	text-transform:uppercase;
	text-align:left;
	/*font-size:12px!important;*/
}
.child-menu{
	display:none;
}
#menu-50:hover #child-detail{
	display:block;
}

/*@media screen and (-webkit-min-device-pixel-ratio:0)
{
	.app-container {margin-top: 30px;}	
	body{margin-top:-65px;}
	html{padding-top: 0px ! important;}
}*/

@media (max-width: 1200px)
{
  .home-click
  {
  	height: 95px; margin-left: 280px; position: absolute; width: 380px; cursor:pointer;
  }
	.child8
  {
  	
    /*margin-left: -125px !important;
    padding-left : 127px;*/
    
    width: 105px !important;
  }
  .line_top_new
  {
  	height: 5px;
  	background: #59595C;
  	width:939px;
  }
  
  .carousel-control
  {
  	margin-top:18px !important;
  }
  
  #mymenutop8
  {
  	width:108.1px;
  }
  
  /*. [class*="span"]:first-child {
    margin-left: 30px;*/
}

@media (min-width: 1200px)
{
  .home-click
  {
  	height: 95px; margin-left: 395px; position: absolute; width: 380px; cursor:pointer;
  }
	.child8
  {
  	
   /* margin-left: -158px !important;
    padding-left : 155px;*/
    
    width: 134px !important;
  }
  
  .line_top_new
  {
  	height: 5px;
  	background: #59595C;
  	width:1169px;
  }
  
  .carousel-control
  {
  	margin-top:32px !important;
  }
  /*. [class*="span"]:first-child {
    	margin-left: 20px;
	}*/
}

.child18
  {
  	
    /*margin-left: -100px !important;
    padding-left : 101px;*/
    
    width: 79px !important;
  }
  
  .placeholder { color: #aaa; }
  
  
}

@media (max-width: 979px)
{
	
	.home-click
  {
  	height: 84px; margin-left: 210px; position: absolute; width: 305px; cursor:pointer;
  }
	/*. [class*="span"]:first-child {
    	margin-left: 20px;
	}*/
	
	.child18
	{
		line-height: 12px;
	}
}

.lshop
{
	margin-left: 19.3px;
}
.lwish
{
	margin-left: 9.2px;
}

.mymodal
{
	font-family: buenard !important; 
	font-size: 16px !important; 
	border-radius: 0 !important; 
	line-height: 20px !important;
}

.mytop-modal
{
	text-align: right !important; 
	margin-top: 10px !important; 
	margin-right: 10px !important; 
	cursor: pointer !important;
}

.mybody-modal
{
	text-align: center !important; 
	padding: 5px 50px 20px !important;
}
.mybody-modal-left
{
	text-align: left;
	padding: 5px 50px 20px !important;
}
.accordion-inner a:hover{color: #d71d5d}
</style>

<script>
//alert(navigator.userAgent + "<br>");

//Detect bser and write the corresponding name

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
	//alert('"Google Chrome ');// For some reason in the bser identification Chrome contains the word "Safari" so when detecting for Safari you need to include Not Chrome
	
	// new_style += '<style> ';
	// new_style += '.app-container {margin-top: 30px;} ';
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
	

	
	

<!-- <fb:login-button show-faces="true" width="200" max-s="1"></fb:login-button> -->

	
	
	
	
	
	
	
	
	

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
	
	
	
	<script>
	
	jQuery(function ($) {
    // Invoke the plugin
    $('.inputp').placeholder();
    // That’s it, really.
    // Now display a message if the bser supports placeholder natively
    
   });
	</script>
	<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; color: #403c3c; font-family: times; border-top: 5px solid #000">
		<tr>
			<td>
			</td>
		</tr>
	</table>
	<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; color: #403c3c; font-family: times; ">
		<tr>
			<td>
				Dear <?=$recipient?>,<br/>
				<br/>
				A gorgeous Spencer &amp; Rutherford gift has been sent to you from a friend. It will be delivered to <?=$address?> within the next 14 days and will arrive by courier or eParcel.<br/>
				<br/>
				We Hope you enjoy your gift!<br/>
				xo Spencer &amp; Rutherford
			</td>
		</tr>
	</table>
	
	<table width="630px" align="center" cellpadding="0" cellspacing="0" style="margin-top: 30px; font-size: 16px; background: #faf8f6; color: #403c3c; font-family: times; font-style: italic">
		<tr>
			<td style="padding: 10px; width: 50%">
				<img alt="" src="<?=base_url()?>img/ecard/large<?=$img?>.jpg"/>
			</td>
			<td style="padding: 50px; width: 50%; vertical-align: top">
				<p style="text-align: center; margin-bottom: 30px;">
				<img alt="" src="<?=base_url()?>img/logo_ecard.png"/>
				</p>
				<p>
				Dear <?=$recipient?>,<br/>
				<br/>
				<?=$notes?><br/>
				<br/>
				</p>
				<p style="text-align: left">
				<?=$sender?>
				</p>
			</td>
		</tr>
	</table>
	
	<!-- <table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; margin-bottom: 30px; color: #403c3c; font-family: times; ">
		<tr>
			<td style="text-align: center">
				<img alt="" src="<?=base_url()?>img/footer-ecard.png"/><br/>
				WWW.SPENCERANDRUTHERFORD.COM.AU
			</td>
		</tr>
	</table> -->
	
	
	<table cellspacing="0" cellpadding="0" width="630" align="center" style="margin-top: 20px; ">
						
						<tr>
							<td style="width:206px; height:34px;">
								<img alt="" src="<?=base_url()?>img/left-email-dot.png"/>
							</td>
							<td style="width:34px; height:34px;"><a href="https://www.facebook.com/spencerandrutherford/"><img alt="" src="<?=base_url()?>img/email-fb.png"/></a></td>
							<td style="width:13px; height:34px;">&nbsp;</td>
							<td style="width:34px; height:34px;"><a href="https://twitter.com/snr_handbags/"><img alt="" src="<?=base_url()?>img/email-tweet.png"/></a></td>
							<td style="width:13px; height:34px;">&nbsp;</td>
							<td style="width:34px; height:34px;"><a href="http://youtube.com/spencerandrutherford"><img alt="" src="<?=base_url()?>img/email-yt.png"/></a></td>
							<td style="width:13px; height:34px;">&nbsp;</td>
							<td style="width:34px; height:34px;"><a href="http://instagram.com/spencerandrutherford"><img alt="" src="<?=base_url()?>img/email-camera.png"/></a></td>
							<td style="width:13px; height:34px;">&nbsp;</td>
							<td style="width:34px; height:34px;"><a href="http://pinterest.com/snrhandbags/"><img alt="" src="<?=base_url()?>img/email-pin.png"/></a></td>
							<td style="width:206px; height:34px;">
								<img alt="" src="<?=base_url()?>img/right-email-dot.png"/>
							</td>
						</tr>
						
					</table>
	
	<!-- <table cellspacing="0" cellpadding="0" width="630" align="center" style="margin-top: 20px">
						
						<tr>
							<td><img alt="" src="<?=base_url()?>img/email-service.png"/></td>
							<td><img alt="" src="<?=base_url()?>img/email-us.png"/></td>
							<td><img alt="" src="<?=base_url()?>img/email-you.png"/></td>
							<td><img alt="" src="<?=base_url()?>img/email-stores.png"/></td>
						
						</tr>
						
					</table> -->	
					
		<table cellspacing="0" cellpadding="0" width="630" align="center" style="margin-top: 20px">
						
						<tr>
							<td style="width:630px; height:45px; line-height:45px; text-align:center; color:#5b5758">
								<a href="<?=base_url()?>"><img alt="" src="<?=base_url()?>img/email-link-footer.png"/></a>
							</td>
							
						</tr>
		</table>
		<table width="630px" align="center" cellpadding="0" cellspacing="0" style="font-size: 16px; color: #403c3c; font-family: times; border-top: 5px solid #000">
		<tr>
			<td>
			</td>
		</tr>
	</table>
</body>
</html>