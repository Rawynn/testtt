<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'message'.DS.'message',
		array(
			'class'   => 'info',
			'message' => $message
		)
	)
?>