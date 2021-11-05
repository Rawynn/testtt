<div class="product-box small phrase-preload">
	<span class="category-box">
		<span class="phrase-label">
			<?php echo $attribute ?>:
		</span>
		
		<span class="parent-name">
			<?php
				if (preg_match_all('/'.get('term').'/i', $name, $matches)):
					foreach ($matches[0] as $match):
						$name = str_replace($match, '<span class="highlight">'.$match.'</span>', $name);
					endforeach;
				endif;
				
				echo $name;
			?>
			<i class="fa fa-caret-right" aria-hidden="true"></i>
		</span>
	</span>
</div>