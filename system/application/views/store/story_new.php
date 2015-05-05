<script>
jQuery(function() {
	jQuery('.story_tt').tooltip({
			showURL: false
	});
	
	jQuery('.item').first().toggleClass("active");
	var id= jQuery('.item').first().attr("id");
	var n=id.split("#");			
	idstory = n[1];
	if(idstory==0)
	{
		jQuery('#cat1').toggleClass("active");
		jQuery('#cat2').hide();
		jQuery('#divider1').hide();
	}else
	{
		jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
		document.title = jQuery('#meta_title_story'+idstory).val();
		idori=jQuery('#idstory'+idstory).val();
		// jQuery('meta[name=description]').remove();
   	 	// jQuery('head').append( '<meta name="description" content="'+jQuery('#meta_desc_story'+idstory).val()+'">' );
   	 	jQuery("meta[name = 'description']").attr("content", jQuery('#meta_desc_story'+idstory).val());
		jQuery('#cat3').html(jQuery('#title_story_parent'+idstory).val()+ '<span class="divider"> > </span>');
		<? if($cat=='cat_all'){$cat_n='single_all';}else{$cat_n=$cat;}?>
		jQuery("a.story_class").attr("href", "<?=base_url()?>store/story_product_new/<?=$cat_n?>/"+idori);
		//jQuery('#cat2').html('aa');
		jQuery('#cat1').removeClass('active');
		jQuery('#cat2').removeClass('active');

		jQuery('#cat2').toggleClass("active");
		
		jQuery('#cat2').show();
		jQuery('#divider1').show();
	}
	jQuery('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= jQuery(this).attr("id");
			var n=id.split("#");
			idp=n[0].replace('id','');
			var ids = parseInt(idp);
			jQuery('.actt').html(ids);
			
		}
	});
	<?
	
	if($slide > -1)
	{
	?>
		jQuery('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			jQuery(this).removeClass('active');
		}
		});
		
		jQuery('.item').each(function () {			
			var id=jQuery(this).attr("id");
			var n=id.split("#");
			idp=n[1];			
			if(idp==<?=$slide?>)
			{
				jQuery(this).toggleClass("active");				
				idps=n[0].replace('id','');
				idstory = n[1];
				var ids = parseInt(idps);
				jQuery('.actt').html(ids);
				
				jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
				document.title = jQuery('#meta_title_story'+idstory).val();
				idori=jQuery('#idstory'+idstory).val();
				//jQuery('meta[name=description]').remove();
   	 			//jQuery('head').append( '<meta name="description" content="'+jQuery('#meta_desc_story'+idstory).val();+'">' );
   	 			jQuery("meta[name = 'description']").attr("content", jQuery('#meta_desc_story'+idstory).val());
				jQuery('#cat3').html(jQuery('#title_story_parent'+idstory).val()+ '<span class="divider"> > </span>');
				<? if($cat=='cat_all'){$cat_n='single_all';}else{$cat_n=$cat;}?>
				jQuery("a.story_class").attr("href", "<?=base_url()?>store/story_product_new/<?=$cat_n?>/"+idori);
				jQuery('#cat1').removeClass('active');
				jQuery('#cat2').removeClass('active');
		
				jQuery('#cat2').toggleClass("active");
				
				jQuery('#cat2').show();
				jQuery('#divider1').show();
			}
		});
		
	<? } ?>
	jQuery('[id^="myCarousel"]').carousel('pause');
});
function share_with_friend()
{
	
	jQuery('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= jQuery(this).attr("id");
			var n=id.split("#");
			idp=n[1];

			jQuery('#slide_id').val(idp);
			jQuery('#message').val(jQuery('#title_story'+idp).val());
			
		}
	});
	jQuery('#emailModal').modal('show');
}
function check_html()
{
	var idsp=1;
	jQuery('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= jQuery(this).attr("id");
			var n=id.split("#");
			idp=n[0].replace('id','');
			var ids = parseInt(idp)-1;
			
			if(ids==0){
				
				idsp=0;
				cat = '<?=$cat?>';
				if(cat=='single' || cat=='single_all' || cat=='cat_all' || cat=='latest season' || cat=='luggage' || cat=='archive'){
					ids=<?=count($pages_story)?>;
				}
				else
				{
					ids=<?=$index?>;
				}
			}
			jQuery('.actt').html(ids);
		}
	});
	
	if(idsp==1)
	{
		jQuery('.item').each(function () {
			if (jQuery(this).hasClass('active')) {								
				var id= jQuery(this).prev().attr("id");
				var n=id.split("#");			
				idstory = n[1];
				if(idstory==0)
				{
					jQuery('#cat1').toggleClass("active");
					jQuery('#cat2').hide();
					jQuery('#divider1').hide();
				}else
				{
					jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
					document.title = jQuery('#meta_title_story'+idstory).val();
					idori=jQuery('#idstory'+idstory).val();
					//jQuery('meta[name=description]').remove();
   	 				//jQuery('head').append( '<meta name="description" content="'+jQuery('#meta_desc_story'+idstory).val();+'">' );
   	 				jQuery("meta[name = 'description']").attr("content", jQuery('#meta_desc_story'+idstory).val());
					jQuery('#cat3').html(jQuery('#title_story_parent'+idstory).val()+ '<span class="divider"> > </span>');
					<? if($cat=='cat_all'){$cat_n='single_all';}else{$cat_n=$cat;}?>
					jQuery("a.story_class").attr("href", "<?=base_url()?>store/story_product_new/<?=$cat_n?>/"+idori);
					jQuery('#cat1').removeClass('active');
					jQuery('#cat2').removeClass('active');
			
					jQuery('#cat2').toggleClass("active");
					
					jQuery('#cat2').show();
					jQuery('#divider1').show();
				}
			}
		});
	}
	else{
		var id=jQuery('.item').last().attr("id");
		var n=id.split("#");			
		idstory = n[1];
		

		/*
		jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
		jQuery('#cat1').removeClass('active');
		jQuery('#cat2').removeClass('active');

		jQuery('#cat2').toggleClass("active");
		
		jQuery('#cat2').show();
		jQuery('#divider1').show();
		*/
		if(idstory==0)
		{
			jQuery('#cat1').toggleClass("active");
			jQuery('#cat2').hide();
			jQuery('#divider1').hide();
		}else
		{
			jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
			document.title = jQuery('#meta_title_story'+idstory).val();
			idori=jQuery('#idstory'+idstory).val();
			//jQuery('meta[name=description]').remove();
   	 		//jQuery('head').append( '<meta name="description" content="'+jQuery('#meta_desc_story'+idstory).val();+'">' );
   	 		jQuery("meta[name = 'description']").attr("content", jQuery('#meta_desc_story'+idstory).val());
			jQuery('#cat3').html(jQuery('#title_story_parent'+idstory).val()+ '<span class="divider"> > </span>');
			<? if($cat=='cat_all'){$cat_n='single_all';}else{$cat_n=$cat;}?>
			jQuery("a.story_class").attr("href", "<?=base_url()?>store/story_product_new/<?=$cat_n?>/"+idori);
			jQuery('#cat1').removeClass('active');
			jQuery('#cat2').removeClass('active');
	
			jQuery('#cat2').toggleClass("active");
			
			jQuery('#cat2').show();
			jQuery('#divider1').show();
		}
	}
	
}
function check_html_right()
{

	var idsp=1;
	jQuery('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= jQuery(this).attr("id");
			var n=id.split("#");			
			idp=n[0].replace('id','');
			var ids = parseInt(idp);
			ids=ids+1;

			cat = '<?=$cat?>';
			if(cat=='single' || cat=='single_all' || cat=='cat_all' || cat=='latest season' || cat=='luggage' || cat=='archive'){
				idsps=<?=count($pages_story)?>;
			}
			else
			{
				idsps=<?=$index?>;
			}

			if(ids > idsps){idsp=0;ids=1;}			
			jQuery('.actt').html(ids);			
		}
	});
	/*
	$('.item').each(function () {
		if (jQuery(this).hasClass('active')) {			
			var id= $(this).next().attr("id");
			var n=id.split("#");
			idstory = n[1];
			if(idstory==0)
			{
				jQuery('#cat1').toggleClass("active");
				jQuery('#cat2').hide();
				jQuery('#divider1').hide();
			}else
			{
				jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
				jQuery('#cat1').removeClass('active');
				jQuery('#cat2').removeClass('active');
				jQuery('#cat2').toggleClass("active");
				jQuery('#cat2').show();
				jQuery('#divider1').show();
			}
		}
	});
	*/
	if(idsp==1)
	{
		jQuery('.item').each(function () {
			if (jQuery(this).hasClass('active')) {								
				var id= jQuery(this).next().attr("id");
				var n=id.split("#");			
				idstory = n[1];
				if(idstory==0)
				{
					jQuery('#cat1').toggleClass("active");
					jQuery('#cat2').hide();
					jQuery('#divider1').hide();
				}else
				{
					jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
					document.title = jQuery('#meta_title_story'+idstory).val();
					idori=jQuery('#idstory'+idstory).val();
					//jQuery('meta[name=description]').remove();
   	 				//jQuery('head').append( '<meta name="description" content="'+jQuery('#meta_desc_story'+idstory).val();+'">' );
   	 				jQuery("meta[name = 'description']").attr("content", jQuery('#meta_desc_story'+idstory).val());
					jQuery('#cat3').html(jQuery('#title_story_parent'+idstory).val()+ '<span class="divider"> > </span>');
					<? if($cat=='cat_all'){$cat_n='single_all';}else{$cat_n=$cat;}?>
					jQuery("a.story_class").attr("href", "<?=base_url()?>store/story_product_new/<?=$cat_n?>/"+idori);
					jQuery('#cat1').removeClass('active');
					jQuery('#cat2').removeClass('active');
			
					jQuery('#cat2').toggleClass("active");
					
					jQuery('#cat2').show();
					jQuery('#divider1').show();
				}
			}
		});
	}
	else
	{
		var id=jQuery('.item').first().attr("id");
		var n=id.split("#");			
		idstory = n[1];
	

		if(idstory==0)
		{
			jQuery('#cat1').toggleClass("active");
			jQuery('#cat2').hide();
			jQuery('#divider1').hide();
		}else
		{
			jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
			document.title = jQuery('#meta_title_story'+idstory).val();
			idori=jQuery('#idstory'+idstory).val();
			//jQuery('meta[name=description]').remove();
   	 		//jQuery('head').append( '<meta name="description" content="'+jQuery('#meta_desc_story'+idstory).val();+'">' );
   	 		jQuery("meta[name = 'description']").attr("content", jQuery('#meta_desc_story'+idstory).val());
			jQuery('#cat3').html(jQuery('#title_story_parent'+idstory).val()+ '<span class="divider"> > </span>');
			<? if($cat=='cat_all'){$cat_n='single_all';}else{$cat_n=$cat;}?>
			jQuery("a.story_class").attr("href", "<?=base_url()?>store/story_product_new/<?=$cat_n?>/"+idori);
			jQuery('#cat1').removeClass('active');
			jQuery('#cat2').removeClass('active');
			jQuery('#cat2').toggleClass("active");
			jQuery('#cat2').show();
			jQuery('#divider1').show();
		}
		
		/*jQuery('#cat2').html(jQuery('#title_story'+idstory).val());
		jQuery('#cat1').removeClass('active');
		jQuery('#cat2').removeClass('active');

		jQuery('#cat2').toggleClass("active");
		
		jQuery('#cat2').show();
		jQuery('#divider1').show();*/
	}

}
</script> 
<style>
.thumbnails > li{
	margin-bottom:0px!important;
}

