<?php if ($opinions): ?>
	<ul class="opinion-list">
		<?php foreach ($opinions as $opinion): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'item_opinion',
					array(
						'opinion'      => $opinion,
						'product_list' => $product_list
					)
				)
			?>
		<?php endforeach ?>
	</ul>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => __('Brak opinii.', true)
			)
		)
	?>
<?php endif ?>