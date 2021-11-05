<div class="blog-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $item['Blog']['title'] ?>
			
			<time class="blog-date" datetime="<?php echo date(DATE_W3C, strtotime($item['Blog']['created'])) ?>">
				<?php echo showDate($item['Blog']['created']) ?>
			</time>
		</h1>
	</div>
	
	<div class="page-content cms-content">
		<?php /*if ($item['Blog']['logo']): ?>
			<?php
				echo $this->element(
					'_default'.DS.'miniature',
					array(
						'file'  => array(
							'type'     => configuration('Blog.dir'),
							'filename' => $item['Blog']['logo'],
							'dir'      => ''
						),
						'image' => array(
							'resize'     => 'resize',
							'width'      => 150,
							'height'     => 150,
							'blazy'      => true,
							'background' => array(
								'R' => 255,
								'G' => 255,
								'B' => 255
							)
						),
						'html'  => array(
							'image' => array(
								'alt' => $item['Blog']['title']
							),
							'tag' => array(
								'name'       => 'div',
								'properties' => array(
									'class'       => 'blog-thumbnail img-thumbnail preload-image',
									'data-loaded' => 'false'
								)
							)
						)
					)
				)
			?>
		<?php endif */?>
		
		<?php if ($item['Blog']['intro']): ?>
			<div class="blog-intro">
				<?php echo $item['Blog']['intro'] ?>
			</div>
		<?php endif ?>
		
		<?php if ($item['Blog']['content']): ?>
			<div class="blog-content">
				<?php echo $item['Blog']['content'] ?>
			</div>
		<?php endif ?>
		
		<?php if ($item['Tag']): ?>
			<div class="blog-tags">
				<span class="tag-title">
					<?php __('Tagi') ?>:
				</span>
				
				<?php foreach ($item['Tag'] as $key => $tag): ?>
					<?php
						echo $this->Html->link(
							$tag['name'],
							getTagBlogEntriesUrl($tag['id']),
							array(
								'class' => 'tag-item'
							)
						)
					?>
				<?php endforeach ?>
			</div>
		<?php endif ?>
	</div>
	
	<?php if ($products): ?>
		<ul class="product-list gallery col-4 blog-product-list" data-loaded="true" data-from="blog" data-campaign-id="<?php echo getPageParamValue("campaign-id") ?>">
			<?php
				foreach ($products as $product):
					echo $this->element(
						'_default'.DS.'product_item',
						array(
							'type'    => 'gallery',
							'path'    => TEMPLATE_NAME.DS.'product_list'.DS.'item_gallery',
							'product' => $product
						)
					);
				endforeach;
			?>
		</ul>
	<?php endif ?>
</div>

<?php
	/* Opinie */
	echo $this->element(
		TEMPLATE_NAME.DS.'blog'.DS.'opinions',
		array(
			'item' => $item
		)
	)
?>