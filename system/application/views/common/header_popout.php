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
</head>



<body>
	<script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>

	<script src="<?=base_url()?>js/bootstrap.js"></script>
	<script src="<?=base_url()?>js/select2/select2.js"></script>
	<script src="<?=base_url()?>js/zoome.js"></script>
	<script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
	<script src="<?=base_url()?>js/jquery.placeholder.js"></script>
	<script src="<?=base_url()?>js/magiczoom.js"></script>