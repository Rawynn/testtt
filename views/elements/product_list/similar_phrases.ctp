<?php if ($phrase): ?>
	<div class="similar-phrases" data-type="ajax-load" data-load-url="<?php echo $this->Html->url(getProductsSimilarPhrasesUrl($phrase)) ?>" data-load-type="onscroll" data-load-offset="50" data-loaded="false">
		<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
	</div>
<?php endif ?>