<div class="gift-list-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Listy życzeń') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($gifts_lists): ?>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Nazwa') ?>
							</th>
							<th>
								<?php __('Data od') ?>
							</th>
							<th>
								<?php __('Data do') ?>
							</th>
							<th>
								<?php __('Produkty') ?>
							</th>
							<th>
								<?php __('Wykupione') ?>
							</th>
							<th>
								<?php __('Aktywna') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($gifts_lists as $key => $gifts_list): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Nazwa') ?>:
									</span>
									
									<?php echo $gifts_list['GiftsList']['name'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data od') ?>:
									</span>
									
									<?php echo $gifts_list['GiftsList']['date_from'] ? showDate($gifts_list['GiftsList']['date_from']) : '-' ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data do') ?>:
									</span>
									
									<?php echo $gifts_list['GiftsList']['date_to'] ? showDate($gifts_list['GiftsList']['date_to']) : '-' ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Produkty') ?>:
									</span>
									
									<?php if ($gifts_list['Product']): ?>
										<a data-toggle="modal" href="#GiftsListProducts-<?php echo $key ?>" role="button" title="<?php echo h(__('Pokaż', true)) ?>"><?php __('Pokaż') ?></a>
										
										<div class="modal fade" id="GiftsListProducts-<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" data-dismiss="modal" aria-hidden="true">
															&times;
														</button>
														
														<h2>
															<?php __('Produkty z listy życzeń') ?>
														</h2>
													</div>
													
													<div class="modal-body">
														<ul class="navigation-list">
															<?php foreach ($gifts_list['Product'] as $product): ?>
																<li>
																	<a href="<?php echo $this->Html->url(getProductUrl($product['id'])) ?>" title="<?php echo h($product['name']) ?>">
																		<?php echo $product['name'] ?>
																	</a>
																</li>
															<?php endforeach ?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									<?php else: ?>
										-
									<?php endif ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Wykupione') ?>:
									</span>
									
									<?php if ($gifts_list['BoughtProducts']): ?>
										<a data-toggle="modal" href="#GiftsListBoughtProducts-<?php echo $key ?>" role="button" title="<?php echo h(__('Pokaż', true)) ?>"><?php __('Pokaż') ?></a>
										
										<div class="modal fade" id="GiftsListBoughtProducts-<?php echo $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" data-dismiss="modal" aria-hidden="true">
															&times;
														</button>
														
														<h2>
															<?php __('Produkty z listy życzeń') ?>
														</h2>
													</div>
													
													<div class="modal-body">
														<ul class="navigation-list">
															<?php foreach ($gifts_list['BoughtProducts'] as $product): ?>
																<li>
																	<a href="<?php echo $this->Html->url(getProductUrl($product['id'])) ?>" title="<?php echo h($product['name']) ?>">
																		<?php echo $product['name'] ?>
																	</a>
																</li>
															<?php endforeach ?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									<?php else: ?>
										-
									<?php endif ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Aktywna') ?>:
									</span>
									
									<?php if ($gifts_list['GiftsList']['active']): ?>
										<i class="fa fa-check-circle-o"></i>
									<?php else: ?>
										<i class="fa fa-ban"></i>
									<?php endif ?>
								</td>
								<td class="table-options">
									<?php if (checkGiftsListIsActive($gifts_list['GiftsList']['id'])): ?>
										<a href="<?php echo $this->Html->url(getGiftListSendUrl($gifts_list['GiftsList']['id'])) ?>" title="<?php echo h(__('Wyślij', true)) ?>">
											<i class="fa fa-share"></i>
										</a>
									<?php endif ?>
									
									<a href="<?php echo $this->Html->url(getGiftListEditUrl($gifts_list['GiftsList']['id'])) ?>" title="<?php echo h(__('Edytuj', true)) ?>">
										<i class="fa fa-edit"></i>
									</a>
									
									<a href="<?php echo $this->Html->url(getGiftListDeleteUrl($gifts_list['GiftsList']['id'])) ?>" title="<?php echo h(__('Usuń', true)) ?>">
										<i class="fa fa-times"></i>
									</a>
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
							'message' => __('Brak listy życzeń.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
		<div class="page-sidebar">
			<h2>
				<?php __('Zarządzaj listą życzeń') ?>
			</h2>
			
			<a class="btn btn-block" href="<?php echo $this->Html->url(getGiftListEditUrl()) ?>" title="<?php echo h(__('Dodaj nową listę', true)) ?>">
				<?php __('Dodaj nową listę') ?>
			</a>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>