<script type="text/javascript" src="<?=base_url()?>js/jquery-sortable.js"></script>


<script>
$(function() {       
	//getcats();
	//getcats2(); 
	jQuery('.selectpicker').selectpicker();
	
	var cur_cat = 0;
	var group = jQuery('.sorted_table').sortable({	  	  
	  containerSelector: 'tbody',
	  itemSelector: 'tr',
	  placeholder: '<tr class="placeholder"/>',	 
	  onDrop: function(item, container, _super) {
      	update_order();
    	}
    
	
	})
	
	jQuery('#title-cat-104').click(function(){
		alert('test2');	
	});
	
	
});
</script>
<script>
jQuery(function() { load_category(); });
function reload_category() {
	jQuery('.sorted_table').sortable("enable");
	jQuery('.error').html('');
	load_category();
	
}
function update_order(){
	var indx=[];
	var i=1;
	jQuery('.tr_cat').each(function () {
		var id = $(this).attr("id");
		dtrp=id.replace('cat-','');
		indx[i]=dtrp;
		i=i+1;
		
	});
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/update_order/',
		type: 'POST',
		data: ({indx:indx}),
		dataType: "html",
		success: function(html) {
			
		}
	})
	
}
function load_category() {
	var cat_id = jQuery('#categories :selected').val();
	
	jQuery('#parent').val(cat_id);
	load_position(cat_id);
	load_subcat(cat_id);
	
}
function edit(id) {
	
	jQuery('.sorted_table').sortable("disable");
	if(jQuery('#title_link_'+id).length == 0)
	{
		var title = jQuery('#detail' + id).html();
		var title_link = jQuery('#detaillink' + id).html();
		//jQuery('#detail_cat-' + id).html("<input type='hidden' id='title_link_"+id+"' value='" + title_link +"'><input type='text' class='textfield rounded' value='" + title + "' id='title-cat-" + id + "' /> <br><input type='button' class='btn btn-primary' value='Update' onClick='update(" + id + ")' /> <input type='button' class='btn btn-primary' value='Cancel' onClick='cancel(" + id + ")' />");
		jQuery.ajax({
			url: '<?=base_url()?>admin/cms/editcatpage/',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				jQuery('#detail_cat-' + id).html(html);
				//jQuery('.sorted_table').sortable("disable");
				
				
			}
		})
		
	}
	else
	{
		cancel(id);
		
	}
	
}
function enable_sort()
{
	jQuery('.sorted_table').sortable("enable");
	
}
function cancel(id) {
	var title_link = jQuery('#title-cat-' + id).val();
	jQuery('#detail_cat-' + id).html(title_link);
	enable_sort();
	/*jQuery.ajax({
		url: '<?=base_url()?>admin/new_store/getcat/',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#cat-' + id).html(html);
		}
	})*/
		
}
function update(id) {
	var title = jQuery('#title-cat-' + id).val();
	
	if(jQuery('#page_category_dt'+id).length==1)
	{
		var page_id = jQuery('#page_category_dtr'+id).val();
		var external_link = jQuery('#page_category_elink'+id).val();
	}
	else
	{
		var page_id=0;
		var external_link = '';
	}
	//alert(external_link);
	var title_link = jQuery('#title_link_' + id).val();
	
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/updatecat/',
		type: 'POST',
		data: ({external_link:external_link,id:id,title:title,page_id:page_id}),
		dataType: "html",
		success: function(html) {
			jQuery('#detail_cat-' + id).html(title);
			//jQuery('#detaillinka'+id).html(title);
		}
	})	
	jQuery('.sorted_table').sortable("enable");
}
function move(step,id) {	
	window.location = '<?=base_url()?>admin/cms/movecat/' + id + '/' + step;
}
function delcat(id) {
	if(confirm('Are you sure you want to delete this sub category?')) {
		window.location = '<?=base_url()?>admin/cms/delcat/' + id;
	}
}
function load_position(cat_id) {
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getsubcatlist/',
		type: 'POST',
		data: ({id:cat_id}),
		dataType: "html",
		success: function(html) {
			jQuery("#position").html(html);
		}
	})
}
function load_subcat(cat_id) {
	jQuery.ajax({
		url: '<?=base_url()?>admin/cms/getsubcat/',
		type: 'POST',
		data: ({id:cat_id}),
		dataType: "html",
		success: function(html) {
			jQuery("#subcat").html(html);
		}
	})
}
function new_cat()
{
	//alert('aaa');
	centerPopup();
	loadPopup();
	jQuery('#name').focus();
}