.thumbnails > ul{
	margin-bottom:0px!important;
}
a {
    color: #222;
    text-decoration: none;
	

}
a:hover, a:focus {
	color: #222;
    text-decoration: none;
	
	
}
.text-bagazine{
	text-align:center;
	font-size:48px;
	font-family: 'Parisienne', cursive;
}
[class^="icon-"], [class*=" icon-"]
{
	vertical-align:bottom!important;
}
@media (min-width: 1200px) {
.indi{
right:590px; top: 375px;
}
.span4 {
    width: 383px;
}
[class*="span"] {

    margin-left: 10px;
}
. [class*="span"]:first-child {
    margin-left: 30px;
}
.nav1{
	margin-left:36%;
}
#center_pointer { margin:0 auto; margin-left:30%; }
.all_s{margin-left: -10px;}
}

@media (min-width: 979px) and (max-width:1200px){
.indi{
right:444px; top: 360px;
}
.hidden-div{
	width:0px!important;
}
.span4 {
    width: 306px;
}
[class*="span"] {

    margin-left: 10px;
}
. [class*="span"]:first-child {
    margin-left: 20px;
}
.big-font{
	font-size:20px;
	line-height : 20px;
}
.nav1{
	margin-left:36%;
}
.text-bagazine{
	text-align:center;
	font-size:42px;
	font-family: 'Parisienne', cursive;
}
#center_pointer
{
	margin:0 auto; margin-left:28%;
}
.all_s{margin-left: -10px;}
}
@media (max-width: 979px) {
	.indi{
right:345px; top: 230px;
}
.nav1{
	margin-left:25%;
}
.text-bagazine{
	text-align:center;
	font-size:40px;
	font-family: 'Parisienne', cursive;
}
#center_pointer
{
	margin:0 auto; margin-left:7%;
}
.all_s{margin-left: 10px;}
}
@media (max-width: 767px) {
.indi{
right:46%; top: 70%;
}	
.span4{
	margin-top:10px;
}
.big-font{
	font-size:14px;
	line-height : 10px;
}
.nav1{
	margin-left:22%;
}
.text-bagazine{
	text-align:center;
	font-size:36px;
	font-family: 'Parisienne', cursive;
}
#center_pointer
{
	margin:0 auto; margin-left:18%;
}
.all_s{margin-left: 0px;}
}
@media (max-width: 480px) {
.indi{
right:63%; top: 42%;
}	
.span4{
	margin-top:10px;
}
.big-font{
	font-size:14px;
	line-height : 15px;
}
.nav1{
	margin-left:20%;
}
.text-bagazine{
	text-align:center;
	font-size:28px;
	font-family: 'Parisienne', cursive;
}
.all_s{margin-left: 0px;}
}	
.breadcrumb {
    background-color: transparent;
	padding-left:0px;
	font-size:12px;
	margin-bottom:0px!important;
	font-weight:600;
}
.breadcrumb > .active {
    color: #222222;
	font-weight:400;
}


