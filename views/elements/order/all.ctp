<?php
	$is_salesrep = userIsSalesrep();
	$i = 0;
?>

<?php foreach ($orders as $order_status => $status_orders): ?>
	<h2>
		<?php echo $order_status ?>
	</h2>
	
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
				
				<th>
					<?php __('Wartość') ?>
				</th>
				<th>
					<?php __('Forma dostawy') ?>
				</th>
				<th>
					<?php __('Forma płatności') ?>
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
			<?php foreach ($status_orders as $key => $order): ?>
				<tr>
					<td>
						<span class="table-responsive-label">
							<?php __('Id') ?>:
						</span>
						
						<strong>
							<?php echo getOrderFullId($order['Order']['id'], true) ?>
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
					
					<td class="table-options">
						<?php if ($is_salesrep): ?>
							<a href="#SalesrepOption<?php echo 't'.$i.'r'.$key ?>" data-type="toggle">
								<?php __('Opcje') ?> <i class="fa fa-chevron-circle-down"></i>
							</a>
						<?php else: ?>
							<a href="<?php echo $this->Html->url(getOrderUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
								<i class="fa fa-search"></i>
							</a>
							
							<a href="<?php echo $this->Html->url(getOrderReorderUrl($order['Order']['id'])) ?>" title="<?php echo h(__('Ponów', true)) ?>">
								<i class="fa fa-repeat"></i>
							</a>
							
							<?php if (setting('MODULE_POCZTA_EZWROTY_SHOP_ID')): ?>
								<a href="<?php echo $this->Html->url(getPocztaOrderEzwrotUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Zwróć zamówienie', true)) ?>">
									<i class="fa fa-arrow-circle-left"></i>
								</a>
							<?php endif ?>
							
							<?php if (module('COMPLAINTS')): ?>
								<a href="<?php echo $this->Html->url(getComplaintAddUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Reklamacja', true)) ?>">
									<i class="fa fa-exclamation-triangle"></i>
								</a>
							<?php else: ?>
								<a href="<?php echo $this->Html->url(getOrderReclamationUrl($order['Order']['id'])) ?>" title="<?php echo h(__('Reklamacja', true)) ?>">
									<i class="fa fa-exclamation-triangle"></i>
								</a>
							<?php endif ?>
							
							<a href="<?php echo $this->Html->url(getOrderPayUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Opłać', true)) ?>">
								<i class="fa fa-dollar"></i>
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
				<tr id="SalesrepOption<?php echo 't'.$i.'r'.$key ?>" class="product-row product-row-salesrep-options">
					<td colspan="<?php echo (setting('MODULE_PKCS_SIGN_ORDER') && $pkcs_certificate) ? '8' : '7' ?>">
						<div class="salesrep-options-box">
							<a href="<?php echo $this->Html->url(getOrderUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
								<i class="fa fa-search"></i> <?php __('Szczegóły') ?>
							</a>
							
							<a href="<?php echo $this->Html->url(getOrderReorderUrl($order['Order']['id'])) ?>" title="<?php echo h(__('Ponów', true)) ?>">
								<i class="fa fa-repeat"></i> <?php __('Ponów') ?>
							</a>
							
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
						</div>
					</td>
				</tr>
			<?php endif ?>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<?php $i++ ?>
<?php endforeach ?>