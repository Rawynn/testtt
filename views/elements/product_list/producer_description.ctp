<?php if (getCurrentPaginatePage() == 1): ?>
	<?php if ($producer['Producer']['id']): ?>
		<?php
			/* Banery kategorii */
			echo $this->element(
				TEMPLATE_NAME.DS.'banners',
				array(
					'container_class'    => 'category-banners',
					'carousel_id'        => 'ProducerBanners',
					'section'            => 3,
					'banner_producer_id' => $producer['Producer']['id']
				)
			)
		?>
	<?php endif ?>
	
	<?php if ($producer['Producer']['description']): ?>
		<div class="producer-description">
			<?php
				echo $this->element(
					'_default'.DS.'miniature',
					array(
						'file'  => array(
							'type'     => configuration('Producer.dir'),
							'filename' => $producer['Producer']['logo'],
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
								'alt' => isset($producer['Producer']['name']) ? h($producer['Producer']['name']) : ''
							),
							'tag' => array(
								'name'       => 'div',
								'properties' => array(
									'class'       => 'producer-thumbnail img-thumbnail preload-image',
									'data-loaded' => 'false'
								)
							)
						)
					)
				)
			?>
			
			<div class="cms-content">
				<?php echo $producer['Producer']['description'] ?>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>