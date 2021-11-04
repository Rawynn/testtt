<?php
	echo $this->element(
		TEMPLATE_NAME.DS.'box_tags',
		array(
			'cache' => array(
				'time' => configuration('Cache.long_time'),
				'key'  => getStandardCacheKey()
			)
		)
	)
?>