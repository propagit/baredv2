<script>
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
	
	jQuery('.tooltip-alt').tooltip({
		showURL:false
	});
	
});
</script>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->
				<h1 style="padding-left: 7px;">
					Manage Template Homepage
				</h1>
			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">
			    			<th style="width: 30%">Template</th>
                            <th style="width: 10%; text-align: center;">Tiles</th>
                            <th style="width: 10%; text-align: center;">Promotions</th>
                            <th style="width: 10%; text-align: center;">Stories</th>
			    			<th style="width: 10%; text-align: center;">Preview</th>
			    			<th style="width: 10%; text-align: center;">Publish</th>			    			
			    		</tr>

			    	</thead>

			    	<tbody>			    
			    			<? foreach($homepage as $hm){?>
                            <tr>								
			    				<td>Template <?=$hm['type']?></td>
	
                                <td class="center">
                                    <a href="<?=base_url();?>admin/cms/update_setting/<?=$hm['id']?>/4/<?=$hm['tiles'] ? 0 : 1;?>" class="anchor tooltip-alt" data-toggle="tooltip" title="<?=$hm['tiles'] ? 'Deactivate' : 'Activate';?> Tile">
                                        <i class="icon-ok-circle icon-2x <?=$hm['tiles'] ? 'icon-active' : 'icon-inactive';?>"></i>
                                    </a>
                                </td>
			    				<td style="text-align: center;">
                                	<?php if($hm['promotions'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Promotions" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/1/0'">
                                        	<i style="color: #00c717" class="icon-ok-circle icon-2x"></i>
                                        </div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Promotion" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/1/1'">
                                        	<i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i>
                                        </div>
			    					<?php	
			    					}
			    					?>
                                
                                </td>

			    				<td style="text-align: center;">
                                	<?php if($hm['stories'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Stories" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/2/0'">
                                        	<i style="color: #00c717" class="icon-ok-circle icon-2x"></i>
                                        </div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Stories" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/2/1'">
                                       		<i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i>
                                        </div>
			    					<?php	
			    					}
			    					?>
                                </td>
			    				
			    				<td style="text-align: center;">
			    					<a target="_blank" href="<?=base_url()?>admin/cms/preview_template/<?=$hm['type']?>">
                                    <div class="edit-cp" data-toggle="tooltip" title="Preview Template" style="cursor: pointer">
			    						<i class="icon icon-search"></i>
			    					</div>
                                    </a>
			    				</td>
			    				<td style="text-align: center;">
			    					<?php if($hm['published'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Template" style="cursor: pointer;"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Template" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/3/1'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>

			    				

			    			</tr>
							<? } ?>
			    		
			    	</tbody>

			    </table>
			    
			  	<!--
			  	<h1 style="padding-left: 7px;">
					Manage Template Homepage - Trade
				</h1>
			    <table class="table table-hover">

			    	<thead>

			    		<tr style="font-size: 15px">
			    			<th style="width: 30%">Template</th>
                            -->
                            <!-- <th style="width: 10%; text-align: center;">Promotions</th>
                            <th style="width: 10%; text-align: center;">Stories</th>
			    			<th style="width: 10%; text-align: center;">Preview</th> --><!--
			    			<th style="width: 10%; text-align: center;">Publish</th>			    			
			    		</tr>

			    	</thead>

			    	<tbody>			    
			    			<? foreach($homepage_trade as $hm){?>
                            <tr>								
			    				<td>Template <?=$hm['type']?></td>
								-->
			    				<!-- <td style="text-align: center;">
                                	<?php if($hm['promotions'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Promotions" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/1/0'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Promotion" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/1/1'""><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
                                
                                </td>

			    				<td style="text-align: center;">
                                	<?php if($hm['stories'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Stories" style="cursor: pointer;" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/2/0'"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Stories" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/2/1'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
                                </td>
			    				
			    				<td style="text-align: center;">
			    					<a target="_blank" href="<?=base_url()?>admin/cms/preview_template/<?=$hm['type']?>">
                                    <div class="edit-cp" data-toggle="tooltip" title="Preview Template" style="cursor: pointer">
			    						<i class="icon icon-search"></i>
			    					</div>
                                    </a>
			    				</td> -->
                                <!--
			    				<td style="text-align: center;">
			    					<?php if($hm['published'] == 1) { ?>
			    						<div class="de-active-cp" data-toggle="tooltip" title="Deactived Template" style="cursor: pointer;"><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></div>
			    					<?php 
									}
			    					else
			    					{
			    					?>
			    						<div class="active-cp" data-toggle="tooltip" title="Actived Template" style="cursor: pointer" onclick="window.location = '<?=base_url()?>admin/cms/update_setting/<?=$hm['id']?>/3/1'"><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></div>
			    					<?php	
			    					}
			    					?>
			    				</td>

			    				

			    			</tr>
							<? } ?>
			    		
			    	</tbody>

			    </table>
				-->
			<!-- end here -->

		</div>

	</div>

</div>

<script>
function delete_coupon(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal').modal('show');
}
function deletecoupon(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/new_system/deletecoupon/'+id,
		type: 'POST',
		//data: (),
		dataType: "html",
		success: function(html) {
			jQuery('#coupon-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This coupon has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
}
</script>
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Coupon</h3>
</div>
<div class="modal-body">
    <p>Are you sure to delete this coupon?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletecoupon(choose)">Delete</button>

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