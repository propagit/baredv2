<script type="text/javascript" src="<?=base_url();?>js/city_states.js"></script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/tax'">Back To Taxes List</button>
			<div style="height: 20px"></div>
			<form method="post" action="<?=base_url()?>admin/system/addtax">
				
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Tax Name</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Description</div>
					<div style="width: 80%; float: right">
						<input style="width: 97%" type="text" class="textfield rounded" id="description" name="description" value=""/>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Country</div>
					<div style="width: 80%; float: right">
						<select name="countries[]" multiple="multiple" style="height:auto;">
							<?php foreach($countries as $ct) {?>
		                    	<option value="<?=$ct['id']?>"><?=$ct['name']?></option>
		                    <?php } ?>
						</select>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Cost</div>
					<div style="width: 80%; float: right">
	                    <div class="input-append">
							<input class="span2" id="appendedInput" name="value" type="text">
							<span class="add-on">%</span>
						</div>
					</div>
				</div>
				<div style="height: 5px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
					    <p><input style="margin-top: -3px;" type="checkbox" name="included" /> &nbsp;&nbsp; Retail Store Front (Include tax in price)</p>
						<p><input style="margin-top: -3px; display:none;" type="checkbox" name="tradetax" /> <!--&nbsp;&nbsp; Trade Store Front (Include tax in price)--></p>    
					</div>
				</div>
				<div style="height: 20px; clear: both">&nbsp;</div>
				<div>
					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
					<div style="width: 80%; float: right">
					    <button class="btn btn-primary" type="submit">Create</button>
					</div>
				</div>
			</form>
			<div style="height: 0px; clear: both">&nbsp;</div>
			<!-- end here -->
		</div>
	</div>
</div>