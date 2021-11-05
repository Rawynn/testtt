<div class="user-files-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Pliki') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($files): ?>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Plik') ?>
							</th>
							<th>
								<?php __('Id zamówienia') ?>
							</th>
							
							<?php if (setting('MODULE_DOWNLOAD_PRODUCTS_MAX_DOWNLOADS')): ?>
								<th>
									<?php __('Ilość pobrań / limit') ?>
								</th>
							<?php endif ?>
							
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($files as $file): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Plik') ?>:
									</span>
									
									<?php echo $file['ProductFile']['filename'] ? $file['ProductFile']['filename'] : '-' ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Id zamówienia') ?>:
									</span>
									
									<?php echo getOrderFullId($file['Order']['id'], true) ?>
								</td>
								
								<?php if (setting('MODULE_DOWNLOAD_PRODUCTS_MAX_DOWNLOADS')): ?>
									<td>
										<span class="table-responsive-label">
											<?php __('Ilość pobrań / limit') ?>:
										</span>
										
										<?php echo $file['Order']['download_count'].'/'.setting('MODULE_DOWNLOAD_PRODUCTS_MAX_DOWNLOADS') ?>
									</td>
								<?php endif ?>
								
								<td class="table-options">
									<?php if (!empty($file['ProductFile']['id'])): ?>
										<a href="<?php echo $this->Html->url(getProductFileDownloadUrl($file['ProductFile']['id'], $file['Order']['id'], $file['Order']['code'], $file['ProductFile']['filename'])) ?>" title="<?php echo h(__('Pobierz', true)) ?>" target="_blank">
											<i class="fa fa-download"></i>
										</a>
									<?php else: ?>
										<a href="<?php echo $this->Html->url($file['Order']['url']) ?>" title="<?php echo h(__('Pobierz', true)) ?>" target="_blank">
											<i class="fa fa-download"></i>
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
							'message' => __('Brak plików do pobrania.', true)
						)
					)
				?>
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