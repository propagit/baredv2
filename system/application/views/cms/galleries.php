<script>
$j(function() {
	$j('.galleries-thumb *').tooltip({
		showURL: false
	});
	
});

/*function delete_gallery(id)
{
	if (confirm('It will delete all photos of this gallery. Are you sure you want to do this?')) {		
		xmlhttp = GetXmlHttpObject();
		if (xmlhttp == null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}
		
		var url = "<?=base_url()?>admin/cms/delete_gallery/";
		url = url + id;
		alert(url);
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4)
			{
				if (xmlhttp.status == 200) {
					var result = xmlhttp.responseText;
					if (result.match("Ok")) {
						$j("#gallery-" + id).fadeOut("normal");
					}
					else {
						alert("There was an error when deleting this gallery");
					}				
				}
			}
		};
	} else {
		return false;
	}
}*/

</script>

<style>
.gallery-thumbs
{
	clear:both;
}
.galleries-thumb
{
	float: left; height: 175px;
    /*margin: 10px 10px 0 0;*/
    opacity: 0.8;
    text-align: center;
    width: 140px;
}
.galleries-thumb:hover
{
	opacity: 1;
}
</style>

<script>
function delete_gallery(id)
{
	if (confirm('It will delete all photos of this gallery. Are you sure you want to do this?')) {
				
		//xmlhttp = GetXmlHttpObject();
		/*
		if (xmlhttp == null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}*/
		
		var url = "<?=base_url()?>admin/cms/delete_gallery/";
		url = url + id;
		alert(url);
		
		$j.ajax({
		url: url,
		success: function(html) {
			if (html == 'Ok') {
						$j("#gallery-" + id).fadeOut("normal");
					}
					else {
						alert("There was an error when deleting this gallery");
					}
			
		}
	})
		
		
		/*xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4)
			{
				if (xmlhttp.status == 200) {
					var result = xmlhttp.responseText;
					if (result.match("Ok")) {
						$j("#gallery-" + id).fadeOut("normal");
					}
					else {
						alert("There was an error when deleting this gallery");
					}				
				}
			}
		};*/
	} else {
		return false;
	}
}
</script>
	<div class="left">
        	<h1>Store Management</h1>
            <div class="bar">

            	<div class="text">Manage Image Galleries</div>
            	<div class="cr"></div>
            </div>
            <div class="box">
            	 <form style="margin-left:6px" name="createGalleryForm" method="post" action="<?=base_url()?>admin/cms/create_gallery">
				<?php if ($this->session->flashdata('error_cg')) {
                    print '<span class="error">ERROR: Please enter a name for new gallery</span>';
                } ?>
                <p><input type="text" class="medium" name="title" /></p>
                <a href="#"><input type="button" class="button rounded" value="Create" onClick="document.createGalleryForm.submit()" /></a>
                </form>
        		
                <div class="gallery-thumbs">
				<?php foreach($galleries as $gallery)
                {
                    if($gallery['id'] != 4)
                    {
                ?>
                         
                    <div class="galleries-thumb" id="gallery-<?=$gallery['id']?>" style="margin: 10px 10px 40px 5px !important;">
                        <div style="background-color:#fff;  border:1px solid #ccc; width:145px; height:180px; padding:3px; margin-right:3px;">
                        <?=$thumbnails[$gallery['id']]?>
                        <!--
                        <div class="icon">
                            <a href="<?=base_url()?>admin/cms/galleries/<?=$gallery['id']?>"><img src="<?=base_url()?>images/icon-box-edit.png" title="Edit this gallery" /></a>
                            <a href="#"><img src="<?=base_url()?>images/icon-box-delete.png" title="Delete this gallery" onclick="return delete_gallery(<?=$gallery['id']?>)" /></a>
                        </div>
                        -->
                         <div style="padding-top:10px;">
                                <a href="<?=base_url()?>admin/cms/galleries/<?=$gallery['id']?>">
                                    <img src="<?=base_url()?>img/pencil.png" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;">
                                </a>
                                
                                <a onclick="return delete_gallery(<?=$gallery['id']?>)">
                                    <img src="<?=base_url()?>img/bin.png" style="border:1px solid #ccc;width:35px; height:41px; padding-left:15px;padding-right:15px; padding-top:6px; padding-bottom:6px;">
                                </a>
                                 
                        </div>
                        </div>
                    </div>
                    
                <?php
                    }
                }
                ?>
                </div>
                <div class="gallery-end"></div>
            </div>
         
        </div>