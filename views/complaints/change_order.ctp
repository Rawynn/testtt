<?php
	$output = array(
		'products' => $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'add'.DS.'products')
	);
	
	if (userIsSalesrep() && !empty($order)):
		$output['receive_user_address'] = $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'receive_user_address');
		$output['user_address']         = $this->element(TEMPLATE_NAME.DS.'complaint'.DS.'user_address');
		$output['order']                = $order;
	endif;
	
	echo json_encode($output);
?>