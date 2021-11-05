<div class="user-list-page user-page list-page text-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php __('Zapytania do ofert') ?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php
			echo $this->Form->create(
				'B2bEnquire',
				array(
					'url'         => getB2bEnquiriesListUrl(),
					'class'       => 'user-search-form form form-user-search',
					'data-submit' => 'once',
					'data-type'   => 'b2b-enquiries-list-search-form',
					'type'        => 'get'
				)
			)
		?>
			<h2>
				<?php __('Wyszukaj') ?>
			</h2>
			
			<?php
				echo $this->Form->input(
					'title',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Tytuł', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('title'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'content',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Treść', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('content'),
						'data-send' => 'submit'
					)
				);
				
				echo $this->Form->input(
					'username',
					array(
						'type'      => 'text',
						'div'       => 'form-row',
						'label'     => __('Klient', true).':',
						'class'     => 'form-control',
						'default'   => getPageParamValue('username'),
						'data-send' => 'submit'
					)
				);
			?>
			
			<div class="form-row pull-right">
				<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
			</div>
		<?php echo $this->Form->end() ?>
		
		<?php if ($enquiries): ?>
			<table class="user-list-table table table-striped table-responsive">
				<thead>
					<tr>
						<th>
							<?php __('Tytuł') ?>
						</th>
						<th>
							<?php __('Treść') ?>
						</th>
						<th>
							<?php __('Klient') ?>
						</th>
						<th>
							<?php __('Oferty') ?>
						</th>
						<th class="table-options">
							<?php __('Opcje') ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($enquiries as $enquire): ?>
						<tr>
							<td>
								<span class="table-responsive-label">
									<?php __('Tytuł') ?>:
								</span>
								
								<?php echo $enquire['B2bEnquire']['title'] ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('Treść') ?>:
								</span>
								
								<?php echo nl2br($enquire['B2bEnquire']['content']) ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('Klient') ?>:
								</span>
								
								<?php echo $enquire['B2bEnquire']['username'] ?>
							</td>
							<td>
								<span class="table-responsive-label">
									<?php __('Oferty') ?>:
								</span>
								
								<?php if ($enquire['UserCartOffer']): ?>
									<?php foreach ($enquire['UserCartOffer'] as $user_cart_offer): ?>
										<a href="<?php echo $this->Html->url(getOfferPreviewUrl($user_cart_offer['user_cart_id'], $user_cart_offer['id'])) ?>" target="_blank" title="<?php echo h($user_cart_offer['offer_name']) ?>"><?php echo $user_cart_offer['offer_name'] ?></a>
										
										<br/>
									<?php endforeach ?>
								<?php else: ?>
									-
								<?php endif ?>
							</td>
							<td class="table-options">
								<a href="<?php echo $this->Html->url(getB2bEnquiriesEditUrl($enquire['B2bEnquire']['id'])) ?>" title="<?php echo h(__('Edytuj zapytanie', true)) ?>">
									<i class="fa fa-edit"></i>
								</a>
								
								<a data-toggle="modal" href="#B2bEnquireCreateOffer<?php echo $enquire['B2bEnquire']['id'] ?>" role="button" title="<?php echo h(__('Stwórz ofertę', true)) ?>">
									<i class="fa fa-file-text-o"></i>
								</a>
								
								<a data-toggle="modal" href="#DeleteB2bEnquire<?php echo $enquire['B2bEnquire']['id'] ?>" role="button" title="<?php echo h(__('Usuń zapytanie', true)) ?>">
									<i class="fa fa-times"></i>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			
			<div class="user-list-view-options">
				<div class="options-container form form-inline">
					<a class="btn btn-primary btn-lg" href="<?php echo $this->Html->url(getB2bEnquiriesEditUrl()) ?>" title="<?php echo h(__('Dodaj zapytanie', true)) ?>">
						<?php __('Dodaj zapytanie') ?>
					</a>
				</div>
				
				<div class="pagination-container">
					<?php
						/* Stronicowanie */
						echo $this->element(TEMPLATE_NAME.DS.'paginator')
					?>
				</div>
			</div>
			
			<?php foreach ($enquiries as $enquire): ?>
				<div class="modal fade" id="B2bEnquireCreateOffer<?php echo $enquire['B2bEnquire']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								
								<h2>
									<?php __('Stwórz ofertę') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<?php
									echo $this->Form->create(
										'B2bEnquire',
										array(
											'url'         => getB2bEnquiriesCreateOfferUrl($enquire['B2bEnquire']['id']),
											'id'          => 'B2bEnquiriesCreateOfferForm'.$enquire['B2bEnquire']['id'],
											'data-submit' => 'once',
											'class'       => 'form',
											'data-type'   => 'b2b-enquiries-create-offer-form-'.$enquire['B2bEnquire']['id']
										)
									)
								?>
									<?php
										echo $this->Form->input(
											'name',
											array(
												'div'   => 'form-row',
												'label' => __('Nazwa oferty', true).':',
												'value' => $enquire['B2bEnquire']['title'],
												'id'    => 'B2bEnquireName'.$enquire['B2bEnquire']['id'],
												'class' => 'form-control'
											)
										)
									?>
								<?php echo $this->Form->end() ?>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Anuluj') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" href="#" data-type="b2b-enquiries-create-offer" data-b2b-enquire-id="<?php echo $enquire['B2bEnquire']['id'] ?>">
									<?php __('Stwórz ofertę') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="DeleteB2bEnquire<?php echo $enquire['B2bEnquire']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								
								<h2>
									<?php __('Usunięcie zapytanie') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<p class="text-center">
									<?php __('Czy na pewno chcesz usunąć to zapytanie?') ?>
								</p>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Nie') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getB2bEnquiriesDeleteUrl($enquire['B2bEnquire']['id'])) ?>">
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
						'message' => __('Nie znaleziono żadnych zapytań.', true)
					)
				)
			?>
			
			<div class="user-list-view-options">
				<div class="options-container form form-inline">
					<a class="btn btn-primary btn-lg" href="<?php echo $this->Html->url(getB2bEnquiriesEditUrl()) ?>" title="<?php echo h(__('Dodaj zapytanie', true)) ?>">
						<?php __('Dodaj zapytanie') ?>
					</a>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>