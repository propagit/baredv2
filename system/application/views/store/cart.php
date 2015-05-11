<script>
var choose = 0;

function move_to_wishlist(id,cid)
{
	if($('#sizeproduct-'+cid).val() == '--')
	{
		$('#any_message').html("Please Choose Your Size");
		$('#anyModal').modal('show');
		return false;
	}
	var attributes = '';
	
	var myObject = new Object();
	var num = 0;
	<?php if(0){ ?>
	<?php for($i=0;$i<count($attributes);$i++) 
	{ ?>
	 // use json javascript generator and pass value in json format(by Hieu)
	 //myArray[<?=$i?>] = $j('#attribute-<?=$i?>').val();
	 myObject.<?=$attributes[$i]['name']?> = $('#attribute-<?=$i?>').val();
	<?php } ?>
	<?php } ?>
	if($('#sizeproduct-'+cid).length)
	{
	  mul_size = $('#sizeproduct-'+cid).val();
	
		myObject.Size = mul_size;
	}
	//var myObject = toObject(myArray);
	attributes = JSON.stringify(myObject);
	
	
	jQuery.ajax({
		url: '<?=base_url()?>cart/from_cart_to_wishlist',
		type: 'POST',
		data: ({id:id,attributes:attributes}),
		dataType: "html",
		success: function(html) {
			
			if(html != '-1')
			{
				jQuery.ajax({
				url: '<?=base_url()?>cart/removeitem',
				type: 'POST',
				data: ({id:cid}),
				dataType: "html",
				success: function(html) {
					jQuery('#cart-'+cid).fadeOut('slow');
					location.reload(); 
					
					
					}
				})
			}
			else
			{
				jQuery('#any_message').html('Please login to your member account to add this product to your wish list wishlist <br> Click <a class="a-primary" href="<?=base_url()?>store/signin"> here </a> to sign up or login to your member account.');
				jQuery('#anyModal').modal('show');
			}
			
		}
	})
}

function delete_cart(id)
{
	choose = id;	
	jQuery('#deleteModal').modal('show');
}

function deletecart(id)
{
	jQuery('#deleteModal').modal('hide');
	
	jQuery.ajax({
		url: '<?=base_url()?>cart/removeitem',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('.cart-'+id).fadeOut('slow');
		}
	})
}
function checkout()
{
	if (jQuery('#curr_agree').is(':checked')) {
		<?php
			if($this->session->userdata('userloggedin'))
			{
				$user = $this->session->userdata('userloggedin');
				?>
					//window.location='<?=base_url()?>store/edit_detail_retail/<?=$user['customer_id']?>';
					window.location='<?=base_url()?>cart/account_page/';
				<?
			}
			else
			{
				?>
					window.location='<?=base_url()?>store/signin';
				<?
			}
		?>
	
	}
	else
	{
		jQuery('#any_message').text('Please tick the checkbox to proceed.');		
		jQuery('#anyModal').modal('show');
		jQuery('#curr_agree').focus();
	}
}
</script>

