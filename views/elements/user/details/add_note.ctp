<div class="modal fade" id="NewUserNote" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Dodaj notatkę') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php
					echo $this->Form->create(
						'UserNote',
						array(
							'url'       => getUserAddNoteUrl($id),
							'class'     => 'form',
							'id'        => 'UserAddNoteForm',
							'data-type' => 'user-add-note-form'
						)
					)
				?>
					<?php
						echo $this->Form->input(
							'content',
							array(
								'type'  => 'textarea',
								'div'   => 'form-row',
								'label' => __('Notatka', true).':',
								'class' => 'form-control'
							)
						);
						
						echo $this->Form->input(
							'contact_form',
							array(
								'type'    => 'select',
								'div'     => 'form-row',
								'label'   => __('Forma kontaktu', true).':',
								'class'   => 'form-control',
								'options' => getUserNoteContactForms(),
								'empty'   => __('-brak-', true)
							)
						);
					?>
					
					<div class="form-actions">
						<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Anuluj') ?>
						</a>
						
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Dodaj', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>