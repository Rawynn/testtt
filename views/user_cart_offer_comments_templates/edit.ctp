<div class="page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Edycja szablonu uwag do ofert') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'UserCartOfferCommentsTemplate',
					array(
						'url'           => getUserCartOfferCommentsTemplateEditUrl($id),
						'class'         => 'form',
						'data-validate' => 'true',
						'autocomplete'  => 'off',
						'data-submit'   => 'once'
					)
				)
			?>
				<?php
					echo $this->Form->input(
						'name',
						array(
							'type'          => 'text',
							'data-validate' => 'validate(required)',
							'div'           => 'form-row',
							'label'         => __('Nazwa', true).':',
							'class'         => 'form-control',
							'escape'        => false
						)
					);
					
					echo $this->Form->input(
						'content',
						array(
							'type'          => 'textarea',
							'data-validate' => 'validate(required-textarea)',
							'div'           => 'form-row',
							'label'         => __('Treść', true).':',
							'class'         => 'form-control',
							'escape'        => false
						)
					);
				?>
				
				<span class="form-info required-info">
					<?php __('Pola oznaczone (*) są wymagane') ?>
				</span>
				
				<div class="form-actions align-input">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
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