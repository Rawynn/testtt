<?php if (setting('MODULE_WEB_PUSH_API_KEY')): ?>
	<script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
	
	<?php
		echo $this->Javascript->link(
			array(
				'webpush'.DS.'webpush'
			)
		)
	?>
	
	<script>
		var config = {
			apiKey           : "<?php echo setting('MODULE_WEB_PUSH_API_KEY') ?>",
			authDomain       : "<?php echo setting('MODULE_WEB_PUSH_PROJECT_ID') ?>.firebaseapp.com",
			messagingSenderId: "<?php echo setting('MODULE_WEB_PUSH_SENDER_ID') ?>",
		};
		
		firebase.initializeApp(config);
		
		const messaging = firebase.messaging();
	</script>
	
	<?php if (showWebpushDialog()): ?>
		<div class="modal fade" id="WebPushAddSubscription" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Powiadomienia') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php __('Czy chcesz dostawać powiadomienia od Nas? Jeżeli tak kliknij zgodę powyżej') ?>
					</div>
					
					<div class="modal-footer modal-actions">
						<a class="btn-back btn btn-lg" href="#" data-type="webpush-refuse">
							<?php __('Nie') ?>
						</a>
						
						<a class="btn-next btn btn-primary btn-lg" href="#" data-type="webpush-confirm">
							<?php __('Tak') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
	
	<?php if (empty($_COOKIE['webPushDenied']) && !empty($_COOKIE['webPushToken-wszyscy']) && $this->Session->read('Personalization.email') && empty($_COOKIE['webPushToken-'.str_replace('.', '_', $this->Session->read('Personalization.email'))])): ?>
		<?php /* Dodaję tag jeżeli nie było do tej porty tagu z emailem */ ?>
		<script>
			$(function(){
				setTimeout(
					function(){
						webpush_set_tag("<?php echo $this->Session->read('Personalization.email') ?>");
					},
					5000
				);
			});
		</script>
	<?php endif ?>
<?php endif ?>