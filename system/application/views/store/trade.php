<script src="<?=base_url()?>js/bootstrap-select.js"></script>
<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<script type="text/javascript">
$(function() {       	
	jQuery('.selectpicker').selectpicker();
	clear();
	
});
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
	
	jQuery.ajax({
		url: '<?=base_url()?>cart/validatetrade',
		type: 'POST',
		data: ({username:username,password:password}),
		dataType: "html",
		success: function(data) {
			if(data==1)
			{
				window.location='<?=base_url()?>store/cart';
			}
			else
			{
				clear();
				jQuery('#alert-login').show();			
			}
			
		}
	});
	
}

function register() 
{		
	
	var firstname=jQuery("#firstname").val();
	var lastname=jQuery("#lastname").val();
	var email=jQuery("#email").val();	
	var password=jQuery("#password-register").val();
	var address=jQuery("#address").val();
	var suburb=jQuery("#suburb").val();
	var state=jQuery("#state").val();
	var postcode=jQuery("#postcode").val();
	var mobile=jQuery("#mobile").val();
	
	jQuery.ajax({
		url: '<?=base_url()?>cart/traderegister',
		type: 'POST',
		data: ({firstname:firstname,lastname:lastname, email:email, password:password, address:address, suburb:suburb, state:state, postcode:postcode, mobile:mobile}),
		dataType: "html",
		success: function(data) {
			
			if(data==1)
			{
				clear();
				jQuery('#alert-welcome').show();			
				$(':input').not(':button, :submit, :reset, :hidden').val('');
			}
			else if(data==2)
			{
				clear();
				jQuery('#alert-register').show();			
			}
			
			
			
		}
	});
	
}
function forgot()
{
	var username = jQuery("#email-forgot").val();
	jQuery.ajax({
		url: '<?=base_url()?>cart/forgot',
		type: 'POST',
		data: ({username:username}),
		dataType: "html",
		success: function(data) {
			
			if(data==1)
			{
				clear();
				jQuery('#alert-forgot').show();			
				$(':input').not(':button, :submit, :reset, :hidden').val('');
			}
			else if(data==2)
			{
				clear();
				jQuery('#alert-forgot-error').show();			
			}
			
			
			
		}
	});
}
</script>
<div class="app-container">
	<div style="height:10px;"></div>     
		<div class="">        	
            <div class="col-sm-12">
            <h1> Sign In </h1>
            <p>Existing members login to your account by entering your username and password. <br>If you have forgotten your password click the link below and a password will be sent to your email account.</p>
                <div style="height:10px;"></div> 
                <div class="alert alert-error" id="alert-login">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>Warning!</strong> Wrong username/password. Please try again!.
				</div>
                <div class="alert alert-success" id="alert-welcome">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>Well done!</strong> You successfully sign up. Please sign in with your email and password..
				</div>
				
                <form class="form-horizontal" name="loginForm" method="post" action="javascript:logiin();">
                <div class="control-group">
                <label class="control-label" style="text-align:left;" for="username">Email</label>
                <div class="controls">
                <input type="email" id="username" name="username" placeholder="Email" required>
                </div>
                </div>
                <div class="control-group">
                <label class="control-label" style="text-align:left;" for="password-login">Password</label>
                <div class="controls">
                <input type="password" placeholder="Password" name="password-login"  id="password-login" required>
                </div>
                </div>
                <div class="control-group">
                <div class="controls">
                <a  href="#forgotPassword"   data-toggle="modal">Forgot Password</a>
                </div>
                </div>
                <div class="control-group">
                <div class="controls">  
                              
                <button type="submit" onClick="login();" class="btn">Sign in</button>
                </div>
                </div>
                </form>                                
            </div>
        </div>
        <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
        <div style="height:10px;"></div>     
        <div class="">        	
            <div class="col-sm-12">
            	<h1>Sign Up</h1>
                <p >If you don't have a member account simply fill in the below form and click sign up. <br>
                After signing up you will be directed through to checkout so you can purchase your goods.</p>
                <div style="height:10px;"></div> 
                <div class="alert alert-error" id="alert-register">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>Warning!</strong> You've already sign up. 
				</div>
                <div class="">        	
            	<div class="span6">
                <form class="form-horizontal" id="registerForm" name="registerForm" method="post" action="javascript:register();" autocomplete="off">
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="firstname">First Name *</label>
                        <div class="controls">
                            <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
                            
                        </div>
                        
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="lastname">Last Name *</label>
                        <div class="controls">
                            <input type="text" placeholder="Last Name" name="lastname"  id="lastname" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="email">Email *</label>
                        <div class="controls">
                            <input type="email" placeholder="Email" name="email"  id="email" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="password-register">Password *</label>
                        <div class="controls">
                            <input type="password" placeholder="Password" name="password-register"  id="password-register" required>
                        </div>
                    </div>
        			
                    
                    
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="mobile">Mobile *</label>
                        <div class="controls">
                            <input type="text" placeholder="Mobile" name="mobile"  id="mobile" required>
                        </div>
                    </div>
                     <div class="control-group">
                        <div class="controls">                                    
                            <button type="submit" class="btn">Sign Up</button>
                        </div>
                    </div>                   
                   
                </div>
                               
                
            	<div class="span6">
                <div class="form-horizontal" >                
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="address">Address *</label>
                        <div class="controls">
                            <input type="text" placeholder="Address" name="address"  id="address" required>
                        </div>
                    </div>
                    
        			
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="suburb">Suburb *</label>
                        <div class="controls">
                            <input type="text" placeholder="Suburb" name="suburb"  id="suburb" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="state">State</label>
                        <div class="controls">
                            <select class="selectpicker" name="state" id="state">
                        		<?php foreach($states as $st) { ?>
                        			<option value="<?=$st['id']?>" <?php if($st['name'] == "Victoria")  print ' selected="selected"'; ?>><?=$st['name']?></option>
                        		<?php } ?>                                
                        	</select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align:left;" for="postcode">Postcode *</label>
                        <div class="controls">
                            <input type="text" placeholder="Postcode" name="postcode"  id="postcode" required>
                        </div>
                    </div>
                    
                    
                </form>          
                </div>
                </div>                      
            </div>
        </div>

<!-- Modal -->
<div id="forgotPassword" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Forgot Password</h3>
</div>
<div class="modal-body">
<div class="alert alert-error" id="alert-forgot-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Warning!</strong> Wrong username. Please try again!.
</div>
<div class="alert alert-success" id="alert-forgot">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Your login details has been sent to your email address!.
</div>

<form name="addForm" method="post" action="javascript:forgot();">
    <p>Please enter your email address or your username and click the Send button, your password will be sent to your email address.</p>
    <p><input type="email" class="textfield rounded" id="email-forgot" name="email-forgot" required/></p>

</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button type="submit" class="btn btn-primary" >Send</button>
</form>
</div>
</div>	