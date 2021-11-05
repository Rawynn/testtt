<?php
	$is_responsive = (int) setting('GLOBAL_RWD_TEMPLATE');
	
	/* Główne Meta Tagi */
	echo $this->element('_default'.DS.'meta_tags', array(
		'vieport'              => $is_responsive ? 'width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0' : 'width=1170, initial-scale=1',
		'meta_tags_ajax_links' => false
	));
	
	/* noindex dla paginacji */
	
	if (strpos($_SERVER['REQUEST_URI'], "page")!== false):?>
		<meta name="robots" content="noindex, follow">
	<?php endif;
	
	/* Kompilator LESS */
	$less_compiler = getLessCompiler(true);
	
	$less_compiler->setVariables(array(
		'template-name' => '\''.TEMPLATE_NAME.'\'',
		'base-url'      => '\''.Router::url('/').'\'',
		'responsive'    => $is_responsive
	));
	
	$less_compiler->compileFile(CSS.TEMPLATE_NAME.DS.'less'.DS.'bootstrap'.DS.'bootstrap.less', CSS.TEMPLATE_NAME.DS.'bootstrap.css');
	$less_compiler->compileFile(CSS.TEMPLATE_NAME.DS.'less'.DS.'font-awesome'.DS.'font-awesome.less', CSS.TEMPLATE_NAME.DS.'font-awesome.css');
	$less_compiler->compileFile(CSS.TEMPLATE_NAME.DS.'less'.DS.'atomstore'.DS.'atomstore.less', CSS.TEMPLATE_NAME.DS.'atomstore.css');
	
	if ($is_responsive):
		$less_compiler->compileFile(CSS.TEMPLATE_NAME.DS.'less'.DS.'atomstore-responsive'.DS.'atomstore-responsive.less', CSS.TEMPLATE_NAME.DS.'atomstore-responsive.css');
	endif;
	
	$styles = array(
		TEMPLATE_NAME.DS.'bootstrap',
		TEMPLATE_NAME.DS.'font-awesome',
		TEMPLATE_NAME.DS.'atomstore'
	);
	
	if ($is_responsive):
		$styles[] = TEMPLATE_NAME.DS.'atomstore-responsive';
	endif;
	
	$styles[] = TEMPLATE_NAME.DS.'template';
	
	/* Pliki CSS */
	echo $this->Compressor->css(
		$styles,
		TEMPLATE_NAME,
		'styles.min'
	);
	
	/* Przykład dołączania plików JS w przypadku błędów kompresora */
	echo $this->Javascript->link(
		array(
			TEMPLATE_NAME.DS.'vendor'.DS.'jquery-1.11.0'
		)
	);
?>