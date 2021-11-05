<?php $is_selected = !empty($this->data['User']['set_password']) && $this->data['User']['set_password'] ?>

<?php
	echo $this->Form->input(
		'User.set_password',
		array(
			'type'      => 'checkbox',
			'data-type' => 'toggle-register-user',
			'div'       => 'form-row checkbox',
			'label'     => __('Chcę założyć konto w sklepie', true).' '.setting('GLOBAL_STORE_NAME')
		)
	)
?>

<div class="<?php echo !$is_selected ? 'hide' : '' ?>" data-type="register-user" id="UserCartUnloggedNewUser">
	<?php
		echo $this->Form->input(
			'NewUser.passwd',
			array(
				'type'                  => 'password',
				'data-validate'         => $is_selected ? 'validate(required, minlength('.$min_password_length.'))' : '',
				'data-validate-pattern' => 'validate(required, minlength('.$min_password_length.'))',
				'div'                   => 'form-row form-block',
				'placeholder'           => __('Hasło', true),
				'label'                 => false,
				'class'                 => 'form-control',
				'escape'                => false
			)
		);
		
		echo $this->Form->input(
			'NewUser.passwd_2',
			array(
				'type'                  => 'password',
				'data-validate'         => $is_selected ? 'validate(required, match-value(#NewUserPasswd))' : '',
				'data-validate-pattern' => 'validate(required, match-value(#NewUserPasswd))',
				'div'                   => 'form-row form-block',
				'placeholder'           => __('Powtórz hasło', true),
				'label'                 => false,
				'class'                 => 'form-control',
				'escape'                => false
			)
		);
	?>
</div>

<?php if (setting('MODULE_LOYALTY_USER_ACCESS_TYPE') == 'on_demand'): ?>
	<div class="<?php echo !$is_selected ? 'hide' : '' ?>" data-type="loyalty-user">
		<?php
			echo $this->Form->input(
				'User.loyalty',
				array(
					'type'      => 'checkbox',
					'data-type' => 'toggle-loyalty-user',
					'div'       => 'form-row checkbox',
					'label'     => __('Chcę dołączyć do programu lojalnościowego', true),
					'disabled'  => !$is_selected
				)
			)
		?>
	</div>
<?php endif ?>