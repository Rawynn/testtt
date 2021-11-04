<div class="modal fade" id="ChangeSalesrepsClient" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Wybierz') ?>
				</h2>
			</div>
			
			<?php
				echo $this->Form->create(
					'Salesrep',
					array(
						'url' => getSalesrepChangeUserUrl(),
						'id'  => 'SalesrepChangeUserFormHeaderTop'
					)
				)
			?>
				<div class="modal-body">
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'data-type' => 'salesrep-user-id-header'
							)
						)
					?>
					
					<?php foreach (array(0 => __('Pozostaw aktualny koszyk', true), 1 => __('Wczytaj bieżący koszyk klienta', true)) as $key => $value): ?>
						<?php
							echo $this->Form->input(
								'type',
								array(
									'type'      => 'radio',
									'options'   => array(
										$key => $value
									),
									'id'        => 'radio_ClientHeader',
									'legend'    => false,
									'checked'   => $key == getSessionValue('Salesrep.type')
								)
							)
						?>
					<?php endforeach ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Anuluj') ?>
					</a>
					
					<input class="btn btn-next btn-lg btn-primary" type="submit" value="<?php echo h(__('Wybierz', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		</div>
	</div>
</div>