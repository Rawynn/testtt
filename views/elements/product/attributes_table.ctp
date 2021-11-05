<table class="product-specification-table table">
	<?php
		$leading_check = false;
		
		if (isset($hide_leading)):
			$leading_check = $hide_leading;
		endif;
	?>
	
	<?php foreach ($attributes as $attribute): ?>
		<?php
			/* Jeśli jest flaga leading, to w danych technicznych wpisy są ukrywane */
			if ($leading_check && $attribute['leading']):
				continue;
			endif;
		?>
		<tr>
			<td>
				<?php if ($attribute['description']): ?>
					<?php echo $attribute['name'] ?>
					
					<a data-toggle="modal" role="button" href="#AttributeDescription<?php echo $attribute['id'] ?>" role="button" title="<?php echo h($attribute['name']) ?>">
						<i class="fa fa-info-circle"></i>
					</a>
					
					<div class="modal fade" id="AttributeDescription<?php echo $attribute['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									
									<h2>
										<?php echo $attribute['name'] ?>
									</h2>
								</div>
								
								<div class="modal-body">
									<?php echo $attribute['description'] ?>
								</div>
							</div>
						</div>
					</div>
				<?php else: ?>
					<?php echo $attribute['name'] ?>:
				<?php endif ?>
			</td>
			<td>
				<?php if (count($attribute['elements']) == 1): ?>
					<?php $attribute = reset($attribute['elements']) ?>
					
					
						<?php if ($attribute['indexable'] == 1): ?>
							<a href="<?php echo $this->Html->url(getAttributeValueCanonicalLink(array(), $attribute['ProductsAttributeValue']['attribute_value_id'])) ?>" target="_blank"><?php echo $attribute['ProductsAttributeValue']['name'] ?></a>
						<?php else: ?>
							<?php echo $attribute['ProductsAttributeValue']['name'] ?>
						<?php endif ?>
					
				<?php else: ?>
					<ul>
						<?php foreach ($attribute['elements'] as $element): ?>
							<li>
								
									<?php if ($element['indexable'] == 1): ?>
										<a href="<?php echo $this->Html->url(getAttributeValueCanonicalLink(array(), $element['ProductsAttributeValue']['attribute_value_id'])) ?>"><?php echo $element['ProductsAttributeValue']['name'] ?></a>
									<?php else: ?>
										<?php echo $element['ProductsAttributeValue']['name'] ?>
									<?php endif ?>
								
							</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>