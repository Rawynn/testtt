<?php if ($opinions): ?>
	<ul class="opinion-list" itemprop="review" itemscope itemtype="http://schema.org/Review" >
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