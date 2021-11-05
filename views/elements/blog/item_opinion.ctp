<li>
	<div class="opinion-author">
		<strong><?php echo $opinion['username'] ?></strong> <span class="text-muted"><?php __('napisał') ?>:</span>
	</div>
	
	<div class="opinion-content">
		<?php echo nl2br($opinion['content']) ?>
	</div>
	
	<div class="opinion-options">
		<span class="opinion-option opinion-publish-date">
			<?php echo showDate($opinion['created']) ?>
		</span>
	</div>
</li>