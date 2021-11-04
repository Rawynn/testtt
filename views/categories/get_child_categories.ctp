<?php if (isset($categories) && $categories): ?>
	<?php echo $this->Tree->show($categories, array(), setting('MODULE_BOX_CATEGORIES_SHOW_QUANTITIES'), 1) ?>
<?php endif ?>