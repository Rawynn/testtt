<div data-type="complaint-add-products">
	<?php if (!empty($products)): ?>
		<div class="form-row field-radio">
			<label>
				<?php __('Wybierz produkt') ?>:
			</label>
			
			<div class="input-group">
				<?php
					echo $this->Form->hidden(
						'new_product_id',
						array(
							'data-type' => 'complatins-new-product-autocomplete-id'
						)
					);
					
					$products[-1] = __('inny', true);
				?>
				
				<?php foreach ($products as $product_id => $product_name): ?>
					<div class="radio">
						<?php
							echo $this->Form->input(
								'Complaint.product_id',
								array(
									'type'                       => 'radio',
									'div'                        => false,
									'legend'                     => false,
									'data-type'                  => 'complaint-product-radio',
									'data-product-producer-id'   => $product_producers[$product_id]['id'],
									'data-product-producer-name' => $product_producers[$product_id]['name'],
									'options'                    => array(
										$product_id => $product_name
									)
								)
							)
						?>
						
						<?php if ($product_id == -1): ?>
							<div class="explication hide" data-type="complaint-product-autocompleter-toggle">
								<?php
									echo $this->Form->input(
										'Complaint.product_name',
										array(
											'type'                      => 'text',
											'div'                       => false,
											'label'                     => false,
											'class'                     => 'form-control',
											'disabled'                  => 'disabled',
											'data-type'                 => 'autocomplete',
											'data-ac'                   => 'true',
											'data-ac-url'               => $this->Html->url(getComplaintProductsAutocompleterUrl()),
											'data-ac-handler'           => '[data-type=complaint-product-autocompleter-toggle]',
											'data-ac-extended'          => 'false',
											'data-ac-copy'              => '[data-type=complatins-new-product-autocomplete-id]',
											'data-trigger-autocomplete' => 'select-product'
										)
									)
								?>
							</div>
						<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	<?php else: ?>
		<div class="form-row">
			<?php
				echo $this->Form->hidden(
					'Complaint.product_id',
					array(
						'data-type' => 'complatins-new-product-autocomplete-id'
					)
				)
			?>
			
			<label>
				<?php __('Produkt') ?>:
			</label>
			
			<div class="input-group" data-type="complaint-product-autocompleter-toggle">
				<?php
					echo $this->Form->input(
						'Complaint.product_name',
						array(
							'type'                      => 'text',
							'div'                       => false,
							'label'                     => false,
							'class'                     => 'form-control',
							'escape'                    => false,
							'data-type'                 => 'autocomplete',
							'data-ac'                   => 'true',
							'data-ac-url'               => $this->Html->url(getComplaintProductsAutocompleterUrl()),
							'data-ac-handler'           => '[data-type=complaint-product-autocompleter-toggle]',
							'data-ac-extended'          => 'false',
							'data-ac-copy'              => '[data-type=complatins-new-product-autocomplete-id]',
							'data-trigger-autocomplete' => 'select-product'
						)
					)
				?>
			</div>
		</div>
	<?php endif ?>
</div>