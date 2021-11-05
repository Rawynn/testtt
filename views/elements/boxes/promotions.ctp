<?php
	$options = array();
	
	if (isBot()):
		/* Dla Bota cache'ujemy element */
		$options = array(
			'cache' => array(
				'time' => configuration('Cache.bot_time'),
				'key'  => getStandardCacheKey()
			)
		);
	endif;
	
	echo $this->element(TEMPLATE_NAME.DS.'box_promotions', $options);
?>