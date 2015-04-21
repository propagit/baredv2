<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"></link>
<script  src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/popup.css" />

<script>
$j(document).ready(function(){
    $j("#background-popup").click(function(){ disablePopup(); });
    $j(document).keypress(function(e){ if(e.keyCode==27 && popupStatus==1){ disablePopup(); } });
	$("#sortable").sortable({
    	opacity: 0.8, 
		cursor: 'move',
		update: function(event, ui) {
      	imgOrder = $("#sortable").sortable('toArray').toString();
	    $("#pos").val(imgOrder);
	   	document.posform.submit(); 
		
    	}
  	});
  $("#sortable").disableSelection();
});
function addpage() {
    window.location = '<?=base_url()?>admin/cms/addpage';
}
function deletepage(id) {
    if (confirm('Are you sure you want to delete this page?')) {
        window.location = '<?=base_url()?>admin/cms/deletepage/' + id;
    }
}
</script>

<style>
dl { clear:both; }
dl dt { float:left; }
dl dd { float:right; }
dl.three { line-height:25px; width:350px; }
dl.three dt { width:90px; }
dl.three dd { padding:0 0 0 20px; }
dl.three input.textfield { width:185px; margin:2px 0; }
dl.three dd select { margin:0 0 2px 0; width:193px; }
.box { padding:15px 25px; clear:both; color:#575757; }
.box2 { padding:5px 25px; clear:both; color:#575757; }    
.box-add { float:left; width:300px; }
.box-add dl { padding:4px 0; }
.box-add dl dt input.textfield { width:292px; }
.box-add dl dd input.textfield { width:180px; }
.box-add dl dd select { width:188px; }
.box-edit { float:right; padding:10px; width:250px; background:#fff; border:1px solid #ccc; }

ul.em { list-style:none; }
ul.em li { display:block; padding:3px 10px; background:#e5e5e5; border:1px solid #999; margin:2px 0; }
ul.em ul { list-style:none; margin:3px 0 0 0; }
ul.em ul li { background:#f5f5f5; }
ul.em li.nochild div, ul.em ul li div { float:right; margin-right:-6px; opacity:0; }
ul.em li.nochild:hover div, ul.em ul li:hover div { opacity:1; }

.row-title { height:36px; line-height:36px; border:1px dotted #63A2D4; background:#fff; font-weight:bold; clear:both; }
.row-item { height:36px; line-height:36px; border:1px dotted #63A2D4; border-top:0; clear:both; }
.row-default { background:#ddd; }
.order-id { float:left; width:70px; text-align:center; }
.order-id2 { float:left; width:50px; text-align:center;  border-right:1px dotted #63A2D4; }
.order-customer { float:left; width:150px; padding:0 10px; border-left:1px dotted #63A2D4; }
.order-date { float:left; width:80px; text-align:center; border-left:1px dotted #63A2D4; }
.order-total { float:left; width:70px; text-align:center; border-left:1px dotted #63A2D4; }
.order-status { float:left; width:80px; text-align:center; border-left:1px dotted #63A2D4; }
.order-func { float:left; border-left:1px dotted #63A2D4; width:49px; text-align:center; }
.order-func img { padding:3px 0; }
.order-func2 { float:left; border-left:1px dotted #63A2D4; width:99px; text-align:center; }
.cust-fname { float:left; padding:0 10px; width:140px; }
.cust-uname { float:left; padding:0 10px; width:150px; border-left:1px dotted #63A2D4; }
.cust-email { float:left; padding:0 24px; border-left:1px dotted #63A2D4; }
.cat-name { float:left; padding:0 10px; }
.cat-name input.textfield { margin:4px 0 0 0; float:left; }
.cat-name input.button { margin:4px 0 0 4px; float:left; }
.quick-func { height:36px; float:right; width:100px; text-align:center; border-left:1px dotted #63A2D4; }
.cat-func { float:right; width:50px; text-align:center; border-left:1px dotted #63A2D4; }
.cat-func2 { float:right; width:80px; text-align:center; border-left:1px dotted #63A2D4; }
.quick-func img { padding:3px 0; }
.cat-func input { }
.cat-func a:focus { outline:none; }
.customer-name { float:left; padding:0 10px; }
.total { float:right; text-align:center; width:60px; border-left:1px dotted #63A2D4; }
.box-1 h3 { }
.box-1 .row-item { height:36px; line-height:36px; }
.box-1 .cat-func img { padding:1px 0; }


.box-edit2 {width:300px; margin:20px 0 10px 10px; }
ul.em2 { list-style:none; }
ul.em2 li { display:block; padding:3px 10px; background:#e5e5e5; border:1px solid #999; margin:2px 0; }
ul.em2 ul { list-style:none; margin:3px 0 0 0; }
ul.em2 ul li { background:#f5f5f5; }
ul.em2 li div, ul.em ul li div { float:right; margin-right:-6px; opacity:0; position:relative; }
ul.em2 li :hover div, ul.em ul li:hover div { opacity:1; }

#sortable { list-style-type: none; margin: 0; padding: 0; }
#sortable li { background:#e5e5e5; border:1px solid #999; margin: -2px 3px 3px 0; padding: 4px 2px 3px 10px; width: 400px; height: 20px; font-size: 12px; text-align: left; }
#sortable li img {padding:1px; cursor: pointer; }
#sortable li img {padding:1px; cursor: pointer; float:right; margin-top:-15px; opacity:0; position:inherit; }
#sortable li:hover img { opacity:1; }
.ui-state-default, .ui-widget-content .ui-state-default{border:none; background:none;}

</style>

<div id="popup-box">
    <div id="sale-content">
        
    </div>
</div>
<div id="background-popup"></div>

  <div class="left">
 	<h1>Store Management</h1>
		    <div class="bar">

            	<div class="text">Manage Page</div>
            	<div class="cr"></div>
            </div>
 

            <div class="box">
                <p>
                   
                    <div style="margin-top:20px;margin-bottom:10px;" >
             Category :
             <form name="form_category" id="form_category" action="<?=base_url()?>admin/cms/get_page_by_category" method="post">
             <select name="category" id="category" onchange="document.form_category.submit();">
             	<?php foreach($categories as $category) { ?>
                	<option value="<?=$category['id']?>" <? if($cat==$category['id']){echo "selected=selected";}?> ><?=$category['name']?></option>
                <? } ?>
             </select>
             </form>
             <br />
              <input type="button" class="button rounded" value="Add new page" onclick="addpage()" />
             </div>
                </p>
            </div>            
           
      		 <div class="box-edit2" id="list2" style="margin-left:25px;">    	
             
             <p style="color:#575757">
             
                <ul id="sortable">
                <?php foreach($pages as $page) { ?>
                    
                    <li id="<?=$page['id']?>" class="ui-state-default"><a href="<?=base_url()?>admin/cms/editpage/<?=$page['id']?>" title="Edit this news"><?=$page['title']?></a> <div><a href="javascript:deletepage(<?=$page['id']?>)" title="Delete this news"><img src="<?=base_url()?>img/delete2.png" /></a></div></li>
                    <?
                } ?>        
                </ul>
            </div>  
            <form name="posform" id="posform" method="post" action="<?=base_url()?>admin/cms/listnewsorder">
            <input type="hidden" name="pos" id="pos" />    
             <input type="hidden" name="id" id="id" value="<?=$cat?>" />           
            </form>    
</div>        