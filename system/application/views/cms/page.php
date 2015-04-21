<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/popup.css"> 
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script> 
<script>
$j(function() { 
	<?php if($this->session->userdata('location_id')) { ?>
	$j('#location_id').val(<?=$this->session->userdata('location_id')?>);
	<?php } ?>
	getcats();	
});
/* Get category and pages */
function getcats() {
	//var location_id = $j('#location_id').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getcats',
		type: 'POST',
		data: ({location_id:0}),
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
		url: '<?=base_url()?>admin/cms/getpages',
		type: 'POST',
		data: ({category_id:category_id}),
		dataType: "html",
		success: function(html) {
			$j('#page-list').html(html);
		}
	})	
}

/* Add new category */
function addnew() {
	/*var location_id = $j('#location_id').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getlocs',
		type: 'POST',
		data: ({location_id:0}),
		dataType: "html",
		success: function(html) {
			//$j('#locs').html(html);
			getcats2();
			centerPopup();
			loadPopup();
			$j('#name').focus();
		}
	})
	*/	
	getcats2();
	centerPopup();
	loadPopup();
	$j('#name').focus();
}
function getcats2() {
	var category_id = $j('#category_id').val();
	//var location_id = $j('#location_id2').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getcats2',
		type: 'POST',
		data: ({category_id:category_id,location_id:0}),
		dataType: "html",
		success: function(html) {
			$j('#cats2').html(html);
		}
	})	
}
function addcat() {
	if($j('#name').val() == "") {
		alert('Please enter a name for new category');
	} else {
		document.addForm.submit();
	}
}

/* Delete category */
function deletecat() {
	var category_id = $j('#category_id').val();
	if (category_id == -1) {
		alert('Sorry! You can not delete this category');
	} else if (confirm('This will delete all the pages in this category and the category itself. Are you sure you want to continue?')) {		
		$j.ajax({
			url: '<?=base_url()?>admin/cms/deletecategory',
			type: 'POST',
			data: ({category_id:category_id}),
			dataType: "html",
			success: function(html) {
				location.reload();
			}
		})
	}
}

/* Create new page */
function addpage() {
	var category_id = $j('#category_id').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/addpage',
		type: 'POST',
		data: ({category_id:category_id}),
		dataType: "html",
		success: function(html) {
			$j('#page-add').html(html);
			$j('#title').focus();
		}
	})
}
/*
function addpage() {
    window.location = '<?=base_url()?>admin/cms/addpage';
}
*/
function cancel() { $j('#page-add').html(''); }
function addingpage() {
	if($j('#title').val() == "") {
		alert('Please enter a title for new page');
	} else {
		document.addPageForm.submit();
	}
}
function editpage(id,title) {
	$j('#pagename-' + id).html('<div><input type="text" class="textfield rounded" value="' + title + '" id="newtitle-' + id + '" size="25" /></div><div><input type="button" class="button rounded" value="Go" onClick="updatepage(' + id + ')" /></div><div><input type="button" class="button rounded" value="X" onClick="cancelpage(' + id + ',\'' + title + '\')" />');
}
function updatepage(id) {
	var title = $j('#newtitle-' + id).val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/updatepagetitle',
		type: 'POST',
		data: ({id:id,title:title}),
		dataType: "html",
		success: function(html) {
			if (html == "OK") {
				$j('#pagename-' + id).html('<a href="javascript:editpage(' + id + ',\'' + title + '\')">' + title + '</a>');
			} else {
				alert('There was an error. Could not update the page title');
			}
		}
	})
}
function cancelpage(id,title) {
	$j('#pagename-' + id).html('<a href="javascript:editpage(' + id + ',\'' + title + '\')">' + title + '</a>');
}
function deletepage(page_id) {
	
	if (confirm('Are you sure you want to delete this page? This action cannot be undo!')) {
		$j.ajax({
			url: '<?=base_url()?>admin/cms/deletepage',
			type: 'POST',
			data: ({page_id:page_id}),
			dataType: "html",
			success: function(html) {
				$j('#page-' + page_id).fadeOut();
			}
		})
	}
}

/* Update page */
function menu(page_id) {
day = new Date();
id = day.getTime();
URL = '<?=base_url()?>admin/cms/page/menu/' + page_id;
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=540,height=500,left = 240,top = 125');");
}
function gallery(page_id) {
day = new Date();
id = day.getTime();
URL = '<?=base_url()?>admin/cms/page/gallery/' + page_id;
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=450,left = 240,top = 125');");
}
function content(page_id) {
day = new Date();
id = day.getTime();
URL = '<?=base_url()?>admin/cms/page/content/' + page_id;
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=930,height=750,left = 180,top = 50');");
}
function copy(page_id) {
day = new Date();
id = day.getTime();
URL = '<?=base_url()?>admin/cms/page/copy/' + page_id;
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=480,height=250,left = 280,top = 100');");
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
.page-name { float:left; padding:0 10px; }
.page-name input.textfield { width:300px; margin:9px 0 0 0; }
.page-button { float:left; }
.page-button input.button { margin:0 0 0 5px; }

</style>
<div class="left">
<h1>Content Management</h1>
<div class="bar">
    <div class="text">Page Manager</div>
    <div class="cr"></div>
</div>
<div class="box">
	<dl><dd class="addnew"><a href="javascript:addnew()">Add new category</a></dd></dl>
    <!--
    <select id="location_id" onChange="getcats()">
    	<option value="0">National</option>
    	<?php foreach($locations as $location) { ?>
        <option value="<?=$location['id']?>"><?=$location['name']?></option>
        <?php } ?>
    </select>
    -->
    <span id="cats">
    
    </span>
    &nbsp; <a href="javascript:deletecat()">Delete this category</a>
    <dl></dl>    
</div>
<hr />
<div class="box bgw">
	
    <div id="page-list">
    </div>
    <div id="page-add"></div>
</div>
<hr />


<div id="popup-box">
	<div id="popup-content">
    	<h3>Add new category</h3>
        <form name="addForm" method="post" action="<?=base_url()?>admin/cms/addcat">
        <p>Name</p>
        <p><input type="text" class="textfield rounded" id="name" name="name" /></p>
        <!--
        <p>Location</p>
        <p id="locs"></p>
        -->
        <p>Parent</p>
        <p id="cats2"></p>
        
        <p><input type="button" class="button rounded" value="Add" onclick="addcat()" /></p>
        </form>
    </div>
</div>
<div id="background-popup"></div>
</div>