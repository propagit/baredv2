<script>
$(function() {       	
<?php if($product['multiplesize']==1){?>

jQuery('#multi_stock').show(); 
jQuery('#single_stock').hide();
<? } else {?>
jQuery('#multi_stock').hide(); 
jQuery('#single_stock').show();
<? } ?>
});
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>Add Product</h1>
			<button class="btn btn-primary" onclick="window.location = '<?=base_url()?>admin/cms/product';">Back To Product List</button>
			
			<h2>Basic Details</h2>
			<form id="addProduct" method="post" action="<?=base_url()?>admin/cms/editproduct">
			<input type="hidden" name="id" value="<?=$product['id']?>" />
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Title</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="title" name="title" value="<?=$product['title']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Short Description</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="short_desc" name="short_desc" value="<?=$product['short_desc']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Designer Notes</div>
				<div style="width: 80%; float: right">
					<textarea style="width: 97%" type="text" class="textfield rounded" id="long_desc" name="long_desc" value="" rows="3"><?=$product['long_desc']?></textarea>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Features</div>
				<div style="width: 80%; float: right">
					<textarea style="width: 97%" type="text" class="textfield rounded" id="features" name="features" value="" rows="3"><?=$product['features']?></textarea>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Price</div>
				<div style="width: 30%; float: left">
					<input style="width: 97%" type="text" class="textfield rounded" id="price" name="price" value="<?=$product['price']?>"/>
				</div>
				<div style="width: 15%; float: left; height: 30px; line-height: 30px; margin-left: 3.5%">Sale Price</div>
				<div style="width: 30%; float: left">
					<input style="width: 97%" type="text" class="textfield rounded" id="sale_price" name="sale_price" value="<?php if($product['sale_price'] != $product['price']) print $product['sale_price']; ?>"/>
				</div>
			</div>
			
			<div style="height: 5px; clear: both">&nbsp;</div>
			<!--
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Trade Price</div>
				<div style="width: 30%; float: left">
					<input style="width: 97%" type="text" class="textfield rounded" id="price_trade" name="price_trade" value="<?=$product['price_trade']?>"/>
				</div>
				<div style="width: 15%; float: left; height: 30px; line-height: 30px; margin-left: 3.5%">Trade Sale Price</div>
				<div style="width: 30%; float: left">
					<input style="width: 97%" type="text" class="textfield rounded" id="sale_price_trade" name="sale_price_trade" value="<?php if($product['sale_price_trade'] != $product['price_trade']) print $product['sale_price_trade']; ?>"/>
				</div>
			</div>
			
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">EAN</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="ean" name="ean" value="<?=$product['ean']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Product Code</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="style_no" name="style_no" value="<?=$product['style_no']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Size</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="product_dimension" name="product_dimension" value="<?=$product['dimension']?>"/>
				</div>
			</div>
            
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Handle Length</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="length" name="length" value="<?=$product['length']?>"/>
				</div>
			</div>
            -->
			<div style="height: 5px; clear: both">&nbsp;</div>
			<!--
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Collection</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="collection" name="collection" value="<?=$product['collection']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Composition</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="composition" name="composition" value="<?=$product['composition']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
            -->
            <input style="width: 97%;display:none;" type="text" class="textfield rounded" id="composition" name="composition" value="<?=$product['composition']?>"/>
            <input style="width: 97%;display:none;" type="text" class="textfield rounded" id="length" name="length" value="<?=$product['length']?>"/>
            <input style="width: 97%;display:none;" type="text" class="textfield rounded" id="style_no" name="style_no" value="<?=$product['style_no']?>"/>
            <input style="width: 97%;display:none;" type="text" class="textfield rounded" id="ean" name="ean" value="<?=$product['ean']?>"/>
            <input style="width: 97%;display:none;" type="text" class="textfield rounded" id="product_dimension" name="product_dimension" value="<?=$product['dimension']?>"/>
            <input style="width: 97%;display:none;" type="text" class="textfield rounded" id="collection" name="collection" value="<?=$product['collection']?>"/>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Main Category</div>
				<div style="width: 80%; float: right">
					<select id="main_category" name="main_category">	
                    	<?php foreach($main as $maincat) { ?>
                    		<option <?php if($maincat['id'] == $product['main_category']) {echo "selected='selected'";}?> value="<?=$maincat['id']?>"><?=$maincat['title']?></option>        
                    	<?php }?>
                    </select>
				</div>
			</div>
			
			<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Retail</div>
			<div style="width: 80%; float: right; height: 30px; line-height: 30px;">
				<input <?php if($product['available_retail']=='N' || $product['available_retail']=='n') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="available_retail" value="N"  /> No 
				&nbsp;&nbsp;&nbsp; 
				<input <?php if($product['available_retail']=='Y' || $product['available_retail']=='y') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="available_retail" value="Y" /> Yes
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Review Category</div>
				<div style="width: 30%; float: left">
					<input style="width: 97%" type="text" class="textfield rounded" id="review_category" name="review_category" value="<?=$product['review_category'];?>"/>
				</div>
			</div>
            <!--
			<div style="height: 15px; clear: both">&nbsp;</div>
			<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Available Wholesale</div>
			<div style="width: 80%; float: right; height: 30px; line-height: 30px;">
				<input <?php if($product['available_wsale']=='N' || $product['available_wsale']=='n') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="available_wsale" value="N"  /> No 
				&nbsp;&nbsp;&nbsp; 
				<input <?php if($product['available_wsale']=='Y' || $product['available_wsale']=='y') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="available_wsale" value="Y" /> Yes
			</div>
			<div style="height: 15px; clear: both">&nbsp;</div>
            
			<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Limited</div>
			<div style="width: 80%; float: right; height: 30px; line-height: 30px;">
				<input <?php if($product['limited']=='N' || $product['limited']=='n') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="limited" value="N"  /> No 
				&nbsp;&nbsp;&nbsp; 
				<input <?php if($product['limited']=='Y' || $product['limited']=='y') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="limited" value="Y" /> Yes
			</div>
			<div style="height: 15px; clear: both">&nbsp;</div>
			
			<div style="width: 20%; float: left; height: 30px; line-height: 30px;">First Edition</div>
			<div style="width: 80%; float: right; height: 30px; line-height: 30px;">
				<input <?php if($product['first_edition']=='N' || $product['first_edition']=='n') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="first_edition" value="N"  /> No 
				&nbsp;&nbsp;&nbsp; 
				<input <?php if($product['first_edition']=='Y' || $product['first_edition']=='y') echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="first_edition" value="Y" /> Yes
			</div>
			<div style="height: 15px; clear: both">&nbsp;</div>
            -->
            <div style="clear: both">&nbsp;</div>
            <h2>Basic Stock</h2>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Multiple Size Stock</div>
				<div style="width: 80%; float: right; height: 30px; line-height: 30px;">
					<input <?php if($product['multiplesize']==0) echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="typeproduct" value="no" checked="checked" onclick="$('#multi_stock').hide(); $('#single_stock').show(); "/> No 
					&nbsp;&nbsp;&nbsp; 
					<input <?php if($product['multiplesize']==1) echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="typeproduct" value="yes" onclick="$('#multi_stock').show(); $('#single_stock').hide(); "/> Yes
				</div>
			</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Stock</div>
				<div id="single_stock" style="width: 80%; float: right;">
					<input style="width: 97%" type="text" class="textfield rounded" id="product_stock" name="product_stock" value="<?=$product['stock']?>"/>
				</div>
				<?php $multiple_stock = json_decode($product['size'],true);?>
                <?php $multiple_stock_id = json_decode($product['size_stock_id'],true);?>
				<div id="multi_stock" style="width: 80%; float: right; display: none">
					
                    <!-- 34 EU -->
                    <? $stock34 = str_replace('#','',$multiple_stock_id['34eu']);?>
                    <div style="float: left; width: 15%">
						Size 34 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="34eu" name="34eu" value="<?=$multiple_stock['34eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_34eu" name="s_34eu" value="<?=$stock34?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    
                    <!-- 35 EU -->
                    <? $stock35 = str_replace('#','',$multiple_stock_id['35eu']);?>
                    <div style="float: left; width: 15%">
						Size 35 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="35eu" name="35eu" value="<?=$multiple_stock['35eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_35eu" name="s_35eu" value="<?=$stock35?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    
                    <!-- 36 EU -->
                    <? $stock36 = str_replace('#','',$multiple_stock_id['36eu']);?>
                    <div style="float: left; width: 15%">
						Size 36 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="36eu" name="36eu" value="<?=$multiple_stock['36eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_36eu" name="s_36eu" value="<?=$stock36?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 37 EU -->
                    <? $stock37 = str_replace('#','',$multiple_stock_id['37eu']);?>
                    <div style="float: left; width: 15%">
						Size 37 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="37eu" name="37eu" value="<?=$multiple_stock['37eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_37eu" name="s_37eu" value="<?=$stock37?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 38 EU -->
                    <? $stock38 = str_replace('#','',$multiple_stock_id['38eu']);?>
                    <div style="float: left; width: 15%">
						Size 38 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="38eu" name="38eu" value="<?=$multiple_stock['38eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_38eu" name="s_38eu" value="<?=$stock38?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                                        
                    <!-- 39 EU -->
                    <? $stock39 = str_replace('#','',$multiple_stock_id['39eu']);?>
                    <div style="float: left; width: 15%">
						Size 39 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="39eu" name="39eu" value="<?=$multiple_stock['39eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_39eu" name="s_39eu" value="<?=$stock39?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 40 EU -->
                    <? $stock40 = str_replace('#','',$multiple_stock_id['40eu']);?>
                    <div style="float: left; width: 15%">
						Size 40 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="40eu" name="40eu" value="<?=$multiple_stock['40eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_40eu" name="s_40eu" value="<?=$stock40?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 41 EU -->
                    <? $stock41 = str_replace('#','',$multiple_stock_id['41eu']);?>
                    <div style="float: left; width: 15%">
						Size 41 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="41eu" name="41eu" value="<?=$multiple_stock['41eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_41eu" name="s_41eu" value="<?=$stock41?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    
                    <!-- 42 EU -->
                    <? $stock42 = str_replace('#','',$multiple_stock_id['42eu']);?>
                    <div style="float: left; width: 15%">
						Size 42 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="42eu" name="42eu" value="<?=$multiple_stock['42eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_42eu" name="s_42eu" value="<?=$stock42?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 43 EU -->
                    <? $stock43 = str_replace('#','',$multiple_stock_id['43eu']);?>
                    <div style="float: left; width: 15%">
						Size 43 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="43eu" name="43eu" value="<?=$multiple_stock['43eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_43eu" name="s_43eu" value="<?=$stock43?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 44 EU -->
                    <? $stock44 = str_replace('#','',$multiple_stock_id['44eu']);?>
                    <div style="float: left; width: 15%">
						Size 44 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="44eu" name="44eu" value="<?=$multiple_stock['44eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_44eu" name="s_44eu" value="<?=$stock44?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 45 EU -->
                    <? $stock45 = str_replace('#','',$multiple_stock_id['45eu']);?>
                    <div style="float: left; width: 15%">
						Size 45 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="45eu" name="45eu" value="<?=$multiple_stock['45eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_45eu" name="s_45eu" value="<?=$stock45?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 46 EU -->
                    <? $stock46 = str_replace('#','',$multiple_stock_id['46eu']);?>
                    <div style="float: left; width: 15%">
						Size 46 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="46eu" name="46eu" value="<?=$multiple_stock['46eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_46eu" name="s_46eu" value="<?=$stock46?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 47 EU -->
                    <? $stock47 = str_replace('#','',$multiple_stock_id['47eu']);?>
                    <div style="float: left; width: 15%">
						Size 47 EU
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="47eu" name="47eu" value="<?=$multiple_stock['47eu']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_47eu" name="s_47eu" value="<?=$stock47?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 5 US -->
                    <? $stock5 = str_replace('#','',$multiple_stock_id['5us']);?>
                    <div style="float: left; width: 15%">
						Size 5 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="5us" name="5us" value="<?=$multiple_stock['5us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_5us" name="s_5us" value="<?=$stock5?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 6 US -->
                    <? $stock6 = str_replace('#','',$multiple_stock_id['6us']);?>
                    <div style="float: left; width: 15%">
						Size 6 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="6us" name="6us" value="<?=$multiple_stock['6us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_6us" name="s_6us" value="<?=$stock6?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 65 US -->
                    <? $stock65 = str_replace('#','',$multiple_stock_id['65us']);?>
                    <div style="float: left; width: 15%">
						Size 6.5 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="65us" name="65us" value="<?=$multiple_stock['65us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_65us" name="s_65us" value="<?=$stock65?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 7 US -->
                    <? $stock7 = str_replace('#','',$multiple_stock_id['7us']);?>
                    <div style="float: left; width: 15%">
						Size 7 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="7us" name="7us" value="<?=$multiple_stock['7us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_7us" name="s_7us" value="<?=$stock7?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 75 US -->
                    <? $stock75 = str_replace('#','',$multiple_stock_id['75us']);?>
                    <div style="float: left; width: 15%">
						Size 7.5 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="75us" name="75us" value="<?=$multiple_stock['75us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_75us" name="s_75us" value="<?=$stock75?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 8 US -->
                    <? $stock8 = str_replace('#','',$multiple_stock_id['8us']);?>
                    <div style="float: left; width: 15%">
						Size 8 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="8us" name="8us" value="<?=$multiple_stock['8us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_8us" name="s_8us" value="<?=$stock8?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 85 US -->
                    <? $stock85 = str_replace('#','',$multiple_stock_id['85us']);?>
                    <div style="float: left; width: 15%">
						Size 8.5 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="85us" name="85us" value="<?=$multiple_stock['85us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_85us" name="s_85us" value="<?=$stock85?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 9 US -->
                    <? $stock9 = str_replace('#','',$multiple_stock_id['9us']);?>
                    <div style="float: left; width: 15%">
						Size 9 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="9us" name="9us" value="<?=$multiple_stock['9us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_9us" name="s_9us" value="<?=$stock9?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 95 US -->
                    <? $stock95 = str_replace('#','',$multiple_stock_id['95us']);?>
                    <div style="float: left; width: 15%">
						Size 9.5 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="95us" name="95us" value="<?=$multiple_stock['95us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_95us" name="s_95us" value="<?=$stock95?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 10 US -->
                    <? $stock10 = str_replace('#','',$multiple_stock_id['10us']);?>
                    <div style="float: left; width: 15%">
						Size 10 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="10us" name="10us" value="<?=$multiple_stock['10us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_10us" name="s_10us" value="<?=$stock10?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 105 US -->
                    <? $stock105 = str_replace('#','',$multiple_stock_id['105us']);?>
                    <div style="float: left; width: 15%">
						Size 10.5 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="105us" name="105us" value="<?=$multiple_stock['105us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_105us" name="s_105us" value="<?=$stock105?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 11 US -->
                    <? $stock11 = str_replace('#','',$multiple_stock_id['11us']);?>
                    <div style="float: left; width: 15%">
						Size 11 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="11us" name="11us" value="<?=$multiple_stock['11us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_11us" name="s_11us" value="<?=$stock11?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 12 US -->
                    <? $stock12 = str_replace('#','',$multiple_stock_id['12us']);?>
                    <div style="float: left; width: 15%">
						Size 12 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="12us" name="12us" value="<?=$multiple_stock['12us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_12us" name="s_12us" value="<?=$stock12?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
                    <!-- 13 US -->
                    <? $stock13 = str_replace('#','',$multiple_stock_id['13us']);?>
                    <div style="float: left; width: 15%">
						Size 13 US
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="13us" name="13us" value="<?=$multiple_stock['13us']?>"/>
					</div>
					<div style="float: left; width: 7%">
						&nbsp;
					</div>
					<div style="float: left; width: 15%">
						Stock ID
					</div>
					<div style="float: left; width: 30%">
						<input style="width: 100%" type="text" class="textfield rounded" id="s_13us" name="s_13us" value="<?=$stock13?>"/>
					</div>
                    <div style="height: 5px; clear: both">&nbsp;</div>
                    
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div  id="single_stock" style="width: 20%; float: left; height: 30px; line-height: 30px;">Stock ID</div>
			<div id="single_stock" style="width: 80%; float: right;" >
				<input style="width: 97%" type="text" class="textfield rounded" id="product_stock_id" name="product_stock_id" value="<?=$product['stock_id']?>"/>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<!-- <h2>Set Categories</h2>
			<div class="well">
				<ul class="tree">
					<li style="line-height: 30px;">
						<a href="javascript:nothing()" role="branch" class="tree-toggle" data-toggle="branch" data-value="All_Category">
							All Category
						</a>
                          <ul class="branch in">
                          	  <?php foreach($main as $maincat) {
                          	  	 $sub2 = $this->Category_model->get($maincat['id']);
                          	  	?>
                          	  	 <li style="line-height: 30px;">
                          	  	 	<?php if(count($sub2) > 0)
                          	  	 	{
                          	  	 	?>
                          	  	 		<a href="javascript:nothing()" role="branch" class="tree-toggle closed" data-toggle="branch" data-value="<?=$maincat['title']?>">
                          	  	 			<input style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="<?=$maincat['id']?>"/>
                          	  	 			<?=$maincat['title']?>
                          	  	 		</a>
                          	  	 	<?
                          	  	 	}
									else
									{
									?>
										<a href="javascript:nothing()" role="leaf">
											<input style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="<?=$maincat['id']?>"/>
											<?=$maincat['title']?>
										</a>
									<?
									}
                          	  	 	?>
                          	  	 	
                          	  	 	<ul class="branch">
                          	  	 		<?php $sub = $this->Category_model->get($maincat['id']);
										foreach($sub as $subcat) { ?>
											<li style="line-height: 30px;">
												<a href="javascript:nothing()" role="leaf">
													<input style="margin-top: -3px; margin-right: 5px;" type="checkbox" name="categories[]" value="<?=$subcat['id']?>"/>
													<?=$subcat['title']?>
												</a>
											</li>
										<?php } ?>
                          	  	 	</ul>
                          	  	 </li>
                          	  <? } ?>
                          	
                              
                          </ul>
					</li>
				</ul>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div> -->
			<h2>Basic Shipping</h2>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Product Weight</div>
				<div style="width: 80%; float: right">
					<div style="float: left" class="input-append">
						<input class="span2" id="appendedInput" name="weight" type="text" value="<?=$product['weight']?>">
						<span class="add-on">Kg</span>
					</div>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Show Product Weight</div>
				<div style="width: 80%; float: right">
					
						<input <?php if($product['show_weight']==0) echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="show_weight" value="no" checked="checked" /> No 
						&nbsp;&nbsp;&nbsp; 
						<input <?php if($product['show_weight']==1) echo " checked=\"checked\""; ?> style="margin: 0" type="radio" name="show_weight" value="yes" /> Yes
					
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Volume</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="volume" name="volume" value="<?=$product['volume']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
            <!--
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Shipping Dimensions W</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="dimension_w" name="dimension_w" value="<?=$product['dimension_w']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Shipping Dimensions H</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="dimension_h" name="dimension_h" value="<?=$product['dimension_h']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Shipping Dimensions D</div>
				<div style="width: 80%; float: right">
					<input style="width: 97%" type="text" class="textfield rounded" id="dimension_d" name="dimension_d" value="<?=$product['dimension_d']?>"/>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
            -->
			<!-- <h2>Product Attributes</h2>
			<div>
				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Select Attributes</div>
				<div style="width: 80%; float: right">
					<select class="selectpicker" id="attribute">
                    	<?php foreach($attributes as $attr) { ?>
                        <option value="<?=$attr['id']?>"><?=$attr['name']?></option>
                        <?php } ?>
                    </select>
                    <script>jQuery(".selectpicker").selectpicker();</script>
					<button onclick="add_att();" style="margin-bottom: 10px" class="btn" type="button">Insert</button>
				</div>
			</div>
			<div style="height: 5px; clear: both">&nbsp;</div>
			<div id="all_att">  
				<?php
					foreach($product_attributes as $attribute)
					{
					?>
					<div id="att-<?=$attribute['id']?>" style="margin-bottom:1px" class="alert alert-info">
						<input type="hidden" name="prodattributes[]" value="<?=$attribute['name']?>">
						<button onclick="remove_att(<?=$attribute['id']?>)" type="button" class="close">&times;</button>
						<?=$attribute['name']?>
					</div>
					<?
					}
				?>
			</div> -->
			<div style="height: 5px; clear: both">&nbsp;</div>
			<button class="btn btn-primary" type="submit">Update</button>
			</form>
			<!-- end here -->
		</div>
	</div>
</div>

<script>
function nothing()
{
	
}
function remove_att(id)
{
	$('#att-'+id).remove();
}
function add_att()
{
	var id = $('#attribute').val();
	var out = '';
	$.ajax({
			url: '<?=base_url()?>admin/cms/get_product_att/',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				//alert(html);
				out += '<div id="att-'+id+'" style="margin-bottom:1px" class="alert alert-info">';
				out += '<input type="hidden" name="attributes[]" value="'+id+'">';
				out += '<button onclick="remove_att('+id+')" type="button" class="close">&times;</button>';
				out += html;
				out += '</div>';
				$('#all_att').append(out);
			}
	});
}
</script>