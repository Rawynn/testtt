<?php if (module('RELATED_PRODUCTS_EXT')): ?>
	<?php
		/* Powiązane - wersja rozszerzona */
		echo $this->element(
			TEMPLATE_NAME.DS.'product'.DS.'related_extended',
			array(
				'product_id' => getPageParamValue('id'),
				'cache'      => array(
					'time'    => Configure::read('Cache.long_time'),
					'key'     => getProductCacheFolder(getPageParamValue('id')).DS.getStandardCacheKey(),
					'no_slug' => true
				)
			)
		)
	?>
<?php else: ?>
	<?php
		/* Powiązane */
		echo $this->element(
			TEMPLATE_NAME.DS.'product'.DS.'related',
			array(
				'product_id' => getPageParamValue('id'),
				'cache'      => array(
					'time'    => Configure::read('Cache.long_time'),
					'key'     => getProductCacheFolder(getPageParamValue('id')).DS.getStandardCacheKey(),
					'no_slug' => true
				)
			)
		)
	?>
<?php endif ?>

<?php if (!getPageParamValue('sellable')): ?>
	<?php
		/* Podobne dla produktu niedostępnego */
		echo $this->element(
			TEMPLATE_NAME.DS.'product'.DS.'similar',
			array(
				'product_id' => getPageParamValue('id'),
				'cache'      => array(
					'time'    => Configure::read('Cache.long_time'),
					'key'     => getProductCacheFolder(getPageParamValue('id')).DS.getStandardCacheKey(),
					'no_slug' => true
				)
			)
		)
	?>
<?php endif ?>

<?php
	/* Również kupowane */
	echo $this->element(
		TEMPLATE_NAME.DS.'product'.DS.'also_bought',
		array(
			'product_id' => getPageParamValue('id'),
			'cache'      => array(
				'time'    => Configure::read('Cache.long_time'),
				'key'     => getProductCacheFolder(getPageParamValue('id')).DS.getStandardCacheKey(),
				'no_slug' => true
			)
		)
	)
?>

<?php
	/* Również oglądane */
	echo $this->element(
		TEMPLATE_NAME.DS.'product'.DS.'also_viewed',
		array(
			'product_id' => getPageParamValue('id'),
			'cache'      => array(
				'time'    => Configure::read('Cache.long_time'),
				'key'     => getProductCacheFolder(getPageParamValue('id')).DS.getStandardCacheKey(),
				'no_slug' => true
			)
		)
	)
?>