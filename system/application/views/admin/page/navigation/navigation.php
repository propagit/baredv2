<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/popup.css"> 
<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script> 
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"></link>
<script  src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script>
$j(document).ready(function(){
   
	updatepos();
    
    
    
                
		//CLOSING POPUP    
		//Click out event!
		$j("#background-popup").click(function(){
			disablePopup();
		});
    //Press Escape event!
		$j(document).keypress(function(e){
			if(e.keyCode==27 && popupStatus==1){
				disablePopup();
			}
			});
    	
	
	 $("#sortable").sortable({
    	opacity: 0.8, 
		cursor: 'move',
		update: function(event, ui) {
      	imgOrder = $("#sortable").sortable('toArray').toString();
	    $("#pos").val(imgOrder);
		var parentid = $j('#parentid').val(); 
		$("#parentpos").val(parentid);
		$("#parentidpos").val(parentid);
	   	document.posform.submit(); 
		
    	}
  	});
  $("#sortable").disableSelection();
  
  
    
});
function test()
{
	
		/*
	$j.ajax({
		url: '<?=base_url()?>admin/cms/listposorder',
		type: 'POST',
		data: ({pos:pos,parentidpos:parentidpos,parentpos:parentpos}),
		dataType: "html",
		success: function(html) {
			updatepos();
		}
	
	})
		*/
	alert('test');
}
function updatepos() {
    <? if($this->session->flashdata('link')){?>
	alert('test');
	var parentid = <?=$this->session->flashdata('link')?>;  
	<? } else{?>var parentid = $j('#parentid').val();  <? }?>
	
    $j.ajax({
        url: '<?=base_url()?>admin/cms/getposlist2',
        type: 'POST',
        data: ({menuid:'<?=$menu['id']?>',parentid:parentid}),
        dataType: "html",
        success: function(html) {
            $j('#sortable').html('');
			$j('#sortable').html(html);
        }
		
    })
}
function addlink() {
    if ($j('#name').val() == "") {
        alert('Please enter a title for the link');
    } else {
        document.addForm.submit();
    }
}
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
function deletelink(id) {
    if (confirm('Are you sure to delete this link?')) {
        window.location = '<?=base_url()?>admin/cms/deletelink/' + id;
    }
}
function updateurl() {
    var path = $j('#page-title').val();
    $j('#url').val(path);
}
function updateurl2() {
    var path = $j('#page-title2').val();
    $j('#url2').val(path);
}
</script>
<style>

