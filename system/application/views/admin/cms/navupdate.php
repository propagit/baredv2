<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/popup.css"> 
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script> 
<script>
$j(function() {
	getcats();
	updatepos();
	previewnav();
	$j('#backbutton').click(function(){
		window.location = '<?=base_url()?>admin/cms/navigation';
	});
	
	// Drag and drop
	$j("#list ul").sortable({ 
		opacity: 0.8, 
		cursor: 'move', 
		update: function() {			
			var order = $j(this).sortable("serialize") + '&update=update'; 
			$j.post("<?=base_url()?>admin/cms/reorderlink", order, function(html){	
				previewnav();
			});
		}
	});
});

/* Add link */
function updatepos() {
	var parentid = $j('#parentid').val();
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getposlist',
		type: 'POST',
		data: ({menuid:'<?=$menu['id']?>',parentid:parentid}),
		dataType: "html",
		success: function(html) {
			$j('#position').html(html);
		}
	})
}
function getcats() {
	var location_id = $j('#location_id').val();
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
function addlink() {
	if ($j('#name').val() == "") {
		alert('Please enter a title for the link');
	} else {
		document.addForm.submit();
	}
}

/* Edit link */
function editlink(id) {
	$j.ajax({
		url: '<?=base_url()?>admin/cms/getlink',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
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

/* Delete link */
function deletelink(id) {
	if (confirm('Are you sure to delete this link?')) {
		$j.ajax({
			url: '<?=base_url()?>admin/cms/deletelink',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				$j('#link_' + id).fadeOut();
				previewnav();
			}
		})
	}
}

function previewnav() {
	$j.ajax({
		url: '<?=base_url()?>admin/cms/previewnav',
		type: 'POST',
		data: ({menu_id:'<?=$menu['id']?>'}),
		dataType: "html",
		success: function(html) {
			$j('#menu-preview').html(html);
		}
	})	
}
</script>
<style>
dl { clear:both; }
dl dt { float:left; }
dl dd { float:right; }
.box-add { float:left; width:300px; }
.box-add dl { padding:4px 0; }
.box-add dl dt input.textfield { width:292px; }
.box-add dl dd input.textfield { width:180px; }
.box-add dl dd select { width:188px; }
.box-edit { float:left; width:300px; margin:20px 0 10px 0; }
.box-preview { float:right; padding:0 30px 10px 30px; width:207px; background:#fff; border:1px solid #ccc; font-family:Arial, Helvetica, sans-serif;  }
.box-preview h4 { font-size:12px;border-bottom:1px solid #dbdcdc; padding:14px 0 3px 0; margin:0 0 3px 0; }



ul.me { list-style:none; }
ul.me li { padding:2px 0; }
ul.me li a { color:#666; text-decoration:none; }
ul.me li a img { }
ul.me li a:hover { color:#789424; }
ul.me ul { list-style:none; }
ul.me li.par ul { border-left: 1px solid #789424; margin:0 0 0 3px; }
ul.me li.par ul li span { color: #789424; letter-spacing: -1px; }

ul.em { list-style:none; padding:0}
ul.em li { display:block; padding:3px 10px; background:#e5e5e5; border:1px solid #999; margin:2px 0; }
ul.em ul { list-style:none; margin:3px 0 0 0; padding:0}
ul.em ul li { background:#f5f5f5; }
ul.em li.nochild div, ul.em ul li div { float:right; margin-right:-6px; opacity:0; position:relative; }
ul.em li.nochild:hover div, ul.em ul li:hover div { opacity:1; }
</style>
<div class="left">
<h1>Content Management</h1>
<div class="bar">
    <div class="text">Navigation Manager &raquo; Update</div>
    <div class="cr"></div>
</div>
<div class="box">
	<input type="button" class="button rounded" id="backbutton" value="Back to Navigation List" />
</div>
<hr />
<div class="box bgw">
	<div class="box-add">
        <h3>Add new link to the menu</h3>
        <form name="addForm" method="post" action="<?=base_url()?>admin/cms/addlink">
        <input type="hidden" name="menu_id" value="<?=$menu['id']?>" />
        <dl><dt>Name</dt><dd><input type="text" class="textfield rounded" name="name" id="name" /></dd></dl>
        <dl><dt>Parent</dt><dd>
            <select name="parent_id" id="parentid" onchange="updatepos()">
                <option value="0">No parent</option>
                <?php foreach($links as $link) { ?>
                <option value="<?=$link['id']?>"><?=$link['name']?></option>
                <?php } ?>
            </select>
        </dd></dl>
        <dl><dt>Position</dt><dd id="position">
            
        </dd></dl>
        <dl><dt>Link to</dt>
        	<!--
            <dd>
            <select id="location_id" onchange="getcats()">
            	<option value="0">National</option>
            	<?php //foreach($locations as $loc) { ?>
                <option value="<? //=$loc['id']?>"><? //=$loc['name']?></option>
                <?php //} ?>
            </select>
            </dd>
            -->        
        <dd id="cats"></dd></dl>
        <dl><dt>&nbsp;</dt><dd id="pages">
            
        </dd></dl>
        <dl><dt><input type="text" class="textfield rounded" name="url" id="url" value="http://" /></dt></dl>
        <dl><dd><input type="button" class="button rounded" value="Add" onclick="addlink()" /></dd></dl>
        </form>
    </div>
    
    <div class="box-preview" id="menu-preview">
    	
    </div>
    
    <div class="box-edit" id="list">
    	<p>Drag & drop the bar to re-order the navigation</p><br />
    	<ul class="em">
    	<?php foreach($links as $link) {
		$children = $this->Menu_model->get_links($menu['id'],$link['id']);
		if(!$children) { ?>
        	<li id="link_<?=$link['id']?>" class="nochild"><a href="javascript:editlink(<?=$link['id']?>)"><?=$link['name']?></a> <div><a href="javascript:deletelink(<?=$link['id']?>)"><img src="<?=base_url()?>img/admin/delete.png" /></a></div></li>
        <?php } else { ?>
        	<li id="link_<?=$link['id']?>" class="haschild"><a href="javascript:editlink(<?=$link['id']?>)"><?=$link['name']?></a>
                <ul>
                    <?php foreach($children as $child) { ?>
                    <li id="link_<?=$child['id']?>"><a class="child_link" href="#" onclick="editlink(<?=$child['id']?>)"><?=$child['name']?></a> <div><a href="javascript:deletelink(<?=$child['id']?>)"><img src="<?=base_url()?>img/admin/delete.png" /></a></div></li>
                    <?php } ?>
                </ul>
          	</li>
		<?php } 
		} ?>        
        </ul>
    </div>
    <dl></dl>
</div>

<div id="popup-box">
	<div id="popup-content">
    	
    </div>
</div>
<div id="background-popup"></div>
</div>