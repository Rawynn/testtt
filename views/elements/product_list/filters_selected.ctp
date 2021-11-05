<div data-type="current-filters">
	<?php if ($filters = getUserProductListFilters()): ?>
		<div class="product-listing-selected-filters">
			<?php foreach ($filters as $filter): ?>
				<?php if ($filter['value']): ?>
					<span class="filter-label">
						<?php echo $filter['label'].': '.$filter['value'] ?>
						
						<a class="close" href="<?php echo $this->Html->url($filter['url']) ?>" title="<?php echo h(__('Usuń filtrowanie', true)) ?>">&times;</a>
					</span>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	<?php endif ?>
</div>