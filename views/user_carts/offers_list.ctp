<div class="cart-list-page cart-page list-page text-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Zapisane oferty') ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content">
			<?php
				echo $this->Form->create(
					'UserCart',
					array(
						'url'         => getSavedOffersUrl(),
						'class'       => 'cart-search-form form form-user-search',
						'data-submit' => 'once',
						'data-type'   => 'offers-list-search-form',
						'type'        => 'get'
					)
				)
			?>
				<h2>
					<?php __('Wyszukaj') ?>
				</h2>
				
				<?php
					echo $this->Form->input(
						'number',
						array(
							'type'      => 'text',
							'div'       => 'form-row',
							'label'     => __('Numer', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('number'),
							'data-send' => 'submit',
							'id'        => 'UserCartNumberSearch'
						)
					);
					
					echo $this->Form->input(
						'name',
						array(
							'type'      => 'text',
							'div'       => 'form-row',
							'label'     => __('Nazwa', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('name'),
							'data-send' => 'submit',
							'id'        => 'UserCartNameSearch'
						)
					);
					
					echo $this->Form->input(
						'my',
						array(
							'type'      => 'checkbox',
							'div'       => 'form-row checkbox',
							'label'     => __('tylko moje', true),
							'checked'   => (bool) getPageParamValue('my'),
							'data-send' => 'submit'
						)
					);
					
					echo $this->Form->hidden(
						'user_id',
						array(
							'default'   => getPageParamValue('user_id'),
							'data-send' => 'submit',
							'data-type' => 'offers-user-id'
						)
					);
				?>
				
				<div class="form-row username-row username-row-autocompleter-on">
					<label for="UserCartSearchUsername">
						<?php __('Klient') ?>:
					</label>
					
					<?php
						echo $this->Form->input(
							'username',
							array(
								'type'               => 'text',
								'data-type'          => 'autocomplete',
								'data-ac'            => 'true',
								'data-ac-url'        => $this->Html->url(getUsersAutocompleterUrl()),
								'data-ac-handler'    => '[data-type=offers-user-id-container]',
								'data-ac-extended'   => 'false',
								'data-ac-copy'       => '[data-type=offers-user-id]',
								'data-ac-copy-clear' => 'true',
								'data-send'          => 'submit',
								'div'                => array(
									'data-type' => 'offers-user-id-container',
									'class'     => 'autocompleter-container'
								),
								'label'              => false,
								'class'              => 'form-control',
								'default'            => getPageParamValue('username'),
								'id'                 => 'UserCartSearchUsername',
								'placeholder'        => __('Wszyscy', true)
							)
						)
					?>
				</div>
				
				<?php
					echo $this->Form->input(
						'nip',
						array(
							'type'      => 'text',
							'div'       => 'form-row',
							'label'     => __('NIP', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('nip'),
							'data-send' => 'submit'
						)
					);
					
					echo $this->Form->input(
						'city',
						array(
							'type'      => 'text',
							'div'       => 'form-row',
							'label'     => __('Miejscowość', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('city'),
							'data-send' => 'submit'
						)
					);
					
					echo $this->Form->input(
						'status',
						array(
							'type'      => 'select',
							'div'       => 'form-row',
							'label'     => __('Status', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('status'),
							'data-send' => 'submit',
							'options'   => $statuses,
							'empty'     => __('-dowolny-', true)
						)
					);
				?>
				
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
						'salesrep_id',
						array(
							'type'      => 'select',
							'div'       => 'form-row',
							'label'     => __('Utworzona przez', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('salesrep_id'),
							'data-send' => 'submit',
							'options'   => $salesreps,
							'empty'     => __('-dowolny-', true)
						)
					);
				?>
				
				<div class="form-row pull-right">
					<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
			
			<a class="btn btn-primary btn-lg btn-margin-bottom" data-toggle="modal" href="#NewOffer" role="button" title="<?php echo h(__('Dodaj nową ofertę', true)) ?>">
				<?php __('Dodaj nową ofertę') ?>
			</a>
			
			<a class="btn btn-primary btn-lg btn-margin-bottom" href="<?php echo $this->Html->url(getUserCartOfferCommentsTemplatesUrl()) ?>" title="<?php echo h(__('Szablony uwag', true)) ?>">
				<?php __('Szablony uwag') ?>
			</a>
			
			<div class="modal fade" id="NewOffer" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							
							<h2>
								<?php __('Dodaj nową ofertę') ?>
							</h2>
						</div>
						
						<div class="modal-body">
							<?php
								echo $this->Form->create(
									'UserCart',
									array(
										'url'         => getUserCartNewCartUrl(true),
										'class'       => 'form',
										'data-submit' => 'once',
										'id'          => 'UserCartSaveForm'
									)
								)
							?>
								<?php
									echo $this->Form->input(
										'name',
										array(
											'type'    => 'text',
											'div'     => 'form-row',
											'label'   => __('Nazwa oferty', true).':',
											'class'   => 'form-control'
										)
									)
								?>
								
								<div class="form-actions">
									<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Dodaj', true)) ?>">
								</div>
							<?php echo $this->Form->end() ?>
						</div>
					</div>
				</div>
			</div>
			
			<?php if ($offers): ?>
				<table class="offer-list-table table table-striped table-responsive product-table-salesrep">
					<thead>
						<tr>
							<th>
								&nbsp;
							</th>
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
								<?php __('Utworzona') ?>
							</th>
							<th>
								<?php __('przez') ?>
							</th>
							<th>
								<?php __('Klient') ?>
							</th>
							<th>
								<?php __('Telefon') ?>
							</th>
							<th>
								<?php __('E-mail') ?>
							</th>
							<th>
								<?php __('Wartość') ?>
							</th>
							<th class="table-options"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($offers as $key => $offer): ?>
							<?php
								$show_row = true;
								
								if (setting('MODULE_B2B_OFFER_ONLY_INDIVIDUAL') && $offer['UserCartOffer']):
									$show_row = false;
								endif;
							?>
							
							<?php if ($show_row): ?>
								<tr>
									<td class="center small-size">
										<?php
											echo $this->Form->checkbox(
												'UserCart.'.$offer['UserCart']['id'],
												array(
													'data-type' => 'cart-offer-list-checkbox',
													'disabled'  => $offer['UserCartOffer'] ? 'disabled' : false
												)
											)
										?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Numer') ?>:
										</span>
										
										<?php echo $offer['UserCart']['auto_number'] ?>
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
										
										<?php __('szkic') ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Utworzona') ?>:
										</span>
										
										<?php echo showDate($offer['UserCart']['created']) ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Utworzona przez') ?>:
										</span>
										
										<?php echo $offer['User']['username'] ? $offer['User']['username'] : $offer['User']['email'] ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Klient') ?>:
										</span>
										
										-
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Telefon') ?>:
										</span>
										
										-
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('E-mail') ?>:
										</span>
										
										-
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
										<a href="#SalesrepOption<?php echo $key ?>" data-type="toggle">
											<?php __('Opcje') ?> <i class="fa fa-chevron-circle-down"></i>
										</a>
									</td>
								</tr>
								
								<tr id="SalesrepOption<?php echo $key ?>" class="product-row product-row-salesrep-options">
									<td colspan="11">
										<div class="salesrep-options-box">
											<a href="<?php echo $this->Html->url(getOfferPreviewByNrUrl($offer['UserCart']['auto_number'])) ?>" title="<?php echo h(__('Podgląd', true)) ?>">
												<i class="fa fa-search"></i> <?php __('Podgląd') ?>
											</a>
											
											<?php if ($offer['UserCart']['can_edit']): ?>
												<a data-toggle="modal" href="#EditOffer<?php echo $offer['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Edytuj ofertę', true)) ?>">
													<i class="fa fa-edit"></i> <?php __('Edytuj ofertę') ?>
												</a>
											<?php endif ?>
											
											<a data-toggle="modal" href="#CopyOffer<?php echo $offer['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Skopiuj ofertę', true)) ?>">
												<i class="fa fa-copy"></i> <?php __('Skopiuj ofertę') ?>
											</a>
											
											<a data-toggle="modal" href="#SendOffer<?php echo $offer['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Wyślij ofertę', true)) ?>">
												<i class="fa fa-share"></i> <?php __('Wyślij ofertę') ?>
											</a>
											
											<a href="<?php echo $this->Html->url(getUserCartOfferPdfByNrUrl($offer['UserCart']['auto_number'])) ?>" title="<?php echo h(__('Pobierz PDF', true)) ?>" target="_blank">
												<i class="fa fa-download"></i> <?php __('Pobierz PDF') ?>
											</a>
											
											<a data-toggle="modal" href="#AcceptOffer<?php echo $offer['UserCart']['id'] ?>" role="button"  title="<?php echo h(__('Akceptuj / złóż zamówienie', true)) ?>" target="_blank">
												<i class="fa fa-shopping-cart"></i> <?php __('Akceptuj / złóż zamówienie') ?>
											</a>
											
											<?php if ($offer['UserCart']['can_delete']): ?>
												<a data-toggle="modal" href="#DeleteOffer<?php echo $offer['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Usuń ofertę', true)) ?>">
													<i class="fa fa-times"></i> <?php __('Usuń ofertę') ?>
												</a>
											<?php endif ?>
										</div>
									</td>
								</tr>
							<?php endif ?>
							
							<?php foreach ($offer['UserCartOffer'] as $key_sec => $user_cart_offer): ?>
								<?php
									$auto_number = $offer['UserCart']['auto_number'];
									
									if (setting('MODULE_B2B_OFFER_NUMBER_ADD_VERSION_NUMBER')):
										$auto_number = $offer['UserCart']['auto_number'].'-'.$user_cart_offer['auto_number'];
									endif;
								?>
								
								<tr>
									<td class="center small-size">
										<?php
											echo $this->Form->checkbox(
												'UserCartOffer.'.$user_cart_offer['id'],
												array(
													'data-type' => 'cart-offer-list-checkbox'
												)
											)
										?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Numer') ?>:
										</span>
										
										<?php echo $auto_number ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Nazwa') ?>:
										</span>
										
										<?php
											if (setting('MODULE_B2B_OFFER_ONLY_INDIVIDUAL')):
												echo $offer['UserCart']['name'];
											endif;
										?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Status') ?>:
										</span>
										
										<?php echo $statuses[$user_cart_offer['status']] ?>
										
										<?php if ($user_cart_offer['status'] == 'rejected' && $user_cart_offer['rejection_date']): ?>
											(<?php echo showDate($user_cart_offer['rejection_date']) ?>)
										<?php endif ?>
										
										<?php if ($user_cart_offer['last_email_error']): ?>
											<i class="fa fa-exclamation-circle fa-error" data-toggle="tooltip" title="<?php echo h(sprintf(__('Wystąpił błąd podczas wysyłki e-maila z informacją o zamówieniu. Powód błędu: %s', true), $user_cart_offer['last_email_error'])) ?>"/>
										<?php endif ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Utworzona') ?>:
										</span>
										
										<?php echo showDate($user_cart_offer['created']) ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Utworzona przez') ?>:
										</span>
										
										<?php if (setting('MODULE_B2B_OFFER_ONLY_INDIVIDUAL')): ?>
											<?php echo $offer['User']['username'] ? $offer['User']['username'] : $offer['User']['email'] ?>
										<?php else: ?>
											-
										<?php endif ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Klient') ?>:
										</span>
										
										<?php if ($user_cart_offer['user_id']): ?>
											<?php if ($user_cart_offer['username']): ?>
												<a href="<?php echo $this->Html->url(getUserDetailsUrl($user_cart_offer['user_id'])) ?>" target="_blank">
													<i class="fa fa-user"></i> <?php echo $user_cart_offer['username'] ?>
												</a>
											<?php else: ?>
												-
											<?php endif ?>
										<?php else: ?>
											<?php echo $user_cart_offer['name'] ? $user_cart_offer['name'] : '-' ?>
										<?php endif ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('Telefon') ?>:
										</span>
										
										<?php echo $user_cart_offer['phone'] ? $user_cart_offer['phone'] : '-' ?>
									</td>
									<td>
										<span class="table-responsive-label">
											<?php __('E-mail') ?>:
										</span>
										
										<?php echo $user_cart_offer['email'] ? $user_cart_offer['email'] : '-' ?>
										
										<?php if ($user_cart_offer['can_delete']): ?>
											<a data-toggle="modal" href="#DeleteOfferUser<?php echo $offer['UserCart']['id'].'_'.$user_cart_offer['id'] ?>" role="button" title="<?php echo h(__('Usuń klienta', true)) ?>">
												<i class="fa fa-times"></i>
											</a>
										<?php endif ?>
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
										<a href="#SalesrepOption_<?php echo $key_sec.'_'.$key ?>" data-type="toggle">
											<?php __('Opcje') ?> <i class="fa fa-chevron-circle-down"></i>
										</a>
									</td>
								</tr>
								
								<tr id="SalesrepOption_<?php echo $key_sec.'_'.$key ?>" class="product-row product-row-salesrep-options">
									<td colspan="11">
										<div class="salesrep-options-box">
											<a href="<?php echo $this->Html->url(getOfferPreviewByNrUrl($auto_number)) ?>" title="<?php echo h(__('Podgląd', true)) ?>">
												<i class="fa fa-search"></i> <?php __('Podgląd') ?>
											</a>
											
											<?php if ($offer['UserCart']['can_edit'] && setting('MODULE_B2B_OFFER_ONLY_INDIVIDUAL') && $user_cart_offer['status'] == 'before_sent'): ?>
												<a data-toggle="modal" href="#EditOffer<?php echo $offer['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Edytuj ofertę', true)) ?>">
													<i class="fa fa-edit"></i> <?php __('Edytuj ofertę') ?>
												</a>
											<?php endif ?>
											
											<a data-toggle="modal" href="#CopyOffer<?php echo $offer['UserCart']['id'].'_'.$user_cart_offer['id'] ?>" role="button" title="<?php echo h(__('Skopiuj ofertę', true)) ?>">
												<i class="fa fa-copy"></i> <?php __('Skopiuj ofertę') ?>
											</a>
											
											<?php if ($user_cart_offer['status'] == 'before_sent'): ?>
												<a data-toggle="modal" href="#SendOffer<?php echo $offer['UserCart']['id'].'-'.$user_cart_offer['id'] ?>" role="button" title="<?php echo h(__('Wyślij ofertę', true)) ?>">
													<i class="fa fa-share"></i> <?php __('Wyślij ofertę') ?>
												</a>
											<?php elseif ($user_cart_offer['status'] != 'sold'): ?>
												<a data-toggle="modal" href="#SendOfferAgain<?php echo $offer['UserCart']['id'].'-'.$user_cart_offer['id'] ?>" role="button" title="<?php echo h(__('Wyślij ponownie', true)) ?>">
													<i class="fa fa-share"></i> <?php __('Wyślij ponownie') ?>
												</a>
											<?php endif ?>
											
											<a href="<?php echo $this->Html->url(getUserCartOfferPdfByNrUrl($auto_number)) ?>" title="<?php echo h(__('Pobierz PDF', true)) ?>" target="_blank">
												<i class="fa fa-download"></i> <?php __('Pobierz PDF') ?>
											</a>
											
											<a data-toggle="modal" href="#AcceptOffer<?php echo $offer['UserCart']['id'].'_'.$user_cart_offer['id'] ?>" role="button"  title="<?php echo h(__('Akceptuj / złóż zamówienie', true)) ?>" target="_blank">
												<i class="fa fa-shopping-cart"></i> <?php __('Akceptuj / złóż zamówienie') ?>
											</a>
											
											<?php if ($user_cart_offer['can_delete']): ?>
												<a data-toggle="modal" href="#DeleteOffer<?php echo $offer['UserCart']['id'].'_'.$user_cart_offer['id'] ?>" role="button" title="<?php echo h(__('Usuń ofertę', true)) ?>">
													<i class="fa fa-times"></i> <?php __('Usuń ofertę') ?>
												</a>
											<?php endif ?>
										</div>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<?php foreach ($offers as $offer): ?>
					<?php
						/* Edycja oferty */
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'edit_offer',
							array(
								'offer'           => $offer,
								'user_cart_offer' => null
							)
						);
						
						/* Skopiowanie oferty */
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'copy_offer',
							array(
								'offer'           => $offer,
								'user_cart_offer' => null
							)
						);
						
						/* Wysłanie oferty */
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'send_offer',
							array(
								'offer'           => $offer,
								'user_cart_offer' => null
							)
						);
						
						/* Usunięcie oferty */
						if ($offer['UserCart']['can_delete']):
							echo $this->element(
								TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'delete_offer',
								array(
									'offer'           => $offer,
									'user_cart_offer' => null
								)
							);
						endif;
						
						/* Akceptacja oferty */
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'accept_offer',
							array(
								'offer'           => $offer,
								'user_cart_offer' => null
							)
						);
						
						foreach ($offer['UserCartOffer'] as $user_cart_offer):
							/* Skopiowanie oferty */
							echo $this->element(
								TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'copy_offer',
								array(
									'offer'           => $offer,
									'user_cart_offer' => $user_cart_offer
								)
							);
							
							/* Usunięcie oferty */
							if ($user_cart_offer['can_delete']):
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'delete_offer',
									array(
										'offer'           => $offer,
										'user_cart_offer' => $user_cart_offer
									)
								);
								
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'delete_offer_user',
									array(
										'offer'           => $offer,
										'user_cart_offer' => $user_cart_offer
									)
								);
							endif;
							
							/* Wysłanie oferty */
							if ($user_cart_offer['status'] == 'before_sent'):
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'send_offer',
									array(
										'offer'           => $offer,
										'user_cart_offer' => $user_cart_offer
									)
								);
							elseif ($user_cart_offer['status'] != 'sold'):
								echo $this->element(
									TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'send_offer_again',
									array(
										'offer'           => $offer,
										'user_cart_offer' => $user_cart_offer
									)
								);
							endif;
							
							/* Akceptacja oferty */
							echo $this->element(
								TEMPLATE_NAME.DS.'user_carts'.DS.'offers_list'.DS.'accept_offer',
								array(
									'offer'           => $offer,
									'user_cart_offer' => $user_cart_offer
								)
							);
						endforeach;
					?>
				<?php endforeach ?>
				
				<div class="cart-list-view-options">
					<div class="options-container form form-inline">
						<a class="btn btn-primary btn-lg" data-type="join-offers" href="#" title="<?php echo h(__('Połącz', true)) ?>">
							<?php __('Połącz') ?>
						</a>
					</div>
					
					<?php if  (setting('MODULE_B2B_SALESREP_OFFERS_LIST_PAGINATION')): ?>
						<div class="pagination-container">
							<?php
								/* Stronicowanie */
								echo $this->element(TEMPLATE_NAME.DS.'paginator')
							?>
						</div>
					<?php endif ?>
				</div>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Nie znaleziono żadnych zapisanych ofert.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
	</div>
</div>