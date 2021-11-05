<div class="advice-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Porady') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($advices): ?>
			<ul class="advice-list">
				<?php foreach ($advices as $advice): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'item_advice',
							array(
								'advice' => $advice
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
						'message' => __('Brak porad.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>