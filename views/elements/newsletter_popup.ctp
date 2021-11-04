<?php if (showNewsletterPopUp()): ?>
	<div class="newsletter-modal modal fade" data-type="newsletter-popup" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h2>
						<?php __('Zapisz się do Newslettera') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => __('Podaj nam swój email aby otrzymywać informacje o nowościach i promocjach.', true),
								'no_close' => true
							)
						)
					?>
					
					<?php
						echo $this->Form->create(
							'Subscriber',
							array(
								'url' => getNewsletterSubscriberAddUrl(isHomePageView() ? array('from' => 'main') : array())
							)
						)
					?>
						<?php
							echo $this->Form->input(
								'email',
								array(
									'type'        => 'text',
									'div'         => 'newsletter-popup-email',
									'label'       => false,
									'class'       => 'form-control',
									'default'     => getUserEmail(),
									'placeholder' => __('Twój e-mail', true)
								)
							)
						?>
						
						<?php if ((isset($show_groups) ? $show_groups : true) && ($newsletter_groups = getNewsletterGroupsList()) && count($newsletter_groups) > 1): ?>
							<div class="newsletter-popup-groups">
								<?php
									echo $this->Form->input(
										'NewsletterGroup.NewsletterGroup',
										array(
											'div'      => false,
											'label'    => false,
											'type'     => 'select',
											'options'  => $newsletter_groups,
											'multiple' => 'checkbox',
											'default'  => getSuggestedNewsletterGroupsList(),
											'id'       => 'NewsletterGroupNewsletterGroupPopUp'
										)
									)
								?>
							</div>
						<?php endif ?>
						
						<?php if (setting('MODULE_NEWSLETTER_CAPTCHA') && !getLoggedUserId()): ?>
							<div class="captcha">
								<div class="g-recaptcha" id="newsletter-pop-captcha"></div>
							</div>
						<?php endif ?>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" title="<?php echo h(__('Anuluj', true)) ?>">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>