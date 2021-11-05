<div class="user-newsletter-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Newsletter') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'Subscriber',
					array(
						'url'         => getNewsletterSubscriberMyAccountUrl(),
						'class'       => 'form',
						'data-submit' => 'once'
					)
				)
			?>
				<?php if (true || count($newsletter_groups) <= 1): ?>
					<?php
						echo $this->Form->input(
							'newsletter',
							array(
								'type'  => 'checkbox',
								'div'   => 'form-row checkbox',
								'label' => sprintf(
									__('Chcę otrzymywać informacje na temat promocji, nowości i wydarzeń sklepu %s', true),
									setting('GLOBAL_STORE_NAME')
								)
							)
						)
					?>
				<?php else: ?>
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
				<?php endif ?>
				
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