.box { padding:15px 25px; clear:both; color:#575757; }
.box-add { float:left; width:300px; }
.box-add dl { padding:4px 0; }
.box-add dl dt input.textfield { width:292px; }
.box-add dl dd input.textfield { width:190px; }
.box-add dl dd select { width:188px; }
.box-edit { float:right; padding:10px; width:240px; background:#fff; border:1px solid #ccc; margin-bottom:20px; }

ul.em { list-style:none; margin-left:-39px; }
ul.em li { display:block; padding:3px 10px; margin:2px 0; }
ul.em ul { list-style:none; margin:3px 0 0 0; margin-left:-40px; }
ul.em ul li {  }
ul.em li.nochild div, ul.em ul li div { float:right; margin-right:-6px; opacity:0; }
ul.em li.nochild:hover div, ul.em ul li:hover div { opacity:1; }

.box-edit2 { float:left; width:300px; margin:20px 0 10px 0; }
ul.em2 { list-style:none; }
ul.em2 li { display:block; padding:3px 10px; background:#e5e5e5; border:1px solid #999; margin:2px 0; }
ul.em2 ul { list-style:none; margin:3px 0 0 0; }
ul.em2 ul li { background:#f5f5f5; }
ul.em2 li.nochild div, ul.em ul li div { float:right; margin-right:-6px; opacity:0; position:relative; }
ul.em2 li.nochild:hover div, ul.em ul li:hover div { opacity:1; }

#sortable { list-style-type: none; margin: 0; padding: 0; }
#sortable li { background:#e5e5e5; border:1px solid #999; margin: -2px 3px 3px 0; padding: 4px 2px 3px 10px; float: left; width: 150px; height: 20px; font-size: 12px; text-align: left; }
#sortable li img {padding:1px; cursor: pointer; width:138px; height:112px;}
.ui-state-default, .ui-widget-content .ui-state-default{border:none; background:none;}
  
</style>
<div id="left-content">
    <div class="content-title"><img src="<?=base_url()?>images/admin/title-site-control.png" />        
    </div>
    <div class="bar-title"><div>Manage Navigation</div></div>    
    
    
    <div class="box"><br />
    <div class="box-add">
        <form name="addForm" method="post" action="<?=base_url()?>admin/cms/addlink">
        <input type="hidden" name="menu_id" value="<?=$menu['id']?>" />
        <table>
        <tr><td>Name</td><td><input type="text"  style="width:200px; height:25px; padding-left:5px;margin-bottom: 5px;" name="name" id="name" /></td></tr>
		<tr><td>Parent</td>
        	<td valign="middle"><select name="parent_id" id="parentid" onchange="updatepos()" style="width:200px; height:25px; padding:4px;">
                <option value="0">No parent</option>
                <?php foreach($links as $link) { ?>
                <option value="<?=$link['id']?>" <? if($this->session->flashdata('link')==$link['id']){echo "Selected=selected";}?>><?=$link['name']?></option>
                <?php } ?>
            </select>
            </td>
        </tr>
        <tr><td>Page</td><td> <select id="page-title" onchange="updateurl()" style="width:200px; height:25px; padding:4px;">
                <option>Please select a page</option>
                <?
                if ($pages) { 
                    foreach($pages as $page) { ?>
                    <option value="<?=$page['id']?>">|-- <?=$page['title']?></option>
                <?php }
                    } 
                    
                ?>
            </select></td></tr>
        <tr>
        	<div id="divurl">
            <td>
            
        <div id="tagurl">Url</div></td>
        	<td><input type="text" style="width:200px; height:25px;padding-left:5px;" name="url" id="url" value="http://" /></div></td>
        </tr>    
        <tr>
        	<td><input type="button" class="button rounded" value="Add" onclick="addlink()" /></td>
        </tr>
   		</table>
        </form>
    </div>
    
    <div class="box-edit" id="list">
        <ul class="em">
        <?php foreach($links as $link) {
        $children = $this->Menu_model->get_links($menu['id'],$link['id']);
        if(!$children) { ?>
            <li class="nochild"><a style="color:#97908c; font-size:13px; font-weight:bold;" href="javascript:editlink(<?=$link['id']?>)"><?=$link['name']?></a> <div><a href="javascript:deletelink(<?=$link['id']?>)"><img src="<?=base_url()?>images/admin/delete2.png" /></a></div></li>
        <?php } else { ?>
            <li class="haschild"><a style="color:#97908c;font-size:13px;font-weight:bold;" href="javascript:editlink(<?=$link['id']?>)"><?=$link['name']?></a>
                <ul>
                    <?php foreach($children as $child) { ?>
                    <li id="link-<?=$child['id']?>"><a style="color:#b9b2ae;font-size:13px; font-weight:500;" href="#" onclick="editlink(<?=$child['id']?>)"><?=$child['name']?></a> <div><a href="javascript:deletelink(<?=$child['id']?>)"><img src="<?=base_url()?>images/admin/delete2.png" /></a></div></li>
                    <?php } ?>
                </ul>
              </li>
        <?php } 
        } ?>        
        </ul>
    </div>
    
   
    <div class="box-edit2" id="list2">    	
     <p>Drag & drop the bar to re-order the navigation</p>
    	<ul id="sortable">
    	<?php foreach($links as $link) {
			?>
        	<li id="<?=$link['id']?>" class="ui-state-default"><a href="#" onClick="javascript:editlink(<?=$link['id']?>)"><?=$link['name']?></a> </li>
            <?
		} ?>        
        </ul>
    </div>
    <form name="posform" id="posform" method="post" action="<?=base_url()?>admin/cms/listposorder">
	<input type="hidden" name="pos" id="pos" />
    <input type="hidden" name="parentpos" id="parentpos" />
    <input type="hidden" name="parentidpos" id="parentidpos" />
    </form>
   
    
   
</div>
</div>
<div id="popup-box">
    <div id="popup-content" style="background-color:#fff!important; width:330px!important; height:190px!important;" >
        
    </div>
</div>
<div id="background-popup"></div>