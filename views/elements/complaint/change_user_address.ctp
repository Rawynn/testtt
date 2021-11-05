<?php if (!$complaint['Complaint']['tracking_number']): ?>
	<div class="modal fade" id="ComplaintChangeAddress" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Zmień adres zwrotny') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'Complaint',
							array(
								'url'           => getComplaintShowUrl($complaint['Complaint']['id']),
								'class'         => 'address-form form',
								'data-submit'   => 'once',
								'escapeInputs'  => false,
								'id'            => 'ComplaintChangeAddressForm'
							)
						)
					?>
						<?php if ($user_address_warning): ?>
							<p class="message notice">
								<?php __('UWAGA: adres zostanie zmieniony we wszystkich zgłoszeniach, dla których została utworzona wspólna paczka.') ?>
							</p>
						<?php endif ?>
						
						<?php echo $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'user_address') ?>
					<?php echo $this->Form->end() ?>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Anuluj') ?>
					</a>
					
					<a class="btn-next btn btn-primary btn-lg" href="#" data-type="complaint-change-address-submit">
						<?php __('Zmień') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>