<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="<?php echo $langauge = getCurrentLanguageField('language') ?>" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="<?php echo $langauge ?>" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="<?php echo $langauge ?>" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="<?php echo $langauge ?>" class="no-js"> <!--<![endif]-->
	<head>
		<?php
			/* Meta tagi */
			echo $this->element(TEMPLATE_NAME.DS.'head')
		?>
	</head>
	<body class="<?php echo userIsSalesrep() && isCartView() ? 'edit-offer' : '' ?>">
		<div class="wrap-header">
			<?php
				/* Nagłówek strony */
				echo $this->element(TEMPLATE_NAME.DS.'header')
			?>
		</div>
		
		<?php if (!(userIsSalesrep() && isCartView()) ): ?>
			<div class="wrap-navbar">
				<div class="container">
					<?php
						/* Nawigacja - kategorie */
						echo $this->element(
							TEMPLATE_NAME.DS.'main_nav',
							array(
								'cache' => array(
									'time' => Configure::read('Cache.short_time'),
									'key'  => getStandardCacheKey()
								)
							)
						)
					?>
				</div>
			</div>
		<?php endif ?>
		
		<div class="wrap-content">
			<?php if (isHomePageView()): ?>
				<div class="container-message container">
					<?php
						/* Komunikaty systemowe */
						echo $this->element(TEMPLATE_NAME.DS.'message')
					?>
				</div>
				
				<?php
				$current_url = getCurrentUrl();
				switch ($current_url['language']) {
					case "pol":
						$i = 1;
						break;
					case "cze":
						$i = 7;
						break;
					case "slo":
						$i = 8;
						break;
					case "deu":
						$i = 9;
						break;
					case "hun":
						$i = 10;
						break;
				}
					/* Główny baner */
					echo $this->element(
						TEMPLATE_NAME.DS.'banners',
						array(
							'container_class' => 'mainpage-banners',
							'carousel_id'     => 'MainpageBanners',
							'section'         => $i
						)
					)
				?>
			<?php endif ?>
			
			<div class="main-container container">
				<?php
					/* Ścieżka okruchów */
					echo $this->element(TEMPLATE_NAME.DS.'breadcrumbs')
				?>
				<?php if(isProductListIndexView()):?>
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
				<div class="options category-option">
					<div class="pagination-container" data-type="product-list-paginator-top" data-possible-filters="<?php echo implode(',', $possibleProductIndexParams) ?>">
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
					<?php
						/* Sortowanie */
						echo $this->element(TEMPLATE_NAME.DS.'product_list'.DS.'change_sort')
					?>
				</div>
				<div class="clearfix"></div>
				<?php endif;?>
				<div class="row">
					<?php
						$left_boxes = getSidebarContent('left_column');
						$blog_page = getCurrentController() == 'blog';
					?>
					
					<?php if ($left_boxes || $blog_page): ?>
						<aside class="sidebar sidebar-left">
							<?php
								/* Wyświetlenie lewego sidebar'a */
								echo $this->element(
									TEMPLATE_NAME.DS.'sidebar',
									array(
										'boxes'     => isset($left_boxes) ? $left_boxes : '',
										'blog_page' => $blog_page
									)
								)
							?>
						</aside>
					<?php endif ?>
					
					<section class="main-content <?php echo $left_boxes || $blog_page ? 'sidebar-left-true' : 'sidebar-left-false' ?>">
						<?php
							if (!isHomePageView()):
								/* Komunikaty systemowe */
								echo $this->element(TEMPLATE_NAME.DS.'message'); // Na głównej umieszczone nad banerem
							endif;
						?>
						
						<?php
							/* Treść strony */
							echo $content_for_layout
						?>
						
						<?php
							/* Skrypty które mają być na dole stron */
							echo $this->element('_default'.DS.'bottom_page_scripts')
						?>
					</section>
				</div>
			</div>
		</div>
		<?php if (!isLandingPageShowView() && !isProductListIndexView() && !isProductShowView()): ?>
			<?php
				switch ($current_url['language']) {
					case "pol":
						$a = 5;
						break;
					case "cze":
						$a = 15;
						break;
					case "slo":
						$a = 16;
						break;
					case "deu":
						$a = 17;
						break;
					case "hun":
						$a = 18;
						break;
				}
				/* darmowa dostawa */
				echo $this->element(
					TEMPLATE_NAME.DS.'banners',
					array(
						'container_class' => 'dostawa-banners',
						'carousel_id'     => 'DostawaBanners',
						'section'         => $a
					)
				)
			?>
		<?php endif;?>
		
		<div class="wrap-footer">
			<?php
				/* Stopka */
				echo $this->element(TEMPLATE_NAME.DS.'footer')
			?>
		</div>
		
		<span class="go-to-top btn btn-primary"></span>
		
		<?php
			/* Informacja o ciasteczkach */
			echo $this->element(TEMPLATE_NAME.DS.'cookies')
		?>
		
		<?php
			/* JavaScript i Szablony */
			echo $this->element(TEMPLATE_NAME.DS.'scripts')
		?>
	</body>
</html>