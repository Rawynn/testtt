<div class="tags-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Tagi') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($tags): ?>
			<?php foreach ($tags as $tag): ?>
				<a class="tag-item <?php echo $tag['Tag']['class'] ?>" href="<?php echo $this->Html->url(getTagProductsUrl($tag['Tag']['id'])) ?>" title="<?php echo h($tag['Tag']['name']) ?>">
					<?php echo $tag['Tag']['name'] ?>
				</a>
			<?php endforeach ?>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Brak tagów.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>