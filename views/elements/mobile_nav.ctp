<div class="mobile-nav-menu <?php echo userIsSalesrep() ? 'mobile-nav-menu-salesrep' : '' ?>">
	<?php if ($categories = getCategoryTree('all')): ?>
		<span class="mobile-top-icons" data-type="show-menu-mobile">
			<i class="fa fa-bars"></i>
		</span>
	<?php endif ?>
	
	<a class="mobile-top-icons" data-type="toggle" href="#MainSearchElement2" data-toggle-extended="top-navigation">
		<i class="fa fa-search"></i>
	</a>
	
	<?php if (userIsSalesrep()): ?>
		<a class="mobile-top-icons" href="#UserAccountMenu2" data-type="toggle" data-toggle-extended="top-navigation">
			<i class="fa fa-user-o" aria-hidden="true"></i>
		</a>
	<?php else: ?>
		<?php
			
			if (module('WISHLIST')):
				echo $this->Html->link(
					'<i class="fa fa-heart-o"></i>',
					getWishlistUrl(),
					array(
						'escape' => false,
						'class'  => 'mobile-top-icons'
					)
				);
			endif;
		?>
		
		<?php
			echo $this->Html->link(
				'<i class="fa fa-user-o"></i>',
				getOrdersUrl(),
				array(
					'escape' => false,
					'class'  => 'mobile-top-icons'
				)
			)
		?>
	<?php endif ?>
	
	<?php
		echo $this->Html->link(
			'<i class="sprite sprite-cart"></i>',
			getCartUrl(),
			array(
				'escape' => false,
				'class'  => 'mobile-top-icons'
			)
		)
	?>
</div>
<div class="search-form" id="MainSearchElement2" data-toggle-extended-elements="top-navigation">
	<?php echo $this->element(TEMPLATE_NAME.DS.'header_search_mobile')?>
</div>