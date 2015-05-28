<div class="app-container relative bar social col-xs-12 x-gutters">
	<div class="segment hidden-xs"><hr></div>
	<div class="segment">
        <h2><span class="hidden-xs">use #baredfootwear </span><i class="fa fa-instagram"></i> <span class="visible-xs">use #baredfootwear </span></h2>
        <h4 class="hidden-xs">to show us how your wear bared on instagram</h4>
    </div>
    <div class="segment hidden-xs"><hr></div>
</div>
<div id="instagram" class="app-container br-top carousel slide gallery hidden-xs" data-ride="carousel" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      	  <?php 
		  	$counter = 0;
			$active = true;
			$items_per_row = 6;
			$total = count($instagram_gallery);
			$num_rows = $total % $items_per_row;
			$extra_tiles = ($items_per_row * $num_rows) - $total;
			
		 ?>
         <div class="item <?=$active ? 'active' : '';?>">
			 <?php	
                foreach($instagram_gallery as $gallery){ 
					if($counter < $items_per_row){	
              ?> 
                          <a href="javascript:get_modal_view(<?=$gallery['instagram_gallery_id'];?>,<?=$gallery['product_id'];?>);">
                              <div class="col-sm-2 instagram-item">
                                  <img src="<?=base_url();?>uploads/instagram/<?=$gallery['image'];?>" />
                              </div>
                          </a>   
              <?php 
			 		 $counter++; 
			  		}else{
					$counter = 0;
			  ?>
			 </div>
             <div class="item">
             	 <a href="javascript:get_modal_view(<?=$gallery['instagram_gallery_id'];?>,<?=$gallery['product_id'];?>);">
                      <div class="col-sm-2 instagram-item">
                          <img src="<?=base_url();?>uploads/instagram/<?=$gallery['image'];?>" />
                      </div>
                  </a> 
			 <?php	
					}
					$active = false;
				}
				# done with the number of records
				# if extra tiles is needed populate them
				if($extra_tiles){
					for($i = 0; $i < $extra_tiles; $i++){
				?>
                	<a href="javascript:get_modal_view(<?=$instagram_gallery[$i]['instagram_gallery_id'];?>,<?=$instagram_gallery[$i]['product_id'];?>);">
                      <div class="col-sm-2 instagram-item">
                          <img src="<?=base_url();?>uploads/instagram/<?=$instagram_gallery[$i]['image'];?>" />
                      </div>
                   </a>
                <?php	
					}
				}
				
				?>
          </div>
      </div>
      
      <!-- Controls -->
      <a class="left carousel-control" href="#instagram" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#instagram" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>


<div id="instagram-mob" class="app-container br-top carousel slide gallery visible-xs" data-ride="carousel" data-interval="false">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      		<?php
				$mob_active = true; 
				foreach($instagram_gallery as $gallery){ 
			?>
            	<div class="item swapper mob-carousel-item <?=$mob_active ? 'active' : '';?>">
                	<a href="javascript:get_modal_view(<?=$gallery['instagram_gallery_id'];?>,<?=$gallery['product_id'];?>);">
                      <div class="col-xs-12">
                          <img src="<?=base_url();?>uploads/instagram/<?=$gallery['image'];?>" />
                      </div>
                  	</a> 
                </div>
            <?php $mob_active = false;} ?>
         
      </div>
      <!-- Controls -->
      <a class="left carousel-control" href="#instagram" role="button" data-slide="prev">
          <span class="slide-btn"><i class="fa fa-angle-left"></i></span>
      </a>
      <a class="right carousel-control" href="#instagram" role="button" data-slide="next">
          <span class="slide-btn"><i class="fa fa-angle-right"></i></span>
      </a>
</div>


<div class="modal fade app-modal" id="instagramModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" id="instagram-modal-content">

      </div>
    </div>
  </div>
</div>
<script>
function get_modal_view(instagram_gallery_id,product_id){
	$('#instagramModal').modal('show');
	$.ajax({
		url:'<?=base_url();?>home/get_instagram_product',
		type:'POST',
		dateType:'html',
		data:{instagram_gallery_id:instagram_gallery_id,product_id:product_id},
		success:function(html){
			$('#instagram-modal-content').html(html);
		}
	});	
}

$(function(){
	app.adjust_element_height('#instagram','.instagram-item');
	
	setTimeout(function(){
		app.adjust_element_height('#instagram','.instagram-item');
	},500);
	
	
	
});

$(window).resize(function(){
	app.adjust_element_height('#instagram','.instagram-item');
});
</script>