<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="<?php echo $langauge = getCurrentLanguageField('language') ?>" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="<?php echo $langauge ?>" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="<?php echo $langauge ?>" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="<?php echo $langauge ?>" class="no-js"> <!--<![endif]-->
	<head>
		<?php
			/* Meta tagi */
			echo $this->element(TEMPLATE_NAME.DS.'head')
		?>
	</head>
	<body>
		<div class="wrap-content print-layout">
			<div class="main-container container">
				<div class="row">
					<section class="main-content sidebar-left-false">
						<?php
							/* Treść strony */
							echo $content_for_layout
						?>
					</section>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(function(){
				window.print();
			});
		</script>
	</body>
</html>