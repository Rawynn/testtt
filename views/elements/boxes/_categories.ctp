<?php if (module('BOX_CATEGORIES')): ?>
	<?php
		if (isProductListIndexView() && isset($category_id) && is_numeric($category_id)):
			$categories    = getCategoryTree($category_id, isProductListIndexView() ? $this->params['url'] : array());
			$category_path = getCategoryPath($category_id);
		elseif (isProductShowView() && !empty($product) && $product['Product']['id']):
			$category_id   = getProductParentCategory($product['Product']['id']);
			$categories    = getCategoryTree($category_id);
			$category_path = getCategoryPath($category_id);
		else:
			$categories    = getCategoryTree(null, isProductListIndexView() ? $this->params['url'] : array());
			$category_path = array();
		endif;
	?>
	
	<?php if ($categories): ?>
		<section class="categories-box aside-box" data-type="categories-box">
			<a class="responsive-toggle" data-type="toggle" href="#BoxCategories">
				<?php __('Kategorie') ?>
			</a>
			
			<div class="box-content" id="BoxCategories">
				<?php
					echo $this->element(
						'_default'.DS.'category_tree',
						array(
							'category'      => isset($category_id) ? $category_id : null,
							'categories'    => $categories,
							'category_path' => $category_path
						)
					)
				?>
				
				<?php if (setting('MODULE_BOX_CATEGORIES_LINK_MAP')): ?>
					<a class="category-map-link" href="<?php echo $this->Html->url(getSitemapUrl()) ?>" title="<?php echo h( __('Mapa kategorii', true)) ?>">
						<?php __('Mapa kategorii') ?>
					</a>
				<?php endif ?>
			</div>
		</section>
		<script type='text/javascript'>
			$(function(){
				if ( $(this).find('a').hasClass('current_page') ){
					var check_undercategory = $(this).find('.current_page').next().length;
					if(check_undercategory){
						var li__ = $('#BoxCategories > ul > li .current_page').parent().clone();
					}else{
						var li__ = $('#BoxCategories > ul > li .current_page').parent().parent().parent().clone();
					}
					$('#BoxCategories > ul li, #BoxCategories > ul ul').remove();
					li__.appendTo('#BoxCategories > ul').show();
					return;
				};
			});
		</script>
	<?php endif ?>
<?php endif ?>