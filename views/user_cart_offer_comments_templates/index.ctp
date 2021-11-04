<div class="list-page text-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Szablony uwag do ofert') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($templates): ?>
				<table class="offer-list-table table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Nazwa') ?>
							</th>
							<th>
								<?php __('Treść') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($templates as $template): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Nazwa') ?>:
									</span>
									
									<?php echo $template['UserCartOfferCommentsTemplate']['name'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Treść') ?>:
									</span>
									
									<?php echo nl2br($template['UserCartOfferCommentsTemplate']['content']) ?>
								</td>
								<td class="table-options">
									<a href="<?php echo $this->Html->url(getUserCartOfferCommentsTemplateEditUrl($template['UserCartOfferCommentsTemplate']['id'])) ?>" itle="<?php echo h(__('Edytuj szablon', true)) ?>">
										<i class="fa fa-edit"></i>
									</a>
									<a data-toggle="modal" href="#DeleteUserCartOfferCommentsTemplate<?php echo $template['UserCartOfferCommentsTemplate']['id'] ?>" role="button" title="<?php echo h(__('Usuń szablon', true)) ?>">
										<i class="fa fa-times"></i>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<?php
					/* Stronicowanie */
					echo $this->element(TEMPLATE_NAME.DS.'paginator',
						array(
							'class' => 'list-page-paginator'
						)
					)
				?>
				
				<?php foreach ($templates as $template): ?>
					<div class="modal fade" id="DeleteUserCartOfferCommentsTemplate<?php echo $template['UserCartOfferCommentsTemplate']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									
									<h2>
										<?php __('Usuń szablon') ?>
									</h2>
								</div>
								
								<div class="modal-body">
									<?php echo sprintf(__('Czy na pewno chcesz usunąć szablon "%s"?', true), $template['UserCartOfferCommentsTemplate']['name']) ?>
								</div>
								
								<div class="modal-footer modal-actions">
									<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
										<?php __('Anuluj') ?>
									</a>
									
									<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserCartOfferCommentsTemplateDeleteUrl($template['UserCartOfferCommentsTemplate']['id'])) ?>">
										<?php __('Usuń') ?>
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
							'message' => __('Nie znaleziono żadnych zapisanych szablonów.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<a class="btn btn-primary btn-lg btn-block" href="<?php echo $this->Html->url(getUserCartOfferCommentsTemplateEditUrl()) ?>" title="<?php echo h(__('Dodaj nowy szablon', true)) ?>">
				<?php __('Dodaj nowy szablon') ?>
			</a>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>