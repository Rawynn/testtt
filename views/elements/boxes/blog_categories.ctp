<?php if (module('BLOG')): ?>
	<?php
		$category_id = null;
		
		if (getCurrentPageController() == 'blog'):
			if (getCurrentPageAction() == 'index' && !empty($this->params['pass'][0])):
				/* Jeżeli listing -> pobieram aktualna kategorię */
				$category_id = $this->params['pass'][0];
			elseif (getCurrentPageAction() == 'show'):
				/* Jeżeli wpis -> pobieram kategorię główną wpisu */
				$category_id = getBlogItemMainCategoryId($this->params['pass'][0]);
			endif;
		
		endif;
		
		/* Pobieram drzewko kategorii */
		$categories = getBlogCategoryTree($category_id);
		
		/* Pobieram ścieżkę kategorii */
		$path = getBlogCategoryPath($category_id);
	?>
	
	<section class="categories-box aside-box blog-aside" data-type="categories-box">
		<a class="responsive-toggle" data-type="toggle" href="#BlogCategories">
				<?php __('Kategorie') ?>
		</a>
		<h2 class="box-header">
			<?php __('Kategorie') ?>
		</h2>
		
		<div class="box-content" id="BlogCategories">
			<?php echo $this->BlogTree->show($categories, $path) ?>
		</div>
	</section>
<?php endif ?>