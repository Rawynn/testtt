<?php
	$options = array(
		'is_first' => true,
		'box_name' => $box
	);
	
	if (isBot()):
		$options['cache'] = array(
			'time' => configuration('Cache.bot_time'),
			'key'  => getStandardCacheKey()
		);
	endif;
	
	echo $this->element(TEMPLATE_NAME.DS.'home'.DS.$box, $options);
?>