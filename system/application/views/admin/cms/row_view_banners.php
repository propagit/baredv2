<?php foreach($banners as $banner){ ?>
    <table align="center" style="padding-left: 7px;">
            	<tr>
                	<td align="center" width="80%">
                    	<a href="<?=base_url()?>uploads/banners/<?=$banner['name']?>"><img style="width:50%;height:50%;" src="<?=base_url()?>uploads/banners/ori2/<?=$banner['name']?>" /></a>
                    </td>
                    
                    <td align="center" valign="top" width="20%">
                    <div class="icon" style="margin-left:20px;">
                            <a style="text-decoration:none;" href="<?=base_url()?>admin/cms/activebanner/<?=$banner['id']?>/<?=$temp?>/retail" title="Active this banner">                            
                            <i <?php if(!$banner['actived']){echo 'style="color: #d6d6d6"';}else {echo 'style="color: #00c717"';}?> class="icon-ok-circle icon-2x"></i>
                            </a>
                            <a style="text-decoration:none;" href="javascript:deletebanner(<?=$banner['id']?>)"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></a>
                     </div>
                    </td>
                </tr>
                <tr>
                	<td align="center" width="80%">
                    	<form method="post" action="<?=base_url()?>admin/cms/updatebanner">
                        <input type="hidden" name="banner_id" value="<?=$banner['id']?>" />
                        <div style="height: 5px; clear: both">&nbsp;</div> 
                        <p style="width: 55px; margin-top: 5px; height: 10px;">Caption:</p>
                        <input type="text" class="textfield rounded" style="margin-bottom:5px!important;" name="caption" value="<?=$banner['caption']?>" />
                        <p style="width: 55px; margin-top: 6px; height: 10px;">Category:</p>
                        <select name="banners-category" id="banners-filter">
                            <option  value="0" <?php if($banner['category']==0){echo "selected";} ?>>All</option>
                            <option  value="1"<?php if($banner['category']==1){echo "selected";} ?>>Male</option>
                            <option  value="2"<?php if($banner['category']==2){echo "selected";} ?>>Female</option>
                        </select> 
                        <p>Link to when click (<?=$banner['hit']?> times)</p>
                        <input type="text" class="textfield rounded" style="margin-bottom:0px!important;" name="url" value="<?=$banner['url']?>" />
                        <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>
            <div style="height: 10px; clear: both">&nbsp;</div>
<?php } ?>