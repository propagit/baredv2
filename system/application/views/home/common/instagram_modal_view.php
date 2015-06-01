<?php
	$hero = $this->Product_model->get_hero($product['id']);
	$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
	$normal_price = number_format($product['price'] * $cur_val,2);
	$sale_price = number_format($product['sale_price'] * $cur_val,2);
	$normal_price_arr = explode('.',$normal_price);
	$sale_price_arr = explode('.',$sale_price);
	$cat = $this->Category_model->identify($product['main_category']);
?>
<div class="modal-body">
    <div class="col-sm-8 x-gutters left hidden-xs">
        <img src="<?=base_url();?>uploads/instagram/<?=$gallery['image'];?>" />
    </div>
    <div class="col-sm-4 x-gutters right">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div class="product" style="margin-top:0;">
            <div class="product-info">
                <h4 class="instagram-header"><?=$gallery['name'];?></h4>
            </div>
         </div>
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
            
            <a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>"><div class="btn btn-app">buy now</div></a>
         </div>
    </div>
<div>
<a class="left carousel-control" onClick="get_modal_view(<?=$next_prev['prev_instagram_gallery_id'];?>,<?=$next_prev['prev_instagram_product_id'];?>);" role="button" data-slide="prev">
    <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
</a>
<a class="right carousel-control" onClick="get_modal_view(<?=$next_prev['next_instagram_gallery_id'];?>,<?=$next_prev['next_instagram_product_id'];?>);" role="button" data-slide="next">
    <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
</a>
