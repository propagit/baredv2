<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$product['title']?> - Product Cross Sale Items</title>
<link href="<?=base_url()?>css/bootstrap.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">

<link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet" media="screen">

<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<link href="<?=base_url()?>css/bootstrap-tree.css" rel="stylesheet" media="screen">
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

<script>
function removecrosssale(id) {
	if(confirm('Are you sure you want to remove this item from cross sale list?')) {
		window.location = '<?=base_url()?>admin/store/removecrosssale/' + id;
	}
}
function searchproduct() {
	var keyword = $('#keyword').val();
	var category = $('#category').val();
	$.ajax({
		url: '<?=base_url()?>admin/store/searchcrosssale/',
		type: 'POST',
		data: ({product_id:'<?=$product['id']?>',keyword:keyword,category:category}),
		dataType: "html",
		success: function(html) {
			$('#addcrosssale').html(html);
		}
	})
}
</script>



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
    <script src="<?=base_url()?>ckfinder/ckfinder.js"></script>
    <script src="<?=base_url()?>ckfinder/config.js"></script>
    <!-- <script src="<?=base_url()?>js/bootstrap-datepicker.js"></script> -->

	<!-- start here -->
	

<div class="row">
	<div class="span12">
		<h1>Related Products</h1>
		<h5>Add related products to work as cross sale items when this product is displayed</h5>
		
		<div class="thumb1" style="float: left; text-align: center">
        	<?php if($thumb) { ?>
        	<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb2/<?=$thumb['name']?>" />
            <p><?=$product['title']?><br /><b>$<?=$product['price']?></b></p>
            <?php } else { ?>
            No image
            <?php } ?>
        </div>
        
        <div class="crosssale" style="float: left; margin-left: 40px;">
        	<h4>Cross sale items</h4>
            <?php $n = 0; if($crosssales) foreach($crosssales as $crosssale) { $n++; ?>
            <div class="item" style="float: left; margin-right: 10px;">
            <?php $hero = $this->Product_model->get_hero($crosssale['related']); 
				if ($hero) { ?>
                <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$hero['product_id'])?>/thumb3/<?=$hero['name']?>" />                
                <?php } else { ?>
                No image
                <?php } ?>
                <div class="nav" style="text-align: center">
                	<a style="text-decoration: none" href="javascript:removecrosssale(<?=$crosssale['id']?>)" title="Remove this item">
                		<!-- <img src="<?=base_url()?>img/backend/icon-delete.png" /> -->
                		<i class="icon-2x  icon-remove-sign"></i>
                	</a>
                	<?php if($n>1) { ?>
                		<a style="text-decoration: none" href="<?=base_url()?>admin/store/movecrosssale/<?=$crosssale['id']?>/-1">
                			<!-- <img src="<?=base_url()?>img/backend/icon-moveleft.png" /> -->
                			<i class="icon-2x  icon-circle-arrow-left"></i>
                		</a>
                	<?php } ?>
                	<?php if($n<count($crosssales)) { ?>
                		<a style="text-decoration: none" href="<?=base_url()?>admin/store/movecrosssale/<?=$crosssale['id']?>/1">
                			<!-- <img src="<?=base_url()?>img/backend/icon-moveright.png" /> -->
                			<i class="icon-2x  icon-circle-arrow-right"></i>
                		</a>
                	<?php } ?>
                </div>
            </div>
            <?php } ?>
            <dl></dl>
            <?php if($this->session->flashdata('addcs_true')) { ?>
            <p class="error">Error: maximum 3 cross sale items for each product</p>
            <?php } ?>
            
        </div>
        
        <div style="clear: both; border-top: 1px solid #ccc;"></div>
        
        <div class="box">
    	<h1>Search Product</h1>
    	<div style="float:left; width: 100px; line-height: 30px;">
    		Keyword
    	</div>
    	<div>
    		<input id="keyword" class="textfield rounded" type="text" value="" name="keyword" style="height: 30px;">
    	</div>
    	<div style="clear: both; height: 10px;">
    	</div>
    	<div style="float:left; width: 100px; line-height: 30px">
    		Category
    	</div>
    	<div>
    		<select id="category">
                <option value="0">All categories</option>
                <?php foreach($main as $maincat) { ?>
                <option value="<?=$maincat['id']?>"><?=$maincat['title']?></option>
                <?php $sub = $this->Category_model->get($maincat['id']);
                    foreach($sub as $subcat) { ?>
                    <option value="<?=$subcat['id']?>"><?=$maincat['title']?> &raquo; <?=$subcat['title']?></option>
                    <?php } ?>                        
                <?php } ?>
            </select>
    	</div>
    	<div style="clear: both; height: 10px;">
    	</div>
        <!-- <dl class="one"><dt>Keyword</dt><dd><input type="text" class="textfield rounded" id="keyword" /></dd>
            <dd class="error"><?=$this->session->flashdata('error_input')?></dd>
        </dl> -->
        <!-- <dl class="one"><dt>Category</dt><dd id="position"> -->
        <div style="float:left; width: 100px;">
    		&nbsp;
    	</div>
    	<div>
    		<button class="btn btn-inverse" type="button" onclick="searchproduct()">Search</button>
    	</div>
    	<div style="clear: both; height: 10px;">
    	</div> 
        <!-- </dd><dd><input type="button" class="button rounded" value="Search" onclick="searchproduct()" /></dd></dl> -->
        <dl></dl>
  	</div>
    <div id="addcrosssale">
    
    </div>
	</div>
</div>          
</body>