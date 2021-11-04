<div class="order-list-page user-page order-page list-page text-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Program partnerski / edycja') ?>
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
						'url'         => getPartnerAdEditUrl($id),
						'type'        => 'file',
						'data-submit' => 'once',
						'class'       => 'form'
					)
				)
			?>
			
			<div class="form-row" data-type="change-partner-add-content" data-container-set="html">
				<label>
					<?php __('Adres odnośnika') ?>
					
					<?php
						echo $this->Html->tag(
							'i',
							'',
							array(
								'class'          => 'fa fa-info-circle',
								'data-toggle'    => 'modal',
								'data-target'    => '#getCodeForLink'
							)
						)
					?>:
				</label>
				
				<?php
					echo $this->Form->input(
						'url',
						array(
							'div'           => false,
							'label'         => false,
							'escape'        => false,
							'class'         => 'form-control',
							'data-activate' => 'true'
						)
					)
				?>
			</div>
			
			<div class="form-row" data-type="change-partner-add-content" data-container-set="html">
				<label>
					<?php __('Zawartość') ?>:
				</label>
				
				<div class="radio-partners">
					<?php
						$checked  = '';
						
						if ($this->data['PartnerAd']['type'] == 1):
							$checked = 'checked="checked"';
						endif;
					?>
					
					<input type="radio" name="data[PartnerAd][type]" value="1" id="PartnerAdType1" <?php echo $checked ?>/>
					
					<label for="PartnerAdType1">
						<?php __('obraz') ?>:
					</label>
					
					<?php if ($this->data['PartnerAd']['type'] == 1):?>
						<div class="file-input-block">
							<?php
								echo $this->Image->resize(
									configuration('PartnerAd.dir').DS.$this->data['PartnerAd']['image'],
									150,
									150
								)
							?>
						</div>
					<?php endif ?>
					
					<div class="file-input-block">
						<?php
							echo __('Zmień', true).': ';
							
							echo $this->Form->file(
								'photo'
							);
						?>
					</div>
				</div>
			</div>
			
			<div class="form-row align-input" data-type="change-partner-add-content" data-container-set="html">
				<div class="radio-partners">
					<?php
						$checked  = '';
						
						if ($this->data['PartnerAd']['type'] == 2):
							$checked = 'checked="checked"';
						endif;
					?>
					
					<input type="radio" name="data[PartnerAd][type]" value="2" id="PartnerAdType2" <?php echo $checked ?>/>
					
					<label for="PartnerAdType2">
						<?php __('tekst') ?>:
					</label>
					
					<?php
						echo $this->Form->input(
							'alias',
							array(
								'div'      => false,
								'label'    => false,
								'escape'   => false,
								'class'    => 'form-control'
							)
						)
					?>
				</div>
			</div>
			
			<?php
				$checked  = '';
				
				if ($this->data['PartnerAd']['type'] == 3):
					$checked = 'checked="checked"';
				endif;
			?>
			
			<div class="form-row align-input" data-type="change-partner-add-content" data-container-set="json">
					<div class="radio-partners">
						<div id="JsonProductContainer" class="autocomplete-container"></div>
						
						<input type="radio" name="data[PartnerAd][type]" value="3" id="PartnerAdContent3" <?php echo $checked ?>/>
						
						<label for="PartnerAdContent3">
							<?php __('Lista produktów (JSON)') ?>:
						</label>
						
						<div data-container-get="json">
							<?php 
								echo $this->Form->input(
									'JSON.count',
									array(
										'type'          => 'text',
										'div'           => 'form-row',
										'label'         => __('Ilość produktów', true).':',
										'class'         => 'form-control number-width-input',
										'escape'        => false
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
							
							<div id="JSONCategoriesAdd" class="align-input">
								<?php if (!empty($this->data['JSON']['category_id'])): ?>
									<?php
										if (!is_array($this->data['JSON']['category_id'])):
											$this->data['JSON']['category_id'] = array($this->data['Filter']['category_id']);
										endif;
									?>
									
									<?php foreach ($this->data['JSON']['category_id'] as $category_id):?>
										<div class="category-json-append">
											<input type="hidden" name="data[JSON][category_id][]" id="JSONCategoryId<?php echo $category_id ?>" value="<?php echo $category_id ?>"/>
											
											<?php echo getCategoryFullName($category_id, ' &#8594; ', true) ?>
											
											<i class="fa fa-times" data-type="remove-json-row"></i>
										</div>
									<?php endforeach ?>
								<?php endif ?>
							</div>
							
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
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>

<div class="modal fade" id="getCodeForLink" tabindex="-1" role="dialog" aria-labelledby="getCodeForLinkLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
				
				<h4 class="modal-title" id="getCodeForLinkLabel">
					<?php __('Własny adres') ?>
				</h4>
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