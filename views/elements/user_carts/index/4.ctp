<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'message'.DS.'message',
		array(
			'class'    => 'success',
			'message'  => __('Zamówienie zostało przyjęte. Wkrótce otrzymasz potwierdzającą wiadomość e-mail.', true),
			'no_close' => true
		)
	)
?>

<?php if (isset($orders)): ?>
	<?php foreach ($orders as $order): ?>
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'4'.DS.'placed_order',
				array(
					'order'  => $order,
					'target' => '_blank'
				)
			)
		?>
	<?php endforeach ?>
<?php elseif (isset($saved)): ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'4'.DS.'placed_order',
			array(
				'order' => $__order
			)
		)
	?>
<?php endif ?>

<?php if (isset($saved)): ?>
	<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'4'.DS.'static_info') ?>
	
	<div class="user-box">
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'4'.DS.'newsletter',
				array(
					'order' => $__order
				)
			)
		?>
		
		<?php
			echo $this->element(
				TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'4'.DS.'new_user',
				array(
					'order' => $__order
				)
			)
		?>
	</div>
	
	<?php if ($partner_html_code = getPartnerHTMLCode()): ?>
		<hr>
		
		<?php echo $partner_html_code ?>
	<?php endif ?>
	
	<div class="order-actions form-actions">
		<a class="btn-back btn btn-lg btn-link" href="<?php echo $this->Html->url('/') ?>" title="<?php echo h(__('Powrót do sklepu', true)) ?>">
			<i class="fa fa-caret-left"></i> <?php __('Powrót do sklepu') ?>
		</a>
	</div>
<?php endif ?>