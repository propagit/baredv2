<?php
	$hero = $this->Product_model->get_hero($product['id']);
	$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
	$normal_price_arr = explode('.',$product['price']);
	$sale_price_arr = explode('.',$product['sale_price']);
	$cat = $this->Category_model->identify($product['main_category']);
?>
<div class="col-sm-8 x-gutters left hidden-xs">
    <img src="<?=base_url();?>uploads/instagram/<?=$gallery['image'];?>" />
</div>
<div class="col-sm-4 x-gutters right">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     
     <div class="product">
        <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
        <div class="product-info <?=$on_sale;?>">
            <h3><?=$product['title'];?></h3>
            <h4><?=$product['short_desc'];?></h4>
            <h4><?=$sign?>
                <span class="price">
                    <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                     <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                </span>
            </h4>
            <div class="yotpo bottomLine"
                data-appkey="87cmugsJWWCvn4YdAy3U9AcGnlYiUwvpv1TKwE5Z"
                data-domain="bared.com.au"
                data-product-id="<?=$product['review_category']?>"
                data-product-models="<?=$product['title']?>"
                data-name="<?=$product['title']?> <?=$product['short_desc']?>"
                data-url="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$product['id_title']?>"
                data-image-url="The product image url. Url escaped"
                data-description="<?=$product['long_desc']?>"
                data-bread-crumbs="Product categories"
                data-images-star_empty="<?=base_url()?>img/star_empty.png"
                data-images-star_half="<?=base_url()?>img/star_half.png"
                data-images-star_full="<?=base_url()?>img/star_full.png">                                                                            
           </div>
        </div>
        
        <a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>"><div class="btn btn-app">buy now</div>
     </div>
</div>
