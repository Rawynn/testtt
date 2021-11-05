<?php if ($products): ?>
	<?php
		$count = count($products);
		$i     = 0;
	?>
	
	<table class="product">
		<?php foreach ($products as $key => $product): ?>
			<?php $combinations = getProductCombinations($product['product_id'], false, true) ?>
			
			<tr data-type="added-product-row" data-product-id="<?php echo $product['product_id'] ?>">
				<td class="preload-image preload-image-small" data-loaded="true">
					<?php
						$name = getProductName($product['product_id']);
						
						echo $this->Form->hidden(
							'UserCart.'.$key.'.product_id',
							array(
								'value' => $product['product_id']
							)
						);
						
						if (!$combinations):
							echo $this->Form->hidden(
								'UserCart.'.$key.'.combination_id',
								array(
									'value' => $product['combination_id']
								)
							);
						endif;
						
						echo $this->Form->hidden(
							'UserCart.'.$key.'.quantity',
							array(
								'value' => $product['quantity']
							)
						);
						
						echo $this->Form->hidden(
							'UserCart.'.$key.'.price',
							array(
								'value' => $product['price']
							)
						);
						
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
									'width'      => 60,
									'height'     => 60,
									'no_photo'   => true,
									'watermark'  => $product['product_id'],
									'background' => array(
										'R' => 255,
										'G' => 255,
										'B' => 255
									)
								),
								'html'  => array(
									'image' => array(
										'alt' => h($name)
									)
								)
							)
						);
					?>
				</td>
				<td>
					<span class="product-name">
						<?php echo $name ?>
						
						<?php if ($combinations): ?>
							<br>
							
							<?php
								echo $this->Form->input(
									'UserCart.'.$key.'.combination_id',
									array(
										'div'     => false,
										'label'   => false,
										'type'    => 'select',
										'class'   => 'form-control',
										'options' => $combinations,
										'value'   => $product['combination_id']
									)
								)
							?>
						<?php endif ?>
					</span>
					
					<span class="product-quantity">
						<?php echo showQuantityValue($product['quantity'], $product['product_id']) ?> x <span class="price"><?php echo showPrice($product['price']) ?></span>
					</span>
					
					<a href="#" data-type="delete-offer-tmp-product" data-offer-product-key="<?php echo $key ?>" class="remove" title="<?php echo h(__('Usuń', true)) ?>">
						<?php __('usuń') ?> &times;
					</a>
				</td>
			</tr>
			
			<?php $i++ ?>
			
			<?php if ($i < $count): ?>
				<tr class="hr">
					<td colspan="2">
						<hr>
					</td>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
	</table>
<?php endif ?>