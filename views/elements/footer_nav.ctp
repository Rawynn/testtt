<?php $sections = getStaticPagesSectionsByCode('stopka') ?>

<div class="row">
	<?php foreach ($sections as $section_id => $section): ?>
		<?php $pages = getSectionStaticPages($section_id) ?>
		
		<nav class="col-<?php echo count($sections)+1 ?>">
			<?php 
				if($section=='Stopka - informacje'):
					$title= __('Informacje', true);
				elseif ($section == 'Stopka - twoje konto'):
					$title= __('Twoje konto', true);
				else:
					$title = __('Obsługa klienta', true);
				endif;
			?>
			<div class="hheader">
				<?php echo $title ?>
			</div>
			
			<a class="responsive-toggle" data-type="toggle" href="#FooterNav-<?php echo $section_id ?>">
				<?php echo $title ?>
			</a>
			
			<?php if ($pages): ?>
				<ul class="clear-list" id="FooterNav-<?php echo $section_id ?>">
					<?php foreach ($pages as $page): ?>
						<?php
							if ($page['StaticPage']['only_url']):
								$url = $page['StaticPage']['url'];
							else:
								$url = getStaticPageUrl($page['StaticPage']['id']);
							endif;
						?>
						
						<li>
							<a href="<?php echo $this->Html->url($url) ?>" title="<?php echo h($page['StaticPage']['title']) ?>">
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
				<?php __('Znajdź nas na:') ?>
			</div>
			
			<a class="responsive-toggle" data-type="toggle" href="#FooterNav-social">
				<?php __('Znajdź nas') ?>
			</a>
			<div class="clear-list" id="FooterNav-social">
				<?php
					/* Linki społecznościowe  */
					echo $this->element(TEMPLATE_NAME.DS.'social_links')
				?>	
			</div>
		</nav>
</div>