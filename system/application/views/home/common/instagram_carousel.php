<div class="app-container relative bar social col-xs-12 x-gutters">
	<div class="segment hidden-xs"><hr></div>
	<div class="segment">
        <h2><span class="hidden-xs">use #baredfootwear </span><i class="fa fa-instagram"></i> <span class="visible-xs">use #baredfootwear </span></h2>
        <h4 class="hidden-xs">to show us how your wear bared on instagram</h4>
    </div>
    <div class="segment hidden-xs"><hr></div>
</div>
<div id="instagram" class="app-container br-top carousel slide multi-carousel gallery" data-ride="carousel" data-type="multi" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <?php for($i = 1;$i < 7; $i++){ ?>
          <div class="item swapper <?=$i == 1 ? 'active' : '';?>">
              <a href="#" data-toggle="modal" data-target="#myModal">
              <div class="col-sm-2">
                  <img src="<?=base_url() . ASSETS;?>img/dummy/instagram<?=$i;?>.jpg" />
              </div>
              </a>
          </div>
          <?php } ?>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#instagram" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#instagram" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>


<div class="modal fade app-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        	<div class="col-sm-8 x-gutters left hidden-xs">
            	<img src="<?=base_url() . ASSETS;?>img/dummy/instagram-featured.jpg">
            </div>
            <div class="col-sm-4 x-gutters right">
            	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 
                 <div class="product">
                 	<img class="hidden-sm" src="<?=base_url() . ASSETS;?>img/dummy/instagram-featured-thumb.jpg">
                    <div class="product-info">
                        <h3>starling</h3>
                        <h4>gold leopard calf hair smoking loafer</h4>
                        <h4>au 
                            <span class="price">
                                <span class="normal-price">$229.<sub>00</sub></span>
                                <span class="sale-price">$179.<sub>00</sub></span>
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
      </div>
    </div>
  </div>
</div>