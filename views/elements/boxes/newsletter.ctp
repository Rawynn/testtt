<?php if (module('NEWSLETTER')): ?>
	<section class="newsletter-box aside-box">
		<a class="responsive-toggle" data-type="toggle" href="#<?php echo isset($id) ? $id : 'BoxNewsletter' ?>">
			<?php __('Newsletter') ?>
		</a>
		
		<div class="box-content" id="<?php echo isset($id) ? $id : 'BoxNewsletter' ?>">
			<div class="newsletter-label">
				<?php __('Podaj nam swoj email aby otrzymywac informacje o nowosciach i promocjach') ?>
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
						'email',
						array(
							'div'         => false,
							'label'       => false,
							'class'       => 'form-control',
							'placeholder' => __('Podaj swój adres e-mail', true)
						)
					)
				?>
				
				<input class="btn btn-primary btn-form-size" type="submit" value="<?php echo h(__('Zapisz się', true)) ?>">
				
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