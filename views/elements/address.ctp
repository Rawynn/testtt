<address>
	<?php if ($firstname && $lastname): ?>
		<strong class="highlight">
			<?php echo $firstname.' '.$lastname ?>
		</strong>
		
		<br>
	<?php endif ?>
	
	<?php if ($company): ?>
		<strong class="highlight">
			<?php echo $company ?>
		</strong>
		
		<br>
	<?php endif ?>
	
	<?php if ($nip): ?>
		<abbr title="<?php echo h(__('Numer identyfikacji podatkowej', true)) ?>"><?php __('NIP') ?>:</abbr> <?php echo $nip ?>
		
		<br>
	<?php endif ?>
	
	<?php echo $street ?> <?php echo $street_1 ?> <?php echo $street_2 ? ' / '.$street_2 : '' ?>
	
	<br>
	
	<?php echo $postcode ?>, <?php echo $city ?>
	
	<?php if ($state_name): ?>
		(<?php echo $state_name ?>)
	<?php endif ?>
	
	<br>
	
	<?php echo $country_name ?>
	
	<?php if ($phone): ?>
		<br>
		
		<abbr title="<?php echo h(__('Telefon', true)) ?>"><?php __('Tel') ?>:</abbr> <?php echo $phone ?>
	<?php endif ?>
</address>
