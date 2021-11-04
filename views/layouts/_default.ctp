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
					/* Główny baner */
					echo $this->element(
						TEMPLATE_NAME.DS.'banners',
						array(
							'container_class' => 'mainpage-banners',
							'carousel_id'     => 'MainpageBanners',
							'section'         => 1
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
								$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ą,ż,ź,ć,ń,ł,ś,ę");
								$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,z,z,c,n,l,s,e");
								$urlTitle = str_replace($search, $replace, $__page_header);
								if(strpos($urlTitle, '>')!== false):
									list ($a, $b) = explode(' > ', $urlTitle);
									echo $a;
								else:
									echo $urlTitle;
								endif;
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
				/* darmowa dostawa */
				echo $this->element(
					TEMPLATE_NAME.DS.'banners',
					array(
						'container_class' => 'dostawa-banners',
						'carousel_id'     => 'DostawaBanners',
						'section'         => 5
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