<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'box_producers',
		array(
			'cache' => array(
				'time' => configuration('Cache.long_time'),
				'key'  => getStandardCacheKey()
			)
		)
	)
?>