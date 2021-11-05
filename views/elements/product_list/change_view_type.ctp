<?php
	$view_types = array(
		'gallery' => setting('MODULE_LIST_GALLERY'),
		'list'    => setting('MODULE_LIST_LIST'),
		'details' => setting('MODULE_LIST_DETAILS')
	)
?>

<div data-type="product-listing-view-type" class="product-listing-view-type form-row">
	<?php if (array_sum($view_types) > 1): ?>
		<div class="btn-group">
			<?php if ($view_types['gallery']): ?>
				<a class="btn <?php echo $products_list_view == 'products_list_item_gallery' ? 'active' : '' ?>" href="<?php echo $this->Html->url(getChangeProductsViewUrl('gallery')) ?>" title="<?php echo h(__('Galeria', true)) ?>">
					<i class="sprite sprite-widok_1"></i>
				</a>
			<?php endif ?>
			
			<?php if ($view_types['list']): ?>
				<a class="btn <?php echo $products_list_view == 'products_list_item_list' ? 'active' : '' ?>" href="<?php echo $this->Html->url(getChangeProductsViewUrl('list')) ?>" title="<?php echo h(__('Lista', true)) ?>">
					<i class="fa fa-align-justify"></i>
				</a>
			<?php endif ?>
			
			<?php if ($view_types['details'] && !isMobile()): ?>
				<a class="btn <?php echo $products_list_view == 'products_list_item_details' ? 'active' : '' ?>" href="<?php echo $this->Html->url(getChangeProductsViewUrl('details')) ?>" title="<?php echo h(__('Szczegóły', true)) ?>">
					<i class="sprite sprite-widok_2"></i>
				</a>
			<?php endif ?>
		</div>
	<?php endif ?>
</div>