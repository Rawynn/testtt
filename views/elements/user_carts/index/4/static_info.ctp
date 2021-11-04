<?php if ($section_pages = getStaticPagesBySectionCode('potw-zam')): ?>
	<?php foreach($section_pages as $page): ?>
		<?php if (!$page['StaticPage']['only_url']): ?>
			<?php $static_page_contents = getStaticPageContent($page['StaticPage']['id']) ?>
			
			<?php if (!empty($static_page_contents)): ?>
				<hr>
				
				<h2>
					<?php __('Dodatkowe informacje') ?>
				</h2>
				<div class="order-section cms-content">
					<?php echo $static_page_contents ?>
				</div>
				
				<?php //Tylko pierwsza strona z tekstem?>
				<?php break ?>
			<?php endif ?>
		<?php endif ?>
	<?php endforeach ?>
<?php endif ?>