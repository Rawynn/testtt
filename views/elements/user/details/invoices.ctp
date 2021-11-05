<?php if ($invoices): ?>
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>
					<?php __('Numer') ?>
				</th>
				<th>
					<?php __('Id zamówienia') ?>
				</th>
				<th>
					<?php __('Data wystawienia') ?>
				</th>
				<th>
					<?php __('Data sprzedaży') ?>
				</th>
				<th>
					<?php __('Termin płatności') ?>
				</th>
				<th>
					<?php __('Do zapłaty') ?>
				</th>
				<th>
					<?php __('Pozostało') ?>
				</th>
				<th class="table-options">
					<?php __('Opcje') ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($invoices as $invoice): ?>
				<tr>
					<td>
						<span class="table-responsive-label">
							<?php __('Numer') ?>:
						</span>
						
						<strong>
							<?php echo $invoice['Invoice']['number'] ?>
						</strong>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Id zamówienia') ?>:
						</span>
						
						<?php echo getOrderFullId($invoice['Invoice']['order_id'], true) ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Data wystawienia') ?>:
						</span>
						
						<?php echo showDate($invoice['Invoice']['date_created']) ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Data sprzedaży') ?>:
						</span>
						
						<?php echo showDate($invoice['Invoice']['date_sale']) ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Termin płatności') ?>:
						</span>
						
						<?php echo showDate($invoice['Invoice']['date_payment']) ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Do zapłaty') ?>:
						</span>
						
						<?php echo showOrderPrice($invoice['Invoice']['to_pay'], $invoice['Invoice']['order_id']) ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Pozostało') ?>:
						</span>
						
						<?php echo showOrderPrice($invoice['Invoice']['paid'] > $invoice['Invoice']['to_pay'] ? 0 : $invoice['Invoice']['to_pay'] - $invoice['Invoice']['paid'], $invoice['Invoice']['order_id']) ?>
					</td>
					<td class="table-options">
						<a href="<?php echo $this->Html->url(getInvoiceDownloadUrl($invoice['Invoice']['id'])) ?>" title="<?php echo h(__('Pobierz plik PDF', true)) ?>" target="_blank">
							<i class="fa fa-download"></i>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<div class="user-details-view-options">
		<div class="options-container form form-inline">
			<a class="btn btn-primary btn-lg pull-right" href="<?php echo $this->Html->url(getInvoicesUrl(array('user_id' => $id))) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
				<?php __('Pokaż wszystkie') ?>
			</a>
		</div>
	</div>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => __('Nie znaleziono żadnych faktur tego klienta.', true)
			)
		)
	?>
<?php endif ?>