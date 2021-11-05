<?php if (module('ADVICE')): ?>
	<?php
		$model = Inflector::classify(getCurrentPageController());
		$action = getCurrentPageAction();
		$pass = isset($this->params['pass'][0]) ? $this->params['pass'][0] : null;
	?>
	
	<?php if ($advices = getSidebarAdvice($model, $action, $pass, true)): ?>
		<section class="advice-box aside-box">
			<h2 class="box-header">
				<?php __('Porady') ?>
			</h2>
			
			<a class="responsive-toggle" data-type="toggle" href="#BoxActive">
				<?php __('Porady') ?>
			</a>
			
			<div class="box-content" id="BoxActive">
				<ul class="advice-list">
					<?php foreach ($advices as $advice): ?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'item_advice',
								array(
									'advice'            => $advice,
									'title_as_link'     => setting('MODULE_ADVICE_LINK_ENTRY'),
									'show_more_link'    => setting('MODULE_ADVICE_SHOW_MORE'),
									'no_advice_content' => true
								)
							)
						?>
					<?php endforeach ?>
				</ul>
			</div>
		</section>
	<?php endif ?>
<?php endif ?>