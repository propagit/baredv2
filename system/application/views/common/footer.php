
<footer>
	<div id="footer" class="app-container">
        <div class="container">
            <div id="goto-top"><i class="fa fa-angle-up"></i></div>
            
            	<h5>join us on</h5>
                <ul class="social-links">
                    <li><a href="<?=PINTEREST;?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                    <li><a href="<?=FACEBOOK;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="<?=INSTAGRAM;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                </ul>
                
                <div class="subscribe-box">
                    <h5>subscribe to our vip mailing list</h5>
                    <div class="form-group has-feedback col-xs-5 x-gutters">
                      <input type="text" class="form-control app-form-control" id="subscribe" placeholder="your email...">
                      <span class="form-control-feedback pointer susbcribe-btn"><i class="fa fa-envelope"></i></span>
                    </div>
                </div>
                
                <hr>
                
                <div class="col-sm-4">
                    <ul class="quick-links">
        				<li><h5>customer care</h5></li>
                        <li><a href="#">shipping information</a></li>
                        <li><a href="#">return &amp; exchanges</a></li>
                        <li><a href="#">payment security</a></li>
                        <li><a href="#">faq</a></li>
                        <li><a href="#">shoe care instructions</a></li>
                        <li><a href="#">promotion t&amp;c's</a></li>
                        <li><a href="#">competitions</a></li>
                    </ul>   
                </div>
                <div class="col-sm-4">
                    <ul class="quick-links">
        				<li><h5>fitting options</h5></li>
                        <li><a href="#">fitting options</a></li>
                        <li><a href="#">orthotics</a></li>
                        <li><a href="#">wide feet</a></li>
                        <li><a href="#">narrow feet</a></li>
                        <li><a href="#">orthotic friendly shoes</a></li>
                        <li><a href="#">size chart</a></li>
                    </ul>   
                </div>
                <div class="col-sm-4">
                    <ul class="quick-links">
        				<li><h5>your account</h5></li>
                        <li><a href="#">login</a></li>
                        <li><a href="#">shopping basket</a></li>
                        <li><a href="#">wish list</a></li>
                    </ul>  
                </div>
                
                <hr>
                <div class="col-sm-12">
                    <p class="disclaimer">
                        &copy; BARED PTY LTD,ABN 76 843 320 186 (Bared Trading Trust Owns & Operates The Website) 	<br>
                        1098 HIGH STREET ARMADALE VIC 3143 AUSTRALIA
                    </p> 
                </div>  
        </div>
    </div>
</footer>


<div class="modal fade" id="anyModalFooter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header x-border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
     <div class="modal-body mybody-modal">
    	<p id="any_message_footer" class="body-copy-Font"></p>
     </div>
     
    </div>
  </div>
</div>


<script>
$(function(){
	app.swiper('#instagram');
	app.swiper('#featured');
	app.swiper('#banners');
	app.swiper('#product-gallery');
	
	$('.susbcribe-btn').click(function(){
		subscribe();
	});
	
	
	
});

// old funcs
function subscribe()
{
	var email = $('#subscribe').val();
	if(email==''){ 
		jQuery('#any_message_footer').html('Please enter email address');
	  	jQuery('#anyModalFooter').modal('show');
		return false;
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
</body>
</html>