<?php
	/* Kategorie przeniesione do views/elements/sidebar.ctp */
?>

<div class="blog-list-page list-page text-page page">
	<div class="page-header">
		<h1>
			<?php __('Blog') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($items): ?>
			<ul class="blog-list">
				<?php foreach ($items as $blog_item): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'item_blog',
							array(
								'blog'       => $blog_item,
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
						'message' => __('Brak wpisów.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>