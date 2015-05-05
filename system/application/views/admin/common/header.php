<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="keywords" content="<?=META_KEYWORDS?>" />

<meta name="description" content="<?=META_DESC?>" />

<title><?=META_TITLE?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/admin.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">

<link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet" media="screen">

<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bootstrap-tree.css" rel="stylesheet" media="screen">
<!-- <link href="<?=base_url()?>css/datepicker.css" rel="stylesheet" media="screen"> -->
<link href="<?=base_url()?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/jasny-bootstrap.css" rel="stylesheet" media="screen">

<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>


</head>



<body>

	<script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>

	<script src="<?=base_url()?>js/bootstrap.js"></script>
    <script src="<?=base_url()?>js/bootstrap-select.js"></script>
    <script src="<?=base_url()?>js/bootstrap-tree.js"></script>
    <script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?=base_url()?>js/jasny-bootstrap.js"></script>
    <script src="<?=base_url()?>js/ckeditor.js"></script>
    <script src="<?=base_url()?>js/config.js"></script>
    <script src="<?=base_url()?>js/styles.js"></script>
    <!-- <script src="<?=base_url()?>js/build-config.js"></script> -->
    <!-- <script src="<?=base_url()?>ckfinder/ckfinder.js"></script> -->
    <!-- <script src="<?=base_url()?>ckfinder/config.js"></script> -->
    <!-- <script src="<?=base_url()?>js/bootstrap-datepicker.js"></script> -->

	<!-- start here -->
	
    <script>
	function logout()
	{
		window.location='<?=base_url()?>admin/logout';
	}
	function dashboard()
	{
		window.location='<?=base_url()?>admin/cms';
	}
	</script>
    
	<div id="main-header" class="navbar navbar-inverse navbar-fixed-top">

		<div class="navbar-inner" style="background: #ffffff; border: none; box-shadow: none">

			<!-- <div style="height: 115px;">&nbsp;</div> -->

			<div style="height: 105px; background: #000;">

				<div class="container">

					<div style="margin-left: 19px; float: left; margin-top: 6px;">

						<img src="<?=base_url()?>img/new_admin/admin-logo.png" alt="company-logo"/>

					</div>

					<div style="margin-right: 19px; float: right; margin-top: 14px;">

						<div>
							<!--color: #2084ce-->
							<div style="float: right;"><button class="btn " type="button" onclick="javascript:logout();">Logout</button></div>

							<div style="float: right; margin-right: 9px;"><button  class="btn " type="button" onclick="javascript:dashboard();">Dashboard</button></div>

							<div style="clear: both"></div>

						</div>

						<div style="clear: both; height: 13px"></div>
						<form method="post" action="<?=base_url()?>admin/cms/search_all_admin">
					    <div class="input-append">

						    <input placeholder="product or customer name" class="span2" id="appendedInputButton" type="text" name="keyword">

						    <button class="btn" type="submit">Search <i class="icon-search"></i></button>

					    </div>
						</form>
						

					</div>

					<div style="clear: both"></div>

				</div>

			</div>
			<div style="height: 17px; background: url('<?=base_url()?>img/new_admin/header-shadow.png'); background-position:center">
				&nbsp;
			</div>

			<div class="container" style="margin-top: -10px; margin-bottom: 10px">

				<div style="margin-right: 19px; float: right; font-size: 14px;">

					Logged in as: <span style="font-weight: 600">Onlinemerchandis</span>

				</div>

				<div style="clear: both"></div>

			</div>

		</div>

	</div>

	<!-- end here -->

	<div class="container">

		<div class="row">

			