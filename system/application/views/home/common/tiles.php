<div class="app-container tiles br-top">
	<?php 
		if($tiles){
			foreach($tiles as $tile){
	?>
	<div class="col-sm-4 tile">
    	<img src="<?=base_url();?>uploads/tiles/<?=$tile['image_name'];?>" alt="<?=$tile['image_name'];?>">
        <?php if($tile['btn_visibility']){ ?>
        <div class="tile-btn-wrap"><a class="btn-tile" href="<?=$tile['tile_uri'] ? $tile['tile_uri'] : '#';?>" <?=$tile['new_window'] ? 'target="_blank"' : '';?>><?=$tile['btn_name'];?></a></div>
        <?php } ?>
        <div class="caption">
        	<h3><?=$tile['caption'];?></h3>
        </div>
    </div>
    <?php 	
			} 
		 } 
	?> 
</div>