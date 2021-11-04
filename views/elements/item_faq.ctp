<li>
	<h3>
		<span><?php echo $counter ?></span>. <?php echo $faq['Faq']['question'] ?>
	</h3>
	
	<?php if ($faq['Faq']['answer']): ?>
		<div class="faq-content cms-content">
			<?php echo $faq['Faq']['answer'] ?>
		</div>
	<?php endif ?>
</li>