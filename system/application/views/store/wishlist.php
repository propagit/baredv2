<script>
var choose=0;

function addtocart(id,wid) {
	var quantity=1;
	if(quantity == '')
	{
	alert('Please enter a valid number for quantity');
	return false;
	}
	else
	{
	if(isNaN(quantity))
	{
	alert('Please enter a valid number for quantity');
	return false;
	}
	else
	{
	if(quantity <=0 )
	{
	alert('Please enter a valid number for quantity');
	return false;
	}
	}
	}
	// var attributes = '';
	// //var myArray = new Array();
	// var myObject = new Object();
	//var num = 0;
	
	if($j('#sizeproduct-'+wid).val() == '--')
	{
		$j('#any_message').html("Please Choose Your Size");
		$j('#anyModal').modal('show');
		return false;
	}
	var attributes = '';
	
	var myObject = new Object();
	var num = 0;
	
	<?php for($i=0;$i<count($attributes);$i++) 
	{ ?>
	 // use json javascript generator and pass value in json format(by Hieu)
	 //myArray[<?=$i?>] = $j('#attribute-<?=$i?>').val();
	 myObject.<?=$attributes[$i]['name']?> = $j('#attribute-<?=$i?>').val();
	<?php } ?>
	if($j('#sizeproduct-'+wid).length)
	{
	  mul_size = $j('#sizeproduct-'+wid).val();
	
		myObject.Size = mul_size;
	}
	//var myObject = toObject(myArray);
	attributes = JSON.stringify(myObject);
	
	$.ajax({
	url: '<?=base_url()?>cart/addtocart',
	type: 'POST',
	data: ({quantity:quantity,product_id:id,attributes:attributes}),
	dataType: "html",
	success: function(html) {
	
		jQuery('#any_message').html(html);
		jQuery('#anyModal').modal('show');
		
		$.ajax({
			url: '<?=base_url()?>cart/count_cart',
			type: 'POST',
			data: ({}),
			dataType: "html",
			success: function(html) {
			
					jQuery('.tot_shopbag').text(html);
					jQuery('#anyModal').modal('show');
					delete_wishlist(wid);
			}
			});
	
	}
	})
} 

function delete_wishlist(id)
{
	window.location="<?=base_url()?>cart/delete_wishlist/"+id;
	//alert(id);
}

</script>

<style>
.wishlist-wrapper
{
	background: none;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    text-align: center;
}

.wishlist-wrapper .image-wrapper
{
	margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 2%;
	border: 1px solid #ccc;
}
</style>

