<?php foreach($landing_pages as $landing_page){ ?>
    <tr>
        <input type="hidden" name="sort[]" value="<?=$landing_page['landing_page_id'];?>">
        <td><?=$landing_page['name'];?></td>
        <td><?=$landing_page['url'];?></td>
        <td class="center">
            <a href="<?=base_url();?>admin/landing_page/edit/<?=$landing_page['landing_page_id'];?>" class="anchor tooltip-alt" data-toggle="tooltip" title="Edit"><i class="icon-edit icon-2x"></i></a>
        </td>
    </tr>
<?php } ?>