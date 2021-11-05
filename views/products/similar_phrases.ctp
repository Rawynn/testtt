<hr>

<p>
	<strong><?php __('Szukaj także') ?>:</strong>
</p>

<ul class="similar-phrases navigation-list">
	<?php foreach ($phrases as $phrase): ?>
		<li>
			<a href="<?php echo $this->Html->url(getProductsSearchUrl(array('q' => $phrase))) ?>" title="<?php echo h($phrase) ?>">
				<?php echo $phrase ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>