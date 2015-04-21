<div class="tiles-wrap">
	<?php
        $tiles = $this->Tiles_model->get_active_tiles();
        $count = 0;
        if($tiles){
            foreach($tiles as $tile){
				# this is just an extra check to disallow more than 2 tiles. This is also checked in the admin panel
                if($count >=2 ){
                    break;	
                }
    ?>
        <div class="span6">
            <a href="<?=$tile['tile_uri'] ? $tile['tile_uri'] : '#';?>" <?=$tile['new_window'] ? 'target="_blank"' : '';?>><img src="<?=base_url();?>uploads/tiles/<?=$tile['image_name'];?>" alt="<?=$tile['image_name'];?>" title="<?=$tile['name'];?>"></a>
        </div>
    <?php 
                $count++;
            }
        } 
    ?>
</div>
