<div class="invoices-list-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Moje reklamacje') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php
			echo $this->Form->create(
				'Complaint',
				array(
					'url'         => getComplaintsUrl(),
					'class'       => 'order-search-form form form-user-search',
					'data-submit' => 'once',
					'data-type'   => 'complaints-list-search-form',
					'type'        => 'get'
				)
			)
		?>
			<h2>
				<?php __('Wyszukaj') ?>
			</h2>
			
			<?php if (userIsSalesrep()): ?>
				<?php
					echo $this->Form->hidden(
						'user_id',
						array(
							'default'   => getPageParamValue('user_id'),
							'data-send' => 'submit',
							'data-type' => 'complaints-user-id'
						)
					)
				?>
				
				<div class="form-row username-row username-row-autocompleter-on">
					<label for="ComplaintUsername">
						<?php __('Klient') ?>:
					</label>
					
					<?php
						echo $this->Form->input(
							'username',
							array(
								'type'             => 'text',
								'data-type'        => 'autocomplete',
								'data-ac'          => 'true',
								'data-ac-url'      => $this->Html->url(getUsersAutocompleterUrl()),
								'data-ac-handler'  => '[data-type=complaints-user-id-container]',
								'data-ac-extended' => 'false',
								'data-ac-copy'     => '[data-type=complaints-user-id]',
								'div'              => array(
									'data-type' => 'complaints-user-id-container',
									'class'     => 'autocompleter-container'
								),
								'label'            => false,
								'class'            => 'form-control',
								'default'          => getPageParamValue('user_id') ? getPageParamValue('username') : '',
								'placeholder'      => !getPageParamValue('user_id') ? (setting('MODULE_B2B_SALESREP_COMPLAINTS_LIST_DEFAULT_SALESREP_FILTER') == 'salesrep_user' ? __('moi klienci', true) : __('Wszyscy', true)) : ''
							)
						)
					?>
				</div>
			<?php endif ?>
			
			<div class="form-row date-from-to">
				<?php
					echo $this->Form->input(
						'date_from',
						array(
							'type'      => 'text',
							'div'       => false,
							'label'     => __('Data od', true).':',
							'class'     => 'form-control datepicker',
							'default'   => getPageParamValue('date_from'),
							'data-send' => 'submit'
						)
					);
					
					echo $this->Form->input(
						'date_to',
						array(
							'type'      => 'text',
							'div'       => false,
							'label'     => __('do', true).':',
							'class'     => 'form-control datepicker',
							'default'   => getPageParamValue('date_to'),
							'data-send' => 'submit'
						)
					);
				?>
			</div>
			
			<?php
				echo $this->Form->input(
					'order_id',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Zamówienie', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('order_id'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'product_name',
					array(
						'type'      => 'text',
						'div'       => 'form-row product-row',
						'label'     => __('Produkt', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('product_name'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'complaint_type_id',
					array(
						'type'      => 'select',
						'options'   => $complaint_types,
						'div'       => 'form-row status-row',
						'label'     => __('Typ', true).':',
						'class'     => 'form-control',
						'empty'     => __('-dowolny-', true),
						'default'   => getPageParamValue('complaint_type_id'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'complaint_status_id',
					array(
						'type'      => 'select',
						'options'   => $complaint_statuses,
						'div'       => 'form-row status-row',
						'label'     => __('Status', true).':',
						'class'     => 'form-control',
						'empty'     => __('-dowolny-', true),
						'default'   => getPageParamValue('complaint_status_id'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'to_pay',
					array(
						'type'      => 'select',
						'options'   => array(
							1 => __('tak', true),
							0 => __('nie', true)
						),
						'div'       => 'form-row status-row',
						'label'     => __('Płatne', true).':',
						'class'     => 'form-control',
						'empty'     => __('-dowolny-', true),
						'default'   => getPageParamValue('to_pay'),
						'data-send' => 'submit'
					)
				);
			?>
			
			<div class="form-row pull-right">
				<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
			</div>
		<?php echo $this->Form->end() ?>
		
		<?php
			echo $this->Html->link(
				__('Zgłoś reklamację', true),
				array(
					'controller' => 'complaints',
					'action'	 => 'add',
					'language'	 => Configure::read('Config.language')
						
				), array(
					'class' => 'btn btn-primary btn-lg'
				)
			);
		?>
		
		<hr class="no-border" />
		
		<?php if ($complaints): ?>
			<?php
				echo $this->Form->create(
					'Complaint',
					array(
						'url'         => getComplaintsAddPackageUrl(),
						'data-submit' => 'once'
					)
				)
			?>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								&nbsp;
							</th>
							<th>
								<?php __('Data zgłoszenia') ?>
							</th>
							<th>
								<?php __('Data rozpatrzenia') ?>
							</th>
							
							<?php if (userIsSalesrep()): ?>
								<th>
									<?php __('Klient') ?>
								</th>
							<?php endif ?>
							
							<th>
								<?php __('Typ') ?>
							</th>
							<th>
								<?php __('Zamówienie') ?>
							</th>
							<th>
								<?php __('Produkt') ?>
							</th>
							<th>
								<?php __('Status') ?>
							</th>
							<th>
								<?php __('Nr listu przewozowego') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($complaints as $complaint):?>
							<tr>
								<td class="center small-size">
									<?php
										echo $this->Form->checkbox(
											'Complaint.'.$complaint['Complaint']['id'],
											array(
												'disabled' => $complaint['Complaint']['has_package']
											)
										)
									?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data zgłoszenia') ?>:
									</span>
									
									<?php echo showDate($complaint['Complaint']['created']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data rozpatrzenia') ?>:
									</span>
									
									<?php echo $complaint['Complaint']['consideration_time'] != null ? showDate($complaint['Complaint']['consideration_time']) : '-' ?>
								</td>
								
								<?php if (userIsSalesrep()): ?>
									<td>
										<span class="table-responsive-label">
											<?php __('Klient') ?>:
										</span>
										
										<?php echo $complaint['Complaint']['username'] ? $complaint['Complaint']['username'] : '-' ?>
									</td>
								<?php endif ?>
								
								<td>
									<span class="table-responsive-label">
										<?php __('Typ') ?>:
									</span>
									
									<?php echo isset($complaint_types[$complaint['Complaint']['complaint_type_id']]) ? $complaint_types[$complaint['Complaint']['complaint_type_id']] : '-' ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Zamówienie') ?>:
									</span>
									
									<?php
										if ($complaint['Order']['id'] > 0):
											echo $this->Html->link(
												getOrderFullId($complaint['Complaint']['order_id'], true),
												getOrderUrl($complaint['Order']['id'], $complaint['Order']['code']),
												array(
													'target' => '_blank'
												)
											);
										else:
											echo '-';
										endif;
									?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Produkt') ?>:
									</span>
									
									<?php
										if ($complaint['Complaint']['product_id'] > 0):
											echo $this->Html->link(
												$complaint['Complaint']['product_name'],
												getProductUrl($complaint['Complaint']['product_id']),
												array(
													'target' => '_blank'
												)
											);
										else:
											echo $complaint['Complaint']['product_name'];
										endif;
									?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Status') ?>:
									</span>
									
									<?php echo isset($complaint_statuses[$complaint['Complaint']['complaint_status_id']]) ? $complaint_statuses[$complaint['Complaint']['complaint_status_id']] : '-' ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Nr listu przewozowego') ?>:
									</span>
									
									<?php echo $complaint['Complaint']['tracking_number'] ? $complaint['Complaint']['tracking_number'] : '-' ?>
								</td>
								<td class="table-options">
									<a href="<?php echo $this->Html->url(getComplaintShowUrl($complaint['Complaint']['id'])) ?>" title="<?php echo h(__('Zobacz szczegóły reklamacji', true)) ?>">
										<i class="fa fa-search"></i>
									</a>
									
									<a href="<?php echo $this->Html->url(getComplaintPdfUrl($complaint['Complaint']['id'], $complaint['Order']['code'])) ?>" title="<?php echo h(__('Pobierz plik PDF', true)) ?>" target="_blank">
										<i class="fa fa-download"></i>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<div class="form-actions">
					<input class="btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Stwórz paczkę', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
			
			<?php if ($complaint_packages): ?>
				<div class="page-header second-page-header">
					<h1>
						<?php __('Utworzone paczki') ?>
					</h1>
				</div>
				
				<table class="table table-striped table-responsive table-second">
					<thead>
						<tr>
							<th>
								<?php __('Numer') ?>
							</th>
							<th>
								<?php __('Data') ?>
							</th>
							
							<?php if (userIsSalesrep()): ?>
								<th>
									<?php __('Klient') ?>
								</th>
							<?php endif ?>
							
							<th>
								<?php __('Numery reklamacji') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($complaint_packages as $complaint_package): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Numer') ?>:
									</span>
									
									<?php echo $complaint_package['ComplaintPackage']['auto_number'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data') ?>:
									</span>
									
									<?php echo showDate($complaint_package['ComplaintPackage']['created']) ?>
								</td>
								
								<?php if (userIsSalesrep()): ?>
									<td>
										<span class="table-responsive-label">
											<?php __('Klient') ?>:
										</span>
										
										<?php echo $complaint_package['Complaint']['username'] ? $complaint_package['Complaint']['username'] : '-' ?>
									</td>
								<?php endif ?>
								
								<td>
									<span class="table-responsive-label">
										<?php __('Numery reklamacji') ?>:
									</span>
									
									<?php echo implode('<br/>', $complaint_package['Complaint']['id']) ?>
								</td>
								<td class="table-options">
									<a href="<?php echo $this->Html->url(getComplaintPackagePdfUrl($complaint_package['ComplaintPackage']['id'])) ?>" title="<?php echo h(__('Pobierz plik PDF', true)) ?>" target="_blank">
										<i class="fa fa-download"></i>
									</a>
									
									<a data-toggle="modal" href="#DeleteComplaintPackage<?php echo $complaint_package['ComplaintPackage']['id'] ?>" role="button" title="<?php echo h(__('Usuń paczkę', true)) ?>">
										<i class="fa fa-times"></i>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<?php foreach ($complaint_packages as $complaint_package): ?>
					<div class="modal fade" id="DeleteComplaintPackage<?php echo $complaint_package['ComplaintPackage']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									
									<h2>
										<?php __('Usuń paczkę') ?>
									</h2>
								</div>
								
								<div class="modal-body">
									<p class="text-center">
										<?php echo sprintf(__('Czy na pewno chcesz usunąć paczkę numer %s?', true), $complaint_package['ComplaintPackage']['auto_number']) ?>
									</p>
								</div>
								
								<div class="modal-footer modal-actions">
									<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
										<?php __('Nie') ?>
									</a>
									
									<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getComplaintDeletePackageUrl($complaint_package['ComplaintPackage']['id'])) ?>">
										<?php __('Tak') ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			<?php endif ?>
		<?php else: ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'message'.DS.'message',
					array(
						'class'   => 'flat no-items',
						'message' => __('Nie znaleziono żadnych reklamacji.', true)
					)
				)
			?>
		<?php endif ?>
	</div>
</div>