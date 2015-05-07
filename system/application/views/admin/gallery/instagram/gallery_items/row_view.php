<?php
	#print_r($gallery_items);
	if($gallery_items){
?>

<?php 
	foreach($gallery_items as $item){ 
	$product = $this->Product_model->identify($item['product_id']);
?>
    <tr>
        <input type="hidden" name="sort[]" value="<?=$item['instagram_gallery_id'];?>">
        <td><?=$item['name'];?></td>
        <td><?=$product['title'] . ' - ' . $product['short_desc'];?></td>
        <td class="center"><?=$item['home_category'] == MEN ? 'M' : '<span class="female">F</span>';?></td>
        <td class="center">
            <img height="80" src="<?=base_url();?>uploads/instagram/<?=$item['image']?>" />
        </td>
        <td class="center">
            <a href="javascript:void(0)" class="anchor change-status tooltip-alt" data-id="<?=$item['instagram_gallery_id'];?>" data-toggle="tooltip" title="<?=$item['status'] ? 'Deactivate' : 'Activate';?>">
                <i class="icon-ok-circle icon-2x <?=$item['status'] ? 'icon-active' : 'icon-inactive';?>"></i>
            </a>
        </td>
        <td class="center">
            <a href="javascript:void(0)" class="anchor tooltip-alt delete" data-id="<?=$item['instagram_gallery_id'];?>" data-toggle="tooltip" title="Delete">
                <i class="icon-remove-circle icon-2x icon-danger"></i>
            </a>
        </td>
    </tr>

<?php } ?>


<?php } # end if gallery items?>