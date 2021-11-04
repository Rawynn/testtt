<?php if ($kit_products): ?>
	<div class="product-kit">
		<p class="text-muted">
			<?php __('W skład zestawu wchodzą następujące produkty') ?>:
		</p>
		
		<ul class="product-kit-list navigation-list">
			<?php foreach ($kit_products as $kit_product): ?>
				<?php if (isset($kit_product['KitsGroupingCode']['start_name'])): ?>
					<li>
						<strong>
							<?php
								echo $kit_product['KitsGroupingCode']['start_name']
							?>
						</strong>
					</li>
				<?php endif ?>
				
				<li>
					<a href="<?php echo $this->Html->url(getProductUrl($kit_product['KitProduct']['product_id'])) ?>" title="<?php echo h($kit_product['KitProduct']['name']) ?>">
						<?php echo $kit_product['KitProduct']['name'] ?>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>