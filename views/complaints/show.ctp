<div class="order-complaint-page order-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php echo sprintf(__('Szczegóły reklamacji nr %s', true), $complaint['Complaint']['id']) ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-false">
			<table class="table show-details">
				<tbody>
					<tr>
						<td class="label">
							<?php __('Imię i nazwisko') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['username'] ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('E-mail') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['email'] ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Telefon') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['phone'] ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Nr faktury') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Invoice']['id'] ? $complaint['Invoice']['number'] : '-' ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Nr zamówienia') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['order_id'] ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Produkt') ?>:
						</td>
						<td class="value">
							<?php
								echo $complaint['Complaint']['product_name'];
								
								if ($complaint['Complaint']['quantity']):
									echo ' ('.showQuantityValue($complaint['Complaint']['quantity'], $complaint['Complaint']['product_id']).')';
								endif;
							?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Producent') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Producer']['name'] ? $complaint['Producer']['name'] : '-' ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Typ') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['ComplaintType']['name'] ? $complaint['ComplaintType']['name'] : '-' ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Rodzaj') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['kind'] ?>
						</td>
					</tr>
					<tr>
						<td class="label long">
							<?php __('Opis') ?>:
						</td>
						<td class="value">
							<?php echo nl2br($complaint['Complaint']['description']) ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Załączniki') ?>:
						</td>
						<td class="value">
							<?php
								if ($complaint['ComplaintAttachment']):
									echo implode('<br/>', Set::extract($complaint['ComplaintAttachment'], '{n}.filename'));
								else:
									echo '-';
								endif;
							?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Nr własny') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['own_number'] ? $complaint['Complaint']['own_number'] : '-' ?>
						</td>
					</tr>
					
					<?php foreach ($complaint_fields as $complaint_field): ?>
						<?php if (isset($complaint['Complaint'][$complaint_field['ComplaintField']['key']])): ?>
							<?php
								if ($complaint_field['ComplaintField']['type'] == 'checkbox' && !$complaint['Complaint'][$complaint_field['ComplaintField']['key']]):
									/* Niezaznaczony checkbox - pomijam */
									continue;
								endif;
							?>
							
							<tr>
								<td class="label">
									<?php echo $complaint_field['ComplaintField']['type'] != 'checkbox' ? $complaint_field['ComplaintField']['label'].':' : '' ?>
								</td>
								<td class="value">
									<?php echo $complaint_field['ComplaintField']['type'] != 'checkbox' ? nl2br($complaint['Complaint'][$complaint_field['ComplaintField']['key']]) : $complaint_field['ComplaintField']['label'] ?>
								</td>
							</tr>
						<?php endif ?>
					<?php endforeach ?>
					
					<tr>
						<td class="label">
							<?php __('Adres odbioru') ?>:
							
							<i class="fa fa-info-circle" title="<?php echo h(__('Miejsce, z którego towar zostanie odebrany.', true)) ?>"></i>
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['receive_address'] ? $complaint['Complaint']['receive_address'] : '-' ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Adres doręczenia') ?>:
							
							<i class="fa fa-info-circle" title="<?php echo h(__('Miejsce, do którego towar zostanie odesłany po naprawie / wymianie etc.', true)) ?>"></i>
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['shipping_address'] ? $complaint['Complaint']['shipping_address'] : '-' ?>
							
							<?php if (!$complaint['Complaint']['tracking_number']): ?>
								<a data-toggle="modal" href="#ComplaintChangeAddress" role="button">
									<?php __('-zmień-') ?>
								</a>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<td class="label">
							<?php __('Nr listu przewozowego') ?>:
						</td>
						<td class="value">
							<?php echo $complaint['Complaint']['tracking_number'] ? $complaint['Complaint']['tracking_number'] : '-' ?>
						</td>
					</tr>
					
					<?php if ($complaint_costs): ?>
						<tr>
							<td class="label long">
								<?php __('Koszty') ?>:
							</td>
							<td>
								<table class="table table-striped table-responsive">
									<thead>
										<tr>
											<th>
												<?php __('Wartość') ?>
											</th>
											<th>
												<?php __('Płatnik') ?>
											</th>
											<th>
												<?php __('Komentarz') ?>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($complaint_costs as $complaint_cost): ?>
											<tr>
												<td>
													<?php echo showPrice($complaint_cost['ComplaintCost']['value'], true, getDefaultCurrency('code')) ?>
												</td>
												<td>
													<?php echo $complaint_cost_payers[$complaint_cost['ComplaintCost']['payer']] ?>
												</td>
												<td>
													<?php echo $complaint_cost['ComplaintCost']['comments'] ? nl2br($complaint_cost['ComplaintCost']['comments']) : '-' ?>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
									<thead>
										<tr>
											<th colspan="3">
												<?php __('Koszt dla klienta') ?>: <?php echo showPrice($buyer_cost, true, getDefaultCurrency('code')) ?>
											</th>
										</tr>
										<tr>
											<th colspan="3">
												<?php __('Koszt sprzedawcy') ?>: <?php echo showPrice($seller_cost, true, getDefaultCurrency('code')) ?>
											</th>
										</tr>
									</thead>
								</table>
							</td>
						</tr>
					<?php endif ?>
					
					<?php if ($history): ?>
						<tr>
							<td class="label long">
								<?php __('Historia') ?>:
							</td>
							<td>
								<table class="table table-striped table-responsive">
									<thead>
										<tr>
											<th>
												<?php __('Data') ?>
											</th>
											<th>
												<?php __('Status') ?>
											</th>
											<th>
												<?php __('Komentarz') ?>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($history as $item): ?>
											<tr>
												<td>
													<?php echo showDateTime($item['ComplaintStatusHistory']['created']) ?>
												</td>
												<td>
													<?php echo $complaint_statuses[$item['ComplaintStatusHistory']['complaint_status_id']] ?>
												</td>
												<td>
													<?php echo $item['ComplaintStatusHistory']['comments'] ? nl2br($item['ComplaintStatusHistory']['comments']) : '-' ?>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
			
			<div class="form-actions">
				<a class="btn-back btn btn-lg" href="javascript: history.back()" title="<?php echo h(__('Powrót', true)) ?>">
					<?php __('Powrót') ?>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
	/* Formularz zmiany adresu zwrotnego */
	echo $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'change_user_address')
?>