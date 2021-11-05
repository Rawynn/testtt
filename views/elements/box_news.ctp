<?php if (module('NEWS')): ?>
	<?php if ($news = getLastNews(2)): ?>
		<section class="news-box aside-box">
			<h2 class="box-header">
				<a href="<?php echo $this->Html->url(getNewsIndexUrl()) ?>" title="<?php echo h(__('Aktualności', true)) ?>">
					<?php __('Aktualności') ?>
				</a>
				
				<?php if (setting('MODULE_NEWS_LINK_ARCHIVE')): ?>
					<a class="archive" href="<?php echo $this->Html->url(getNewsIndexUrl()) ?>" title="<?php echo h(__('Pokaż wszystkie', true)) ?>">
						<?php __('Pokaż wszystkie') ?> <i class="fa fa-chevron-right"></i>
					</a>
				<?php endif ?>
			</h2>
			
			<a class="responsive-toggle" data-type="toggle" href="#<?php echo isset($id) ? $id : 'BoxNews' ?>">
				<?php __('Aktualności') ?>
			</a>
			
			<div class="box-content" id="<?php echo isset($id) ? $id : 'BoxNews' ?>">
				<ul class="news-list">
					<?php foreach ($news as $news_item): ?>
						<?php
							echo $this->element(
								TEMPLATE_NAME.DS.'item_news',
								array(
									'news'       => $news_item,
									'show_intro' => true
								)
							)
						?>
					<?php endforeach ?>
				</ul>
			</div>
		</section>
	<?php endif ?>
<?php endif ?>