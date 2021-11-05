<?php if (module('NEWSLETTER')): ?>
	<section class="newsletter-box aside-box">
		<h5 class="box-header">
			<i class="sprite sprite-newsletter"></i> <?php __('Newsletter') ?>
		</h5>
		
		<a class="responsive-toggle" data-type="toggle" href="#<?php echo isset($id) ? $id : 'BoxNewsletter' ?>">
			<?php __('Newsletter') ?>
		</a>
		
		<div class="box-content" id="<?php echo isset($id) ? $id : 'BoxNewsletter' ?>">
			<div class="newsletter-label">
				<?php __('Otrzymuj jako pierwszy informacje o promocjach i nowościach.<br/><strong>Zapisz się do newslettera:</strong>') ?>
			</div>
			
			<?php
				echo $this->Form->create(
					'Subscriber',
					array(
						'url'   => getNewsletterSubscriberAddUrl(isHomePageView() ? array('from' => 'main') : array()),
						'class' => 'newsletter-form ajax-modal-form'
					)
				)
			?>
				<?php
						echo $this->Form->input(
							'FreshMail.imie',
							array(
								'div'         => false,
								'label'       => false,
								'class'       => 'form-control',
								'placeholder' => __('IMIĘ', true)
							)
						)
					?>
				<?php
					echo $this->Form->input(
						'email',
						array(
							'div'         => false,
							'label'       => false,
							'class'       => 'form-control',
							'placeholder' => __('E-MAIL', true)
						)
					)
				?>
				
				<button class="btn btn-form-size btn-primary" type="submit"><?php __('Zapisz się')?> <i class="fa fa-angle-right"></i></button>
				<?php if ((isset($show_groups) ? $show_groups : true) && $newsletter_groups = getNewsletterGroupsList()): ?>
					<div class="newsletter-groups">
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
						<div class="g-recaptcha" id="<?php isset($id) ? strtolower($id) : 'box-newsletter' ?>-captcha"></div>
					</div>
				<?php endif ?>
			<?php echo $this->Form->end() ?>
		</div>
	</section>
<?php endif ?>