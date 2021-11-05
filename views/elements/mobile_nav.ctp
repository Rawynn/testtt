<div class="mobile-nav-menu <?php echo userIsSalesrep() ? 'mobile-nav-menu-salesrep' : '' ?>">
	
		<?php if ($categories = getCategoryTree('all')): ?>
			<span class="mobile-top-icons" data-type="show-menu-mobile">
				<i class="fa fa-bars"></i>
			</span>
		<?php endif ?>
	
	
	<a class="mobile-top-icons" data-type="toggle" href="#MainSearchElement" data-toggle-extended="top-navigation">
		<i class="fa fa-search"></i>
	</a>
	
	<?php if (userIsSalesrep()): ?>
		<a class="mobile-top-icons" href="#UserAccountMenu" data-type="toggle" data-toggle-extended="top-navigation">
			<i class="fa fa-user-o" aria-hidden="true"></i>
		</a>
	<?php else: ?>
		<?php
			$contact_page = getStaticPageByName('Kontakt');
			
			if (isset($contact_page[0]['StaticPage']['id'])):
				echo $this->Html->link(
					'<i class="fa fa-envelope-o"></i>',
					getStaticPageUrl($contact_page[0]['StaticPage']['id']),
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
			'<i class="sprite sprite-koszyk1"></i>',
			getCartUrl(),
			array(
				'escape' => false,
				'class'  => 'mobile-top-icons'
			)
		)
	?>
</div>