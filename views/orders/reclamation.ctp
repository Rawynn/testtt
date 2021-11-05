<div class="order-reclamation-page order-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php echo sprintf(__('Reklamacja do zamówienia nr %s', true), getOrderFullId($order['Order']['id'], true))?>
			
			<small>
				<?php echo showDate($order['Order']['created']) ?> - <strong><?php echo $order_status['OrderStatus']['name'] ?></strong>
			</small>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'Order',
					array(
						'url'           => getOrderReclamationUrl($id),
						'class'         => 'form',
						'data-validate' => 'true',
						'autocomplete'  => 'off',
						'data-submit'   => 'once'
					)
				)
			?>
				<div class="form-row field-checkbox">
					<label>
						<?php __('Wybierz produkt') ?>:
					</label>
					
					<?php
						echo $this->Form->input(
							'product_id',
							array(
								'type'     => 'select',
								'multiple' => 'checkbox',
								'div'      => 'input-group',
								'label'    => false,
								'options'  => Set::combine($order['OrderProduct'], '{n}.product_id', '{n}.product_name')
							)
						)
					?>
				</div>
				
				<?php
					echo $this->Form->input(
						'description',
						array(
							'type'          => 'textarea',
							'data-validate' => 'validate(required-textarea)',
							'div'           => 'form-row',
							'label'         => __('Opis reklamacji', true).':',
							'class'         => 'form-control long'
						)
					)
				?>
				
				<div class="form-actions align-input">
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Wyślij reklamację', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>