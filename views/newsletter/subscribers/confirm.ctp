<?php if ($subscriber && !isset($groups_saved) && count($newsletter_groups) > 1): ?>
	<div class="user-newsletter-page user-page page">
		<div class="page-header">
			<h1>
				<?php __('Potwierdzenie zapisu do newslettera') ?>
			</h1>
		</div>
		
		<div class="page-content-container">
			<div class="page-content page-sidebar-true">
				<?php
					echo $this->Form->create(
						'Subscriber',
						array(
							'url'         => getNewsletterSubscriberConfirmUrl($code),
							'class'       => 'form',
							'data-submit' => 'once'
						)
					)
				?>
					<p>
						<strong>
							<?php __('Chcę dopisać się do listy subskrybentów newslettera') ?>:
						</strong>
					</p>
					
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
					
					<div class="form-actions">
						<input class="btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
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