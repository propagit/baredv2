<ul class="dropdown-menu" role="menu">
<?php 
	foreach($categories as $ct){
		if($ct['type']==0){
			# products
			$texts = $this->Product_model->get_name_keyword($ct['title']);
			$cat = $this->Category_model->identify_by_title($ct['title']);
			
			# for products get store url from nav array
			# file location views/common/nav/main_view.php
?>
				<li><a href="<?=$nav['store_url'] . ( $ct['show_all'] == 1 ? 'all' : $ct['name'] )?>"><?=$ct['title'];?></a></li>
<?php
			
		}else{
			# page	
			if($ct['external_link']!=''){
				# if this is an external link
?>
				<li><a target="_blank" href="<?=$ct['external_link']?>"><?=$ct['title']?></a></li>
<?php
			}else{
				# for internal links get the page
				$pages = $this->Menu_model->getpage($ct['id_page']);
?>
			   <li><a href="<?=base_url()?>page/<?=$pages['title_id']?>"><?=$ct['title']?></a></li>
<?php
			}
			
		} # if, else ct type
	} # foreach categories as ct
?>
</ul>
