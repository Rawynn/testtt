<div class="user-recommend-page user-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Poleć stronę znajomym') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'User',
					array(
						'url'          => getRecommendPageUrl(),
						'class'        => 'form',
						'data-submit'  => 'once'
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
				
				<?php if (getLoggedUserId()): ?>
					<?php
						echo $this->Form->input(
							'User.url',
							array(
								'type'  => 'textarea',
								'div'   => 'form-row',
								'label' => __('Link polecający', true).':',
								'class' => 'form-control',
								'value' => Router::url('/?u_code='.getUserRecommendationCode(getLoggedUserId()), true)
							)
						)
					?>
					
					<span class="form-info">
						<?php __('Możesz także wkleić poniższy link na strony.') ?>
					</span>
				<?php endif ?>
				
				<div class="form-actions align-input">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Poleć', true)) ?>">
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