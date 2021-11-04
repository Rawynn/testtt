<a class="btn btn-primary btn-lg btn-block" data-toggle="modal" href="#NewCart" role="button" title="<?php echo h(__('Dodaj nowy koszyk', true)) ?>">
	<?php __('Dodaj nowy koszyk') ?>
</a>

<div class="modal fade" id="NewCart" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
				<h2>
					<?php __('Dodaj nowy koszyk') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getUserCartNewCartUrl(),
							'class'       => 'form',
							'data-submit' => 'once',
							'id'          => 'UserCartSaveForm'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'name',
							array(
								'type'    => 'text',
								'div'     => 'form-row',
								'label'   => __('Nazwa koszyka', true).':',
								'class'   => 'form-control'
							)
						)
					?>
					
					<div class="form-actions">
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Dodaj', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>