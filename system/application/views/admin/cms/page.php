<script>
$(function() {       
	getcats();
	getcats2(); 
	getcats21(); 
	jQuery('.selectpicker').selectpicker();
	
	var cur_cat = 0;
});
function addnewpage()
{
	var title = $('#name_new').val();
	var cat = $('#parent_id_new').val();
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/addingpage',
		type: 'POST',
		data: ({title:title,category_id:cat}),
		dataType: "html",
		success: function(html) {
			getpages();
			$('#newpageModal').modal('hide');
			//getpages();
		}
	})	
}
function getcats() {
	//var location_id = $j('#location_id').val();
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getcats',
		type: 'POST',
		data: ({location_id:0,id_cat:<?=$id_cat?>}),
		dataType: "html",
		success: function(html) {
			jQuery('#cats').html(html);
			getpages();
		}
	})	
}
function addcat() {
	if(jQuery('#name').val() == "") {
		alert('Please enter a name for new category');
	} else {
		document.addForm.submit();
	}
}
function getcats2() {
	//var category_id = jQuery('#category_id').val();
	var category_id=1;
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getcats2',
		type: 'POST',
		data: ({category_id:category_id,location_id:0}),
		dataType: "html",
		success: function(html) {
			jQuery('.cats2').html(html);
		}
	})	
}

function getcats21() {
	//var category_id = jQuery('#category_id').val();
	var category_id=1;
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getcats21',
		type: 'POST',
		data: ({category_id:category_id,location_id:0}),
		dataType: "html",
		success: function(html) {
			jQuery('.cats21').html(html);
		}
	})	
}

function getpages()
{
	
	var id = jQuery('#category_id').val();
	jQuery('#parent_id_new').val(id);
	cur_cat = id;
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getcatetitle',
		type: 'POST',
		data: ({category_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#cat-name').html(html);
		}
	})
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getpages',
		type: 'POST',
		data: ({category_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#all_page').html(html);
		}
	})
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getpages3',
		type: 'POST',
		data: ({category_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#all_div').html(html);
		}
	})
}

function deletepage(id)
{
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/deletepage',
		type: 'POST',
		data: ({page_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#any_message').html('This page has been successfully deleted');
			$('#anyModal').modal('show');
		}
	})
	$('#deleteModal-'+id).modal('toggle');
	jQuery('#page-'+id).fadeOut('slow');
}

function showcopymodal(id)
{
	getcats2(); 
	$('#copyModal-'+id).modal('show');
}

function showmodal(id)
{
	//alert(id);
	$('#deleteModal-'+id).modal('show');
}

function submitcopy(id)
{
	jQuery('#copyForm-'+id).submit();
}

function show_catdeleteModal()
{
	//alert('aa');
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getcatetitle',
		type: 'POST',
		data: ({category_id:cur_cat}),
		dataType: "html",
		success: function(html) {
			jQuery('#cat-delete-name').html(html);
			$('#catdeleteModal').modal('show');
		}
	})
	
}

function deletecat()
{
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/deletecategory',
		type: 'POST',
		data: ({category_id:cur_cat}),
		dataType: "html",
		success: function(html) {
			location.reload(); 
		}
	})
}

function changetitle(id)
{
	var new_name = jQuery('#change-name-'+id).val();
	$('#editModal-'+id).modal('hide');
	//alert(new_name);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/updatepagetitle',
		type: 'POST',
		data: ({id:id,title:new_name}),
		dataType: "html",
		success: function(html) {
			var text = '<a href="#editModal-'+id+'" data-toggle="modal">'+new_name+'</a>';
			jQuery('#listname-'+id).html(text);
			jQuery('#any_message').html("This page's name has been successfully changed");
			$('#anyModal').modal('show');
			
		}
	})
}

function showgallerymodal(id)
{
	$('#galleryModal-'+id).modal('show');
}

function setgallery(id)
{
	var gallery_id = jQuery('#gal-select-'+id).val();
	$('#galleryModal-'+id).modal('hide');
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/updatepagegallery',
		type: 'POST',
		data: ({id:id,gallery_id:gallery_id}),
		dataType: "html",
		success: function(html) {
			jQuery('#any_message').html("This gallery has been successfully set for this page");
			$('#anyModal').modal('show');
			
		}
	})
}

