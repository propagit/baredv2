<?php require_once($_SERVER['DOCUMENT_ROOT'].'/svc/cuteeditor_files/include_CuteEditor.php');?>
<script>
function addlink()
{
    if ($j('#title').val() == "") {
        alert('Please enter a title for the page');
    } else {
        document.addForm.submit();
    }
}
</script>
<style>

body{
	color:#B9B2AE;
}
#content_text{
	color:#B9B2AE;
}
.CuteEditorFrameContainer
{
	color:#B9B2AE;
}
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
        
        
        <form name="addForm" method="post" action="<?=base_url()?>admin/cms/createpage" enctype="multipart/form-data">
        <table>
        
        <tr>
        	<td> Title  </td>
        </tr>
        <tr>
        	<td> <input type="text" class="input_text" name="title" id="title" /> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
        <td>
        Category </td>
        </tr>
        <tr>
        <td>
        <select id="category" name="category">
        <option value="0">No Category</option>
            <?
            foreach($categories as $category){
                ?>
                <option value=<?=$category['id']?> ><?=$category['name']?></option>
                <?
            }
            ?>
        </select>
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td>Content</td>
        </tr>
        
        <tr>
			<td>
       <span id="template" style="color:#646464;">
		<?php
           
			/*$this->Cute_model->init();	
            $this->Cute_model->ID ="content_text";
            $this->Cute_model->UseHTMLEntities = true;
            $this->Cute_model->EditorWysiwygModeCss = base_url()."css/template.css";			
            $this->Cute_model->setWidth("600px");
            $this->Cute_model->setHeight("425px");			
            $this->Cute_model->Draw();
            $this->Cute_model = null;*/
			
			$editor=new CuteEditor();   
	        //$editor->Text=$pages['content'];	
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
        <tr><td>&nbsp;</td></tr>
         <tr>
        	<td> Background Page  </td>
        </tr>
        <tr>
        	<td> <input type="file" name="userfile" style="width:400px; height:25px;color:#665e44;font-size:12px;padding:3px;" /> </td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        <!--
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
                <option value=<?=$menu['id']?> ><?=$menu['name']?></option>
                <?
            }
            ?>
        </select>
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        -->
        <tr>
        <td>
        <input type="button" class="button rounded" value="Add" onclick="addlink()"  />
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        </table>
        </form>
    </div>
</div>
