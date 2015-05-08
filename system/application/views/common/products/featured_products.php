<?php if($feature_products){ ?>
<div id="featured" class="app-container br-top carousel slide multi-carousel featured" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php 
		  		$counter = 0;
				#echo '<pre>' . print_r($feature_products,true) . '</pre>';
		  	 	foreach($feature_products as $p){
					$product = $this->Product_model->identify($p['id']);
					$hero = $this->Product_model->get_hero($p['id']);
					$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
					$normal_price_arr = explode('.',$product['price']);
					$sale_price_arr = explode('.',$product['sale_price']);
		  ?>
                     <div class="item swapper <?=!$counter ? 'active' : '';?>">
                          <a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>">
                          <div class="col-sm-2 product">
                              <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
                              <div class="carousel-caption product-info <?=$on_sale;?>">
                                  <h3><?=$product['title'];?></h3>
                                  <h4><?=$product['short_desc'];?></h4>
                                  <h4><span class="currency">au</span> 
                                    <span class="price">
                                        <span class="normal-price">$<?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                                        <span class="sale-price">$<?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                                    </span>
                                  </h4>
                              </div>
                          </div>
                          </a>
                      </div>
          <?php $counter++;} ?>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#featured" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>
<?php } ?>