.breadcrumb > li > .divider2 {
    color: #000000;
    padding: 0 5px;
}



</style>

<script>
//alert(navigator.userAgent + "<br>");

//Detect bser and write the corresponding name

var new_style = '';
if (navigator.userAgent.search("MSIE") >= 0){
    //alert('"MS Internet Explorer ');
    var position = navigator.userAgent.search("MSIE") + 5;
    var end = navigator.userAgent.search("; Windows");
    var version = navigator.userAgent.substring(position,end);
    if(version < 9)
    {
    	alert(version + '"');
    }
}
else if (navigator.userAgent.search("Chrome") >= 0){
	//alert('"Google Chrome ');// For some reason in the bser identification Chrome contains the word "Safari" so when detecting for Safari you need to include Not Chrome
	
	// new_style += '<style> ';
	// new_style += '.app-container {margin-top: 30px;} ';
	// new_style += 'body{margin-top:-65px;} ';
	// new_style += 'html{padding-top: 0px ! important;} ';
	// new_style += '</style>';
	
	new_style += '<style> ';
	new_style += '@media (min-width: 1200px) {';
	new_style += '';
	new_style += '#center_pointer { margin:0 auto; margin-left:15%; }';
	new_style += '';
	new_style += '}';
	new_style += '@media (min-width: 979px) and (max-width:1200px){';
	new_style += '';
	new_style += '#center_pointer { margin:0 auto; margin-left:12%; }';
	new_style += '';
	new_style += '}';
	new_style += '@media (max-width: 767px) {';
	new_style += '';
	new_style += '#center_pointer { margin:0 auto; margin-left:30%; }';
	new_style += '';
	new_style += '}';
	new_style += '@media (max-width: 480px) {';
	new_style += '';
	new_style += '#center_pointer { margin:0 auto; margin-left:30%; }';
	new_style += '';
	new_style += '}';
	new_style += '</style>';
	
	document.write(new_style);
    
}
else if (navigator.userAgent.search("Firefox") >= 0){
    //alert('"Mozilla Firefox ');
    
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0){//<< Here
    //alert('"Apple Safari ');
    
   new_style += '<style> ';
	//new_style += '.lshop{margin-left: 1.5em;} ';
	//new_style += '.lwish{margin-left: 0.8em;} ';
	new_style += '</style>';
	
	document.write(new_style);
}
else if (navigator.userAgent.search("Opera") >= 0){
    //alert('"Opera ');
    
}
else{
    //alert('"Other"');
}

