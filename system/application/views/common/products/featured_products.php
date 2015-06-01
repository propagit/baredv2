<?php if($feature_products){ ?>
<div id="featured" class="app-container multi-carousel br-top carousel slide featured hidden-xs" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php 
		  		$counter = 0;
				#echo '<pre>' . print_r($feature_products,true) . '</pre>';
				$total = count($feature_products);
				$items_per_row = MULTI_CAROUSEL_REC_PER_ROW;
				$num_rows = $total / $items_per_row;
				if(!is_int($num_rows)){
					$num_rows = $num_rows + 1;
				}
				$extra_tiles = ($items_per_row * $num_rows) - $total;
				$active = true;
		  ?>
          <div class="item <?=$active ? 'active' : '';?>">
          <?php 
		  		$item_counter = 0;	
		  	 	foreach($feature_products as $p){
					$product = $this->Product_model->identify($p['id']);
					$hero = $this->Product_model->get_hero($p['id']);
					$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
					$normal_price = number_format($product['price'] * $cur_val,2);
					$sale_price = number_format($product['sale_price'] * $cur_val,2);
					$normal_price_arr = explode('.',$normal_price);
					$sale_price_arr = explode('.',$sale_price);
					
					if($counter < $items_per_row){
		  ?>
                          <a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>">
                          <div class="col-sm-2 product">
                              <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
                              <div class="carousel-caption product-info <?=$on_sale;?>">
                                  <h3><?=$product['title'];?></h3>
                                  <h4><?=$product['short_desc'];?></h4>
                                  <h4><span class="currency"><?=$sign?></span> 
                                    <span class="price">
                                        <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                                        <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                                    </span>
                                  </h4>
                              </div>
                          </div>
                          </a>
                   	 <?php 
			 		 $counter++; 
			  		}else{
					$counter = 0;
					$product = $this->Product_model->identify($p['id']);
					$hero = $this->Product_model->get_hero($p['id']);
					$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
					$normal_price = number_format($product['price'] * $cur_val,2);
					$sale_price = number_format($product['sale_price'] * $cur_val,2);
					$normal_price_arr = explode('.',$normal_price);
					$sale_price_arr = explode('.',$sale_price);
			  ?>
          </div>
          <div class="item">
          			<a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>">
                          <div class="col-sm-2 product">
                              <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
                              <div class="carousel-caption product-info <?=$on_sale;?>">
                                  <h3><?=$product['title'];?></h3>
                                  <h4><?=$product['short_desc'];?></h4>
                                  <h4><span class="currency"><?=$sign?></span> 
                                    <span class="price">
                                        <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                                        <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                                    </span>
                                  </h4>
                              </div>
                          </div>
                          </a>
          <?php 
		  			}
					$active = false;
					$item_counter++; 
				}
				# done with the number of records
				# if extra tiles is needed populate them
				if($extra_tiles){
					for($i = 0; $i < $extra_tiles; $i++){
						if(isset($feature_products[$i])){
						$product = $this->Product_model->identify($feature_products[$i]['id']);
						#print_r($product);
						$hero = $this->Product_model->get_hero($feature_products[$i]['id']);
						$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
						$normal_price = number_format($product['price'] * $cur_val,2);
						$sale_price = number_format($product['sale_price'] * $cur_val,2);
						$normal_price_arr = explode('.',$normal_price);
						$sale_price_arr = explode('.',$sale_price);
				?>
                		  <a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>">
                          <div class="col-sm-2 product">
                              <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
                              <div class="carousel-caption product-info <?=$on_sale;?>">
                                  <h3><?=$product['title'];?></h3>
                                  <h4><?=$product['short_desc'];?></h4>
                                  <h4><span class="currency"><?=$sign?></span> 
                                    <span class="price">
                                        <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                                        <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                                    </span>
                                  </h4>
                              </div>
                          </div>
                          </a>
                <?php	
						}
					}
				}
		 		 ?>
          </div>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#featured" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>




<div id="mob-featured" class="app-container multi-carousel br-top carousel slide featured visible-xs" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php 
				$active = true;
		  	 	foreach($feature_products as $p){
					$product = $this->Product_model->identify($p['id']);
					$hero = $this->Product_model->get_hero($p['id']);
					$on_sale = $product['sale_price'] < $product['price'] ? 'on-sale' : '';
					$normal_price = number_format($product['price'] * $cur_val,2);
					$sale_price = number_format($product['sale_price'] * $cur_val,2);
					$normal_price_arr = explode('.',$normal_price);
					$sale_price_arr = explode('.',$sale_price);

		  ?>
          <div class="item swapper <?=$active ? 'active' : '';?>">
              <a href="<?=base_url()?>store/detail_product/quick_link/<?=$product['id_title']?>">
              <div class="col-sm-2 product">
                  <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/thumb5/<?=$hero['name']?>" />
                  <div class="carousel-caption product-info <?=$on_sale;?>">
                      <h3><?=$product['title'];?></h3>
                      <h4><?=$product['short_desc'];?></h4>
                      <h4><span class="currency"><?=$sign?></span> 
                        <span class="price">
                            <span class="normal-price"><?=$normal_price_arr[0];?>.<sub><?=$normal_price_arr[1];?></sub></span>
                            <span class="sale-price"><?=$sale_price_arr[0];?>.<sub><?=$sale_price_arr[1];?></sub></span>
                        </span>
                      </h4>
                  </div>
              </div>
              </a>      	
          </div>
          <?php $active = false; } ?>
         
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#mob-featured" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#mob-featured" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>
<?php } ?>