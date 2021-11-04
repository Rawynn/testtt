<?php if (module('TAGS')): ?>
	<?php if ($tags = getTagsCloud()): ?>
		<section class="tags-box aside-box">
			<a class="responsive-toggle" data-type="toggle" href="#BoxTags">
				<?php __('Tagi') ?>
			</a>
			
			<h2 class="box-header">
				<?php __('Tagi') ?>
			</h2>
			
			<div class="box-content" id="BoxTags">
				<?php foreach ($tags as $tag): ?>
					<a class="tag-item <?php echo $tag['Tag']['class'] ?>" href="<?php echo $this->Html->url(getTagProductsUrl($tag['Tag']['id'])) ?>" title="<?php echo h($tag['Tag']['name']) ?>">
						<?php echo $tag['Tag']['name'] ?>
						
						<?php if (setting('MODULE_TAGS_SHOW_QUANTITIES')): ?>
							<span>
								(<?php echo $tag['Tag']['count'] ?>)
							</span>
						<?php endif ?>
					</a>
				<?php endforeach ?>
			</div>
		</section>
	<?php endif ?>
<?php endif ?>