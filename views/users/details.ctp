<div class="user-details-page user-page list-page text-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Szczegóły klienta') ?> "<?php echo $user['User']['first_name'].' '.$user['User']['last_name']?>"
		</h1>
	</div>
	
	<div class="page-content">
		<?php
			echo $this->Form->create(
				'User',
				array(
					'url'          => getUserDetailsUrl($id),
					'class'        => 'form',
					'autocomplete' => 'off',
					'data-submit'  => 'once',
					'escapeInputs' => false
				)
			)
		?>
			<?php
				echo $this->Form->input(
					'first_name',
					array(
						'type'     => 'text',
						'div'      => 'form-row',
						'label'    => __('Imię', true).':',
						'class'    => 'form-control form-hidden',
						'value'    => $user['User']['first_name'],
						'disabled' => 'disabled'
					)
				);
				
				echo $this->Form->input(
					'last_name',
					array(
						'type'     => 'text',
						'div'      => 'form-row',
						'label'    => __('Nazwisko', true).':',
						'class'    => 'form-control form-hidden',
						'value'    => $user['User']['last_name'],
						'disabled' => 'disabled'
					)
				);
				
				if (isset($user['User']['company_name'])):
					echo $this->Form->input(
						'company_name',
						array(
							'type'     => 'text',
							'div'      => 'form-row',
							'label'    => __('Nazwa firmy', true).':',
							'class'    => 'form-control form-hidden',
							'value'    => $user['User']['company_name'],
							'disabled' => 'disabled'
						)
					);
				endif;
				
				echo $this->Form->input(
					'phone',
					array(
						'type'     => 'number',
						'pattern'  => "[0-9]*",
						'div'      => 'form-row',
						'label'    => __('Telefon', true).':',
						'class'    => 'form-control form-hidden',
						'value'    => $user['User']['phone'],
						'disabled' => 'disabled'
					)
				);
				
				echo $this->Form->input(
					'email',
					array(
						'type'     => 'email',
						'div'      => 'form-row',
						'label'    => __('Adres e-mail', true).':',
						'class'    => 'form-control form-hidden',
						'value'    => $user['User']['email'],
						'disabled' => 'disabled'
					)
				);
			?>
			
			<?php if ($custom_user_fields): ?>
				<hr/>
				
				<?php foreach ($custom_user_fields as $custom_user_field_key => $custom_user_field_label): ?>
					<?php
						echo $this->Form->input(
							$custom_user_field_key,
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => $custom_user_field_label.':',
								'class'   => 'form-control',
								'default' => $user['User'][$custom_user_field_key]
							)
						)
					?>
				<?php endforeach ?>
				
				<div class="form-actions align-input">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
				</div>
			<?php endif ?>
			
			<div class="user-details-tab clear">
				<a class="responsive-toggle" data-type="toggle" href="#UserDetailTabs">
					<?php __('Menu') ?>
				</a>
				
				<ul class="user-detail-tabs tabs nav-justified" id="UserDetailTabs">
					<li class="active">
						<a href="#group-and-price-list" title="<?php echo h(__('Grupa i cennik', true)) ?>">
							<?php __('Grupa i cennik') ?>
						</a>
					</li>
					<li>
						<a href="#orders" title="<?php echo h(__('Zamówienia', true)) ?>">
							<?php __('Zamówienia') ?>
						</a>
					</li>
					<li>
						<a href="#addresses" title="<?php echo h(__('Adresy', true)) ?>">
							<?php __('Adresy') ?>
						</a>
					</li>
					<li>
						<a href="#invoices" title="<?php echo h(__('Faktury', true)) ?>">
							<?php __('Faktury') ?>
						</a>
					</li>
					<li>
						<a href="#notes" title="<?php echo h(__('Notatki', true)) ?>">
							<?php __('Notatki') ?>
						</a>
					</li>
				</ul>
				
				<div class="tab-content">
					<div class="user-details-tab-pane tab-pane active" id="group-and-price-list">
						<?php
							/* Grupa i cennik */
							echo $this->element(TEMPLATE_NAME.DS.'user'.DS.'details'.DS.'group_and_price_list')
						?>
					</div>
					
					<div class="user-details-tab-pane tab-pane" id="orders">
						<?php
							/* Zamówienia */
							echo $this->element(TEMPLATE_NAME.DS.'user'.DS.'details'.DS.'orders')
						?>
					</div>
					
					<div class="user-details-tab-pane tab-pane" id="addresses">
						<?php
							/* Adresy */
							echo $this->element(TEMPLATE_NAME.DS.'user'.DS.'details'.DS.'addresses')
						?>
					</div>
					
					<div class="user-details-tab-pane tab-pane" id="invoices">
						<?php
							/* Faktury */
							echo $this->element(TEMPLATE_NAME.DS.'user'.DS.'details'.DS.'invoices')
						?>
					</div>
					
					<div class="user-details-tab-pane tab-pane" id="notes">
						<?php
							/* Notatki */
							echo $this->element(TEMPLATE_NAME.DS.'user'.DS.'details'.DS.'notes')
						?>
					</div>
				</div>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>

<?php
	/* Dodanie notatki */
	echo $this->element(TEMPLATE_NAME.DS.'user'.DS.'details'.DS.'add_note')
?>
