<div class="col-sm-5 hdr-block lt">&nbsp;</div>

<div class="col-sm-2 logo-wrap">
    <a href="<?=base_url();?>"><img src="<?=base_url() . ASSETS;?>img/bared-logo.png" alt="bared-logo.png" title="Bared Footwear Logo"></a>
</div>

<div class="col-sm-5 hdr-block rt">
	 <div class="search-form-wrap">
         <form id="search-form" method="post" action="<?=base_url()?>store/search">
            <div class="form-group has-feedback col-xs-6 x-gutters search-form pull">
              <input type="text" name="keyword" class="form-control app-form-control search-product" placeholder="Search Products...">
              <span class="form-control-feedback pointer search-btn" form-id="search-form"><i class="fa fa-search"></i></span>
            </div>
        </form>
    </div>
    <ul class="cart-info h6">
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
                <span class="hidden-md hidden-sm hidden-xs">Shopping Bag </span>
                <span class="badge app-badge shopping-cart-items tot_shopbag"><?=$count_shopbag;?></span>
            </a>
        </li>
    </ul>
</div>
