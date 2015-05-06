// JavaScript Document
// kaushtuvgurung@gmail.com

$(function(){
	 $('#goto-top').click(function(){
		$('html, body').animate({ scrollTop:0},300);
	 }); 
	 
	 
	 // to display the goto top button
	 $(window).scroll(function() {
		// use this when the goto top btn is on the lower right hand corner
		// check if scrolling has stopped, then perform scroll position check and fire animate
		// if scrolling check is not done the scroll position check will keep firing 
		// and the animate will mis fire giving buggy result
		/*clearTimeout($.data(this, 'scrollTimer')); 
		$.data(this, 'scrollTimer', setTimeout(function() {
			var scroll_top = $(document).scrollTop(); 
			if(scroll_top >= 200){
				$('#goto-top').animate({bottom:"25px"},500);	
			}else{
				$('#goto-top').animate({bottom:"-43px"},500);			
			}
    	}, 250));
		*/
		
		// when goto top btn is on the center
		// an offset value so that action is triggered 
		// after passing some distance from the footer
		var offset = 120; 
		
		var height = $(window).height();
		var scrollTop = $(window).scrollTop();
		var obj = $("#footer")
		var pos = obj.position();
		if (height + scrollTop - offset > pos.top) {
		   $('#goto-top').slideDown();
		}
		else {
		   $('#goto-top').slideUp();
		}

	 });// scroll
	 
	 $('.carousel[data-type="multi"] .item').each(function(){
		  var next = $(this).next();
		  if (!next.length) {
			next = $(this).siblings(':first');
		  }
		  next.children(':first-child').clone().appendTo($(this)).addClass('clone');
		  
		  for (var i=0;i<4;i++) {
			next=next.next();
			if (!next.length) {
				next = $(this).siblings(':first');
			}
			
			next.children(':first-child').clone().appendTo($(this)).addClass('clone');
		  }
	 });
	 
	 //carousel swipe
	 
	 
	 
}); // ready

var app = {
	
	swiper:function(selector){
		$(selector).swiperight(function() {  
      		$(selector).carousel('prev');  
		});  
		$(selector).swipeleft(function() {  
			$(selector).carousel('next');  
		});  
	}
	
		
};

