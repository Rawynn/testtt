<div class="opinion-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Opinie o produktach') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($product_opinions): ?>
			<ul class="opinion-list">
				<?php foreach ($product_opinions as $key => $opinion): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'item_opinion',
							array(
								'opinion'      => $opinion,
								'product_list' => true,
								'show_image'   => true
							)
						)
					?>
					
					<?php if ($key % 2 != 0): ?>
						<li class="divider"></li>
					<?php endif ?>
				<?php endforeach ?>
			</ul>
			
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'paginator',
					array(
						'class' => 'list-page-paginator'
					)
				)
			?>
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
	</div>
</div>