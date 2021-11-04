<?php if ($orders): ?>
	<table class="order-list-table table table-striped table-responsive">
		<thead>
			<tr>
				<th>
					<?php __('Id') ?>
				</th>
				<th>
					<?php __('Data') ?>
				</th>
				<th>
					<?php __('Wartość') ?>
				</th>
				<th>
					<?php __('Status') ?>
				</th>
				<th>
					<?php __('Faktura') ?>
				</th>
				<th class="table-options">
					<?php __('Opcje') ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($orders as $order): ?>
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
					<td>
						<span class="table-responsive-label">
							<?php __('Wartość') ?>:
						</span>
						
						<span class="text-important">
							<?php echo showOrderPrice($order['Order']['price'], $order['Order']['id']) ?>
						</span>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Status') ?>:
						</span>
						
						<?php echo $order['OrderStatus']['name'] ? $order['OrderStatus']['name'] : '-' ?>
					</td>
					<td>
						<span class="table-responsive-label">
							<?php __('Faktura') ?>:
						</span>
						
						<?php echo $order['Invoice'] ? implode(', ', Set::extract($order['Invoice'], '{n}.number')) : '-' ?>
					</td>
					<td class="table-options">
						<a href="<?php echo $this->Html->url(getOrderUrl($order['Order']['id'], $order['Order']['code'])) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
							<i class="fa fa-search"></i>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<div class="user-details-view-options">
		<div class="options-container form form-inline">
			<a class="btn btn-primary btn-lg pull-right" href="<?php echo $this->Html->url(getOrdersUrl(array('user_id' => $id))) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
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
				'message' => __('Nie znaleziono żadnych zamówień tego klienta.', true)
			)
		)
	?>
<?php endif ?>