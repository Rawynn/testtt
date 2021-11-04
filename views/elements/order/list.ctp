<?php $is_salesrep = userIsSalesrep() ?>

<table class="order-list-table table table-striped table-responsive <?php echo $is_salesrep ? 'product-table-salesrep' : '' ?>">
	<thead>
		<tr>
			<th>
				<?php __('Id') ?>
			</th>
			<th>
				<?php __('Data') ?>
			</th>
			
			<?php if ($is_salesrep): ?>
				<th>
					<?php __('Klient') ?>
				</th>
			<?php endif ?>
			
			<?php if (module('B2B')): ?>
				<th>
					<?php __('Faktura') ?>
				</th>
			<?php endif ?>
			
			<th>
				<?php __('Wartość') ?>
			</th>
			
			<?php if (module('B2B')): ?>
				<th>
					<?php __('Zapłacono') ?>
				</th>
			<?php endif ?>
			
			<th>
				<?php __('Forma dostawy') ?>
			</th>
			<th>
				<?php __('Forma płatności') ?>
			</th>
			<th>
				<?php __('Opłacone') ?>
			</th>
			<?php if (setting('MODULE_PKCS_SIGN_ORDER') && $pkcs_certificate): ?>
				<th>
					<?php echo __('Podpis', true).'<br/>'.__('elektroniczny', true) ?>
				</th>
			<?php endif ?>
			
			<th class="table-options">
				<?php echo !$is_salesrep ? __('Opcje', true) : '' ?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($orders as $key => $order): ?>
			<tr>
				<td>
					<span class="table-responsive-label">
						<?php __('Id') ?>:
					</span>
					
					<strong>
						<?php echo getOrderFullId($order['Order']['id'], true) ?>.
					</strong>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Data') ?>:
					</span>
					
					<?php echo showDate($order['Order']['created']) ?>
				</td>
				
				<?php if ($is_salesrep): ?>
					<td>
						<span class="table-responsive-label">
							<?php __('Klient') ?>:
						</span>
						
						<a href="<?php echo $this->Html->url(getUserDetailsUrl($order['Order']['user_id'])) ?>" title="<?php echo h(__('Klient', true)) ?>">
							<?php echo $order['Order']['username'] ?>
						</a>
					</td>
				<?php endif ?>
				
				
				<?php if (module('B2B')): ?>
					<td>
						<span class="table-responsive-label">
							<?php __('Faktura') ?>:
						</span>
						
						<?php echo $order['Invoice'] ? implode('<br/>', Set::extract($order['Invoice'], '{n}.number')) : '-' ?>
					</td>
				<?php endif ?>
				
				<td>
					<span class="table-responsive-label">
						<?php __('Wartość') ?>:
					</span>
					
					<span class="text-important">
						<?php echo showOrderPrice($order['Order']['price'], $order['Order']['id']) ?>
						
						<?php if ($order['Order']['dropshipping_cod_value'] > 0): ?>
							<br/>(<?php echo __('COD', true).': '.showOrderPrice($order['Order']['dropshipping_cod_value'], $order['Order']['id']) ?>)
						<?php endif ?>
					</span>
				</td>
				
				<?php if (module('B2B')): ?>
					<td>
						<span class="table-responsive-label">
							<?php __('Zapłacono') ?>:
						</span>
						
						<span class="text-important">
							<?php echo showOrderPrice($order['Payment'], $order['Order']['id']) ?>
						</span>
					</td>
				<?php endif ?>
				
				<td>
					<span class="table-responsive-label">
						<?php __('Dostawy') ?>:
					</span>
					
					<?php echo $order['Order']['shipping_method'] ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Płatności') ?>:
					</span>
					
					<?php echo $order['Order']['payment_method'] ?>
				</td>
				
				<?php if (setting('MODULE_PKCS_SIGN_ORDER') && $pkcs_certificate): ?>
					<td>
						<span class="table-responsive-label">
							<?php __('Podpis elektroniczny') ?>:
						</span>
						
						<?php if ($order['Order']['pkcs_signed']): ?>
							<i class="fa fa-check-circle" title="<?php __('Zamówienie podpisane.') ?>"></i>
						<?php else: ?>
							<i class="fa fa-circle-o" title="<?php __('Zamówienie niepodpisane.') ?>"></i>
						<?php endif ?>
					</td>
				<?php endif ?>
				<td>
					<span class="table-responsive-label">
						<?php __('Opłacone') ?>:
					</span>
					<?php
						$payment_sum = $order['Payment'];
						$order_price = $order['Order']['OrdersTotalCount'];
						echo $payment_sum >= $order_price ? __('Tak', true) : __('Nie', true);
						?>
				</td>
				<td class="table-options">
					<?php if ($is_salesrep): ?>
						<a href="#SalesrepOption<?php echo $key ?>" data-type="toggle">
							<?php __('Opcje') ?> <i class="fa fa-chevron-circle-down"></i>
						</a>
					<?php else: ?>
						<a href="<?php echo $this->Html->url(getOrderUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
							<?php __('Szczegóły')?>
						</a>
						
						<?php if (setting('MODULE_POCZTA_EZWROTY_SHOP_ID')): ?>
							<a href="<?php echo $this->Html->url(getPocztaOrderEzwrotUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Zwróć zamówienie', true)) ?>">
								<i class="fa fa-arrow-circle-left"></i>
							</a>
						<?php endif ?>
						
						<a href="<?php echo $this->Html->url(getOrderPayUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Opłać', true)) ?>">
							<?php __('Opłać')?>
						</a>
						
						<?php if (setting('MODULE_PKCS_SIGN_ORDER') && $pkcs_certificate && !$order['Order']['pkcs_signed']): ?>
							<a href="<?php echo $this->Html->url(getOrderPkcsSignUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Podpisz zamówienie', true)) ?>">
								<i class="fa fa-key"></i>
							</a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
			
			<?php if ($is_salesrep): ?>
				<tr id="SalesrepOption<?php echo $key ?>" class="product-row product-row-salesrep-options">
					<td colspan="<?php echo (setting('MODULE_PKCS_SIGN_ORDER') && $pkcs_certificate) ? '11' : '10' ?>">
						<div class="salesrep-options-box">
							<a href="<?php echo $this->Html->url(getOrderUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
								<i class="fa fa-search"></i> <?php __('Szczegóły') ?>
							</a>
							
							<a href="<?php echo $this->Html->url(getOrderReorderUrl($order['Order']['id'])) ?>" title="<?php echo h(__('Ponów', true)) ?>">
								<i class="fa fa-repeat"></i> <?php __('Ponów') ?>
							</a>
							
							<?php if (module('OFFERS')): ?>
								<a data-toggle="modal" href="#OfferFromOrder<?php echo $order['Order']['id'] ?>" role="button" title="<?php echo h(__('Stwórz ofertę', true)) ?>">
									<i class="fa fa-copy"></i> <?php __('Stwórz ofertę') ?>
								</a>
							<?php endif ?>
							
							<?php if (module('COMPLAINTS')): ?>
								<a href="<?php echo $this->Html->url(getComplaintAddUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Reklamacja', true)) ?>">
									<i class="fa fa-exclamation-triangle"></i> <?php __('Reklamacja') ?>
								</a>
							<?php else: ?>
								<a href="<?php echo $this->Html->url(getOrderReclamationUrl($order['Order']['id'])) ?>" title="<?php echo h(__('Reklamacja', true)) ?>">
									<i class="fa fa-exclamation-triangle"></i> <?php __('Reklamacja') ?>
								</a>
							<?php endif ?>
							
							<a href="<?php echo $this->Html->url(getOrderPayUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Opłać', true)) ?>">
								<i class="fa fa-dollar"></i> <?php __('Opłać') ?>
							</a>
							
							<?php if (setting('MODULE_PKCS_SIGN_ORDER') && $pkcs_certificate && !$order['Order']['pkcs_signed']): ?>
								<a href="<?php echo $this->Html->url(getOrderPkcsSignUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Podpisz zamówienie', true)) ?>">
									<i class="fa fa-key"></i> <?php __('Podpisz zamówienie') ?>
								</a>
							<?php endif ?>
							
							<a data-toggle="modal" href="#ShareOrder<?php echo $order['Order']['id'] ?>" role="button" title="<?php echo h(__('Poleć zamówienie', true)) ?>">
								<i class="fa fa-share"></i> <?php __('Poleć zamówienie') ?>
							</a>
						</div>
					</td>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
	</tbody>
