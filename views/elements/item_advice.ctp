<li>
	<h3>
		<?php if (isset($title_as_link) && $title_as_link): ?>
			<a href="<?php echo $this->Html->url(getAdviceUrl($advice['Advice']['id'])) ?>" class="advice-more btn btn-link" title="<?php echo h($advice['Advice']['title']) ?>">
				<?php echo $advice['Advice']['title'] ?>
			</a>
		<?php else: ?>
			<?php echo $advice['Advice']['title'] ?>
		<?php endif ?>
	</h3>
	
	<?php if ($advice['Advice']['content'] && !isset($no_advice_content)): ?>
		<div class="advice-content cms-content">
			<?php
				echo $advice['Advice']['content']
			?>
		</div>
	<?php endif ?>
	
	<?php if (isset($show_more_link) && $show_more_link): ?>
		<a class="advice-more btn btn-link pull-right" href="<?php echo $this->Html->url(getAdviceUrl($advice['Advice']['id'])) ?>" title="<?php echo h($advice['Advice']['title']) ?>">
			<?php __('Więcej') ?> <i class="fa fa-chevron-right"></i>
		</a>
	<?php endif ?>
</li>