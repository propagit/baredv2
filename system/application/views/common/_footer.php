<style>



	
</style>
<script>
jQuery('.banners').carousel({
  interval: 6000
})
function subscribe()
{
	var email_desktop = $('#subs_input_desktop').val();
	var email_not_desktop = $('#subs_input_not_desktop').val();
	if(email_desktop=='' && email_not_desktop==''){ 
		jQuery('#any_message_footer').html('Please enter email address');
	  	jQuery('#anyModalFooter').modal('show');
		return false;
	}
	else if(email_desktop=='' && email_not_desktop!='')
	{
		var email = email_not_desktop;
	}
	else if(email_desktop!='' && email_not_desktop=='')
	{
		var email = email_desktop;
	}
	if(email!='')
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(reg.test(email) == false) {
		
		  jQuery('#any_message_footer').html('Invalid Email Address');
		  jQuery('#anyModalFooter').modal('show');	
	   }
	   else
	   {
		  $.ajax({
				url: '<?=base_url()?>cart/newsletter_subscribe',
				type: 'POST',
				data: ({email:email}),
				dataType: "html",
				success: function(html) {
				
						if(html != 0)
						{
							if(html == -1)
							{
								jQuery('#any_message_footer').html('Your are already in our subscription list.');
								jQuery('#anyModalFooter').modal('show');
							}
							else
							{
								jQuery('#any_message_footer').html('Thank you for subscribing with us.');
								jQuery('#anyModalFooter').modal('show');
							}
							
						}
				
				}
				});
	   }
	}
}
</script>
	<div class="container">
		<div class="hidden-phone">	
			<div class="row"  id="social-line">
				<div class="span12">
					<div class="dot-footer-left hidden-phone">
						&nbsp;
					</div>
					<div class="dot-footer-left visible-phone phone-foot">
						&nbsp;
					</div>
					<div class="footer-social-icon" >
						<a id="fb_foot" href="https://www.facebook.com/baredfootwear/" target="_blank"><img src="<?=base_url()?>img/footer/fb-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/fb-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/fb-footer-icon.png'"></a>
					</div>
					<div class="footer-social-icon" >
						<a id="tw_foot" href="https://twitter.com/BaredFootwear" target="_blank"><img src="<?=base_url()?>img/footer/twitter-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/twitter-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/twitter-footer-icon.png'"></a>
					</div>
					<div class="footer-social-icon" >
						<a id="cam_foot" href="http://instagram.com/baredfootwear#" target="_blank"><img src="<?=base_url()?>img/footer/camera-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/camera-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/camera-footer-icon.png'"></a>
					</div>
					<div class="last-footer-social-icon" >
						<a id="pin_foot" href="http://www.pinterest.com/baredfootwear" target="_blank"><img src="<?=base_url()?>img/footer/pin-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/pin-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/pin-footer-icon.png'"></a>
					</div>
					<div class="dot-footer-right hidden-phone">
						&nbsp;
					</div>
					<div class="dot-footer-right visible-phone phone-foot">
						&nbsp;
					</div>
				</div>
				<script>
					
				</script>
			</div>
			<!-- <div style="clear: both; height: 50px;">
				&nbsp;
			</div> -->
			<div class="row" id="footer-cont">
				<div class="span2 new_span2" >
					<div class="footer-menu footer-menu-Font">CUSTOMER CARE</div>					
                    <div class="list-footer-menu">
                    <? 
					
					$categories = $this->Category_model->get(9);
					foreach($categories as $ct)
                    {
						
						if($ct['type']==0){
							$texts=$this->Product_model->get_name_keyword($ct['title']);											
							if($texts){
							?>									    
								<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/products/Handbags/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/>
							<? }else{ ?>
								<a  class="feature-submenu-Font footer-submenu" href="#"><?=$ct['title']?></a><br/>
							<? } ?>
					<?php }
						else
						{ 
							if($ct['external_link']!='')
							{														
								?><a target="_blank" class="feature-submenu-Font footer-submenu" href="<?=$ct['external_link']?>"><?=$ct['title']?></a><br/><?                                
							}
							else
							{
								$pages = $this->Menu_model->getpage($ct['id_page']);
								if($pages)
								{
								if($pages['display']==0){
								?><!--<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/page/<?=$ct['id_page']?>"><?=$ct['title']?></a>-->
                                    <? $pages = $this->Menu_model->getpage($ct['id_page']);?>					                                    
                                    <a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a>
								
                                <br/><? } else {
								?>
								<a style="cursor:pointer;" class="feature-submenu-Font footer-submenu" onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a><br/>
								<?
								}
								}
								else {
									
									$pages = $this->Menu_model->getpage($ct['id_page']);
									?>					                                    
                                    <a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a><br/>
									<?
								}
							}
						}
					}
					?>
					
					</div>
				</div>
				<div class="span2 new_span2 span-left">
					<div class="footer-menu-Font footer-menu">FITTING OPTIONS</div>	
					<div class="list-footer-menu">					
                    <?
                    $categories = $this->Category_model->get(10);
					foreach($categories as $ct)
                    {

						if($ct['type']==0){
							$texts=$this->Product_model->get_name_keyword($ct['title']);											
							if($texts){
							?>									    
								<a  class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/products/Handbags/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/>
							<? }else{ ?>
								<a  class="feature-submenu-Font footer-submenu" href="#"><?=$ct['title']?></a><br/>
							<? } ?>
					<?php }
						else
						{ 
							if($ct['external_link']!='')
							{
						
								?><a target="_blank" class="feature-submenu-Font footer-submenu" href="<?=$ct['external_link']?>"><?=$ct['title']?></a><br/><?
							}
							else
							{
								$pages = $this->Menu_model->getpage($ct['id_page']);
								
								
								if($pages)
								{
								if($pages['display']==0){
								?><!--<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/page/<?=$ct['id_page']?>"><?=$ct['title']?></a>-->
                                 <? $pages = $this->Menu_model->getpage($ct['id_page']);?>					                                    
                                    <a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a>
                                <br/><? } else {
								?>
								<a style="cursor:pointer;" class="feature-submenu-Font footer-submenu" onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a><br/>
								<?
								}
								}
								else {
									
									$pages = $this->Menu_model->getpage($ct['id_page']);
									?>					                                    
                                    <a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a><br/>
									<?
								}
							}
						}
					}
					?>
					</div>
				</div>
				<div class="span2 new_span2 span-left">
					<div class="footer-menu-Font footer-menu">YOUR ACCOUNT</div>	
					<div class="list-footer-menu">							
                    <?
                    $categories = $this->Category_model->get(11);
					foreach($categories as $ct)
                    {
						
						if($ct['id']==111)
						{
							if($this->session->userdata('userloggedin'))
							{
								$user = $this->session->userdata('userloggedin');
								if($user==1){$cust = $this->Customer_model->identify(1);}
								else{
									$cust = $this->Customer_model->identify($user['customer_id']);
								}
								if($user['level'] == 1)
								{
								?>
									<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">Login</a><br />
								<?
								}
								else if($user['level'] == 2)
								{
								?>
									<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/edit_detail_trade/<?=$cust['id']?>">Login</a><br />
								<?
								}else if($user['level'] == 9)
								{
									?>
									<a class="feature-submenu-Font footer-submenu" href="#">Login</a><br />
									<?
								}
							}
							else
							{
								?><a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/register">Login</a><br /><?
							}
						}
						else
						{
							if($ct['type']==0){
								$texts=$this->Product_model->get_name_keyword($ct['title']);											
								if($texts){
								?>									    
									<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/products/Handbags/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a><br/>
								<? }else{ ?>
									<a class="feature-submenu-Font footer-submenu" href="#"><?=$ct['title']?></a><br/>
								<? } ?>
							<?php }
							else
							{ 
								if($ct['external_link']!='')
								{
							
									?><a class="feature-submenu-Font footer-submenu" href="<?=$ct['external_link']?>"><?=$ct['title']?></a><br/><?
								}
								else
								{
									$pages = $this->Menu_model->getpage($ct['id_page']);
									if($pages)
									{
									if($pages['display']==0){
									?><!--<a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>store/page/<?=$ct['id_page']?>"><?=$ct['title']?></a>-->
                                     <? $pages = $this->Menu_model->getpage($ct['id_page']);?>					                                    
                                    <a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a>
                                    <br/><? } else {
									?>
									<a style="cursor:pointer;" class="feature-submenu-Font footer-submenu" onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a><br/>
									<?
									}
									}
									else {
									
									$pages = $this->Menu_model->getpage($ct['id_page']);
									?>					                                    
                                    <a class="feature-submenu-Font footer-submenu" href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a><br/>
									<?
									}
								}
							}
						}
					}
					?>
					</div>
				</div>
				
				<div class="span4 span_subscribe visible-desktop span-left" >
					
					<div style="float: right;margin-top:52px;">
						<div style="float: left;"><img src="<?=base_url()?>img/footer/dontMissout.png"></div>
						<div style="clear: both; height:25px;"></div>
						
						<div class="body-copy-Font footer-submenu" style="clear: both; ">
							Stay up to date with new stock, styles and sales by signing up to our newsletter.
						</div>
						<!-- <div class="body-copy-Font footer-submenu" style="margin-top:-5px;">
							
						</div>	 -->
                        <div style="clear: both; height:30px;"></div>
							<div style="float:right;">
								<input name="sub_email" id="subs_input_desktop" type="email" placeholder="Enter Email Address">
							</div>	
                            <div style="clear: both;height:15px;"></div>						
							<div onclick="subscribe();" class="primaryFont " style="cursor:pointer;" id="button_subscribe" >
								Sign Up
							</div>				
					</div>
				</div>
				
				<div class="span4 span_subscribe hidden-desktop span-left">
					<div style="float: right;margin-top:52px;">	
                        <div style="float: left;"><img src="<?=base_url()?>img/footer/dontMissout.png"></div>
                        <div style="clear: both; height:15px;"></div>
						<div class="primaryFont footer-submenu" style="clear: both;">
							Stay up to date with new stock, styles and sales by signing up to our newsletter.
						</div>
						<!-- <div class="primaryFont footer-submenu" style="margin-top:-5px;">
							
						</div>	 -->
                        <div style="clear: both; height:20px;"></div>
                        <div style="float: right">
							<input class="input-form-Font" id="subs_input_not_desktop" type="email" placeholder="Enter Email Address" >
						</div>
                        <div style="clear: both;height:15px;"></div>	
						<div onclick="subscribe();" style="cursor:pointer;" class="button-Font" id="button_subscribe">
							Sign Up
						</div>
                    </div>
				</div>
			</div>
		</div>
		
		
		
	</div>
	
	<div class="navbar navbar-fixed-top" >
	
	<div class="visible-phone">	
		<div class="container">
			<div class="row">
				<!-- <div style="text-align: center; margin-bottom: 30px; padding-left: 4%; padding-right: 4%; color: #fff;">
					
					<div id="footer-nondesktop" class="primaryFont footer-submenu">
						<a style="color: #fff; display: block" href="<?=base_url()?>store/page/14">SERVICE</a>
					</div>
					<div style="width: 4%; float: left">&nbsp;</div>
					<div id="footer-nondesktop" class="primaryFont footer-submenu">
						<a style="color: #fff; display: block" href="<?=base_url()?>store/stockist">US</a>
					</div>
					<div style="clear: both; height: 10px"></div>
					<div id="footer-nondesktop" class="primaryFont footer-submenu">
						
						<?php
							if($this->session->userdata('userloggedin'))
							{
								$user = $this->session->userdata('userloggedin');
								if($user==1){$cust = $this->Customer_model->identify(1);}
								else{
									$cust = $this->Customer_model->identify($user['customer_id']);
								}
								if($user['level'] == 1)
								{
								?>
									<a  style="color: #fff; display: block" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">YOU</a><br />
								<?
								}
								else if($user['level'] == 2)
								{
								?>
									<a  style="color: #fff; display: block"href="<?=base_url()?>store/edit_detail_trade/<?=$cust['id']?>">YOU</a><br />
								<?
								}else if($user['level'] == 9)
								{
									?>
									<a  style="color: #fff; display: block"href="#">My Account</a><br />
									<?
								}
							}
							else
							{
								?><a  style="color: #fff; display: block" href="<?=base_url()?>store/register">YOU</a><br /><?
							}
						?>
					</div>
					<div style="width: 4%; float: left">&nbsp;</div>
					<div id="footer-nondesktop" class="primaryFont footer-submenu">
						<a style="color: #fff; display: block" href="<?=base_url()?>store/page/38">CONTACT US</a>
					</div>
					<div style="clear: both"></div>
				</div> -->
				
				<div style="margin-left:4%; margin-right: 4%;">
					<!-- <div class="dot-footer-left visible-phone phone-foot">
						&nbsp;
					</div> -->
					<div style="width: 100%">
						<div style="width:12.5%; float: left">&nbsp;</div>
						<div style="width:15%; float: left; text-align: center">
							<a id="fb_foot" href="https://www.facebook.com/baredfootwear/" target="_blank"><img src="<?=base_url()?>img/footer/fb-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/fb-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/fb-footer-icon.png'"></a>
						</div>
						<div style="width:5%; float: left">&nbsp;</div>
						<div style="width:15%; float: left; text-align: center">
							<a id="tw_foot" href="https://twitter.com/BaredFootwear" target="_blank"><img src="<?=base_url()?>img/footer/twitter-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/twitter-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/twitter-footer-icon.png'"></a>
						</div>
						<div style="width:5%; float: left">&nbsp;</div>
						<div style="width:15%; float: left; text-align: center">
							<a id="cam_foot" href="http://instagram.com/baredfootwear#" target="_blank"><img src="<?=base_url()?>img/footer/camera-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/camera-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/camera-footer-icon.png'"></a>
						</div>
						<div style="width:5%; float: left">&nbsp;</div>
						<div style="width:15%; float: left; text-align: center">
							<a id="pin_foot" href="http://www.pinterest.com/baredfootwear" target="_blank"><img src="<?=base_url()?>img/footer/pin-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/pin-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/pin-footer-icon.png'"></a>
						</div>
						<div style="width:12.5%; float: left">&nbsp;</div>
					</div>
					<div style="clear: both; height: 10px;"></div>
					<!-- <div style="width: 225px; margin: 0 auto;">
						<div class="footer-social-icon" >
							<a id="fb_foot" href="https://www.facebook.com/baredfootwear/" target="_blank"><img src="<?=base_url()?>img/footer/fb-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/fb-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/fb-footer-icon.png'"></a>
						</div>
						<div class="footer-social-icon" >
							<a id="tw_foot" href="https://twitter.com/BaredFootwear" target="_blank"><img src="<?=base_url()?>img/footer/twitter-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/twitter-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/twitter-footer-icon.png'"></a>
						</div>
						<div class="footer-social-icon" >
							<a id="cam_foot" href="http://instagram.com/baredfootwear#" target="_blank"><img src="<?=base_url()?>img/footer/camera-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/camera-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/camera-footer-icon.png'"></a>
						</div>
						<div class="last-footer-social-icon" >
							<a id="pin_foot" href="http://www.pinterest.com/baredfootwear" target="_blank"><img src="<?=base_url()?>img/footer/pin-footer-icon.png" onmouseover="this.src='<?=base_url()?>img/footer/pin-footer-color-icon.png'" onmouseout="this.src='<?=base_url()?>img/footer/pin-footer-icon.png'"></a>
						</div>
					</div> -->
					<!-- <div class="dot-footer-right visible-phone phone-foot">
						&nbsp;
					</div> -->
					<div style="height: 15px; clear: both">&nbsp;</div>
					<?php
						if($this->session->userdata('userloggedin'))
						{
						?>
							<input onclick="window.location='<?=base_url()?>store/signout'" class="button_primary button-Font left-side button_header" type="button" value="Sign Out">
						<?
						}
						else 
						{
						?>
							<input onclick="window.location='<?=base_url()?>store/signin'" class="button_primary button-Font left-side button_header" type="button" value="Sign In">
						<?
						}
					?>
					
					<div style="float: left; width: 10%">&nbsp;</div>
					<input onclick="window.location='<?=base_url()?>store/register'" class="button_primary button-Font left-side button_header" type="button" value="Register">
					
					<div style="height: 15px; clear: both">&nbsp;</div>
					
					<input onclick="window.location='<?=base_url()?>page/Contact-Us'" class="button_primary button-Font left-side button_header" type="button" value="Contact Us">
					
					<div style="float: left; width: 10%">&nbsp;</div>
					<input onclick="window.location='<?=base_url()?>cart/list_cart'" class="button_primary button-Font left-side button_header" type="button" value="Shopping Bag">
				</div>
			</div>
		</div>
	
		
	</div>
	</div>
	
	
    
    
    <div id="anyModalFooter" class="modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="mytop-modal" onclick="jQuery('#anyModalFooter').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
    <div class="modal-body mybody-modal">
        <p id="any_message_footer" class="body-copy-Font"></p>
    </div>
    </div>

<!-- Crazy Egg -->
<script type="text/javascript">
setTimeout(function(){var a=document.createElement("script");
var b=document.getElementsByTagName("script")[0];
a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0018/8084.js?"+Math.floor(new Date().getTime()/3600000);
a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>


</body>
</html>