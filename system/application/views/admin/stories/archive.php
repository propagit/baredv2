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
				<button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/stories2'">All Stories</button>
				<h1 style="padding-left: 7px;">
					My Archives
				</h1>
				<form action="<?=base_url()?>admin/cms/search_archive" method="post">
				<div style="float: left; width: 100px; height: 30px; line-height: 30px; margin-left: 7px">Keyword</div>
				<div style="float: left"><input type="text" name="keyword" placeholder="story/archive name"/></div>
				<div style="clear: both"></div>
				<div style="float: left; width: 100px; height: 30px; line-height: 30px; margin-left: 7px">&nbsp;</div>
				<div style="float: left"><button type="submit" class="btn btn-primary">Search</button></div>
				<div style="clear: both"></div>
				</form>
			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">
			    			
							<!-- <th style="width: 10%">&nbsp;</th> -->
			    			<th style="width: 80%">Archive Title (Story Title)</th>			    			
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
			    					<div  id="name-<?=$story['id']?>" onclick="changename(<?=$story['id']?>)"><?=$story['name']?></div> 
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
			    						<i class="icon icon-search"></i>
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
			    					<div class="delete-cp" data-toggle="tooltip" title="Delete Archive" style="cursor: pointer" onclick="delete_story(<?=$story['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    					</div>
			    				</td>

			    			</tr>

			    		<?php }?>
			    		
			    		<?php
			    		
			    		if($add_search == 1)
						{
							foreach($inside_archives as $story)
							{
							?>
								<tr id="sstory-<?=$story['id']?>">
									<!-- <td><input class="story_check" value="<?=$story['id']?>" type="checkbox"></td> -->
				    				<td>
				    					<a href="<?=base_url()?>admin/cms/list_archives/<?=$story['id']?>"><div><?=$story['name']?> (<?=$story['title']?>)</div> </a>
				    				</td>
	
				    				<!-- <td style="text-align: center;"><?=date('d-M-Y',strtotime($story['created']))?></td> -->
				    				
				    				
				    				<!-- <td style="text-align: center;">
				    					<div class="edit-cp" data-toggle="tooltip" title="Edit Archive" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/edit_story/<?=$story['id']?>'">
				    						<i class="icon-edit icon-2x"></i>
				    					</div>
				    				</td> -->
	                                <td style="text-align: center;">
				    					<a href="<?=base_url()?>admin/cms/archive_preview/<?=$story['id']?>">
	                                    <div class="edit-cp" data-toggle="tooltip" title="Preview Archive" style="cursor: pointer">
				    						<i class="icon icon-search"></i>
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
				    					<!-- <div class="delete-cp" data-toggle="tooltip" title="Delete Archive" style="cursor: pointer" onclick="delete_story(<?=$story['id']?>);"> -->
				    					<i style="color: #D6D6D6; cursor: not-allowed" class="icon-remove-circle icon-2x"></i>
				    					<!-- </div> -->

				    				</td>
	
				    			</tr>
							<?
							}
						}
			    		
			    		?>
			    		
			    		

			    	</tbody>

			    </table>
			    
			    <div style="height: 20px"></div>
			    <!-- <button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/add_story'">Create A Story</button>
				<button class="btn btn-primary" onclick="create_archive();">Create An Archive</button> -->
			<!-- end here -->

		</div>

	</div>

</div>

<script>
function changename(id)
{
	choose = id;
	//alert(id);
	$('#archiveModal').modal('show');
}
function change_name(id)
{
	var new_name = $('#archive_name').val();
	$('#name'+id).text(new_name);
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
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete archive</h3>

</div>
<div class="modal-body">
    <p>Are you sure to delete this archive?</p>
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