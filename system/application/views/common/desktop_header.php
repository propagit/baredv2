<div class="col-sm-5 hdr-block lt">
    <span class="h6 block">
        <span class="fw-700 block">Free Shipping</span>
        <span class="visible-lg">Australia wide on order over $150!</span>
        <span class="hidden-lg">AU wide on order over $150!</span>
    </span>
    
    <form id="search-form" method="post" action="<?=base_url()?>store/search">
    <div class="form-group has-feedback col-xs-5 x-gutters search-form">
      <input type="text" name="keyword" class="form-control app-form-control search-product" placeholder="Search Products...">
      <span class="form-control-feedback pointer search-btn" form-id="search-form"><i class="fa fa-search"></i></span>
    </div>
    </form>
</div>

<div class="col-sm-2 logo-wrap">
    <a href="<?=base_url();?>"><img src="<?=base_url() . ASSETS;?>img/bared-logo.png" alt="bared-logo.png" title="Bared Footwear Logo"></a>
</div>

<div class="col-sm-5 hdr-block rt">
    <span class="h6 fw-700 block acc-access">
        
        <?php 
			if($this->session->userdata('userloggedin')){
			$user = $this->session->userdata('userloggedin');
			$cust = $this->Customer_model->identify($user['customer_id']);
		?>
        <a class="app-link" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>"><i class="fa fa-user"></i>  Welcome - <?=$cust['firstname']?></a> /
        <a class="app-link" href="<?=base_url()?>store/signout">Logout</a>
        <?php }else{ 	?>
        <i class="fa fa-unlock-alt"></i> 
        <a class="app-link" href="<?=base_url()?>store/register">Register</a> /
        <a class="app-link" href="<?=base_url()?>store/signin">Login</a>
        <?php } ?>
    </span>
    <ul class="acc-info h6">
        <li>
            <a class="app-link" href="<?=base_url()?>cart/wishlist">
                <i class="fa fa-heart"></i> 
                <span class="hidden-md hidden-sm hidden-xs">Wish List </span>
                <span class="badge app-badge wish-list tot_wishlist"><?=$count_wishlist;?></span>
            </a>
        </li>
        <li>
        	<a class="app-link" href="<?=base_url()?>cart/list_cart">
                <i class="fa fa-shopping-cart"></i> 
                <span class="hidden-md hidden-sm hidden-xs">Shopping Cart </span>
                <span class="badge app-badge shopping-cart-items tot_shopbag"><?=$count_shopbag;?></span>
            </a>
        </li>
    </ul>
</div>
