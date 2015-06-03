<?
if (!empty($_SERVER['HTTPS'])) {}else
{
	Redirect('https://bared.com.au/store/signin', false);
}
?>



<script>
function clear()
{
	jQuery('#alert-login').hide();	
	jQuery('#alert-register').hide();	
	jQuery('#alert-welcome').hide();
	jQuery('#alert-forgot').hide();			
	jQuery('#alert-forgot-error').hide();			
}
function login() 
{		
	
	var username=jQuery("#username").val();
	var password=jQuery("#password-login").val();
	/*
	if(username!='' && password !='')
	{
		<?php
		/*
		if($this->session->flashdata('f_wishlist'))
		{
		?>
		var wlist = 1;
		<?
		}
		else 
		{
		?>
		var wlist = 0;
		<?
		}
		*/
		?>
		
		jQuery.ajax({
			url: '<?=base_url()?>store/validatetrade',
			type: 'POST',
			data: ({username:username,password:password,wlist:wlist}),
			dataType: "html",
			success: function(data) {
				if(data==3)
				{
					window.location='<?=base_url()?>store/edit_profile/';
				}
				else if(data==4)
				{
					window.location='<?=base_url()?>store/detail_product/<?=$this->session->userdata('from_wishlist')?>';
				}
				else if(data==1)
				{
					window.location='<?=base_url()?>cart/account_page/';
				}
				else
				{
					//clear();
					//jQuery('#alert-login').show();
					jQuery('#any_message').html("New website, new password. Please <a class='a-primary' href='javascript:open_forgot();'>click here</a> for a new password to be sent to you");
					jQuery('#anyModal').modal('show');			
				}
				
			}
		});
	}
	else
	{
		jQuery('#any_message').html("Please fill up username and password");
		jQuery('#anyModal').modal('show');			
	}
	*/
	if(username!='' && password !='')
	{
		<?php
		if($this->session->flashdata('f_wishlist'))
		{
		?>
		var wlist = 1;
		<?
		}
		else 
		{
		?>
		var wlist = 0;
		<?
		}
		?>
		
		jQuery.ajax({
			url: '<?=base_url()?>store/validate',
			type: 'POST',
			data: ({username:username,password:password,wlist:wlist}),
			dataType: "html",
			success: function(data) {
				if(data==3)
				{
					// if users already have something new in their basket, point them to shopping bag page
					window.location='<?=base_url()?>cart/list_cart/';
				}
				else if(data==4)
				{
					// if users don't have any item yet, point them to the previous page
					<?php
						if($this->session->userdata('from_prod'))
						{
							?>
								window.location='<?=$this->session->userdata('from_prod')?>';
							<?	
						}
						else 
						{
							?>
								window.location='<?=base_url()?>';
							<?
						}
					?>
				}
				else if(data==1)
				{
					// if users already have items in their bag from last time 
					window.location='<?=base_url()?>cart/account_page/';
				}
				else
				{
					//clear();
					//jQuery('#alert-login').show();
					jQuery('#any_message').html("I'm sorry you appear to have entered an incorrect username or password. Please try again, use the <a class='a-primary' href='javascript:open_forgot();'>forgot password</a> function or sign up to a new account");
					jQuery('#anyModal').modal('show');			
				}
				
			}
		});
	}
	else
	{
		jQuery('#any_message').html("Please enter your username and password");
		jQuery('#anyModal').modal('show');			
	}
	
}
</script>

<div class="app-container content-wrap">
	
	
	<div id="fb-root"></div>
<script>


  //function
  
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '602736106428564', // App ID
    channelUrl : '//bared.com.au/channel.html', // Channel File
    status     : false, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
    
  });

  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
  // for any auth related change, such as login, logout or session refresh. This means that
  // whenever someone who was previously logged out tries to log in again, the correct case below 
  // will be handled. 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most bsers unless they 
      // result from direct user interaction (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
    } else {
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
    }
  },{scope:'email,user_birthday'});
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));
  
  

  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {
    //console.log('Welcome!  Fetching your information.... ');
     //FB.api('/me', function(response) {
       //console.log('Good to see you, ' + response.email + '.');
     //});
    window.location='<?=base_url()?>store/fb';
  }
