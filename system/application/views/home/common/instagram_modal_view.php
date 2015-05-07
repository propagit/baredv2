<?php
	$hero = $this->Product_model->get_hero($product['id']);
	$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
	$normal_price_arr = explode('.',$product['price']);
	$sale_price_arr = explode('.',$product['sale_price']);
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
            <h4>au 
                <span class="price">
                    <span class="normal-price">$<?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                     <span class="sale-price">$<?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                </span>
            </h4>
            <span class="raiting">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star off"></i>
            </span>
        </div>
        
        <button class="btn btn-app">buy now</button>
     </div>
</div>