<?php if (module('B2B') && !getCartUserCartOfferId()): ?>
	<div class="import-cart">
		<a data-toggle="modal" href="#CartImport" data-tooltip-set="true" role="button" title="<?php echo h(__('Importuj koszyk z CSV', true)) ?>">
			<i class="fa fa-download" aria-hidden="true"></i>
		</a>
		
		<div class="modal fade" id="CartImport" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						
						<h2>
							<?php __('Importuj koszyk z CSV') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->create(
								'UserCart',
								array(
									'url'         => getUserCartImportCsvUrl(),
									'type'        => 'file',
									'class'       => 'form',
									'data-submit' => 'once',
									'id'          => 'UserCartImportCsvForm'
								)
							)
						?>
							<?php
								echo $this->Form->input(
									'code_column',
									array(
										'type'    => 'text',
										'div'     => 'form-row',
										'label'   => __('Kolumna produktów', true).':',
										'class'   => 'form-control',
										'default' => 1
									)
								);
								
								echo $this->Form->input(
									'quantity_column',
									array(
										'type'    => 'text',
										'div'     => 'form-row',
										'label'   => __('Kolumna ilości', true).':',
										'class'   => 'form-control',
										'default' => 2
									)
								);
								
								echo $this->Form->input(
									'file',
									array(
										'type'  => 'file',
										'div'   => 'form-row',
										'label' => __('Wgraj plik', true).':',
										'class' => 'form-control'
									)
								);
							?>
							
							<div class="form-actions">
								<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
							</div>
						<?php echo $this->Form->end() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>