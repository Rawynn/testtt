<h2>
	<?php __('Należności') ?>
</h2>

<div class="form">
	<div class="form-row">
		<label>
			<?php __('Aktualny stan należności') ?>: <strong><?php echo showPrice($current_charge) ?></strong>
		</label>
	</div>
	
	<?php
		echo $this->Form->input(
			'PartnerPayment.filtr_type',
			array(
				'type'          => 'select',
				'data-type'     => 'load-payment-list',
				'data-load-el'  => 'payment-partners-list',
				'div'           => array(
					'tag'           => 'div',
					'class'         => 'form-row'
				),
				'label'     => __('Filtruj', true).':',
				'class'     => 'form-control',
				'options'   => array(
					1 => __('bieżący tydzień', true),
					2 => __('ostatni tydzień', true),
					3 => __('bieżący miesiąc', true),
					4 => __('ostatni miesiąc', true),
					5 => __('bieżący kwartał', true),
					6 => __('ostatni kwartał', true),
					7 => __('bieżący rok', true),
					8 => __('ostatni rok', true),
					9 => __('wszystko', true)
				),
				'empty'     => false,
				'default'   => 4
			)
		)
	?>
</div>

<div id="payment-partners-list">
	<?php echo $this->element(TEMPLATE_NAME.DS.'partner_payments'.DS.'list') ?>
</div>