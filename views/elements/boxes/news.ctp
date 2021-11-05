<?php
	$cache_key = isset($id) ? getStandardCacheKey().'_'.$id : getStandardCacheKey();
	
	echo $this->element(
		TEMPLATE_NAME.DS.'box_news',
		array(
			'id'    => isset($id) ? $id : null,
			'cache' => array(
				'time' => configuration('Cache.long_time'),
				'key'  => $cache_key
			)
		)
	);
?>