<div class="modal fade" id="SetProductPosition" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Ustaw pozycję produktu') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getUserCartSetProductPositionUrl(),
							'class'       => 'form',
							'data-submit' => 'once',
							'id'          => 'UserCartSetProductPositionForm'
						)
					)
				?>
					<?php
						echo $this->Form->hidden(
							'key',
							array(
								'data-type' => 'set-product-position-product-key',
								'id'        => 'UserCartKeySetProductPosition'
							)
						);
						
						echo $this->Form->input(
							'position',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Pozycja', true).':',
								'class'   => 'form-control',
								'default' => 1,
								'id'      => 'UserCartPositionSetProductPosition'
							)
						)
					?>
					
					<div class="form-actions">
						<input class="btn-next btn btn-lg" type="submit" value="<?php echo h(__('Ustaw pozycję', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>