<div class="header-top">
	<div class="container">
		<div class="contact-info">
			<span><strong><?php __('DARMOWA DOSTAWA OD 150 ZŁ')?></strong></span>
			<span class="squer"></span>
			<span><strong><?php __('30 DNI NA ZWROT TOWARU')?></strong></span>
		</div>
		
		<div class="navbar">
			<ul>
				<?php if ($phone = setting('GLOBAL_CONTACT_PHONE_1')): ?>
					<li class="phone">
						<i class="sprite sprite-phone"></i> <?php echo $phone ?>
					</li>
					<li class="time">
						<?php __('P<small>ON</small>-P<small>T</small> 9<sup>00</sup>-17<sup>00</sup>')?>
					</li>
				<?php endif ?>
				<li class="language_select">
					<?php
						$allLanguages = getAllLanguages();
						$current_url = getCurrentUrl();
						$currentCountry = getCurrentCountryName();
						
						if (empty($currentCountry)):
							$currentCountry = 'Polska';
						endif;
					?>
					<span class="squer"></span>
					<div class="transform-select-wrapper transform-wrapper">
						<div class="transform-select transform-input">
							<?php foreach ( $allLanguages as $allLanguage ) : ?>
								<?php if($allLanguage['Language']['active']):?>
								<span class="<?php echo $current_url['language'] != $allLanguage['Language']['locale'] ? 'hide' : ''; ?>">
									<?php if ( file_exists(IMAGES.Configure::read('Lang.dir').DS.$allLanguage['Language']['id']) ) : ?>
										<?php
											echo $this->Html->image(
												Configure::read('Lang.dir').'/'.$allLanguage['Language']['id'],
												array(
													'class' => $current_url['language'] != $allLanguage['Language']['locale'] ? 'hide' : '',
													'title' => __('Język: ', true).$allLanguage['Language']['name']
												)
											);
										?>
									<?php else : ?>
										<?php echo ucfirst($allLanguage['Language']['language']); ?>
									<?php endif; ?>
								</span>
								<?php endif;?>
							<?php endforeach; ?>
							<a class="transform-open"></a>
						</div>
						<ul class="transform-select-list">
							<?php foreach ( $allLanguages as $allLanguage ) : ?>
								<?php
									$url = $current_url;
									$url['language'] = $allLanguage['Language']['locale'];
									$s = '';
									if ( setting('GLOBAL_SSL_EXTENDED') ) {
										$s = 's';
									}
									 if ( $allLanguage['Language']['domain'] ) :
										$lang_domain = $allLanguage['Language']['domain'];
									else :
										$lang_domain = 'www.peripetie.cz';
									endif;
									$url_lang = array(
										'controller' => $this->params['controller'],
										'action' => $this->params['action']
									);
									if (isset($this->params['pass']) && !empty($this->params['pass'])):
										$url_lang = array_merge($url_lang, $this->params['pass']);
									endif;
									
									if (!isProductShowView()):
										$url_params = $this->params['url'];
										unset($url_params['url']);
										if ($url_params != null):
											$url_lang['?'] = $url_params;
										endif;
									endif;
									
									if (isProductListIndexView()) :
										$store_id = getStoreIdFromDomain($allLanguage['Language']['domain']);
										$category_parent = getCategoryParentId($category['Category']['id']);
										$category['Category']['name'];
									endif;
									if ($allLanguage['Language']['domain'] && Configure::read('Config.store_id') && $url_lang['controller'] == 'products' && $url_lang['action'] == 'index' && !empty($url_lang[0]) && !empty($category)):
										/* Jest kategoria i MultiStore - szukam odpowiedniego w drugim sklepie */
										$store_id = getStoreIdFromDomain($allLanguage['Language']['domain']);
										if ($store_id):
											if ($category_id = getExternalAtomId('MODULE_MULTISTORE', $store_id.'_'.$url_lang[0], 'Category')):
												$url_lang[0] = $category_id;
											elseif ($category_id = getExternalId('MODULE_MULTISTORE', $url_lang[0], 'Category')):
												$url_lang[0] = array_pop(explode('_', $category_id));
											endif;
										endif;
									endif;
									$url_lang['language'] = $allLanguage['Language']['locale'];
									$url_lang_ = $this->Html->url(generateFriendlyLink($url_lang));
									$full_domain = 'http'.$s.'://'.$lang_domain.$url_lang_;
								?>
								<?php if($allLanguage['Language']['active']):?>
								<li>
									<a 
										<?php /*href="<?php echo $this->Html->url(generateFriendlyLink($full_domain)); ?>" */?>
										href="<?php echo $full_domain; ?>"
										title="<?php echo __('Zmień język na ', true).$allLanguage['Language']['name']; ?>"
										class="<?php echo $current_url['language'] == $allLanguage['Language']['locale'] ? 'current' : ''; ?>"
									>
									
									<?php if ( file_exists(IMAGES.Configure::read('Lang.dir').DS.$allLanguage['Language']['id']) ) : ?>
										<?php
											echo $this->Html->image(
												Configure::read('Lang.dir').'/'.$allLanguage['Language']['id'],
												array(
													'class' => 'language_icon',
													'title' => __('Język: ', true).$allLanguage['Language']['name']
												)
											);
										?>
									<?php else: ?>
										<span class="language_icon">
											<?php echo $allLanguage['Language']['language']; ?>
									</span>
									<?php endif; ?>
									</a>
								</li>
								<?php endif;?>
							<?php endforeach; ?>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<script>
		$(function () {
			/* change language and currency */
			$('.language_select .transform-select').click(function(e){
				e.stopPropagation();
				$(this).next('ul').toggle();
			});
			$('.language_select .transform-select').click(function(e){
				e.stopPropagation();
			});
			$('body,html, .language_select .transform-select').click(function(e){
				$('.language_select .transform-select').not(this).next('ul').hide();
			});
		});
	</script>
</div>