    	<div class="left">
        	<h1>System Settings</h1>
            <div class="bar">

            	<div class="text">Email Forwardings</div>
            	<div class="cr"></div>
            </div>
            <form method="post" action="<?=base_url()?>admin/system/updateemails">
            <div class="box">
            
                <dl class="two"><dt>New Franchise</dt><dd>
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
                	<input type="text" class="textfield rounded" name="trade" value="<?=$values?>" />
                    <p class="desc">New trader signup will be notified to the email to the above email address.<br />
                    For additional emails seperate addresses by a comma</p>
                	</dd></dl>
            	<dl class="two"><dt>Shop Order</dt><dd>
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
                	<input type="text" class="textfield rounded" name="order" value="<?=$values?>" />
                    <p class="desc">Sales orders will be emailed to the email to the above email address.<br />
For additional emails seperate addresses by a comma</p>
                    </dd></dl>
                <dl class="two"><dt>Website Contact</dt><dd>
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
				<input type="text" class="textfield rounded" name="contact" value="<?=$values?>" />
                    <p class="desc">General website corospondance will be emailed to the above email address.<br />For additional emails seperate addresses by a comma</p>
                </dd></dl>
				<dl class="two"><dt>Low Stock</dt><dd>
                <?php 
				$add = json_decode($stock['address'],true);
				$values = '';
                	for($i=0;$i<count($add);$i++) 
					{
						
                		$values .= $add[$i];
						if($i<(count($add)-1))
						{
							$values .= ',';
						}
                	} 
					
					?>	<input type="text" class="textfield rounded" name="stock" value="<?=$values?>" />
                    <p class="desc">General website corospondance will be emailed to the above email address.<br />For additional emails seperate addresses by a comma</p>
                </dd></dl>
                <dl></dl>
            </div>
            <hr />                        
            <div class="box bgw">
                <dl class="four"><dt>&nbsp;</dt><dd><input type="submit" class="button rounded" value="Update" /></dd></dl>
				<dl class="four"><dt>&nbsp;</dt><dd><?php if($this->session->flashdata('updated')) { print $this->session->flashdata('updated'); } ?></dd></dl>
                <dl></dl>
            </div>
            </form>
        </div>
        
