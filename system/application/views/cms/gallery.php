<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"></link>
<!--<script  src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
			<script src="http://code.jquery.com/ui/1.8.23/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" media="screen" />

<script>

/*$j(function() {
	$j('.gallery-thumb *').tooltip({
		showURL: false
	});
	
});
function delete_photo(id)
{
	if (confirm('Are you sure you want to do this?')) {
		var url = "<?=base_url()?>admin/cms/delete_photo/";
		url = url + id;
		window.location = url;
	} else {
		return false;
	}
}*/



var imgOrder = '';

$(function() {
  $('.img_display').lightBox();
    
  $("#sortable").sortable({
    update: function(event, ui) {
      imgOrder = $("#sortable").sortable('toArray').toString();
	  $("#textorder").val(imgOrder);
       document.orderimage.submit(); 
    }
  });
  $("#sortable").disableSelection();
  
  <?
  /*if($this->session->flashdata('update')==true)
  {
    ?>
    alert('Order has been updated');
    <? 
  }     
  ?>
  
  <?
  if($this->session->flashdata('warning')==true)
  {
    ?>
    alert('There is no order has been changed');
    <? 
  } */    
  ?>
  
});

$(document).ready(function(){
  $("#btnshoworder").click(function(){
      $("#textorder").val(imgOrder);
       document.orderimage.submit();  
       //alert('Order has been updated');
    
  });
});

/*function delete_photo(id)
{
    if (confirm('Are you sure you want to do this?')) {
        var url = "<?=base_url()?>admin/cms/delete_photo/";
        url = url + id;
        window.location = url;
    } else {
        return false;
    }
}*/
</script>
<style>
  
  #reorder-gallery {width:600px; padding:0px; border:1px solid #eee; margin-top:20px;}
  #order-buttons {background-color:#eee; padding:10px;}
  #sortable { list-style-type: none; margin: 0; padding: 0; }
  #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 150px; height: 230px; font-size: 12px; text-align: center; }
  #sortable li img {padding:1px; cursor: pointer; width:138px; height:112px;}
  
  .ui-state-default, .ui-widget-content .ui-state-default{border:none; background:none;}
  
  .clear {clear:both;}
