<?php if (checkFiltersAvailable()): ?>
	<?php $has_attribute_filters = setting('MODULE_FILTER_CRITERIA_ATTRIBUTES') && ($attributes = getCategoryAttributes($category_id, null)) ?>
	
	<div class="product-listing-filters">
		<?php
			echo $this->Form->create(
				'Product',
				array(
					'url'       => $this->Html->url(getProductsFilterFormActionUrl(), true),
					'type'      => 'get',
					'data-type' => 'product-listing-filters'
				)
			)
		?>
			<?php
				/* Ukryte pola do wyszukiwarki */
				echo $this->element('_default'.DS.'filter_hidden_fields');
			?>
			
			<?php
				echo $this->Form->hidden(
					'red',
					array(
						'data-send' => 'submit',
						'value'     => 0
					)
				)
			?>
			
			<div class="top-filters" data-type="top-filters">
				<?php if (checkFiltersAvailable('categories') && ($categories = getCategoriesListForFilter($category_id))): ?>
					<div class="filter-category filter-item">
						<?php
							/* Filtry kategorii */
							echo $this->Form->input(
								'cat',
								array(
									'type'      => 'select',
									'data-send' => 'reload',
									'div'       => false,
									'label'     => false,
									'class'     => 'form-control',
									'options'   => $categories,
									'value'     => unescapeUrl($this->Html->url(getCurrentUrl())),
									'empty'     => __('Kategoria', true),
									'escape'    => false
								)
							)
						?>
					</div>
				<?php endif ?>
				
				<div class="filter-submit filter-item filter-submit-mobile">
					<a class="filter-more" data-type="toggle" href="#HiddenFiltersMobile" title="<?php echo h(__('więcej', true)) ?>">
						<span class="show-filters"><?php __('Pokaż filtry') ?></span>
						<span class="hide-filters"><?php __('zwiń') ?></span>
						
						<i class="fa fa-plus" aria-hidden="true"></i>
					</a>
				</div>
				
				<div class="hidden-filters-mobile" data-type="hidden-filters-mobile" id="HiddenFiltersMobile">
					<?php if (checkFiltersAvailable('status')): ?>
						<div class="filter-status filter-item">
							<?php
								echo $this->Form->input(
									'status',
									array(
										'type'      => 'select',
										'data-send' => 'submit',
										'div'       => false,
										'label'     => false,
										'class'     => 'form-control',
										'options'   => getProductStatusOptions(),
										'value'     => getProductFilterStatusSelectedValue(),
										'empty'     => __('Produkt', true),
										'escape'    => false
									)
								)
							?>
						</div>
					<?php endif ?>
					
					<?php if (checkProducerFilterAvailable() && (($producers = getProducersWithCount(null)) || getPageParamValue('pn'))): ?>
						<div class="filter-producer filter-item">
							<?php if (count($producers) >= setting('MODULE_FILTER_PRODUCER_INPUT_CHANGE_FROM') || getPageParamValue('pn')): ?>
								<div id="ProductProducerContainer" class="autocompleter-container">
									<?php
										echo $this->Form->input(
											'pn',
											array(
												'type'            => 'text',
												'data-send'       => 'submit',
												'data-ac'         => 'true',
												'data-ac-url'     => $this->Html->url(getProducerAutocompleterUrl()),
												'data-ac-handler' => '#ProductProducerContainer',
												'label'           => false,
												'class'           => 'form-control',
												'div'             => false,
												'value'           => getPageParamValue('pn'),
												'placeholder'     => __('Producent', true)
											)
										);
									?>
								</div>
							<?php else: ?>
								<?php
									$options = array();
									
									if (setting('MODULE_FILTER_SHOW_QUANTITIES_PRODUCERS')):
										foreach ($producers as $producer):
											$options[$producer['Producer']['id']] = $producer['Producer']['name'].' ('.$producer['Producer']['products_count'].')';
										endforeach;
									else:
										$options = Set::combine($producers,'{n}.Producer.id', '{n}.Producer.name');
									endif;
									
									echo $this->Form->input(
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
									)
								?>
							<?php endif ?>
						</div>
					<?php endif ?>
					
					<?php if (checkFiltersAvailable('price')): ?>
						<div class="filter-price filter-range filter-item">
							<?php
								echo $this->Form->input(
									'pf',
									array(
										'type'        => 'text',
										'pattern'     => '[0-9.,]+',
										'data-send'   => 'submit',
										'div'         => false,
										'label'       => false,
										'class'       => 'form-control',
										'value'       => getPageParamValue('pf'),
										'placeholder' => __('Cena od', true),
										'title'       => getPageParamValue('pf') !== null ? __('Cena od', true) : ''
									)
								)
							?>
							
							<span>-</span>
							
							<?php
								echo $this->Form->input(
									'pt',
									array(
										'type'        => 'text',
										'pattern'     => '[0-9.,]+',
										'data-send'   => 'submit',
										'div'         => false,
										'label'       => false,
										'class'       => 'form-control',
										'value'       => getPageParamValue('pt'),
										'placeholder' => __('Cena do', true),
										'title'       => getPageParamValue('pt') !== null ? __('Cena do', true) : ''
									)
								)
							?>
						</div>
					<?php endif ?>
					
					<?php if ($has_attribute_filters) : ?>
						<?php $k = 0 ?>
						
						<?php foreach ($attributes as $key => $attribute): ?>
							<?php if ($attribute['Attribute']['numerical'] == 1): ?>
								<div class="filter-range filter-item">
									<?php
										echo $this->Form->input(
											'avf['.$attribute['Attribute']['id'].']',
											array(
												'type'        => 'text',
												'pattern'     => '[0-9.,]+',
												'data-send'   => 'submit',
												'div'         => false,
												'label'       => false,
												'class'       => 'form-control',
												'value'       => getPageParamValue('avf', $attribute['Attribute']['id']),
												'placeholder' => sprintf(__('%s od', true), $attribute['Attribute']['name']),
												'title'       => sprintf(__('%s od', true), $attribute['Attribute']['name'])
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
												'div'         => false,
												'label'       => false,
												'class'       => 'form-control',
												'value'       => getPageParamValue('avt', $attribute['Attribute']['id']),
												'placeholder' => sprintf(__('%s do', true), $attribute['Attribute']['name']),
												'title'       => sprintf(__('%s do', true), $attribute['Attribute']['name'])
											)
										)
									?>
								</div>
							<?php else:?>
								<div class="filter-attribute filter-item">
									<?php if (isset($attribute['AttributeValue'])): ?>
										<?php
											$options = array();
											
											if (setting('MODULE_FILTER_SHOW_QUANTITIES')):
												foreach ($attribute['AttributeValue'] as $attribute_value):
													$options[$attribute_value['id']] = $attribute_value['value'].' ('.$attribute_value['products_count'].')';
												endforeach;
											else:
												$options = Set::combine($attribute['AttributeValue'],'{n}.id', '{n}.value');
											endif;
											
											echo $this->Form->input(
												'at['.$attribute['Attribute']['id'].']',
												array(
													'type'      => 'select',
													'data-send' => 'submit',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control',
													'options'   => $options,
													'value'     => getPageParamValue('at', $attribute['Attribute']['id']),
													'empty'     => $attribute['Attribute']['name'],
												)
											);
										?>
									<?php else: ?>
										<div id="ProductAttributeContainer<?php echo $attribute['Attribute']['id'] ?>" class="autocompleter-container">
											<?php
												echo $this->Form->input(
													'avn['.$attribute['Attribute']['id'].']',
													array(
														'type'            => 'text',
														'data-send'       => 'submit',
														'data-ac'         => 'true',
														'data-ac-url'     => $this->Html->url(getAttributeValueAutocompleterUrl($attribute['Attribute']['id'])),
														'data-ac-handler' => '#ProductAttributeContainer'.$attribute['Attribute']['id'],
														'div'             => false,
														'label'           => false,
														'class'           => 'form-control',
														'value'           => getPageParamValue('avn', $attribute['Attribute']['id']),
														'placeholder'     => $attribute['Attribute']['name']
													)
												)
											?>
										</div>
									<?php endif ?>
								</div>
							<?php endif ?>
							
							<?php
								$k++;
								if ($k==6){break;}
							?>
						<?php endforeach ?>
					<?php endif ?>
					
					<div class="filter-submit filter-item">
						<?php if ($has_attribute_filters && count($attributes) > 6): ?>
							<a class="filter-more" data-type="toggle" href="#HiddenFilters" title="<?php echo h(__('więcej', true)) ?>">
								<span class="show-filters"><?php __('rozwiń') ?></span>
								<span class="hide-filters"><?php __('zwiń') ?></span>
								
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a>
						<?php endif ?>
					</div>
				</div>
			</div>
			
			<?php if ($has_attribute_filters && count($attributes) > 2): ?>
				<div class="hidden-filters" data-type="hidden-filters" id="HiddenFilters">
					<?php $kk = 0 ?>
					<?php foreach ($attributes as $key => $attribute): ?>
						<?php if ($kk > 1): ?>
							<?php if ($attribute['Attribute']['numerical'] == 1): ?>
								<div class="filter-range filter-item">
									<?php
										echo $this->Form->input(
											'avf['.$attribute['Attribute']['id'].']',
											array(
												'type'        => 'text',
												'pattern'     => '[0-9.,]+',
												'data-send'   => 'submit',
												'div'         => false,
												'label'       => false,
												'class'       => 'form-control',
												'value'       => getPageParamValue('avf', $attribute['Attribute']['id']),
												'placeholder' => sprintf(__('%s od', true), $attribute['Attribute']['name']),
												'title'       => sprintf(__('%s od', true), $attribute['Attribute']['name'])
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
												'div'         => false,
												'label'       => false,
												'class'       => 'form-control',
												'value'       => getPageParamValue('avt', $attribute['Attribute']['id']),
												'placeholder' => sprintf(__('%s do', true), $attribute['Attribute']['name']),
												'title'       => sprintf(__('%s do', true), $attribute['Attribute']['name'])
											)
										)
									?>
								</div>
							<?php else:?>
								<div class="filter-attribute filter-item">
									<?php if (isset($attribute['AttributeValue'])): ?>
										<?php
											$options = array();
											
											if (setting('MODULE_FILTER_SHOW_QUANTITIES')):
												foreach ($attribute['AttributeValue'] as $attribute_value):
													$options[$attribute_value['id']] = $attribute_value['value'].' ('.$attribute_value['products_count'].')';
												endforeach;
											else:
												$options = Set::combine($attribute['AttributeValue'],'{n}.id', '{n}.value');
											endif;
											
											echo $this->Form->input(
												'at['.$attribute['Attribute']['id'].']',
												array(
													'type'      => 'select',
													'data-send' => 'submit',
													'div'       => false,
													'label'     => false,
													'class'     => 'form-control',
													'options'   => $options,
													'value'     => getPageParamValue('at', $attribute['Attribute']['id']),
													'empty'     => $attribute['Attribute']['name'],
												)
											)
										?>
									<?php else: ?>
										<div id="ProductAttributeContainer<?php echo $attribute['Attribute']['id'] ?>" class="autocompleter-container">
											<?php
												echo $this->Form->input(
													'avn['.$attribute['Attribute']['id'].']',
													array(
														'type'            => 'text',
														'data-send'       => 'submit',
														'data-ac'         => 'true',
														'data-ac-url'     => $this->Html->url(getAttributeValueAutocompleterUrl($attribute['Attribute']['id'])),
														'data-ac-handler' => '#ProductAttributeContainer'.$attribute['Attribute']['id'],
														'div'             => false,
														'label'           => false,
														'class'           => 'form-control',
														'value'           => getPageParamValue('avn', $attribute['Attribute']['id']),
														'placeholder'     => $attribute['Attribute']['name']
													)
												)
											?>
										</div>
									<?php endif ?>
								</div>
							<?php endif ?>
						<?php endif ?>
						
						<?php $kk++ ?>
					<?php endforeach ?>
				</div>
			<?php endif ?>
		<?php echo $this->Form->end() ?>
	</div>
	
	<?php if (isAjax()): ?>
		<script type="text/javascript">
			$(function(){
				ProductList.init({
					ajaxPaging           : App.getSetting("ajax-paging"),
					ajaxAppend           : App.getSetting("ajax-preloading"),
					ajaxLoadOnScroll     : false,
					maxFilterEntries     : App.getSetting("max-filter-entries"),
					submitFiltersOnChange: false,
					logClicks            : false
				});
			});
		</script>
	<?php endif ?>
<?php endif ?>