function addcat() {
	if(jQuery('#name').val() == "") {
		alert('Please enter a name for new category');
	} else {
		//document.addForm.submit();
		jQuery('#addForm').submit();
	}
}
function change_page_detail_dt(id)
{
	var ids=jQuery('#page_category_dt'+id).val();
	jQuery.ajax({
			url: '<?=base_url()?>admin/cms/getsubcatpage2/',
			type: 'POST',
			data: ({id:ids}),
			dataType: "html",
			success: function(html) {
				jQuery("#dtdiv"+id).html(html);
			}
	})

}
function change_page_detail()
{
	var id=jQuery('#page_category').val();
		jQuery.ajax({
			url: '<?=base_url()?>admin/cms/getsubcatpage/',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				jQuery("#subcatpagediv").html(html);
			}
		})
}
function check_category_type()
{
	if ($("#optionsType1").is(":checked")) {		
		jQuery('#div_page').hide();
	}
	else
	if ($("#optionsType2").is(":checked")) {
		jQuery('#div_page').show();
		var id=jQuery('#page_category').val();
		jQuery.ajax({
			url: '<?=base_url()?>admin/cms/getsubcatpage/',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				jQuery("#subcatpagediv").html(html);
			}
		})
	}
}
function check_link()
{
	var links = jQuery('#external_link').val();
	if (links!='')
	{
		var n=links.search("http://");
		var m=links.search("https://");
	
		if(n==-1)
		{
			if(m==-1)
			{
				alert('Please make sure the external link has a http:// or https://');
			}
		}
	}
}
</script>
<style>
body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}
.sorted_table tr {
    cursor: pointer;
}
.sorted_table tr.placeholder {
    background: none repeat scroll 0 0 red;
    border: medium none;
    display: block;
    margin: 0;
    padding: 0;
    position: relative;
}
.sorted_table tr.placeholder:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: transparent -moz-use-text-color transparent red;
    border-image: none;
    border-style: solid none solid solid;
    border-width: 5px medium 5px 5px;
    content: "";
    height: 0;
    left: -5px;
    margin-top: -5px;
    position: absolute;
    width: 0;
}
.list_header
{
	height: 45px; line-height: 45px; font-weight: 900; font-size: 15px; float: left;
}
.list_data
{
	height: 45px; line-height: 45px; font-size: 14px; float: left;
}
.list_icon
{
	padding-top: 8px; cursor: pointer;
}
.list_center
{
	text-align: center;
}
.list_line
{
	clear: both; border-top: 1px solid #dedede;
}
</style>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<h1 style="padding-left: 7px">Manage Categories</h1>
            <div style="float: left; margin-right: 10px">
				<select id="categories" class="selectpicker" onchange="reload_category()">
                	
					<?php foreach($main_categories as $mc) { ?>
                    <option value="<?=$mc['id']?>"<?php if($mc['id'] == $this->session->userdata('parent_category')) print ' selected="selected"'; ?>><?=$mc['title']?></option>
                    <?php } ?>                   
                </select>                        
            </div>
            <div id="serialize_output"> </div>
            <!--
            <div style="float: left">
				<a style="color: #fff;" href="#myModal"  class="btn btn-primary" data-toggle="modal">Add New Categories</a>
			</div>				
            -->
			<div style="height: 10px; clear: both">&nbsp;</div>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            
            <form method="post" action="<?=base_url()?>admin/cms/category/add">
                <input type="hidden" name="parent_id" id="parent" />
            	<h2>Add new Sub Category</h2>
                <?=$this->session->flashdata('error_input')?>
                
                <div>
                    <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Name</div>
                    <div style="width: 80%; float: right">                    
                        <input style="width: 97%" class="textfield rounded" type="text" name="title" />                        
                    </div>
            	</div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <!--
                <div>
                    <div style="width: 20%; float: left; height: 30px; line-height: 30px;">Position</div>
                    <div style="width: 80%; float: right">                    
                        <select name="order">
                    		<option value="0">At the end</option>
                    	</select>                       
                    </div>
            	</div>                                
                -->
                <div>
                	<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Category Type</div>
                    <div style="width: 80%; float: right">                    
                        <input type="radio" name="optionsRadios" id="optionsType1" value="1" onChange="check_category_type()" checked style="margin-top:0px!important;"> Product
                        
                        <input type="radio" name="optionsRadios" id="optionsType2" value="2" onChange="check_category_type()" style="margin-top:0px!important; margin-left:10px;"> Page
                    </div>
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div>
                	<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Show All Parent Products</div>
                    <div style="width: 80%; float: right; margin-top: 5px;">                    
                        <input type="checkbox" name="show_all" id="show_all" value="1"/>
                    </div>
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div id="div_page" style="display:none;">
                <div>
                	<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Link To Page</div>
                    <div style="width: 80%; float: right">                    
                        <div>
                        	<select name="page_category" id="page_category" class="selectpicker" onchange="change_page_detail()">
                        	<?php foreach($main_categories as $mc) { ?>
                            <option value="<?=$mc['id']?>"<?php if($mc['id'] == $this->session->userdata('parent_category')) print ' selected="selected"'; ?>><?=$mc['title']?></option>
                    		<?php } ?>                   
                        	</select>
                        </div>
                        <div id="subcatpagediv">
                        	<select name="page_detail_category" id="page_detail_category" class="selectpicker">
                            	<option>Please Select..</option>
                        	</select>
                        </div>
                    </div>
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div>
                	<div style="width: 20%; float: left; height: 30px; line-height: 30px;">Link To External Page</div>
                    <div style="width: 80%; float: right">                    
                        <input type="text" name="external_link" id="external_link" onblur="check_link();"/>                        
                    </div>
                </div>
                </div>
                <div style="height: 5px; clear: both">&nbsp;</div>
                <div>
                	<div style="width: 20%; float: left; height: 30px; line-height: 30px;">&nbsp;</div>
                    <div style="width: 80%; float: right">						
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
            	</div>
            </form>
            
            <div style="height: 10px; clear: both">&nbsp;</div>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            
          	<h2>Categories List</h2>
            
            <div style="margin-top: 10px;" class="list_line"></div>
            
            <table class="table table-striped" id="table-1" >
            <thead>
                <tr style="font-size: 15px">
                    <th style="width: 60%">Category name</th>
                    <!--<th style="width: 15%; text-align: center;">Down</th>
                    <th style="width: 15%; text-align: center;">Up</th>-->
                    <th style="width: 10%; text-align: center;">Show All</th>
                    <th style="width: 10%; text-align: center;">Edit</th>
                    <th style="width: 10%; text-align: center;">Delete</th>
                </tr>
            </thead>
            <tbody id="subcat" class="sorted_table">
                <!-- <tr>
                    <td>page name</td>
                    <td style="text-align: center;">
                        <i class="icon-edit icon-2x"></i>
                    </td>
                    <td style="text-align: center;">
                        <i class="icon-share icon-2x"></i>
                    </td>
                    <td style="text-align: center;">
                        <i class="icon-camera icon-2x"></i>
                    </td>
                    <td style="text-align: center;">
                        <i class="icon-remove-circle icon-2x"></i>
                    </td>
                </tr> -->
            </tbody>
            
        	</table>
            
			<!-- end here -->
		</div>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Add New Category</h3>
</div>
<div class="modal-body">
<form name="addForm" id="addForm" method="post" action="<?=base_url()?>admin/new_store/addmaincat">
	<p>Name</p>
	<p><input type="text" class="textfield rounded" id="name" name="name" /></p>    
    
</form>    
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="addcat();">Save changes</button>
</form>
</div>
</div>

<div id="anyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Edit Title</h3>
</div>
<div class="modal-body">
<form name="addForm" method="post" action="<?=base_url()?>admin/new_store/addmaincat">
	<p>Title</p>
	<p><input type="text" class="textfield rounded" id="title" name="title" /></p>    
    
</form>    

</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>
