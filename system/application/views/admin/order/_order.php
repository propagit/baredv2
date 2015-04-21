
<script type="text/javascript" src="//code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.jqprint.0.3.js"></script>
<script>
	var j = jQuery.noConflict();
function print_results() {
	j('#print_area').css({"background":"#fff"});
	//jQuery(".hprint").css({"background":"#fff"});
	j('#print_area').css({"display":"block"});
	//$j('#order_header').css({"display":"block"});
	j('#print_area').jqprint();
	j('#print_area').css({"display":"none"});
}
function print_results_com() {
	j('#print_areacom').css({"background":"#fff"});
	//jQuery(".hprint").css({"background":"#fff"});
	j('#print_areacom').css({"display":"block"});
	//$j('#order_header').css({"display":"block"});
	j('#print_areacom').jqprint();
	j('#print_areacom').css({"display":"none"});
}
</script>
<style>

.order-label

{

	font-weight: 700;

}

</style>

<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

			<div style="float: left">

				<h1>View Order Details</h1>

			</div>
		
			<div style="float: right">		
			</div>
			<div style="clear: both"></div>
            <button style="margin-right:20px;" onclick="window.location='<?=base_url()?>admin/new_cms/login_as_admin/<?=$order['id']?>';" type="button" class="btn btn-primary">Place Order</button>
            
            <button style="margin-right:20px;" onclick="window.location='<?=base_url()?>admin/order/login_as_client/<?=$order['customer_id']?>';" type="button" class="btn btn-primary">Login as this customer</button>
            
            <button style="margin-right:20px;" onclick="print_results();" type="button" class="btn btn-primary">Print Tax Invoice</button>
            
            <button style="margin-right:20px;" onclick="print_results_com();" type="button" class="btn btn-primary">Print Commercial Invoice</button>
			<div style="clear: both"></div>
			<div>
			<h2>Order Details</h2>
			
            <!-- <button style="margin-right:20px;" onclick="window.location='<?=base_url()?>cron/create_order_xls_per_id/<?=$order['id']?>';" type="button" class="btn btn-primary">Export Order</button> --> 
            <!-- <div style="clear: both; height: 20px;"></div> -->
            <? if($order['admin']>0){echo 'This order is replaced order for order ID <a target="_blank" href="'.base_url().'admin/order/list_all/view/'.$order['admin'].'">'.$order['admin'].'</a>'; ?> <div style="clear: both; height: 20px;"></div><? }?>
            
			<div>

				<div class="order-label" style="float: left; width: 20%">Customer Name</div>
				<? $user = $this->User_model->identify_cust_id($order['customer_id']);?>
				<div style="float: left; width: 80%"><a href="<?=base_url()?>admin/customer/list_all/edit/<?=$user['id'] ?>"><?=$cust['firstname'].' '.$cust['lastname']?>  (<?=$order['customer_id']?>)</a></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Order Number</div>

				<div style="float: left; width: 80%"><?=$order['id']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Order Time</div>

				<div style="float: left; width: 80%"><?=date('H:i:s',strtotime($order['order_time']))?> on the <?=date('jS, F Y',strtotime($order['order_time']))?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Order Status</div>

				<div style="float: left; width: 80%"><?=$order['order_status']?></div>

			</div>
			
			<div style="clear: both; height: 5px;"></div>
			<? if($order['msg']=='Paypal'){?>
			<div>

				<div class="order-label" style="float: left; width: 20%">Payment Method</div>

				<div style="float: left; width: 80%">Paypal </div>

			</div>
            <div>

				<div class="order-label" style="float: left; width: 20%">TXN ID</div>

				<div style="float: left; width: 80%"><?=$order['txn_id']?></div>

			</div>
			<div style="clear: both; height: 5px;"></div>
            
            <? }
			elseif ($order['msg']=='30 Days Invoice') {
				
				?>
			<div>

			<div class="order-label" style="float: left; width: 20%">Payment Method</div>

			<div style="float: left; width: 80%"><?=$order['msg']?></div>

			</div>
				<?
				
			}
            
            else{?>
            <div>

				<div class="order-label" style="float: left; width: 20%">Payment Method</div>

				<div style="float: left; width: 80%"><? if($order['msg']=='No Charge'){?> Free <? } else {?>Credit Card<? }?> </div>

			</div>
            <? if($order['msg']!='No Charge'){?>
			<div style="clear: both; height: 5px;"></div>
             <div>

				<div class="order-label" style="float: left; width: 20%">Credit Card Number</div>

				<div style="float: left; width: 80%"><?=$order['cardnumber']?></div>

			</div>
            <? } ?>
			<div style="clear: both; height: 5px;"></div>
            <div>

				<div class="order-label" style="float: left; width: 20%">Payment Status</div>

				<div style="float: left; width: 80%"><?=$order['msg']?></div>

			</div>
			<div style="clear: both; height: 5px;"></div>
            <? } ?>

			<div>

				<div class="order-label" style="float: left; width: 20%">Coupon Code</div>

				<div style="float: left; width: 80%"><?=$order['coupon_code']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Shipping Method</div>

				<div style="float: left; width: 80%">

					<?php

						$s = $this->System_model->get_shipping($order['shipping_method']);

						echo $s['name'];

					?>

				</div>

			</div>
			<div style="clear: both; height: 5px;"></div>

			<?php

			$cc = 0;

			foreach($cart as $cr)

			{

				$pro = $this->Product_model->identify($cr['product_id']);
				$product = $this->Product_model->identify($cr['product_id']);
				$var = json_decode($cr['attributes'],true);
				//$attributes = json_decode($item['attributes'],true);
				
				if($product['multiplesize'] == 1)
				{
					if($var['Size'] == '65us')
					{
						$size_text = '6.5us';
					}
					elseif($var['Size'] == '75us')
					{
						$size_text = '7.5us';
					}
					elseif($var['Size'] == '85us')
					{
						$size_text = '8.5us';
					}
					elseif($var['Size'] == '95us')
					{
						$size_text = '9.5us';
					}
					elseif($var['Size'] == '105us')
					{
						$size_text = '10.5us';
					}
					else
					{
						$size_text = $var['Size'];
					}
					
					$size = 'Size: '.$size_text;
				}
				else
				{
					$size = '';
				}
				$size = strtoupper($size);
				
				$size ='&nbsp;'.$size;

			?>

			<div>

				<div class="order-label" style="float: left; width: 20%"><?php if($cc == 0){?>Purchased Items<?php }else{?>&nbsp;<?php }?></div>

				<div style="float: left; width: 20%">$<?=$cr['price']?></div>

				<div style="float: left; width: 60%"><?=$cr['quantity']?> x <?=$pro['title']?> <?=$pro['short_desc']?> <?=$size?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<?

			$cc++;

			}

			?>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 80%; border-top: 1px dashed #ccc">&nbsp;</div>

			</div>

			
            <div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 20%">Subtotal</div>

				<div style="float: left; width: 60%">$<?=$order['subtotal']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>
            <? if($order['gift_card']>0){ ?>
			<div>
			<div class="order-label" style="float: left; width: 20%">&nbsp;</div>
			<div style="float: left; width: 20%">Gift Card</div>
			<div style="float: left; width: 60%">$<?=$order['gift_card']?></div>
			
			</div>
 			<div style="clear: both; height: 5px;"></div>
			<? } ?> 

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 20%">

					Discount 

					<?php

					$cp = $this->System_model->check_coupon_code($order['coupon_code']);

					if($cp)

					{

						if($cp['type'] == 1)

						{

							echo $cp['value']."%";

						}

						else

						{

							echo "$".$cp['value'];

						}

					}

					?>

				</div>

				<div style="float: left; width: 60%">- $<?=$order['discount']?></div>

			</div>
            
            <div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 20%">

					Member Discount 


				</div>

				<div style="float: left; width: 60%">- $<?=$order['member_discount']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 20%">Shipping Cost</div>

				<div style="float: left; width: 60%">$<?=$order['shipping_cost']?></div>

			</div>

			

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 20%">Tax</div>

				<div style="float: left; width: 60%">$<?=$order['tax']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 80%; border-top: 1px dashed #ccc">&nbsp;</div>

			</div>

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<div style="float: left; width: 20%">Total</div>

				<div style="float: left; width: 60%">$<?=$order['total']?></div>

			</div>

			<div style="clear: both; height: 30px;"></div>

			<div style="clear: both; height: 10px; border-top: 1px solid #ccc"></div>

			<h2>Shipping Details</h2>

			<div>

				<div class="order-label" style="float: left; width: 20%">Full Name</div>

				<div style="float: left; width: 80%"><?=$order['firstname'].' '.$order['lastname']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Address</div>

				<div style="float: left; width: 80%"><?=$order['address']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<?php

					$state = $this->System_model->get_state($order['state']);

				?>

				<div style="float: left; width: 80%"><?=$order['city']?> , <?=$state?> <?=$order['postcode']?> <?=$this->System_model->get_country($order['country'])?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Email</div>

				<div style="float: left; width: 80%"><?=$order['email']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Message</div>

				<div style="float: left; width: 80%"><?=$order['message']?></div>

			</div>

			

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Tracking URL</div>

				<div style="float: left; width: 80%">

					<script>

					function set_track()

					{

						var id = <?=$order['id']?>;

						var track = $('#track_number').val();

						

						jQuery.ajax({

							url: '<?=base_url()?>admin/order/set_tracking_number',

							type: 'POST',

							data: ({id:id,track:track}),

							dataType: "html",

							success: function(html) {

								//jQuery('#cart-'+id).fadeOut('slow');

								//jQuery('#any_message').html("This coupon has been successfully deleted");

								//$('#anyModal').modal('show');

								

								$('#any_message').text('new tracking number set');

								$('#anyModal').modal('show');

								

							}

						});

					}

					</script>

					<input type="text" id="track_number" value="<?=$order['tracking_number']?>" style="margin-bottom: 0px">

					<button type="button" class="btn btn-primary" onclick="set_track();">Set Tracking URL</button>

				</div>

			</div>

			<div style="clear: both; height: 20px;"></div>

			<!-- end here -->

			<div class="line-between">&nbsp;</div>

			<div style="height: 20px; clear: both">&nbsp;</div>

			<h2>Billing Details</h2>

			<div>

				<div class="order-label" style="float: left; width: 20%">Full Name</div>

				<div style="float: left; width: 80%"><?=$cust['title'].' '.$cust['firstname'].' '.$cust['lastname']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div>

				<div class="order-label" style="float: left; width: 20%">Address</div>

				<div style="float: left; width: 80%"><?=$cust['address']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<?php

			if($cust['address2'] != '')

			{

			?>

			<div>

				<div class="order-label" style="float: left; width: 20%">Address2</div>

				<div style="float: left; width: 80%"><?=$cust['address2']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<?php

			}

			?>

			

			<div>

				<div class="order-label" style="float: left; width: 20%">&nbsp;</div>

				<?php

					$state = $this->System_model->get_state($cust['state']);

				?>

				<div style="float: left; width: 80%"><?=$state?> <?=$cust['postcode']?> <?=$cust['country']?></div>

			</div>

			<div style="clear: both; height: 5px;"></div>

			<div style="height: 20px; clear: both">&nbsp;</div>

			<div class="line-between">&nbsp;</div>

			<div style="height: 20px; clear: both">&nbsp;</div>
			
            </div>
            
			<h2>Admin Comment</h2>

			

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Comment</div>

				<div style="width: 80%; float: right">

					<textarea style="width: 97%" type="text" class="textfield rounded" id="admin_comment" rows="3"></textarea>

				</div>

			</div>

			<div style="height: 5px; clear: both">&nbsp;</div>

			<div>

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>

				<div style="width: 80%; float: right">

					<button class="btn btn-inverse" type="button" onclick="addcomment();">Add Comment</button>

				</div>

			</div>

			<div style="height: 20px; clear: both">&nbsp;</div>

			<table class="table table-hover">

				<thead>

					<tr>

						<th style="width: 10%">Date</th>

						<th style="width: 75%">Comment</th>

						<th style="width: 15%">Admin</th>

					</tr>

				</thead>

				<tbody id="all_comment">

					<?php

					foreach($comments as $cm)

					{

						$user = $this->User_model->id($cm['admin_id']);

					?>

					<tr>

						<td><?=date('d-m-Y',strtotime($cm['created']))?></td>

						<td><?=$cm['comment']?></td>

						<td><?=$user['username']?></td>

					</tr>

					<?

					}

					?>

				</tbody>

			</table>

		</div>

	</div>

