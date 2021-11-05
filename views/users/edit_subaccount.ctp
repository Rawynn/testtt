<div class="user-edit-account-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php echo $user ? sprintf(__('Edycja subkonta "%s"', true), $user['User']['username']) : __('Dodaj subkonto', true) ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'User',
					array(
						'url'           => getSubaccountEditUrl($user_id),
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
							'email',
							array(
								'type'          => 'email',
								'data-validate' => 'validate(email)',
								'div'           => 'form-row',
								'label'         => __('E-mail', true).':',
								'class'         => 'form-control'
							)
						);
						
						echo $this->Form->input(
							'first_name',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Imię', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
						
						echo $this->Form->input(
							'last_name',
							array(
								'type'          => 'text',
								'data-validate' => 'validate(required)',
								'div'           => 'form-row',
								'label'         => __('Nazwisko', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
					?>
					
					<hr>
					
					<?php
						echo $this->Form->input(
							'passwd',
							array(
								'type'          => 'password',
								'div'           => 'form-row',
								'data-validate' => !$user ? 'validate(required), minlength('.$min_password_length.')' : '',
								'label'         => ($user ? __('Nowe hasło', true) : __('Hasło', true)).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
						
						echo $this->Form->input(
							'passwd_2',
							array(
								'type'          => 'password',
								'data-validate' => 'validate(match-value(#UserPasswd))',
								'div'           => 'form-row',
								'label'         => __('Powtórz hasło', true).':',
								'class'         => 'form-control',
								'escape'        => false
							)
						);
					?>
					
					<?php if ($user): ?>
						<span class="form-info">
							<?php __('Pozostaw pole puste, aby pozostawić dotychczasowe hasło.') ?>
						</span>
					<?php endif ?>
					
					<hr>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Uprawnienia - zamówienia') ?>:
						</label>
						
						<div class="input-group">
							<?php foreach (array('none' => __('brak dostępu', true), 'view_own' => __('własne (tylko wyświetlanie)', true), 'view_all' => __('wszystkie (tylko wyświetlanie)', true), 'add_and_view_own' => __('własne', true), 'add_and_view_all' => __('wszystkie', true)) as $key => $value): ?>
								<div class="radio">
									<?php
										echo $this->Form->input(
											'UserPermission.orders',
											array(
												'type'      => 'radio',
												'div'       => false,
												'legend'    => false,
												'default'   => 'add_and_view_all',
												'options'   => array(
													$key => $value
												)
											)
										)
									?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Uprawnienia - faktury') ?>:
						</label>
						
						<div class="input-group">
							<?php foreach (array('none' => __('brak dostępu', true), 'view_own' => __('tylko do własnych zamówień', true), 'view_all' => __('wszystkie', true)) as $key => $value): ?>
								<div class="radio">
									<?php
										echo $this->Form->input(
											'UserPermission.invoices',
											array(
												'type'      => 'radio',
												'div'       => false,
												'legend'    => false,
												'default'   => 'view_all',
												'options'   => array(
													$key => $value
												)
											)
										)
									?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Uprawnienia - płatności') ?>:
						</label>
						
						<div class="input-group">
							<?php foreach (array('none' => __('brak dostępu', true), 'view_own' => __('tylko do własnych zamówień', true), 'view_all' => __('wszystkie', true)) as $key => $value): ?>
								<div class="radio">
									<?php
										echo $this->Form->input(
											'UserPermission.payments',
											array(
												'type'      => 'radio',
												'div'       => false,
												'legend'    => false,
												'default'   => 'view_all',
												'options'   => array(
													$key => $value
												)
											)
										)
									?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
					
					<div class="form-row field-radio">
						<label>
							<?php __('Uprawnienia - adresy') ?>:
						</label>
						
						<div class="input-group">
							<?php foreach (array('none' => __('brak dostępu', true), 'view' => __('wyświetlanie', true), 'edit' => __('wyświetlanie i edycja (z wyjątkiem danych do faktury)', true)) as $key => $value): ?>
								<div class="radio">
									<?php
										echo $this->Form->input(
											'UserPermission.addresses',
											array(
												'type'      => 'radio',
												'div'       => false,
												'legend'    => false,
												'default'   => 'none',
												'options'   => array(
													$key => $value
												)
											)
										)
									?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
					
					<?php if (module('COMPLAINTS')): ?>
						<div class="form-row field-radio">
							<label>
								<?php __('Uprawnienia - reklamacje') ?>:
							</label>
							
							<div class="input-group">
								<?php foreach (array('none' => __('brak dostępu', true), 'view_own' => __('własne', true), 'view_all' => __('wszystkie', true)) as $key => $value): ?>
									<div class="radio">
										<?php
											echo $this->Form->input(
												'UserPermission.complaints',
												array(
													'type'      => 'radio',
													'div'       => false,
													'legend'    => false,
													'default'   => 'view_own',
													'options'   => array(
														$key => $value
													)
												)
											)
										?>
									</div>
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>
					
					<span class="form-info required-info">
						<?php __('Pola oznaczone (*) są wymagane') ?>
					</span>
					
					<div class="form-actions align-input">
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
