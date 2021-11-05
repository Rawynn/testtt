<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'payment_message',
		array(
			'type'    => 'error',
			'header'  => __('Zrezygnowałeś z otrzymania kredytu ratalnego', true),
			'message' => __('Skontaktuj się z właścicielem sklepu w celu wyjaśnienia sytuacji oraz pomyślnym dokończenia transakcji. ', true)
		)
	)
?>