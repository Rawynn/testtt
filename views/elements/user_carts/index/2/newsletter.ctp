<?php if (module('NEWSLETTER')): ?>
	<?php $newsletter_groups = getNewsletterGroupsList() ?>
	
	<?php if (count($newsletter_groups) <= 1): ?>
		<?php
			echo $this->Form->input(
				'newsletter',
				array(
					'type'    => 'checkbox',
					'div'     => 'form-row checkbox',
					'label'   => sprintf(
						__('Chcę otrzymywać informacje na temat promocji, nowości i wydarzeń sklepu %s', true),
						setting('GLOBAL_STORE_NAME')
					),
					'checked' => isset($this->data['UserCart']['newsletter']) ? true : false
				)
			);
		?>
	<?php else: ?>
		<div class="form-row">
			<strong>
				<?php __('Chcę dopisać się do listy subskrybentów newslettera') ?>:
			</strong>
		</div>
		
		<?php
			echo $this->Form->input(
				'NewsletterGroup.NewsletterGroup',
				array(
					'type'     => 'select',
					'multiple' => 'checkbox',
					'div'      => 'form-row checkbox-group',
					'label'    => false,
					'options'  => $newsletter_groups,
					'default'  => getSuggestedNewsletterGroupsList()
				)
			)
		?>
	<?php endif ?>
<?php endif ?>