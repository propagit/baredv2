<?php require_once($_SERVER['DOCUMENT_ROOT'].'/svc/cuteeditor_files/include_CuteEditor.php');?>

<script>
$j(function() {
	
	$j('#backbutton').click(function(){
		window.location = '<?=base_url()?>admin/cms/page';
	});
});
function updatepage()
{
    if ($j('#title').val() == "") {
        alert('Please enter a title for the page');
    } else {
        document.updateForm.submit();
    }
}
function delete_background(id)
{
	$j.ajax({
			url: '<?=base_url()?>admin/cms/removebackground/',
			type: 'POST',
			data: ({id:id}),
			dataType: "html",
			success: function(html) {
				$j("#background").hide();
			}
		})
}
function change (el) {

var max_len = 70;
if (el.value.length > max_len) {
el.value = el.value.substr(0, max_len);
}
document.getElementById('char_cnt').innerHTML = el.value.length;
document.getElementById('chars_left').innerHTML = max_len - el.value.length;
return true;
}

function change2 (el) {

var max_len = 150;
if (el.value.length > max_len) {
el.value = el.value.substr(0, max_len);
}
document.getElementById('char_cnt2').innerHTML = el.value.length;
document.getElementById('chars_left2').innerHTML = max_len - el.value.length;
return true;
}

</script>
<style>
.input_text
{
	width:300px; height:25px;color:#00002A;font-size:12px;padding:3px;
}

</style>
<link href="<?=base_url()?>css/template.css" rel="stylesheet" type="text/css">
<div class="left">
    <h1>Website Management</h1>
            <div class="bar">

            	<div class="text">Manage Page &raquo; Page Details</div>
            	<div class="cr"></div>
            </div>

    <div class="box">
	<input type="button" class="button rounded" id="backbutton" value="Back to Page List" />
</div>
<hr />
    
    
    <div class="box bgw">
        
        
        <form name="updateForm" method="post" action="<?=base_url()?>admin/cms/updatepage" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<?=$pages['id']?>">
        <table>
        <!-- 
        <tr>
        <td>
        Parent </td>
        </tr>
        <tr>
        <td>
        <select id="category" name="category">
        <option value="0">No Category</option>
            <?
            foreach($categories as $category){
                ?>
                <option value=<?=$category['id']?> <? if($pages['category']==$category['id']){echo "Selected=selected;";}?>><?=$category['name']?></option>
                <?
            }
            ?>
        </select>
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        -->
        <tr>
        	<td> Meta Keywords  <span id="char_cnt">0</span> /<span id="chars_left">70</span> </td>
        </tr>
        <tr>
        	<td> <input type="text" class="input_text" name="meta_title" id="meta_title" value="<?=$pages['meta_title']?>" maxlength="70" onkeyup="change(this);" /> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td> Meta Description  <span id="char_cnt2">0</span> /<span id="chars_left2">150</span>  </td>
        </tr>
        <tr>
        	<td> <input type="text" class="input_text" name="meta_description" id="meta_description" value="<?=$pages['meta_description']?>" maxlength="150" onkeyup="change2(this);"/> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>        
        <tr>
        	<td> Title  </td>
        </tr>
        <tr>
        	<td> <input type="text" class="input_text" name="title" id="title" value="<?=$pages['title']?>" /> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td>Content</td>
        </tr>
        
        <tr>
			<td>
        <span id="template" style="color:#646464;">
		<?php
           /*
			$this->Cute_model->init();	
            $this->Cute_model->ID ="content_text";
            $this->Cute_model->UseHTMLEntities = true;
            $this->Cute_model->EditorWysiwygModeCss ="/svc/css/template.css";			
            $this->Cute_model->setWidth("600px");
            $this->Cute_model->setHeight("425px");
            $this->Cute_model->Text = $pages['content'];			
            $this->Cute_model->Draw();
            $this->Cute_model = null;
			*/
			$editor=new CuteEditor();   
	        $editor->Text=$pages['content'];	
			$editor->Width="600px";
			
			$editor->EditorWysiwygModeCss ="/svc/css/template.css";			
			$editor->AutoConfigure="Default";			
            //Step 3: Set a unique ID to Editor   
            $editor->ID="content_text"; 
            //Step 4: Render Editor   
            $editor->Draw();   
			$editor=null;  
        ?>
        </span>
		</td>
        </tr>
         <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        	<td> Background Page  </td>
        </tr>
        <tr>
        	<td> <input type="file" name="userfile" style="width:400px; height:25px;color:#665e44;font-size:12px;padding:3px;" />             	                
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td>
            	<img id="background" src="<?=base_url()?>uploads/pages/<?=$pages['background']?>"  />
               <br /> 
                <a style="cursor:pointer;" onclick="delete_background(<?=$pages['id']?>)">Delete Background</a>
            </td>
        </tr>
        <!--
        <tr>
        <td>&nbsp;</td>
        </tr>
      
      	<tr>
        <td>
        Parent </td>
        </tr>
        <tr>
        <td>
        <select id="menu" name="menu">
        <option value="0">No Parent</option>
            <?
            foreach($menus as $menu){
                ?>
                <option value=<?=$menu['id']?> <? if($pages['parent']==$menu['id']){echo "Selected=selected;";}?>><?=$menu['name']?></option>
                <?
            }
            ?>
        </select>
        </td>
        </tr>
        -->
        <tr><td>&nbsp;</td></tr>
        
        
       
        <tr>
        <td>
        <input type="button" class="button rounded" value="Update" onclick="updatepage()"  />
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        </table>                                       
        </form>
    </div>
    
    
    

</div>
