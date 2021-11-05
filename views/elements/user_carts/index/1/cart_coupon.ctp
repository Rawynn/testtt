<?php if (module('COUPONS')): ?>
	<?php $coupon = getCartCoupon() ?>
	
	<div class="coupon-section order-section">
		<div class="order-section-header">
			<h2>
				<?php __('Kod rabatowy') ?>
			</h2>
		</div>
		
		<div class="order-section-inner">
			<?php if ($coupon): ?>
				<?php echo $this->Form->hidden('Coupon.code') ?>
				
				<h3>
					<?php echo $coupon['name'] ?>
					
					<a data-toggle="modal" class="clear-coupon" href="#ClearCoupon" role="button" title="<?php echo h(__('Zrezygnuj z użycia kuponu', true)) ?>">
						<?php __('zrezygnuj z kuponu') ?>
					</a>
				</h3>
				
				<div class="modal fade" id="ClearCoupon" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								
								<h2>
									<?php __('Rezygnacja z kuponu') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<p class="text-center">
									<?php __('Czy na pewno chcesz zrezygnować z użycia tego kuponu?') ?>
								</p>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
									<?php __('Nie') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserCartClearCouponUrl()) ?>">
									<?php __('Tak') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="form form-inline">
					<span class="coupon-form-label">
						<?php if ($coupon_info = getStaticPageContent(2)): ?>
							<span>
								<?php __('Jeżeli posiadasz kod rabatowy, wpisz go tutaj') ?>:
							</span>
							
							<br>
							
							<a data-toggle="modal" href="#CouponInfo" role="button" title="<?php echo h(__('Jak zdobyć kupon', true)) ?>">
								<?php __('jak uzyskać kupon') ?> <i class="icon-angle-right"></i>
							</a>
							
							<div class="modal fade" id="CouponInfo" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											
											<h2>
												<?php __('Jak uzyskać kupon') ?>
											</h2>
										</div>
										
										<div class="modal-body cms-content">
											<?php echo $coupon_info ?>
										</div>
									</div>
								</div>
							</div>
						<?php else: ?>
							<span class="coupon-label-no-static-info">
								<?php __('Jeżeli posiadasz kod rabatowy, wpisz go tutaj') ?>:
							</span>
						<?php endif ?>
					</span>
					
					<?php
						echo $this->Form->input(
							'Coupon.code',
							array(
								'type'     => 'text',
								'div'      => 'form-row',
								'label'    => false,
								'class'    => 'form-control',
								'disabled' => $cart_blocked
							)
						)
					?>
					
					<input class="btn btn-form-size btn-grey" id="CouponCartSubmit" name="data[Coupon][activate]" type="submit" value="<?php echo h(__('Aktywuj kod', true)) ?>" data-submit="no-disable">
				</div>
			<?php endif ?>
		</div>
		
		<div class="order-section-summary">
			<span data-type="cart-coupon-price">
				<?php echo $coupon && $coupon['value'] != 0 ? showPrice((-1) * $coupon['value']) : '' ?>
			</span>
		</div>
	</div>
	
	<hr>
<?php endif ?>