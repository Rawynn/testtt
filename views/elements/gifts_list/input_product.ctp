<?php $next_key = $key + 1 ?>

<div class="autocomplete-container gifts-list-autocomplete" data-next="<?php echo $this->Html->url(getUsersAjaxUrl('ajax_giftslist_product', array('key' => $next_key))) ?>" id="gifts-list-ac-<?php echo $key ?>-container">
	<?php
		echo $this->Form->hidden(
			'Product.'.$key.'.id',
			array(
				'data-type' => 'gifts-list-autocomplete-id',
				'data-key'  => $key
			)
		)
	?>
	
	<?php
		echo $this->Form->input(
			'Product.'.$key.'.name',
			array(
				'type'             => 'text',
				'data-type'        => 'autocomplete',
				'data-ac'          => 'true',
				'data-ac-url'      => $this->Html->url(getUserCartAutocompleterUrl()),
				'data-ac-handler'  => '#gifts-list-ac-'.$key.'-container',
				'data-ac-extended' => 'false',
				'data-ac-copy'     => '[data-type=gifts-list-autocomplete-id][data-key="'.$key.'"]',
				'label'            => false,
				'div'              => false,
				'class'            => 'form-control'
			)
		)
	?>
	
	<a class="delete-product delete <?php echo $show_delete ? '' : 'hide' ?>" data-type="delete-product" href="#">&times;</a>
</div>