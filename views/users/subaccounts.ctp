<div class="user-list-page user-page list-page text-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Subkonta') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<?php if ($subaccounts): ?>
			<table class="table table-striped table-responsive">
				<thead>
					<tr>
						<th>
							<?php __('Nazwa') ?>
						</th>
						<th>
							<?php __('E-mail') ?>
						</th>
						<th>
							<?php __('Ilość / wartość zamówień') ?>
						</th>
						<th>
							<?php __('Ilość wizyt') ?>
						</th>
						<th>
							<?php __('Ostatnia wizyta') ?>
						</th>
						<th class="table-options">
							<?php __('Opcje') ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($subaccounts as $account): ?>
						<tr>
							<td>
								<span class="table-responsive-label">
									<?php __('Nazwa') ?>:
								</span>
								
								<?php echo $account['User']['username'] ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('E-mail') ?>:
								</span>
								
								<?php echo $account['User']['email'] ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('Ilość / wartość zamówień') ?>:
								</span>
								
								<?php echo $account['User']['orders_count'].' / '.showPrice($account['User']['orders_value']) ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('Ilość wizyt') ?>:
								</span>
								
								<?php echo $account['User']['visits_count'] ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('Ostatnia wizyta') ?>:
								</span>
								
								<?php echo $account['User']['last_visit'] ? showDateTime($account['User']['last_visit']) : '-' ?>
							</td>
							<td class="table-options">
								<a href="<?php echo $this->Html->url(getSubaccountEditUrl($account['User']['id'])) ?>" title="<?php echo h(__('Edytuj', true)) ?>">
									<i class="fa fa-edit"></i>
								</a>
								
								<?php if ($account['User']['blocked']): ?>
									<a href="<?php echo $this->Html->url(getSubaccountLockUrl($account['User']['id'], 0)) ?>" title="<?php echo h(__('Odblokuj', true)) ?>">
										<i class="fa fa-unlock"></i>
									</a>
								<?php else: ?>
									<a href="<?php echo $this->Html->url(getSubaccountLockUrl($account['User']['id'], 1)) ?>" title="<?php echo h(__('Zablokuj', true)) ?>">
										<i class="fa fa-lock"></i>
									</a>
								<?php endif ?>
								
								<a data-toggle="modal" href="#DeleteSubaccount<?php echo $account['User']['id'] ?>" role="button" title="<?php echo h(__('Usuń konto', true)) ?>">
									<i class="fa fa-times"></i>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			
			<?php foreach ($subaccounts as $account): ?>
				<div class="modal fade" id="DeleteSubaccount<?php echo $account['User']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								
								<h2>
									<?php __('Usuń subkonto') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<p class="text-center">
									<?php echo sprintf(__('Czy na pewno chcesz usunąć subkonto "%s"?', true), $account['User']['username']) ?>
								</p>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Nie') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getSubaccountDeleteUrl($account['User']['id'])) ?>">
									<?php __('Tak') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Brak zdefiniowanych subkont.', true)
					)
				)
			?>
		<?php endif ?>
		
		<div class="user-list-view-options">
			<div class="options-container">
				<a class="btn btn-primary btn-lg"  href="<?php echo $this->Html->url(getSubaccountEditUrl()) ?>" title="<?php echo h(__('Dodaj subkonto', true)) ?>">
					<?php __('Dodaj subkonto') ?>
				</a>
			</div>
		</div>
	</div>
</div>