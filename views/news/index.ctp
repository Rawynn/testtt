<div class="news-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Aktualności') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($news): ?>
			<ul class="news-list">
				<?php foreach ($news as $news_item): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'item_news',
							array(
								'news'       => $news_item,
								'show_intro' => true
							)
						)
					?>
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
						'message' => __('Brak aktualności.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>