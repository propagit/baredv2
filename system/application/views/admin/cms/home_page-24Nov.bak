<div id="left-content">
	<div class="content-title">
    	<img src="<?=base_url()?>images/admin/title-site-control.png" />        	
    </div>
    <div class="bar-title"><div>Manage Home Page</div></div>
    <div class="content-area">
    
   
   
     <h2>Left Box Content</h2>
     <form name="updateHomePageForm" method="post"  action="<?=base_url()?>admin/cms/updating_home_page_content">
   
       <?
	   $content = array('','','');
	   if($page['content'] != '')
	   {
	   $content = explode("~~",$page['content']);
	   }
	   ?>
         <div>
    <?php	
	       
			
			$this->Cute_model_third->ID="left_box";
			$this->Cute_model_third->Text = $content[0];
			$this->Cute_model_third->EditorBodyStyle="font:normal 12px arial;";
			$this->Cute_model_third->EditorBodyStyle="color: #474747;";
			$this->Cute_model_third->UseHTMLEntities = true;
			$this->Cute_model_third->EditorWysiwygModeCss=base_url()."css/template.css";			
			//$this->Cute_model_third->FilesPath=base_url()."js/cute";
			$this->Cute_model_third->Draw();
			$this->Cute_model_third = null;			
			?>
        </div>
        <br/>
    
     <h2>Middle Box Content</h2>
    
       
         <div>
    <?php	
	       
			
			$this->Cute_model_second->ID="middle_box";
			$this->Cute_model_second->Text = $content[1];
			$this->Cute_model_second->EditorBodyStyle="font:normal 12px arial;";
			$this->Cute_model_second->EditorBodyStyle="color: #474747;";
			$this->Cute_model_second->UseHTMLEntities = true;
			$this->Cute_model_second->EditorWysiwygModeCss=base_url()."css/template.css";			
			//$this->Cute_model_second->FilesPath=base_url()."js/cute";
			$this->Cute_model_second->Draw();
			$this->Cute_model_second = null;			
			?>
        </div> 
      <p>&nbsp;</p>
       <h2>Right Box Content</h2>
    
       
         <div>
    <?php	
	       
			
			$this->Cute_model_fourth->ID="right_box";
			$this->Cute_model_fourth->Text = $content[2];
			$this->Cute_model_fourth->EditorBodyStyle="font:normal 12px arial;";
			$this->Cute_model_fourth->EditorBodyStyle="color: #474747;";
			$this->Cute_model_fourth->UseHTMLEntities = true;
			$this->Cute_model_fourth->EditorWysiwygModeCss=base_url()."css/template.css";			
			//$this->Cute_model_fourth->FilesPath=base_url()."js/cute";
			$this->Cute_model_fourth->Draw();
			$this->Cute_model_fourth = null;			
			?>
        </div> 
      
    <p>    	
    	<a href="#"><input type="button" class="button rounded" value="Update Home Page" onclick="document.updateHomePageForm.submit()" /></a></p>
  
    </form>
   </div>          
</div>