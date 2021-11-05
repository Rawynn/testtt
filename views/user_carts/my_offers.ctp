<div class="cart-list-page cart-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Moje oferty') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($offers): ?>
				<table class="cart-list-table table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Numer') ?>
							</th>
							<th>
								<?php __('Nazwa') ?>
							</th>
							<th>
								<?php __('Status') ?>
							</th>
							<th>
								<?php __('Wartość') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach ($offers as $offer): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Numer') ?>:
									</span>
									
									<?php echo $offer['UserCart']['number'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Nazwa') ?>:
									</span>
									
									<?php echo $offer['UserCart']['name'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Status') ?>:
									</span>
									
									<?php echo $statuses[$offer['UserCartOffer']['status']] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Wartość') ?>:
									</span>
									
									<span class="text-important">
										<?php echo showPrice(getDefaultPricesType() == 'netto' ? $offer['UserCart']['netto_value'] : $offer['UserCart']['value'], true, $offer['UserCart']['currency_code']) ?>
									</span>
								</td>
								<td class="table-options">
									<a href="<?php echo $this->Html->url(getOfferPreviewUrl($offer['UserCart']['id'], $offer['UserCartOffer']['id'])) ?>" title="<?php echo h(__('Podgląd', true)) ?>">
										<i class="fa fa-search"></i>
									</a>
									
									<a href="<?php echo $this->Html->url(getUserCartOfferPdfUrl($offer['UserCart']['id'], $offer['UserCartOffer']['id'])) ?>" title="<?php echo h(__('Drukuj PDF', true)) ?>" target="_blank">
										<i class="fa fa-download"></i>
									</a>
									
									<?php if ($offer['UserCartOffer']['can_confirm']): ?>
										<a href="<?php echo $this->Html->url(getOfferConfirmUrl($offer['UserCart']['id'], $offer['UserCartOffer']['id'])) ?>" title="<?php echo h(__('Zrealizuj ofertę', true)) ?>">
											<i class="fa fa-check-square-o"></i>
										</a>
									<?php endif ?>
									
									<?php if ($offer['UserCartOffer']['can_reject']): ?>
										<a href="<?php echo $this->Html->url(getOfferRejectUrl($offer['UserCart']['id'], $offer['UserCartOffer']['id'])) ?>" title="<?php echo h(__('Odrzuć ofertę', true)) ?>">
											<i class="fa fa-times"></i>
										</a>
									<?php endif ?>
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
							'message' => __('Nie znaleziono żadnych Twoich ofert.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/*Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>