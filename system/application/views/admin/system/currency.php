<script>
function save_cur(nation)
{
	var val = $('#'+nation).val();
	
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/system/set_currency',
		type: 'POST',
		data: ({nation:nation,val:val}),
		dataType: "html",
		success: function(html) {
			jQuery('#any_message').html("Your "+nation.toUpperCase()+" currency has been successfully updated");
			$('#anyModal').modal('show');
			
		}
	})
	//alert(val);
}
</script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1>
				Currency Setting
			</h1>
			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">
				$1.00 AUD = 
			</div>
			<div style="width: 80%; float: left;">
				<div style="float: left" class="input-prepend">
                  	<span class="add-on" style="width:40px">USA $</span>
					<input style="width: 190px;" class="span2" id="usa" type="text" value="<?=$usa?>">
				</div>
				<button onclick="save_cur('usa');" class="btn btn-primary" type="button" style="margin-left: 15px">Update</button>
			</div>
			<div style="clear: both; height: 15px"></div>
			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">
				$1.00 AUD = 
			</div>
			<div style="width: 80%; float: left;">
				<div style="float: left" class="input-prepend">
                  	<span class="add-on" style="width:40px">EUR €</span>
					<input style="width: 190px;" class="span2" id="eur" type="text" value="<?=$eur?>">
				</div>
				<button onclick="save_cur('eur');" class="btn btn-primary" type="button" style="margin-left: 15px">Update</button>
			</div>
			<div style="clear: both; height: 15px"></div>
			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">
				$1.00 AUD = 
			</div>
			<div style="width: 80%; float: left;">
				<div style="float: left" class="input-prepend">
                  	<span class="add-on" style="width:40px">GBP £</span>
					<input style="width: 190px;" class="span2" id="gbp" type="text" value="<?=$gbp?>">
				</div>
				<button onclick="save_cur('gbp');" class="btn btn-primary" type="button" style="margin-left: 15px">Update</button>
			</div>
			<div style="clear: both; height: 15px"></div>
			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">
				$1.00 AUD = 
			</div>
			<div style="width: 80%; float: left;">
				<div style="float: left" class="input-prepend">
                  	<span class="add-on" style="width:40px">JPY ¥</span>
					<input style="width: 190px;" class="span2" id="jpy" type="text" value="<?=$jpy?>">
				</div>
				<button onclick="save_cur('jpy');" class="btn btn-primary" type="button" style="margin-left: 15px">Update</button>
			</div>
			<div style="clear: both"></div>
			<!-- end here -->
		</div>
	</div>
</div>

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