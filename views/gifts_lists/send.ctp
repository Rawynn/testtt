<div class="gift-list-send-page user-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Listy życzeń') ?>
		</h1>
	</div>
	
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<div class="form">
				<?php
					echo $this->Form->create(
						'GiftsList',
						array(
							'url'         => getGiftListSendUrl($id),
							'data-submit' => 'once'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'emails',
							array(
								'type'  => 'text',
								'div'   => 'form-row',
								'label' => __('Adres e-mail', true).':',
								'class' => 'form-control'
							)
						)
					?>
					
					<span class="form-info">
						<?php __('Możesz podać wiele adresów e-mail, oddzielając je przecinkiem.') ?>
					</span>
					
					<?php
						echo $this->Form->input(
							'message',
							array(
								'type'  => 'textarea',
								'div'   => 'form-row',
								'label' => __('Twoja wiadomość', true).':',
								'class' => 'form-control long'
							)
						)
					?>
					
					<div class="form-actions align-input">
						<a class="btn-back btn btn-link btn-lg" href="<?php echo $this->Html->url(getGiftListUrl()) ?>" title="<?php echo h(__('Powrót', true)) ?>">
							<?php __('Powrót') ?>
						</a>
						
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
				
				<hr>
				
				<?php
					echo $this->Form->input(
						'User.url',
						array(
							'type'  => 'textarea',
							'div'   => 'form-row',
							'label' => __('Lub wklej poniższy link', true).':',
							'class' => 'form-control',
							'value' => $this->Html->url(getGiftListShowUrl($code), true)
						)
					)
				?>
			</div>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>