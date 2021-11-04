<?php
	$opinions  = getProductOpinions($product_id);
	$show_form = true;
	$msg       = '';
	
	if (setting('MODULE_OPINIONS_ONLY_LOGGED') && !getLoggedUserId()):
		$show_form = false;
		$msg       = sprintf(__('Jesteś niezalogowany. Tylko osoby zalogowane mogą dodawać opinie o produkcie. %s aby się zalogować.', true), $this->Html->link( __('Kliknij', true), getUserLoginUrl()));
	endif;
	
	if (setting('MODULE_OPINIONS_ONLY_BUYERS') && !checkUserPurchasedProduct(getLoggedUserId(), $product_id)):
		$show_form = false;
		$msg       = __('Tylko osoby które kupiły dany produkt mogą dodawać opinie.', true);
	endif;
?>

<div class="product-opinions">
	<?php if ($opinions): ?>
		<div data-type="opinion-list-container">
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'opinion_list',
					array(
						'opinions'     => $opinions,
						'product_list' => true
					)
				)
			?>
		</div>
	<?php endif ?>
	
	<?php if ($show_form): ?>
		<h2>
			<?php __('Dodaj opinię') ?>
		</h2>
		
		<?php
			echo $this->Form->create(
				'Product',
				array(
					'url' => Set::merge(
						getProductUrl($product_id),
						array(
							'#' => '!#opinie'
						)
					),
					'class'         => 'opinion-form form',
					'data-validate' => 'true',
					'data-submit'   => 'once'
				)
			)
		?>
			<?php
				echo $this->Form->hidden(
					'action',
					array(
						'value' => 'add_comment'
					)
				);
				
				echo $this->Form->input(
					'ProductOpinion.username',
					array(
						'type'          => 'text',
						'data-validate' => 'validate(required)',
						'div'           => 'form-row',
						'placeholder'   => __('AUTOR', true).':*',
						'label'         => false,
						'class'         => 'form-control',
						'default'       => getUserUsername()
					)
				);
				
				echo $this->Form->input(
					'ProductOpinion.email',
					array(
						'type'          => 'text',
						'data-validate' => 'validate(email)',
						'div'           => 'form-row',
						'label'         => false,
						'placeholder'   => __('E-MAIL', true).':*',
						'class'         => 'form-control',
						'default'       => getUserEmail()
					)
				);
			?>
			
			<div class="form-row required">
				<label>
					<?php __('OCENA') ?>:
				</label>
				
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'opinion_rating',
						array(
							'input' => true,
							'note'  => null
						)
					);
					
					echo $this->Form->hidden(
						'ProductOpinion.note',
						array(
							'data-type'     => 'rating',
							'data-validate' => 'validate(required)'
						)
					);
				?>
			</div>
			
			<?php
				echo $this->Form->input(
					'ProductOpinion.content',
					array(
						'type'          => 'textarea',
						'data-validate' => 'validate(required-textarea)',
						'div'           => 'form-row',
						'label'         => false,
						'placeholder'   => __('TREŚĆ', true).':',
						'class'         => 'form-control long'
					)
				);
				
				echo $this->Form->input(
					'ProductOpinion.benefits',
					array(
						'type'          => 'textarea',
						'div'           => 'form-row',
						'label'         => false,
						'placeholder'   => __('ZALETY', true).':',
						'class'         => 'form-control long'
					)
				);
				
				echo $this->Form->input(
					'ProductOpinion.defects',
					array(
						'type'          => 'textarea',
						'div'           => 'form-row',
						'label'         => false,
						'placeholder'   => __('WADY', true).':',
						'class'         => 'form-control long'
					)
				);
			?>
			
			<?php if (setting('MODULE_OPINIONS_CAPTCHA') && !getLoggedUserId()):?>
				<div class="form-row">
					<label>
						&nbsp;
					</label>
					
					<div class="captcha">
						<div class="g-recaptcha" id="recaptcha-product-opinion"></div>
					</div>
				</div>
			<?php endif ?>
			
			<span class="form-info required-info">
				<?php __('Pola oznaczone (*) są wymagane') ?>
			</span>
			
			<div class="form-actions">
				<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
			</div>
		<?php echo $this->Form->end() ?>
	<?php else: ?>
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'message'.DS.'message',
				array(
					'class'    => 'info',
					'message'  => $msg,
					'no_close' => true
				)
			)
		?>
	<?php endif ?>
</div>