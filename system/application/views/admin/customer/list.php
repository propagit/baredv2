<script>

jQuery(function() {
	jQuery('.edit-cust').tooltip({
		showURL: false
	});
	
});

var choose = 0;
function export_competition() {
	if (confirm('This will export the competition entry to a csv file. Do you want to continue?')) {
		//var type=document.customerform.type.value;
		window.location = '<?=base_url()?>admin/competition/export_csv';
	}
}


function export_csv() {
	if (confirm('This will export the customers list to a csv file. Do you want to continue?')) {
		//var type=document.customerform.type.value;
		window.location = '<?=base_url()?>admin/customer/exportcustomer';
	}
}
function export_csv_myob() {
	if (confirm('This will export the customers list to a csv file. Do you want to continue?')) {
		//var type=document.customerform.type.value;
		window.location = '<?=base_url()?>admin/customer/export_cust_for_MYOB';
	}
}
function deletesubscribe(id) {
	if (confirm('You are about to delete this subscribe from the system? Are you sure you want to do this?')) {
		window.location = '<?=base_url()?>admin/customer/deletesubscribe/' + id;
	}
}
function delete_customer(id)
{
	choose = id;
	//alert(id);
	$('#deleteModal').modal('show');
}
function deletecustomer(id)
{
	$('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/customer/deletecustomer/'+id,
		type: 'POST',	
		dataType: "html",
		success: function(html) {
			jQuery('#user'+id).fadeOut('slow');
			jQuery('#any_message').html("This customer has been successfully deleted");
			$('#anyModal').modal('show');
			
		}
	})
}
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>Customers</h1>
			<h2>Search Customer</h2>
			<form name="customerform" method="post" action="<?=base_url()?>admin/customer/list_all/search">
			<div>
				<div style="float: left; width: 20%; height: 30px; line-height: 30px">
					Customer Keyword
				</div>
				<div style="float: left; width: 80%">
					<input type="text" class="textfield rounded" id="name" name="name" value="<?=$this->session->userdata('name')?>"/>
				</div>
			</div>			
			<div style="clear: both"></div>
			<div>
				<div style="float: left; width: 20%; height: 30px; line-height: 30px">
					Customer Type
				</div>
				<div style="float: left; width: 80%">
					<select class="selectpicker" id="cat" name="type">
						<option <? if($this->session->userdata('type')==0){echo "selected=selected";}?> value="0">All</option>
						<option <? if($this->session->userdata('type')==1){echo "selected=selected";}?> value="1">Retailer</option>
						<option <? if($this->session->userdata('type')==5){echo "selected=selected";}?> value="5">Subscriber</option>
                        <option <? if($this->session->userdata('type')==6){echo "selected=selected";}?> value="6">Competition</option>
                        <!--
                        <option <? if($this->session->userdata('type')==2){echo "selected=selected";}?> value="2">Trade</option>
						<option <? if($this->session->userdata('type')==5){echo "selected=selected";}?> value="5">Subscribers</option>
                        -->
					</select>
                    <script>jQuery(".selectpicker").selectpicker();</script>
				</div>
			</div>
			<div style="clear: both"></div>
			<div>
				<div style="float: left; width: 20%; height: 30px; line-height: 30px">
					&nbsp;
				</div>
				<div style="float: left; width: 80%">
					<button class="btn btn-primary" type="submit">Search</button>
				</div>
			</div>
			</form>
			<div style="clear: both; height: 20px"></div>
			<div style="float: left; margin-right: 20px;">
				<h2><?php if($this->session->userdata('type')==6) { echo 'Competition Entries'; }else { echo 'Customers';}?></h2>
			</div>
			<div style="float: left; margin-top: 15px;">
            	<?php if($this->session->userdata('type')==6){?>
                	<button class="btn btn-primary" onclick="export_competition();">Export To CSV</button>
                <?php }else{ ?>
					<button class="btn btn-primary" onclick="export_csv();">Export To CSV</button>
                <?php } ?>
			</div>
			<!-- <div style="float: left; margin-top: 15px; margin-left:10px">
				<button class="btn btn-primary" onclick="export_csv_myob();">Export To CSV for MYOB</button>
			</div> -->
			<div style="clear: both"></div>
			<?php
			if($type==6){
			?>
            <table class="table table-hover">
				<thead>
					<tr>
                    	<th>First Name</th>
                        <th>Last Name</th>
						<th>Email</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Entry Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($competition_entries as $entry) 
						{
						?>
						<tr <?=$entry['customer_id'] ? 'class="is-customer text-success pointer" data-id="' . $entry['customer_id'] . '"' : '';?>>
							<td><?=$entry['firstname'];?></td>
                            <td><?=$entry['lastname']?></td>
                            <td><?=$entry['email']?></td>
                            <td><?=$entry['state']?></td>
                            <td><?=$entry['country']?></td>
                            <td><?=date('d-m-Y',strtotime($entry['created_on']));?></td>
						</tr>
						<?php
						}
					?>
				</tbody>
			</table>
            <?php
			}elseif($type==5)
			{
				
			?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th style="width: 80%">Email</th>
						<th style="width: 20%; text-align: center">Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($subscribers as $s) 
						{
						?>
						<tr id="user<?=$s['id']?>">
							<td><?=$s['email']?></td>
							<td style="text-align: center">
								<span style="cursor: pointer" onclick="deletesubscribe(<?=$s['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
		    					</span>
							</td>
						</tr>
						<?php
						}
					?>
				</tbody>
			</table>
			<?php
			}
			elseif($this->session->userdata('type')==2)
			{
			?>
			<table class="table table-hover">
				<thead>
					<tr >
						<th style="width: 40%">Customer Name</th>
						<th style="width: 20%">Email</th>
						<th style="width: 10%">Orders</th>
						<th style="width: 10%; text-align: center;">Status</th>
						<th style="width: 10%; text-align: center;">Edit</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($users as $user) 
						{
							$customer = $this->Customer_model->identify($user['customer_id']);
						?>
						<tr id="user<?=$user['id']?>">
							<td><?=$customer['title'] ? $customer['title'] . ' ' : '';?><?=$customer['firstname'].' '.$customer['lastname']?></td>
							<td><a href="mailto:<?=$customer['email']?>"><?=$customer['email']?></a></td>
							<td>
								<?=$this->Customer_model->total_orders($customer['id'],'')?>
								&nbsp;
								(<span style="color: green"><?=$this->Customer_model->total_orders($customer['id'],'successful')?></span>/<span style="color: red"><?=$this->Customer_model->total_orders($customer['id'],'failed')?></span>)
							</td>
							<td style="text-align: center;">
								<?php if($user['activated']) { ?>
		    						<span ><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></span>
		    					<?php 
								}
		    					else
		    					{
		    					?>
		    						<span ><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></span>
		    					<?php	
		    					}
		    					?>
							</td>
							<td style="text-align: center;">
								<span class="edit-cust" data-toggle="tooltip" title="Edit Customer" style="cursor: pointer" onclick="edit_cust(<?=$user['id']?>,2)">
		    						<i class="icon-edit icon-2x"></i>
		    					</span>
							</td>
						</tr>
						<?php
						} 
					?>
				</tbody>
			</table>
			<?php
			}
			else 
			{
			?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th style="width: 50%">Customer Name</th>
						<th style="width: 20%">Email</th>
						<th style="width: 10%">Orders</th>
						<th style="width: 10%; text-align: center;">Edit</th>
                        <th style="width: 10%; text-align: center;">Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($users as $user) 
						{
							$customer = $this->Customer_model->identify($user['customer_id']);
						?>
						<tr id="user<?=$user['id']?>">
							<td><?=$customer['title'] ? $customer['title'] . '. ' : '';?><?=$customer['firstname'].' '.$customer['lastname']?></td>
							<td><a href="mailto:<?=$customer['email']?>"><?=$customer['email']?></a></td>
							<td>
								<?=$this->Customer_model->total_orders($customer['id'],'')?>
								&nbsp;
								(<span style="color: green"><?=$this->Customer_model->total_orders($customer['id'],'successful')?></span>/<span style="color: red"><?=$this->Customer_model->total_orders($customer['id'],'failed')?></span>)
							</td>
							<!-- <td style="text-align: center;">
								<?php if($user['activated']) { ?>
		    						<span ><i style="color: #00c717" class="icon-ok-circle icon-2x"></i></span>
		    					<?php 
								}
		    					else
		    					{
		    					?>
		    						<span ><i style="color: #d6d6d6" class="icon-ok-circle icon-2x"></i></span>
		    					<?php	
		    					}
		    					?>
							</td> -->
							<td style="text-align: center;">
								<span class="edit-cust" data-toggle="tooltip" title="Edit Customer" style="cursor: pointer" onclick="edit_cust(<?=$user['id']?>,<?=$user['level']?>)">
		    						<i class="icon-edit icon-2x"></i>
		    					</span>
							</td>
                            <td style="text-align: center;">
			    				<div class="all_tt" data-toggle="tooltip" title="Delete Customer" style="cursor: pointer; text-align: center" onclick="delete_customer(<?=$user['id']?>);">
			    					<i style="color: #c70520" class="icon-remove-circle icon-2x"></i>
			    				</div>
			    			</td>
						</tr>
                        
						<?php
						} 
					?>
				</tbody>
			</table>
			<?
			}
			?>
			
			<!-- end here -->
		</div>
	</div>
</div>


<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Delete Customer</h3>
</div>
<div class="modal-body">
    <p>Are you sure to delete this customer?</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="deletecustomer(choose)">Delete</button>

</div>
</div>
<script>
function edit_cust(id,type)
{
	//alert(id);
	if(type == 1)
	{
		window.location = "<?=base_url()?>admin/customer/list_all/edit/"+id;
	}
	else
	{
		window.location = "<?=base_url()?>admin/customer/list_all/edit_trader/"+id;
	}
}

$(function(){
	$('.is-customer').click(function(){
		window.location = "<?=base_url()?>admin/customer/list_all/edit/"+$(this).attr('data-id');
	});
});
</script>