<?php if ($partner_payments): ?>
	<table class="table table-striped table-responsive">
		<colgroup>
			<col width="30%">
			<col width="50%">
			<col width="20%">
		</colgroup>
		<thead>
			<tr>
				<th>
					<?php __('Data') ?>
				</th>
				<th>
					<?php __('Zdarzenie') ?>
				</th>
				<th>
					<?php __('Kwota') ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $sum = 0 ?>
			
			<?php foreach ($partner_payments as $payment): ?>
				<tr id="PartnerPaymentItem<?php echo $payment['PartnerPayment']['id'] ?>">
					<td>
						<span class="table-responsive-label">
							<?php __('Data') ?>:
						</span>
						<?php echo showDateTime($payment['PartnerPayment']['created']) ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Zdarzenie') ?>:
						</span>
						
						<?php
							if ($payment['PartnerPayment']['action'] == 'ACTION_CLICK'):
								__('Wejście');
							elseif ($payment['PartnerPayment']['action'] == 'ACTION_PURCHASE'):
								echo sprintf(
									__('Złożenie zamówienia nr %s', true),
									$payment['PartnerPayment']['foreign_key']
								);
							elseif ($payment['PartnerPayment']['action'] == 'PURCHASE_COMMISSION'):
								echo sprintf(
									__('Prowizja od zamówienia nr %s', true),
									$payment['PartnerPayment']['foreign_key']
								);
							elseif ($payment['PartnerPayment']['action'] == 'ADMIN_EDIT'):
								__('Zmiana stanu należności');
							elseif ($payment['PartnerPayment']['action'] == 'ADMIN_PAYOFF'):
								__('Spłata należności');
							endif;
						?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Kwota') ?>:
						</span>
						
						<?php
							echo showPrice($payment['PartnerPayment']['value']);
							$sum += $payment['PartnerPayment']['value'];
						?>
					</td>
				</tr>
			<?php endforeach ?>
			
			<tr>
				<td colspan="2" class="text-right">
					<strong class="hidden-xs">
						<?php __('RAZEM')?>:
					</strong>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Razem') ?>:
					</span>
					
					<strong>
						<?php echo showPrice($sum) ?>
					</strong>
				</td>
			</tr>
		</tbody>
	</table>
<?php else:?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => __('Nie znaleziono żadnych transakcji w podanym okresie czasowym', true)
			)
		)
	?>
<?php endif;?>