<table border="0" cellpadding="0" cellspacing="0" class="body" width="600" style="margin-bottom: 20px">
    <tbody>
    <tr>
        <td style="width: 100%; background: #000">
            <p style="padding:20px; margin: 0; color: #fff; font-size: 14px; font-family:Arial, sans-serif;">
            	Dear <?php echo ucwords($invitee_firstname); ?>,<br/><br/>
                
                I entered this competition and thought you may want to enter also.<br><br>
                
                Thanks <?php echo ucwords($inviter_firstname); ?>
           </p>
        </td>
    </tr>
    <tr>    
        <td style="width: 100%; background: #000; text-align:center; padding:20px;">
            <a href="<?=base_url();?>competition/entry/<?=$token;?>" target="_blank">
                <img alt="enter-btn.jpg" src="<?=base_url();?>img/competition/enter-btn.jpg">
            </a>
        </td>
    </tr>
    <tr>
    	<td>
        	<img alt="competition-banner.jpg" src="<?=base_url();?>img/competition/competition-banner.jpg">
        </td>
    </tr>
    </tbody>
</table>