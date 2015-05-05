<!-- app css -->
<link rel="stylesheet" href="<?=base_url() . ASSETS;?>css/app.css">

<div class="app-container tiles br-top landing-page">
	<?php foreach($landing_pages as $landing_page){ 	
		  $default_url = ($landing_page['landing_page_id'] == 1) ? 'men' : 'women';
	?>
      <div class="col-sm-6 tile">
          <img src="<?= base_url();?>uploads/landing_page/<?=$landing_page['image_name'];?>"/>
          <div class="tile-btn-wrap">
              <a href="<?=(trim($landing_page['url'] == '') ? base_url() . 'home/' . $default_url : $landing_page['url']);?>"><div class="btn-tile"><?= $landing_page['name']; ?></div></a>
          </div>
      </div> 
    <?php } ?>
</div>





