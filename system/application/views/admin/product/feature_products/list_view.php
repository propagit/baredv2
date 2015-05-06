
<?php
 $n = 0;
if($features) { 
	foreach ($features as $product) {
	$n++;
?>
		<div class="box_container" style="padding-left:7px; float: left">
			<div class="item" style="float:left;padding-right:10px;">
				<?php
				$hero = $this->Product_model->get_hero($product['id']);
				if ($hero) {
				 ?>
					<img src="<?= base_url() ?>uploads/products/<?= md5('mbb' . $product['id']) ?>/thumb3/<?= $hero['name'] ?>" />                
				<?php } else { ?>
					<img src="http://placehold.it/89x97"/> 
				<?php } ?>
	
				<div class="nav" style="margin-top:10px;" >
					<a href="javascript:removefeature(<?= $product['id'] ?>)" style="text-decoration:none;" data-toggle="tooltip" title="Remove this item"><i class="icon-trash icon-2x"></i></a>
		<?php if ($n > 1) { ?><a style="text-decoration:none;" data-toggle="tooltip" title="Move this item" href="<?= base_url() ?>admin/store/movefeature/<?= $product['id'] ?>/-1"><i class="icon-circle-arrow-left icon-2x"></i></a><?php } ?>
		<?php if ($n < count($features)) { ?><a style="text-decoration:none;" data-toggle="tooltip" title="Move this item" href="<?= base_url() ?>admin/store/movefeature/<?= $product['id'] ?>/1"><i class="icon-circle-arrow-right icon-2x"></i></a><?php } ?>
				</div>
			</div>
	
		</div>                 
<?php 
	}
} 
?>
<?php if($this->session->flashdata('addft_true')) { ?>
<p class="error">Error: maximum 6 features products in the homepage</p>
<?php } ?>  