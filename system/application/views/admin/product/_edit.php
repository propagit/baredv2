<script>
function expand(id) {
	$j('#maincat-' + id).show();
	$j('#act-' + id).html('<a href="javascript:collapse(' + id +')"><img src="<?=base_url()?>img/backend/minus.gif" /></a>');
}
function collapse(id) {
	$j('#maincat-' + id).hide();
	$j('#act-' + id).html('<a href="javascript:expand(' + id +')"><img src="<?=base_url()?>img/backend/plus.gif" /></a>');
}
function insertoption() {
	var id = $j('#attribute').val();
	if ($j('#attribute-' + id).val() == id) {
		alert('You have already inserted this atttribute');
	} else {
		$j.ajax({
			url: '<?=base_url()?>admin/system/getattributes/',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				$j('#optcontent').append(html);
			}
		})
	}
}
function addoption(id,n) {
	var opt = $j('#optval-' + id).val();
	if ($j.trim(opt) != '') {
		$j('#optval-' + id).val('');
		$j('#options-' + id).append('<dl class="five" id="opt-' + id + '-' + n + '"><dt>' + opt + '</dt><dd><a href="javascript:removeoption(' + id + ',' + n + ')"><img src="<?=base_url()?>img/backend/icon-delete-small.png" /></a></dd><input type="hidden" value="' + opt + '" name="options-' + id + '[]" /></dl>');
		$j('#optbutton-' + id).html('<input type="button" class="button rounded" value="&raquo;" onclick="addoption(' + id + ',' + (n+1) + ')" />');
	} else {
		alert('Please enter a valid option');
	}
}
function removeoption(id,n) {
	$j('#opt-' + id + '-' + n).remove();	
}
function removeattr(id) {
	$j('#attr-' + id).remove();
}
function switchall() {
	var cond = $j('#allcat:checked').val();
	if (cond) {  
		$j('[id^=category-]').attr('checked',true);
	} else { 
		$j('[id^=category-]').attr('checked',false);
	}
}


