<div class="sitemap-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Mapa strony') ?>
		</h1>
	</div>
	
	<div class="page-content categories-box">
		<div class="box-content sitemap-links">
			<?php foreach ($all_categories as $categories): ?>
				<?php echo $this->Tree->show($categories, array(), false, false) ?>
			<?php endforeach ?>
			
			<hr/>
			
			<ul>
				<?php foreach ($landing_pages as $landing_page): ?>
					<li>
						<?php echo $this->Html->link($landing_page['LandingPage']['name'], getLandingPageUrl($landing_page['LandingPage']['id'])) ?>
					</li>
				<?php endforeach ?>
				
				<?php foreach ($product_filters as $product_filter): ?>
					<li>
						<?php echo $this->Html->link($product_filter['ProductFilter']['name'], getProductFilterUrl($product_filter['ProductFilter']['id'])) ?>
					</li>
				<?php endforeach ?>
				
				<?php foreach ($static_pages as $static_page): ?>
					<li>
						<?php echo $this->Html->link($static_page['StaticPage']['title'], getStaticPageUrl($static_page['StaticPage']['id'])) ?>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>