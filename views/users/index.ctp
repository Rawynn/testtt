<div class="user-list-page user-page list-page text-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Lista klientów') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content">
		<?php
			echo $this->Form->create(
				'Order',
				array(
					'url'         => getUsersListUrl(),
					'class'       => 'user-search-form form form-user-search',
					'data-submit' => 'once',
					'data-type'   => 'users-list-search-form',
					'type'        => 'get'
				)
			)
		?>
			<?php
				echo $this->Form->hidden(
					'search',
					array(
						'value'     => 1,
						'data-send' => 'submit'
					)
				)
			?>
			
			<h2>
				<?php __('Wyszukaj') ?>
			</h2>
			
			<?php
				echo $this->Form->input(
					'name',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Nazwa', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('name'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'nip',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('NIP', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('nip'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'phone',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Telefon', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('phone'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'email',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('E-mail', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('email'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'city',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Miejscowość', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('city'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'status',
					array(
						'type'      => 'select',
						'div'       => 'form-row',
						'label'     => __('Status', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('status'),
						'data-send' => 'submit',
						'empty'     => __('-wszyscy-', true),
						'options' => array(
							1 => __('aktywny', true),
							0 => __('niepotwierdzony', true),
							2 => __('zablokowany', true)
						)
					)
				);
				
				echo $this->Form->input(
					'salesrep_id',
					array(
						'type'      => 'select',
						'div'       => 'form-row',
						'label'     => __('Handlowiec', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('salesrep_id'),
						'data-send' => 'submit',
						'empty'     => __('-wszyscy-', true),
						'options'   => $salesreps
					)
				);
				
				foreach ($custom_user_fields as $custom_user_field_key => $custom_user_field_label):
					echo $this->Form->input(
						'custom_'.$custom_user_field_key,
						array(
							'type'      => 'text',
							'div'       => 'form-row',
							'label'     => $custom_user_field_label.':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('custom_'.$custom_user_field_key),
							'data-send' => 'submit'
						)
					);
				endforeach;
			?>
			
			<div class="form-row pull-right">
				<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
			</div>
		<?php echo $this->Form->end() ?>
		
		<?php if ($users): ?>
			<?php
				/* Lista klientów */
				echo $this->element(TEMPLATE_NAME.DS.'users'.DS.'list')
			?>
		<?php else: ?>
			<?php if (!$this->data): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Brak klientów.', true)
						)
					)
				?>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Nie znaleziono żadnych klientów spełniających kryteria.', true)
						)
					)
				?>
			<?php endif ?>
			
			<div class="user-list-view-options">
				<div class="options-container form form-inline">
					<a class="btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserAddUrl()) ?>" title="<?php echo h(__('Dodaj nowego klienta', true)) ?>">
						<?php __('Dodaj nowego klienta') ?>
					</a>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>