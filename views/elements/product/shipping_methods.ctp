<div class="modal fade" id="ShippingMethods" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<div class="hheader">
					<?php __('Formy dostawy') ?>
				</div>
			</div>
			
			<div class="modal-body">
				<?php $shipping_methods = getProductShippingMethodDetails($product['Product']['id'], getDefaultPricesType()) ?>
				
				<table class="table">
					<colgroup>
						<col width="65%">
						<col width="35%">
					</colgroup>
					<thead>
						<tr>
							<th>
								<?php __('Forma dostawy') ?>
							</th>
							<th>
								<?php __('Cena') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($shipping_methods as $shipping_method): ?>
							<tr>
								<td>
									<?php echo $shipping_method['ShippingMethod']['name'] ?>
								</td>
								<td>
									<strong class="text-important">
										<?php
											if ($shipping_method['ShippingMethod']['price'] === null):
												echo showPrice(0);
											else:
												echo showPrice($shipping_method['ShippingMethod']['price']);
											endif;
										?>
									</strong>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>