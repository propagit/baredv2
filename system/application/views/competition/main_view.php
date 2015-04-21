<div class="container">
	<div style="height:20px;"></div>
    <div class="row-fluid">
   
        <div class="span8">
            <img src="<?=base_url();?>img/competition/competition-banner.jpg">
        </div>
        
        
       
        <div class="span4">
      	<form id="competition-form">	
            <div class="box">
            	<img src="<?=base_url();?>img/competition/header.jpg">
            </div>
            
            <div class="box form-wrap">
              <fieldset>
                <input placeholder="Your First Name" type="text" class="span12" name="firstname">
              </fieldset>
              
              <fieldset>
                <input placeholder="Your Surname" type="text" class="span12" name="lastname" >
              </fieldset>
              
              <fieldset>
                <input placeholder="Your Email" type="text" class="span12" name="email">
              </fieldset>
              
              <fieldset>
                <select class="span12" name="state">
                    <option value="" selected>Select State</option> 
                    <?php
                        foreach($states as $state){
                    ?>
                    <option value="<?=$state['name'];?>"><?=$state['name']?></option> 
                    <?php } ?>
                </select>
              </fieldset>
              
              <fieldset>
                <select class="span12" name="country">
                    <option value="">Select Country</option> 
                    <?php
                        foreach($countries as $country){
                    ?>
                    <option value="<?=$country['name'];?>" <?=strtolower($country['name']) == 'australia' ? 'selected="selected"' : '';?>><?=$country['name']?></option> 
                    <?php } ?>
                </select>
              </fieldset>
            
            </div>
            
            <div class="box">
            	<img src="<?=base_url();?>img/competition/more-chance.jpg">
            </div>
            
            <div class="box form-wrap friend-box">
              <fieldset>
                <input type="text" placeholder="Friend's Name" class="span12" name="friend_name[]">
              </fieldset>
              
              <fieldset>
                <input type="text" placeholder="Friend's Email" class="span12 friend-email" name="friend_email[]">
              </fieldset>
            </div>
            
            <div class="box center">
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
</div>
<script>

$j(function(){
	$j(document).on('focus','.friend-email',function(){
		if($j(this).parent().is(':last-child')){
			append_friend();	
		}
	});
	
	// submit form
	$j('#enter-competition').click(function(){
		enter_competition();
		//$j('#competition-form').submit();
	});
});

function append_friend(){
	var count = 1;
	var inc = 1;
	var friends = $j('.friend-email').length - 1;
	$j('.friend-email').each(function(){
		if($j(this).val()){
			count++;
		}
	});
	if(count >= friends){
		inc++;
		var html = '<div class="additional-friends"><fieldset><input type="text" placeholder="Friend\'s Name" class="span12" name="friend_name[]"></fieldset><fieldset><input type="text" placeholder="Friend\'s Email" class="span12 friend-email" name="friend_email[]"></fieldset></div>';
		$('.friend-box').append(html);
	}
}

function enter_competition(){
	$j.ajax({
		type: "POST",
		url: "<?=base_url();?>competition/enter_competition",
		data: $j('#competition-form').serialize(),
		dataType:"JSON",
		success: function(data){
			if(data['status'] == 'ok'){
			 	$j('#any_message_footer').html('<span class="text-success">You have successfully entered the competition.</span>');
				$j('#anyModalFooter').modal('show');
				
				// clear form and remove additional friend invite fields
				$j('.additional-friends').remove();
				$j('#competition-form')[0].reset();
			}else{
				$j('#any_message_footer').html('<span class="text-danger">'+data['msg']+'</span>');
				$j('#anyModalFooter').modal('show');
			}
		}
	});	
	
}

</script>