function editpage(id)
{
	window.location = "<?=base_url()?>admin/cms/editpage/"+id;
}

function showpage(id)
{
	window.location = "<?=base_url()?>admin/cms/showpage/"+id;
}
</script>
<style>
.list_header
{
	height: 45px; line-height: 45px; font-weight: 900; font-size: 15px; float: left;
}
.list_data
{
	height: 45px; line-height: 45px; font-size: 14px; float: left;
}
.list_icon
{
	padding-top: 8px; cursor: pointer;
}
.list_center
{
	text-align: center;
}
.list_line
{
	clear: both; border-top: 1px solid #dedede;
}
</style>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
			<h1 style="padding-left:7px;">Manage Pages</h1>
			<div style="padding-left:7px;">

				<div style="float: left; margin-right: 10px">
						<div id="cats">
					   
                        <select class="selectpicker">
                        <option>Select Page Category</option>
						                   
                        </select>
                       
                        </div>

				</div>
				<!--
				<div style="float: left">

					<a style="color: #fff;" href="#myModal"  class="btn btn-primary" data-toggle="modal">Add New Categories</a>

				</div>
				-->
				<div style="float: right">
					<a style="color: #fff;" href="#newpageModal"  class="btn btn-primary" data-toggle="modal">Add New Page</a>
					<!-- <button class="btn btn-primary" type="button">Add New Pages</button> -->

				</div>

			</div>

			<!-- end here -->
            
            <div style="clear:both;"></div>
            
            <div>
            	<div style="float: left"> 
            		<h2 style="margin: 0px; padding-left:7px;" id="cat-name">Page</h2>
            	</div>
            	<!--<div style="float: left; margin-left: 10px; height: 40px; line-height: 40px;">
            		<a href="javascript:show_catrenameModal();">(Rename This Category)</a>
            	</div>-->
                <div style="float: left; margin-left: 10px; height: 40px; line-height: 40px;">
            		<a href="javascript:show_catdeleteModal();">(Delete This Category)</a>
            	</div>
            	<div style="margin-top: 10px;" class="list_line"></div>
            	
            	<table class="table table-hover">
			    	<thead>
			    		<tr style="font-size: 15px">
			    			<th style="width: 40%">Page Title</th>
			    			<th style="width: 12%; text-align: center;">Preview</th>
			    			<th style="width: 12%; text-align: center;">Edit Page</th>
			    			<th style="width: 12%; text-align: center;">Copy Page</th>
			    			<th style="width: 12%; text-align: center;">Add Gallery</th>
			    			<th style="width: 12%; text-align: center;">Delete Page</th>
			    		</tr>
			    	</thead>
			    	<tbody id="all_page">
		    			
			    	</tbody>
			    	
			    </table>
			    <div id="all_div">
			    </div>
            	
            	
            </div>

		</div>

	</div>

</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add New Category</h3>
</div>
<div class="modal-body">
<form name="addForm" method="post" action="<?=base_url()?>admin/cms/addcat">
    <p>Name</p>
    <p><input type="text" class="textfield rounded" id="name" name="name" /></p>

    <p>Parent</p>
    <p class="cats2"></p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="addcat();">Save changes</button>
</form>
</div>
</div>

<div id="newpageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add New Page</h3>
</div>
<div class="modal-body">
    <p>Name</p>
    <p><input type="text" class="textfield rounded" id="name_new" name="name" /></p>
	
    <p>Parent</p>
    <p class="cats21"></p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="addnewpage();">Save</button>
</div>
</div>

<div id="catdeleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete <span id="cat-delete-name"></span> Category</h3>
</div>
<div class="modal-body">
    <p>Are you sure to delete this category?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletecat()">Delete</button>

</div>
</div>

<div id="anyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Message</h3>
</div>
<div class="modal-body">
    <p id="any_message"></p>
</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>

<script>
function getpages_first()
{
	
	var id = <?=$first_cat['id']?>;
	
	cur_cat = id;
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getcatetitle',
		type: 'POST',
		data: ({category_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#cat-name').html(html);
		}
	})
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getpages',
		type: 'POST',
		data: ({category_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#all_page').html(html);
			
		}
	})
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getpages3',
		type: 'POST',
		data: ({category_id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#all_div').html(html);
		}
	})
}

getpages_first();
</script>