</script>

	<div class="app-container">
		<div style="height: 10px;"></div>
        <ul class="breadcrumb" style="font-size: 11px; text-transform: uppercase">
        		<!-- <?=$cat?> -->
			    <li><a href="<?=base_url()?>">HOME</a> <span class="divider">></span></li>
                
                <? if($cat!='all' && $cat!='single_all'){
					if($cat=='single')
					{?>
						<!--<li class="active" id="cat1"> <?=$story_single['title']?>  <span class="divider" id="divider1" style="display:none;">></span></li>	
                        <li id="cat2"></li>-->
                        <li><a href="<?=base_url()?>store/stories_new/all">THE BAGAZINE</a> <span class="divider">></span></li>
                    	<li id="cat1"><a href="<?=base_url()?>store/stories_new/single/<?=$story_single['id']?>"><?=$story_single['title']?> </a> </li>
					<?
                    }else{
					?>
                    <? if($cat=='whats happening'){$cats="What's Happening";}else{$cats=$cat;}?>
                    <? if($cat=='cat_all'){$cats=strtolower($story_single['category']);}else{$cats=$cat;}?>
                    <li id="cat1"><a href="<?=base_url()?>store/stories_new/<?=$cats?>"><?=$cats?></a><span class="divider" id="divider1" style="display:none;">></span></li>
                	<li id="cat2"></li>
                    <? } ?>
				<? } else{
						if($cat=='single_all'){ ?>
						
                    	<li id="cat1"><a href="<?=base_url()?>store/stories_new/all">THE BAGAZINE</a> <span class="divider" id="divider1" style="display:none;">></span></li>
                    	<li id="cat3"><?=$story_parent['title']?><span class="divider"> > </span></li> 
                    	<li id="cat2" style="font-weight: 400"><?=$story_single['title']?></li>          	
						
				<?		}else{
				?>
                    
                    	<li><a href="<?=base_url()?>store/stories_new/all">THE BAGAZINE</a> <span class="divider">></span></li>
                    	<li id="cat1"><a href="<?=base_url()?>store/stories_new/all">LATEST ISSUE</a> <span class="divider" id="divider1" style="display:none;">></span></li>
                    	<li id="cat2"></li>          
                        <? } ?>          
                <? } ?>
        </ul>
        <div style="height: 10px;"></div>
        <? if($cat!='all' && $cat!='single' && $cat!='single_all'){?>
       
        <div class="text-bagazine" style="text-transform:capitalize;"><?=$cats?></div>			
        <? } else if($cat=='single'){ ?>
        <div class="text-bagazine" style="text-transform:capitalize;"><?=$story_single['title']?></div>			
		<? } else{ ?>
        <div class="text-bagazine">The Bagazine</div>		
        <? }?>
        <div style="height: 50px;"></div>
		<div class="">
			<div class="col-sm-12" style="background:#fafafa;">
				<div id="myCarousel2" class="carousel slide" style="padding:10px;">                    
                    <div class="carousel-inner">
                        <? 	$i=1;
						
							$k=1;
							$j=1;
							
							foreach($stories as $st){  								
								$data_story[$k][]=$st['id'];
								if($j % 9 == 0){$k++;}
								$j++;
							}							
							
						if(strtoupper($cat)!='LATEST SEASON' && strtoupper($cat)!='LUGGAGE' && strtoupper($cat)!='ARCHIVE' && strtoupper($cat)!='SINGLE' && strtoupper($cat)!='SINGLE_ALL' && strtoupper($cat)!='CAT_ALL'){
												
                        for($m=1; $m<=$k; $m++)
						{
						?>
						<div class="item" id="id<?=$i?>#0">

						<div class="">
                            <div class="col-sm-12" style="background:#fafafa;">
                               <div class=" all_s">
                               <div class="col-sm-12">
								<div style="height:8px; clear:both"></div>
							   <? 
							   $now=1;
							   foreach($data_story[$m] as $st){  
							    if($st==-1){$str['title']='Lookbook';$pr_image=NULL;}
								else
								{
									$str=$this->System_model->get_story_id($st);
									$pr_image = $this->System_model->check_image($st,'tile'); 
								}
							   	if($now == 4){echo '</div>';$now = 1;}
								
							   	if($now == 1){   ?> 
                                		<div style="height:20px; clear:both"></div>
                                        <div class="" >                                                                                                         
                                        
                                        <div class="span4" style="margin-left:0px!important;">
                                            <div style="text-align: center;">                                            	
                                                <? if($cat=='all'){ 
                                                	if($st==-1){?> <a href="<?=base_url()?>store/stories_new/latest season">  <? }else{?> 
                                                    <a href="<?=base_url()?>store/stories_new/single_all/<?=$st?>">
                                                    <? }?>
                                                <? } else { ?>
                                                
                                                <a href="<?=base_url()?>store/stories_new/cat_all/<?=$st?>"> 
                                                <? } ?>
                                                	<? if($pr_image){?>
                                                    	<img alt="" src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$st)?>/<?=$pr_image['name']?>" style="width:65%;" />
                                                    <? }else{ ?>
                                                    	<img src="http://placehold.it/710x449/000000/000000" alt="" style="width:65%;" />
                                                    <? } ?>
                                                </a>                                                                                            	
                                                <? if($cat=='all'){ ?>
                                                <a href="<?=base_url()?>store/stories_new/single_all/<?=$st?>">
                                                <? } else {?> 
                                                <a href="<?=base_url()?>store/stories_new/cat_all/<?=$st?>"> 
												<? }?>
                                                <div style="margin-top:10px;font-family: buenard;    font-size: 14px;    text-align: center;font-weight:600;"><?=$str['title']?></div></a>
                                            </div>
                                        </div>  
                                <? }                                                                                                            
                                
                                if($now == 2){   ?>                                                                                                           
                                        <div class="span4" style="margin-left:0px!important;">
                                            <div style="text-align: center;">
                                            	
                                                <? if($cat=='all'){ 
                                                if($st==-1){?> <a href="<?=base_url()?>store/stories_new/latest season">  <? }else{?> 
                                                    <a href="<?=base_url()?>store/stories_new/single_all/<?=$st?>">
                                                    <? }?>
                                                <? } else {?> 
                                                <a href="<?=base_url()?>store/stories_new/cat_all/<?=$st?>"> 
												<? }?>
                                                	<? if($pr_image){?>
                                                    	<img alt="" src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$st)?>/<?=$pr_image['name']?>" style="width:65%;" />
                                                    <? }else{ ?>
                                                    	<img src="http://placehold.it/710x449/000000/000000" alt="" style="width:65%;" />
                                                    <? } ?>
                                                </a> 
                                            	<? if($cat=='all'){ ?>
                                                <a href="<?=base_url()?>store/stories_new/single_all/<?=$st?>">
                                                <? } else {?> 
                                                <a href="<?=base_url()?>store/stories_new/cat_all/<?=$st?>"> 
												<? }?>
                                                <div style="margin-top:10px;font-family: buenard;    font-size: 14px;    text-align: center;font-weight:600;"><?=$str['title']?></div></a>
                                            </div>                                            
                                        </div>  
                                <? }                                                                                                           
                                if($now == 3){   ?>                                                                                                           
                                        <div class="span4" style="float:left;margin-left:0px!important;">
                                            <div style="text-align: center;">
                                            	<!--<div style="color:#fff; font-family: 'open sans';    font-size: 16px;    font-weight: 400; top:60px; position:relative;"><?=$st['category']?></div>-->
                                                <? if($cat=='all'){ 
                                                if($st==-1){?> <a href="<?=base_url()?>store/stories_new/latest season">  <? }else{?> 
                                                    <a href="<?=base_url()?>store/stories_new/single_all/<?=$st?>">
                                                    <? }?>
                                                <? } else {?> 
                                                <a href="<?=base_url()?>store/stories_new/cat_all/<?=$st?>"> 
												<? }?>
                                                	<? if($pr_image){?>
                                                    	<img alt="" src="<?=base_url()?>uploads/stories/tiles/<?=md5('tile'.$st)?>/<?=$pr_image['name']?>" style="width:65%;" />
                                                    <? }else{ ?>
                                                    	<img src="http://placehold.it/710x449/000000/000000" alt="" style="width:65%;" />
                                                    <? } ?>
                                                </a> 
                                            	<? if($cat=='all'){ ?>
                                                <a href="<?=base_url()?>store/stories_new/single_all/<?=$st?>">
                                                <? } else {?> 
                                                <a href="<?=base_url()?>store/stories_new/cat_all/<?=$st?>"> 
												<? }?><div style="margin-top:10px;font-family: buenard;    font-size: 14px;    text-align: center;font-weight:600;"><?=$str['title']?></div></a>
                                            </div>                                            
                                        </div>  
                                   		
                                <? }                                                                                                             
                                $now++;
                                } 
									if($now-1 % 3 > 0){echo '</div>';}
								?>
                            	</div>
                                <div style="height:8px; clear:both"></div>
                                </div>
                            </div>                         
                        </div>
                        </div>
                        
						<?
						$i++;
						}
						}
						if($cat=='single'||$cat=='single_all' ||$cat=='cat_all' || $cat=='latest season' || $cat=='luggage' || $cat=='archive'){
							foreach($pages_story as $story_html){?>
								
								<div class="item" id="id<?=$i?>#<?=$story_html['id']?>">
									<? $s_parent = $this->System_model->get_story_id($story_html['story_id']);?>
                                    <input type="hidden" id="title_story<?=$story_html['id']?>" value="<?=$story_html['title']?>" />
                                    <input type="hidden" id="title_story_parent<?=$story_html['id']?>" value="<?=$s_parent['title']?>" />
                                    <input type="hidden" id="idstory<?=$story_html['id']?>" value="<?=$story_html['story_id']?>" />
                                    <?php
                                    if($story_html['meta_title'])
									{
										$m_title = $story_html['meta_title'];
									}
									else 
									{
										$m_title = 'Spencer & Rutherford Stories';
									}
									
									if($story_html['meta_description'])
									{
										$m_desc = $story_html['meta_description'];
									}
									else 
									{
										$m_desc = 'Spencer & Rutherford Stories';
									}
                                    ?>
                                    <input type="hidden" id="meta_title_story<?=$story_html['id']?>" value="<?=$m_title?>" />
                                    <input type="hidden" id="meta_desc_story<?=$story_html['id']?>" value="<?=$m_desc?>" />
									<div class="">
										<div class="col-sm-12" style="background:#cdcdcd;">
											<?=$story_html['content']?>                               
										</div>
									</div>
								</div>                            
							<? 
							$i++; 
							}
							
						}
						?>                               
                    </div>
                    
                    <div style="clear:both"></div>
                    
                    <a class="left carousel-control" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1" onclick="check_html()">
						<img src="<?=base_url()?>img/white-left-ar.png"/>
					</a>
					<a class="right carousel-control" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1" onclick="check_html_right()">
						<img src="<?=base_url()?>img/white-right-ar.png"/>
					</a>
				</div>
                <div style="height: 20px;"></div>
                <div style="float:none">
                
                 <? if($cat=='single'||$cat=='single_all' ||$cat=='cat_all' || $cat=='latest season' || $cat=='luggage' || $cat=='archive'){$num=count($pages_story);}
				else{$num=$index;} 
				?>
                
                <!--
                <ul class="breadcrumb" style="margin-left:20px;font-size: 11px; text-transform: uppercase; float:left;"> 
                	<li><a href="<?=base_url()?>store/stories_archive">ARCHIVE</a> <span class="divider2"> | </span></li>
                    <li><a href="<?=base_url()?>store/stories_new/all">INDEX</a> </li>
                </ul>
                <ul class="breadcrumb" style="float:left;margin-left:35%;" id="nav1">
                    <li>
                    	<a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html()">
                    		<i class="icon icon-angle-left icon-2x" style="line-height:10px!important;"></i>
                		</a>
                	</li>
                    <li><div style="font-size: 11px; "><span id="act"></span> / <?=$num?></div></li>
                    <li><a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html_right()">
                    	<i class="icon icon-angle-right icon-2x" style="line-height:10px!important;"></i>
                		</a>  
                    </li>
                 </ul>
                 <ul class="breadcrumb" style="float:right;margin-right:10px;">
                    <li ><a href="#" onclick="share_with_friend();"> <i style="color:#a6a4a5; line-height:15px; " class="icon-envelope-alt icon-2x"></i></a> <span class="divider2" style="vertical-align:top;"> | </span></li>
                    <li><a href="<?=base_url()?>store/story_product_new/<?=$cat?>/<?=$id?>"> <img alt="" src="<?=base_url()?>img/icon_shopping_bag.png"  style="margin-top:-5px; vertical-align:top!important;"></a> </li>
				</ul>                                                                                           
                -->
                <table class="hidden-xs" width="100%" style="font-size: 11px; text-transform: uppercase;font-weight:600; " align="center">
                	<tr>
                		<td style="width: 33.5%; text-align: left;" >
                			<? if($cat=='all' || $cat=='single_all'){?>
                            <a class="hidden-xs" style="margin-left:20px" href="<?=base_url()?>store/stories_archive">ARCHIVE</a> 
                			<!-- <a class="visible-xs" style="margin-left:20px; font-size: 7px;" href="<?=base_url()?>store/stories_archive">ARCHIVE</a> --> 
                			<span class="divider2 hidden-xs" style="font-size:22px; margin-left:8px; margin-right:3px; font-weight:lighter!important;"> | </span>
                            <? } ?>
                			<!-- <span class="divider2 visible-xs" style="font-size:12px; margin-left:8px; margin-right:3px; font-weight:lighter!important;"> | </span> -->
                            <? if($cat=='all' || $cat=='single_all'){?>
                            <a class="hidden-xs" href="<?=base_url()?>store/stories_new/all">INDEX</a>
                            <? }else{?>
                            <a class="hidden-xs" href="<?=base_url()?>store/stories_new/<?=$cats?>">INDEX</a>
                            <? } ?>
                			
                			<!-- <a class="visible-xs" style="font-size: 7px;" href="<?=base_url()?>store/stories_new/all">INDEX</a> -->
                		</td>
                		<td style="width: 33%; text-align: center; line-height: 11px">
                			<a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;" onclick="check_html()">
                    			<i class="icon icon-angle-left icon-2x" style="line-height:10px!important;"></i>
                			</a>
                            <span class="actt"></span> / <?=$num?>
                            <a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;" onclick="check_html_right()">
                            	<i class="icon icon-angle-right icon-2x" style="line-height:10px!important;"></i>
                            </a>
                		</td>
                		
                		<td style="width: 33.5%; text-align: right">
                			<a href="#" onclick="share_with_friend();">
	                			<img class="hidden-xs story_tt" data-toggle="tooltip" title="SEND TO A FRIEND" src="<?=base_url()?>img/envelope.png"  alt="">
	                			<!-- <img class="visible-xs" src="<?=base_url()?>img/envelope.png"  alt="" style=""> -->
                            </a> 
                        	<span class="divider2 hidden-xs" style="vertical-align:top; font-size:22px; margin-left:8px; margin-right:3px;font-weight:lighter!important;"> | </span>
                        	<!-- <span class="divider2 visible-xs" style="vertical-align:top; font-size:12px; margin-left:8px; margin-right:3px;font-weight:lighter!important;"> | </span> -->
                            <a class="story_class" style="margin-left: 3px" href="<?=base_url()?>store/story_product_new/<?=$cat?>/<?=$id?>"> 
                            	<img class="hidden-xs story_tt" data-toggle="tooltip" title="SHOP THE BAGAZINE" src="<?=base_url()?>img/icon_shopping_bag.png" style="margin-bottom:4px;margin-right:20px;" alt="" >
                            	<!-- <img class="visible-xs" src="<?=base_url()?>img/icon_shopping_bag.png" style="margin-bottom:4px;margin-right:20px;" alt="" > -->
                            </a>
                		</td>
                		
                		
                	</tr>
                </table>
                
                <div class="visible-xs" style="padding-left:5%; padding-right: 5%; width:90%">
                	
                    <div style="float: left; width: 33.5%; text-align: left; font-size: 9px; line-height:20px;">
                		<? if($cat=='all' || $cat=='single_all'){?> <a  href="<?=base_url()?>store/stories_archive">ARCHIVE</a> | <? } ?> 
                        <? if($cat=='all' || $cat=='single_all'){?>
                        <a href="<?=base_url()?>store/stories_new/all">INDEX</a>
                        <? }else{?>
                        <a href="<?=base_url()?>store/stories_new/<?=$cats?>">INDEX</a>
                        <? } ?>
                	</div>
                	<div style="float: left; width: 33%; text-align: center; font-size: 9px;">
                		<a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;" onclick="check_html()">
                			<i class="icon icon-angle-left icon-2x" style=""></i>
            			</a>
            			&nbsp;
                        <span class="actt"></span> / <?=trim($num)?>
                        &nbsp;
                        <a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;" onclick="check_html_right()">
                        	<i class="icon icon-angle-right icon-2x" style=""></i>
                        </a>
                	</div>
                	<div style="float: left; width: 33.5%; text-align: right; font-size: 9px;">
                		<a style="padding-right: 2px; border-right: 1px solid #222" href="#" onclick="share_with_friend();">
                			<img class=" story_tt" data-toggle="tooltip" title="SEND TO A FRIEND" src="<?=base_url()?>img/envelope.png"  alt="">
                			<!-- <img class="visible-xs" src="<?=base_url()?>img/envelope.png"  alt="" style=""> -->
                        </a>
                		<a class="story_class" style="margin-left: 3px" href="<?=base_url()?>store/story_product_new/<?=$cat?>/<?=$id?>"> 
                        	<img class="story_tt" data-toggle="tooltip" title="SHOP THE BAGAZINE" src="<?=base_url()?>img/icon_shopping_bag.png" alt="" style="margin-top:-5px!important;">
                        	<!-- <img class="visible-xs" src="<?=base_url()?>img/icon_shopping_bag.png" style="margin-bottom:4px;margin-right:20px;" alt="" > -->
                        </a>
                	</div>
                	<div style="clear: both">
                	</div>
                </div>
                
                
                <!-- <table width="100%" style="font-size: 11px; text-transform: uppercase;font-weight:600; " align="center">
                	<tr>
                    	<td><a style="margin-left:20px" href="<?=base_url()?>store/stories_archive">ARCHIVE</a> <span class="divider2" style="font-size:22px; margin-left:8px; margin-right:3px; font-weight:lighter!important;"> | </span><a href="<?=base_url()?>store/stories_new/all">INDEX</a></td>
                        
                        
                        <td align="center">
                        	
                            <div id="center_pointer">
                            <a class="left" data-slide="prev" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html()">
                    			<i class="icon icon-angle-left icon-2x" style="line-height:10px!important;"></i>
                			</a>
                            <div style="float:left;line-height:12px; margin-left:10px; margin-right:10px;"><span id="act"></span> / <?=$num?></div>
                            <a class="right" data-slide="next" href="#myCarousel2" style="background: none; border: none; opacity: 1;float:left;" onclick="check_html_right()">
                            	<i class="icon icon-angle-right icon-2x" style="line-height:10px!important;"></i>
                            </a>
                            </div>
                            
                        </td>
                        
                        <td align="right" valign="middle" ><a href="#" onclick="share_with_friend();"> 
                        	
                            <img src="<?=base_url()?>img/envelope.png"  alt="">
                            </a> 
                        	<span class="divider2" style="vertical-align:top; font-size:22px; margin-left:8px; margin-right:3px;font-weight:lighter!important;"> | </span>
                            <a href="<?=base_url()?>store/story_product_new/<?=$cat?>/<?=$id?>"> <img src="<?=base_url()?>img/icon_shopping_bag.png" style="margin-bottom:4px;margin-right:20px;" alt="" ></a>
                        </td>
                        
                    </tr>
                </table> -->
                </div> 
                <div style="clear:both;height:10px;"></div>                                             
			</div>
		</div>
        <div style="clear:both;height:20px;"></div>                                             
		
