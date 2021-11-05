<div class="gift-list-edit-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Listy życzeń') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'GiftsList',
					array(
						'url'           => getGiftListEditUrl($id),
						'class'         => 'gift-list-edit-form form',
						'data-validate' => 'true',
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
							'label'         => __('Nazwa listy życzeń', true).':',
							'class'         => 'form-control',
							'escape'        => false
						)
					)
				?>
				
				<div class="date-range-row form-row">
					<?php
						echo $this->Form->input(
							'date_from',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => false,
								'label'         => __('Data od', true).':',
								'class'         => 'form-control datepicker',
								'escape'        => false
							)
						);
						
						echo $this->Form->input(
							'date_to',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => false,
								'label'         => array(
									'text'      => __('do', true),
									'class'     => 'date-range-separator'
								),
								'class'         => 'form-control datepicker',
								'escape'        => false
							)
						);
					?>
				</div>
				
				<div class="form-row">
					<label>
						<?php __('Aktywna') ?>:
					</label>
					
					<div class="input-group">
						<?php foreach (array(1 => __('Tak', true), 0 => __('Nie', true)) as $key => $value): ?>
							<?php
								echo $this->Form->input(
									'active',
									array(
										'type'      => 'radio',
										'options'   => array(
											$key => $value
										),
										'legend'    => false,
										'default'   => 1
									)
								)
							?>
						<?php endforeach ?>
					</div>
				</div>
				
				<div class="form-row">
					<label>
						<?php __('Lista przedmiotów') ?>:
					</label>
					
					<?php $key = -1 ?>
					
					<?php if ($this->data['Product']): ?>
						<?php foreach ($this->data['Product'] as $key => $product): ?>
							<?php
								echo $this->element(
									TEMPLATE_NAME.DS.'gifts_list'.DS.'input_product',
									array(
										'key'         => $key,
										'show_delete' => true
									)
								)
							?>
						<?php endforeach ?>
					<?php endif ?>
					
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'gifts_list'.DS.'input_product',
							array(
								'key'         => ++$key,
								'show_delete' => false
							)
						)
					?>
				</div>
				
				<span class="form-info required-info">
					<?php __('Pola oznaczone (*) są wymagane') ?>
				</span>
				
				<div class="form-actions align-input">
					<a class="btn-back btn btn-link btn-lg" href="<?php echo $this->Html->url(getGiftListUrl()) ?>" title="<?php echo h(__('Anuluj', true)) ?>">
						<?php __('Anuluj') ?>
					</a>
					
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