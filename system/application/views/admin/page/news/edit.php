<script>
function updatepage()
{
    if ($j('#title').val() == "") {
        alert('Please enter a title for the page');
    } else {
        document.updateForm.submit();
    }
}
function delete_image(id)
{
    if (confirm('Are you sure you want to do this?')) {
        var url = "<?=base_url()?>admin/cms/delete_image/";
        url = url + id;
        window.location = url;
    } else {
        return false;
    }
}
function delete_image2(id)
{
    if (confirm('Are you sure you want to do this?')) {
        var url = "<?=base_url()?>admin/cms/delete_image2/";
        url = url + id;
        window.location = url;
    } else {
        return false;
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
.box-add { float:left; width:300px; }
.box-add dl { padding:4px 0; }
.box-add dl dt input.textfield { width:292px; }
.box-add dl dd input.textfield { width:180px; }
.box-add dl dd select { width:188px; }
.box-edit { float:right; padding:10px; width:250px; background:#fff; border:1px solid #ccc; }


</style>
<link href="<?=base_url()?>css/template.css" rel="stylesheet" type="text/css">
<div id="left-content">
    <div class="content-title"><img src="<?=base_url()?>images/admin/title-site-control.png" />        
    </div>
    <div class="bar-title"><div>Manage News</div></div>    
    
    
    <div class="box"><br />
    <div class="box-add">
        
         <?php
			if ($this->session->flashdata('error_upload')) 
			{
				print $this->session->flashdata('error_upload');
			}
		?>
        <form name="updateForm" method="post" action="<?=base_url()?>admin/cms/updatenews" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<?=$pages['id']?>">
        <table>
        <tr>
        	<td> Title  </td>
        </tr>
        <tr>
        	<td> <input type="text" style="width:400px; height:25px;color:#665e44;font-size:12px;padding:3px;" name="title" id="title" value="<?=$pages['title']?>" /> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td>Content</td>
        </tr>
        
        <tr>
			<td>
            <?
			/*
			$c1=str_replace('&lt;','<',$pages['content']);
			$c2=str_replace('&gt;','>',$c1);		
			$contents = str_replace('<style type="text/css">@import url(/10feettall2/css/template.css);</style>','', $c2);
			$text=$contents;
			if($text=='')
			{
				$text=$pages['content'];
			}*/
			//$text=$pages['content'];
			?>
            
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
            $this->Cute_model->setHeight("325px");
            $this->Cute_model->Text =$pages['content'];			
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
			
			
			/*$c1=str_replace('&lt;','<',$pages['media']);
			$c2=str_replace('&gt;','>',$c1);		
			$contents = str_replace('<style type="text/css">@import url(/10feettall2/css/template.css);</style>','', $c2);
			$text=$contents;
			*/
            $this->load->model('Cute_model2');
			$this->Cute_model2->init();	
            $this->Cute_model2->ID ="content_media";
            $this->Cute_model2->UseHTMLEntities = true;
            $this->Cute_model2->EditorWysiwygModeCss = "/10feettall2/css/template.css";			
            $this->Cute_model2->FilesPath = "/10feettall2/js/cute";
            $this->Cute_model2->setConfigure("Compact");	
            $this->Cute_model2->setWidth("400px");
            $this->Cute_model2->setHeight("425px");
            $this->Cute_model2->Text = $pages['media'];
            $this->Cute_model2->Draw();
            $this->Cute_model2 = null;
        ?>
        </span>
		</td>
        </tr>
        
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
</div>
