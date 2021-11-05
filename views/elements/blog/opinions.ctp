<div class="blog-opinions row">
	<?php if ($item['BlogComment']): ?>
		<div class="col-sm-12">
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
		</div>
	<?php endif ?>
	<div class="col-md-8 col-md-offset-2">
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
						'div'           => 'form-row form-block',
						'placeholder'   => __('Autor', true),
						'label'         => false,
						'class'         => 'form-control',
						'default'       => getUserUsername()
					)
				);
				
				echo $this->Form->input(
					'BlogComment.email',
					array(
						'type'          => 'email',
						'data-validate' => 'validate(email)',
						'div'           => 'form-row form-block',
						'placeholder'   => __('E-mail', true),
						'label'         => false,
						'class'         => 'form-control',
						'default'       => getUserEmail()
					)
				);
				
				echo $this->Form->input(
					'BlogComment.content',
					array(
						'type'          => 'textarea',
						'data-validate' => 'validate(required-textarea)',
						'div'           => 'form-row form-block',
						'placeholder'   => __('Treść', true),
						'label'         => false,
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
			
			<div class="form-actions">
				<input class="btn btn-primary btn-block" type="submit" value="<?php echo h(__('Wyślij', true)) ?>">
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>
