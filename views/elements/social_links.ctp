<?php if (module('SOCIAL_LINKS')): ?>
	<div class="social-profiles-info">
	
		<?php if (setting('MODULE_SOCIAL_LINKS_INSTAGRAM')): ?>
			<a href="<?php echo setting('MODULE_SOCIAL_LINKS_INSTAGRAM') ?>" title="Instagram" target="_blank">
				<i class="sprite sprite-insta" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_FACEBOOK')): ?>
			<a href="<?php echo setting('MODULE_SOCIAL_LINKS_FACEBOOK') ?>" title="Facebook" target="_blank">
				<i class="sprite sprite-face" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_TWITTER')): ?>
			<a href="<?php echo setting('MODULE_SOCIAL_LINKS_TWITTER') ?>" title="Twitter" target="_blank">
				<i class="fa fa-twitter-square" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_GOOGLE_PLUS')): ?>
			<a href="<?php echo setting('MODULE_SOCIAL_LINKS_GOOGLE_PLUS') ?>" title="Google+" target="_blank">
				<i class="fa fa-google-plus-square" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_PINTEREST')): ?>
			<a href="<?php echo setting('MODULE_SOCIAL_LINKS_PINTEREST') ?>" title="Pinterest" target="_blank">
				<i class="sprite sprite-pin" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_YOUTUBE')): ?>
			<a href="<?php echo setting('MODULE_SOCIAL_LINKS_YOUTUBE') ?>" title="Youtube" target="_blank">
				<i class="fa fa-youtube-square" aria-hidden="true"></i>
			</a>
		<?php endif ?>
	</div>
<?php endif ?>