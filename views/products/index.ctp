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
		
		<div class="clearfix"></div>
		
		<div class="page-content">
			<?php
				/* Opis i baner kategorii */
				/*echo $this->element(
					TEMPLATE_NAME.DS.'product_list'.DS.'category_description',
					array(
						'category' => $category
					)
				)*/
			?>
			
			<?php
				if (isset($producer)):
					/* Opis i baner producenta */
					echo $this->element(
						TEMPLATE_NAME.DS.'product_list'.DS.'producer_description',
						array(
							'producer' => $producer
						)
					);
				endif;
				
				if (isset($product_filter)):
					/* Opis dynamicznej listy */
					echo $this->element(
						TEMPLATE_NAME.DS.'product_list'.DS.'product_filter_description',
						array(
							'product_filter' => $product_filter
						)
					);
				endif
			?>
			
			
			<?php if (isBot() || isAjax()): ?>
				<?php echo $this->element(TEMPLATE_NAME.DS.'product_list'.DS.'filters') ?>
			<?php else: ?>
				<?php
					$url = getCurrentUrl();
					$url['?']['only_filters'] = 1;
					
					unset($url['?']['type']);
				?>
				
				<div class="product-additional-box preload-box" data-type="ajax-load" data-load-url="<?php echo $this->Html->url($url) ?>" data-load-type="onload" data-load-offset="50" data-loaded="false">
					<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
				</div>
			<?php endif ?>
			
			<?php
				if (setting('OPTIMALIZATION_PAGINATION_VIA_AJAX') && MODULE('FILTER') && isAjax() && checkIsSidebarBoxActive('filters')):
					echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.'filters');
				endif;
			?>
			
			<?php
				/* Wybrane filtry */
				echo $this->element(TEMPLATE_NAME.DS.'product_list'.DS.'filters_selected')
			?>
			
			<?php if ($products): ?>
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
					<ul class="product-list <?php echo $view_type ?> col-4" data-loaded="true" data-from="listing" data-campaign-id="<?php echo get('campaign-id') ?>" data-q="<?php echo urlencode(get('q')) ?>">
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
					
					<div class="options-container form form-inline">
						<?php
							/* Limit wyświetlania */
							echo $this->element(TEMPLATE_NAME.DS.'product_list'.DS.'change_limit');
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