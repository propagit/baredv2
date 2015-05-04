<script src="<?=base_url()?>js/ui/jquery-ui-1.11.1.min.js"></script>
<script>
/*** Handle jQuery plugin naming conflict between jQuery UI and Bootstrap ***/
$.widget.bridge('uibutton', $.ui.button);
$.widget.bridge('uitooltip', $.ui.tooltip);
</script>
<!--reload bootstrap.js again-->
<script src="<?=base_url()?>js/bootstrap.js"></script>
<div class="span9">
	<div class="box">

        <h1 class="page-header-alt">Setup landing page</h1>
		<button class="btn btn-primary" id="order">Update Order</button>
        
        
        <form id="sort-form" method="post" action="<?=base_url();?>admin/landing_page/sort_order">
        
            <table class="table table-hover sortable-table"  id="sort">
    
                <thead>
                    <tr>
                        <th style="width: 20%">Name</th>			    			
                        <th style="width: 50%;">URL</th>
                        <th class="center" style="width: 10%;">Edit</th>
                    </tr>
                </thead>
                
                <tbody id="tile-rows">
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
                </tbody>
    
            </table>
        
        </form>
        
        <div class="vgap"></div>
		<button class="btn btn-primary" id="order">Update Order</button>
	</div>
</div>

<!-- confirm delete-->
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Tile</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure to delete this tile?</p>
    </div>
    <div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="delete-url"></span>
    </div>
</div><!-- confirm delete-->

<!-- message modal-->
<div id="anyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Error</h3>
    </div>
    <div class="modal-body">
        <p>You can only have 2 active tiles at one time. Please deactivate a tile first.</p>
    </div>
    <div class="modal-footer">
    	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div><!-- message modal-->
<script>
$(function() {
	$('.tooltip-alt').tooltip({
		showURL: false
	});
	
	get_tiles_by_category();
	
	// delete tile
	$(document).on('click','.delete',function(){
		var tile_id = $(this).attr('data-tile-id');
		$('#delete-url').html('<a class="btn btn-primary" href="<?=base_url();?>admin/tiles/delete/'+tile_id+'">Delete</a>');
		$('#deleteModal').modal('show');
	});
	
	// change status
	$(document).on('click','.change-status',function(){
		var tile_id = $(this).attr('data-tile-id');
		$.ajax({
			url:'<?=base_url();?>admin/tiles/change_status',
			type:'POST',
			dateType:'html',
			data:{tile_id:tile_id},
			success:function(html){
				if(html == 'error'){
					$('#anyModal').modal('show');	
				}else{
					get_tiles_by_category();
				}
			}
		});
	});
	
	// sort
	$(document).on('click','#order',function(){
		$('#sort-form').submit();
	});
});

// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};

$("#sort tbody").sortable({
	helper: fixHelper
}).disableSelection();

function get_tiles_by_category(){
	var category = $('#tile-filter').val();
	$.ajax({
			url:'<?=base_url();?>admin/tiles/ajax_get_tiles_by_category',
			type:'POST',
			dateType:'html',
			data:{category:category},
			success:function(html){
				$('#tile-rows').html(html);
			}
		});	
}

</script>
