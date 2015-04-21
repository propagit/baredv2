    	<script type="text/javascript" src="<?=base_url()?>js/jquery.jqprint.0.3.js"></script>
		<script>
		var $j = jQuery.noConflict();
		function print_results() {
			$j('#print_area').css({"background":"#fff"});
			$j(".hprint").css({"background":"#fff"});
			$j('#order_header').css({"display":"block"});
			$j('#print_area').jqprint();
			$j('#order_header').css({"display":"none"});
		}
		</script>
		<div class="left">
        	<h1>Store Management</h1>
            <div class="bar">

            	<div class="text">Manage Orders &raquo; View Order Details</div>
            	<div class="cr"></div>
            </div>
            <div class="box">
            	<p>
                	<input type="button" class="button rounded" value="Back to Orders List" onclick="history.go(-1)" />
                    <input onclick="print_results();" id="print_order" type="button" class="button rounded" value="Print Order" />
                </p>
            </div>            
            <hr />
            <!--
			<div id="print_area">
            <div id="order_header" class="hprint" style="background-color:#FFFFFF; height:146px; display:none;">
            	<div style="float:left; padding-left:20px; padding-top:10px;"><img src="<?=base_url()?>img/logo_signature.png" alt=""></div>
            	<div style="float:right; color:#575757; font-size:12px; padding-right:10px; padding-top:10px;">
                	<span style="font-weight:bold;">Nana Huchy</span> <br/>
                    31B Hume Street <br/>
                    Huntingdale Victoria 3166 Australia  <br/>
                    T: 1800 454 282 <br/>
                    F: +61 3 9077 3042 <br/>
                    ABN 61261315176 <br/>
                    <a href="mailto:sales@nanahuchy.com" style="text-decoration:none; color:#404040;">sales@nanahuchy.com</a><br/>
                    <a href="http://www.nanahuchy.com" target="_blank" style="text-decoration:none; color:#404040;">www.nanahuchy.com</a><br/>
                </div>                
            </div>
            </div>
            -->
            <div class="box bgw hprint" style="min-height:400px">
            	<h3>Order Details</h3>
                <? $cust = $this->Customer_model->identify($order['customer_id']);?>
				<dl class="two"><dt>Customer Name</dt><dd><a href="<?=base_url()?>admin/store/customer/edit/<?=$order['customer_id']?>"><? echo $cust['firstname'].' '.$cust['lastname'];?></a></dd></dl>
                <dl class="two"><dt>Order Number</dt><dd><?=$order['id']?></dd></dl>
                <dl class="two"><dt>Order time</dt><dd><?=date('H:i:s',strtotime($order['order_time']))?> on the <?=date('jS, F Y',strtotime($order['order_time']))?></dd></dl>
                <dl class="two"><dt>Order status</dt><dd<?php if($order['status'] == 'successful') print ' class="green"'; else print ' class="error"'; ?>>
                <!--
                <?php if($order['status'] != 'successful') 
				{ 
					$msg = str_replace('eWAY Error:','',$order['msg']); 
					$msg = str_replace('(Test CVN Gateway)','',$msg); 
					$msg = str_replace('80,','',$msg);
					if (strlen($msg) > 80) {
						$n = strpos($msg,'.',80);
						$msg = substr($msg,0,$n);
					} ?>
                    <dl class="two"><dt>Declined reason</dt><dd class="error"><?=$msg?></dd></dl>
                <?php } ?>
                -->
                <?
                	$msg=$order['msg'];
					if(substr($order['msg'],0,2)=='05')
					{
						$msg='Do Not Honour. There might be a problem with your account or the card details have not been entered correctly';
					}
					if(substr($order['msg'],0,2)=='58')
					{
						$msg='Function Not Permitted to Terminal';
					}
				?>
                <p><?=ucwords($order['status'])?> <br /> (<?=$msg?>)</p></dd></dl>
                <dl class="two"><dt>Purchased items</dt><dd>
                	<?php foreach($cart as $item) 
					{ 
					$product = $this->Product_model->identify($item['product_id']);
					//$attributes = str_replace(':',': ',$item['attributes']);
                    //$attributes = str_replace('~','. ',$attributes); ?>
                    <dl class="three"><dt>$<?=$item['price']?></dt><dd><?=$item['quantity']?> x <?php if(!empty($product['title'])) echo $product['title'];?></dd>
                    <dd><?php 
					    echo $item['attributes'];
						?>
					 </dd>
                     <?
					}
					?>
                <dl></dl>
                <hr />
                <dl class="two"><dt>Sub total</dt><dd>$<?=$order['subtotal']?></dd></dl>
                <dl class="two"><dt>Tax</dt><dd>$<?=$order['tax']?></dd></dl>
                <?php if($order['discount'] > 0) { 
					$coupon = $this->System_model->check_coupon_code($order['coupon_code']);
					$value = $coupon['value'];
					if ($coupon['type'] == 1) { 
						$amount = money_format('%i',floatval($value) * floatval($order['subtotal'] + $order['tax'])/100);
						$value = $value.'% (-$'.$amount.')'; 
					} else { $value = '$'.$value; }
				?>
                <dl class="two"><dt>Discount</dt><dd>-<?=$value?></dd></dl>
                <?php } 
				//only show shipping when customer is not a trade customer
				$user = $this->session->userdata('cloggedin');
				if($user['level'] != 4){
				?>
                
                <dl class="two"><dt>Shipping cost</dt>
                    <dd>
                        <dl class="three">
                                <dt>$<?=$order['shipping_cost']?></dt>
                                <dd>Shipping method</dd>
                                <dd><?php if(!empty($shipping['id'])){ ?><a href="<?=base_url()?>admin/system/shipping/edit/<?=$shipping['id']?>"><?=$shipping['name']?></a><?php } ?></dd>
                        </dl>
                    </dd>
                </dl>
                
                <dl class="two"><dt>&nbsp;</dt>
                    <dd>
                    <dl class="three">
                            <dt>&nbsp;</dt>
                            <dd>Shipping Weight</dd>
                            <dd>$<?=$order['shipping_weight']?>=<?=$order['weight']?>kg x $<?=$order['cost_weight']?></dd>
                    </dl>
                    </dd>
                </dl>
                
                <dl class="two"><dt>&nbsp;</dt>
                <dd>
                <dl class="three">
                		<dt>&nbsp;</dt>
                        <dd>Shipping Flat</dd>
                        <dd><div style="margin-left:20px;">$<?=$order['cost_flat']?></div></dd>
                </dl>
                </dd>
                </dl>
				<?php
				}
				?>                
                <dl></dl><hr />
                <dl class="two"><dt>Total</dt><dd>$<?=$order['total']?></dd></dl>
                <dl></dl>
                </dl></dd></dl>
                <dl class="two"><dt>&nbsp;</dt></dl>
                <div style="clear:both;"></div>
                
            </div>
            <hr />            
            <div class="box hprint">
            	<h3>Shipping Details</h3>
                <? $states=$this->System_model->get_state($order['state']);
				
				?>
                <dl class="two"><dt>Full name</dt><dd><?=$order['firstname']?> <?=$order['lastname']?></dd></dl>
                <dl class="two"><dt>Address</dt><dd><?=$order['address']?>, <?=$order['city']?></dd></dl>
                <dl class="two"><dt>&nbsp;</dt><dd><?=$states?> <?=$order['postcode']?> <?=$order['country']?> </dd></dl>             
				<dl class="two"><dt>Email</dt><dd><?=$order['email']?></dd></dl>
                <dl class="two"><dt>Phone</dt><dd><? if($order['phone']){echo $order['phone'];}else{echo '-';} ?></dd></dl>
                <dl class="two"><dt>Message</dt><dd><p><? if($order['message']){echo $order['message'];}else{echo '-';}?></p></dd></dl>
				<dl></dl>
            </div>
            <hr />
	        <!--
            <div class="box bgw">
            	<h3>Payment</h3>
                <dl class="two"><dt>Card name</dt><dd><?=$order['cardname']?></dd></dl>
                <dl class="two"><dt>Card type</dt><dd><?=$order['cardtype']?></dd></dl>
                <dl class="two"><dt>Card number</dt><dd><?=$order['cardnumber']?></dd></dl>
                <dl class="two"><dt>Expiry date</dt><dd><?php printf('%02s',$order['expmonth']); ?>/<?=$order['expyear']?></dd></dl>
                <dl class="two"><dt>CVV number</dt><dd><?=$order['cvv']?></dd></dl>
                <dl></dl>
            </div>
			-->
        </div>
        
