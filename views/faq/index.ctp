<div class="faq-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('FAQ') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($faqs): ?>
			<ul class="faq-list">
				<?php foreach ($faqs as $faq): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'item_faq',
							array(
								'faq'     => $faq,
								'counter' => isset($i) ? ++$i : $i = 1
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
						'message' => __('Brak pytań.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>