function addprodoption(id,n) {
	var opt = $j('#prodoptval-' + id).val();
	if ($j.trim(opt) != '') {
		$j('#prodoptval-' + id).val('');
		$j('#prodoptions-' + id).append('<dl class="five" id="prodopt-' + id + '-' + n + '"><dt>' + opt + '</dt><dd><a href="javascript:removeprodoption(' + id + ',' + n + ')"><img src="<?=base_url()?>img/backend/icon-delete-small.png" /></a></dd><input type="hidden" value="' + opt + '" name="prodoptions-' + id + '[]" /></dl>');
		$j('#prodoptbutton-' + id).html('<input type="button" class="button rounded" value="&raquo;" onclick="addprodoption(' + id + ',' + (n+1) + ')" />');
	} else {
		alert('Please enter a valid option');
	}
}
function removeprodoption(id,n) {
	$j('#prodopt-' + id + '-' + n).remove();	
}
function removeprodattr(id) {
	if (confirm('This action will delete this attribute. Are you sure you want to do it?')) {
		$j('#prodattr-' + id).remove();
	}
}
$j(document).ready(function(){
	<?php if($product['multiplesize']==0){ ?>
		activestock(0);
	<?php }else{ ?>
		activestock(1);	
	<?php } ?>
});
function activestock(n){
	if(n==0){
		$j('#typestock').css({'display':'none'});
		$j('#typestock_normal').css({'display':'block'});
		
	}else{
		$j('#typestock').css({'display':'block'});
		$j('#typestock_normal').css({'display':'none'});
		
	}
}
</script>
    	<div class="left">
        	<h1>Store Management</h1>
            <div class="bar">

            	<div class="text">Manage Products &raquo; Edit Product</div>
            	<div class="cr"></div>
            </div>
            <div class="box">
            	<p>
                	<input type="button" class="button rounded" value="Back to Products List" onclick="history.go(-1)" />
                </p>
            </div>            
            <hr />
            <form id="addProduct" method="post" action="<?=base_url()?>admin/store/editproduct">
            <input type="hidden" name="id" value="<?=$product['id']?>" />
            <div class="box bgw">
            	<h3>Basic Details</h3>
                <dl class="two"><dt>Title</dt><dd><input type="text" class="textfield rounded" name="title" value="<?=$product['title']?>" /></dd></dl>
                <dl class="two"><dt>Short description</dt><dd><input type="text" class="textfield rounded" name="short_desc" value="<?=$product['short_desc']?>" /></dd></dl>
                <dl class="two"><dt>Long description</dt><dd><textarea name="long_desc"><?=$product['long_desc']?></textarea></dd></dl>
                <dl class="three"><dt>Price</dt><dd><input type="text" class="textfield rounded" name="price" value="<?=$product['price']?>" /></dd>
                		<dd>Sale price</dd><dd><input type="text" class="textfield rounded" name="sale_price" value="<?php if($product['sale_price'] != $product['price']) print $product['sale_price']; ?>" /></dd></dl>
               	<dl class="three"><dt>Trade Price</dt><dd><input type="text" class="textfield rounded" name="price_trade" value="<?=$product['price_trade']?>" /></dd>
                		<dd>Sale price</dd><dd><input type="text" class="textfield rounded" name="sale_price_trade" value="<?php if($product['sale_price_trade'] != $product['price_trade']) print $product['sale_price_trade']; ?>" /></dd></dl>
                		
                <dl class="two"><dt>Style number</dt><dd><input type="text" class="textfield rounded" name="style_no" value="<?=$product['style_no']?>" /></dd></dl>
				<dl class="two"><dt>Dimension</dt><dd><input type="text" class="textfield rounded" name="product_dimension" value="<?=$product['dimension']?>" /></dd></dl>
				<dl class="two"><dt>Pack Size</dt><dd><input type="text" class="textfield rounded" name="product_pack_size" value="<?=$product['pack_size']?>" /></dd></dl>
				<dl class="two"><dt>Multiple Size Stock</dt><dd>NO <input <?php if($product['multiplesize']==0) echo " checked=\"checked\""; ?> onclick="activestock(0)" type="radio" name="typeproduct" value="no" /> YES <input type="radio" onclick="activestock(1)" <?php if($product['multiplesize']==1) echo " checked=\"checked\""; ?> name="typeproduct" value="yes" /></dd></dl>		
					<?php $multiple_stock = json_decode($product['size'],true);?>
				<div id="typestock" <?php if($product['multiplesize']==0) { echo 'style="display:none"';}?>>
				<dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth">Size XXXS</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="XXXS" value="<?=$multiple_stock['XXXS']?>" /></div><div class="sizewidth margin-left" >Size XXS</div> <div class="sizewidth" ><input type="number" class="textfield rounded" name="XXS" value="<?=$multiple_stock['XXS']?>" /></div></dd></dl>				
				<dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size XS</div> <div class="sizewidth" ><input type="number" class="textfield rounded" name="XS" value="<?=$multiple_stock['XS']?>" /></div><div class="sizewidth margin-left" >Size S</div> <div class="sizewidth" ><input type="number" class="textfield rounded" name="S" value="<?=$multiple_stock['S']?>" /></div></dd></dl>				
				<dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size M</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="M" value="<?=$multiple_stock['M']?>" /></div><div class="sizewidth margin-left" >Size L</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="L" value="<?=$multiple_stock['L']?>" /></div></dd></dl>				
				<dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size XL</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="XL" value="<?=$multiple_stock['XL']?>" /></div><div class="sizewidth margin-left" >Size XXL</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="XXL" value="<?=$multiple_stock['XXL']?>" /></div></dd></dl>				
				<dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 3XL</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="3XL" value="<?=$multiple_stock['3XL']?>" /></div><div class="sizewidth margin-left" >Size 4XL</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="4XL" value="<?=$multiple_stock['4XL']?>" /></div></dd></dl>
                <dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 5XL</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="5XL" value="<?=$multiple_stock['5XL']?>" /></div><div class="sizewidth margin-left" >Size 6XL</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="6XL" value="<?=$multiple_stock['6XL']?>" /></div></dd></dl>
                <dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 6</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="6" value="<?=$multiple_stock['6']?>" /></div><div class="sizewidth margin-left" >Size 8</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="8" value="<?=$multiple_stock['8']?>" /></div></dd></dl>
                <dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 10</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="10" value="<?=$multiple_stock['10']?>" /></div><div class="sizewidth margin-left" >Size 12</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="12" value="<?=$multiple_stock['12']?>" /></div></dd></dl>
                <dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 14</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="14" value="<?=$multiple_stock['14']?>" /></div><div class="sizewidth margin-left" >Size 16</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="16" value="<?=$multiple_stock['16']?>" /></div></dd></dl>
                <dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 18</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="18" value="<?=$multiple_stock['18']?>" /></div><div class="sizewidth margin-left" >Size 20</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="20" value="<?=$multiple_stock['20']?>" /></div></dd></dl>
                <dl class="six"><dt>&nbsp;</dt><dd><div class="sizewidth" >Size 22</div><div class="sizewidth" > <input type="number" class="textfield rounded" name="22" value="<?=$multiple_stock['22']?>" /></div></dd></dl>
				</div> <!-- end of typestock -->
               <div id="typestock_normal">		
				<dl class="two"><dt>Stock</dt><dd><input type="text" class="textfield rounded" name="product_stock" value="<?=$product['stock']?>" /></dd></dl>
               </div>
                <dl></dl>
            </div>
            <hr />
            <!--
            <div class="box">
            	<h3>Display product in the categories</h3>
                <p class="desc">Select a primary category on the left to display it's sub caregories. You can select multiple categoreis</p>
                <div id="catwrap">
                	<div class="level1"><input type="checkbox" onchange="switchall()" id="allcat" /> All categories</div>
                    <?php foreach($main as $maincat) { ?>
                    <div class="level2"><input type="checkbox" name="categories[]" value="<?=$maincat['id']?>" id="category-<?=$maincat['id']?>" class="cat-check" /> <span id="act-<?=$maincat['id']?>"><a href="javascript:expand(<?=$maincat['id']?>)"><img src="<?=base_url()?>img/backend/plus.gif" /></a></span> <?=$maincat['title']?></div>
                    <div id="maincat-<?=$maincat['id']?>" class="hidden">
                    <?php $sub = $this->Category_model->get($maincat['id']);
						foreach($sub as $subcat) { ?>
						<div class="level3"><input type="checkbox" name="categories[]" value="<?=$subcat['id']?>" id="category-<?=$subcat['id']?>" class="cat-check" /> <?=$subcat['title']?></div>
						<?php } ?>
                    </div>
					<?php } ?>                    
                </div>                               
            </div>
            <hr /> -->
            <div class="box">
            	<h3>Shipping</h3>
                <dl class="four"><dt>Product weight</dt><dd><input type="text" class="textfield rounded" name="weight" id="weight" value="<?=$product['weight']?>" /></dd><dd>Please enter the weight in kilo in format 00.00</dd></dl>
                <dl></dl>
            </div>
            <hr />
            <div class="box bgw">
            	<h3>Product attributes</h3>
                <dl class="four"><dt>Select option</dt><dd>
                	<select id="attribute">
                    	<?php foreach($attributes as $attr) { ?>
                        <option value="<?=$attr['id']?>"><?=$attr['name']?></option>
                        <?php } ?>
                    </select>
                </dd><dd><input type="button" class="button rounded" value="Insert" onclick="insertoption()" /></dd></dl>
                <dl></dl>
                <div id="optcontent">
                	<?php $n = 1;
					
					foreach($product_attributes as $attribute) 
					{
						$options = json_decode($attribute['value'],true);
					?>
                    <div id="prodattr-<?=$n?>" class="optwrap">
                    	<div class="title">
                        	Attribute: <b><?=$attribute['name']?></b>
                             (You can still customsie this attribute by adding/removing options below) <a href="javascript:removeprodattr(<?=$n?>)">Remove</a>                            
                        </div>
                        <input type="hidden" value="<?=$attribute['name']?>" name="prodattributes[]" />
                        <div class="input">
                        	<dl class="four">
                            <dd><input type="text" class="textfield rounded" id="prodoptval-<?=$n?>" /></dd>
                            <dd id="prodoptbutton-<?=$n?>">
                            	<input type="button" class="button rounded" value="&raquo;" onclick="addprodoption(<?=$n?>,<?=count($options)?>)" />
                            </dd></dl>
                            <dl></dl>
                        </div>
                        <div id="prodoptions-<?=$n?>" class="label">
                        	<?php $i = 1; foreach($options as $option) 
							{ 
							?>
                            <dl id="prodopt-<?=$n?>-<?=$i?>" class="five">
                            	<dt><?=$option?></dt>
                                <dd><a href="javascript:removeprodoption(<?=$n?>,<?=$i?>)"><img src="<?=base_url()?>img/backend/icon-delete-small.png" /></a></dd>
                                <input type="hidden" value="<?=$option?>" name="prodoptions-<?=$n?>[]" />
                            </dl>
                            <?php } ?>
                        </div>
                        <dl></dl>
                    </div>	
                    <?php $n++; } ?>
                </div>
            </div>
            <hr />
            <div class="box"><input type="submit" class="button rounded" value="Update Product" /> 
            <?php if($this->session->flashdata('update')) { ?>
            <span class="green">&nbsp; &nbsp; The product has been updated successfully!</span>
            <?php } ?>
            </div>
            </form>
        </div>
        
