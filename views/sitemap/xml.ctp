<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
	<?php foreach ($categories as $category_id):?>
		<url>
			<loc>
				<?php echo $this->Html->url(getCategoryUrl($category_id), true) ?>
			</loc>
			
			<?php if (!empty($categories_logo[$category_id]) && file_exists(IMAGES.configuration('Category.dir').DS.$categories_logo[$category_id])): ?>
				<image:image>
					<image:loc>
						<?php  echo $this->Html->url('/'.IMAGES_URL.configuration('Category.dir').'/'.$categories_logo[$category_id], true) ?>
					</image:loc>
				</image:image>
			<?php endif ?>
		</url>
	<?php endforeach ?>
	
	<?php foreach ($producers as $producer): ?>
		<url>
			<loc>
				<?php echo $this->Html->url(getProducerProductsUrl($producer['Producer']['id']), true) ?>
			</loc>
			<?php if (!empty($producer['Producer']['logo']) && file_exists(IMAGES.configuration('Producer.dir').DS.$producer['Producer']['logo'])): ?>
				<image:image>
					<image:loc>
						<?php echo $this->Html->url('/'.IMAGES_URL.configuration('Producer.dir').'/'.$producer['Producer']['logo'], true)?>
					</image:loc>
				</image:image>
			<?php endif ?>
		</url>
	<?php endforeach ?>
	
	<?php foreach ($static_pages as $page): ?>
		<url>
			<loc>
				<?php echo $this->Html->url(getStaticPageUrl($page['StaticPage']['id']), true) ?>
			</loc>
		</url>
	<?php endforeach ?>
</urlset>