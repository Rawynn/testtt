<div class="static-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $page['StaticPage']['title'] ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-false cms-content">
			<?php if ($gallery): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'static_page'.DS.'gallery', array(
							'gallery_name'   => $gallery['Gallery']['name'],
							'gallery_images' => $gallery['GalleryImage']
						)
					)
				?>
			<?php endif ?>
			
			<?php echo $page['StaticPage']['content'] ?>
		</div>
	</div>
</div>