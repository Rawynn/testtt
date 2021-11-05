<?php
	$output = array(
		'products' => $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'add'.DS.'products')
	);
	
	echo json_encode($output);
?>