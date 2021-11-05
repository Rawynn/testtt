<p data-type="scroll-login-page">
	<?php __('Zaloguj się') ?>
</p>

<?php
	echo $this->Form->create(
		'User',
		array(
			'url'          => getUserLoginUrl(),
			'class'        => 'form-login form',
			'data-submit'  => 'once',
			'id'           => 'UserLoginForm'
		)
	)
?>
	<div class="form-inner form-inner-wider">
		<?php
			echo $this->Form->hidden(
				'redirect',
				array(
					'value' => !empty($this->data['User']['redirect']) ? $this->data['User']['redirect'] : getPageParamValue('from')
				)
			);
			
			echo $this->Form->input(
				'email',
				array(
					'type'        => 'email',
					'div'         => 'form-row form-block',
					'placeholder' => __('E-mail', true),
					'label'       => false,
					'class'       => 'form-control'
				)
			);
			
			echo $this->Form->input(
				'password',
				array(
					'type'        => 'password',
					'div'         => 'form-row form-block',
					'placeholder' => __('Hasło', true),
					'label'       => false,
					'class'       => 'form-control'
				)
			);
			
			echo $this->Form->input(
				'remember_me',
				array(
					'type'  => 'checkbox',
					'div'   => 'form-row checkbox',
					'label' => __('Zapamiętaj mnie na tym komputerze', true)
				)
			);
		?>
		
		<div class="form-actions">
			<input class="btn btn-grey btn-block" type="submit" value="<?php echo h(__('Zaloguj się', true)) ?>">
			
			<?php
				echo $this->Html->link(
					__('Zarejestruj się', true),
					getUserRegisterUrl(),
					array(
						'class' => 'register-link visible-below-768'
					)
				)
			?>
		</div>
	</div>
<?php echo $this->Form->end() ?>

<?php if (module('GOOGLE') || (setting('GLOBAL_ALLOW_FB_LOGIN') && setting('GLOBAL_FACEBOOK_APP_ID')) || setting('MODULE_PAYPAL_LOGIN_CLIENT_ID') && setting('MODULE_PAYPAL_LOGIN_SECRET')): ?>
	<div class="form-inner form-inner-wider">
		<div class="social-login">
			<p>
				<?php __('Zaloguj się za pomocą') ?>:
			</p>
			
			<?php if (setting('GLOBAL_ALLOW_FB_LOGIN') && setting('GLOBAL_FACEBOOK_APP_ID')): ?>
				<a class="facebook-login btn btn-block" data-type="facebook-login" href="#" title="<?php echo h(__('Zaloguj się za pomocą konta Facebook', true)) ?>">
					<?php __('Facebook') ?>
				</a>
			<?php endif ?>
			
			<?php if (module('GOOGLE')): ?>
				<a class="google-login btn btn-block" href="<?php echo 'https://accounts.google.com/o/oauth2/auth?scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile&redirect_uri='.$this->Html->url(getUserGoogleLoginUrl(), true).'&response_type=code&client_id='.setting('MODULE_GOOGLE_CLIENT_ID').'&state=/profile&approval_prompt=force' ?>" title="<?php echo h(__('Zaloguj się za pomocą konta Google', true)) ?>">
					<?php __('Google') ?>
				</a>
			<?php endif ?>
			
			<?php
				/* Formularz logowania paypal */
				echo $this->element('_default'.DS.'paypal_button')
			?>
		</div>
	</div>
<?php endif ?>

<p>
	<?php __('Nie pamiętasz hasła?') ?>
</p>

<?php
	echo $this->Form->create(
		'User',
		array(
			'url'          => getUserForgotPasswordUrl(),
			'class'        => 'form-password-emind form',
			'data-submit'  => 'once',
			'id'           => 'UserPasswordRemindForm'
		)
	)
?>
	<div class="form-inner form-inner-wider">
		<?php
			echo $this->Form->input(
				'email',
				array(
					'type'        => 'text',
					'div'         => 'form-row form-block',
					'placeholder' => __('E-mail', true),
					'label'       => false,
					'class'       => 'form-control'
				)
			)
		?>
		
		<div class="form-actions">
			<input class="btn btn-block btn-grey" type="submit" value="<?php echo h(__('Przypomnij hasło', true)) ?>">
		</div>
	</div>
<?php echo $this->Form->end() ?>
