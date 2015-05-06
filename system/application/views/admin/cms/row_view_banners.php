<?php foreach($banners as $banner){ ?>
      <tr>
          <td  width="80%">
              <img style="width:50%;" src="<?=base_url()?>uploads/banners/ori2/<?=$banner['name']?>" />
          </td>
          
          <td  valign="top" width="20%">
          <div class="icon" style="margin-left:20px;">
                  <a style="text-decoration:none;" href="javascript:change_status(<?=$banner['id']?>);" title="Active this banner">                            
                  <i <?php if(!$banner['actived']){echo 'style="color: #d6d6d6"';}else {echo 'style="color: #00c717"';}?> class="icon-ok-circle icon-2x"></i>
                  </a>
                  <a style="text-decoration:none;" href="javascript:deletebanner(<?=$banner['id']?>)"><i style="color: #c70520" class="icon-remove-circle icon-2x"></i></a>
           </div>
          </td>
      </tr>
      <tr>
          <td  width="80%">
              <form id="update-form-<?=$banner['id'];?>">
                  <input type="hidden" name="banner_id" value="<?=$banner['id']?>" />
                  <div style="height: 5px; clear: both">&nbsp;</div> 
                  <p style="width: 55px; margin-top: 6px; height: 10px;">Category:</p>
                  <select name="banners-category" id="banners-filter">
                      <option  value="<?=MEN?>"<?php if($banner['category'] == MEN){echo "selected";} ?>>Male</option>
                      <option  value="<?=WOMEN?>"<?php if($banner['category'] == WOMEN){echo "selected";} ?>>Female</option>
                  </select> 
                  <p style="width: 55px; margin-top: 5px; height: 10px;">Caption:</p>
                  <input type="text" class="textfield rounded" style="margin-bottom:5px!important;" name="caption" value="<?=$banner['caption']?>" />
                  
                  <p>Link to when click (<?=$banner['hit']?> times)</p>
                  <input type="text" class="textfield rounded" style="margin-bottom:0px!important;" name="url" value="<?=$banner['url']?>" />
                  <button class="btn btn-primary" type="button" onClick="update_banner(<?=$banner['id'];?>);">Update</button>
                  <span id="update-msg-<?=$banner['id'];?>" class="text-success hide" style="padding-left:15px;">Banner update successfully</span>
              </form>
              
          </td>
          <td>&nbsp;</td>
      </tr>
            
<?php } ?>