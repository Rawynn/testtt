<?php if (module('BOX_PRODUCERS')): ?>
	<?php
		/* Lista producentów */
		$producers = Set::sort(getProducersWithCount(), '{n}.Producer.name', 'ASC');
		$count     = count($producers);
	?>
	
	<?php if ($producers): ?>
		<section class="producers-box aside-box">
			<a class="responsive-toggle" data-type="toggle" href="#BoxProducers">
				<?php __('Producenci') ?>
			</a>
			
			<h2 class="box-header">
				<?php __('Producenci') ?>
			</h2>
			
			<div class="box-content" id="BoxProducers">
				<?php if ($count > setting('MODULE_BOX_PRODUCERS_INPUT_CHANGE_FROM')): ?>
					<?php
						echo $this->Form->create(
							'Product',
							array(
								'url'  => getProductsSearchUrl(),
								'type' => 'get',
							)
						)
					?>
						<div class="producer-autocomplete">
							<?php
								echo $this->Form->input(
									'pn',
									array(
										'type'             => 'text',
										'data-ac'          => 'true',
										'data-ac-url'      => $this->Html->url(getProducerAutocompleterUrl()),
										'data-ac-handler'  => '.producer-autocomplete',
										'data-ac-extended' => 'false',
										'div'              => false,
										'label'            => false,
										'value'            => getPageParamValue('pn'),
										'class'            => 'form-control',
										'placeholder'      => __('Wpisz nazwę producenta', true)
									)
								)
							?>
						</div>
						
						<hr>
						
						<input class="btn btn-block" type="submit" value="<?php echo h(__('Filtruj', true)) ?>">
					<?php echo $this->Form->end() ?>
				<?php else: ?>
					<?php if (setting('MODULE_BOX_PRODUCERS_SHOW_FULL_LIST')): ?>
						<ul class="navigation-list">
							<?php foreach ($producers as $producer): ?>
								<li>
									<?php echo $this->Html->link($producer['Producer']['name'], getProducerProductsUrl($producer['Producer']['id'])) ?>
								</li>
							<?php endforeach ?>
						</ul>
					<?php else: ?>
						<?php
							$producers = Set::combine($producers, '{n}.Producer.id', '{n}.Producer.name');
							
							foreach ($producers as $id => $producer):
								$producers_url[$this->Html->url(getProducerProductsUrl($id))] = $producer;
							endforeach;
							
							echo $this->Form->input(
								'producers',
								array(
									'type'      => 'select',
									'options'   => $producers_url,
									'label'     => false,
									'div'       => false,
									'class'     => 'form-control',
									'data-type' => 'producer-select',
									'empty'     => __('Wybierz', true)
								)
							);
						?>
					<?php endif ?>
				<?php endif ?>
			</div>
		</section>
	<?php endif ?>
<?php endif ?>