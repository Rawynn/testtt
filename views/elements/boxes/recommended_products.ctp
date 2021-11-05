<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'box_recommended_products',
		array(
			'cache' => array(
				'time' => configuration('Cache.long_time'),
				'key'  => getStandardCacheKey()
			)
		)
	)
?>