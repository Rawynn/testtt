<?php if (module('BREADCRUMBS') && !isHomePageView()): ?>
	<?php
		$breadcrumbs_separator = $this->Html->tag(
			'span',
			setting('MODULE_BREADCRUMBS_SEPARATOR'),
			array(
				'class' => 'divider'
			)
		)
	?>
	
	<ul class="breadcrumb" vocab="http://schema.org/" typeof="BreadcrumbList">
		<li property="itemListElement" typeof="ListItem">
			<a property="item" typeof="WebPage" href="<?php echo $this->Html->url('/') ?>" title="<?php echo h(__('Strona główna', true)) ?>">
				<span property="name"><?php __('Strona główna') ?></span>
			</a>
			
			<meta property="position" content="1">
		</li>
		
		<?php foreach (getBreadcrumb() as $key => $breadcrumb): ?>
			<li property="itemListElement" typeof="ListItem">
				<i class="fa fa-angle-right"></i>
				
				<a property="item" typeof="WebPage" href="<?php echo $this->Html->url($breadcrumb['url']) ?>" title="<?php echo h($breadcrumb['name']) ?>">
					<span property="name"><?php echo $breadcrumb['name'] ?></span>
				</a>
				
				<meta property="position" content="<?php echo $key + 2 ?>">
			</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>