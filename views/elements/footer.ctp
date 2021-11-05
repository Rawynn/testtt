<footer>
	<?php if(!isCartView()):?>
	<div class="footer-newsletter-box">
		<?php 
			echo $this->Html->image(
				'layout/'.TEMPLATE_NAME.'/newsletter.png',
					array(
						'alt'   => __('Newsletter', true),
						'class'=> 'newsleter-img'
					)
				);
			?>
		<div class="container">
			<div class="row">
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'boxes'.DS.'newsletter',
						array(
							'id'          => 'Newsletter',
							'show_groups' => false
						)
					)
				?>
			</div>
		</div>
	</div>
	
	<div class="page-desc">
		<?php if(isHomePageView()):?>
			<div class="container">
				<?php echo getStaticPageContent(28);?>
			</div>
		<?php endif;?>
		<?php if(isProductListIndexView()):?>
			<div class="container">
				<div class="product-list-page page">
					<div class="page-content">
						<?php
							/* Opis i baner kategorii */
							echo $this->element(
								TEMPLATE_NAME.DS.'product_list'.DS.'category_description',
								array(
									'category' => $category
								)
							)
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
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>
	<?php endif;?>
	<div class="container">
		<div class="row">
			<div class="footer-nav">
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'footer_nav',
						array(
							'cache' => array(
								'time' => configuration('Cache.short_time'),
								'key'  => getStandardCacheKey().'_'.((int) ((bool) getLoggedUserId())).'_'.((int) userIsSalesrep())
							)
						)
					)
				?>
			</div>
		</div>
	</div>
	
	
	
	<script>

			$(document).ready(function() {


				$(".page-desc").prependTo(".product-list-page .sidebar-left-false");
  

			});
	</script>
	
	<div class="subfooter">
		<div class="container">
			<p class="copy">
				<span><?php __('Wszelkie prawa zastrzeżone przez Polmarkus  &copy; 2018') ?></span>
			</p>
			
			<p class="realization">
				<span><?php __('realizacja') ?>:</span> <a rel="nofollow" href="http://www.netarch.com.pl/" title="NetArch - sklepy dedykowane, systemy B2B" target="_blank">NetArch</a> <span>|</span> <a rel="nofollow" href="http://www.atomstore.pl/" title="AtomStore - platforma e-commerce klasy premium" target="_blank">AtomStore</a>
			</p>
		</div>
	</div>
</footer>