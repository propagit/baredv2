<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?=base_url()?>css/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.crossslide.js"></script>
<script> var $j = jQuery.noConflict(); </script>
<title><?=$page['title']?> - Update page gallery</title>
<style>
body { background:#E8EDF2; margin:20px; }
p { padding:3px 0; }
.box-add { width:200px; }
h4 div { float:right; }
.contact { height:70px; }
.info { float:left; }
.but-rev { float:right; padding:5px 0 0 0; font-weight:bold; }
.info a { color:#005E5C; }
.box-preview { width:165px; padding:10px 10px 0 10px; }
.slide #pic1, .slide #pic2, .slide #pic3 { width: 165px; height: 104px; margin:0 0 10px 0; }
</style>
<?php $n1 = ceil(count($photos)/3); $n2 = ceil(count($photos)/3 * 2) ; $n3 = count($photos); ?>
<script>
$j(function() {      
	$j('#pic1').crossSlide({
		fade: 1
		}, [
		<?php for($i=0;$i<$n1;$i++) { ?>
		{ src: '<?=base_url()?>uploads/galleries/<?=$photos[$i]['name']?>',href: '',from:'100% 100% 1x',to:'100% 100% 1x',time:<?php if($i==0) print '4'; else print '15'; ?> }<?php if($i < $n1-1) { print ',
		'; } ?>
		<?php } ?>
	]);
	
	$j('#pic2').crossSlide({
		fade: 1
		}, [
		<?php for($i=$n1;$i<$n2;$i++) { ?>
		{ src: '<?=base_url()?>uploads/galleries/<?=$photos[$i]['name']?>',href: '',from:'100% 100% 1x',to:'100% 100% 1x',time:<?php if($i==$n1) print '9'; else print '15'; ?> }<?php if($i < $n2-1) { print ',
		'; } ?>
		<?php } ?>
	]);
	
	$j('#pic3').crossSlide({
		fade: 1
		}, [
		<?php for($i=$n2;$i<$n3;$i++) { ?>
		{ src: '<?=base_url()?>uploads/galleries/<?=$photos[$i]['name']?>',href: '',from:'100% 100% 1x',to:'100% 100% 1x',time:<?php if($i==$n2) print '14'; else print '15'; ?> }<?php if($i < $n3-1) { print ',
		'; } ?>
		<?php } ?>
	]);
});
</script>
</head>

<body>
<div class="box-add">    
    <p>Please select the gallery</p>
    <form method="post" action="<?=base_url()?>admin/cms/updatepagegallery">
    <input type="hidden" name="page_id" value="<?=$page['id']?>" />
    <p><select name="gallery_id">
    	<?php foreach($galleries as $g) { ?>
        <option value="<?=$g['id']?>"<?php if ($page['gallery_id'] == $g['id']) print ' selected="selected"'; ?>>&raquo; <?=$g['name']?></option>
        <?php } ?>
    </select></p>
    <p><input type="submit" class="button rounded" value="Update" /></p>
    </form>
</div>
<div class="box-preview">
	<div class="slide">
        <div id="pic1"></div>
        <div id="pic2"></div>
        <div id="pic3"></div>
    </div>
</div>
</body>
</html>
