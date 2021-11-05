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
									'id'        => 'SalesrepChangeUserTypeHeader',
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

<div class="modal fade" data-type="salesrep-search-user-header" tabindex="-1" role="dialog" aria-hidden="true">
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
						'id'  => 'SalesrepChangeUserFormHeaderFindUserTop',
						'class' => 'form'
					)
				)
			?>
				<div class="modal-body">
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'data-type' => 'salesrep-user-id-find-user-header'
							)
						)
					?>
					
					<div class="form-row username-row username-row-autocompleter-on">
						<label for="OrderUsername">
							<?php __('Klient') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'username',
								array(
									'type'             => 'text',
									'data-type'        => 'autocomplete',
									'data-ac'          => 'true',
									'data-ac-url'      => $this->Html->url(getUsersAutocompleterUrl()),
									'data-ac-handler'  => '[data-type=salesreps-find-user-id-container]',
									'data-ac-extended' => 'false',
									'data-ac-copy'     => '[data-type=salesrep-user-id-find-user-header]',
									'data-trigger'     => 'select-user',
									'div'              => array(
										'data-type' => 'salesreps-find-user-id-container',
										'class'     => 'autocompleter-container'
									),
									'label'            => false,
									'class'            => 'form-control',
									'placeholder'      => __('Szukaj', true)
								)
							)
						?>
					</div>
					
					<?php foreach (array(0 => __('Pozostaw aktualny koszyk', true), 1 => __('Wczytaj bieżący koszyk klienta', true)) as $key => $value): ?>
						<?php
							echo $this->Form->input(
								'type',
								array(
									'type'      => 'radio',
									'options'   => array(
										$key => $value
									),
									'id'        => 'SalesrepChangeUserTypeFindUserHeader',
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
					
					<a class="btn btn-lg" href="<?php echo $this->Html->url(getUserAddUrl(array('select' => 1)))?>">
						<?php __('Nowy klient') ?>
					</a>
					
					<input class="btn btn-next btn-lg btn-primary" type="submit" disabled="disabled" data-type="salesrep-user-id-find-user-submit-button" value="<?php echo h(__('Wybierz', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		</div>
	</div>
</div>