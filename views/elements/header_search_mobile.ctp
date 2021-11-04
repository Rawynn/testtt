<?php if (module('SEARCH')): ?>
	<?php
		echo $this->Form->create(
			'Product',
			array(
				'url'         => getProductsSearchUrl(),
				'type'        => 'get',
				'secure'      => false,
				'data-submit' => 'once',
				'id'          => 'ProductSearchForm2'
			)
		)
	?>
		<div class="input-container" id="InputContainer2">
			<span class="loop-holder">
				<i class="sprite sprite-loop"></i>
			</span>
			
			<?php
				$is_autocomplete  = isProductsAutocompleterEnabled();
				$autocomplete_url = getProductAutocompleterUrl();
				
				if (setting('GLOBAL_EXTENDED_PRODUCTS_AUTOCOMPLETER')):
					$autocomplete_url = getExtendedAutocompleterUrl();
				endif;
				
				echo $this->Form->input(
					'q',
					array(
						'type'             => 'text',
						'data-ac'          => $is_autocomplete ? 'true' : 'false',
						'data-ac-url'      => $is_autocomplete ? $this->Html->url($autocomplete_url) : '',
						'data-ac-handler'  => $is_autocomplete ? '#InputContainer2' : '',
						'data-ac-extended' => setting('GLOBAL_EXTENDED_PRODUCTS_AUTOCOMPLETER') ? 'true' : 'false',
						'div'              => false,
						'label'            => false,
						'value'            => getPageParamValue('q'),
						'class'            => 'form-control',
					)
				)
			?>
			
			<a class="submit js-submit" href="#" title="<?php echo h(__('szukaj', true)) ?>">
				<?php __('szukaj')?>
			</a>
		</div>
		
		<?php
			/* echo $this->Form->input(
				'desc',
				array(
					'type'        => 'checkbox',
					'div'         => 'search-options checkbox',
					'label'       => __('Szukaj także w opisach', true),
					'value'       => getPageParamValue('desc'),
					'checked'     => getPageParamValue('desc') ? true : false,
					'hiddenField' => false
				)
			) */
		?>
	<?php echo $this->Form->end() ?>
<?php endif ?>