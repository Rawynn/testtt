<div class="order-list-page order-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Koszyk') ?> "<?php echo $name ?>"
		</h1>
	</div>

	<div class="page-content">
		<?php if ($products): ?>
			<div class="product-section order-section">
				<table class="table product-table">
					<colgroup>
						<col width="14%">
						<col width="50%">
						<col width="11%">
						<col width="14%">
						<col width="11%">
					</colgroup>
					
					<thead>
						<tr class="product-header">
							<th class="product-data-header" colspan="2">
								<?php __('Produkt') ?>
							</th>
							<th class="product-price-header">
								<?php __('Cena') ?>
							</th>
							<th class="product-quantity-header">
								<?php __('Ilość') ?>
							</th>
							<th class="product-summary-header">
								<?php __('Wartość') ?>
							</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach ($products as $product): ?>
							<?php
								$product_url      = getProductUrl($product['product_id']);
								$product_name     = getProductName($product['product_id']);
								$combination_name = is_numeric($product['combination_id']) && $product['combination_id'] > 0 ? getCombinationName($product['combination_id']) : '';
							?>
							
							<tr class="product-row">
								<td class="product-image">
									<span class="preload-image" data-loaded="false">
										<?php
											echo $this->element(
												'_default'.DS.'miniature',
												array(
													'file'  => array(
														'type'     => configuration('ProductMedium.dir'),
														'filename' => ($filename = getCombinationField($product['combination_id'], 'filename')) ? $filename : getProductMainPhotoId($product['product_id'], 'filename'),
														'dir'      => ($dir = getCombinationField($product['combination_id'], 'dir')) ? $dir : getProductMainPhotoId($product['product_id'], 'dir')
													),
													'image' => array(
														'resize'     => 'resize',
														'width'      => 400,
														'height'     => 400,
														'no_photo'   => true,
														'watermark'  => $product['product_id'],
														'blazy'      => true,
														'background' => array(
															'R' => 255,
															'G' => 255,
															'B' => 255
														)
													),
													'html'  => array(
														'image' => array(
															'alt' => h($product_name)
														)
													)
												)
											)
										?>
									</span>
								</td>
								<td class="product-data">
									<div class="name">
										<?php if (checkProductIsVisible($product['product_id'])): ?>
											<a href="<?php echo $this->Html->url($product_url) ?>" title="<?php echo h($product_name) ?>">
												<?php echo $product_name ?>
											</a>
										<?php else: ?>
											<span>
												<?php echo $product_name ?>
											</span>
										<?php endif ?>
										
										<?php if (!empty($combination_name)): ?>
											<br>
											
											<span class="combination-name">
												<?php echo $combination_name ?>
											</span>
										<?php endif ?>
									</div>
								</td>
								<td class="product-price">
									<span class="table-responsive-label">
										<?php __('Cena') ?>:
									</span>
									
									<span>
										<?php echo showPrice($product['single_price']) ?>
									</span>
								</td>
								<td class="product-price product-quantity">
									<span class="table-responsive-label">
										<?php __('Ilość') ?>:
									</span>
									
									<?php echo showQuantityValue($product['quantity'], $product['product_id']) ?>
								</td>
								<td class="product-price product-summary">
									<div class="table-responsive-label">
										<?php __('Wartość') ?>:
									</div>
									
									<span>
										<?php echo showPrice($product['price']) ?>
									</span>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			
			<div class="order-actions form-actions">
				<a class="btn-back btn btn-lg" href="javascript: history.back()" title="<?php echo h(__('Powrót', true)) ?>">
					<?php __('Powrót') ?>
				</a>
				
				<?php if ($cart['UserCart']['can_activate']): ?>
					<a class="btn btn-primary btn-lg btn-next" data-toggle="modal" href="#ActivateCart<?php echo $cart['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Aktywuj koszyk', true)) ?>">
						<?php __('Aktywuj koszyk') ?>
					</a>
				<?php endif ?>
			</div>
			
			<?php
				/* Dialogi do aktywacji koszyka */
				echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'my_carts'.DS.'activate_box')
			?>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Nie znaleziono żadnych produktów w wybranym koszyku.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>