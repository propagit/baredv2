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
    	<div class="hidden-xs desktop"><?=$this->load->view('common/desktop_header');?></div>
    	<div class="visible-xs mob"><?=$this->load->view('common/mob_header');?></div>
    </div>    
</header> 

<?php $this->load->view('common/nav/main_view'); ?>














