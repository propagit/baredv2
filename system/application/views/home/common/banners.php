<div id="banners" class="app-container carousel slide" data-ride="carousel" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      	  <?php if($banners){ 
		  			$counter = 0;
		  			foreach($banners as $banner){
		  ?>
                      <div class="item <?=!$counter ? 'active' : '';?>">
                          <a href="<?=$banner['url'] != '' ? $banner['url'] : '';?>">
                              <img src="<?=base_url();?>uploads/banners/ori/<?=$banner['name'];?>"  alt="<?=$banner['name'];?>"/>
                              <div class="carousel-caption visible-xs">
                                  <h3><?=$banner['caption'];?></h3>
                              </div>
                          </a>
                      </div>
          
          <?php
		  			$counter++; 	
				} 
			 } 
		?> 
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#banners" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#banners" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>