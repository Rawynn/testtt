<div class="user-address-edit-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php echo $order_id ? sprintf(__('Zwrot zamówienia %s', true), getOrderFullId($order_id, true)) : __('Zwrot zamówienia', true) ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if (isset($response) && $response->idNalepki): ?>
				<?php
					echo sprintf(
						__('Na Twój adres e-mail został wysłany list przewozowy. Wydrukuj go i udaj się do urzędu Pocztowego: %s i nadaj przesyłkę. Masz %s dni na nadanie przesyłki.', true),
						$urzad_pocztowy,
						setting('MODULE_POCZTA_EZWROTY_WAZNOSC_ZGODY')
					)
				?>
			<?php else: ?>
				<?php
					echo $this->Form->create(
						'Order',
						array(
							'url'           => getPocztaOrderEzwrotUrl($order_id, $code),
							'class'         => 'address-form form',
							'data-validate' => 'true',
							'data-submit'   => 'once',
							'escapeInputs'  => false
						)
					)
				?>
					<div class="form-inner form-inner-wider">
						<?php
							echo $this->Form->input(
								'Order.name',
								array(
									'type'                  => 'text',
									'data-type'             => 'firstname',
									'data-validate'         => 'validate(required)',
									'data-validate-pattern' => 'validate(required)',
									'label'                 => __('Nazwa', true).':',
									'class'                 => 'form-control',
									'div'                   => array(
										'tag'       => 'div',
										'class'     => 'form-row',
										'data-type' => 'firstname-row'
									)
								)
							);
							
							echo $this->Form->input(
								'Order.street',
								array(
									'type'                  => 'text',
									'data-validate'         => 'validate(required)',
									'data-validate-pattern' => 'validate(required)',
									'div'                   => 'form-row',
									'label'                 => __('Ulica', true).':',
									'class'                 => 'form-control'
								)
							);
							
						?>
						
						<div class="street-number-row form-row">
							<?php
								echo $this->Form->input(
									'Order.street_number_1',
									array(
										'type'                  => 'text',
										'data-validate'         => 'validate(required)',
										'data-validate-pattern' => 'validate(required)',
										'div'                   => false,
										'label'                 => __('Nr domu', true).':',
										'class'                 => 'form-control',
										'error'                 => false
									)
								);
								
								echo $this->Form->input(
									'Order.street_number_2',
									array(
										'type'          => 'text',
										'div'           => false,
										'label'         => array(
											'text' => __('/', true),
											'class'=> 'street-number-separator'
										),
										'class'         => 'form-control'
									)
								);
							?>
						</div>
						
						<?php
							echo $this->Form->input(
								'Order.postcode',
								array(
									'type'                  => 'text',
									'data-validate'         => 'validate(required, postal-pl)',
									'data-validate-pattern' => 'validate(required, postal-pl)',
									'div'                   => 'form-row',
									'label'                 => __('Kod pocztowy', true).':',
									'class'                 => 'form-control'
								)
							);
							
							echo $this->Form->input(
								'Order.city',
								array(
									'type'                  => 'text',
									'data-validate'         => 'validate(required)',
									'data-validate-pattern' => 'validate(required)',
									'div'                   => 'form-row',
									'label'                 => __('Miasto', true).':',
									'class'                 => 'form-control'
								)
							);
							
							echo $this->Form->input(
								'Order.email',
								array(
									'type'                  => 'email',
									'data-validate'         => 'validate(email)',
									'data-validate-pattern' => 'validate(email)',
									'div'                   => 'form-row',
									'label'                 => __('E-mail', true).': '.$this->Html->icon(
										'info-circle',
										array(
											'data-toggle' => 'tooltip',
											'title'       => __('Na ten adres email zostanie wysłany list przewozowy.', true)
										)
									),
									'class'                 => 'form-control'
								)
							);
							
							echo $this->Form->input(
								'Order.phone',
								array(
									'type'    => 'number',
									'pattern' => "[0-9]*",
									'div'   => 'form-row',
									'label' => __('Telefon', true).':',
									'class' => 'form-control'
								)
							);
							
							echo $this->Form->input(
								'Order.id',
								array(
									'type'                  => 'text',
									'data-validate'         => 'validate(required)',
									'data-validate-pattern' => 'validate(required)',
									'div'                   => 'form-row',
									'label'                 => __('Nr zamówienia', true).':',
									'class'                 => 'form-control'
								)
							);
							
							echo $this->Form->hidden(
								'Order.pni',
								array(
									'data-type' => 'order-pni'
								)
							);
							
							echo $this->Form->input(
								'Order.pni_search',
								array(
									'type'             => 'text',
									'div'              => 'form-row',
									'label'            => __('Placówka', true).': '.$this->Html->icon(
										'info-circle',
										array(
											'data-toggle' => 'tooltip',
											'title'       => __('Wybierz placówkę Poczty Polskiej w której nadasz przesyłkę.', true)
										)
									),
									'class'            => 'form-control',
									'placeholder'      => __('Podaj adres lub kod pocztowy', true),
									'data-type'        => 'autocomplete',
									'data-ac'          => 'true',
									'data-ac-url'      => $this->Html->url(getPocztaEzwrotPlacowkiSearchUrl()),
									'data-ac-handler'  => '[data-type=orders-pni-search-container]',
									'data-ac-extended' => 'false',
									'data-ac-copy'     => '[data-type=order-pni]',
									'div'              => array(
										'data-type' => 'orders-pni-search-container',
										'class'     => 'autocompleter-container form-row'
									)
								)
							);
						?>
						
						<?php
							echo $this->Form->input(
								'zgoda',
								array(
									'type'  => 'checkbox',
									'div'   => 'form-row checkbox',
									'label' => __('Wyrażam zgodę na przesłanie za pomocą środków komunikacji elektronicznej na wskazany adres e-mail i nr telefonu, informacji handlowych, dotyczących produktów i usług Poczty Polskiej S.A., zgodnie z ustawą z dnia 18 lipca 2002 r. o świadczeniu usług drogą elektroniczną. Zgoda, o której mowa w niniejszej klauzuli, obejmuje również zgodę na przekazywanie informacji handlowych w przyszłości', true)
								)
							)
						?>
						
						<span class="form-info required-info">
							<?php __('Pola oznaczone (*) są wymagane') ?>
						</span>
						
						<div class="form-actions">
							<a class="btn-back btn btn-link btn-lg" href="<?php echo $this->Html->url(getPageParamValue('redirect_to') ? getPageParamValue('redirect_to') : getOrdersUrl()) ?>" title="<?php echo h(__('Anuluj', true)) ?>">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
						</div>
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
