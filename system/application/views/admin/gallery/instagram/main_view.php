<script src="<?=base_url()?>js/ui/jquery-ui-1.11.1.min.js"></script>
<script>
/*** Handle jQuery plugin naming conflict between jQuery UI and Bootstrap ***/
$.widget.bridge('uibutton', $.ui.button);
$.widget.bridge('uitooltip', $.ui.tooltip);
</script>
<!--reload bootstrap.js again-->
<script src="<?=base_url()?>js/bootstrap.js"></script>
<div class="span9">
	<div class="box">
    	<div class="page-padding">
            <h1>
                Manage Instagram Gallery
            </h1>
            <h2>Add new gallery item</h2>
            <p>
                <span><em>Ideal image size: 872px x 872px<br>All image should be of same width & height for optimum result.</em></span><br><br>
            
                Add a new image by browsing your computer and uploading a file. The image files accepted for upload include, (.jpg , .gif , .png)<br><br>
            </p>
        </div>
        
        <div class="page-padding">
        	<?php $this->load->view('admin/gallery/instagram/form_view'); ?>
            <div class="page-breaker">&nbsp;</div>
        </div>
        
        
        
        <div class="page-padding">
        	<?php $this->load->view('admin/gallery/instagram/gallery_items/list_view'); ?>
            <div class="page-breaker">&nbsp;</div>
        </div>
        
        
    </div>
	

</div>