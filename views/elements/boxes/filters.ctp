<?php if (checkFiltersAvailable()): ?>
	<?php
		$loader = false;
		
		if (!isAjax() && !isBot() && isProductListIndexView()):
			$loader = true;
		endif;
	?>

	<?php if ($loader): ?>
		<?php
			$url = getCurrentUrl();
			$url['?']['only_filters'] = 1;
			$url['?']['type']         = 'boxes';
		?>
		
		<div data-type="ajax-load" data-load-url="<?php echo $this->Html->url($url) ?>" data-load-type="onload" data-load-offset="50" data-loaded="false">
			<section class="filter-box aside-box">
				<h5 class="box-header hheader">
					<?php __('Filtry') ?>
				</h5>
				
				<a class="responsive-toggle" data-type="toggle" href="#FilterBox">
					<?php __('Filtry') ?>
				</a>
				
				<div class="box-content" id="FilterBox">
					<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
				</div>
			</section>
		</div>
	<?php else: ?>
		<section class="filter-box aside-box">
			<h5 class="box-header hheader">
				<?php __('Filtry') ?>
			</h5>
			
			<a class="responsive-toggle" data-type="toggle" href="#FilterBox">
				<?php __('Filtry') ?>
			</a>
			
			<div class="box-content" id="FilterBox">
				<?php
					echo $this->Form->create(
						'Product',
						array(
							'url'       => $this->Html->url(getProductsFilterFormActionUrl(), true),
							'type'      => 'get',
							'data-type' => 'product-sidebar-filters'
						)
					)
				?>
					<?php
						/* Ukryte pola do wyszukiwarki */
						echo $this->element('_default'.DS.'filter_hidden_fields')
					?>
					
					<ul class="filter-list">
						<?php if (checkFiltersAvailable('status')): ?>
							<li>
								<div class="filter-header hheader">
									<?php __('Rodzaj produktu') ?>
								</div>
								
								<div class="filter-inputs" data-type="filter-row">
									<div data-type="selected-filters"></div>
									
									<div data-type="orderable-filters" data-collapsed="true">
										<?php
											/* Filtry statusów */
											echo $this->element('_default'.DS.'status_filter',
												array(
													'not_ias' => true
												)
											)
										?>
										
										<a class="filter-expander hide" data-type="filter-expander" data-text-collapsed="<?php echo h(__('więcej', true)) ?>" data-text-expanded="<?php echo h(__('mniej', true)) ?>" href="#"></a>
									</div>
								</div>
							</li>
						<?php endif ?>
						<?php if (checkFiltersAvailable('price')): ?>
						<li>
							<div class="filter-header hheader">
								<?php __('Cena') ?>
							</div>
							
							<div class="filter-inputs">
								<div class="price-range-slider">
									<div class="filter-inputs">
										<div class="attribute-range-input price-range">
											<?php
												echo $this->Form->input(
													'pf',
													array(
														'type'        => 'text',
														'pattern'     => '[0-9.,]+',
														'data-send'   => 'submit',
														'label'       => false,
														'div'         => false,
														'class'       => 'form-control',
														'value'       => getPageParamValue('pf'),
														'placeholder' => floor(getMinMaxProductPrice('min', null)).getCurrentCurrency('right_symbol')
													)
												)
											?>
											<?php
												echo $this->Form->input(
													'pt',
													array(
														'type'        => 'text',
														'pattern'     => '[0-9.,]+',
														'data-send'   => 'submit',
														'label'       => false,
														'div'         => false,
														'class'       => 'form-control',
														'value'       => getPageParamValue('pt'),
														'placeholder' => round(getMinMaxProductPrice('max', null)).getCurrentCurrency('right_symbol')
													)
												)
											?>
										</div>
										<div id="slider-range"></div>
									</div>
								</div>
								<?php $__params = $this->params['url']; ?>
								<?php
									$minPrice = floor(getMinMaxProductPrice('min', null));
									
									if ( empty($minPrice) ) :
										$minPrice = getMinMaxProductPrice('min');
									endif;
								
									$maxPrice = round(getMinMaxProductPrice('max', null));
									
									if ( empty($maxPrice) ) :
										$maxPrice = getMinMaxProductPrice('max');
									endif;
									$pf = !empty($this->params['url']['pf']) ? $this->params['url']['pf'] : $minPrice;
									$pt = !empty($this->params['url']['pt']) ? $this->params['url']['pt'] : ($maxPrice);
								?>

								<script type='text/javascript'>
									$( "#slider-range" ).slider({
										animate: 'fast',
										range: true,
										min: <?php echo isset($pf) ? $pf : 0; ?>,
										max: <?php echo $maxPrice; ?>,
										values: [ <?php echo $pf ?>, <?php echo $pt ?> ],
										slide: function( event, ui ) {
											$( "#ProductPf" ).val( ui.values[ 0 ] );
											$( "#ProductPt" ).val( ui.values[ 1 ] );
											
										}
									});
								</script>
							</div>
						</li>
						<?php endif ?>
						
						
						
						<?php if (checkProducerFilterAvailable()): ?>
							<?php if (getProducersCount() >= setting('MODULE_FILTER_PRODUCER_INPUT_CHANGE_FROM')): ?>
								<li>
									<div class="filter-header hheader">
										<?php __('Producent') ?>
									</div>
									
									<div class="filter-inputs">
										<div class="ac-container" id="ProducerFilter">
											<?php
												echo $this->Form->input(
													'pn',
													array(
														'type'            => 'text',
														'data-send'       => 'submit',
														'data-ac'         => "true",
														'data-ac-url'     => $this->Html->url(getProducerAutocompleterUrl()),
														'data-ac-handler' => "#ProducerFilter",
														'div'             => false,
														'label'           => false,
														'class'           => 'form-control',
														'value'           => getPageParamValue('pn')
													)
												)
											?>
										</div>
									</div>
								</li>
							<?php else: ?>
								<?php if ($producers = getProducersWithCount(null)): ?>
									<?php
										$current_producers         = getPageParamValue('pr') ? explode(',', getPageParamValue('pr')) : array();
										$producers_canonical_links = getProducersCanonicalLinks($this->params, Set::extract($producers, '{n}.Producer.id'));
									?>
									
									<li>
										<div class="filter-header hheader">
											<?php __('Producent') ?>
										</div>
										
										<div class="filter-inputs" data-type="filter-row">
											<div data-type="selected-filters"></div>
											
											<div data-type="orderable-filters" data-collapsed="true">
												<?php foreach ($producers as $key => $producer): ?>
													<?php
														$label = $this->Html->link(
															$producer['Producer']['name'],
															$producers_canonical_links[$producer['Producer']['id']],
															array(
																'escape' => false
															)
														);
														
														if (setting('MODULE_FILTER_SHOW_QUANTITIES_PRODUCERS')):
															$label .= $this->Html->tag(
																'span',
																' ('.$producer['Producer']['products_count'].')',
																array(
																	'class' => 'text-muted'
																)
															);
														endif;
														
														echo $this->Form->input(
															'pr['.$producer['Producer']['id'].']',
															array(
																'type'        => 'checkbox',
																'data-send'   => 'submit',
																'div'         => array(
																	'tag'        => 'div',
																	'data-order' => $key
																),
																'label'       => $label,
																'checked'     => in_array($producer['Producer']['id'], $current_producers) ? 'checked' : '',
																'hiddenField' => false
															)
														);
													?>
												<?php endforeach ?>
												
												<a class="filter-expander hide" data-type="filter-expander" data-text-collapsed="<?php echo h(__('więcej', true)) ?>" data-text-expanded="<?php echo h(__('mniej', true)) ?>" href="#"></a>
											</div>
										</div>
									</li>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
						
						<?php if (setting('MODULE_FILTER_CRITERIA_ATTRIBUTES')): ?>
							<?php if ($attributes = getCategoryAttributes(isset($category_id) ? $category_id : null, null)): ?>
								<?php $k = 0 ?>
								<?php foreach ($attributes as $attribute): ?>
									<?php if ($attribute['Attribute']['numerical'] == 1): ?>
										<li>
											<div class="filter-header hheader">
												<?php echo $attribute['Attribute']['name'] ?>
											</div>
											
											<div class="filter-inputs">
												<div class="attribute-range-input">
													<?php
														echo $this->Form->input(
															'avf['.$attribute['Attribute']['id'].']',
															array(
																'type'        => 'text',
																'pattern'     => '[0-9.,]+',
																'data-send'   => 'submit',
																'label'       => false,
																'div'         => false,
																'class'       => 'form-control',
																'value'       => getPageParamValue('avf', $attribute['Attribute']['id']),
																'placeholder' => __('od', true)
															)
														)
													?>
													
													<span>-</span>
													
													<?php
														echo $this->Form->input(
															'avt['.$attribute['Attribute']['id'].']',
															array(
																'type'        => 'text',
																'pattern'     => '[0-9.,]+',
																'data-send'   => 'submit',
																'label'       => false,
																'div'         => false,
																'class'       => 'form-control',
																'value'       => getPageParamValue('avt', $attribute['Attribute']['id']),
																'placeholder' => __('do', true)
															)
														)
													?>
												</div>
											</div>
										</li>
									<?php else: ?>
										<?php if (!isset($attribute['AttributeValue'])): ?>
											<li>
												<div class="filter-header hheader">
													<?php echo $attribute['Attribute']['name'] ?>
												</div>
												
												<div class="filter-inputs">
													<div class="ac-container" id="AttributeFilter-<?php echo $attribute['Attribute']['id'] ?>">
														<?php
															echo $this->Form->input(
																'avn.'.$attribute['Attribute']['id'],
																array(
																	'type'            => 'text',
																	'data-send'       => 'submit',
																	'data-ac'         => "true",
																	'data-ac-url'     => $this->Html->url(getAttributeValueAutocompleterUrl($attribute['Attribute']['id'])),
																	'data-ac-handler' => "#AttributeFilter-".$attribute['Attribute']['id'],
																	'div'             => false,
																	'label'           => false,
																	'class'           => 'form-control',
																	'name'            => 'avn['.$attribute['Attribute']['id'].']',
																	'value'           => getPageParamValue('avn', $attribute['Attribute']['id'])
																)
															)
														?>
													</div>
												</div>
											</li>
										<?php else: ?>
											<?php if ($attribute_values = $attribute['AttributeValue']): ?>
												<?php
													$current_attributes = getPageParamValue('at', $attribute['Attribute']['id']) && is_string(getPageParamValue('at', $attribute['Attribute']['id'])) ? explode(',', getPageParamValue('at', $attribute['Attribute']['id'])) : array();
													
													if ($attribute['Attribute']['indexable']):
														$attribute_value_canonical_links = getAttributeValuesCanonicalLinks($this->params, Set::extract($attribute_values, '{n}.id'));
													endif;
												?>
												
												<li>
													<div class="filter-header hheader">
														<?php echo $attribute['Attribute']['name'] ?>
													</div>
													
													<div class="filter-inputs" data-type="filter-row">
														<div data-type="selected-filters"></div>
														
														<div data-type="orderable-filters" data-collapsed="true">
															<?php foreach ($attribute_values as $key => $value): ?>
																<?php
																	if ($attribute['Attribute']['indexable']):
																		$label = $this->Html->link($value['value'], $attribute_value_canonical_links[$value['id']]);
																	else:
																		$label = $value['value'];
																	endif;
																	
																	if (setting('MODULE_FILTER_SHOW_QUANTITIES')):
																		$label .= $this->Html->tag(
																			'span',
																			' ('.$value['products_count'].')',
																			array(
																				'class' => 'text-muted'
																			)
																		);
																	endif;
																	
																	echo $this->Form->input(
																		'at['.$attribute['Attribute']['id'].']['.$value['id'].']',
																		array(
																			'type'        => 'checkbox',
																			'data-send'   => 'submit',
																			'div'         => array(
																				'tag'        => 'div',
																				'data-order' => $key
																			),
																			'label'       => $label,
																			'checked'     => in_array($value['id'], $current_attributes) ? 'checked' : '',
																			'hiddenField' => false
																		)
																	);
																?>
															<?php endforeach ?>
															
															<a class="filter-expander hide" data-type="filter-expander" data-text-collapsed="<?php echo h(__('więcej', true)) ?>" data-text-expanded="<?php echo h(__('mniej', true)) ?>" href="#"></a>
														</div>
													</div>
												</li>
											<?php endif ?>
										<?php endif ?>
									<?php endif ?>
									<?php
										$k++;
										if ($k==2){break;}
									?>
								<?php endforeach ?>
								
								<?php if ($attributes && count($attributes) > 2): ?>
									<?php $kk = 0 ?>
									<li class="hidden-filters" data-type="hidden-filters" id="HiddenFilters1">
										<ul class="filter-list">
											<?php foreach ($attributes as $attribute): ?>
												<?php if ($kk > 1): ?>
													<?php if ($attribute['Attribute']['numerical'] == 1): ?>
														<li>
															<div class="filter-header hheader">
																<?php echo $attribute['Attribute']['name'] ?>
															</div>
															
															<div class="filter-inputs">
																<div class="attribute-range-input">
																	<?php
																		echo $this->Form->input(
																			'avf['.$attribute['Attribute']['id'].']',
																			array(
																				'type'        => 'text',
																				'pattern'     => '[0-9.,]+',
																				'data-send'   => 'submit',
																				'label'       => false,
																				'div'         => false,
																				'class'       => 'form-control',
																				'value'       => getPageParamValue('avf', $attribute['Attribute']['id']),
																				'placeholder' => __('od', true)
																			)
																		)
																	?>
																	
																	<span>-</span>
																	
																	<?php
																		echo $this->Form->input(
																			'avt['.$attribute['Attribute']['id'].']',
																			array(
																				'type'        => 'text',
																				'pattern'     => '[0-9.,]+',
																				'data-send'   => 'submit',
																				'label'       => false,
																				'div'         => false,
																				'class'       => 'form-control',
																				'value'       => getPageParamValue('avt', $attribute['Attribute']['id']),
																				'placeholder' => __('do', true)
																			)
																		)
																	?>
																</div>
															</div>
														</li>
													<?php else: ?>
														<?php if (!isset($attribute['AttributeValue'])): ?>
															<li>
																<div class="filter-header hheader">
																	<?php echo $attribute['Attribute']['name'] ?>
																</div>
																
																<div class="filter-inputs">
																	<div class="ac-container" id="AttributeFilter-<?php echo $attribute['Attribute']['id'] ?>">
																		<?php
																			echo $this->Form->input(
																				'avn.'.$attribute['Attribute']['id'],
																				array(
																					'type'            => 'text',
																					'data-send'       => 'submit',
																					'data-ac'         => "true",
																					'data-ac-url'     => $this->Html->url(getAttributeValueAutocompleterUrl($attribute['Attribute']['id'])),
																					'data-ac-handler' => "#AttributeFilter-".$attribute['Attribute']['id'],
																					'div'             => false,
																					'label'           => false,
																					'class'           => 'form-control',
																					'name'            => 'avn['.$attribute['Attribute']['id'].']',
																					'value'           => getPageParamValue('avn', $attribute['Attribute']['id'])
																				)
																			)
																		?>
																	</div>
																</div>
															</li>
														<?php else: ?>
															<?php if ($attribute_values = $attribute['AttributeValue']): ?>
																<?php
																	$current_attributes = getPageParamValue('at', $attribute['Attribute']['id']) && is_string(getPageParamValue('at', $attribute['Attribute']['id'])) ? explode(',', getPageParamValue('at', $attribute['Attribute']['id'])) : array();
																	
																	if ($attribute['Attribute']['indexable']):
																		$attribute_value_canonical_links = getAttributeValuesCanonicalLinks($this->params, Set::extract($attribute_values, '{n}.id'));
																	endif;
																?>
																
																<li>
																	<div class="filter-header hheader">
																		<?php echo $attribute['Attribute']['name'] ?>
																	</div>
																	
																	<div class="filter-inputs" data-type="filter-row">
																		<div data-type="selected-filters"></div>
																		
																		<div data-type="orderable-filters" data-collapsed="true">
																			<?php foreach ($attribute_values as $key => $value): ?>
																				<?php
																					if ($attribute['Attribute']['indexable']):
																						$label = $this->Html->link($value['value'], $attribute_value_canonical_links[$value['id']]);
																					else:
																						$label = $value['value'];
																					endif;
																					
																					if (setting('MODULE_FILTER_SHOW_QUANTITIES')):
																						$label .= $this->Html->tag(
																							'span',
																							' ('.$value['products_count'].')',
																							array(
																								'class' => 'text-muted'
																							)
																						);
																					endif;
																					
																					echo $this->Form->input(
																						'at['.$attribute['Attribute']['id'].']['.$value['id'].']',
																						array(
																							'type'        => 'checkbox',
																							'data-send'   => 'submit',
																							'div'         => array(
																								'tag'        => 'div',
																								'data-order' => $key
																							),
																							'label'       => $label,
																							'checked'     => in_array($value['id'], $current_attributes) ? 'checked' : '',
																							'hiddenField' => false
																						)
																					);
																				?>
																			<?php endforeach ?>
																			
																			<a class="filter-expander hide" data-type="filter-expander" data-text-collapsed="<?php echo h(__('więcej', true)) ?>" data-text-expanded="<?php echo h(__('mniej', true)) ?>" href="#"></a>
																		</div>
																	</div>
																</li>
															<?php endif ?>
														<?php endif ?>
													<?php endif ?>
												<?php endif;?>
												<?php $kk++ ?>
											<?php endforeach ?>
										</ul>
									</li>
									<li class="btn-list">
										<a href="#HiddenFilters1" data-type="toggle" class="btn btn-grey btn-block" title="<?php echo __('więcej')?>">
											<span class="show-filt"><?php __('Pokaż więcej')?></span>
											<span class="hide-filt"><?php __('Pokaż mniej')?></span>
										</a>
									</li>
								<?php endif;?>
								
							<?php endif ?>
						<?php endif ?>
						
						<li class="btn-list">
							<input class="btn btn-primary btn-block" data-send="submit" type="submit" value="<?php echo h(__('Filtruj', true)) ?>">
						</li>
						<li class="btn-list">
							<?php $cat_url = getCategoryUrl($category['Category']['id']);  ?>
							<a class="btn btn-primary btn-block" href="<?php echo $this->Html->url($cat_url); ?>">
								<?php __('Wyczyść filtry'); ?>
							</a>
						</li>
					</ul>
				<?php echo $this->Form->end() ?>
			</div>
		</section>
		
		<?php if (isAjax() && get('only_filters') && isProductListIndexView()): ?>
			<script type="type/javascript">
				$(function(){
					ProductList.setupSidebarFilters();
					ProductList.runSidebarFilters();
				});
			</script>
		<?php endif ?>
	<?php endif ?>
<?php endif ?>