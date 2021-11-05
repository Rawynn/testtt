<?php if ($products): ?>
	<hr/>
	
	<div class="product-kit">
		<p class="text-muted">
			<?php __('Produkt możesz zamówić tylko w ramach zestawu') ?>:
		</p>
		<ul class="product-kit-list navigation-list">
			<?php foreach ($products as $product): ?>
				<li>
					<a href="<?php echo $this->Html->url(getProductUrl($product['Kit']['id'])) ?>" title="<?php echo h($product['Kit']['name']) ?>">
						<?php echo $product['Kit']['name'] ?>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
	
	<hr/>
<?php endif ?>