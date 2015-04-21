
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
</script>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
				<?php
					if($this->session->flashdata('err_archive'))
					{
					?>
					<div style="color: #c70520">
						<?=$this->session->flashdata('err_archive')?>
					</div>
					<?
					}
				?>
				<h1 style="padding-left: 7px;">
					My Stories <!-- <a href="<?=base_url()?>admin/cms/archives" style="color: #E4006F; font-size: 12px; font-weight: 400">Show all archives</a> -->
				</h1>
				<form action="<?=base_url()?>admin/cms/search_stories" method="post">
				<div style="float: left; width: 100px; height: 30px; line-height: 30px; margin-left: 7px">Keyword</div>
				<div style="float: left"><input type="text" name="keyword" placeholder="story title / category"/></div>
				<div style="clear: both"></div>
				<div style="float: left; width: 100px; height: 30px; line-height: 30px; margin-left: 7px">Status</div>
				<div style="float: left">
					<select class="selectpicker" name="status">
						<option value="8">Active</option>
						<option value="1">Archived</option>
						<option value="9">Inactive</option>
					</select>
					<script>jQuery(".selectpicker").selectpicker();</script>
				</div>
				<div style="clear: both"></div>
				<div style="float: left; width: 100px; height: 30px; line-height: 30px; margin-left: 7px">&nbsp;</div>
				<div style="float: left"><button type="submit" class="btn btn-primary">Search</button></div>
				<div style="clear: both"></div>
				</form>
				<?php
				if($status_ls == 0)
				{
				?>
				<table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">
			    			
							<th style="width: 10%">&nbsp;</th>
			    			<th style="width: 40%">Story Title</th>			    			
			    			<th style="width: 20%; text-align: center;">Created</th>
			    			<th style="width: 10%; text-align: center;">Edit</th>
			    			<th style="width: 10%; text-align: center;">Preview</th>
                            <th style="width: 10%; text-align: center;">Home</th>
                            <th style="width: 10%; text-align: center;">Active</th>
			    			<th style="width: 10%; text-align: center;">Delete</th>

			    		</tr>

			    	</thead>

			    	<tbody>

			    		<?php foreach($stories as $story) { 
			    			if($story['archive_id'] == 0)
							{
			    			?>

			    			<tr id="story-<?=$story['id']?>">
								<td><input class="story_check" value="<?=$story['id']?>" type="checkbox"></td>
			    				<td>
			    					<?=$story['title']?> 
			    					<!-- <?php
			    					if($story['home'])
									{
									?>
										(Home order: <?=$story['home_order']?>)
									<?
									}
			    					?>  -->
			    				</td>

			    				<td style="text-align: center;"><?=date('d-M-Y',strtotime($story['created']))?></td>
			    				
			    				
			    				<td style="text-align: center;">
			    					<div class="edit-cp" data-toggle="tooltip" title="Edit Story" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/edit_story/<?=$story['id']?>'">
			    						<i class="icon-edit icon-2x"></i>
			    					</div>
			    				</td>
                                <td style="text-align: center;">
			    					<a target="_blank" href="<?=base_url()?>admin/cms/preview_story/all/<?=$story['id']?>">
                                    <div class="edit-cp" data-toggle="tooltip" title="Preview Story" style="cursor: pointer">
			    						<i class="icon-2x icon-search"></i>
			    					</div>
                                    </a>
			    				</td>
                                <td style="text-align: center;">
			    					<?php if($story['home'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Story in Homepage" style="cursor: pointer;" onclick="check_home(<?=$story['id']?>,'green');">
			    							<i style="color: #00c717" id='green' class="icon-2x icon-heart"></i>
			    							<!-- <div style="color: #FFFFFF; margin-left: 25px; margin-top: -26px; position: absolute;"><?=$story['home_order']?></div> -->
			    						</div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Story in Homepage" style="cursor: pointer" onclick="check_home(<?=$story['id']?>,'gray');"><i style="color: #d6d6d6" id='gray' class="icon-2x icon-heart"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>
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

			    				<td style="text-align: center;">
			    					<div class="delete-cp" data-toggle="tooltip" title="delete Story" style="cursor: pointer" onclick="delete_story(<?=$story['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    					</div>
			    				</td>

			    			</tr>

			    		<?php }}?>

			    	</tbody>

			    </table>
				<?
				}
				else 
				{
				?>
				<table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">
			    			
							<!-- <th style="width: 10%">&nbsp;</th> -->
			    			<th style="width: 80%">Archive Title</th>			    			
			    			<!-- <th style="width: 10%; text-align: center;">Edit</th> -->
			    			<th style="width: 10%; text-align: center;">Preview</th>
			    			<th style="width: 10%; text-align: center;">Delete</th>

			    		</tr>

			    	</thead>

			    	<tbody>

			    		<?php foreach($archives as $story) { 
			    			?>

			    			<tr id="story-<?=$story['id']?>">
								<!-- <td><input class="story_check" value="<?=$story['id']?>" type="checkbox"></td> -->
			    				<td>
			    					<div class="edit-cp" data-toggle="tooltip" title="View Archive" style="cursor: pointer; float: left; margin-right: 10px;">
			    						<a href="<?=base_url()?>admin/cms/list_archives/<?=$story['id']?>" style="text-decoration: none">
			    							<i class="icon-2x icon-folder-open"></i>
			    						</a>
			    					</div>
			    					<div style="cursor: pointer; float: left; height: 30px; line-height: 30px"  id="name-<?=$story['id']?>" onclick="changename(<?=$story['id']?>)"><?=$story['name']?></div>
			    					<div style="clear: both"></div> 
			    				</td>

			    				<!-- <td style="text-align: center;"><?=date('d-M-Y',strtotime($story['created']))?></td> -->
			    				
			    				
			    				<!-- <td style="text-align: center;">
			    					<div class="edit-cp" data-toggle="tooltip" title="Edit Archive" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/edit_story/<?=$story['id']?>'">
			    						<i class="icon-edit icon-2x"></i>
			    					</div>
			    				</td> -->
                                <td style="text-align: center;">
			    					<a href="<?=base_url()?>admin/cms/list_archives/<?=$story['id']?>">
                                    <div class="edit-cp" data-toggle="tooltip" title="Preview Archive" style="cursor: pointer">
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
			    				<!-- <td style="text-align: center;">
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
			    				</td> -->

			    				<td style="text-align: center;">
			    					<div class="delete-cp" data-toggle="tooltip" title="Delete Archive" style="cursor: pointer" onclick="delete_story1(<?=$story['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    					</div>
			    				</td>

			    			</tr>

			    		<?php }?>
			    		
			    		
			    		
			    		

			    	</tbody>

			    </table>
				<?
				}
				?>
			    
			    
			    <div style="height: 20px"></div>
			    <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/add_story'">Create A Story</button>
				<button class="btn btn-primary" onclick="create_archive();">Create An Archive</button>
				<button class="btn btn-primary" onclick="add_to_archive();">Add To Archive</button>
			<!-- end here -->

		</div>

	</div>

</div>

<script>
function add_to_archive()
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
		$('#ar_story2').val(archecked);
		$('#archiveModal2').modal('show');
	}
	
	//$('#archiveModal2').modal('show');
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
		url: '<?=base_url()?>admin/new_cms/deletestory/'+id,
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

function changename(id)
{
	choose = id;
	//alert(id);
	$('#archiveModal1').modal('show');
}
function change_name(id)
{
	//alert(8);
	$('#archiveModal1').modal('hide');
	var new_name = $('#archive_name').val();
	//alert(new_name);
	$('#name-'+id).html(new_name);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/change_archive_name',
		type: 'POST',
		data: ({name:new_name,id:id}),
		dataType: "html",
		success: function(html) {
			//jQuery('#story-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This coupon has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
	
}
function delete_story1(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal1').modal('show');
}
function deletestory1(id)
{
	$('#deleteModal1').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/deletearchive/'+id,
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

<div id="archiveModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add To Archive</h3>
</div>

<form id="ar_ad_form" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_to_archive">
	<input type="hidden" name="ar_story2" id="ar_story2" value=""/>
	<div class="modal-body">
	    <div style="float: left; width: 20%; line-height: 30px">Archive Name</div>
	    <div style="float: left">
	    	<select id="cur_archive" name="cur_archive">
	    		<?php
	    			foreach($a_archives as $aa)
					{
					?>
						<option value="<?=$aa['id']?>"><?=$aa['name']?></option>
					<?	
					}
	    		?>
	    	</select>
	    </div>
	    <div style="clear: both"></div>
	</div>
	<div class="modal-footer">
	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	<button class="btn btn-primary" onclick="$('#ar_ad_form').submit();">Submit</button>
	</div>
</form>

</div>

<div id="archiveModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Change Archive Name</h3>
</div>


<div class="modal-body">
    <div style="float: left; width: 20%; line-height: 30px">New Name</div>
    <div style="float: left"><input type="text" id="archive_name"/></div>
    <div style="clear: both"></div>
</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="change_name(choose)">Submit</button>
</div>

</div>

<div id="deleteModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete archive</h3>

</div>
<div class="modal-body">
    <p>Are you sure to delete this archive?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletestory1(choose)">Delete</button>

</div>
</div>

<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Story</h3>

</div>
<div class="modal-body">
    <p>Are you sure to delete this story?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletestory(choose)">Delete</button>

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
	    <div></div>
	    <div>Image size: 710px X 449px</div>
	    <div></div>
	</div>
	<div class="modal-footer">
	<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	<button class="btn btn-primary" onclick="$('#ar_form').submit();">Submit</button>
	</div>
</form>
</div>