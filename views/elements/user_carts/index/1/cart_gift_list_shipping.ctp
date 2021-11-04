<?php if (getPossibleGiftListId() > 0):?>
	<div class="gift-list-shipping form form-inline">
		<div class="form-row">
			<?php foreach (array(1 => __('Dołącz do przesyłki zbiorczej', true), 0 => __('Wyślij prezent od razu', true)) as $key => $value): ?>
				<?php
					echo $this->Form->input(
						'ShippingMethod.use_gifts_list',
						array(
							'type'      => 'radio',
							'data-type' => 'change-use-gift-list',
							'options'   => array(
								$key => $value
							),
							'value'     => getUseGiftsListInCart(),
							'legend'    => false
						)
					)
				?>
			<?php endforeach ?>
		</div>
	</div>
<?php endif ?>