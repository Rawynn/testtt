<?php if (!(getPageParamValue('send') == true)): ?>
	<div class="user-newsletter-page user-page page">
		<div class="page-header">
			<h1>
				<?php __('Rezygnacja z newslettera') ?>
			</h1>
		</div>
		
		<div class="page-content-container">
			<div class="page-content page-sidebar-true">
				<?php
					echo $this->Form->create(
						'Subscriber',
						array(
							'url'         => getNewsletterSubscriberDeleteUrl(),
							'class'       => 'form',
							'data-submit' => 'once'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'email',
							array(
								'type'          => 'email',
								'data-validate' => 'validate(email)',
								'div'           => 'form-row',
								'label'         => __('Podaj adres e-mail', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						)
					?>
					
					<div class="form-row checkbox-group">
						<label>
							&nbsp;
						</label>
						
						<div class="checkbox-group-checkboxes">
							<?php
								echo $this->Form->input(
									'NewsletterGroup.NewsletterGroup',
									array(
										'type'     => 'select',
										'multiple' => 'checkbox',
										'div'      => 'form-row checkbox-group',
										'label'    => false,
										'options'  => $newsletter_groups
									)
								)
							?>
						</div>
					</div>
					
					<div class="form-actions align-input">
						<input class="btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Usuń', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			</div>
			
			<div class="page-sidebar">
				<?php
					/* Sidebar */
					echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
				?>
			</div>
		</div>
	</div>
<?php endif ?>
