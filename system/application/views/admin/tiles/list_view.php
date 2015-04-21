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

        <h1 class="page-header-alt">Manage Tiles</h1>
        <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/tiles/create'">Create A Tile</button>
		<button class="btn btn-primary" id="order">Update Order</button>
        
        
       <h1 class="page-header-alt">Filter</h1>
          <select id="tile-filter" onChange="get_tiles_by_category();">
              <option <?=$category == 'all' ? 'selected="selected"' : '';?> value="all">All</option>
              <option <?=$category == '1' ? 'selected="selected"' : '';?> value="1">Male</option>
              <option <?=$category == '2' ? 'selected="selected"' : '';?> value="2">Female</option>
          </select>        
        <hr>
        
        <form id="sort-form" method="post" action="<?=base_url();?>admin/tiles/sort_order">
        
            <table class="table table-hover sortable-table"  id="sort">
    
                <thead>
                    <tr>
                        <th style="width: 20%">Name</th>			    			
                        <th style="width: 50%;">URL</th>
                        <th class="center" style="width: 10%;">Category</th>
                        <th class="center" style="width: 10%;">Edit</th>
                        <th class="center" style="width: 10%;">Status</th>
                        <th class="center" style="width: 10%;">Delete</th>
                    </tr>
                </thead>
                
                <tbody id="tile-rows">

                </tbody>
    
            </table>
        
        </form>
        
        <div class="vgap"></div>
        <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/tiles/create'">Create A Tile</button>
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
