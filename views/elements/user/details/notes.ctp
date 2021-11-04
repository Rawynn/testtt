<?php if ($user_notes): ?>
	<ul class="opinion-list">
		<?php foreach ($user_notes as $key => $user_note): ?>
			<li>
				<div class="opinion-author">
					<strong><?php echo $user_note['AdminUser']['username'] ? $user_note['AdminUser']['username'] : $user_note['AdminUser']['email'] ?></strong>
					
					<span class="text-muted">
						<?php echo sprintf(__('w dniu %s napisał', true), showDate($user_note['AdminUser']['created'])) ?>:
					</span>
				</div>
				
				<div class="opinion-content">
					<?php echo nl2br($user_note['UserNote']['content']) ?>
				</div>
				
				<div class="opinion-options">
					<div class="opinion-footer">
						<?php __('Forma kontaktu') ?>: <strong><?php echo $user_note['UserNote']['contact_form'] ? $contact_forms[$user_note['UserNote']['contact_form']] : '-' ?></strong>
					</div>
				</div>
			</li>
		<?php endforeach ?>
	</ul>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => __('Nie znaleziono żadnych notatek tego klienta.', true)
			)
		)
	?>
<?php endif ?>

<div class="form-actions">
	<a class="btn btn-primary btn-next" data-toggle="modal" title="<?php echo h(__('Dodaj notatkę', true)) ?>" href="#NewUserNote" role="button">
		<?php __('Dodaj notatkę') ?>
	</a>
</div>