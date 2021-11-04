<?php if ($logo = getTemplatePath('logo', false)): ?>
	<?php
		echo $this->Html->image(
			$logo,
			array(
				'url'   => '/',
				'title' => setting('GLOBAL_STORE_NAME'),
				'alt'   => setting('GLOBAL_STORE_NAME')
			)
		)
	?>
<?php endif ?>