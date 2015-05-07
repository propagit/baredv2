<h2>Filter</h2>
<?php
$insta_cur_cat = 'all'; 
if($this->session->userdata('insta_cur_cat')){
    $insta_cur_cat = $this->session->userdata('insta_cur_cat');
}
?>
<select id="instagram-filter" onChange="get_gallery_items_by_category();">
    <option  value="all" <?=$insta_cur_cat == 'all' ? 'selected="selected"' : '';?>>All</option>
    <option  value="<?=MEN?>" <?=$insta_cur_cat == MEN ? 'selected="selected"' : '';?>>Male</option>
    <option  value="<?=WOMEN?>" <?=$insta_cur_cat == WOMEN ? 'selected="selected"' : '';?>>Female</option>
</select> 



<form id="sort-form" method="post" action="<?=base_url();?>admin/instagram_gallery/sort_order">
        
    <table class="table table-hover sortable-table"  id="sort">
    
        <thead>
            <tr>
                <th style="width: 20%">Name</th>			    			
                <th style="width: 50%;">Attached Product</th>
                <th class="center" style="width: 10%;">Category</th>
                <th class="center" style="width: 10%;">Image</th>
                <th class="center" style="width: 10%;">Status</th>
                <th class="center" style="width: 10%;">Delete</th>
            </tr>
        </thead>
        
        <tbody id="gallery-items">
    
        </tbody>
    
    </table>
    <div class="vgap"></div>
	<button class="btn btn-primary" style="float:right;" id="order">Update Order</button>
</form>


<!-- confirm delete-->
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Gallery Item</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure to delete this item?</p>
    </div>
    <div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="delete-url"></span>
    </div>
</div><!-- confirm delete-->

<script>
$(function() {
	$('.tooltip-alt').tooltip({
		showURL: false
	});
	
	get_gallery_items_by_category();
	
	// delete tile
	$(document).on('click','.delete',function(){
		var data_id = $(this).attr('data-id');
		$('#delete-url').html('<a class="btn btn-primary" href="<?=base_url();?>admin/instagram_gallery/delete/'+data_id+'">Delete</a>');
		$('#deleteModal').modal('show');
	});
	
	// change status
	$(document).on('click','.change-status',function(){
		var data_id = $(this).attr('data-id');
		$.ajax({
			url:'<?=base_url();?>admin/instagram_gallery/change_status',
			type:'POST',
			dateType:'html',
			data:{instagram_gallery_id:data_id},
			success:function(html){
				if(html == 'error'){
					$('#anyModal').modal('show');	
				}else{
					get_gallery_items_by_category();
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

function get_gallery_items_by_category(){
	var home_category = $('#instagram-filter').val();
	$.ajax({
			url:'<?=base_url();?>admin/instagram_gallery/ajax_get_gallery_items_by_category',
			type:'POST',
			dateType:'html',
			data:{home_category:home_category},
			success:function(html){
				$('#gallery-items').html(html);
			}
		});	
}

</script>