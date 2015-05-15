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
      	  <?php 
		  	$counter = 0;
		  	foreach($instagram_gallery as $gallery){ 
		  		
		  ?>
      			<div class="item swapper <?=!$counter ? 'active' : '';?>">
                  <a href="javascript:get_modal_view(<?=$gallery['instagram_gallery_id'];?>,<?=$gallery['product_id'];?>);">
                      <div class="col-sm-2 instagram-item">
                          <img src="<?=base_url();?>uploads/instagram/<?=$gallery['image'];?>" />
                      </div>
                  </a>
               </div>
          <?php $counter++; } ?>
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