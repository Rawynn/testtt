<div class="unavailable-variants-modal modal fade" id="UnavailableVariants" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

				<h2>
					<?php __('Powiadom o dostępności') ?>
				</h2>
			</div>
			
			<?php $not_available_variants = getNotAvailableProductCombinations($product['Product']['id']) ?>
			
			<?php if (!($not_available_variants == null)): ?>
				<?php
					echo $this->Form->create(
						'AvailibilityNotification',
						array(
							'onsubmit' => 'return ValidateFormTabSize(this)',
							'url' => array(
								'action' => 'add',
								$product['Product']['id'],
								'language' => Configure::read('Config.language')
							),
							'class' => 'form'
						)
					)
				?>
					<?php echo $this->Form->hidden('product_id', array('value' => $product['Product']['id'])) ?>
					
					<div class="modal-body">
						<p>
							<?php __('Produkt') ?>: <strong><?php echo $product['Product']['name'] ?></strong>
						</p>
						
						<?php
							echo $this->Form->input(
									'combination_id', array(
									'div'		 => 'form-row',
									'label'		 => __('Wybierz wariant', true).':',
									'type'		 => 'select',
									'options'	 => $not_available_variants,
									'class'      => 'form-control',
									'empty'		 => __('Wybierz', true)
								)
							)
						?>
	
						<?php $_val_email = (isset($_SESSION['Auth']['User']['email']) ? $_SESSION['Auth']['User']['email'] : '') ?>
						
						<?php
							echo $this->Form->input(
								'email', array(
								'div'	 => 'form-row',
								'label'	 => __('Podaj adres e-mail', true).':',
								'class'  => 'form-control',
								'value'	 => $_val_email
								)
							)
						?>
					</div>
			
					<div class="modal-footer modal-actions">
						<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Anuluj') ?>
						</a>
						
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
		</div>
	</div>
</div>