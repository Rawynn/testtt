<div class="product-box small phrase-preload">
	<span class="product-image preload-image" data-loaded="true"></span>
	
	<span class="category-box">
		<span class="phrase-label">
			<?php __('słowo kluczowe') ?>:
		</span>
		
		<span class="parent-name">
			<?php
				if (preg_match_all('/'.get('term').'/i', $tag, $matches)):
					foreach ($matches[0] as $match):
						$tag = str_replace($match, '<span class="highlight">'.$match.'</span>', $tag);
					endforeach;
				endif;
				
				echo $tag;
			?>
		</span>
		<i class="fa fa-caret-right" aria-hidden="true"></i>
	</span>
</div>