<script>
function start() {
	var attr = $j('#name').val().trim();
	if (attr != '') {
		$j('#attribute_name').html('Attribute: <b>' + attr + '</b> (Add option by the input field below)');
		$j('#optcontent').show();
	} else {
		alert('Please enter a valid name for new attribute');
	}
}
function addoption(n) {
	var opt = $j('#optval').val().trim();
	if (opt != '') {
		$j('#optval').val('');
		$j('#options').append('<dl class="five" id="opt-' + n + '"><dt>' + opt + '</dt><dd><a href="javascript:removeoption(' + n + ')"><img src="<?=base_url()?>img/backend/icon-delete-small.png" /></a></dd><input type="hidden" name="options[]" value="' + opt + '" /></dl>');
		$j('#optbutton').html('<input type="button" class="button rounded" value="&raquo;" onclick="addoption(' + (n+1) + ')" />');
	} else {
		alert('Please enter a valid option');
	}
}
function changename(id,name) {
	$j('#name-' + id).html('<input type="text" value="' + name + '" class="textfield rounded" id="new-name-' + id + '" /> <input type="button" class="button rounded" value="Change" onClick="updatechange(' + id + ')" /> <input type="button" class="button rounded" value="Cancel" onClick="cancelchange(' + id + ',\'' + name + '\')" />');
}
function cancelchange(id,name) {
	$j('#name-' + id).html('<a href="javascript:changename(' + id + ',\'' + name + '\')">' + name + '</a>');
}
function updatechange(id) {
	var name = $j('#new-name-' + id).val();
	$j.ajax({
		url: '<?=base_url()?>admin/system/updateattributename/',
		type: 'POST',
		data: ({id:id,name:name}),
		dataType: "html",
		success: function(html) {
			$j('#name-' + id).html('<a href="javascript:changename(' + id + ',\'' + name + '\')">' + name + '</a>');
		}
	})	
}
function removeoption(n) {
	$j('#opt-' + n).remove();
}
function deleteattribute(id) {
	if (confirm('Are you sure you want to delete this attribute?')) {
		window.location = '<?=base_url()?>admin/system/deleteattribute/' + id;
	}
}
</script>
    	<div class="left">
        	<h1>System Settings</h1>
            <div class="bar">

            	<div class="text">Product Attributes</div>
            	<div class="cr"></div>
            </div>
            <div class="box">
            	<h3>Attributes List</h3>
                <div class="row-title">
                	<div class="cat-name">Attribute name</div>
                    <div class="cat-func">Delete</div>
                    <div class="cat-func">Edit</div>
                </div>
                <div id="subcat">
                	<?php foreach($attributes as $attr) { ?>
                	<div class="row-item">
                        <div class="cat-name" id="name-<?=$attr['id']?>"><a href="javascript:changename(<?=$attr['id']?>,'<?=$attr['name']?>')" title="Change attribute name"><?=$attr['name']?></a></div>
                        <div class="cat-func"><a href="javascript:deleteattribute(<?=$attr['id']?>)" title="Delete this attribute"><img src="<?=base_url()?>img/backend/icon-delete.png" /></a></div>
                        <div class="cat-func"><a href="<?=base_url()?>admin/system/attribute/edit/<?=$attr['id']?>" title="Edit this attribute"><img src="<?=base_url()?>img/backend/icon-view.png" /></a></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <hr />
            <div class="box bgw">
            	<form method="post" action="<?=base_url()?>admin/system/addattribute">
            	<h3>Create Product Attribute</h3>
                <p>Please enter an attribute name such as Colour that is used to identify your option when you create a product.</p><br />
                <dl class="four"><dd><input type="text" class="textfield rounded" name="name" id="name" />
                				<dd><input type="button" class="button rounded" value="Start" onclick="start()" /></dd></dl>
                
                <dl></dl>
                <div id="optcontent" class="optwrap hidden">
                	<div class="title" id="attribute_name"></div>
                    <div class="input">
                    	<dl class="four"><dd><input type="text" class="textfield rounded" id="optval" /></dd><dd id="optbutton"><input type="button" class="button rounded" value="&raquo;" onclick="addoption(1)" /></dd></dl>
                        <dl></dl>
                    </div>
                    <div class="label" id="options">
                    	
                    </div>
                    <div class="button-complete"><input type="submit" class="button rounded" value="Complete" /></div>
                    <dl></dl>
                </div>
                </form>
            </div>
        </div>
        