</table>

<?php foreach ($orders as $order): ?>
	<div class="modal fade" id="ShareOrder<?php echo $order['Order']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					
					<h2>
						<?php __('Poleć zamówienie') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php __('Aby udostępnić to zamówienie przekaż poniższy adres URL') ?>:
					
					<input type="text" value="<?php echo h($this->Html->url(getOrderShareUrl($order['Order']['id']), true)) ?>" class="form-control share-url"/>
				</div>
				
				<div class="modal-footer modal-actions">
					<a class="btn-next btn btn-primary btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
						<?php __('Zamknij') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<?php if (module('OFFERS') && userIsSalesrep()): ?>
		<div class="modal fade" id="OfferFromOrder<?php echo $order['Order']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Stwórz ofertę') ?>
						</h2>
					</div>
					
					<div class="modal-body">
						<?php
							echo $this->Form->create(
								'Order',
								array(
									'url'         => getOrderReorderUrl($order['Order']['id'], array(), null, 1),
									'id'          => 'OrderReorderOfferForm'.$order['Order']['id'],
									'data-submit' => 'once',
									'class'       => 'form',
									'data-type'   => 'order-reorder-offer-form-'.$order['Order']['id']
								)
							)
						?>
							<?php
								echo $this->Form->input(
									'offer_name',
									array(
										'type'        => 'text',
										'div'         => 'form-row',
										'label'       => __('Nazwa oferty', true).':',
										'class'       => 'form-control',
										'id'          => 'OrderOfferName'.$order['Order']['id'],
										'placeholder' => __('Podaj nazwę oferty', true)
									)
								)
							?>
							
							<div class="form-row checkbox-group">
								<label>
									&nbsp;
								</label>
								
								<div class="checkbox-group-checkboxes">
									<?php
										echo $this->Form->input(
											'offer_set_user',
											array(
												'div'   => 'checkbox',
												'label' => sprintf(__('przypisz klienta %s', true), $order['Order']['username']),
												'id'    => 'OrderOfferSetUser'.$order['Order']['id'],
												'type'  => 'checkbox'
											)
										)
									?>
								</div>
							</div>
						<?php echo $this->Form->end() ?>
					</div>
					
					<div class="modal-footer modal-actions">
						<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Anuluj') ?>
						</a>
						
						<a class="btn-next btn btn-primary btn-lg" href="#" data-type="order-reorder-offer-save" data-order-id="<?php echo $order['Order']['id'] ?>">
							<?php __('Zapisz') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
<?php endforeach ?>

<?php if (module('B2B')): ?>
	<div class="order-list-view-options">
		<div class="options-container form form-inline">
			<a class="btn btn-primary btn-lg" data-type="orders-xls-export" href="#" title="<?php echo h(__('Eksportuj do XLS', true)) ?>">
				<?php __('Eksportuj do XLS') ?>
			</a>
		</div>
		
		<div class="pagination-container">
			<?php
				/* Stronicowanie */
				echo $this->element(TEMPLATE_NAME.DS.'paginator')
			?>
		</div>
	</div>
<?php else: ?>
	<?php
		/* Stronicowanie */
		echo $this->element(TEMPLATE_NAME.DS.'paginator',
			array(
				'class' => 'list-page-paginator'
			)
		)
	?>
<?php endif ?>