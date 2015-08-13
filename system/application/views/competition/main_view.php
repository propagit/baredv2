<div class="app-container competition">
	<div style="height:20px;"></div>
		
        <div class="col-xs-12 x-gutters img-wrap" style="margin-bottom:15px;">
        	<img src="<?=base_url();?>img/competition/2015/competition-header.jpg">
        </div>
   	
        <div class="col-sm-8 col-xs-12 img-wrap x-gutters">
            <img src="<?=base_url();?>img/competition/2015/winter-clearance.jpg">
        </div>
        
        
       
        <div class="col-sm-4 col-xs-12 x-r-gutter competition-form-wrap">
      	<form id="competition-form">	
            <div class="box img-wrap">
            	<img src="<?=base_url();?>img/competition/header.jpg">
            </div>
            
            <div class="box form-wrap col-xs-12">
              <div class="form-group">
                <input placeholder="Your First Name" type="text" class="form-control" name="firstname">
              </div>
              
              <div class="form-group">
                <input placeholder="Your Surname" type="text" class="form-control" name="lastname" >
              </div>
              <div class="form-group">
                <input placeholder="Your Email" type="text" class="form-control" name="email">
              </div>
              <div class="form-group">
                <select class="form-control" name="state">
                    <option value="" selected>Select State</option> 
                    <?php
                        foreach($states as $state){
                    ?>
                    <option value="<?=$state['name'];?>"><?=$state['name']?></option> 
                    <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="country">
                    <option value="">Select Country</option> 
                    <?php
                        foreach($countries as $country){
                    ?>
                    <option value="<?=$country['name'];?>" <?=strtolower($country['name']) == 'australia' ? 'selected="selected"' : '';?>><?=$country['name']?></option> 
                    <?php } ?>
                </select>
              </div>
            
            </div>
            
            <div class="box img-wrap">
            	<img src="<?=base_url();?>img/competition/more-chance.jpg">
            </div>
            
            <div class="box form-wrap friend-box col-xs-12">
           	  <div class="form-group">
                <input type="text" placeholder="Friend's Name" class="form-control" name="friend_name[]">
              </div>
              <div class="form-group">
                <input type="text" placeholder="Friend's Email" class="form-control friend-email" name="friend_email[]">
              </div>
            </div>
            
            <div class="box center img-wrap">
            	<img class="btn-competition" id="enter-competition" src="<?=base_url();?>img/competition/enter-btn.jpg">
                <p class="competition-tems">
                	By entering you agree to competition<br>
                    <a href="<?=base_url()?>page/Competition-Guidelines"><span class="footer-menu footer-menu-Font">TERMS & CONDITIONS</span></a>
                </p>
            </div>
            <input name="token" type="hidden" value="<?=$token ? $token : '';?>">
        </form>    
        </div>

</div>
<script>

$(function(){
	$(document).on('focus','.friend-email',function(){
		if($(this).parent().is(':last-child')){
			append_friend();	
		}
	});
	
	// submit form
	$('#enter-competition').click(function(){
		enter_competition();
		//$('#competition-form').submit();
	});
});

function append_friend(){
	var count = 1;
	var inc = 1;
	var friends = $('.friend-email').length - 1;
	$('.friend-email').each(function(){
		if($(this).val()){
			count++;
		}
	});
	if(count >= friends){
		inc++;
		var html = '<div class="additional-friends"><div class="form-group"><input type="text" placeholder="Friend\'s Name" class="form-control" name="friend_name[]"></div><div class="form-group"><input type="text" placeholder="Friend\'s Email" class="form-control friend-email" name="friend_email[]"></div></div>';
		$('.friend-box').append(html);
	}
}

function enter_competition(){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>competition/enter_competition",
		data: $('#competition-form').serialize(),
		dataType:"JSON",
		success: function(data){
			if(data['status'] == 'ok'){
			 	$('#any_message_footer').html('<span class="text-success">You have successfully entered the competition.</span>');
				$('#anyModalFooter').modal('show');
				
				// clear form and remove additional friend invite fields
				$('.additional-friends').remove();
				$('#competition-form')[0].reset();
			}else{
				$('#any_message_footer').html('<span class="text-danger">'+data['msg']+'</span>');
				$('#anyModalFooter').modal('show');
			}
		}
	});	
	
}

</script>