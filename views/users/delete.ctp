<div class="user-delete-account-page user-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Usuń konto') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'    => 'notice',
						'message'  => __('UWAGA! Po usunięciu konta twoje dane zostaną bezpowrotnie stracone!', true),
						'no_close' => true
					)
				)
			?>
			
			<?php
				echo $this->Form->create(
					'User',
					array(
						'url'          => getUserDeleteAccountUrl(),
						'class'        => 'form',
						'data-submit'  => 'once'
					)
				)
			?>
				<?php
					echo $this->Form->input(
						'password',
						array(
							'type'  => 'password',
							'div'   => 'form-row',
							'label' => __('Hasło', true).':',
							'class' => 'form-control'
						)
					)
				?>
				
				<div class="form-actions align-input">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Usuń konto', true)) ?>">
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