<?php if ($blog_page): ?>
	<?php echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.'blog_categories') ?>
<?php endif ?>

<?php if ($boxes): ?>
	<?php foreach ($boxes as $box): ?>
		<?php echo $this->element(TEMPLATE_NAME.DS.'boxes'.DS.$box) ?>
	<?php endforeach ?>
<?php endif ?>