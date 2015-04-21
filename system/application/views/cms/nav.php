<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/popup.css"> 
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script> 
<script>
function addnew() {
	$j('#popup-content').html('<h3>Add new navigation</h3><form name="addForm" method="post" action="<?=base_url()?>admin/cms/addnav"><p>Name</p><p><input type="text" class="textfield rounded" id="name" name="name" /></p><p id="cats"></p><p id="pages"></p><p><input type="text" class="textfield rounded" name="url" id="url" value="http://" /></p><p><input type="button" class="button rounded" value="Add" onclick="addnav()" /></p></form>');
	getcats();
	centerPopup();
	loadPopup();
	$j('#name').focus();
}

function getcats() {
	var location_id = 1;
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getcats',
		type: 'POST',
		data: ({location_id:location_id}),
		dataType: "html",
		success: function(html) {
			$j('#cats').html(html);
			getpages();
		}
	})	
}

function getpages() {
	var category_id = $j('#category_id').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getpagesinput',
		type: 'POST',
		data: ({category_id:category_id}),
		dataType: "html",
		success: function(html) {
			$j('#pages').html(html);
		}
	})	
}
function updateurl() {
	var path = $j('#page-title').val();
	$j('#url').val(path);
}
function addnav() {
	if($j('#name').val() == "") {
		alert('Please enter a name for new menu');
		$j('#name').focus();
	} else {
		document.addForm.submit();
	}
}


function deletenav(id) {
	if (confirm('Are you sure you want to delete this navigation? This action cannot be undo!')) {
		$j.ajax({
			url: '<?=base_url()?>admin/cms/deletenav',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				$j('#nav-' + id).fadeOut();
			}
		})
	}
}
function editnav(id,name) {	
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getmenu',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
			$j('#name').focus();
		}
	})	
}
function getcats2() {
	var location_id = $j('#location_id2').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getcats3',
		type: 'POST',
		data: ({location_id:location_id}),
		dataType: "html",
		success: function(html) {
			$j('#cats2').html(html);
			getpages2();
		}
	})	
}
function getpages2() {
	var category_id = $j('#category_id2').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getpagesinput2',
		type: 'POST',
		data: ({category_id:category_id}),
		dataType: "html",
		success: function(html) {
			$j('#pages2').html(html);
		}
	})	
}
function updateurl2() {
	var path = $j('#page-title2').val();
	$j('#url2').val(path);
}
function updatenav(id) {
	var name = $j('#newname-' + id).val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/updatenav',
		type: 'POST',
		data: ({id:id,name:name}),
		dataType: "html",
		success: function(html) {
			if (html == "OK") {
				$j('#navname-' + id).html('<a href="javascript:editnav(' + id + ',\'' + name + '\')">' + name + '</a>');
			} else {
				alert('There was an error. Could not update the navigation name');
			}
		}
	})
}
function cancelnav(id,name) {
	$j('#navname-' + id).html('<a href="javascript:editnav(' + id + ',\'' + name + '\')">' + name + '</a>');
}

function editmenu(id,title) {
	$j('#menuname-' + id).html('<div><input type="text" class="textfield rounded" value="' + title + '" id="newtitle-' + id + '" size="25" /></div><div><input type="button" class="button rounded" value="Go" onClick="updatemenu(' + id + ')" /></div><div><input type="button" class="button rounded" value="X" onClick="cancelmenu(' + id + ',\'' + title + '\')" />');
}
function cancelmenu(id,title) {
	$j('#menuname-' + id).html('<a href="javascript:editmenu(' + id + ',\'' + title + '\')">' + title + '</a>');
}

function updatemenu(id) {
	var title = $j('#newtitle-' + id).val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/updatemenu',
		type: 'POST',
		data: ({id:id,title:title}),
		dataType: "html",
		success: function(html) {
			if (html == "OK") {
				$j('#menuname-' + id).html('<a href="javascript:editmenu(' + id + ',\'' + title + '\')">' + title + '</a>');
			} else {
				alert('There was an error. Could not update the page title');
			}
		}
	})
}


</script>
<style>
.row-title { height:25px; line-height:25px; border:1px dotted #63A2D4; background:#fff; font-weight:bold; clear:both; }
.row-item { height:40px; line-height:40px; border:1px dotted #63A2D4; border-top:0; clear:both; }
.menu-name { float:left; padding:0 10px; }
.menu-name div { float:left; }
.menu-name input.textfield { margin:8px 0 5px -5px; }
.menu-name input.button { margin:8px 0 5px 5px; }
.menu-func { float:right; width:60px; text-align:center; border-left:1px dotted #63A2D4; }
.menu-func2 { float:right; width:70px; text-align:center; border-left:1px dotted #63A2D4; }
.menu-func img,.menu-func2 img { padding:5px 0; }
dl dt, dl dd {
    float: right;
}
</style>
<div class="left">
<h1>Content Management</h1>

<div class="bar">
    <div class="text">Navigation Manager</div>
    <div class="cr"></div>
</div>
<div class="box">
	<h3>Menu Bar</h3>
    <div class="row-title">
    	<div class="menu-name">Menu name</div>
        <div class="menu-func">Update</div>
    </div>
    <?php foreach($top as $menu) { ?>
    <div class="row-item" id="menu-<?=$menu['id']?>">
    	<div class="menu-name" id="menuname-<?=$menu['id']?>"><a href="javascript:editmenu('<?=$menu['id']?>','<?=$menu['name']?>')"><?=$menu['name']?></a></div>
        <div class="menu-func"><a href="<?=base_url()?>admin/cms/navigation/update/<?=$menu['id']?>"><img src="<?=base_url()?>img/admin/icon-view.png" /></a></div>                                
    </div>
    <?php } ?>
</div>
<hr />
<!--
<div class="box bgw">
	<dl><dd><a href="javascript:addnew()">Add new menu</a></dd></dl>
    <h3>Page Navigation</h3>
    <dl></dl>
    <div class="row-title">
    	<div class="menu-name">Menu name</div>
        <div class="menu-func">Delete</div>
        <div class="menu-func">Update</div>
    </div>
    <?php foreach($mid as $menu) { ?>
    <div class="row-item" id="nav-<?=$menu['id']?>">
    	<div class="menu-name" id="navname-<?=$menu['id']?>"><a href="javascript:editnav(<?=$menu['id']?>,'<?=$menu['name']?>')"><?=$menu['name']?></a></div>
        <div class="menu-func"><a href="javascript:deletenav(<?=$menu['id']?>)"><img src="<?=base_url()?>img/admin/icon-delete.png" /></a></div>
        <div class="menu-func"><a href="<?=base_url()?>admin/cms/navigation/update/<?=$menu['id']?>"><img src="<?=base_url()?>img/admin/icon-view.png" /></a></div>
    </div>
    <?php } ?>
</div>
<hr />
-->
<div id="popup-box">
	<div id="popup-content">
    	
    </div>
</div>
<div id="background-popup"></div>
</div>