</div>
<div class="hprint" id="print_area" style="display:none;">
<?
		$order_id=$order['id'];
		$order = $this->Order_model->identify($order_id);
		$cart = $this->Cart_model->all($order['session_id']);
		$products_info = '';
		$header='';
		$header .='
		
		<table width="630" align="center"><tr><td></td></tr><tr><td>&nbsp;</td></tr>';
		$footer ='';
		$footer .='
				<table width="630" align="center">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">Message : </span>'; 
					if($order['message']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$order['message'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
				Thank you for shopping at Bared. <br><br>
				Please retain this invoice as a record of your purchase. Please check your goods carefully and refer to our <br>
				Terms & Conditions and Warranty & Returns policy. You will be charged in Australian dollars. <br><br>
				Unfortunately we cannot accept returns or exchanges on sale items.
				</span>
				</td>
				</tr>
				<tr>
				<td align="center"> 
				<br>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700; color:#000!important; text-decoration:none; ">WWW.BARED.COM.AU </span><br> 
				<span style="font-family:Times New Roman, Times, serif; font-size:10px; font-weight:400; ">Bared </span></td>
		</tr></table>';
		$content='';
		$s = $this->System_model->get_shipping($order['shipping_method']);

		if($order['msg']=='Paypal'){
		$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Paypal TXN ID: '.$order['txn_id'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';			
		
		}
		
		else	
		{
			if($order['msg'] == '30 Days Invoice')
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: 30 Days Invoice<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
			else 
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">TAX INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Credit Card Credit Card Number: '.$order['cardnumber'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
			
		
		}
		$cust = $this->Customer_model->identify($order['customer_id']);
		$state_cust = $this->System_model->get_state($cust['state']);
		$state_order = $this->System_model->get_state($order['state']);
		$country = $this->System_model->get_country($order['country']);
		$content.='<tr><td>&nbsp;&nbsp;</td></tr>
		<tr bgcolor="#F1F2F2"><td>
			<table width="100%">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> BILL TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$cust['firstname'].'<br>
						 '.$cust['lastname'].'<br>
						 '.$cust['address'].'<br>
						 '.$cust['address2'].'<br>
						 '.$cust['city'].'<br>
						 '.$state_cust.'<br>
						 '.$cust['postcode'].'<br>
						 '.$cust['country'].'<br>
						 '.$cust['mobile'].'<br>	</span>					 
					</td>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> SHIP TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$order['firstname'].'<br>
						 '.$order['lastname'].'<br>
						 '.$order['address'].'<br>
						 '.$order['address2'].'<br>
						 '.$order['city'].'<br>
						 '.$state_order.'<br>
						 '.$order['postcode'].'<br>
						 '.$country.'<br>	</span>					 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td></tr></table>';
		$content.='
		<table width="630" align="center">
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">CODE </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRODUCT NAME </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">QTY </span></td>
				<td> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRICE </span></td>
				<td align="right"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">SUBTOTAL </span></td>
			</tr>';
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			//$attributes = json_decode($item['attributes'],true);
			$product = $this->Product_model->identify($item['product_id']);
			$var = json_decode($item['attributes'],true);
			//$attributes = json_decode($item['attributes'],true);
			
			if($product['multiplesize'] == 1)
			{
				if($var['Size'] == '65us')
				{
					$size_text = '6.5us';
				}
				elseif($var['Size'] == '75us')
				{
					$size_text = '7.5us';
				}
				elseif($var['Size'] == '85us')
				{
					$size_text = '8.5us';
				}
				elseif($var['Size'] == '95us')
				{
					$size_text = '9.5us';
				}
				elseif($var['Size'] == '105us')
				{
					$size_text = '10.5us';
				}
				else
				{
					$size_text = $var['Size'];
				}
				
				$size = 'Size: '.$size_text;
			}
			else
			{
				$size = '';
			}
			$size = strtoupper($size);
			
			$size ='&nbsp;'.$size;
			$content.='
			<tr>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['id'].'  </span></td>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['title'].' '. $product['short_desc'].' '.$size.' </span></td>
				<td align="center"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$item['quantity'].'</span> </td>
				<td>
				<table cellpadding="0" cellspacing="0" ><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['price'],2,'.',',').' </span></td></tr></table></td>
				
				<td align="right">
					<table cellpadding="0" cellspacing="0" align="right"><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['quantity'] * $item['price'],2,'.',',').' </span></td></tr></table></td>
			</tr>';
						
		}
		$order_id = sprintf('%04d',$order_id);
		$order_time = date('l dS F Y',strtotime($order['order_time']));

		$content.='
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		</table>
		
		<table width=" 630" cellpadding="0" cellspacing="0" align="center">
		<tr>
		<td width="50%">&nbsp;</td>
		<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">ITEMS SUB TOTAL:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['subtotal'].'</span></td>
		</tr>';
		if($order['gift_card']>0){
		$content.='
			<tr>
			<td width="50%">&nbsp;</td>
			<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">GIFT CARD:</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['gift_card'].'</span></td>
			</tr>'; 
		}
		$content.='
		<tr>
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Shipping:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['shipping_cost'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Discount:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">-AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['discount'].'</span></td>
		</tr>
		<tr>
		<td width="50%">&nbsp;</td>
		<td style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">GST 10%</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">AUD$</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">'.$order['tax'].'</span></td>
		</tr>
		<tr style="border-bottom:4px solid #000;">
		<td width="50%">&nbsp;</td>
		<td  style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">TOTAL AMOUNT:</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400;margin-top:5px;">AUD$</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">'.$order['total'].'</div></td>
		</tr>
		
		</table>
		';			
		$message = $header.$content.$footer;
		echo $message;
?>		
</div>


<div class="hprintcom" id="print_areacom" style="display:none;">
<?
		$order_id=$order['id'];
		$order = $this->Order_model->identify($order_id);
		//echo $order['msg'].'132<br/>';
		$cart = $this->Cart_model->all($order['session_id']);
		$products_info = '';
		$header='';
		$header .='
		
		<table width="630" align="center"><tr><td></td></tr><tr><td>&nbsp;</td></tr>';
		$footer ='';
		$footer .='
				<table width="630" align="center">
				<tr><td>&nbsp;</td></tr>				
				<tr>
					<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700;">Message : </span>'; 
					if($order['message']){$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important; ">'.$order['message'];}
					else{$footer.='<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400!important;">-';}
				$footer.='</span></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
				Thank you for shopping at Bared. <br><br>
				Please retain this invoice as a record of your purchase. Please check your goods carefully and refer to our <br>
				Terms & Conditions and Warranty & Returns policy. You will be charged in Australian dollars. <br><br>
				Unfortunately we cannot accept returns or exchanges on sale items.
				</span>
				</td>
				</tr>
				<tr>
				<td align="center"> 
				<br>
				<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:700; color:#000!important; text-decoration:none; ">WWW.BARED.COM.AU </span><br> 
				<span style="font-family:Times New Roman, Times, serif; font-size:10px; font-weight:400; ">Bared </span></td>
		</tr></table>';
		$content='';
		$s = $this->System_model->get_shipping($order['shipping_method']);

		if($order['msg']=='Paypal'){
		$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">COMMERCIAL INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Paypal TXN ID: '.$order['txn_id'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';			
		
		}
		
		else
		{
			if($order['msg'] == '30 Days Invoice')
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">COMMERCIAL INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: 30 Days Invoice<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}
			else
			{
				$content .='<tr><td>
			<span style="font-family:Arial,Verdana, Sans-serif; font-size:18px; font-weight:700; ">COMMERCIAL INVOICE</span> <br>
			<span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">
			<br>
			Order: #'.$order_id.' <br>
			Date: '.date('d-m-Y, H:i',strtotime($order['order_time'])).'<br>
			Payment method: Credit Card Credit Card Number: '.$order['cardnumber'].'<br>
			Shipping method: '.$s['name'].'</span>
		<td></tr>';
			}	
		
		}
		$cust = $this->Customer_model->identify($order['customer_id']);
		$state_cust = $this->System_model->get_state($cust['state']);
		$state_order = $this->System_model->get_state($order['state']);
		$country = $this->System_model->get_country($order['country']);
		$content.='<tr><td>&nbsp;&nbsp;</td></tr>
		<tr bgcolor="#F1F2F2"><td>
			<table width="100%">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> BILL TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$cust['firstname'].'<br>
						 '.$cust['lastname'].'<br>
						 '.$cust['address'].'<br>
						 '.$cust['address2'].'<br>
						 '.$cust['city'].'<br>
						 '.$state_cust.'<br>
						 '.$cust['postcode'].'<br>
						 '.$cust['country'].'<br>
						 '.$cust['mobile'].'<br>	</span>					 
					</td>
					<td valign="top"><span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; "> SHIP TO : </span></td>
					<td valign="top"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; "> '.$order['firstname'].'<br>
						 '.$order['lastname'].'<br>
						 '.$order['address'].'<br>
						 '.$order['address2'].'<br>
						 '.$order['city'].'<br>
						 '.$state_order.'<br>
						 '.$order['postcode'].'<br>
						 '.$country.'<br>	</span>					 
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td></tr></table>';
		$content.='
		<table width="630" align="center">
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr>
				<td valign="top"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">CODE </span></td>
				<td valign="top" width="35%"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRODUCT NAME </span></td>
				<td valign="top"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">COMPOSITION </span></td>
				<td valign="top"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">QTY </span></td>
				<td valign="top"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">PRICE </span></td>
				<td valign="top" align="right"> <span style="font-family:Arial,Verdana, Sans-serif; font-size:14px; font-weight:700; ">SUBTOTAL </span></td>
			</tr>';
		foreach($cart as $item) 
		{
			$product = $this->Product_model->identify($item['product_id']);
			//$attributes = json_decode($item['attributes'],true);
			$product = $this->Product_model->identify($item['product_id']);
			$var = json_decode($item['attributes'],true);
			//$attributes = json_decode($item['attributes'],true);
			
			if($product['multiplesize'] == 1)
			{
				if($var['Size'] == '65us')
				{
					$size_text = '6.5us';
				}
				elseif($var['Size'] == '75us')
				{
					$size_text = '7.5us';
				}
				elseif($var['Size'] == '85us')
				{
					$size_text = '8.5us';
				}
				elseif($var['Size'] == '95us')
				{
					$size_text = '9.5us';
				}
				elseif($var['Size'] == '105us')
				{
					$size_text = '10.5us';
				}
				else
				{
					$size_text = $var['Size'];
				}
				
				$size = 'Size: '.$size_text;
			}
			else
			{
				$size = '';
			}
			$size = strtoupper($size);
			
			$size ='&nbsp;'.$size;
			$content.='
			<tr>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['id'].'  </span></td>
				<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$product['title'].' '. $product['short_desc'].' '.$size.' </span></td>
				<td align="center"><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$item['quantity'].'</span> </td>
				<td>
				<table cellpadding="0" cellspacing="0" ><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['price'],2,'.',',').' </span></td></tr></table></td>
				
				<td align="right">
					<table cellpadding="0" cellspacing="0" align="right"><tr><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td><td width="20">&nbsp;</td><td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.number_format($item['quantity'] * $item['price'],2,'.',',').' </span></td></tr></table></td>
			</tr>';
						
		}
		$order_id = sprintf('%04d',$order_id);
		$order_time = date('l dS F Y',strtotime($order['order_time']));

		$content.='
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		<tr><td colspan="5"></td></tr>
		</table>
		
		<table width=" 630" cellpadding="0" cellspacing="0" align="center">
		<tr>
		<td width="50%">&nbsp;</td>
		<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">ITEMS SUB TOTAL:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['subtotal'].'</span></td>
		</tr>';
		if($order['gift_card']>0){
		$content.='
			<tr>
			<td width="50%">&nbsp;</td>
			<td><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">GIFT CARD:</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
			<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['gift_card'].'</span></td>
			</tr>'; 
		}
		$content.='
		<tr>
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Shipping:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['shipping_cost'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td  ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">Discount:</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">-AUD$</span></td>
		<td align="right" ><span style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; ">'.$order['discount'].'</span></td>
		</tr>
		<tr>
		<td width="50%">&nbsp;</td>
		<td style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">GST 10%</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">AUD$</span></td>
		<td align="right" style="border-bottom:1px solid #000;"><span style="font-family:Times New Roman, Times, serif; font-size:12px; font-weight:400; ">'.$order['tax'].'</span></td>
		</tr>
		<tr >
		<td width="50%">&nbsp;</td>
		<td  style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">TOTAL AMOUNT:</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400;margin-top:5px;">AUD$</div></td>
		<td align="right" style="border-bottom:4px solid #000;"><div style="font-family:Times New Roman, Times, serif; font-size:14px; font-weight:400; margin-top:5px;">'.$order['total'].'</div></td>
		</tr>
		
		</table>
		';			
		$message = $header.$content.$footer;
		echo $message;
?>		
</div>



<script>

function addcomment()

{

	var comment = $('#admin_comment').val();

	var cust_id = <?=$order['customer_id']?>;

	

	$.ajax({ 

			url: '<?=base_url()?>admin/customer/add_comment',

			type: 'POST',

			data: ({comment:comment,cust_id:cust_id}),

			dataType: "html",

			success: function(html) {

				$('#all_comment').html(html);

			}

		})	

	

	//alert(comment);

}

</script>



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