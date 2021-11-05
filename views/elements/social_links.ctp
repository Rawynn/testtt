<?php if (module('SOCIAL_LINKS')): ?>
	<div class="social-profiles-info">
		<p><?php __('Jesteśmy na') ?>:</p>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_FACEBOOK')): ?>
			<a rel="nofollow" href="<?php echo setting('MODULE_SOCIAL_LINKS_FACEBOOK') ?>" title="Facebook" target="_blank">
				<i class="fa fa-facebook-official" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_TWITTER')): ?>
			<a rel="nofollow" href="<?php echo setting('MODULE_SOCIAL_LINKS_TWITTER') ?>" title="Twitter" target="_blank">
				<i class="fa fa-twitter-square" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_GOOGLE_PLUS')): ?>
			<a rel="nofollow" href="<?php echo setting('MODULE_SOCIAL_LINKS_GOOGLE_PLUS') ?>" title="Google+" target="_blank">
				<i class="fa fa-google-plus-square" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_PINTEREST')): ?>
			<a rel="nofollow" href="<?php echo setting('MODULE_SOCIAL_LINKS_PINTEREST') ?>" title="Pinterest" target="_blank">
				<i class="fa fa-pinterest-square" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_YOUTUBE')): ?>
			<a rel="nofollow" href="<?php echo setting('MODULE_SOCIAL_LINKS_YOUTUBE') ?>" title="Youtube" target="_blank">
				<i class="fa fa-youtube-play" aria-hidden="true"></i>
			</a>
		<?php endif ?>
		
		<?php if (setting('MODULE_SOCIAL_LINKS_INSTAGRAM')): ?>
			<a rel="nofollow" href="<?php echo setting('MODULE_SOCIAL_LINKS_INSTAGRAM') ?>" title="Instagram" target="_blank">
				<i class="fa fa-instagram" aria-hidden="true"></i>
			</a>
		<?php endif ?>
	</div>
<?php endif ?>