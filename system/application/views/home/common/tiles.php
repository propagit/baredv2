<div class="app-container tiles br-top">
	<?php 
		if($tiles){
			foreach($tiles as $tile){
	?>
	<div class="col-sm-4 tile">
    	<img src="<?=base_url();?>uploads/tiles/<?=$tile['image_name'];?>" alt="<?=$tile['image_name'];?>">
        <div class="tile-btn-wrap"><button class="btn-tile"><?=$tile['btn_name'];?></button></div>
        <div class="caption">
        	<h3><?=$tile['caption'];?></h3>
        </div>
    </div>
    <?php 	
			} 
		 } 
	?> 
</div>