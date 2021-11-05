<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'opinion_list',
		array(
			'opinions'     => getProductOpinions($product_id, getPageParamValue('type') == 'index' ? $product_opinion_id : null),
			'product_list' => true
		)
	)
?>