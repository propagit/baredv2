<?php foreach($tiles as $tile){ ?>
    <tr>
        <input type="hidden" name="sort[]" value="<?=$tile['tile_id'];?>">
        <td><?=$tile['name'];?></td>
        <td><?=$tile['tile_uri'];?></td>
        <td class="center"><?=$tile['category'] == MEN ? 'M' : '<span class="female">F</span>';?></td>
        <td class="center">
            <a href="<?=base_url();?>admin/tiles/edit/<?=$tile['tile_id'];?>" class="anchor tooltip-alt" data-toggle="tooltip" title="Edit"><i class="icon-edit icon-2x"></i></a>
        </td>
        <td class="center">
            <a href="javascript:void(0)" class="anchor change-status tooltip-alt" data-tile-id="<?=$tile['tile_id'];?>" data-toggle="tooltip" title="<?=$tile['status'] ? 'Deactivate' : 'Activate';?>">
                <i class="icon-ok-circle icon-2x <?=$tile['status'] ? 'icon-active' : 'icon-inactive';?>"></i>
            </a>
        </td>
        <td class="center">
            <a href="javascript:void(0)" class="anchor tooltip-alt delete" data-tile-id="<?=$tile['tile_id'];?>" data-toggle="tooltip" title="Delete">
                <i class="icon-remove-circle icon-2x icon-danger"></i>
            </a>
        </td>
    </tr>
<?php } ?>