</script>
	
    
    <div style="height: 20px;"></div>
    
	<h4 class="content-h4">Sign In</h4>
    <div style="height: 20px;"></div>
	<div class="signin-background">
	    <h4 class="content-h4">Registered Customers</h4>
	    <div style="float: left">
		    <div class="body-copy-Font">If you have already registered with Bared, then sign in here.</div>
		    <!-- <div class="alert alert-error" id="alert-login">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Warning!</strong> Wrong username/password. Please try again!.
			</div> -->
            <div style="clear: both; height: 20px;"></div>
            
            <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-6 x-gutters control-label">Enter your email</label>
                <div class="col-sm-6 x-gutters">
                  <input type="email" id="username" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-6 x-gutters control-label">Enter your password</label>
                <div class="col-sm-6 x-gutters">
                  <input type="password" id="password-login" class="form-control">
                </div>
            </div>
            </form>
		   
		    <div style="clear: both; height: 10px;"></div>
		    <div class="signin-label body-copy-Font">
		    	<a class="body-copy-Font link_title" href="#" onclick="jQuery('#forgot1Modal').modal('show');">Forgot your password?</a>
		    </div>
		    <div class="signin-input input-form-Font">
		    	&nbsp;
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="visible-xs" style="width: 232px;text-align:center;">
		    	<input onclick="login();" type="button" value="Sign In Now" class="button_primary button_size_fb button-Font"/>
		    	
                <div class="body-copy-Font" style="text-align: center; margin-top: 10px; margin-bottom: 10px">
		    	Or
		    	</div>
		    	<!-- <input type="button" value="" style="background: url('<?=base_url()?>img/fb-signin.png'); color: #fff; width: 232px; height: 41px; border:none; font-size: 16px;"/> -->
		    	<div class="fb-login-button" data-show-faces="false" data-size="xlarge" data-scope="email,user_birthday" data-width="232" data-max-s="1">Sign in Via FB</div>
		    	<!-- <img style="cursor: pointer" onclick="fb_login();" src="<?=base_url()?>img/fb-signin.png" alt=""/> -->
		    	<!-- <fb:login-button size="xlarge"
	                 onlogin="require('./log').info('onlogin callback')">
	  Find Friends
	</fb:login-button> -->
		    </div>
	    </div>
	    
	    <div class="hidden-xs" id="button-login-cont" style="text-align:center;">
	    	<input onclick="login();" type="button" value="Sign In Now" class="button_primary button_size_fb button-Font"/>
	    	
            <div class="body-copy-Font" style="text-align: center; margin-top: 10px; margin-bottom: 10px">
	    	Or
	    	</div>
	    	<!-- <input type="button" value="" style="background: url('<?=base_url()?>img/fb-signin.png'); color: #fff; width: 232px; height: 41px; border:none; font-size: 16px;"/> -->
	    	<!-- <img style="cursor: pointer" onclick="fb_login();" src="<?=base_url()?>img/fb-signin.png" alt=""/> -->
	    	<div class="fb-login-button" data-show-faces="false" data-size="xlarge" data-scope="email,user_birthday" data-width="232" data-max-s="1">Sign in Via Facebook</div>
	    </div>
    </div>
    <div style="clear: both; height: 20px;"></div>
    <div>
    	<div class="signin-background">
	    	<h4>Register</h4>
	    	<div class="body-copy-Font" style="float: left; font-weight: bold">
	    		If you are new to Bared, please click 'Register Now'<br/><br/>
	    		
	    		<input class="visible-xs button_primary button_size_fb button-Font" type="button" value="Register Now" onclick="window.location='<?=base_url()?>store/register'" />
	    	</div>
	    	<div style="float: right" class="hidden-xs">
	    		<input onclick="window.location='<?=base_url()?>store/register'" type="button" value="Register Now" class="button_primary button_size_fb button-Font"/>
	    	</div>
    	</div>
    </div>
    <div style="clear: both; height: 20px;"></div>
    
    <script>
    function test()
    {
    	$( "iframe" ).each(function( index ) {
			$(this).contents().find('.uiGrid').hide(); 
		});
	}
	
	function send_forgot()
	{
		jQuery('#forgot1Modal').modal('hide');
		var email = jQuery('#forgot_email').val();
		if(email != '')
		{
			jQuery.ajax({
			url: '<?=base_url()?>store/forgot_pass',
			type: 'POST',
			data: ({email:email}),
			dataType: "html",
			success: function(data) {
					if(data==1)
					{
						jQuery('#any_message').html('Your new password has been sent to your email address '+email);
						jQuery('#anyModal').modal('show');
						jQuery('#forgot_email').val('');
					}
					else
					{
						jQuery('#any_message').html('Your email address does not looks appear as a member');
						jQuery('#anyModal').modal('show');
						jQuery('#forgot_email').val('');	
					}
					
				}
			});
			
			
		}
		else
		{
			jQuery('#any_message').html('Please insert your email password');
			jQuery('#anyModal').modal('show');
		}
		
	}
    </script>
    
    
	
    
    <div id="forgot1Modal" class="modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="mytop-modal" onclick="jQuery('#forgot1Modal').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
    <div class="modal-body mybody-modal body-copy-Font">
    	<div style="margin-bottom: 5px;">Please insert your email</div>
    	<div style="margin-bottom: 5px;"><input id="forgot_email" type="email" style="border: 1px solid #cac5c2; width: 97%" /></div>
       	<div style="margin-bottom: 5px;"><input onclick="send_forgot();" type="button" value="Submit" style="background: #000; color: #fff; width: 100%; height: 41px; border:none; font-size: 16px;"/></div>
        </p>
    </div>
    </div>

	
    
    </div><!-- app-container-->	
        
   