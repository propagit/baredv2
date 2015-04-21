<div class="container">	
<style>
.fb_edge_widget_with_comment span.fb_edge_comment_widget iframe.fb_ltr {
    display: none !important;
}
</style>	
	
	

<!-- for share -->
<div id='fb-root'></div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src='http://connect.facebook.net/en_US/all.js'></script>

<a id="link" href="#">Post to Feed</a>

<script>
FB.init({appId: "575168212545030", status: true, cookie: true}); //You'll need to insert your appId.

$('#link').click(function(){
    FB.ui(
    {
        method: 'feed',
        name: 'Facebook Dialogs',
        link: '<?=base_url()?>',
        picture: 'http://fbrell.com/f8.jpg',
        caption: 'Reference Documentation',
        description: 'Dialogs provide a simple, consistent interface for applications to interface with users.'
    },
    function(response) {
        if (response && response.post_id) {
          window.location = "http://www.google.com"
      } else {
          // Do something else here if they do not post.
      }
    });
    return false;
});
</script>

<!-- // for share -->

<div id="fb-root"></div>



<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({appId: '575168212545030', status: true, cookie: true, xfbml: true});
        //FB.Canvas.setSize({ width: 520, height: 1500 });
        FB.Event.subscribe('edge.create',
            function(response) {
                //alert('like!');
                // put redirect code here eg
                //window.location = "http://www.google.com"; 
            }
        );
    };

    //Load the SDK asynchronously
    (function() {
        var e = document.createElement('script'); e.async = true;
            e.src = document.location.protocol +
              '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
    }());
</script>
<fb:like href="<?=base_url()?>" send="false" width="450" show_faces="false" font=""></fb:like>

    <div>123</div>
    
    
    
    
	
	<div style="height: 30px;"></div>

		
        
   