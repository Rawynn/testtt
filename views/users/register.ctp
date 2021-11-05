<div class="user-register-page user-page page">
	<div class="page-header">
		<h1>
			<?php __('Rejestracja') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if (getPageParamValue('register') == 'success'): ?>
				<?php if (setting('MODULE_B2B_USERS_SELF_REGISTERING') && setting('MODULE_B2B_USERS_SELF_REGISTERING_ADMIN_ACTIVATION')): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => __('Dziękujemy za rejestrację. Twoje konto będzie aktywne po akceptacji ze strony Administratora.', true),
								'no_close' => true
							)
						)
					?>
				<?php elseif (getPageParamValue('active') == 1): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'success',
								'message'  => sprintf(
									__('Dziekujęmy za zarejestrowanie się w sklepie. Skorzystaj z formularza %s aby zalogować się na swoje konto.', true), $this->Html->link(__('logowania', true), getUserLoginUrl())
								),
								'no_close' => true
							)
						)
					?>
				<?php else: ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'    => 'info',
								'message'  => __('Na podany adres e-mail został wysłany link aktywacyjny.', true),
								'no_close' => true
							)
						)
					?>
				<?php endif ?>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'info',
							'message' => __('Założenie konta w naszym serwisie zajmie Ci', true).' '.$this->Html->tag('strong', __('1 minutę!', true)).'<br>'.__('Jako zarejestrowany klient kupujesz szybciej, przeglądasz swoje zamówienia i wiele więcej.', true)
						)
					)
				?>
				
				<?php
					echo $this->Form->create(
						'User',
						array(
							'url'           => getUserRegisterUrl($user_code),
							'class'         => 'form address-form',
							'data-validate' => 'true',
							'data-submit'   => 'once'
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
									'class'         => 'form-control'
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
									'class'         => 'form-control'
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
										'class'         => 'form-control'
									)
								);
							endif;
							
							echo $this->Form->input(
								'email',
								array(
									'type'          => 'email',
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
									'type'          => 'email',
									'data-validate' => 'validate(email, match-value(#UserEmail))',
									'div'           => 'form-row form-block',
									'placeholder'   => __('Powtórz e-mail', true),
									'label'         => false,
									'class'         => 'form-control'
								)
							);
							
							if ($password_required):
								echo $this->Form->input(
									'passwd',
									array(
										'type'          => 'password',
										'data-validate' => 'validate(required, minlength('.$min_password_length.'))',
										'div'           => 'form-row form-block',
										'placeholder'   => __('Hasło', true),
										'label'         => false,
										'class'         => 'form-control'
									)
								);
								
								echo $this->Form->input(
									'passwd_2',
									array(
										'type'          => 'password',
										'data-validate' => 'validate(required, match-value(#UserPasswd))',
										'div'           => 'form-row form-block',
										'placeholder'   => __('Powtórz hasło', true),
										'label'         => false,
										'class'         => 'form-control'
									)
								);
							endif;
						?>
						
						<?php if (module('B2B') || getPageParamValue('from') == 'cart'): ?>
							<hr>
							
							<?php
								echo $this->element(
									TEMPLATE_NAME.DS.'address_form',
									array(
										'prefix'           => 'UserAddress',
										'address_required' => true,
										'name_validate'    => empty($this->data['UserAddress']['company']) ? 'validate(required)' : '',
										'company_validate' => empty($this->data['UserAddress']['company']) ? '' : 'validate(required)',
										'add_vat_checkbox' => false,
										'add_invoice'      => true,
										'invoice_type'     => getInvoiceType(),
										'show_user_type'   => true
									)
								)
							?>
							
							<hr>
						<?php endif ?>
						
						<?php if (setting('GLOBAL_REGISTER_CONDITIONS_CONFIRMATION_REQUIRED')): ?>
							<?php
								echo $this->Form->input(
									'regulamin',
									array(
										'type'          => 'checkbox',
										'data-validate' => 'validate(required)',
										'div'           => 'form-row checkbox',
										'label'         => sprintf(
											__('Przeczytałem/am i akceptuję %s.', true),
											$this->Html->link(
												sprintf(
													__('Regulamin %s', true),
													setting('GLOBAL_STORE_NAME')
												),
												getStaticPageUrl(getStaticPageConditionsId()),
												array(
													'target' => '_blank'
												)
											)
										)
									)
								)
							?>
						<?php endif ?>
						
						<?php if (setting('GLOBAL_REGISTER_PROCESSING_USER_DATA_CONFIRMATION_REQUIRED')): ?>
							<?php
								echo $this->Form->input(
									'personal_data',
									array(
										'type'          => 'checkbox',
										'data-validate' => 'validate(required)',
										'div'           => 'form-row checkbox',
										'label' => sprintf(
											__('Wyrażam zgodę na przetwarzanie moich danych osobowych w celu rejestracji konta i realizacji zamówienia przez sklep internetowy %s prowadzony przez %s z siedzibą w: %s, która jest administratorem danych osobowych. Zgodnie z Ustawą z dnia 29.08.1997 r. każdy Klient ma prawo wglądu do swoich danych, ich poprawiania, zarządzania, zaprzestania przetwarzania oraz zażądania ich usunięcia. Podanie danych jest dobrowolne, ale brak zgody uniemożliwia założenie konta i realizację zamówienia.', true),
											setting('GLOBAL_STORE_NAME'),
											setting('GLOBAL_STORE_COMPANY'),
											setting('GLOBAL_STORE_POSTCODE').' '.setting('GLOBAL_STORE_CITY').', '.setting('GLOBAL_STORE_STREET')
										)
									)
								)
							?>
						<?php endif ?>
						
						<?php if (setting('MODULE_PARTNERSHIP_ALLOW_SELF_REGISTERING')): ?>
							<?php
								echo $this->Form->input(
									'partner',
									array(
										'type'  => 'checkbox',
										'div'   => 'form-row checkbox',
										'label' => __('Zarejestruj jako partnera', true)
									)
								)
							?>
						<?php endif ?>
						
						<?php if (setting('MODULE_LOYALTY_USER_ACCESS_TYPE') == 'on_demand'): ?>
							<?php
								echo $this->Form->input(
									'loyalty',
									array(
										'type'  => 'checkbox',
										'div'   => 'form-row checkbox',
										'label' => __('Chcę dołączyć do programu lojalnościowego', true)
									)
								)
							?>
						<?php endif ?>
						
						<?php if (module('DROPSHIPPING')): ?>
							<?php
								echo $this->Form->input(
									'dropshipping',
									array(
										'type'  => 'checkbox',
										'div'   => 'form-row checkbox',
										'label' => __('Jestem zainteresowany ofertą dropshippingu', true)
									)
								)
							?>
						<?php endif?>
						
						<?php if (module('NEWSLETTER') && !setting('MODULE_NEWSLETTER_AUTO_SUBSCRIBE_ON_REGISTER')): ?>
							<?php if (count($newsletter_groups) <= 1): ?>
								<?php
									echo $this->Form->input(
										'newsletter',
										array(
											'type'  => 'checkbox',
											'div'   => 'form-row checkbox',
											'label' => sprintf(__('Chcę otrzymywać informacje na temat promocji, nowości i wydarzeń sklepu %s', true), setting('GLOBAL_STORE_NAME'))
										)
									)
								?>
							<?php else: ?>
								<div class="form-row">
									<strong>
										<?php __('Chcę dopisać się do listy subskrybentów newslettera') ?>:
									</strong>
								</div>
								
								<?php
									echo $this->Form->input(
										'NewsletterGroup.NewsletterGroup',
										array(
											'type'     => 'select',
											'multiple' => 'checkbox',
											'div'      => 'form-row checkbox-group',
											'label'    => false,
											'options'  => getNewsletterGroupsList(1, 0),
											'default'  => getSuggestedNewsletterGroupsList()
										)
									)
								?>
							<?php endif ?>
						<?php endif ?>
						
						<?php if (setting('MODULE_USERS_AND_ORDERS_REGISTER_CAPTCHA')):?>
							<div class="form-row">
								<div class="captcha">
									<div class="g-recaptcha" id="recaptcha-users-register"></div>
								</div>
							</div>
						<?php endif ?>
						
						<span class="form-info required-info">
							<?php __('Pola oznaczone (*) są wymagane') ?>
						</span>
						
						<div class="form-actions align-input">
							<input class="btn-block btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Załóż konto', true)) ?>">
						</div>
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<h2>
				<?php __('Masz już konto?') ?>
			</h2>
			
			<a class="btn btn-lg btn-primary btn-block" href="<?php echo $this->Html->url(getUserLoginUrl()) ?>" title="<?php echo h(__('Zaloguj się', true)) ?>">
				<?php __('Zaloguj się') ?>
			</a>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>
