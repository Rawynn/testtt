<div class="order-page page">
	
	<div class="page-header">
		<h1>
			<?php echo sprintf(__('Podpisz zamówienie nr %s', true), getOrderFullId($id, true)) ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content">
		<?php __('Aby podpisać zamówienie pobierz plik XML a następnie wygeneruj dla niego sygnaturę własnym kluczem prywatnym i prześlij ją poniższym formularzem.') ?>
		
		<a href="<?php echo $this->Html->url(getOrderPkcsSignUrl($id, $code, array('xml' => 1))) ?>" title="<?php echo h(__('Pobierz plik XML', true)) ?>" target="_blank">
			<?php __('Pobierz plik XML.') ?>
		</a>
		
		<hr/>
		
		<?php
			echo $this->Form->create(
				'Order',
				array(
					'url'         => getOrderPkcsSignUrl($id, $code),
					'class'       => 'form',
					'data-submit' => 'once',
					'type'        => 'file'
				)
			)
		?>
			<?php
				echo $this->Form->input(
					'signature',
					array(
						'type'  => 'file',
						'div'   => 'form-row',
						'label' => __('Plik z sygnaturą', true).':',
						'class' => 'form-control'
					)
				)
			?>
			
			<div class="form-actions align-input">
				<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Podpisz zamówienie', true)) ?>">
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>