<div class="app-container">
	<div class="col-sm-12">
    <div class="col-sm-12">
	<?php if($this->session->flashdata('error_product_quantity')) { ?>
	    <div style="margin-top: 20px" class="alert alert-error">
	    	<button type="button" class="close" onclick="$('.alert-error').fadeOut('slow');">&times;</button>
			<strong>ERROR!</strong> <?=$this->session->flashdata('error_product_quantity')?>
		</div>
	<?php }?>
	<div style="height: 10px;"></div>
    
    <ul class="breadcrum-Font breadcrumb">
        <li><a href="<?=base_url()?>">Home</a> <span class="divider">></span></li>
        <li class="active"><a href="<?=base_url()?>cart/list_cart">Shopping Bag</a> </li>
    </ul>
    
    
    <h4>Welcome To Your Shopping Bag</h4>
	
	<div style="float:right;" class="hidden-xs" >		
		<button onclick="window.location='<?=base_url()?>'" 
        	class="button_primary button-Font" style="width: 235px;">
			Continue Shopping
		</button>
	</div>
    
    <div style="float:left;" class="visible-xs button-Font">		
		<button onclick="window.location='<?=base_url()?>'" style="width: 235px;" class="button_primary button-Font">
			Continue Shopping
		</button>
	</div>
    
	<div style="clear: both; height: 20px;"></div>
	<table class="table hidden-xs">
		<thead class="header-cart-Font">
			<tr>
				<th style="width: 8.33%">
					<span class="header-cart">ITEMS</span>
				</th>
				<th style="width: 31%">
					<span class="header-cart">PRODUCT NAME</span>
				</th>
				<th style="width: 14.65%">
					<span class="header-cart">DESCRIPTION</span>
				</th>    
				<th style="width: 8%">
					<span class="header-cart">SIZE</span>
				</th>                
				<th style="width: 10.99%">
					<span class="header-cart" style="text-align: center">QTY</span>
				</th>
				<th style="width: 16.67%; text-align: center">
					<span class="header-cart">UNIT PRICE</span>
				</th>
			</tr>
		</thead>
		<tbody class="detail-cart-Font">
			<form name="updateCart" method="post" action="<?=base_url()?>cart/updateitems"> 
			<?php
		    	$ttl = 0;
				$total_items = count($cart);
				$cart__counter = 0;
		    	foreach($cart as $c)
				{
					$cart__counter++;
					$itemprice = $c['price'] * $c['quantity'];
					$ttl += $itemprice;
					$pro = $this->Product_model->identify($c['product_id']);
					$hero = $this->Product_model->get_hero($c['product_id']);
					$var = json_decode($c['attributes'],true);
					if($pro['deleted'] == 0)
					{
				?>
				<tr class="cart-<?=$c['id']?> <?=$cart__counter < $total_items ? 'cart_item_divider' : '';?>">
					<td>
						
						<?  $categories = $this->Product_model->get_categories_single($c['product_id']);
							$category = $this->Category_model->identify($categories['category_id']);
						?>
                        <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$pro['id_title']?>">
						<?php
							if($hero)
							{
							?>
								<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$pro['id'])?>/thumb3/<?=$hero['name']?>"/>
							<?
							}
							else
							{
							?>
								<img style="" src="http://placehold.it/89x97"/>
							<?
							}
						?>
						</a>
					</td>
					<td >
						<div class="detail-cart-Font detail-cart" style="margin-top: 0px;">
							<a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$pro['id_title']?>"><?=$pro['title']?></a>
						</div>
						<div class="detail-cart-Font detail-cart-link  cart_remove_box">
							<span onclick="move_to_wishlist(<?=$c['product_id']?>,<?=$c['id']?>)" style="cursor: pointer">Move to Wish List</span> 
                            <span class="cart_line_pipe">&nbsp;&nbsp;|&nbsp;&nbsp;</span> 
                            <span class="cart_line_pipe_second"><br /></span> 
                            <span onclick="delete_cart(<?=$c['id']?>);" style="cursor: pointer">Remove from Shopping Bag</span>
						</div>
					</td>
					<td><span class="detail-cart-Font detail-cart"><?=$pro['short_desc']?></span></td>		
					<td>
						<?php
						 if($pro['multiplesize'] == 1)
						 {
						$multiple_stock = json_decode($pro['size'],true);?>
						<input type="hidden" name="tempsize-<?=$c['id']?>" id="tempsize-<?=$c['id']?>" value="<?=$var['Size']?>" />
                        <select name="sizeproduct-<?=$c['id']?>" id="sizeproduct-<?=$c['id']?>" >
                            <option value="--">Please Select</option>
                            <?php if($multiple_stock['34eu']>0){?><option <?php if($var['Size'] == '34eu') print ' selected="selected"';?> value="34eu">34 EU</option><?php }?>
                            <?php if($multiple_stock['35eu']>0){?><option <?php if($var['Size'] == '35eu') print ' selected="selected"';?> value="35eu">35 EU</option><?php }?>
                            <?php if($multiple_stock['36eu']>0){?><option <?php if($var['Size'] == '36eu') print ' selected="selected"';?> value="36eu">36 EU</option><?php }?>
                            <?php if($multiple_stock['37eu']>0){?><option <?php if($var['Size'] == '37eu') print ' selected="selected"';?> value="37eu">37 EU</option><?php }?>
                            <?php if($multiple_stock['38eu']>0){?><option <?php if($var['Size'] == '38eu') print ' selected="selected"';?> value="38eu">38 EU</option><?php }?>
                            <?php if($multiple_stock['39eu']>0){?><option <?php if($var['Size'] == '39eu') print ' selected="selected"';?> value="39eu">39 EU</option><?php }?>
                            <?php if($multiple_stock['40eu']>0){?><option <?php if($var['Size'] == '40eu') print ' selected="selected"';?> value="40eu">40 EU</option><?php }?>
                            <?php if($multiple_stock['41eu']>0){?><option <?php if($var['Size'] == '41eu') print ' selected="selected"';?> value="41eu">41 EU</option><?php }?>
                            <?php if($multiple_stock['42eu']>0){?><option <?php if($var['Size'] == '42eu') print ' selected="selected"';?> value="42eu">42 EU</option><?php }?>
                            <?php if($multiple_stock['43eu']>0){?><option <?php if($var['Size'] == '43eu') print ' selected="selected"';?> value="43eu">43 EU</option><?php }?>
                            <?php if($multiple_stock['44eu']>0){?><option <?php if($var['Size'] == '44eu') print ' selected="selected"';?> value="44eu">44 EU</option><?php }?>
                            <?php if($multiple_stock['45eu']>0){?><option <?php if($var['Size'] == '45eu') print ' selected="selected"';?> value="45eu">45 EU</option><?php }?>
                            <?php if($multiple_stock['46eu']>0){?><option <?php if($var['Size'] == '46eu') print ' selected="selected"';?> value="46eu">46 EU</option><?php }?>
                            <?php if($multiple_stock['47eu']>0){?><option <?php if($var['Size'] == '47eu') print ' selected="selected"';?> value="47eu">47 EU</option><?php }?>
						   <?php if($multiple_stock['48eu']>0){?><option <?php if($var['Size'] == '48eu') print ' selected="selected"';?> value="48eu">48 EU</option><?php }?>
                            <?php if($multiple_stock['5us']>0){?><option <?php if($var['Size'] == '5us') print ' selected="selected"';?> value="5us">5 US</option><?php }?>
                            <?php if($multiple_stock['6us']>0){?><option <?php if($var['Size'] == '6us') print ' selected="selected"';?> value="6us">6 US</option><?php }?>
                            <?php if($multiple_stock['65us']>0){?><option <?php if($var['Size'] == '65us') print ' selected="selected"';?> value="65us">6.5 US</option><?php }?>
                            <?php if($multiple_stock['7us']>0){?><option <?php if($var['Size'] == '7us') print ' selected="selected"';?> value="7us">7 US</option><?php }?>
                            <?php if($multiple_stock['75us']>0){?><option <?php if($var['Size'] == '75us') print ' selected="selected"';?> value="75us">7.5 US</option><?php }?>
                            <?php if($multiple_stock['8us']>0){?><option <?php if($var['Size'] == '8us') print ' selected="selected"';?> value="8us">8 US</option><?php }?>
                            <?php if($multiple_stock['85us']>0){?><option <?php if($var['Size'] == '85us') print ' selected="selected"';?> value="85us">8.5 US</option><?php }?>
                            <?php if($multiple_stock['9us']>0){?><option <?php if($var['Size'] == '9us') print ' selected="selected"';?> value="9us">9 US</option><?php }?>
                            <?php if($multiple_stock['95us']>0){?><option <?php if($var['Size'] == '95us') print ' selected="selected"';?> value="95us">9.5 US</option><?php }?>
                            <?php if($multiple_stock['10us']>0){?><option <?php if($var['Size'] == '10us') print ' selected="selected"';?> value="10us">10 US</option><?php }?>
                            <?php if($multiple_stock['105us']>0){?><option <?php if($var['Size'] == '105us') print ' selected="selected"';?> value="105us">10.5 US</option><?php }?>
                            <?php if($multiple_stock['11us']>0){?><option <?php if($var['Size'] == '11us') print ' selected="selected"';?> value="11us">11 US</option><?php }?>
                            <?php if($multiple_stock['12us']>0){?><option <?php if($var['Size'] == '12us') print ' selected="selected"';?> value="12us">12 US</option><?php }?>
                            <?php if($multiple_stock['13us']>0){?><option <?php if($var['Size'] == '13us') print ' selected="selected"';?> value="13us">13 US</option><?php }?>
                        </select>
                	<?php } else {echo '-';}?>
					</td>					
					<td>
                    	<input name="quantity-<?=$c['id']?>" type="text" class="textfield rounded input-form-Font" id="meta_title" maxlength="70" value="<?=$c['quantity']?>"/>
                    </td>
					<td style="text-align: center">
						<span class="detail-cart-Font detail-cart"> <?=$sign?> <?php echo number_format($itemprice * $cur_val,2,'.',',');?></span><br/>						
					</td>
				</tr>
				<?php
					}
					else
					{
						$this->Cart_model->delete($c['id']);
					}
				}
			?>
			</form>
		</tbody>
	</table>
    <div class="visible-xs">
    	<form name="updateCart2" method="post" action="<?=base_url()?>cart/updateitems"> 
        
			
			<?php
		    	$ttl = 0;
		    	foreach($cart as $c)
				{
					$itemprice = $c['price'] * $c['quantity'];
					$ttl += $itemprice;
					$pro = $this->Product_model->identify($c['product_id']);
					$hero = $this->Product_model->get_hero($c['product_id']);
					$var = json_decode($c['attributes'],true);
					if($pro['deleted'] == 0)
					{
				?>
				
						<div class="col-sm-12 cart-<?=$c['id']?>" style="float:left; text-align: center" >
						<?  $categories = $this->Product_model->get_categories_single($c['product_id']);
							$category = $this->Category_model->identify($categories['category_id']);
						?>
                        <a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$pro['id_title']?>">
						<?php
							if($hero)
							{
							?>
								<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$pro['id'])?>/<?=$hero['name']?>"/>
							<?
							}
							else
							{
							?>
								<img style="" src="http://placehold.it/89x97"/>
							<?
							}
						?>
						</a>
					
						<div style="height:10px;"></div>
                        <div class="detail-cart-Font detail-cart" style="line-height:30px;"><a href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$pro['id_title']?>"><?=$pro['title']?></a></div>
                        <div class="detail-cart-Font detail-cart" style="line-height:30px;"><span><?=$pro['short_desc']?></span></div>
                        <?php
                        if($pro['multiplesize'] == 1)
						{
                        ?>
                        <div class="detail-cart-Font detail-cart" style="line-height:30px;">
                        
                        <?php $multiple_stock = json_decode($pro['size'],true);?>
						<input type="hidden" name="tempsize-<?=$c['id']?>" id="tempsize-<?=$c['id']?>" value="<?=$var['Size']?>" />
                <select name="sizeproduct-<?=$c['id']?>" id="sizeproduct-<?=$c['id']?>" >
                	<option value="--">Please Select</option>
					<?php if($multiple_stock['34eu']>0){?><option <?php if($var['Size'] == '34eu') print ' selected="selected"';?> value="34eu">34 EU</option><?php }?>
                    <?php if($multiple_stock['35eu']>0){?><option <?php if($var['Size'] == '35eu') print ' selected="selected"';?> value="35eu">35 EU</option><?php }?>
                    <?php if($multiple_stock['36eu']>0){?><option <?php if($var['Size'] == '36eu') print ' selected="selected"';?> value="36eu">36 EU</option><?php }?>
                    <?php if($multiple_stock['37eu']>0){?><option <?php if($var['Size'] == '37eu') print ' selected="selected"';?> value="37eu">37 EU</option><?php }?>
                    <?php if($multiple_stock['38eu']>0){?><option <?php if($var['Size'] == '38eu') print ' selected="selected"';?> value="38eu">38 EU</option><?php }?>
                    <?php if($multiple_stock['39eu']>0){?><option <?php if($var['Size'] == '39eu') print ' selected="selected"';?> value="39eu">39 EU</option><?php }?>
                    <?php if($multiple_stock['40eu']>0){?><option <?php if($var['Size'] == '40eu') print ' selected="selected"';?> value="40eu">40 EU</option><?php }?>
                    <?php if($multiple_stock['41eu']>0){?><option <?php if($var['Size'] == '41eu') print ' selected="selected"';?> value="41eu">41 EU</option><?php }?>
                    <?php if($multiple_stock['42eu']>0){?><option <?php if($var['Size'] == '42eu') print ' selected="selected"';?> value="42eu">42 EU</option><?php }?>
                    <?php if($multiple_stock['43eu']>0){?><option <?php if($var['Size'] == '43eu') print ' selected="selected"';?> value="43eu">43 EU</option><?php }?>
                    <?php if($multiple_stock['44eu']>0){?><option <?php if($var['Size'] == '44eu') print ' selected="selected"';?> value="44eu">44 EU</option><?php }?>
                    <?php if($multiple_stock['45eu']>0){?><option <?php if($var['Size'] == '45eu') print ' selected="selected"';?> value="45eu">45 EU</option><?php }?>
					<?php if($multiple_stock['46eu']>0){?><option <?php if($var['Size'] == '46eu') print ' selected="selected"';?> value="46eu">46 EU</option><?php }?>
                    <?php if($multiple_stock['47eu']>0){?><option <?php if($var['Size'] == '47eu') print ' selected="selected"';?> value="47eu">47 EU</option><?php }?>
				    <?php if($multiple_stock['48eu']>0){?><option <?php if($var['Size'] == '48eu') print ' selected="selected"';?> value="48eu">48 EU</option><?php }?>
                    <?php if($multiple_stock['5us']>0){?><option <?php if($var['Size'] == '5us') print ' selected="selected"';?> value="5us">5 US</option><?php }?>
                    <?php if($multiple_stock['6us']>0){?><option <?php if($var['Size'] == '6us') print ' selected="selected"';?> value="6us">6 US</option><?php }?>
                    <?php if($multiple_stock['65us']>0){?><option <?php if($var['Size'] == '65us') print ' selected="selected"';?> value="65us">6.5 US</option><?php }?>
                    <?php if($multiple_stock['7us']>0){?><option <?php if($var['Size'] == '7us') print ' selected="selected"';?> value="7us">7 US</option><?php }?>
                    <?php if($multiple_stock['75us']>0){?><option <?php if($var['Size'] == '75us') print ' selected="selected"';?> value="75us">7.5 US</option><?php }?>
                    <?php if($multiple_stock['8us']>0){?><option <?php if($var['Size'] == '8us') print ' selected="selected"';?> value="8us">8 US</option><?php }?>
                    <?php if($multiple_stock['85us']>0){?><option <?php if($var['Size'] == '85us') print ' selected="selected"';?> value="85us">8.5 US</option><?php }?>
                    <?php if($multiple_stock['9us']>0){?><option <?php if($var['Size'] == '9us') print ' selected="selected"';?> value="9us">9 US</option><?php }?>
                    <?php if($multiple_stock['95us']>0){?><option <?php if($var['Size'] == '95us') print ' selected="selected"';?> value="95us">9.5 US</option><?php }?>
                    <?php if($multiple_stock['10us']>0){?><option <?php if($var['Size'] == '10us') print ' selected="selected"';?> value="10us">10 US</option><?php }?>
                    <?php if($multiple_stock['105us']>0){?><option <?php if($var['Size'] == '105us') print ' selected="selected"';?> value="105us">10.5 US</option><?php }?>
                    <?php if($multiple_stock['11us']>0){?><option <?php if($var['Size'] == '11us') print ' selected="selected"';?> value="11us">11 US</option><?php }?>
                    <?php if($multiple_stock['12us']>0){?><option <?php if($var['Size'] == '12us') print ' selected="selected"';?> value="12us">12 US</option><?php }?>
                    <?php if($multiple_stock['13us']>0){?><option <?php if($var['Size'] == '13us') print ' selected="selected"';?> value="13us">13 US</option><?php }?>
                </select>
                        
                        </div>
                        <?php } ?>
                        <div class="detail-cart-Font detail-cart" style="line-height:30px;">
                        <input name="quantity-<?=$c['id']?>" style="width: 80%; margin-bottom: 0px; text-align: center" type="text" class="textfield rounded" id="meta_title" maxlength="70" value="<?=$c['quantity']?>"/>
                        </div>
                        <div class="detail-cart-Font detail-cart" style="line-height:30px;"><?=$sign?> <?php echo number_format($itemprice * $cur_val,2,'.',',');?></div>
                        <div class="detail-cart-Font detail-cart-link" style="line-height:30px;"><span onclick="move_to_wishlist(<?=$c['product_id']?>,<?=$c['id']?>)" style="cursor: pointer">Move to Wish List</span> </div>
                        <div class="detail-cart-Font detail-cart-link" style="line-height:30px;"><span onclick="delete_cart(<?=$c['id']?>);" style="cursor: pointer">Remove from Shopping Bag</span></div>
                         </div>                                            
				<?php
					}
					else
					{
						$this->Cart_model->delete($c['id']);
					}
				}
			?>
			
		
            
            
        
        </form>     
    </div>
    
    </div>
    </div><!--col-sm-12-->
    
    <div style="height: 20px;"></div>
    <div class="app-container">
    <div class="col-sm-12">
    	<div class="col-sm-8">
    		<div id="cart-note-shopping" class="note-Font note">
		    	
                <table>
                
                <tr><td valign="top">                            
    			<input type="checkbox" id="curr_agree"/>	    		   </td>
                <td>&nbsp;</td>
                <td>
               	<span class="note-Font note"> 
	    		By ticking this checkbox and proceeding to purchase you agree and have understood our <a class="a-primary" target="_blank" href="<?=base_url()?>page/Returns-and-Exchanges-Policy">Terms + Conditions</a>
                </span>
                </td>
                </tr>
                </table>
	    	
		    </div>
    	</div>
    	<div class="col-sm-1">
    	</div>
    	<div class="col-sm-3 hidden-xs">
    		<div style="text-align:left; float: right;font-size: 16px; padding-bottom: 10px;  margin-top: 10px; width: 238px;" id="cart-puchase-shopping" class="info-cart-Font">
		    	<?php
					$ttl1 = 0;
			    	foreach($cart as $c)
					{
						$itemprice = $c['price'] * $c['quantity'];
						$ttl1 += $itemprice;
					}
				?>
                
                <div class="info-cart-Font" style="width:100%; float:none;">
                	<div style="float:left;width:50%;">ITEM TOTAL</div>
                    <div style="float:left;width:15%; text-align:center;"><?=$sign?></div>
                    <div style="float:right;"> <?php echo number_format($ttl1 * $cur_val,2,'.',',');?></div>
                </div>
                <div style="clear:both;"></div>
                <br />
                <br />
				
		    	
                <div style="width:100%; height:23px;float:none;" id="cart-box-subtotal" class="info-cart-Font">
                	<div style="float:left;width:50%;">SUBTOTAL</div>
                    <div style="float:left;width:15%; text-align:center;"><?=$sign?></div>
                    <div style="float:right;"> <?php echo number_format($ttl1 * $cur_val,2,'.',',');?></div>
                </div>
                <div style="clear:both;"></div>
                <br />
            	 <button onclick="checkout();" style="width: 235px;" class="button-Font button_primary">
					Proceed to Purchase
				</button>
				<div style="height: 10px;"></div>
				<button onclick="document.updateCart.submit();"style="width: 235px;" class="button-Font hidden-xs button_secondary">
					Update Cart
				</button>                   
                                
		    </div>
            
    	</div>
        
        <div class="col-sm-3 visible-xs">
    		<div class="info-cart-Font" id="cart-puchase-shopping">
		    	<?php
					$ttl1 = 0;
			    	foreach($cart as $c)
					{
						$itemprice = $c['price'] * $c['quantity'];
						$ttl1 += $itemprice;
					}
				?>
                
                <div class="info-cart-Font"><span>ITEM TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$sign?></span><span style="text-align:right;"> <?php echo number_format($ttl1 * $cur_val,2,'.',',');?></span></div>
                <br />
                <br />
				
		    	<div id="cart-box-subtotal" class="info-cart-Font" >SUBTOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$sign?> <?php echo number_format($ttl1 * $cur_val,2,'.',',');?></div>
                <br />
            	 <button onclick="checkout();" class="button-Font button_primary button_size_full">
					Proceed to Purchase
				</button>
				<div style="height: 10px;"></div>
				                
                <button onclick="document.updateCart2.submit();" class="button-Font visible-xs button_secondary button_size_full">
					Update Cart
				</button>                   
		    </div>
            
    	</div>
    </div>
    </div>
    
    <div style="clear: both">
    </div>
    <div style="height: 30px;"></div>
    
    <div style="height: 30px; clear: both"></div>
    
    
    <div style="height: 40px;"></div>
    

    
    
    

	 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          	  <div class="modal-header x-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
                <div class="modal-body mybody-modal">
                    <p>Are you sure to delete this item?</p>
                      <div>
                          <button onclick="deletecart(choose);" class="button-Font button_primary button_size_full">
                              Delete
                          </button>
                      </div>            
                </div>
     
        </div>
      </div>
    </div>

      
        
   