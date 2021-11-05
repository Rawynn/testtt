<?php if (userIsSalesrep() && $edit_offer_mode): ?>
	<div class="modal fade" id="SortProducts" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Sortuj produkty') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'       => getUserCartSortProductsUrl(),
								'class'     => 'form',
								'id'        => 'UserCartSortProductsForm'
							)
						)
					?>
						<?php
							echo $this->Form->input(
								'UserCart.sort_products',
								array(
									'div'      => 'form-row',
									'class'    => 'form-control',
									'type'     => 'select',
									'label'    => __('Sortuj wg', true).': ',
									'options'  => getUserCartSortProductsOptions()
								)
							)
						?>
						
						<div class="form-actions">
							<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
								<?php __('Anuluj') ?>
							</a>
							
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz')) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>