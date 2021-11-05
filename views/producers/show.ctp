<div class="producer-page text-page page">
	<div class="page-header">
		<h1>
			<?php echo $producer['Producer']['name'] ?>
		</h1>
	</div>
	
	<div class="page-content cms-content">
		<?php if ($producer['Producer']['logo']): ?>
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
								'alt' => $producer['Producer']['name']
							),
							'tag'   => array(
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
		<?php endif ?>
		
		<?php echo $producer['Producer']['description'] ?>
	</div>
	
	<?php if ($producer['Producer']['url']): ?>
		<div class="producer-www">
			<?php __('Adres WWW') ?>:
			
			<strong>
				<a href="<?php echo $producer['Producer']['url'] ?>" title="<?php echo h($producer['Producer']['name']) ?>" target="_blank">
					<?php echo $producer['Producer']['url'] ?>
				</a>
			</strong>
		</div>
	<?php endif ?>
</div>