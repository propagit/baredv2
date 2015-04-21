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
dl { clear:both; }
dl dt { float:left; }
dl dd { float:right; }
dl.three { line-height:25px; width:350px; }
dl.three dt { width:90px; }
dl.three dd { padding:0 0 0 20px; }
dl.three input.textfield { width:185px; margin:2px 0;  height:30px;}
dl.three dd select { margin:0 0 2px 0; width:193px; }
.box { padding:15px 25px; clear:both; color:#575757; }
.box-add { float:left; width:300px; }
.box-add dl { padding:4px 0; }
.box-add dl dt input.textfield { width:292px; height:30px;}
.box-add dl dd input.textfield { width:180px; height:30px; }
.box-add dl dd select { width:188px; }
.box-edit { float:right; padding:10px; width:250px; background:#fff; border:1px solid #ccc; }
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
#CE_media_ID_ToolBar
{
	height:auto!important;
}
</style>
<link href="<?=base_url()?>css/template.css" rel="stylesheet" type="text/css">
<div id="left-content">
    <div class="content-title"><img src="<?=base_url()?>images/admin/title-site-control.png" />        
    </div>
    <div class="bar-title"><div>Manage News</div></div>    
    
    
    <div class="box"><br />
    <div class="box-add">
        
        
        <form name="addForm" method="post" action="<?=base_url()?>admin/cms/createnews" enctype="multipart/form-data">
        <table>
        <tr>
        	<td> Title  </td>
        </tr>
        <tr>
        	<td> <input type="text" style="width:400px; height:25px;color:#665e44;font-size:12px;padding:3px;" name="title" id="title" /> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td>Content</td>
        </tr>
        
        <tr>
			<td>
        <span id="template" style="color:#6f6e66;">
		<?php
            //$this->load->model('Cute_model');
			$this->Cute_model->init();	
            $this->Cute_model->ID ="content_text";
            $this->Cute_model->UseHTMLEntities = true;
            $this->Cute_model->EditorWysiwygModeCss = "/10feettall2/css/template.css";			
            $this->Cute_model->FilesPath = "/10feettall2/js/cute";
            $this->Cute_model->setConfigure("Simple");	
            $this->Cute_model->setWidth("400px");
            $this->Cute_model->setHeight("300px");
            $this->Cute_model->Text = '';			
            $this->Cute_model->Draw();
            $this->Cute_model = null;
        ?>
        </span>
		</td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        
        <tr>
			<td>
        <span id="template" style="color:#6f6e66;">
		<?php
            $this->load->model('Cute_model2');
			$this->Cute_model2->init();	
            $this->Cute_model2->ID ="content_media";
            $this->Cute_model2->UseHTMLEntities = true;
            $this->Cute_model2->EditorWysiwygModeCss = "/10feettall2/css/template.css";			
            $this->Cute_model2->FilesPath = "/10feettall2/js/cute";
            $this->Cute_model2->setConfigure("Sample");	
            $this->Cute_model2->setWidth("400px");
            $this->Cute_model2->setHeight("425px");
            $this->Cute_model2->Text = '';			
            $this->Cute_model2->Draw();
            $this->Cute_model2 = null;
        ?>
        </span>
		</td>
        </tr>
        
        <tr><td>&nbsp;</td></tr>
        <!--
        <tr>
        <td>
        Video Link  </td>
        </tr>
        <tr>
        <td>
       	<input type="text" style="width:400px; height:25px;color:#B9B2AE;font-weight:bold; font-size:15px;padding:3px;" name="videolink" id="videolink" /> 
        
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td>
        Image 1  </td>
        </tr>
        <tr>
        <td>
        <input type="file" name="userfile" id="userfile" class="file" />
        
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td>
        Image 2  </td>
        </tr>
        <tr>
        <td>
        <input type="file" name="userfile2" id="userfile2" class="file" />
        
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
</div>
