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
				<?php foreach ($static_pages as $static_page): ?>
					<li>
						<?php echo $this->Html->link($static_page['StaticPage']['title'], getStaticPageUrl($static_page['StaticPage']['id'])) ?>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>