</style>



	<div class="left">
        	<h1>Store Management</h1>
            <div class="bar">

            	<div class="text"> <div class="bar-title"><div>Add image to <?=$gallery['title']?></div></div></div>
            	<div class="cr"></div>
            </div>
            <!--<hr />-->
            <script>
			function delete_photo(id)
			{
				if (confirm('Are you sure you want to do this?')) {
					var url = "<?=base_url()?>admin/cms/delete_photo/";
					url = url + id;
					//alert(url);
					window.location = url;
				} else {
					return false;
				}
			}
			</script>
            <div class="box">
            	<?php $pid = $this->session->flashdata('addphoto_id');
		//$src = $this->session->flashdata('addphoto_src');
		
        
        if ($pid) 
		{ 
		?> 
        <p>The image has been uploaded successfully!</p>
         <?
		}
		?>
        <form name="addPhotoForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_photo">
        <?php
			if ($this->session->flashdata('error_addphoto')) 
			{
				print $this->session->flashdata('error_addphoto');
			}
		?>
        <input type="hidden" name="gallery_id" value="<?=$gallery['id']?>" />
     
		<p><input type="file" name="userfile" /> <? if($gallery['id'] != 4) {?>(Max width is 2000px and max height is 2000px) <? } else { echo 'The image uploaded for this gallery will not be resized';} ?></p>
           <br />
        <a href="#"><input type="button" class="button rounded" value="Add Image" onClick="document.addPhotoForm.submit()" /></a>
        </form>
        <div style="clear:both; height:20px;"></div>
        <script>
		function link_change()
		{
			var ori = $('#youtube_link').val();
			var len = ori.length;
			//alert(ori);
			//alert(len);
			var backtext = ori.substr(ori.indexOf('src="')+5,len - ori.indexOf('src="'));
			//alert(backtext);
			var len_back = backtext.length;
			var middle = backtext.substr(0,backtext.indexOf('"'));
			//alert(middle);
			
			var text_link = '<iframe width="196" height="144" src="' + middle + '" frameborder="0" allowfullscreen></iframe>';
			//alert(text_link);
			$('#youtube_preview').html(text_link);
		} 
		</script>
        <form name="addVideoForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>admin/cms/add_video">
        	<table>
            	<tbody>
                	<tr>
                    	<td><textarea id="youtube_link" style="width:250px; height:150px;" name="link" onchange="link_change();"></textarea></td>
                        <td valign="top" style="font-size:10px; "><div id="youtube_preview">(Please insert the new embed style of your youtube video)</div></td>
                    </tr>
                </tbody>
            </table>
        	
            <input  type="hidden" name="gallery_id" value="<?=$gallery['id']?>" />
            <a href="#"><input type="button" class="button rounded" value="Add Video" onClick="document.addVideoForm.submit()" /></a>
        </form>
        <!--
        <form name="addVideoForm" method="post"  action="<?=base_url()?>admin/cms/add_video">
        <?php
			if ($this->session->flashdata('error_addpvideo')) 
			{
				print $this->session->flashdata('error_addvideo');
			}
		?>
        <input type="hidden" name="gallery_id" value="<?=$gallery['id']?>" />
		
        <script>
			function link_change()
			{
				var ori = $('#youtube_link').val();
				var len = ori.length;
				var backtext = ori.substr(ori.indexOf('src="')+5,len - ori.indexOf('src="'));
		
				var len_back = backtext.length;
				var middle = backtext.substr(0,backtext.indexOf('"'));
		
				
				var text_link = '<iframe width="196" height="144" src="' + middle + '" frameborder="0" allowfullscreen></iframe>';
				$('#youtube_preview').html(text_link);
			}
		</script>
        <input type="radio" name="radio" value="0" checked="checked"/> Television
		<input type="radio" name="radio" value="1" /> Radio
        <div style="clear:both">
        	<div></div>
        	<div style="float:left">
            	<textarea onchange="link_change()" id="youtube_link" name="youtube_link" rows="8" cols="33"></textarea>
            </div>
            <div style="padding-left:10px; float:left" id="youtube_preview">
            	(Please insert the new embed style of your youtube video)
            </div>
        </div>
        <div style="clear:both"></div>

        <a href="#"><input type="button" class="button rounded" value="Add Video" onClick="document.addVideoForm.submit()" /></a>
        </form>
        -->
        <!--
        <div class="gallery-thumbs">
        <?php 
			if (count($photos) == 0) { print "<p>There is no photo yet</p>"; }
			else
			for($i=0;$i<count($photos);$i++) { ?>
        	<div class="gallery-thumb" id="photo-<?=$photos[$i]['id']?>"><img title="<?=$photos[$i]['title']?>" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$gallery['id']); ?>/thumbnails/<?php print $photos[$i]['name'];?>" />
            	<div class="icon">
                	<a href="<?=base_url()?>admin/cms/galleries/<?=$gallery['id']?>/<?=$photos[$i]['id']?>"><img src="<?=base_url()?>images/icon-box-edit.png" title="Edit this photo" /></a><a href="#" onclick="delete_photo(<?=$photos[$i]['id']?>)"><img src="<?=base_url()?>images/icon-box-delete.png" title="Delete this photo" /></a><br />
                <?php if (count($photos) == 1) { ?>
                	<img src="<?=base_url()?>images/icon-previous.png" title="Move to left" /><img src="<?=base_url()?>images/icon-next.png" title="Move to right" />
				<?php } else if ($i==0) { ?>
                    <img src="<?=base_url()?>images/icon-previous.png" title="Move to left" /><a href="<?=base_url()?>admin/cms/reorder/<?=$photos[$i]['id']?>/1"><img src="<?=base_url()?>images/icon-next.png" title="Move to right" /></a>
				<?php } else if ($i==(count($photos) -1)) { ?>
                	<a href="<?=base_url()?>admin/cms/reorder/<?=$photos[$i]['id']?>/-1"><img src="<?=base_url()?>images/icon-previous.png" title="Move to left" /></a><img src="<?=base_url()?>images/icon-next.png" title="Move to right" />
                <?php } else { ?>
                    <a href="<?=base_url()?>admin/cms/reorder/<?=$photos[$i]['id']?>/-1"><img src="<?=base_url()?>images/icon-previous.png" title="Move to left" /></a><a href="<?=base_url()?>admin/cms/reorder/<?=$photos[$i]['id']?>/1"><img src="<?=base_url()?>images/icon-next.png" title="Move to right" /></a>
				<?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>
        -->
         <div class="divide-hr-line"></div>  
        <!--<div class="gallery-thumbs">-->
        <div id="reorder-gallery">
            <ul id="sortable">
                <?php 
                $dtphoto=array();
                if (count($photos) == 0) { print "<p>There is no photo yet</p>"; }
                else
                for($i=0;$i<count($photos);$i++) { ?>
                <li class="ui-state-default" id="<?=$photos[$i]['id']?>">
                    
                    <div style="background-color:#fff;  border:1px solid #ccc; height:227px; padding:3px;">   
                    <?php
						if($photos[$i]['video'] == 0)
						{
						?>
                        <a title="<?=$photos[$i]['title'];?>" href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$gallery['id']); ?>/<?php print $photos[$i]['name'];?>" class="img_display">
                        	<img  src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$gallery['id']); ?>/thumbnails/<?php print $photos[$i]['name'];?>" /></a>
                        <?php
						}
						else
						{
						?>
                        	<script>//alert('<?php print $photos[$i]['name'];?>');</script>
                        	<iframe width="138" height="112" src="<?php print $photos[$i]['name'];?>" frameborder="0" allowfullscreen></iframe>
                        <?php
						}
                    ?>                	
                        
                        <div style="padding-top:10px;">
                        <a href="<?=base_url()?>admin/cms/galleries/<?=$gallery['id']?>/<?=$photos[$i]['id']?>">
                            <img src="<?=base_url()?>img/pencil.png" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;">
                        </a>
                        
                        <a href="#" onclick="delete_photo(<?=$photos[$i]['id']?>)">
                            <img src="<?=base_url()?>img/bin.png" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;">
                        </a>
                         
                        </div>
                         DRAG TO CHANGE ORDER OF IMAGES
                        
                    </div>
                </li>                
                <?php 
                
                } ?>
            </ul>
            
            <div class="clear"></div>
            <br /><br />
            <div id="order-buttons">
             <!-- 
              <input id="btnshoworder" name="btnshoworder" type="button" class="button rounded" value="Update Position" />
              -->
            </div>
        </div>
        
        <form name="orderimage" id="orderimage" method="post" action="<?=base_url()?>admin/cms/listorder" onsubmit="return showmessage()">
         <input type="hidden" name="idgallery" id="idgallery" value="<?=$gallery['id']?>">
        <input type="hidden" name="textorder" id="textorder">
        </form>
       <!-- </div>-->
        <div class="gallery-end"></div>
            </div>
            <hr />
         
        </div>
        