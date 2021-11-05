<div class="col-md-8 col-md-offset-2">
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
					'div'           => 'form-row',
					'label'         => __('Twoje imię', true),
					'class'         => 'form-control',
					'default'       => getUserUsername()
				)
			);
			
			echo $this->Form->input(
				'email',
				array(
					'type'          => 'text',
					'data-validate' => 'validate(email)',
					'div'           => 'form-row',
					'label'         => __('Twój e-mail', true),
					'class'         => 'form-control',
					'default'       => getUserEmail()
				)
			);
			
			echo $this->Form->input(
				'friend_email',
				array(
					'type'          => 'text',
					'data-validate' => 'validate(email)',
					'div'           => 'form-row',
					'label'         => __('Adres e-mail', true),
					'class'         => 'form-control'
				)
			);
		?>
		
		<?php if (setting('MODULE_RECOMMEND_CAPTCHA') && !getLoggedUserId()): ?>
			<div class="captcha">
				<div class="g-recaptcha" id="recaptcha-recommend-product"></div>
			</div>
		<?php endif ?>
		
		<div class="form-actions align-input">
			<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
		</div>
	<?php echo $this->Form->end() ?>
</div>
</div>