<?php
	if (get('type') == 'full'):
		$json = array();
		
		foreach ($products as $product):
			$json[] = array(
				'id'    => $product['id'],
				'label' => $this->element(
					TEMPLATE_NAME.DS.'autocompleter'.DS.'product',
					array(
						'product_id'   => $product['id'],
						'product_name' => getProductName($product['id'])
					)
				)
			);
		endforeach;
		
		echo json_encode($json);
	else:
		foreach ($products as $key => $product):
			$products[$key]['name'] = $product['label'];
		endforeach;
		
		echo json_encode($products);
	endif;
?>