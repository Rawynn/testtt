<?php
	$json       = array();
	$get_params = array(
		'q' => get('term')
	);
	
	if ($campaign_id = getSectionCampaignId('list-search')):
		$get_params['campaign-id'] = $campaign_id;
		
		addCampaignViewBox($campaign_id);
	endif;
	
	foreach ($extended_data as $search_model => $values):
		if (!empty($values)):
			foreach ($values as $value):
				$url = $this->Html->url(
					getProductsSearchUrl(
						array(
							'q' => $value['name']
						)
					)
				);
				
				if ($search_model == 'Attribute'):
					if ($value['attribute_indexable']):
						$url = $this->Html->url(getAttributeValueCanonicalLink(array(), $value['attribute_value_id']));
					else:
						$url = $this->Html->url(
							getProductsSearchUrl(
								array(
									'at'  => array(
										$value['attribute_id'] => $value['attribute_value_id']
									),
									'red' => 0
								)
							)
						);
					endif;
				endif;
				
				$label           = $value['name'];
				$autocompl_value = $value['name'];
				
				if ($search_model == 'Product'):
					$url   = $this->Html->url(getProductUrl($value['id'], $get_params));
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'product',
						array(
							'product_id'   => $value['id'],
							'product_name' => $value['name']
						)
					);
				elseif ($search_model == 'Producer'):
					$url   = $this->Html->url(getProducerProductsUrl($value['id'], $get_params));
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'producer',
						array(
							'producer_id'   => $value['id'],
							'producer_name' => $value['name']
						)
					);
				elseif ($search_model == 'Category'):
					$url   = $this->Html->url(getCategoryUrl($value['id'], $get_params));
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'category',
						array(
							'category_id'   => $value['id'],
							'category_logo' => $value['logo'],
							'category_name' => $value['name'],
							'parent_name'   => $value['parent_name']
						)
					);
				elseif ($search_model == 'Phrase'):
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'phrase',
						array(
							'phrase' => $value['name']
						)
					);
				elseif ($search_model == 'Attribute'):
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'attribute',
						array(
							'name'      => $value['name'],
							'attribute' => $value['attribute_name']
						)
					);
				elseif ($search_model == 'Tag'):
					$url   = $this->Html->url(getTagProductsUrl($value['id'], $get_params));
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'tag',
						array(
							'tag' => $value['name']
						)
					);
				else:
					$label = $this->element(
						TEMPLATE_NAME.DS.'autocompleter'.DS.'item',
						array(
							'label'   => $label
						)
					);
				endif;
				
				$json[] = array(
					'value' => $autocompl_value,
					'url'   => htmlspecialchars_decode($url),
					'label' => $label
				);
			endforeach;
		endif;
	endforeach;
	
	echo json_encode($json);
?>