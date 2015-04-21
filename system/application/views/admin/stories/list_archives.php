<script type="text/javascript" src="<?=base_url()?>js/jquery-sortable.js"></script>


<script>
$(function() {       
	//getcats();
	//getcats2(); 
	jQuery('.selectpicker').selectpicker();
	
	var cur_cat = 0;
	var group = $('.sorted_table').sortable({	  
	  containerSelector: 'tbody',
	  itemSelector: 'tr',
	  placeholder: '<tr class="placeholder"/>',
	  onDrop: function(item, container, _super) {
      	update_order();
    	}
    
	
	})
	jQuery('#title-cat-104').click(function(){
		alert('test2');	
	});

	
});
</script>
<script>
var arttl = 0;
var archecked = '';

jQuery(function() {
	jQuery('.edit-cp').tooltip({
		showURL: false
	});
	
	jQuery('.delete-cp').tooltip({
		showURL: false
	});
	
	jQuery('.active-cp').tooltip({
		showURL: false
	});
	
	jQuery('.de-active-cp').tooltip({
		showURL: false
	});
	
});
function check_home(id,type)
{
	var i=0;
	jQuery('.icon-heart').each(function() {
		if($(this).attr("id")=='green')
		{
			i=i+1;
		}
	});
	if(i==3 && type=='gray')
	{
		jQuery('#any_message').html("You can only have 3 active stories display on the homepage at one time. Please deselect a story to add a new story. ");
		$('#anyModal').modal('show');
	}
	else
	{
		window.location = '<?=base_url()?>admin/cms/homestory/'+id;
	}
}

function create_archive()
{
	
	$(".story_check").each(function() {
		if($(this).is(':checked'))
		{
	    	//alert($(this).val());
	    	if(arttl == 0)
	    	{
	    		archecked = $(this).val();
	    	}
	    	else
	    	{
	    		archecked += ','+ $(this).val();
	    	}
	    	arttl++;
	    }
	});
	
	if(arttl == 0)
	{
		jQuery('#any_message').html("Please select at least one story");
		$('#anyModal').modal('show');
	}
	else
	{
		$('#ar_story').val(archecked);
		$('#archiveModal').modal('show');
	}
	
}

