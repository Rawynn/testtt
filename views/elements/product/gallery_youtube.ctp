<?php if ($gallery): ?>
	<?php
		$protocol = 'http';
		
		if (isSsl()):
			$protocol .= 's';
		endif;
		
		foreach ($gallery as $id => $data):
			$json[] = array(
				'youtube'   => $id,
				'href'      => $protocol.'://www.youtube.com/watch?v='.$id,
				'title'     => $data['title'] ? $data['title'] : $product_name,
				'type'      => 'text/html',
				'poster'    => $protocol.'://img.youtube.com/vi/'.$id.'/hqdefault.jpg',
				'thumbnail' => $protocol.'://img.youtube.com/vi/'.$id.'/1.jpg'
			);
		endforeach;
	?>
	
	<div class="product-youtube-gallery <?php echo $gallery_indicators ? 'carousel-indicators-true' : '' ?>">
		<a class="btn" data-type="product-youtube-gallery" data-yt='<?php echo json_encode($json) ?>' href="#">
			<?php __('Zobacz video') ?>
		</a>
	</div>
<?php endif ?>