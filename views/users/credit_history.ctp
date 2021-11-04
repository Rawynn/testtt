<div class="user-credit-history-page user-page page">
	
	<div class="page-header">
		<h1>
			<?php __('Kredyt kupiecki') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
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
								<?php __('Wartość') ?>
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
									
									<?php echo showDateTime($item['CreditHistory']['created']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Zdarzenie') ?>:
									</span>
									
									<?php echo getCreditActionName($item) ?>
								</td>
								<td class="text-center">
									<span class="table-responsive-label">
										<?php __('Wartość') ?>:
									</span>
									
									<strong class="text-important">
										<?php echo showPrice($item['CreditHistory']['value']) ?>
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
							'message' => __('Brak historii kredytu kupieckiego.', true)
						)
					)
				?>
			<?php endif ?>
			
			<hr>
			
			<h3 class="user-points">
				<?php __('Aktualny stan konta') ?>: <strong class="text-important"><?php echo showPrice($credit_value) ?></strong>
			</h3>
			
			<h3 class="user-points">
				<?php __('Dostępny kredyt') ?>: <strong class="text-important"><?php echo showPrice($credit_min) ?></strong>
			</h3>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>