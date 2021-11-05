<li data-type="opinion-container" data-product-opinion-id="<?php echo $opinion['ProductOpinion']['id'] ?>">
	<?php if (isset($show_image) && $show_image): ?>
		<a class="opinion-product-image-container preload-image" href="<?php echo $this->Html->url(getProductUrl($opinion['ProductOpinion']['product_id'])) ?>" title="<?php echo h(getProductName($opinion['ProductOpinion']['product_id'])) ?>" data-loaded="false">
			<?php
				echo $this->element(
					'_default'.DS.'miniature',
					array(
						'file'  => array(
							'type'     => configuration('ProductMedium.dir'),
							'filename' => isset($opinion['ProductMedium']['filename']) ? $opinion['ProductMedium']['filename'] : getProductMainPhotoId($opinion['ProductOpinion']['product_id'], 'filename'),
							'dir'      => isset($opinion['ProductMedium']['dir']) ? $opinion['ProductMedium']['dir'] : getProductMainPhotoId($opinion['ProductOpinion']['product_id'], 'dir'),
						),
						'image' => array(
							'resize'     => 'resize',
							'width'      => 150,
							'height'     => 150,
							'no_photo'   => false,
							'watermark'  => $opinion['ProductOpinion']['product_id'],
							'blazy'      => true,
							'background' => array(
								'R' => 255,
								'G' => 255,
								'B' => 255
							)
						),
						'html'  => array(
							'image' => array(
								'alt' => isset($opinion['ProductMedium']['title']) ? h($opinion['ProductMedium']['title']) : h(getProductName($opinion['ProductOpinion']['product_id'])),
								'class' => 'opinion-product-image'
							)
						)
					)
				)
			?>
		</a>
	<?php endif ?>
	
	<span class="opinion-option opinion-note">
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'opinion_rating',
				array(
					'input' => false,
					'note'  => $opinion['ProductOpinion']['note'],
				)
			)
		?>
	</span>
	<span class="divider pull-left">-</span>
	
	<?php if ($product_list): ?>
		<div class="opinion-author">
			<strong><?php echo $opinion['ProductOpinion']['username'] ?></strong>,
		</div>
	<?php else: ?>
		<div class="opinion-product">
			<strong>
				<?php if (checkProductIsVisible($opinion['ProductOpinion']['product_id'])): ?>
					<a href="<?php echo $this->Html->url(getProductUrl($opinion['ProductOpinion']['product_id'])) ?>" title="<?php echo h(getProductName($opinion['ProductOpinion']['product_id'])) ?>">
						<?php echo getProductName($opinion['ProductOpinion']['product_id']) ?>,
					</a>
				<?php else: ?>
					<?php echo getProductName($opinion['ProductOpinion']['product_id']) ?>,
				<?php endif ?>
			</strong>
		</div>
	<?php endif ?>
	
	<span class="opinion-option opinion-publish-date">
		<?php echo showDate($opinion['ProductOpinion']['created']) ?>
	</span>
	
	<?php if ($product_list): ?>
		<span class="text-muted"><?php __('napisał') ?>:</span>
	<?php endif ?>
	
	<div class="opinion-content">
		<?php echo nl2br($opinion['ProductOpinion']['content']) ?>
	</div>
	
	<?php if ($opinion['ProductOpinion']['benefits']): ?>
		<strong class="opinion-label">
			<?php __('Zalety') ?>:
		</strong>
		
		<div class="opinion-content">
			<?php echo nl2br($opinion['ProductOpinion']['benefits']) ?>
		</div>
	<?php endif ?>
	
	<?php if ($opinion['ProductOpinion']['defects']): ?>
		<strong class="opinion-label">
			<?php __('Wady') ?>:
		</strong>
		
		<div class="opinion-content">
			<?php echo nl2br($opinion['ProductOpinion']['defects']) ?>
		</div>
	<?php endif ?>
	
	<div class="opinion-options">
		<?php if ($product_list): ?>
			<?php if (setting('MODULE_OPINIONS_RATINGS') && setting('MODULE_OPINIONS_RATINGS') != 'never'): ?>
				<span class="opinion-option opinion-rating">
					<span class="text-muted">
						<?php __('Ocena opinii') ?>:
					</span>
					
					<strong>
						<?php echo isset($opinion['ProductOpinion']['rating_plus']) ? $opinion['ProductOpinion']['rating_plus'] : 0 ?>
					</strong>
					
					<?php if (checkCanRatingOpinion($opinion['ProductOpinion']['id'])): ?>
						<a data-type="opinion-rate" data-product-opinion-id="<?php echo $opinion['ProductOpinion']['id'] ?>" data-rate="1" href="#" title="<?php echo h(__('Oceń jako pomocną', true)) ?>">
							<i class="fa fa-thumbs-up"></i>
						</a>
						
						<a data-type="opinion-rate" data-product-opinion-id="<?php echo $opinion['ProductOpinion']['id'] ?>" data-rate="0" href="#" title="<?php echo h(__('Oceń jako niepomocną', true)) ?>">
							<i class="fa fa-thumbs-down"></i>
						</a>
					<?php endif ?>
				</span>
			<?php endif ?>
		<?php else: ?>
			<span class="opinion-option opinion-status">
				<?php if ($opinion['ProductOpinion']['status'] == 0): ?>
					(<?php __('oczekuje na akceptację administratora') ?>)
				<?php else: ?>
					(<?php __('zaakceptowana') ?>)
				<?php endif ?>
			</span>
		<?php endif ?>
	</div>
</li>