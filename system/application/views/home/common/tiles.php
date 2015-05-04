<div class="app-container tiles br-top">
	<?php 
		$btn = array('shop new','MICAH GIANELLI’S TOP PICKS','SUMMER CMPAIGN OUT NOW');
		$caption = array("'parrot' monk - in navy", "micah gianelli hot pring", "summer flip flops");
		for($i = 1; $i < 4; $i++){
	?>
	<div class="col-sm-4 tile">
    	<img src="<?=base_url() . ASSETS;?>img/dummy/tile<?=$i;?>.jpg">
        <div class="tile-btn-wrap"><button class="btn-tile"><?=$btn[$i-1];?></button></div>
        <div class="caption">
        	<h3><?=$caption[$i-1];?></h3>
        </div>
    </div>
    <?php } ?> 
</div>