<div class="app-container">
	
	
    
    <div style="height: 20px;"></div>
    <h4>Welcome to Your Wishlist</h4>
    <?php
    	$cc = 1;
    	foreach($lists as $ls)
		{
			$prod = $this->Product_model->identify($ls['product_id']);
			$hero = $this->Product_model->get_hero($ls['product_id']);
			$cat = $this->Category_model->identify($prod['main_category']);
			$var = json_decode($ls['attributes'],true);
			
			if($prod['status']==1 && $prod['deleted']==0)
			{
			
			//$title = explode('-',$prod['title']);
			if($cc == 5){$cc=1;}
			if($cc == 1)
			{
			?>
			<div class="">
		    	<div class="col-sm-3 wishlist-wrapper" >
		    		<div class="delete-wishlist" style="text-align: right; margin-top: 1%; margin-right: 1%">
		    			<span onclick="delete_wishlist(<?=$ls['id']?>)" style="cursor: pointer"><i class="icon icon-remove"></i></span>
		    		</div>
		    		<div style="clear: both">
		    		</div>
		    		<div class="image-wrapper">
		    			<?php
			    		if($prod['sale_price'] < $prod['price'])
						{
						?>
						<img style="position: absolute; z-index: 999;" src="<?=base_url()?>img/ssale-sign.png" />
						<?php
						}
			    		?>
			    		<?php
			    		if($prod['limited'] == 'Y')
						{
						?>
						<img class="limited-w" style="position: absolute; z-index: 999;" src="<?=base_url()?>img/limited.png" />
						<?php
						}
			    		?>
		    			<? if($hero){?>
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                    		<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/<?=$hero['name']?>"/>
                    	</a>
                        <? } else { ?>
                        <a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                        	<img src="http://placehold.it/710x775" alt="">
                        </a>
						<? }?>
		    			<!-- <img  src="http://placehold.it/710x775"/> -->
		    		</div>
		    		
		    		<div class="hidden-xs" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a class="feauture-title" href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
			    			<span class="wishlist-title-Font link-title" style="font-size: 16px;"><?=$prod['title']?></span> 
	    					<!-- <span class="wishlist-title-Font" style="font-size: 14px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<div class="visible-tablet" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a class="link-title" href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
	    					<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span> 
	    					<!-- <span class="wishlist-title-Font" style="font-size: 12px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<?php
	    				$cur_user = $this->session->userdata('userloggedin');
						
						//echo $cur_user['level'];
						
						if($cur_user['level'] == 1)
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
						elseif($cur_user['level'] == 2)
						{
							if($prod['sale_price_trade'] < $prod['price_trade'])
							{
								$cur_price = $prod['sale_price_trade'];
							}
							else 
							{
								$cur_price = $prod['price_trade'];
							}
						}
						else
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
	    			 
	    				//echo number_format($cur_price * $cur_val,2,'.',',');
	    			?>
		    		
		    		
		    		
		    		
		    		<div class="hidden-xs wishlist-title-Font feauture-desc" style="margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="hidden-xs wishlist-title-Font feauture-price" style="margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		
		    		<div class="visible-tablet wishlist-title-Font feauture-desc" style="margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="visible-tablet wishlist-title-Font feauture-price" style="margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<?php
						 if($prod['multiplesize'] == 1)
						 {
						$multiple_stock = json_decode($prod['size'],true);?>
						<input type="hidden" name="tempsize-<?=$ls['id']?>" id="tempsize-<?=$ls['id']?>" value="<?=$var['Size']?>" />
                <select name="sizeproduct-<?=$ls['id']?>" id="sizeproduct-<?=$ls['id']?>" style="width:80%; margin-top: 7px;">
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
                	<?php } ?>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-top: 7%; color: #fff; background: #000; height: 33px; line-height: 33px; cursor: pointer">
		    			Add to Shopping Bag
		    		</div>
		    		
		    		
		    		
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-top: 7%; color: #fff; background: #000; height: 33px; line-height: 33px; cursor: pointer">
		    			Add to Shopping Bag
		    		</div>
		    	</div>
			<?
			}
			if($cc == 2)
			{
			?>
				<div class="col-sm-3" style="background: #f6f5f5; text-align: center; margin-bottom: 20px;">
		    		<div class="delete-wishlist" style="text-align: right; margin-top: 1%; margin-right: 1%">
		    			<span onclick="delete_wishlist(<?=$ls['id']?>)" style="cursor: pointer"><i class="icon icon-remove"></i></span>
		    		</div>
		    		<div style="clear: both">
		    		</div>
		    		<div style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 2%">
		    			<?php
			    		if($prod['sale_price'] < $prod['price'])
						{
						?>
						<img style="position: absolute; z-index: 1000000;" src="<?=base_url()?>img/ssale-sign.png" />
						<?php
						}
			    		?>
			    		<?php
			    		if($prod['limited'] == 'Y')
						{
						?>
						<img class="limited-w" style="position: absolute; z-index: 999;" src="<?=base_url()?>img/limited.png" />
						<?php
						}
			    		?>
		    			<? if($hero){?>
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                    		<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/<?=$hero['name']?>"/>
                    	</a>
                        <? } else { ?>
                        <a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                        	<img src="http://placehold.it/710x775" alt="">
                        </a>
						<? }?>
		    		</div>
		    		
		    		<div class="hidden-xs" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
			    			<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span> 
	    					<!-- <span style="font-family: buenard; font-size: 14px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<div class="visible-tablet" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
	    					<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span>  
	    					<!-- <span style="font-family: buenard; font-size: 12px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<?php
	    				$cur_user = $this->session->userdata('userloggedin');
						
						//echo $cur_user['level'];
						
						if($cur_user['level'] == 1)
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
						elseif($cur_user['level'] == 2)
						{
							if($prod['sale_price_trade'] < $prod['price_trade'])
							{
								$cur_price = $prod['sale_price_trade'];
							}
							else 
							{
								$cur_price = $prod['price_trade'];
							}
						}
						else
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
	    			 
	    				//echo number_format($cur_price * $cur_val,2,'.',',');
	    			?>
		    		
		    		<div class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-top: 7%; color: #fff; background: #413d3d; height: 33px; line-height: 33px; cursor: pointer">
		    			ADD TO SHOPPING BAG
		    		</div>
		    		
		    		<div class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-top: 7%; color: #fff; background: #413d3d; height: 33px; line-height: 33px; cursor: pointer">
		    			ADD TO SHOPPING BAG
		    		</div>
		    	</div>
			<?
			}
			if($cc == 3)
			{
			?>
				<div class="col-sm-3" style="background: #f6f5f5; text-align: center; margin-bottom: 20px;">
		    		<div class="delete-wishlist" style="text-align: right; margin-top: 1%; margin-right: 1%">
		    			<span onclick="delete_wishlist(<?=$ls['id']?>)" style="cursor: pointer"><i class="icon icon-remove"></i></span>
		    		</div>
		    		<div style="clear: both">
		    		</div>
		    		<div style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 2%">
		    			<?php
			    		if($prod['sale_price'] < $prod['price'])
						{
						?>
						<img style="position: absolute; z-index: 1000000;" src="<?=base_url()?>img/ssale-sign.png" />
						<?php
						}
			    		?>
			    		<?php
			    		if($prod['limited'] == 'Y')
						{
						?>
						<img class="limited-w" style="position: absolute; z-index: 999;" src="<?=base_url()?>img/limited.png" />
						<?php
						}
			    		?>
		    			<? if($hero){?>
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                    		<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/<?=$hero['name']?>"/>
                    	</a>
                        <? } else { ?>
                        <a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                        	<img src="http://placehold.it/710x775" alt="">
                        </a>
						<? }?>
		    		</div>
		    		
		    		<div class="hidden-xs" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
			    			<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span> 
	    					<!-- <span style="font-family: buenard; font-size: 14px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<div class="visible-tablet" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
	    					<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span>  
	    					<!-- <span style="font-family: buenard; font-size: 12px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<?php
	    				$cur_user = $this->session->userdata('userloggedin');
						
						//echo $cur_user['level'];
						
						if($cur_user['level'] == 1)
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
						elseif($cur_user['level'] == 2)
						{
							if($prod['sale_price_trade'] < $prod['price_trade'])
							{
								$cur_price = $prod['sale_price_trade'];
							}
							else 
							{
								$cur_price = $prod['price_trade'];
							}
						}
						else
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
	    			 
	    				//echo number_format($cur_price * $cur_val,2,'.',',');
	    			?>
		    		
		    		<div class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-top: 7%; color: #fff; background: #413d3d; height: 33px; line-height: 33px; cursor: pointer">
		    			ADD TO SHOPPING BAG
		    		</div>
		    		
		    		<div class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="visible-tabletwishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-top: 7%; color: #fff; background: #413d3d; height: 33px; line-height: 33px; cursor: pointer">
		    			ADD TO SHOPPING BAG
		    		</div>
		    	</div>
			<?
			}
			if($cc == 4)
			{
			?>
				<div class="col-sm-3" style="background: #f6f5f5; text-align: center; margin-bottom: 20px;">
		    		<div class="delete-wishlist" style="text-align: right; margin-top: 1%; margin-right: 1%">
		    			<span onclick="delete_wishlist(<?=$ls['id']?>)" style="cursor: pointer"><i class="icon icon-remove"></i></span>
		    		</div>
		    		<div style="clear: both">
		    		</div>
		    		<div style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 2%">
		    			<?php
			    		if($prod['sale_price'] < $prod['price'])
						{
						?>
						<img style="position: absolute; z-index: 1000000;" src="<?=base_url()?>img/ssale-sign.png" />
						<?php
						}
			    		?>
			    		<?php
			    		if($prod['limited'] == 'Y')
						{
						?>
						<img class="limited-w" style="position: absolute; z-index: 999;" src="<?=base_url()?>img/limited.png" />
						<?php
						}
			    		?>
		    			<? if($hero){?>
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                    		<img src="<?=base_url()?>uploads/products/<?=md5('mbb'.$prod['id'])?>/<?=$hero['name']?>"/>
                    	</a>
                        <? } else { ?>
                        <a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
                        	<img src="http://placehold.it/710x775" alt="">
                        </a>
						<? }?>
		    		</div>
		    		
		    		<div class="hidden-xs" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
			    			<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span>  
	    					<!-- <span style="font-family: buenard; font-size: 14px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<div class="visible-tablet" style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 5%">
		    			<a href="<?=base_url()?>store/detail_product/<?=$cat['title']?>/<?=$prod['id_title']?>">
	    					<span class="wishlist-title-Font" style="font-size: 16px;"><?=$prod['title']?></span>  
	    					<!-- <span style="font-family: buenard; font-size: 12px; font-weight: 400"><?=$title[1]?></span><br/> -->
    					</a>
		    		</div>
		    		
		    		<?php
	    				$cur_user = $this->session->userdata('userloggedin');
						
						//echo $cur_user['level'];
						
						if($cur_user['level'] == 1)
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
						elseif($cur_user['level'] == 2)
						{
							if($prod['sale_price_trade'] < $prod['price_trade'])
							{
								$cur_price = $prod['sale_price_trade'];
							}
							else 
							{
								$cur_price = $prod['price_trade'];
							}
						}
						else
						{
							if($prod['sale_price'] < $prod['price'])
							{
								$cur_price = $prod['sale_price'];
							}
							else 
							{
								$cur_price = $prod['price'];
							}
						}
	    			 
	    				//echo number_format($cur_price * $cur_val,2,'.',',');
	    			?>
		    		
		    		<div class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="hidden-xs wishlist-title-Font" style="font-size: 14px; font-weight: 400; margin-top: 7%; color: #fff; background: #413d3d; height: 33px; line-height: 33px; cursor: pointer">
		    			ADD TO SHOPPING BAG
		    		</div>
		    		
		    		<div class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$prod['short_desc']?></div>
		    		<div class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-left: 8%; margin-right: 8%; width: 84%;"><?=$sign?> <?php echo number_format($cur_price * $cur_val,2,'.',',');?></div>
		    		<div onclick="addtocart(<?=$prod['id']?>,<?=$ls['id']?>)" class="visible-tablet wishlist-title-Font" style="font-size: 12px; font-weight: 400; margin-top: 7%; color: #fff; background: #413d3d; height: 33px; line-height: 33px; cursor: pointer">
		    			ADD TO SHOPPING BAG
		    		</div>
		    	</div>
		    </div>
		    <!-- <div style="height: 20px;"></div> -->
			<?
			}
			$cc++;
			}
		}


		if($cc==2)
		{
		?>
			<div class="col-sm-3">
	    		<!-- <div style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 7%">
	    			<img  src="http://placehold.it/710x775"/>
	    		</div> -->
	    		&nbsp;
	    	</div>
		<?
		$cc++;
		}
		if($cc==3)
		{
		?>
			<div class="col-sm-3">
	    		<!-- <div style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 7%">
	    			<img  src="http://placehold.it/710x775"/>
	    		</div> -->
	    		&nbsp;
	    	</div>
		<?
		$cc++;
		}
		if($cc==4)
		{
		?>
				<div class="col-sm-3">
		    		<!-- <div style="margin-left: 8%; margin-right: 8%; width: 84%; margin-top: 7%">
		    			<img  src="http://placehold.it/710x775"/>
		    		</div> -->
		    		&nbsp;
		    	</div>
		    </div>
		<?
		//$cc++;
		}
		
    ?>
    
    
    
    	
    	
    	
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    
    <!-- End Product for Iphone -->
		
        
   