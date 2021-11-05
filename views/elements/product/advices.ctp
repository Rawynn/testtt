<ul class="product-advices cms-content">
	<?php foreach ($advices as $advice): ?>
		<li>
			<h2>
				<?php echo $advice['Advice']['title'] ?>
			</h2>
			
			<?php echo $advice['Advice']['content'] ?>
		</li>
	<?php endforeach ?>
</ul>