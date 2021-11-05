<?php if (get('only_filters')): ?>
	<?php
		if (get('type') == 'boxes'):
			echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.'filters');
		else:
			echo $this->element(TEMPLATE_NAME.DS.'product_list'.DS.'filters');
		endif;
	?>
<?php else: ?>
	<?php
		if (isMobile() && setting('MODULE_LIST_GALLERY') && empty($_COOKIE['AtomStore']['products_list_view'])):
			$view_type = 'gallery';
		else:
			$view_type = str_replace('products_list_item_', '', $products_list_view);
		endif;
	?>
	
	<div class="product-list-page page">
		<div class="category-header page-header">
			<h1 class="title">
				<?php
					if (!empty($__page_header)):
						echo $__page_header;
					else:
						echo __('Produkty', true);
					endif;
				?>
			</h1>
		</div>
		
		<div class="clearfix"></div>
		<?php if (module('BOX_CATEGORIES')): ?>
			<div class="menu-cat aside-box">
				<a class="responsive-toggle" data-type="toggle" href="#BoxCategories">
					<?php __('Kategorie') ?>
				</a>
				<div class="hheader"><?php __('Wszystkie kategorie:')?></div>
				<?php $categories    = getCategoryTree($category_id, isProductListIndexView() ? $this->params['url'] : array());?>
				<?php $parent_id = getCategoryParentId($category_id)?>
				<div class="box-content row" id="BoxCategories">
					<?php foreach($categories as $cat):?>
						<?php if(!$parent_id):?>
							<div class="col-md-3 col-sm-4">
								<a href="<?php echo $this->Html->url(getCategoryUrl($cat['Category']['id']))?>"><?php echo $cat['Category']['seo_name'].' ('.$cat['Category']['products_count'].')' ?></a>
							</div>
						<?php elseif( $parent_id == '1'): ?>
							<?php if(!empty($child = $cat['children'])):?>
								<?php foreach($child as $child_cat):?>
									<div class="col-md-3 col-sm-4">
										<a href="<?php echo $this->Html->url(getCategoryUrl($child_cat['Category']['id']))?>"><?php echo $child_cat['Category']['seo_name'].' ('.$child_cat['Category']['products_count'].')' ?></a>
									</div>
								<?php endforeach;?>
							<?php endif;?>
						<?php else: ?>
							<?php if($cat['Category']['id'] == $parent_id):?>
								<?php foreach($cat['children'] as $child_cat):?>
									<?php if($child_cat['Category']['id'] == $category_id):?>
										<?php foreach($child_cat['children'] as $sec_child_cat):?>
											<div class="col-md-3 col-sm-4">
												<a href="<?php echo $this->Html->url(getCategoryUrl($sec_child_cat['Category']['id']))?>"><?php echo $sec_child_cat['Category']['seo_name'].' ('.$sec_child_cat['Category']['products_count'].')' ?></a>
											</div>
										<?php endforeach;?>
									<?php else:?>
										<?php continue;?>
									<?php endif;?>
								<?php endforeach;?>
							<?php else:?>
								<?php continue;?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				</div>
			</div>
		<?php endif ?>
		<div class="page-content">
			
			<?php if ($products): ?>
				<div class="hheader"><?php __('Produkty z kategorii ')?><?php echo $__page_header;?></div>
				<?php if (module('B2B') && $products): ?>
					<?php $cart_add_groups = true ?>
					
					<div class="add-group-label">
						<?php echo __('Zaznaczono - <span data-type="add-group-counter">0</span> pozycje:', true) ?>
						
						<input type="button" data-type="cart-group-submit" value="<?php echo h(getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true)) ?>" disabled="disabled" class="btn btn-primary" />
						
						<?php if (module('WISHLIST')): ?>
							<input type="button" data-type="wishlist-group-submit" value="<?php echo h(__('Do schowka', true)) ?>" disabled="disabled" class="btn btn-primary" />
						<?php endif ?>
					</div>
				<?php endif ?>
				
				<div data-type="product-list">
					<ul class="product-list <?php echo $view_type ?> col-5" data-loaded="true" data-from="listing" data-campaign-id="<?php echo get('campaign-id') ?>" data-q="<?php echo urlencode(get('q')) ?>">
						<?php
							foreach ($products as $product):
								echo $this->element(
									'_default'.DS.'product_item',
									array(
										'type'    => $view_type,
										'path'    => TEMPLATE_NAME.DS.'product_list'.DS.'item_'.$view_type,
										'product' => $product
									)
								);
							endforeach;
						?>
					</ul>
				</div>
				
				<?php if (isset($cart_add_groups)): ?>
					<div class="add-group-label add-group-label-bottom">
						<?php echo __('Zaznaczono - <span data-type="add-group-counter">0</span> pozycje:', true) ?>
						
						<input type="button" data-type="cart-group-submit" value="<?php echo h(getCartIsOffer() ? __('Do oferty', true) : __('Do koszyka', true)) ?>" disabled="disabled" class="btn btn-primary" />
						
						<?php if (module('WISHLIST')): ?>
							<input type="button" data-type="wishlist-group-submit" value="<?php echo h(__('Do schowka', true)) ?>" disabled="disabled" class="btn btn-primary" />
						<?php endif ?>
					</div>
				<?php endif ?>
				
				<div class="product-list-view-options">
					<div class="pagination-container" data-type="product-list-paginator" data-possible-filters="<?php echo implode(',', $possibleProductIndexParams) ?>">
						<?php
							/* Stronicowanie */
							echo $this->element(
								TEMPLATE_NAME.DS.'paginator',
								array(
									'append' => setting('OPTIMALIZATION_PAGINATION_PRELOADING'),
									'class'  => setting('OPTIMALIZATION_PAGINATION_PRELOADING') ? 'append' : ''
								)
							)
						?>
					</div>
				</div>
			<?php else: ?>
				<div data-type="product-list" data-possible-filters="<?php echo implode(',', $possibleProductIndexParams) ?>">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'   => 'flat no-items',
								'message' => __('Brak produktów do wyświetlenia.', true)
							)
						)
					?>
				</div>
			<?php endif ?>
			
			<?php
				/* Frazy podobne */
				echo $this->element(
					TEMPLATE_NAME.DS.'product_list'.DS.'similar_phrases',
					array(
						'phrase' => getCurrentSearchPhrase()
					)
				)
			?>
			<div class="clearfix"></div>
		</div>
	</div>
		
		<?php if (isAjax()): ?>
			<?php
				$current_url = getCurrentUrl();
				
				unset($current_url['?']['_']);
				unset($current_url['?']['campaign-id']);
			?>
			
			<div data-type="current-ajax-url" data-current-url="<?php echo Router::url(isset($friendly_url) ? $friendly_url : $current_url, false) ?>" title="<?php echo h($title_for_layout) ?>"></div>
		<?php endif ?>
	</div>
	
	<?php
		/* Ping dla kategorii */
		echo $this->element('_default'.DS.'category_ping')
	?>
<?php endif ?>