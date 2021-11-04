<h2>
	<?php __('Inny adres dostawy') ?>
</h2>

<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'message'.DS.'message',
		array(
			'class'   => 'info',
			'message' => __('Adres dostawy nie jest wymagany.', true)
		)
	)
?>