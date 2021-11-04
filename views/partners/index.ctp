<div class="order-list-page order-page list-page text-page page">
	
	
	<div class="page-header">
		<h1>
			<?php __('Program partnerski') ?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($partner_ads): ?>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Banner / link') ?>
							</th>
							<th>
								<?php __('Ilość wyświetleń') ?>
							</th>
							<th>
								<?php __('Ilość kliknięć') ?>
							</th>
							<th>
								<?php __('Ilość zamówień')?>
							</th>
							<th class="center">
								<?php __('Opcje')?>
							</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach ($partner_ads as $key => $partner_ad): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Banner / link') ?>:
									</span>
									
									<?php if (!empty($partner_ad['PartnerAd']['json'])): ?>
										<span class="short-product-desc">
											<?php if ($products = unserialize($partner_ad['PartnerAd']['json'])): ?>
												<strong>
													<?php __('Kategorie') ?>:
												</strong>
												
												<?php
													$categories = array();
													
													if (!empty($products['category_id'])):
														foreach ($products['category_id'] as $category_id):
															$categories[] = getCategoryFullName($category_id, ' &#8594; ', true);
														endforeach;
													endif;
													
													echo $categories ? implode(', ', array_unique($categories)) : '-';
												?>
												
												<p>
													<strong><?php __('Ilość produktów:') ?></strong> <?php echo $products['count'] ?>
												</p>
											<?php endif ?>
										</span>
									<?php else: ?>
										<?php 
											preg_match_all("#<a(.*?)>(.*?)</a>#s", $partner_ad['PartnerAd']['html'], $link);
											preg_match_all("#<img(.*?)/>#s", $link[2][0], $img);
											
											$alias = str_replace($img[0][0], '', $link[2][0]);
											
											if ($alias):
												echo $alias;
											else:
												echo $this->Image->resize(
													configuration('PartnerAd.dir').DS.(!empty($partner_ad['PartnerBanner']['filename']) ? $partner_ad['PartnerBanner']['filename'] : $partner_ad['PartnerAd']['filename']),
													100,
													100
												);
											endif;
										?>
									<?php endif ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Il. wyświetleń') ?>:
									</span>
									
									<?php echo $partner_ad['PartnerAd']['views'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Il. kliknięć') ?>:
									</span>
									
									<?php echo $partner_ad['PartnerAd']['clicks'] ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Il. zamówień') ?>:
									</span>
									
									<?php echo $partner_ad['PartnerAd']['purchases'] ?>
								</td>
								<td class="table-options table-options-links">
									<?php
										if (setting('MODULE_PARTNERSHIP_ALLOW_SELF_BANNERS_MANAGEMENT')):
											if ($partner_ad['PartnerAd']['partner_banner_id'] == 0):
												echo $this->Html->link(
													$this->Html->icon('edit'),
													getPartnerAdEditUrl($partner_ad['PartnerAd']['id']),
													array(
														'escape' => false
													)
												);
											endif;
											
											if ($partner_ad['PartnerAd']['partner_banner_id'] == 0):
												echo $this->Html->link(
													$this->Html->icon('remove'),
													'#DeleteBanerLink',
													array(
														'escape'          => false,
														'data-toggle'     => 'modal',
														'data-type'       => 'delete-baner-link',
														'data-target-url' => $this->Html->url(getPartnerAdDeleteUrl($partner_ad['PartnerAd']['id'])),
														'title'           => h(__('Usuń', true))
													)
												);
											endif;
											
										endif;
										
										echo $this->Html->link(
											$this->Html->icon('download'),
											'#DownloadBannerCode'.$partner_ad['PartnerAd']['id'],
											array(
												'escape' => false,
												'data-toggle' => 'modal',
												'title' => h(__('Pobierz kod banera', true))
											)
										);
									?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<?php foreach ($partner_ads as $partner_ad): ?>
					<div class="modal fade" id="DownloadBannerCode<?php echo $partner_ad['PartnerAd']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									
									<h2>
										<?php __('Pobierz kod banera') ?>
									</h2>
								</div>
								
								<div class="modal-body">
									<?php echo htmlentities($partner_ad['PartnerAd']['html']) ?>
								</div>
								
								<div class="modal-footer modal-actions">
									<a class="btn-next btn btn-primary btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
										<?php __('Zamknij') ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
				
				<div class="modal fade" id="DeleteBanerLink" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								
								<h2>
									<?php __('Usuń baner') ?>
								</h2>
							</div>
							
							<div class="modal-body">
								<p class="text-center">
									<?php __('Czy na pewno chcesz usunąć wybrany baner?') ?>
								</p>
							</div>
							
							<div class="modal-footer modal-actions">
								<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
									<?php __('Nie') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="delete-baner-link-target" href="#">
									<?php __('Tak') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => sprintf(
								__('Brak wpisów. <br>%s aby dodać nowy baner/link.', true), $this->Html->link(__('Kliknij', true), getPartnerAdAddUrl())
							)
						)
					)
				?>
			<?php endif ?>
			
			<hr/>
			
			<?php echo $this->element(TEMPLATE_NAME.DS.'partner_payments'.DS.'payment_search_list');?>
		</div>
		
		<div class="page-sidebar">
			<?php if (setting('MODULE_PARTNERSHIP_ALLOW_SELF_BANNERS_MANAGEMENT')): ?>
				<a class="btn btn-primary btn-lg btn-block" href="<?php echo $this->Html->url(getPartnerAdAddUrl()) ?>" title="<?php echo h(__('Dodaj baner/link', true)) ?>">
					<?php __('Dodaj baner/link') ?>
				</a>
				
				<hr>
			<?php endif ?>
			
			<?php
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>