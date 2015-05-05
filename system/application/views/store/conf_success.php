<div class="app-container">
    <div style="height: 20px;"></div>
    <div style="width: 100%">
	<div style="margin: 0 auto" class="hidden-xs linkbreadcrumb">
		<table align="center" cellpadding="0" cellspacing="0" class="body-copy-Font">
			<tr style="text-align: center">
				<td style="padding-bottom: 5px">Shopping Bag</td>
				<td></td>
				<td style="padding-bottom: 5px">Order Summary</td>
				<td></td>
				<td style="padding-bottom: 5px">Confirmation</td>
			</tr>
			<tr>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
			</tr>
			<tr style="text-align: center">
				<td></td>
				<td>Account Details</td>
				<td></td>
				<td>Payment</td>
				<td></td>
			</tr>
		</table>
		
	</div>
    <div style="margin: 0 auto" class="visible-phone">
		
       <div class="col-sm-12" style="text-align: center">
            <ul class="breadcrumb linkbreadcrumb breadcrumb-Font">
                <li class="active2">Shopping Bag <span class="divider">></span></li>
                <li class="active2">Account Details <span class="divider">></span></li>
                <li class="active2">Order Summary <span class="divider">></span></li>
                <li class="active2">Payment <span class="divider">></span></li>
                <li class="active2">Confirmation </li>
            </ul>
        </div>      
		
	</div>
	</div>
	
	<h4>CONFIRMATION</h4>
    <div style="height: 20px;"></div>
    
	<div class="">
		<div class="col-sm-12">
			<div class="body-copy-Font font18semibold checkout_result_msg">THANK YOU... WE HAVE SUCCESSFULLY RECEIVED YOUR ORDER</div>
			<div style="height: 50px;"></div>
			<div class="body-copy-Font">
				<div style="float: left; width:140px; height:30px;">Your order no: </div>
                	<div style="float: left; margin-left: 10px"><?=$order['id']?></div>
                <div style="clear:both;"></div>
				<div style="float: left; width:140px; height:30px;">You have ordered:</div>
				<div style="float: left; margin-left: 10px">
					<?php
						foreach($carts as $c)
						{
							$prod = $this->Product_model->identify($c['product_id']);
							$var = json_decode($c['attributes'],true);
							?>
							<?=$c['quantity'].'x '.$prod['title'].' '.$prod['short_desc']?>, &nbsp;Size: <span style="text-transform: uppercase">
							<?php
							if($prod['multiplesize'] == 1)
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
						 		echo $size_text;
							}
							?></span>
							<br/>
							<?
						}
					?>
				</div>
				<div style="clear: both; height: 20px"></div>
				<div style="float: left; width:200px;height:30px;"><?=$order['store_pickup'] ? 'Pickup Address:' : 'Your item(s) will be shipped to:';?> </div>
				<div style="float: left; margin-left: 10px">
                	<?php if(!$order['store_pickup']){ ?>
					<?=$order['firstname']?> <?=$order['lastname']?><br/>
                    <?php } ?>
					<?=$order['address']?><br/>
					<?php
						if($order['address2'] != '')
						{
						?>
							<?=$order['address2']?><br/>
						<?
						}
					?>
					<?=$order['city']?><br/>
					<?=$this->System_model->get_state($order['state'])?> <?=$order['postcode']?><br/>
					<?=$this->System_model->get_country($order['country'])?>
				</div>
				<div style="clear: both; height: 20px"></div>
				<div style="width:80%;">
					Thank you for placing an order with Bared, your credit card has been debited and you will receive a tax invoice via email shortly.<br> 
                    <?php if(!$order['store_pickup']){ ?>
					Your order will be dispatched within two business days. We will notify you as soon as your order is on its way and inculde a tracking number so you can follow it right to your door!
                    <?php }else{ ?>
                    Your order is ready for pickup at our store. You can check our opening hours <a target="_blank" href="<?=base_url();?>page/Melbourne-Shoe-Store">here</a>
                    <?php } ?>
				</div>
				<div style="clear: both; height: 20px"></div>
				<div style="width:80%;">
					Should you have any questions or concerns please contact customer service by emailing <a class="body-copy-Font primarylink " href="mailto:info@bared.com.au">info@bared.com.au</a><br /> or calling +61 3 9509 5771.
				</div>
                <? 
				
				if($order['admin_id']==1){?>
                <div style="clear: both; height: 20px"></div>
				<div>
				<button style="margin-right:20px;" onclick="window.location='<?=base_url()?>store_admin/login_admin/<?=$order['id']?>';" type="button" class="btn btn-primary button-Font">Return</button>				
				</div>
                <? } ?>
			</div>
		</div>
	</div>
	<div style="height: 30px;"></div>
    
    
    
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    
    <!-- End Product for Iphone -->
		
        
   