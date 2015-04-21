<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript">
$j(function() {
	$j('#gallery a').lightBox();
	$j('.gallery-thumb *').tooltip({
		showURL: false
	});
	
});
</script>  
<script>
function delete_photo(id)
{
	if (confirm('Are you sure you want to do this?')) {
		var url = "<?=base_url()?>admin/cms/delete_photo/";
		url = url + id;
		window.location = '<?=base_url()?>admin/cms/delete_photo/' + id;		
	} else {
		return false;
	}
}
</script> 	
<div id="left-content">
	<div class="content-title"><img src="<?=base_url()?>images/admin/title-site-control.png" /></div>
    <div class="bar-title"><div>Photo Details</div></div>
    <div class="content-area">
    	<?php $pid = $photo['id'];
		$src = $photo['name'];
		?>
		<div id="gallery">
            <ul>
                <li>
                    <a href="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$gallery['id']); ?>/<?=$src?>">
                        <img src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$gallery['id']); ?>/thumbnails/<?=$src?>" alt="" />
                    </a>
                </li>
            </ul>
        </div>
        <div class="photo-details"><form name="addPhotoTitleForm" method="post" action="<?=base_url()?>admin/cms/add_photo_title">
        <input type="hidden" name="photo_id" value="<?=$pid?>" />
        <input type="hidden" name="gallery_id" value="<?=$gallery['id']?>" />
        Photo Image Caption
        <p><input type="text" name="title" class="medium" value="<?=$photo['title']?>" /></p>
        <a href="#"><input type="button" class="button rounded" value="Add Title" onClick="document.addPhotoTitleForm.submit()" /></a>
        </form>
        </div>
        <div class="divide-hr-line"></div>
        
        <div class="gallery-thumbs">
        <?php for($i=0;$i<count($photos);$i++) { ?>
        	<div class="gallery-thumb" id="photo-<?=$photos[$i]['id']?>"><img title="<?=$photos[$i]['title']?>" src="<?=base_url()?>uploads/galleries/<?php print md5("cdkgallery".$gallery['id']); ?>/thumbnails/<?php print $photos[$i]['name'];?>" />
            	<div class="icon">
                	<a href="<?=base_url()?>admin/cms/galleries/<?=$gallery['id']?>/<?=$photos[$i]['id']?>" ><img src="<?=base_url()?>images/icon-box-edit.png" title="Edit this photo" /></a><a href="#" onclick="delete_photo(<?=$photos[$i]['id']?>)"><img src="<?=base_url()?>images/icon-box-delete.png" title="Delete this photo" /></a><br />
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
        <div class="gallery-end"></div>
    </div>
	
</div>
