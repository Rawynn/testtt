<?php if ($attributes): ?>
	<div class="modal fade" id="AddAtributesToCart" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><?php __('zamknij') ?></button>
					
					<h2>
						<?php __('Dołącz atrybuty') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'       => getUserCartSetAttributesUrl(),
								'class'     => 'form',
								'id'        => 'UserCartSetAttributesForm'
							)
						)
					?>
						<div class="form-inner">
							<div class="cart-attribues-check-all">
								<span data-type="cart-attributes-check-uncheck-all" class="clickable">
									<i class="fa fa-check-square-o"></i> <?php __('Zaznacz / odznacz wszystkie') ?>
								</span>
							</div>
							
							<div class="form-row checkbox-group" data-type="cart-attributes">
								<?php
									echo $this->Form->input(
										'Attribute.id',
										array(
											'type'     => 'select',
											'multiple' => 'checkbox',
											'div'      => false,
											'label'    => false,
											'options'  => $attributes,
											'value'    => $selected_attributes
										)
									)
								?>
							</div>
						</div>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>