<div id="emailModal" class="modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="mytop-modal" onclick="jQuery('#emailModal').modal('hide');">
    <img src="<?=base_url()?>img/close_sign.png" alt=""/>
</div>
<form method="post" action="<?=base_url()?>store/send_friend_email_story">
<input type="hidden" name="story_id" value="<?=$id?>">
<input type="hidden" name="cat" value="<?=$cat?>">
<input type="hidden" id="slide_id" name="slide_id" value="">
<input type="hidden" id="url" name="url" value="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>">
<div class="modal-body mybody-modal-left">
    <table>
        <tr>
            <td style="width: 150px; height: 30px; line-height: 30px; vertical-align: top">Recipient Name</td>
            <td><input type="text" name="friend_name"/></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Recipient Email</td>
            <td><input type="email" name="friend_email" required /></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Your Name</td>
            <td><input type="text" name="name"/></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Your Email</td>
            <td><input type="email" name="email" required /></td>
        </tr>
        <tr>
            <td style="height: 30px; line-height: 30px; vertical-align: top">Message</td>
            <td><textarea id="message" name="message"><?=$story_single['title']?></textarea></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td>
            	<button class="btn btn-primary" aria-hidden="true" type="submit">Send</button>
            </td>
        </tr>
    </table>

</div>
</form>
</div>
        
   