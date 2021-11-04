<div class="product-box small phrase-preload">
	<span class="category-box">
		<span class="phrase-label">
			<?php __('wyszukiwanie podobne') ?>:
		</span>
		
		<span class="parent-name">
			<?php
				if (preg_match_all('/'.get('term').'/i', $phrase, $matches)):
					foreach ($matches[0] as $match):
						$phrase = str_replace($match, '<span class="highlight">'.$match.'</span>', $phrase);
					endforeach;
				endif;
				
				echo $phrase;
			?>
			<i class="fa fa-caret-right" aria-hidden="true"></i>
		</span>
	</span>
</div>