<table class="user-list-table table table-striped table-responsive">
	<thead>
		<tr>
			<th>
				<?php __('Nazwa') ?>
			</th>
			<th>
				<?php __('NIP') ?>
			</th>
			<th>
				<?php __('Telefon') ?>
			</th>
			<th>
				<?php __('E-mail') ?>
			</th>
			<th>
				<?php __('Ilość zamówień') ?>
			</th>
			<th>
				<?php __('Wartość') ?>
			</th>
			<th>
				<?php __('Handlowiec') ?>
			</th>
			<th class="table-options">
				<?php __('Opcje') ?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user): ?>
			<tr class="<?php echo !$user['User']['registered'] ? 'disabled' : '' ?>">
				<td>
					<span class="table-responsive-label">
						<?php __('Nazwa') ?>:
					</span>
					
					<?php echo $user['UserFieldValueUsernameRev']['value'] ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('NIP') ?>:
					</span>
					
					<?php echo $user['InvoiceUserAddress']['nip'] ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Telefon') ?>:
					</span>
					
					<?php echo $user['UserFieldValuePhone']['value'] ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('E-mail') ?>:
					</span>
					
					<?php echo $user['User']['email'] ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Ilość zamówień') ?>:
					</span>
					
					<?php echo $user['User']['orders_count'] ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Wartość') ?>:
					</span>
					
					<?php echo showPrice($user['User']['orders_value']) ?>
				</td>
				<td>
					<span class="table-responsive-label">
						<?php __('Handlowiec') ?>:
					</span>
					
					<?php echo !empty($user['Salesrep']) ? implode('<br/>', $user['Salesrep']) : '-' ?>
				</td>
				<td class="table-options">
					<a href="<?php echo $this->Html->url(getOrdersUrl(array('user_id' => $user['User']['id']))) ?>" title="<?php echo h(__('Lista zamówień', true)) ?>">
						<i class="fa fa-list" aria-hidden="true"></i>
					</a>
					
					<a href="<?php echo $this->Html->url(getUserDetailsUrl($user['User']['id'])) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
						<i class="fa fa-search" aria-hidden="true"></i>
					</a>
					
					<?php if (getCartUserId() != $user['User']['id']): ?>
						<span data-type="salesrep-user-select-list-<?php echo $user['User']['id'] ?>" data-id="<?php echo $user['User']['id'] ?>" title="<?php echo h(__('Aktywuj klienta', true)) ?>">
							<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						</span>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<div class="user-list-view-options">
	<div class="options-container form form-inline">
		<a class="btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserAddUrl()) ?>" title="<?php echo h(__('Dodaj nowego klienta', true)) ?>">
			<?php __('Dodaj nowego klienta') ?>
		</a>
	</div>
	
	<div class="pagination-container">
		<?php
			/* Stronicowanie */
			echo $this->element(TEMPLATE_NAME.DS.'paginator')
		?>
	</div>
</div>