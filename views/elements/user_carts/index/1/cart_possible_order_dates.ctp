<?php if (!$edit_offer_mode): ?>
	<?php if ($dates = getCartPossibleOrderDates()): ?>
		<div class="possible-order-dates">
			<div class="notice">
				<p>
					<?php __('W koszyku znajdują się pozycje o różnej dostępności, w związku z tym') ?>:
				</p>
				
				<?php foreach (array(0 => __('Zaczekam na zbiorczą przesyłkę', true), 1 => __('Proszę o wiele przesyłek i przeliczenie kosztów dostawy', true)) as $key => $value): ?>
					<?php
						echo $this->Form->input(
							'Order.portion_type',
							array(
								'type'      => 'radio',
								'data-type' => 'change-shipping-portion-type',
								'options'   => array(
									$key => $value
								),
								'value'     => (int) getOrderPortionType(),
								'legend'    => false,
								'disabled'  => $cart_blocked
							)
						)
					?>
				<?php endforeach ?>
				
				<table>
					<?php foreach ($dates as $date => $products_in_order): ?>
						<tr>
							<td>
								<?php __('Zamówienie') ?> <?php echo isset($i) ? ++$i : $i = 1 ?><?php echo ($date != '' && $date != 'preorder') ? ' ('.__('wysyłka', true).': '.showDate($date).')' : '' ?>:
							</td>
							
							<td>
								<ul>
									<?php foreach ($products_in_order as $product): ?>
										<li>
											<strong>
												<?php
													echo getProductName($product['product_id']);
													
													if ($product['combination_id'] && is_numeric($product['combination_id'])):
														echo ' ('.getCombinationName($product['combination_id']).')';
													endif;
												?>
											</strong>
										</li>
									<?php endforeach ?>
								</ul>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>