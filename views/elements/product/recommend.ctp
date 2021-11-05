<div class="col-md-6 col-md-offset-3">
<div class="product-recommend">
	<h2><?php __('Poleć produkt')?></h2>
	<?php
		echo $this->Form->create(
			'Product',
			array(
				'url'           => Router::url(getProductUrl($product_id), true),
				'class'         => 'form recommend-product-form validate-form',
				'data-validate' => 'true',
				'data-submit'   => 'once',
				'escapeInputs'  => false
			)
		)
	?>
		<?php
			echo $this->Form->hidden(
				'recommend',
				array(
					'value' => 1
				)
			);
			
			echo $this->Form->input(
				'username',
				array(
					'type'          => 'text',
					'data-validate' => 'validate(required)',
					'div'           => 'form-row form-block',
					'placeholder'   => __('Twoje imię', true),
					'label'         => false,
					'class'         => 'form-control',
					'default'       => getUserUsername()
				)
			);
			
			echo $this->Form->input(
				'email',
				array(
					'type'          => 'email',
					'data-validate' => 'validate(email)',
					'div'           => 'form-row form-block',
					'placeholder'   => __('Twój e-mail', true),
					'label'         => false,
					'class'         => 'form-control',
					'default'       => getUserEmail()
				)
			);
			
			echo $this->Form->input(
				'friend_email',
				array(
					'type'          => 'email',
					'data-validate' => 'validate(email)',
					'div'           => 'form-row form-block',
					'placeholder'   => __('Adres e-mail', true),
					'label'         => false,
					'class'         => 'form-control'
				)
			);
		?>
		
		<?php if (setting('MODULE_RECOMMEND_CAPTCHA') && !getLoggedUserId()): ?>
			<div class="captcha">
				<div class="g-recaptcha" id="recaptcha-recommend-product"></div>
			</div>
		<?php endif ?>
		
		<div class="form-actions">
			<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
		</div>
	<?php echo $this->Form->end() ?>
</div>
</div>
