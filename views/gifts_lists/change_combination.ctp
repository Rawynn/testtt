<?php
	$product_combinations = getProductPossibleCombinations($product_id);
	
	if ($product_combinations):
		$current_combination  = $product_combinations[$combination_id];
		
		foreach ($current_combination as $attribute):
			$output['combination']['attributes'][$attribute['attribute_id']] = $attribute['attribute_value_name'];
		endforeach;
	endif;
	
	$product_price = getProductPrice($product_id, $combination_id);
	
	$output['combination']['price'] = showPrice(getDefaultPricesType() == 'netto' ? $product_price['netto_price'] : $product_price['price']);
	
	$output['combination']['image'] = $this->element(
		'_default'.DS.'miniature',
		array(
			'file'  => array(
				'type'     => configuration('ProductMedium.dir'),
				'filename' => ($filename = getCombinationField($combination_id, 'filename')) ? $filename : getProductMainPhotoId($product_id, 'filename'),
				'dir'      => ($filename = getCombinationField($combination_id, 'dir')) ? $filename : getProductMainPhotoId($product_id, 'dir')
			),
			'image' => array(
				'resize'     => 'resize',
				'width'      => 200,
				'height'     => 200,
				'no_photo'   => true,
				'watermark'  => $product_id,
				'background' => array(
					'R' => 255,
					'G' => 255,
					'B' => 255
				)
			),
			'html'  => array(
				'image' => array(
					'alt' => h(getProductName($product_id))
				)
			)
		)
	);
	
	echo json_encode($output);
?>