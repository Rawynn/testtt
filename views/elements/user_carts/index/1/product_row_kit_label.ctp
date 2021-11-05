<?php if (setting('MODULE_KITS_ADD_KIT_PRODUCTS_TO_CART') && getGlobals('current_kit_id') != $product_kit_id && $product_kit_id): ?>
	<?php setGlobals('current_kit_id', $product_kit_id) ?>
	
	<tr class="product-row kit-row kit-label">
		<?php
			$colspan = 6;
			
			if ($user_is_salesrep):
				if ($default_prices_type == 'netto'):
					$colspan = 12;
				else:
					$colspan = 11;
				endif;
				
				if ($edit_offer_mode):
					$colspan++;//Dla kolumny Nr
				endif;
			endif;
		?>
		
		<td colspan="<?php echo $colspan ?>">
			<h2>
				<?php echo getKitName(getGlobals('current_kit_id')) ?>
			</h2>
		</td>
	</tr>
<?php endif ?>