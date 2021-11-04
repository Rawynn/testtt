<div class="order-complaint-page order-page page">
	
	<div class="page-header">
		<h1>
			<?php if ($order_id): ?>
				<?php echo sprintf(__('Reklamacja do zamówienia nr %s', true), getOrderFullId($order['Order']['id'], true)) ?>
				
				<small>
					<?php echo showDate($order['Order']['created']) ?> - <strong><?php echo $order_status['OrderStatus']['name'] ?></strong>
				</small>
			<?php else: ?>
				<?php __('Złóż reklamację') ?>
			<?php endif ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if (isset($complaint_content)): ?>
				<div>
					<?php echo $complaint_content ?>
				</div>
				
				<?php if (isset($user_code)): ?>
					<a class="btn btn-primary" href="<?php echo $this->Html->url(getComplaintsUrl(array('code' => $user_code))) ?>" title="<?php echo h(__('Zobacz swoje reklamacje', true)) ?>">
						<?php __('Zobacz swoje reklamacje') ?>
					</a>
				<?php endif ?>
			<?php else: ?>
				<?php
					echo $this->Form->create(
						'Complaint',
						array(
							'url'           => getComplaintAddUrl($order_id, $code),
							'class'         => 'address-form form',
							'data-validate' => 'true',
							'autocomplete'  => 'off',
							'data-submit'   => 'once',
							'type'          => 'file'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'username',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Imię i nazwisko', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
						
						echo $this->Form->input(
							'email',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(email)',
								'div'           => 'form-row',
								'label'         => __('E-mail', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
						
						echo $this->Form->input(
							'phone',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Telefon', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
					?>
					
					<div class="form-row">
						<label>
							<?php __('Nr faktury') ?>:
						</label>
						
						<div class="input-group" data-type="invoice-number-autocompleter-container">
							<?php
								echo $this->Form->input(
									'invoice_number',
									array(
										'type'                      => 'text',
										'div'                       => false,
										'label'                     => false,
										'class'                     => 'form-control',
										'escape'                    => false,
										'data-type'                 => 'autocomplete',
										'data-ac'                   => getLoggedUserId() ? 'true' : 'false',
										'data-ac-url'               => $this->Html->url(getInvoicesAutocompleterUrl()),
										'data-ac-handler'           => '[data-type=invoice-number-autocompleter-container]',
										'data-ac-extended'          => 'false',
										'data-trigger-autocomplete' => 'autocomplete-select'
									)
								)
							?>
						</div>
					</div>
					
					<?php
						echo $this->Form->input(
							'order_id',
							array(
								'type'          => 'text',
								'div'           => 'form-row',
								'label'         => __('Nr zamówienia', true).':',
								'class'         => 'form-control',
								'escape'        => false,
								'data-type'     => 'complaint-order-id',
								'data-user-id'  => getLoggedUserId()
							)
						)
					?>
					
					<?php
						/* Produkty */
						echo $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'add'.DS.'products')
					?>
					
					<?php
						echo $this->Form->input(
							'quantity',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Ilość', true).':',
								'class'         => 'form-control',
								'default'       => showQuantityValue(1),
								'escape'        => false
							)
						);
					?>
					
					<div class="form-row">
						<?php
							echo $this->Form->hidden(
								'producer_id',
								array(
									'data-type' => 'complatins-producer-autocomplete-id'
								)
							)
						?>
						
						<label>
							<?php __('Producent') ?>:
						</label>
						
						<div class="input-group" data-type="complaint-producer-autocompleter-toggle">
							<?php
								echo $this->Form->input(
									'producer_name',
									array(
										'type'             => 'text',
										'div'              => false,
										'label'            => false,
										'class'            => 'form-control',
										'escape'           => false,
										'data-type'        => 'complatins-producer-autocomplete-name',
										'data-ac'          => 'true',
										'data-ac-url'      => $this->Html->url(getProducerAutocompleterUrl()),
										'data-ac-handler'  => '[data-type=complaint-producer-autocompleter-toggle]',
										'data-ac-extended' => 'false',
										'data-ac-copy'     => '[data-type=complatins-producer-autocomplete-id]'
									)
								)
							?>
						</div>
					</div>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Rodzaj') ?>:
						</label>
						
						<div class="input-group">
							<?php foreach ($complaint_kinds as $complaint_kind): ?>
								<div class="radio">
									<?php
										echo $this->Form->input(
											'complaint_kind_id',
											array(
												'type'                      => 'radio',
												'div'                       => false,
												'legend'                    => false,
												'default'                   => reset(Set::extract($complaint_kinds, '{n}.ComplaintKind.id')),
												'data-type'                 => 'complaint-kind-radio',
												'data-desctiption-required' => json_encode(Set::combine($complaint_kinds, '{n}.ComplaintKind.id', '{n}.ComplaintKind.complaint_description_required')),
												'options'                   => array(
													$complaint_kind['ComplaintKind']['id'] => $complaint_kind['ComplaintKind']['name']
												)
											)
										)
									?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
					
					<?php if ($complaint_types): ?>
						<div class="form-row field-radio">
							<label>
								<?php __('Typ') ?>:
							</label>
							
							<div class="input-group">
								<?php $complaint_type_id = !empty($this->data['Complaint']['complaint_type_id']) ? $this->data['Complaint']['complaint_type_id'] : $complaint_types[0]['ComplaintType']['id'] ?>
								
								<?php echo $this->Form->hidden('complaint_type_id') ?>
								
								<?php foreach ($complaint_types as $complaint_type): ?>
									<div class="radio">
										<?php
											echo $this->Form->input(
												'complaint_type_id',
												array(
													'type'        => 'radio',
													'div'         => false,
													'legend'      => false,
													'checked'     => $complaint_type['ComplaintType']['id'] == $complaint_type_id,
													'data-type'   => 'complaint-type-radio',
													'hiddenField' => false,
													'data-type'   => 'complaint-type',
													'data-kind'   => $complaint_type['ComplaintType']['complaint_kind_id'],
													'options'     => array(
														$complaint_type['ComplaintType']['id'] => $complaint_type['ComplaintType']['name']
													)
												)
											)
										?>
									</div>
								<?php endforeach ?>
								
								<?php foreach ($complaint_types as $complaint_type): ?>
									<?php if ($complaint_type['ComplaintType']['description']): ?>
										<div class="input-info <?php echo $complaint_type['ComplaintType']['id'] != $complaint_type_id ? 'hide' : '' ?>" data-type="complaint-type-description-<?php echo $complaint_type['ComplaintType']['id'] ?>">
											<?php echo $complaint_type['ComplaintType']['description'] ?>
										</div>
									<?php endif ?>
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>
					
					<?php
						echo $this->Form->input(
							'description',
							array(
								'type'          => 'textarea',
								'data-validate' => 'validate(required-textarea)',
								'div'           => 'form-row',
								'label'         => __('Opis', true).':',
								'class'         => 'form-control long',
								'escape'        => false,
								'data-type'     => 'complaint-description'
							)
						);
						
						echo $this->Form->input(
							'file',
							array(
								'type'          => 'file',
								'div'           => 'form-row',
								'label'         => __('Plik', true).':',
								'class'         => 'form-control',
								'escape'        => false,
								'multiple'      => 'multiple',
								'name'          => 'data[Complaint][file][]'
							)
						);
					?>
					
					<span class="form-info">
						<?php __('Możesz wybrać więcej niż 1 plik.') ?>
					</span>
					
					<?php
						echo $this->Form->input(
							'own_number',
							array(
								'type'   => 'text',
								'div'    => 'form-row',
								'label'  => __('Nr własny', true).':',
								'class'  => 'form-control',
								'escape' => false
							)
						)
					?>
					
					<?php foreach ($complaint_fields as $complaint_field): ?>
						<?php
							$div_options = array(
								'class'     => 'form-row',
								'data-type' => 'complaint-fields',
							);
							
							foreach ($complaint_field['ComplaintKind'] as $complaint_kind_id => $available):
								$div_options['data-kind-'.$complaint_kind_id] = $available;
							endforeach;
						?>
						
						<?php if ($complaint_field['ComplaintField']['type'] == 'text'): ?>
							<?php
								echo $this->Form->input(
									$complaint_field['ComplaintField']['key'],
									array(
										'type'                  => 'text',
										'div'                   => $div_options,
										'label'                 => $complaint_field['ComplaintField']['label'].':',
										'data-validate-pattern' => $complaint_field['ComplaintField']['required'] ? 'validate(required)' : '',
										'class'                 => 'form-control',
										'escape'                => false
									)
								)
							?>
						<?php elseif ($complaint_field['ComplaintField']['type'] == 'longtext'): ?>
							<?php
								echo $this->Form->input(
									$complaint_field['ComplaintField']['key'],
									array(
										'type'                  => 'textarea',
										'div'                   => $div_options,
										'label'                 => $complaint_field['ComplaintField']['label'].':',
										'data-validate-pattern' => $complaint_field['ComplaintField']['required'] ? 'validate(required-textarea)' : '',
										'class'                 => 'form-control',
										'escape'                => false
									)
								)
							?>
						<?php elseif ($complaint_field['ComplaintField']['type'] == 'checkbox'): ?>
							<?php $div_options['class'] .= ' checkbox field-checkbox' ?>
							
							<div <?php echo $this->Html->_parseAttributes($div_options) ?>>
								<div class="label">&nbsp;</div>
								
								<div class="input-group">
									<div class="checkbox">
										<?php
											echo $this->Form->input(
												$complaint_field['ComplaintField']['key'],
												array(
													'type'                  => 'checkbox',
													'div'                   => false,
													'label'                 => $complaint_field['ComplaintField']['label'],
													'data-validate-pattern' => $complaint_field['ComplaintField']['required'] ? 'validate(required)' : '',
													'class'                 => 'form-control',
													'escape'                => false
												)
											)
										?>
									</div>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Adres odbioru') ?>:
							
							<i class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo h(__('Miejsce, z którego towar zostanie odebrany.', true)) ?>"></i>
						</label>
						
						<div class="input-group" data-type="receive-address-list">
							<?php echo $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'receive_user_address') ?>
						</div>
					</div>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Adres doręczenia') ?>:
							
							<i class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo h(__('Miejsce, do którego towar zostanie odesłany po naprawie / wymianie etc.', true)) ?>"></i>
						</label>
						
						<div class="input-group" data-type="shipping-address-list">
							<?php echo $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'user_address') ?>
						</div>
					</div>
					
					<div class="form-actions align-input">
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij reklamację', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>