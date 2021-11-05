<div class="home-page">
	<div class="row">
	<?php 
		echo $this->element(
			TEMPLATE_NAME.DS.'banners_text',
			array(
					'container_class' => 'about-banners',
					'section'         => 6
			)
		)
	?>
	</div>
	<?php
		$mainpage_tabs = array();
		
		if (module('MAIN_RECOMMENDED') && module('PERSONALIZATION')):
			$mainpage_tabs[] = array(
				'label'    => __('Polecane', true),
				'id'       => 'Polecane',
				'box_name' => 'recommendations',
				'url'      => false,
				'is_first' => $mainpage_tabs ? false : true
			);
		endif;
		
		if (module('MAIN_NEW_PRODUCTS')):
			$mainpage_tabs[] = array(
				'label'    => __('Nowości', true),
				'id'       => 'Nowosci',
				'box_name' => 'new_products',
				'url'      => getNewProductsUrl(),
				'is_first' => $mainpage_tabs ? false : true
			);
		endif;
		
		if (module('MAIN_SPECIALS')):
			$mainpage_tabs[] = array(
				'label'    => __('Promocje', true),
				'id'       => 'Promocje',
				'box_name' => 'specials',
				'url'      => getSpecialProductsUrl(),
				'is_first' => $mainpage_tabs ? false : true
			);
		endif;
		
		if (module('MAIN_BESTSELLERS')):
			$mainpage_tabs[] = array(
				'label'    => __('Bestsellery', true),
				'id'       => 'Bestsellery',
				'box_name' => 'bestsellers',
				'url'      => getBestsellerProductsUrl(),
				'is_first' => $mainpage_tabs ? false : true
			);
		endif;
		
		if (module('MAIN_RECENTLY_VIEWED') && getMainpageRecentlyViewedProductsCount() >= setting('MODULE_MAIN_RECENTLY_VIEWED_MIN_NUMBER')):
			$mainpage_tabs[] = array(
				'label'    => __('Ostatnio oglądane', true),
				'id'       => 'OstatnioOgladane',
				'box_name' => 'recently_viewed',
				'url'      => false,
				'is_first' => $mainpage_tabs ? false : true
			);
		endif;
		
		if (module('MAIN_CURRENTLY_VIEWED')):
			$mainpage_tabs[] = array(
				'label'    => __('Aktualnie oglądane', true),
				'id'       => 'AktualnieOgladane',
				'box_name' => 'currently_viewed',
				'url'      => false,
				'is_first' => $mainpage_tabs ? false : true
			);
		endif;
		
	?>
	
	<?php if ($mainpage_tabs): ?>
		<div class="posistion-relative">
			<div id="MainpageTabs" class="mainpage-tabs">
				<ul class="tabs">
					<?php foreach ($mainpage_tabs as $tab): ?>
						<li class="<?php echo $tab['is_first'] ? 'active' : '' ?>">
							<a href="#<?php echo $tab['id'] ?>">
								<?php echo $tab['label'] ?>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			
			<div class="mainpage-tab-content tab-content">
				<?php foreach ($mainpage_tabs as $tab): ?>
					<div class="tab-pane <?php echo $tab['is_first'] ? 'active' : '' ?>" data-target="<?php echo $this->Html->url(getProductMainpageBoxUrl($tab['box_name'])) ?>" data-loaded="<?php echo $tab['is_first'] ? 'true' : 'false' ?>" id="<?php echo $tab['id'] ?>">
						<?php
							$options = array(
								'is_first' => $tab['is_first'],
								'box_name' => $tab['box_name']
							);
							
							if ($tab['is_first'] && isBot()):
								$options['cache'] = array(
									'time' => Configure::read('Cache.bot_time'),
									'key'  => getStandardCacheKey()
								);
							endif;
							
							echo $this->element(TEMPLATE_NAME.DS.'home'.DS.$tab['box_name'], $options);
						?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>
</div>