<div class="producers-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Producenci') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($producers): ?>
			<ul class="producers-list navigation-list">
				<?php foreach ($producers as $producer): ?>
					<li>
						<a href="<?php echo $this->Html->url(getProducerProductsUrl($producer['Producer']['id'])) ?>" title="<?php echo h($producer['Producer']['name']) ?>">
							<?php echo $producer['Producer']['name'] ?>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Nie znaleziono żadnych producentów.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>