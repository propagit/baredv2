<div id="product-gallery" class="app-container carousel slide" data-ride="carousel" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      	  <?php if($photos){ 
		  			$counter = 0;
		  			foreach($photos as $p){
		  ?>
                      <div class="item <?=!$counter ? 'active' : '';?>">
                          <a href="#">
                              <img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$product['id'])?>/<?=$p['name']?>"/>
                          </a>
                      </div>
          
          <?php
		  			$counter++; 	
				} 
			 } 
		?> 
      </div>
      
       <!-- Controls -->
      <a class="left carousel-control" href="#product-gallery" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#product-gallery" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>