<?php
	# this code is very bad, fix it later when there is more time
?>
<div class="col-sm-4">
    <ul class="quick-links">
        <li><h5>customer care</h5></li>
        <?php
			$categories = $this->Category_model->get(9);
		  	foreach($categories as $ct)
		  	{
			  
			  if($ct['type']==0){
				  $texts=$this->Product_model->get_name_keyword($ct['title']);											
				  if($texts){
				  ?>									    
					  <li><a href="<?=base_url()?>store/products/Handbags/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a></li>						<? }else{ ?>
					  <li><a href="#"><?=$ct['title']?></a></li>
				  <? } ?>
		  <?php }
			  else
			  { 
				  if($ct['external_link']!='')
				  {														
					  ?><li><a target="_blank"  href="<?=$ct['external_link']?>"><?=$ct['title']?></a></li><?                                
				  }
				  else
				  {
					  $pages = $this->Menu_model->getpage($ct['id_page']);
					  if($pages)
					  {
					  if($pages['display']==0){
					  ?>
						  <? $pages = $this->Menu_model->getpage($ct['id_page']);?>					                                    
						  <li><a  href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
					  
					  <? } else {
					  ?>
					  <li><a onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a></li>
					  <?
					  }
					  }
					  else {
						  
						  $pages = $this->Menu_model->getpage($ct['id_page']);
						  if(isset($pages['title_id'])){
						  ?>					                                    
						  <li><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
						  <?
						  }
					  }
				  }
			  }
		  }
		  
?>
    </ul>   
</div>


<div class="col-sm-4">
    <ul class="quick-links">
        <li><h5>fitting options</h5></li>
        <?
                    $categories = $this->Category_model->get(10);
					foreach($categories as $ct)
                    {

						if($ct['type']==0){
							$texts=$this->Product_model->get_name_keyword($ct['title']);											
							if($texts){
							?>									    
								<li><a   href="<?=base_url()?>store/products/Handbags/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a></li>
							<? }else{ ?>
								<li><a   href="#"><?=$ct['title']?></a></li>
							<? } ?>
					<?php }
						else
						{ 
							if($ct['external_link']!='')
							{
						
								?><li><a target="_blank"  href="<?=$ct['external_link']?>"><?=$ct['title']?></a></li><?
							}
							else
							{
								$pages = $this->Menu_model->getpage($ct['id_page']);
								
								
								if($pages)
								{
								if($pages['display']==0){
								?>
                                 <? $pages = $this->Menu_model->getpage($ct['id_page']);?>					                                    
                                    <li><a  href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
                                <? } else {
								?>
								<li><a   onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a></li>
								<?
								}
								}
								else {
									
									$pages = $this->Menu_model->getpage($ct['id_page']);
									?>					                                    
                                    <li><a  href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
									<?
								}
							}
						}
					}
					?>
    </ul>
</div>

<div class="col-sm-4">
  <ul class="quick-links">
      <li><h5>your account</h5></li>
       <?
                    $categories = $this->Category_model->get(11);
					foreach($categories as $ct)
                    {
						
						if($ct['id']==111)
						{
							if($this->session->userdata('userloggedin'))
							{
								$user = $this->session->userdata('userloggedin');
								if($user==1){$cust = $this->Customer_model->identify(1);}
								else{
									$cust = $this->Customer_model->identify($user['customer_id']);
								}
								if($user['level'] == 1)
								{
								?>
									<li><a  href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">Login</a></li>
								<?
								}
								else if($user['level'] == 2)
								{
								?>
									<li><a  href="<?=base_url()?>store/edit_detail_trade/<?=$cust['id']?>">Login</a></li>
								<?
								}else if($user['level'] == 9)
								{
									?>
									<li><a  href="#">Login</a></li>
									<?
								}
							}
							else
							{
								?><li><a  href="<?=base_url()?>store/register">Login</a></li><?
							}
						}
						else
						{
							if($ct['type']==0){
								$texts=$this->Product_model->get_name_keyword($ct['title']);											
								if($texts){
								?>									    
									<li><a  href="<?=base_url()?>store/products/Handbags/shop_by/<?=$texts['text']?>/<?=$texts['id']?>"><?=$texts['name']?></a></li>
								<? }else{ ?>
									<li><a  href="#"><?=$ct['title']?></a></li>
								<? } ?>
							<?php }
							else
							{ 
								if($ct['external_link']!='')
								{
							
									?><li><a  href="<?=$ct['external_link']?>"><?=$ct['title']?></a></li><?
								}
								else
								{
									$pages = $this->Menu_model->getpage($ct['id_page']);
									if($pages)
									{
									if($pages['display']==0){
									?>
                                     <? $pages = $this->Menu_model->getpage($ct['id_page']);?>					                                    
                                    <li><a  href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
                                    <? } else {
									?>
									<li><a   onclick="open_window('<?=base_url()?>store/page/<?=$ct['id_page']?>')"><?=$ct['title']?></a></li>
									<?
									}
									}
									else {
									
									$pages = $this->Menu_model->getpage($ct['id_page']);
									?>					                                    
                                    <li><a  href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
									<?
									}
								}
							}
						}
					}
					?>
  </ul>
</div>

