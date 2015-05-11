<div class="col-xs-2 x-gutters block">
    <a href="<?=base_url();?>"><img src="<?=base_url(). ASSETS ?>img/bared-logo-sml.png" alt="bared-logo-sml.png" title="Bared Logo"></a>
</div>
<div class="col-xs-9 x-l-gutters block">
    <ul class="acc-info">
        <li>
        	<form id="mon-search-form" method="post" action="<?=base_url()?>store/search">
            <div class="form-group has-feedback col-xs-12 x-gutters search-form">
              <input name="keyword" type="text" class="form-control app-form-control search-product" placeholder="SEARCH">
              <span class="form-control-feedback pointer search-btn" form-id="mob-search-form"><i class="fa fa-search"></i></span>
            </div>
            </form>
        </li>
        <li>
        <a class="app-link" href="<?=base_url()?>cart/list_cart">
            <i class="fa fa-shopping-cart"></i> 
            <span class="badge app-badge shopping-cart-items tot_shopbag"><?=$count_shopbag;?></span>
            </a>
        </li>
    </ul>
</div>
<div class="col-xs-1 x-gutters block">
    <button class="btn pull mob-nav-btn" data-target="#top-nav" data-toggle="collapse" ><i class="fa fa-bars"></i></button>
</div>

