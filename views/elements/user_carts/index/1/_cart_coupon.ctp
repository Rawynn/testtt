<?php if (module('COUPONS')): ?>
	<?php $coupon = getCartCoupon() ?>
	
	<div class="coupon-section">
		<span class="circle auriell">%</span>
		<div class="order-section-header">
			<h2>
				<?php __('Kupon rabatowy') ?>
			</h2>
		</div>
		
		<div class="order-section-inner">
			<?php if ($coupon): ?>
				<?php echo $this->Form->hidden('Coupon.code') ?>
				<div class="form form-inline">
					<span class="coupon-price" data-type="cart-coupon-price">
						<?php echo $coupon && $coupon['value'] != 0 ? showPrice($coupon['value']) : '-' ?>
					</span>
					<div class="form-row">
						<div class="form-control"><?php echo $coupon['name'] ?></div>
					</div>
					<input class="btn btn-form-size btn-primary disabled" value="<?php echo h(__('Aktywuj kod'))?>">
					<a data-toggle="modal" class="btn btn-form-size btn-primary clear-coupon" href="#ClearCoupon" role="button" title="<?php echo h(__('Usuń kod', true)) ?>">
						<?php __('Usuń kod') ?>
					</a>
				</div>
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
								<?php __('Jeżeli posiadasz kupon rabatowy wprowadź jego kod') ?>:
							</span>
							
							<br>
							
							<a data-toggle="modal" href="#CouponInfo" role="button" title="<?php echo h(__('Dowiedz się jak zdobyć kupon rabatowy', true)) ?>">
								<?php __('Dowiedz się jak zdobyć kupon rabatowy') ?>
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
								<?php __('Jeżeli posiadasz kupon rabatowy wprowadź kod') ?>:
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
					
					<input class="btn btn-form-size btn-primary" id="CouponCartSubmit" name="data[Coupon][activate]" type="submit" value="<?php echo h(__('Aktywuj kod', true)) ?>" data-submit="no-disable">
					<input class="btn btn-form-size btn-primary disabled clear-coupon" value="<?php echo h(__('Usuń kod'))?>">
				</div>
			<?php endif ?>
		</div>
	</div>
	
	<hr>
<?php endif ?>