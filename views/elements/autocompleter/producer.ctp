<div class="product-box small">
	<?php
		$logo          = getProducerField($producer_id, 'logo');
		$producer_logo = '';
		
		if (!empty($logo) && file_exists(IMAGES.Configure::read('Producer.dir').DS.$logo)):
			$producer_logo = $this->element(
				'_default'.DS.'miniature',
				array(
					'file'  => array(
						'type'     => configuration('Producer.dir'),
						'filename' => $logo,
						'dir'      => ''
					),
					'image' => array(
						'resize'     => 'resize',
						'width'      => 70,
						'height'     => 70,
						'no_photo'   => true,
						'watermark'  => 0,
						'blazy'      => true,
						'background' => array(
							'R' => 255,
							'G' => 255,
							'B' => 255
						)
					),
					'html'  => array(
						'image' => array(
							'alt' => h($producer_name)
						)
					)
				)
			);
		endif;
	?>
	
	<span class="product-image preload-image <?php echo !$producer_logo ? 'no-image' : '' ?>" data-loaded="<?php echo $producer_logo ? 'false' : 'true' ?>">
		<?php echo $producer_logo ?>
	</span>
	
	<span class="category-box">
		<span class="phrase-label">
			<?php __('produkty producenta') ?>:
		</span>
		
		<span class="parent-name">
			<?php
				if (preg_match_all('/'.get('term').'/i', $producer_name, $matches)):
					foreach ($matches[0] as $match):
						$producer_name = str_replace($match, '<span class="highlight">'.$match.'</span>', $producer_name);
					endforeach;
				endif;
				
				echo $producer_name;
			?>
			<i class="fa fa-caret-right" aria-hidden="true"></i>
		</span>
	</span>
</div>