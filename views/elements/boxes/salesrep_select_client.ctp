<?php if (userIsSalesrep()): ?>
	<?php $radio_id = isset($client_cart_box_id) ? 'radio_'.$client_cart_box_id : substr(md5('radio'.date('Y')), 0, 10) ?>
	
	<section class="salesrep-box aside-box">
		<a class="responsive-toggle" data-type="toggle" href="#<?php echo isset($client_cart_box_id) ? $client_cart_box_id : 'BoxClientCart' ?>">
			<?php __('Wybierz klienta') ?>
		</a>
		
		<h5 class="box-header hheader">
			<?php __('Wybierz klienta') ?>
		</h5>
		
		<div class="box-content" id="<?php echo isset($client_cart_box_id) ? $client_cart_box_id : 'BoxClientCart' ?>">
			<?php
				echo $this->Form->create(
					'Salesrep',
					array(
						'url' => getSalesrepChangeUserUrl(),
						'id'  => 'SalesrepChangeUserForm'.(isset($client_cart_box_id) ? $client_cart_box_id : '')
					)
				)
			?>
				<?php
					echo $this->Form->input(
						'user_id',
						array(
							'type'      => 'select',
							'div'       => 'form-row',
							'label'     => false,
							'class'     => 'form-control',
							'options'   => getSalesrepUsersList(true),
							'value'     => getCartUserId(),
							'empty'     => __('Wybierz', true),
							'escape'    => false,
							'id'        => 'SalesrepUserId'.(isset($client_cart_box_id) ? $client_cart_box_id : ''),
							'data-type' => 'salesrep-user-select'
						)
					)
				?>
				
				<?php foreach (array(0 => __('Pozostaw aktualny koszyk', true), 1 => __('Wczytaj bieżący koszyk klienta', true)) as $key => $value): ?>
					<?php
						echo $this->Form->input(
							'type',
							array(
								'type'      => 'radio',
								'options'   => array(
									$key => $value
								),
								'id'        => $radio_id,
								'legend'    => false,
								'checked'   => $key == getSessionValue('Salesrep.type')
							)
						)
					?>
				<?php endforeach ?>
				
				<div class="box-options">
					<input class="btn btn-primary" type="submit" value="<?php echo h(__('Wybierz', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		</div>
	</section>
<?php endif ?>