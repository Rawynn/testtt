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
		
		<?php if (!(userIsSalesrep() && isCartView())): ?>
			<div class="wrap-navbar">
				<div class="container">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'main_nav_top',
							array(
								'cache' => array(
									'time' => Configure::read('Cache.short_time'),
									'key'  => getStandardCacheKey()
								)
							)
						);
					?>
					<?php if(isMobile()):?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'main_nav_mobile',
								array(
									'cache' => array(
										'time' => Configure::read('Cache.short_time'),
										'key'  => getStandardCacheKey()
									)
								)
							);
						?>
					<?php endif;?>
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
				
				<div class="row">
					<?php
						$left_boxes = getSidebarContent('left_column');
						$blog_page  = getCurrentController() == 'blog';
					?>
					
					<?php if ($blog_page): ?>
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
					
					<section class="main-content <?php echo $blog_page ? 'sidebar-left-true' : 'sidebar-left-false' ?>">
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
		<?php if (isHomePageView()): ?>
			<?php if($blog = getLastBlogArticles(4)):?>
				<hr>
				<div class="container">
					<ul class="blog-list-holder">
						<li class="blog-img">
							<a href="blog" title="<?php __('Zobacz wszystkie wpisy na blogu')?>">
							<?php 
								echo $this->Html->image(
									'layout/'.TEMPLATE_NAME.'/nablogu.jpg',
									array(
											'alt'   => __('Najnowsze wpisy na blogu', true),
									)
								);
							?>
							<span><?php __('Najnowsze wpisy na blogu')?></span>
							</a>
						</li>
						
						<?php foreach ($blog as $blog_item): ?>
							<?php
								echo $this->element(
									TEMPLATE_NAME.DS.'item_blog',
									array(
										'blog'       => $blog_item,
										'show_intro' => true
									)
								)
							?>
						<?php endforeach ?>
					</ul>
					<?php
						/* Główny baner */
						echo $this->element(
							TEMPLATE_NAME.DS.'banners_homepage',
							array(
								'container_class' => 'homepage-banners',
								'section'         => 7
							)
						)
					?>
				</div>
			<?php endif;?>
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