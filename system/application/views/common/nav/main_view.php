<?php
	$nav_array = array(
						array('category' => 1, 'label' => 'new arrivals', 'store_url' => base_url()),
						array('category' => 2, 'label' => 'women\'s', 'store_url' => base_url().'store/product/Womens/'),	
						array('category' => 3, 'label' => 'men\'s', 'store_url' => base_url().'store/product/Mens/'),
						array('category' => 4, 'label' => 'sale', 'store_url' => base_url().'store/products/sale/'),
						array('category' => 5, 'label' => 'why bared?', 'store_url' => base_url().'store/product/Womens/'),
						array('category' => 6, 'label' => 'gallery', 'store_url' => base_url().'store/product/Womens/'),
						array('category' => 7, 'label' => 'press', 'store_url' => base_url().'store/product/Womens/'),
						array('category' => 8, 'label' => 'contact us', 'store_url' => base_url().'store/product/Womens/')	
					);
?>

<nav>
	<div id="top-nav" class="app-container collapse">
    	<ul class="nav navbar-nav">
        	<?php 
				foreach($nav_array as $nav){ 
					$categories = $this->Category_model->get($nav['category']);
			?>
            	<li class="dropdown">
                	<a href="<?=$nav['label'] == 'sale' ? $nav['store_url'] . 'all' : 'javascript_void(0);'?>" <?=$nav['label'] != 'sale' ? 'class="dropdown-toggle" data-toggle="dropdown"' : '';?> ><?=$nav['label'];?></a>
			<?php 
					if(count($categories) > 0){
						$this->load->view('common/nav/sub_nav', array('categories' => $categories, 'nav' => $nav));
					}
			?>
            	</li>
            <?php } ?>
        </ul>
    </div>
</nav>