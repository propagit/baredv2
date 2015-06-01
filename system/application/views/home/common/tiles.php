<div class="app-container tiles br-top">
	<?php 
		if($tiles){
			foreach($tiles as $tile){
	?>
	<div class="col-sm-4 tile">
    	<a class="btn-tile" href="<?=$tile['tile_uri'] ? $tile['tile_uri'] : '#';?>" <?=$tile['new_window'] ? 'target="_blank"' : '';?>>
    	<img src="<?=base_url();?>uploads/tiles/<?=$tile['image_name'];?>" alt="<?=$tile['image_name'];?>">
        </a>
        <?php if($tile['btn_visibility']){ ?>
        <div class="tile-btn-wrap"><a class="btn-tile" href="<?=$tile['tile_uri'] ? $tile['tile_uri'] : '#';?>" <?=$tile['new_window'] ? 'target="_blank"' : '';?>><?=$tile['btn_name'];?></a></div>
        <?php } ?>
        <a class="btn-tile" href="<?=$tile['tile_uri'] ? $tile['tile_uri'] : '#';?>" <?=$tile['new_window'] ? 'target="_blank"' : '';?>>
        <div class="caption <?=$tile['caption'] == '' ? 'hide' : '';?>">
        	<h3><?=$tile['caption'];?></h3>
        </div>
        </a>
    </div>
    <?php 	
			} 
		 } 
	?> 
</div>