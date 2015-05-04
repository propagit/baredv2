<div class="app-container relative bar bg-black text-white"><h3>our latest range</h3></div>
<div id="featured" class="app-container br-top carousel slide multi-carousel featured" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php for($i = 1;$i < 7; $i++){ ?>
          <div class="item <?=$i == 1 ? 'active' : '';?>">
              <a href="#">
              <div class="col-sm-2 product">
                  <img src="<?=base_url() . ASSETS;?>img/dummy/feature<?=$i;?>.jpg" />
                  <div class="carousel-caption product-info <?=$i == 3 ? ' on-sale' : '';?>">
                      <h3>Kiwi 2</h3>
                      <h4>Back & Patent</h4>
                      <h4><span class="currency">au</span> 
                      	<span class="price">
                      		<span class="normal-price">$229.<sub>00</sub></span>
                            <span class="sale-price">$179.<sub>00</sub></span>
                        </span>
                      </h4>
                  </div>
              </div>
              </a>
          </div>
          <?php } ?>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#featured" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>