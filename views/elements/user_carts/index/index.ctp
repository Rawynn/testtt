<?php
	$steps = array(
		1 => array(
			'title' => getCurrentCartName(),
			'class' => 'cart-page order-show-page'
		),
		2 => array(
			'title' => __('Twoje dane', true),
			'class' => 'order-form-page'
		),
		3 => array(
			'title' => __('Twoje dane', true),
			'class' => 'order-form-page'
		),
		4 => array(
			'title' => __('Potwierdzenie', true),
			'class' => 'order-add-page order-show-page'
		)
	)
?>

<div class="<?php echo $steps[$step]['class'] ?> order-page page">
	<div class="order-header page-header">
		<h1>
			<?php if($step==2):?>
				<?php __('Zakupy bez rejestracji') ?>
			<?php elseif($step==4):?>
				<?php echo sprintf(__('Potwierdzenie zamówienia nr %s', true),getOrderFullId($__order['Order']['id'], true))?>
			<?php else:?>
				<?php echo $steps[$step]['title'] ?>
			<?php endif;?>
			
			<?php if (getCartIsOffer() && userIsSalesrep() && $step == 1): ?>
				<a data-toggle="modal" href="#OfferEditName" role="button" title="<?php echo h(__('Zmień nazwę')) ?>">
					<i class="fa fa-edit"></i>
				</a>
			<?php endif ?>
		</h1>
		
		<?php if (!getCartIsOffer() && $step!==4): ?>
			<?php
				echo $this->element(
					TEMPLATE_NAME.DS.'menu_cart_steps',
					array(
						'step'   => $step,
						'placed' => $step == 4 ? true : false
					)
				)
			?>
		<?php endif ?>
	</div>
	
	<div class="page-content">
		<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.$step) ?>
	</div>
</div>