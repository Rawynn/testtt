<div class="order-list-page user-page order-page list-page text-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Dodaj baner / link') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'PartnerAd',
					array(
						'url'         => getPartnerAdAddUrl(),
						'type'        => 'file',
						'data-submit' => 'once',
						'class'       => 'form'
					)
				)
			?>
				<?php
					echo $this->Form->hidden(
						'PartnerAd.id',
						array(
							'value' => $partner_ad['PartnerAd']['id']
						)
					);
					
					echo $this->Form->input(
						'PartnerAd.locale',
						array(
							'div'     => array(
								'tag'   => 'div',
								'class' => 'form-row'
							),
							'class'   => 'form-control',
							'label'   => __('Wersja językowa', true).':',
							'type'    => 'select',
							'options' => $languages,
							'empty'   => false,
							'value'   => $partner_ad['PartnerAd']['locale']
						)
					);
				?>
				
				<div class="form-row" data-type="change-partner-add-content" data-container-set="html">
					<label>
						<?php __('Zawartość') ?>:
					</label>
					
					<div class="radio-partners">
						<input type="radio" name="data[PartnerAd][content]" value="1" id="PartnerAdContent1" checked="checked"/>
						
						<label for="PartnerAdContent1">
							<?php __('obraz') ?>:
						</label>
						
						<div class="file-input-block">
							<?php echo $this->Form->file('PartnerAd.photo') ?>
						</div>
					</div>
				</div>
				
				<div class="form-row align-input" data-type="change-partner-add-content" data-container-set="html">
					<div class="radio-partners">
						<input type="radio" name="data[PartnerAd][content]" value="2" id="PartnerAdContent2"/>
						
						<label for="PartnerAdContent2">
							<?php __('tekst') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'PartnerAd.link_content',
								array(
									'div'   => false,
									'label' => false,
									'class' => 'form-control'
								)
							)
						?>
					</div>
				</div>
				
				<div class="form-row align-input" data-type="change-partner-add-content" data-container-set="json">
					<div class="radio-partners">
						<div id="JsonProductContainer" class="autocomplete-container"></div>
						
						<input type="radio" name="data[PartnerAd][content]" value="3" id="PartnerAdContent3"/>
						
						<label for="PartnerAdContent3">
							<?php __('Lista produktów (JSON)') ?>:
						</label>
						
						<div data-container-get="json" class="hide">
							<?php
								echo $this->Form->input(
									'JSON.count',
									array(
										'type'   => 'text',
										'div'    => 'form-row',
										'label'  => __('Ilość produktów', true).':',
										'class'  => 'form-control number-width-input',
										'escape' => false
									)
								);
								
								echo $this->Form->input(
									'JSON.category_name',
									array(
										'type'                      => 'text',
										'div'                       => 'form-row',
										'label'                     => __('Kategoria', true).': <i class="fa fa-info-circle" data-tooltip-set="true" data-toggle="tooltip" data-placement="top" title="'.__('Opcjonalnie', true).'"></i>',
										'class'                     => 'form-control',
										'escape'                    => false,
										'data-trigger-autocomplete' => 'autocomplete-select-append',
										'data-ac'                   => 'true',
										'data-ac-url'               => $this->Html->url(getCategoryAutocompleterUrl()),
										'data-ac-handler'           => '#JsonProductContainer',
										'data-ac-extended'          => false,
										'data-render-html'          => 'true'
									)
								);
							?>
							
							<div id="JSONCategoriesAdd" class="align-input"></div>
							
							<?php
								echo $this->Form->input(
									'JSON.width',
									array(
										'type'   => 'text',
										'div'    => 'form-row',
										'label'  => __('Szerkość zdjęć', true).': <i class="fa fa-info-circle" data-tooltip-set="true" data-toggle="tooltip" data-placement="top" title="'.__('Maksymalna szerokość', true).'"></i>',
										'class'  => 'form-control number-width-input',
										'escape' => false
									)
								);
								
								echo $this->Form->input(
									'JSON.height',
									array(
										'type'   => 'text',
										'div'    => 'form-row',
										'label'  => __('Wsokość zdjęć', true).': <i class="fa fa-info-circle" data-tooltip-set="true" data-toggle="tooltip" data-placement="top" title="'.__('Maksymalna wysokość', true).'"></i>',
										'class'  => 'form-control number-width-input',
										'escape' => false
									)
								);
							?>
						</div>
					</div>
				</div>
				
				<div data-container-get="html">
					<div class="form-row" data-type="change-partner-add-link">
						<label>
							<?php __('Adres odnośnika') ?>:
						</label>
						
						<div class="radio-partners">
							<input type="radio" name="data[PartnerAd][link]" value="1" checked="checked" id="PartnerAdLink1"/>
							
							<label for="PartnerAdLink1">
								<?php __('strona główna') ?>
							</label>
						</div>
					</div>
					
					<div class="form-row align-input" data-type="change-partner-add-link">
						<div class="radio-partners">
							<div id="PartnerAdProductNameContainer" class="autocomplete-container"></div>
							
							<input type="radio" name="data[PartnerAd][link]" value="2" id="PartnerAdLink2"/>
							
							<label for="PartnerAdLink2">
								<?php __('strona produktu') ?>
							</label>
							
							<?php
								echo $this->Form->hidden(
									'PartnerAd.product_id'
								);
								
								echo $this->Form->input(
									'PartnerAd.product_name',
									array(
										'div'              => false,
										'label'            => false,
										'class'            =>'form-control',
										'data-ac'          => 'true',
										'data-ac-url'      => $this->Html->url(getProductListUrl()),
										'data-ac-handler'  => '#PartnerAdProductNameContainer',
										'data-ac-extended' => false,
										'data-ac-copy'     => '#PartnerAdProductId'
									)
								);
							?>
						</div>
					</div>
					
					<div class="form-row align-input" data-type="change-partner-add-link">
						<div class="radio-partners">
							<div id="PartnerAdCategoryNameContainer" class="autocomplete-container"></div>
							
							<input type="radio" name="data[PartnerAd][link]" value="3" id="PartnerAdLink3"/>
							
							<label for="PartnerAdLink3">
								<?php __('strona kategorii') ?>:
							</label>
							
							<?php
								echo $this->Form->hidden(
									'PartnerAd.category_id'
								);
								
								echo $this->Form->input(
									'PartnerAd.category_name',
									array(
										'div'              => false,
										'label'            => false,
										'class'            => 'form-control',
										'data-ac'          => 'true',
										'data-ac-url'      => $this->Html->url(getCategoryAutocompleterUrl()),
										'data-ac-handler'  => '#PartnerAdCategoryNameContainer',
										'data-ac-extended' => false,
										'data-ac-copy'     => '#PartnerAdCategoryId',
										'data-render-html' => 'true'
									)
								);
							?>
						</div>
					</div>
					
					<div class="form-row align-input" data-type="change-partner-add-link">
						<div class="radio-partners">
							<input type="radio" name="data[PartnerAd][link]" value="4" id="PartnerAdLink4"/>
							
							<label for="PartnerAdLink4">
								<?php __('Własny adres') ?>
							</label>
							
							<?php
								echo $this->Html->tag(
									'i',
									'',
									array(
										'class'       => 'fa fa-info-circle',
										'data-toggle' => 'modal',
										'data-target' => '#getCodeForLink'
									)
								);
								
								echo $this->Form->input(
									'PartnerAd.url',
									array(
										'div'     => false,
										'label'   => false,
										'default' => Router::url('/', true),
										'class'   => 'form-control'
									)
								)
							?>
							
							<div class="modal fade" id="getCodeForLink" tabindex="-1" role="dialog" aria-labelledby="getCodeForLinkLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
											
											<h4 class="modal-title" id="getCodeForLinkLabel"><?php __('Własny adres') ?></h4>
										</div>
										
										<div class="modal-body">
											<?php
												echo sprintf(
													__('Wprowadzając własny adres strony dodaj na końcu parametr GET %s, aby śledzić statystyki wejść.', true),
													'?partner='.$partner_ad['PartnerAd']['code']
												)
											?>
										</div>
										
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal"><?php __('Zamknij') ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<?php
					echo $this->Form->input(
						'nofollow',
						array(
							'type'      => 'checkbox',
							'div'       => 'form-row checkbox align-input',
							'label'     => __('dodaj parametr rel="nofollow" do linków', true),
							'data-type' => 'partner-ad-nofollow'
						)
					)
				?>
				
				<div class="form-actions align-input">
					<a class="btn-back btn btn-link btn-lg" href="<?php echo $this->Html->url(getPartnersAccountUrl()) ?>" title="<?php echo h(__('Anuluj', true)) ?>">
						<?php __('Anuluj') ?>
					</a>
					
					<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
			
			<hr/>
			
			<?php echo $this->element(TEMPLATE_NAME.DS.'partner_payments'.DS.'payment_search_list') ?>
		</div>
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>

<?php if (!empty($this->data['PartnerAd']['link'])): ?>
	<script type="text/javascript">
		$(function(){
			$("#PartnerAdLink<?php echo  $this->data['PartnerAd']['link'] ?>").click();
		});
	</script>
<?php endif?>

<?php if (!empty($this->data['PartnerAd']['content'])): ?>
	<script type="text/javascript">
		$(function(){
			$("#PartnerAdContent<?php echo  $this->data['PartnerAd']['content'] ?>").click();
		});
	</script>
<?php endif ?>