<?php if (module('BREADCRUMBS') && (isProductListIndexView() || isProductShowView())): ?>
<?php //debug($this->params)?>
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
		<li class="breadcrumb-label">
			<?php __('Jesteś tutaj') ?>:
		</li>
		<li property="itemListElement" typeof="ListItem">
			<a property="item" typeof="WebPage" href="<?php echo $this->Html->url('/') ?>" title="<?php echo h(__('Peripetie.cz', true)) ?>">
				<span property="name"><?php __('Peripetie.cz') ?></span>
			</a>
			
			<meta property="position" content="1">
		</li>
		
		<?php foreach (getBreadcrumb() as $key => $breadcrumb): ?>
			<li property="itemListElement" typeof="ListItem">
				<?php echo $breadcrumbs_separator ?>
				
				<a property="item" typeof="WebPage" href="<?php echo $this->Html->url($breadcrumb['url']) ?>" title="<?php echo h($breadcrumb['name']) ?>">
					<span property="name"><?php echo $breadcrumb['name'] ?></span>
				</a>
				
				<meta property="position" content="<?php echo $key + 2 ?>">
			</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>