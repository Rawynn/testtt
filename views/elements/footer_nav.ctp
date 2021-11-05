<?php $sections = array(
		2 => __('Informacje', true),
		3 => __('Obsługa klienta', true),
		4 => __('Twoje konto', true)
	) ?>

<div class="row">
	<?php foreach ($sections as $section_id => $section): ?>
		<?php $pages = getSectionStaticPages($section_id) ?>
		
		<nav class="col-<?php echo count($sections) + 1 ?>">
			<div class="hheader">
				<?php echo $section ?>
			</div>
			
			<a rel="nofollow" class="responsive-toggle" data-type="toggle" href="#FooterNav-<?php echo $section_id ?>">
				<?php echo $section ?>
			</a>
			
			<?php if ($pages): ?>
				<ul class="list-foot" id="FooterNav-<?php echo $section_id ?>">
					<?php foreach ($pages as $page): ?>
						<?php
							if ($page['StaticPage']['only_url']):
								$url = $page['StaticPage']['url'];
							else:
								$url = getStaticPageUrl($page['StaticPage']['id']);
							endif;
						?>
						
						<li>
							<a rel="nofollow" href="<?php echo $this->Html->url($url) ?>" title="<?php echo h($page['StaticPage']['title']) ?>">
								<?php echo $page['StaticPage']['title'] ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
		</nav>
	<?php endforeach ?>
		<nav class="col-4">
			<div class="hheader">
				<?php __('Kontakt');?>
			</div>
			<ul class="list-foot" id="FooterNav-0">
				<li>
					<?php __('Infolinia: pon - pt 8.00 - 16.00')?>
				</li>
				<li class="with-icon">
					<i class="sprite sprite-tel"></i> 
					<strong>
					<?php if ($phone = setting('GLOBAL_CONTACT_PHONE_1')): ?>
						<?php echo $phone?>
					<?php endif;?>
					<?php if ($phone2 = setting('GLOBAL_CONTACT_PHONE_2')): ?>
						<?php echo ', '?>
						<span><?php echo $phone2; ?></span>
					<?php endif;?>
					</strong>
				</li>
				<li class="with-icon">
				<?php if ($email = setting('GLOBAL_EMAIL_CONTACT')): ?>
					<a class="mail" href="mailto:<?php echo $email ?>">
						<i class="sprite sprite-mail"></i> <?php echo $email ?>
					</a>
				<?php endif ?>
				</li>
			</ul>
			<?php
				/* Linki społecznościowe  */
				echo $this->element(TEMPLATE_NAME.DS.'social_links')
			?>
		</nav>
</div>