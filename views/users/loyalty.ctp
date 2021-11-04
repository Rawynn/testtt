<div class="user-loyalty-page user-page page">
	
	<div class="page-header">
		<h1>
			<?php __('Program lojalnościowy') ?>
		</h1>
	</div>
	
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($loyalty_available): ?>
				<?php if ($history): ?>
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>
									<?php __('Data') ?>
								</th>
								<th>
									<?php __('Zdarzenie') ?>
								</th>
								<th class="text-center">
									<?php __('Punkty') ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($history as $item): ?>
								<tr>
									<td>
										<span class="table-responsive-label">
											<?php __('Data') ?>:
										</span>
										
										<?php echo showDateTime($item['LoyaltyHistory']['created']) ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Zdarzenie') ?>:
										</span>
										
										<?php echo getLoyaltyActionName($item) ?>
										
										<?php if (($item['LoyaltyHistory']['points'] == 0 || $item['LoyaltyHistory']['action'] == 'ADMIN_CHANGE') && !empty($item['LoyaltyHistory']['comments'])): ?>
											<br>
											
											<span class="text-muted">
												<?php echo nl2br($item['LoyaltyHistory']['comments']) ?>
											</span>
										<?php endif ?>
									</td>
									<td class="text-center">
										<span class="table-responsive-label">
											<?php __('Punkty') ?>:
										</span>
										
										<strong class="text-important">
											<?php echo $item['LoyaltyHistory']['points'] ?>
										</strong>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				<?php else: ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'message'.DS.'message',
							array(
								'class'   => 'flat no-items',
								'message' => __('Brak historii punktów.', true)
							)
						)
					?>
				<?php endif ?>
				
				<hr>
				
				<h3 class="user-points form-actions">
					<?php __('Aktualna liczba punktów') ?>: <strong class="text-important"><?php echo $loyalty_points ?></strong>
					
					<?php if (setting('MODULE_LOYALTY_USER_ACCESS_TYPE') == 'on_demand'): ?>
						<a class="btn btn-primary btn-next" data-toggle="modal" href="#CancelLoyalty" data-tooltip-set="true" role="button" title="<?php echo h(__('Zrezygnuj z programu lojalnościowego.', true)) ?>">
							<?php __('Zrezygnuj z programu lojalnościowego.') ?>
						</a>
					<?php endif ?>
				</h3>
				
				<?php if (setting('MODULE_LOYALTY_USER_ACCESS_TYPE') == 'on_demand'): ?>
					<div class="modal fade" id="CancelLoyalty" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									
									<h2>
										<?php __('Rezygnacja z programu lojalnościowego') ?>
									</h2>
								</div>
								
								<div class="modal-body">
									<p class="text-center">
										<?php __('Czy na pewno chcesz zrezygnować z programu lojalnościowego? Nie będziesz mógł wymienić zgromadzonych punktów na produkty.') ?>
									</p>
								</div>
								
								<div class="modal-footer modal-actions">
									<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
										<?php __('Nie') ?>
									</a>
									
									<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserChangeLoyaltyUrl(0)) ?>">
										<?php __('Tak') ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endif ?>
			<?php else: ?>
				<?php if (setting('MODULE_LOYALTY_USER_ACCESS_TYPE') == 'on_demand'): ?>
					<a class="btn btn-primary" href="<?php echo $this->Html->url(getUserChangeLoyaltyUrl(1)) ?>" title="<?php echo h(__('Zapisz się do programu lojalnościowego.', true)) ?>">
						<?php __('Zapisz się do programu lojalnościowego.') ?>
					</a>
				<?php endif ?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>