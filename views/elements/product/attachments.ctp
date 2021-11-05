<div class="product-specification">
	<table class="product-specification-table table table-hover">
		<?php foreach ($attachments as $attachment): ?>
			<tr>
				<td>
					<a href="<?php echo getProductMediumUrl($attachment) ?>" title="<?php echo h($attachment['ProductMedium']['title']) ?>" target="_blank">
						<strong><?php echo $attachment['ProductMedium']['title'].' ('.$attachment['ProductMedium']['filename'].')' ?></strong>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>