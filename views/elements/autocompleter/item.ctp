<div class="product-box small">
	<span class="category-box">
		<span class="parent-name">
			<?php
				if (preg_match_all('/'.get('term').'/i', $label, $matches)):
					foreach ($matches[0] as $match):
						$label = str_replace($match, '<span class="highlight">'.$match.'</span>', $label);
					endforeach;
				endif;
				
				echo $label;
			?>
			<i class="fa fa-caret-right" aria-hidden="true"></i>
		</span>
	</span>
</div>