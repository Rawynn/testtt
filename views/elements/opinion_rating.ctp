<span class="<?php echo isset($class) ? $class.' rating' : 'rating' ?> <?php echo $input ? 'rating-input' : '' ?>" data-type="<?php echo $input ? 'change-rating' : '' ?>">
	<?php for ($i = 1; $i <= 5; $i++): ?>
		<?php if ($input): ?>
			<a class="rating-item <?php echo $i <= $note ? 'selected' : '' ?>" data-type="rating-item" data-rating="<?php echo $input ? $i : '' ?>" href="#" title=""></a>
		<?php else: ?>
			<span class="rating-item <?php echo $i <= $note ? 'selected' : '' ?>" data-type="rating-item" data-rating="<?php echo $input ? $i : '' ?>"></span>
		<?php endif ?>
	<?php endfor ?>
</span>

<?php if (isset($google_meta) && $google_meta['count'] > 0): ?>
	<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<meta itemprop="reviewCount" content="<?php echo $google_meta['count'] ?>">
		<meta itemprop="ratingValue" content="<?php echo $google_meta['average'] ?>">
		<meta itemprop="itemReviewed" content="<?php echo h($google_meta['item']) ?>">
	</div>
<?php endif ?>
