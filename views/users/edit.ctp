<div class="user-edit-account-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Edycja konta') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'User',
					array(
						'url'           => getUserAccountEditUrl(),
						'class'         => 'form',
						'data-validate' => 'true',
						'autocomplete'  => 'off',
						'data-submit'   => 'once',
						'type'          => 'file'
					)
				)
			?>
				<div class="form-inner form-inner-wider">
					<?php
						echo $this->Form->input(
							'first_name',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row form-block',
								'placeholder'   => __('Imię', true),
								'label'         => false,
								'class'         => 'form-control',
								'escape'        => false
							)
						);
						
						echo $this->Form->input(
							'last_name',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row form-block',
								'placeholder'   => __('Nazwisko', true),
								'label'         => false,
								'class'         => 'form-control',
								'escape'        => false
							)
						);
						
						if (module('B2B')):
							echo $this->Form->input(
								'company_name',
								array(
									'type'          => 'text',
									'data-validate' => 'validate(required)',
									'div'           => 'form-row form-block',
									'placeholder'   => __('Nazwa firmy', true),
									'label'         => false,
									'class'         => 'form-control',
									'escape'        => false
								)
							);
						endif;
						
						if (isset($currencies)):
							echo $this->Form->input(
								'currency',
								array(
									'type'    => 'select',
									'div'     => 'form-row form-block',
									'label'   => false,
									'class'   => 'form-control',
									'options' => $currencies,
									'empty'   => __('Waluta', true)
								)
							);
						endif;
						
						echo $this->Form->input(
							'email',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(email)',
								'div'           => 'form-row form-block',
								'placeholder'   => __('E-mail', true),
								'label'         => false,
								'class'         => 'form-control'
							)
						);
						
						echo $this->Form->input(
							'email_2',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(email, match-value(#UserEmail))',
								'div'           => 'form-row form-block',
								'placeholder'   => __('Powtórz e-mail', true),
								'label'         => false,
								'class'         => 'form-control'
							)
						);
					?>
					
					<?php if (isset($user['User']['tmp_mail']) && $user['User']['tmp_mail']):?>
						<span class="form-info">
							<?php
								echo sprintf(
									__('Powyższy adres e-mail został zmieniony na %s. Wymaga on potwierdzenia poprzez kliknięcie w link wysłany na ten adres. Jeżeli chcesz anulować zmianę adresu e-mail kliknij %s. Do czasu potwierdzenia nowego adresu należy korzystać ze starego adresu e-mail.', true),
									$this->Html->tag('strong', $user['User']['tmp_mail']),
									$this->Html->link(__('tutaj', true), getUserCancelNewEmailUrl($user['User']['tmp_mail']))
								)
							?>
						</span>
					<?php endif ?>
					
					<?php if (isset($dropshipping) && $dropshipping): ?>
						<?php
							echo $this->Form->input(
								'dropshipping_cod_account',
								array(
									'type'   => 'textarea',
									'div'    => 'form-row',
									'label'  => __('Dropshipping - numer konta do przekazywania pobrań', true).':',
									'class'  => 'form-control long',
									'escape' => false
								)
							)
						?>
					<?php endif ?>
					
					<?php if (module('PKCS')): ?>
						<?php
							echo $this->Form->input(
								'pkcs',
								array(
									'type'  => 'file',
									'div'   => 'form-row',
									'label' => __('Klucz publiczny PKCS', true).':',
									'class' => 'form-control'
								)
							);
						?>
					<?php endif ?>
					
					<?php if (module('OFFERS') && userIsSalesrep()): ?>
						<hr>
						
						<h3>
							<?php __('Wysyłka ofert') ?>
						</h3>
						
						<div class="form-row radio-group">
							<label>
								<?php __('Wysyłaj oferty') ?>:
							</label>
							
							<div class="radio-list">
								<?php
									foreach (array(1 => __('z ogólnego konta e-mail sklepu', true), 2 => __('z własnego konta e-mail', true).':') as $custom_smtp_key => $custom_smtp_option):
										echo $this->Form->input(
											'custom_smtp',
											array(
												'div'         => 'radio',
												'legend'      => false,
												'type'        => 'radio',
												'hiddenField' => false,
												'data-type'   => 'user-salesrep-custom-smtp',
												'default'     => 1,
												'options'     => array(
													$custom_smtp_key => $custom_smtp_option
												)
											)
										);
									endforeach;
								?>
							</div>
						</div>
						
						<div data-type="salesrep-smtp-configuration">
							<div class="form-row radio-group">
								<label>
									<?php __('Wysyłaj przez Microsoft EWS') ?>:
								</label>
								
								<div class="radio-list">
									<?php
										foreach (array(1 => __('tak', true), 0 => __('nie', true)) as $smtp_ews_key => $smtp_ews_option):
											echo $this->Form->input(
												'smtp_ews',
												array(
													'div'         => 'radio',
													'legend'      => false,
													'type'        => 'radio',
													'hiddenField' => false,
													'options'     => array(
														$smtp_ews_key => $smtp_ews_option
													)
												)
											);
										endforeach;
									?>
								</div>
							</div>
							
							<?php
								echo $this->Form->input(
									'smtp_host',
									array(
										'type'   => 'text',
										'div'    => 'form-row',
										'label'  => __('Host SMTP', true).':',
										'class'  => 'form-control',
										'escape' => false
									)
								);
								
								echo $this->Form->input(
									'smtp_login',
									array(
										'type'   => 'text',
										'div'    => 'form-row',
										'label'  => __('Login poczty SMTP', true).':',
										'class'  => 'form-control',
										'escape' => false
									)
								);
								
								echo $this->Form->input(
									'smtp_password',
									array(
										'type'   => 'password',
										'div'    => 'form-row',
										'label'  => __('Hasło poczty SMTP', true).':',
										'class'  => 'form-control',
										'escape' => false
									)
								);
								
								echo $this->Form->input(
									'smtp_address',
									array(
										'type'   => 'text',
										'div'    => 'form-row',
										'label'  => __('Pełen adres', true).':',
										'class'  => 'form-control',
										'escape' => false
									)
								);
							?>
						</div>
					<?php endif ?>
					
					<?php if ($require_password): ?>
						<hr>
						
						<?php
							echo $this->Form->input(
								'passwd',
								array(
									'type'         => 'password',
									'div'          => 'form-row form-block',
									'placeholder'  => __('Nowe hasło', true),
									'label'        => false,
									'class'        => 'form-control',
									'escape'       => false
								)
							);
							
							echo $this->Form->input(
								'passwd_2',
								array(
									'type'          => 'password',
									'data-validate' => 'validate(match-value(#UserPasswd))',
									'div'           => 'form-row form-block',
									'placeholder'   => __('Powtórz hasło', true),
									'label'         => false,
									'class'         => 'form-control',
									'escape'        => false
								)
							);
						?>
						
						<span class="form-info">
							<?php __('Pozostaw pole puste, aby pozostawić dotychczasowe hasło.') ?>
						</span>
					<?php endif ?>
					
					<?php if ($require_password): ?>
						<hr>
						
						<?php
							echo $this->Form->input(
								'current_passwd',
								array(
									'type'          => 'password',
									'data-validate' => 'validate(required)',
									'div'           => 'form-row form-block',
									'placeholder'   => __('Aktualne hasło', true),
									'label'         => false,
									'class'         => 'form-control',
									'value'         => '',
									'escape'        => false
								)
							)
						?>
						
						<span class="form-info">
							<?php __('Wprowadź aktualne hasło aby autoryzować zmiany') ?>
						</span>
					<?php endif ?>
					
					<span class="form-info required-info">
						<?php __('Pola oznaczone (*) są wymagane') ?>
					</span>
					
					<div class="form-actions">
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
					</div>
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