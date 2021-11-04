<footer>
	<div class="container">
		<div class="row">
			<div class="footer-newsletter-box">
			<?php echo $this->Html->image(
				getTemplatePath('logo', false),
				array(
						'class'   => 'logo',
				)
			);?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'boxes'.DS.'newsletter',
						array(
							'id'          => 'Newsletter',
							'show_groups' => true
						)
					)
				?>
			</div>
			
			<div class="footer-nav">
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'footer_nav',
						array(
							'cache' => array(
								'time' => configuration('Cache.short_time'),
								'key'  => getStandardCacheKey().'_'.((int) ((bool) getLoggedUserId())).'_'.((int) userIsSalesrep())
							)
						)
					)
				?>
			</div>
		</div>
	</div>
	
	<div class="subfooter">
		<div class="container">
			<p class="copy">
				<span><?php __('Copyright  &copy; NetArch') ?></span>
			</p>
			
			<p class="realization">
				<span><?php __('realizacja') ?>:</span> <a href="http://www.netarch.com.pl/" title="NetArch - sklepy dedykowane, systemy B2B" target="_blank">NetArch</a> <span>|</span> <a href="http://www.atomstore.pl/" title="AtomStore - platforma e-commerce klasy premium" target="_blank">AtomStore</a>
			</p>
		</div>
	</div>
</footer>