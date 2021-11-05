<?php if ($product_type == 0 && $discounts): ?>
	<br>
	
	<?php
		if (is_array($combination_id)):
			$combination_id = sha1(serialize($combination_id));
		endif;
	?>
	
	<a data-toggle="modal" href="#QuantityDiscountDialog<?php echo $product_id ?>_<?php echo $combination_id ?>" role="button" title="<?php echo h(__('Zobacz zniżki', true)) ?>">
		<?php __('zobacz zniżki') ?> <i class="fa fa-angle-right"></i>
	</a>
	
	<div class="quantity-discount-modal modal fade" id="QuantityDiscountDialog<?php echo $product_id ?>_<?php echo $combination_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Zniżki ilościowe') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<ul>
						<?php foreach ($discounts as $discount_from => $discount_percentage): ?>
							<li>
								<?php echo sprintf(__('Zamów min. %s a otrzymasz rabat %s%%', true), showQuantityValue($discount_from, $product_id), round($discount_percentage, 4)) ?>
							</li>
						<?php endforeach ?>
					</ul>
				</div>
				
				<div class="modal-footer">
					<a class="btn btn-primary btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
						<?php __('OK') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>