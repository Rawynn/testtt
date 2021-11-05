<?php if ($opinions): ?>
	<ul class="opinion-list">
		<?php foreach ($opinions as $opinion): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'blog'.DS.'item_opinion',
					array(
						'opinion' => $opinion
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
				'message' => __('Brak komentarzy.', true)
			)
		)
	?>
<?php endif ?>