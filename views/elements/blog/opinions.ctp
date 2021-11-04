<div class="blog-opinions">
	<?php if ($item['BlogComment']): ?>
		<div data-type="opinion-list-container">
			<h2>
				<?php __('Komentarze') ?>
			</h2>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'blog'.DS.'opinion_list',
					array(
						'opinions' => $item['BlogComment']
					)
				)
			?>
		</div>
		
		<hr>
	<?php endif ?>
	
	<h2>
		<?php __('Dodaj komentarz') ?>
	</h2>
	
	<?php
		echo $this->Form->create(
			'Blog',
			array(
				'url'           => getBlogUrl($item['Blog']['id']),
				'class'         => 'opinion-form form',
				'data-validate' => 'true',
				'data-submit'   => 'once'
			)
		)
	?>
		<?php
			echo $this->Form->hidden(
				'Blog.action',
				array(
					'value' => 'add_comment'
				)
			);
			
			echo $this->Form->input(
				'BlogComment.username',
				array(
					'type'          => 'text',
					'data-validate' => 'validate(required)',
					'div'           => 'form-row',
					'label'         => __('Autor', true).':',
					'class'         => 'form-control',
					'default'       => getUserUsername()
				)
			);
			
			echo $this->Form->input(
				'BlogComment.email',
				array(
					'type'          => 'text',
					'data-validate' => 'validate(email)',
					'div'           => 'form-row',
					'label'         => __('E-mail', true).':',
					'class'         => 'form-control',
					'default'       => getUserEmail()
				)
			);
			
			echo $this->Form->input(
				'BlogComment.content',
				array(
					'type'          => 'textarea',
					'data-validate' => 'validate(required-textarea)',
					'div'           => 'form-row',
					'label'         => __('Treść', true).':',
					'class'         => 'form-control long'
				)
			);
		?>
		
		<?php if (setting('MODULE_BLOG_CAPTCHA') && !getLoggedUserId()):?>
			<div class="form-row">
				<label>
					&nbsp;
				</label>
				
				<div class="captcha">
					<div class="g-recaptcha" id="recaptcha-blog-opinion"></div>
				</div>
			</div>
		<?php endif ?>
		
		<span class="form-info required-info">
			<?php __('Pola oznaczone (*) są wymagane') ?>
		</span>
		
		<div class="form-actions align-input">
			<input class="btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
		</div>
	<?php echo $this->Form->end() ?>
</div>