<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="keywords" content="" />

<meta name="description" content="" />

<title>SNR</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">

<link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet" media="screen">

<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<!-- <link href="<?=base_url()?>css/datepicker.css" rel="stylesheet" media="screen"> -->
<link href="<?=base_url()?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/jasny-bootstrap.css" rel="stylesheet" media="screen">

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

<style>
h1{
	font-weight : 700;
	font-size:20px!important;
	color: #2084ce
}
h2{
	font-weight : 700;
	font-size:18px!important;
	color: #333
}
.line-between
{
	height: 0px; 
	clear: both; 
	border-top:1px solid #ccc;
}
th
{
	font-weight : 700 !important;
	font-size:15px!important;
}
</style>

</head>



<body>

	<script src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>

	<script src="<?=base_url()?>js/bootstrap.js"></script>
    <script src="<?=base_url()?>js/bootstrap-select.js"></script>
    <script src="<?=base_url()?>js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?=base_url()?>js/jasny-bootstrap.js"></script>
    <script src="<?=base_url()?>js/ckeditor.js"></script>
    <script src="<?=base_url()?>js/config.js"></script>
    <script src="<?=base_url()?>js/styles.js"></script>
    <!-- <script src="<?=base_url()?>js/build-config.js"></script> -->
    <script src="<?=base_url()?>ckfinder/ckfinder.js"></script>
    <script src="<?=base_url()?>ckfinder/config.js"></script>
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
    <!-- <div contenteditable="true"> -->
    	<?=$pages['content']?>
    <!-- </div> -->
</body>
</html>

			