<?php $this->load->view('home/common/banners'); ?>

<?php $this->load->view('home/common/tiles');?>

<?php if($feature_products){ ?>
<?php if(0){ # black bar kept for reference ?>
<!--<div class="app-container relative bar bg-black text-white"><h3>features</h3></div>-->
<?php } ?>
<div class="app-container relative bar social featured col-xs-12 x-gutters">
	<div class="segment hidden-xs"><hr></div>
	<div class="segment">
        <h2>featured products</h2>
    </div>
    <div class="segment hidden-xs"><hr></div>
</div>
<?php $this->load->view('common/products/featured_products'); ?>
<?php } ?>

<?php if($instagram_gallery){ ?>
<?php $this->load->view('home/common/instagram_carousel'); ?>
<?php } ?>
