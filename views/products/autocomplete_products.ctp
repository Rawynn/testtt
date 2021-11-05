<?php
	if ($products):
		$json       = array();
		$get_params = array();
		
		if ($campaign_id = getSectionCampaignId('list-search')):
			$get_params['campaign-id'] = $campaign_id;
			
			addCampaignViewBox($campaign_id);
		endif;
		
		foreach ($products as $id => $name):
			$json[] = array(
				'value' => $name,
				'url'   => $this->Html->url(getProductUrl($id, $get_params)),
				'label' => $this->element(
					TEMPLATE_NAME.DS.'extended_autocomplete_item',
					array(
						'product_id'   => $id,
						'product_name' => $name
					)
				)
			);
		endforeach;
		
		echo json_encode($json);
	endif;
?>