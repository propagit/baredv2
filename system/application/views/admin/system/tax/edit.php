<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

			<h1 style="padding-left: 7px;">

				Edit Taxes

			</h1>

			<button class="btn" onclick="window.location = '<?=base_url()?>admin/system/tax'">Back To Taxes List</button>

			<div style="height: 20px"></div>

			<?php if($this->session->flashdata('updated')) { ?>

			    <div class="alert alert-success" style="margin-left: 7px;">

			    	<button type="button" class="close" onclick="$('.alert-success').fadeOut('slow');">&times;</button>

					<strong>Tax Updated!</strong>

				</div>

			<?php }?>

			<form method="post" action="<?=base_url()?>admin/system/updatetax">

				<input type="hidden" name="tax_id" value="<?=$tax['id']?>" />

				<div style="padding-left: 7px;">

					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Tax Name</div>

					<div style="width: 80%; float: right">

						<input style="width: 97%" type="text" class="textfield rounded" id="name" name="name" value="<?=$tax['name']?>"/>

					</div>

				</div>

				<div style="height: 5px; clear: both">&nbsp;</div>

				<div style="padding-left: 7px;">

					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Description</div>

					<div style="width: 80%; float: right">

						<input style="width: 97%" type="text" class="textfield rounded" id="description" name="description" value="<?=$tax['description']?>"/>

					</div>

				</div>

				<div style="height: 5px; clear: both">&nbsp;</div>

				<div style="padding-left: 7px;">

					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Country</div>

					<div style="width: 80%; float: right">

						<select name="countries[]" multiple="multiple" style="height:auto;">

							<?php foreach($countries as $ct) {?>

		                    	<option <?php if($this->System_model->country_tax($ct['id'],$tax['id'])) print ' selected="selected"'; ?> value="<?=$ct['id']?>"><?=$ct['name']?></option>

		                    <?php } ?>

						</select>

					</div>

				</div>

				<div style="height: 5px; clear: both">&nbsp;</div>

				<div style="padding-left: 7px;">

					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Cost</div>

					<div style="width: 80%; float: right">

	                    <div class="input-append">

							<input class="span2" id="appendedInput" name="value" type="text" value="<?=$tax['value']?>">

							<span class="add-on">%</span>

						</div>

					</div>

				</div>

				<div style="height: 5px; clear: both">&nbsp;</div>

				<div style="padding-left: 7px;">

					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>

					<div style="width: 80%; float: right">

					    <p><input style="margin-top: -3px;" type="checkbox" name="included" <?php if($tax['included']) print ' checked="checked"'; ?> /> &nbsp;&nbsp; Retail Store Front (Include tax in price)</p>
						
						<p><input style="margin-top: -3px; display:none;" type="checkbox" name="tradetax" <?php if($tax['tradetax']) print ' checked="checked"'; ?> /> <!--&nbsp;&nbsp; Trade Store Front (Include tax in price)--></p>    

					</div>

				</div>

				<div style="height: 20px; clear: both">&nbsp;</div>

				<div style="padding-left: 7px;">

					<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>

					<div style="width: 80%; float: right">

					    <button class="btn btn-primary" type="submit">Update</button>

					</div>

				</div>

			</form>

			<div style="height: 0px; clear: both">&nbsp;</div>

			<!-- end here -->

		</div>

	</div>

</div>