function update_order(){
	//alert('aa');
	var indx=[];
	var i=1;
	jQuery('.archive_pg').each(function () {
		var id = $(this).attr("id");
		dtrp=id.replace('story-','');
		indx[i]=dtrp;
		i=i+1;
		
	});
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/update_order_archive/',
		type: 'POST',
		data: ({indx:indx}),
		dataType: "html",
		success: function(html) {
			
		}
	})
	
}
</script>
<style>
body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}
.sorted_table tr {
    cursor: pointer;
}
.sorted_table tr.placeholder {
    background: none repeat scroll 0 0 red;
    border: medium none;
    display: block;
    margin: 0;
    padding: 0;
    position: relative;
}
.sorted_table tr.placeholder:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: transparent -moz-use-text-color transparent red;
    border-image: none;
    border-style: solid none solid solid;
    border-width: 5px medium 5px 5px;
    content: "";
    height: 0;
    left: -5px;
    margin-top: -5px;
    position: absolute;
    width: 0;
}
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
				<button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/stories'">Back to Stories</button>
				<h1 style="padding-left: 7px;">
					<a href="<?=base_url()?>admin/cms/preview_archive/<?=$archive['id']?>"><?=$archive['name']?></a>
				</h1>
			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">
			    			
			    			<th style="width: 60%">Story Title</th>			    			
			    			<th style="width: 20%; text-align: center;">Created</th>
			    			<th style="width: 10%; text-align: center;">Edit</th>
			    			<th style="width: 10%; text-align: center;">Preview</th>
                            <!-- <th style="width: 10%; text-align: center;">Home</th> -->
                            <th style="width: 10%; text-align: center;">Active</th>
			    			<th style="width: 10%; text-align: center;">Duplicate</th>

			    		</tr>

			    	</thead>

			    	<tbody class="sorted_table">
						
			    		<?php foreach($stories as $story) { 
			    			
			    			?>

			    			<tr class="archive_pg" id="story-<?=$story['id']?>">
			    				<td><?=$story['title']?> </td>

			    				<td style="text-align: center;"><?=date('d-M-Y',strtotime($story['created']))?></td>
			    				
			    				
			    				<td style="text-align: center;">
			    					<div class="edit-cp" data-toggle="tooltip" title="Edit Story" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/edit_story/<?=$story['id']?>'">
			    						<i class="icon-edit icon-2x"></i>
			    					</div>
			    				</td>
                                <td style="text-align: center;">
			    					<a target="_blank" href="<?=base_url()?>admin/cms/preview_story/html/<?=$story['id']?>">
                                    <div class="edit-cp" data-toggle="tooltip" title="Preview Story" style="cursor: pointer">
			    						<i class="icon-2x icon-search"></i>
			    					</div>
                                    </a>
			    				</td>
                                <!-- <td style="text-align: center;">
			    					<?php if($story['home'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Story in Homepage" style="cursor: pointer;" onclick="check_home(<?=$story['id']?>,'green');"><i style="color: #00c717" id='green' class="icon-2x icon-heart"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Story in Homepage" style="cursor: pointer" onclick="check_home(<?=$story['id']?>,'gray');"><i style="color: #d6d6d6" id='gray' class="icon-2x icon-heart"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td> -->
			    				<td style="text-align: center;">
			    					<?php if($story['status'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Story" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/activestory/<?=$story['id']?>'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Story" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/activestory/<?=$story['id']?>'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>

			    				<!-- <td style="text-align: center;">
			    					<div class="delete-cp" data-toggle="tooltip" title="delete Story" style="cursor: pointer" onclick="delete_story(<?=$story['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    					</div>
			    				</td> -->
			    				
			    				<td style="text-align: center;">
			    					<div class="delete-cp" data-toggle="tooltip" title="duplicate Story" style="cursor: pointer" onclick="duplicate_story(<?=$story['id']?>)">
			    					<i class="icon-copy icon-2x"></i>
			    					</div>
			    				</td>

			    			</tr>

			    		<?php }?>

			    	</tbody>

			    </table>
			    
			    <div style="height: 20px"></div>
			<!-- end here -->

		</div>

	</div>

</div>

<script>
function duplicate_story(id)
{
	choose = id;
	//alert(id);
	$('#duplicateModal').modal('show');
}
function duplicatestory(id)
{
	$('#duplicateModal').modal('hide');
	//alert(id);
	var name = $('#new_story').val();
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/duplicate_story',
		type: 'POST',
		data: ({name:name,id:id}),
		dataType: "html",
		success: function(html) {
			
			//jQuery('#story-'+id).fadeOut('slow');
			jQuery('#any_message').html("Story duplicated successfully, the duplicated story has been placed in the active story directory. <a style='color:#E4006F' href='<?=base_url()?>admin/cms/stories'>Go to active story directory now</a>");
			$('#anyModal').modal('show');
			
		}
	})
}
function delete_story(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal').modal('show');
}
function deletestory(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/removestory/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#story-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This coupon has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
}
</script>
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Story</h3>

</div>
<div class="modal-body">
    <p>Are you sure to remove this story from archive <?=$archive['name']?>?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletestory(choose)">Delete</button>

</div>
</div>

<div id="duplicateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Duplicate Story</h3>

</div>
<div class="modal-body">
    <div style="height: 30px; line-height: 30px; float: left; width: 100px;">New Story Name</div>
    <div style="float: left;"><input type="text" id="new_story"></div>
    <div style="clear: both"></div>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="duplicatestory(choose)">Duplicate</button>

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

<div id="archiveModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">New Archive</h3>
</div>
<form id="ar_form" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/create_archive">
	<input type="hidden" name="ar_story" id="ar_story" value=""/>
	<div class="modal-body">
	    <div style="float: left; width: 20%; line-height: 30px">Archive Name</div>
	    <div style="float: left"><input type="text" name="archive_name"/></div>
	    <div style="clear: both"></div>
	    <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Upload image</div>
	    <div style="float: left">                                        
	        <div class="fileupload fileupload-new" data-provides="fileupload">
	        <div class="input-append">
	        <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div>
	        <span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
	        <input type="file" name="userfile" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	        </div>
	        </div>
	    </div>
	    <div style="clear: both"></div>
	</div>
	<div class="modal-footer">
	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	<button class="btn btn-primary" onclick="$('#ar_form').submit();">Submit</button>
	</div>
</form>
</div>