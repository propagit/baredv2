<?php $this->load->view('home/common/banners'); ?>

<?php $this->load->view('home/common/tiles');?>

<?php if($feature_products){ ?>
<div class="app-container relative bar bg-black text-white"><h3>our latest range</h3></div>
<?php $this->load->view('common/products/featured_products'); ?>
<?php } ?>

<?php if($instagram_gallery){ ?>
<?php $this->load->view('home/common/instagram_carousel'); ?>
<?php } ?>
