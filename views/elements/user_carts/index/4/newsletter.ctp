<?php if (module('NEWSLETTER') && $order['Order']['email'] && !checkIsSubscriber($order['Order']['email'])): ?>
	<div class="newsletter-order-section">
		
		
		<div class="order-section-inner">
			<h3>
				<?php __('Jesli jeszcze nie zapisales sie do naszego newslettera, mozesz to zrobic teraz') ?><span class="auriell">:</span>
			</h3>
			
			<?php
				echo $this->Form->create(
					'Subscriber',
					array(
						'url'   => getNewsletterSubscriberAddUrl(),
						'class' => 'ajax-modal-form'
					)
				)
			?>
				<?php
					echo $this->Form->hidden(
						'email',
						array(
							'value' => $order['Order']['email']
						)
					)
				?>
				
				<?php if (($newsletter_groups = getNewsletterGroupsList()) && count($newsletter_groups) > 1): ?>
					<div class="newsletter-groups hide">
						<?php
							echo $this->Form->input(
								'NewsletterGroup.NewsletterGroup',
								array(
									'div'      => false,
									'label'    => false,
									'type'     => 'select',
									'options'  => $newsletter_groups,
									'multiple' => 'checkbox',
									'default'  => getSuggestedNewsletterGroupsList()
								)
							)
						?>
					</div>
				<?php endif ?>
				
				<?php if (setting('MODULE_NEWSLETTER_CAPTCHA') && !getLoggedUserId()): ?>
					<div class="captcha">
						<div class="g-recaptcha" id="newsletter-after-order-captcha"></div>
					</div>
				<?php endif ?>
				
					<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Dołącz do newslettera', true)) ?>">
			<?php echo $this->Form->end() ?>
		</div>
	</div>
<?php endif ?>