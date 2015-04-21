
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<h1 style=" padding-left:7px;">Email Forwarding</h1>
			<div style="height: 10px; clear: both">&nbsp;</div>

			<div style="padding-left:7px;">
            <!-- start here
			
			

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Trade Inquiry</div>

				<div style="width: 80%; float: right">
				-->
					<?php 

					$add = json_decode($trade['address'],true);

					$values = '';

	            	for($i=0;$i<count($add);$i++) 

					{

						

	            		$values .= $add[$i];

						if($i<(count($add)-1))

						{

							$values .= ',';

						}

	            	} 

					?>
					 <form method="post" action="<?=base_url()?>admin/system/updateemails">
					<input style="width: 97%; display:none;" type="text" class="textfield rounded" id="trade" name="trade" value="<?=$values?>"/>
					<!--	
					<p style="font-size: 12px; font-style: italic;">New trader signup will be notified to the email to the above email address. For additional emails seperate addresses by a comma</p>

				</div>
					-->
			</div>

			

			<div style="height: 20px; clear: both">&nbsp;</div>

			

			<div style="padding-left:7px;">

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Retail Order</div>

				<div style="width: 80%; float: right">

					<?php 

					$add = json_decode($order['address'],true);

					$values = '';

	            	for($i=0;$i<count($add);$i++) 

					{

						

	            		$values .= $add[$i];

						if($i<(count($add)-1))

						{

							$values .= ',';

						}

	            	} 

					?>

					<input style="width: 97%" type="text" class="textfield rounded" id="order" name="order" value="<?=$values?>"/>

					<p style="font-size: 12px; font-style: italic;">Sales orders will be emailed to the email to the above email address. For additional emails seperate addresses by a comma</p>

				</div>

			</div>

			

			<div style="height: 20px; clear: both">&nbsp;</div>

			

			<div style="padding-left:7px;">

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Website Contact</div>

				<div style="width: 80%; float: right">

					<?php 

					$add = json_decode($contact['address'],true);

					$values = '';

	            	for($i=0;$i<count($add);$i++) 

					{

						

	            		$values .= $add[$i];

						if($i<(count($add)-1))

						{

							$values .= ',';

						}

	            	} 

					?>

					<input style="width: 97%" type="text" class="textfield rounded" id="contact" name="contact" value="<?=$values?>"/>

					<p style="font-size: 12px; font-style: italic;">General website corospondance will be emailed to the above email address. For additional emails seperate addresses by a comma</p>

				</div>

			</div>

			

			<div style="height: 20px; clear: both">&nbsp;</div>

			

			<div style="padding-left:7px;">

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Low Stock</div>

				<div style="width: 80%; float: right">

					<?php 

					$add = json_decode($order['address'],true);

					$values = '';

	            	for($i=0;$i<count($add);$i++) 

					{

						

	            		$values .= $add[$i];

						if($i<(count($add)-1))

						{

							$values .= ',';

						}

	            	} 

					?>

					<input style="width: 97%" type="text" class="textfield rounded" id="stock" name="stock" value="<?=$values?>"/>

					<p style="font-size: 12px; font-style: italic;">General website corospondance will be emailed to the above email address. For additional emails seperate addresses by a comma</p>

				</div>

			</div>

			

			<div style="height: 20px; clear: both">&nbsp;</div>

			

			<div style="padding-left:7px;">

				<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>

				<div style="width: 80%; float: right">

					<button class="btn btn-primary" type="submit">Update</button>
					</form>
				</div>

			</div>

			

			<div style="clear: both">&nbsp;</div>
			<?php if($this->session->flashdata('updated')) { print $this->session->flashdata('updated'); } ?>
			<!-- end here -->

		</div>

	</div>

</div>