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
						<?php if (checkFiltersAvailable('price')): ?>
							<li>
								<div class="filter-header hheader">
									<?php __('Cena') ?>
								</div>
								
								<div class="filter-inputs">
									
									<div class="attribute-range-input">
										<?php
											echo $this->Form->input(
												'pf',
												array(
													'type'        => 'text',
													'pattern'     => '[0-9.,]+',
													'data-send'   => 'submit',
													'label'       => __('od', true),
													'div'         => false,
													'class'       => 'form-control',
													'value'       => getPageParamValue('pf')
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
													'label'       => __('do', true),
													'div'         => false,
													'class'       => 'form-control',
													'value'       => getPageParamValue('pt')
												)
											)
										?>
									</div>
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
										$options = array();
										$current_producers         = getPageParamValue('pr') ? explode(',', getPageParamValue('pr')) : array();
										$producers_canonical_links = getProducersCanonicalLinks($this->params, Set::extract($producers, '{n}.Producer.id'));
									?>
									<?php 
									if (setting('MODULE_FILTER_SHOW_QUANTITIES_PRODUCERS')):
									foreach ($producers as $producer):
									$options[$producer['Producer']['id']] = $producer['Producer']['name'].' ('.$producer['Producer']['products_count'].')';
									endforeach;
									else:
									$options = Set::combine($producers,'{n}.Producer.id', '{n}.Producer.name');
									endif;
									?>
									
									<li>
										<div class="filter-header hheader">
											<?php __('Producent') ?>
										</div>
										
										<div class="filter-inputs" data-type="filter-row">
											<div data-type="selected-filters"></div>
											
											<?php echo $this->Form->input(
															'pr',
															array(
																'type'      => 'select',
																'data-send' => 'submit',
																'div'       => false,
																'label'     => false,
																'class'     => 'form-control',
																'options'   => $options,
																'value'     => getPageParamValue('pr'),
																'empty'     => __('Producent', true)
															)
														); ?>
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
																		$label = $this->Html->link($value['value'], $attribute_value_canonical_links[$value['id']], array('rel' => 'nofollow'));
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
																						$label = $this->Html->link($value['value'], $attribute_value_canonical_links[$value['id']], array('rel' => 'nofollow'));
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
									
								<?php endif;?>
								
							<?php endif ?>
						<?php endif ?>
						
						<li>
							<button class="btn pull-right btn-grey hide" data-send="submit" type="submit"><?php __('Filtruj')?> <i class="fa fa-angle-right"></i></button>
						</li>
						<?php if ($attributes && count($attributes) > 2): ?>
						<li class="btn-list">
							<a href="#HiddenFilters1" data-type="toggle" class="btn btn-link btn-block" title="<?php echo __('więcej')?>">
								<span class="show-filt"><?php __('Pokaż wszystkie filtry')?></span>
								<span class="hide-filt"><?php __('Pokaż mniej filtrów')?></span>
							</a>
						</li>
						<?php endif;?>
					</ul>
				<?php echo $this->Form->end() ?>
			</div>
		</section>
		<script type="text/javascript">
		$("[data-type=product-sidebar-filters]").on("change.product-list", "input[data-send=submit], select[data-send=submit]", function(){
			$("[data-type=product-sidebar-filters]").submit();
		});
		</script>
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