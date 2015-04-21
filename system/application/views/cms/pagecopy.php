<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?=base_url()?>css/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script> var $j = jQuery.noConflict(); </script>
<title><?=$page['title']?> - Copy page</title>
<style>
body { background:#E8EDF2; margin:20px; }
p { padding:0 0 10px 0; }
</style>
<script>
$j(function() { 
	getcats();	
});
function getcats() {
	var location_id = $j('#location_id').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getcats',
		type: 'POST',
		data: ({location_id:location_id}),
		dataType: "html",
		success: function(html) {
			$j('#cats').html(html);
		}
	})	
}
function makecopy() {
	var page_id = '<?=$page['id']?>';
	var category_id = $j('#category_id').val();
	//var location_id = $j('#location_id').val();
	var title = $j('#title').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/copypage',
		type: 'POST',
		data: ({page_id:page_id,category_id:category_id,title:title}),
		dataType: "html",
		success: function(html) {
			window.close();
		}
	})
}
</script>
</head>

<body>
	<p>Copy page <b><?=$page['title']?></b></p>
    
    <?php
		$category = $this->Content_model->get_category($page['category_id']); 
		$from = $category['name'];
		if ($category['parent_id'] != 0) {
			$par1 = $this->Content_model->get_category($category['parent_id']);
			$from = $par1['name'].' &raquo; '.$from;
			if ($par1['parent_id'] != 0) {
				$par2 = $this->Content_model->get_category($par1['parent_id']);
				$from = $par2['name'].' &raquo; '.$from;
			}
		}
	?>
    <p>Category <b><?=$from?></b></p>
	<p>Please select destination</p>
    <p> 
    <!--       
    <select id="location_id" onchange="getcats()">
    	<option value="0">National</option>
    	<?php foreach($locations as $location) { ?>
        <option value="<?=$location['id']?>"><?=$location['name']?></option>
        <?php } ?>
    </select>
    -->
    <span id="cats">
    
    </span>
    </p>
    
    <p>Name for new page</p>
    <p><input type="text" class="textfield rounded" size="40" id="title" value="<?=$page['title']?>" /></p>
    <p><input type="button" class="button rounded" value="Copy" onclick="makecopy()" /></p>
</body>
</html>
