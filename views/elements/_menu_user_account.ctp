<?php if (getLoggedUserId()): ?>
	<?php if (!userIsSalesrep() || (userIsSalesrep() && isset($top_menu) && $top_menu)): ?>
		<?php if (!userIsSalesrep()): ?>
			<a class="responsive-toggle" data-type="toggle" href="#UserAccountMenu">
				<?php __('Menu') ?>
			</a>
		<?php endif ?>
		
		<?php if (userIsSalesrep()): ?>
			<?php $group_menu_salesrep = getUserAccountMenu(true) ?>
			
			<ul id="UserAccountMenu" class="user-account-menu menu salerep-menu">
				<?php foreach ($group_menu_salesrep as $k => $section): ?>
					<li>
						<?php $fa_class = $k > 0 ? ($k ==  1 ? 'fa-user-o' : 'fa-cog') : 'fa-clone' ?>
						
						<span class="responsive-toggle"><?php echo $section['title'] ?></span>
						
						<a href="#UserAccountMenu" data-type="toggle">
							<i class="fa <?php echo $fa_class ?>" aria-hidden="true"></i>
						</a>
						
						<?php if (!empty($section['under_menu'])): ?>
							<ul class="under-menu">
								<?php foreach ($section['under_menu'] as $item): ?>
									<li class="<?php echo isset($item['active']) ? 'active' : '' ?>">
										<a href="<?php echo $this->Html->url($item['url']) ?>" title="<?php echo h($item['title']) ?>">
											<?php echo $item['title'] ?>
										</a>
									</li>
								<?php endforeach ?>
								
								<?php if ($k == 2): ?>
									<li>
										<a href="<?php echo $this->Html->url(getUserLogoutUrl()) ?>" title="<?php h(__('Wyloguj')) ?>">
											<?php __('Wyloguj') ?>
										</a>
									</li>
								<?php endif ?>
							</ul>
						<?php endif ?>
					</li>
				<?php endforeach ?>
				
				<li class="salesrep-client">
					<?php
						echo $this->Form->input(
							'user_id',
							array(
								'type'      => 'select',
								'div'       => 'form-row',
								'label'     => __('Wybrany klient', true).':',
								'class'     => 'form-control',
								'options'   => getSalesrepUsersList(false, true),
								'value'     => getCartUserId(),
								'empty'     => __('Wybierz', true),
								'escape'    => false,
								'data-type' => 'salesrep-user-select-header'
							)
						)
					?>
				</li>
			</ul>
		<?php elseif (module('B2B')): ?>
			<?php $group_menu = getUserAccountMenu(true) ?>
			
			<ul id="UserAccountMenu" class="user-account-menu menu nav-justified b2b-menu">
				<?php foreach ($group_menu as $k => $section): ?>
					<li class="<?php echo (Set::matches('/active', $section['under_menu'])) ? 'active' : '' ?>">
						<a href="#" data-type="slidemenu" data-target="<?php echo 'account_'.$k ?>">
							<?php echo $section['title'] ?>
						</a>
						
						<?php if (!empty($section['under_menu'])): ?>
							<div class="under-menu" data-id="<?php echo 'account_'.$k ?>" data-group="subcategory">
								<div class="row">
									<?php foreach ($section['under_menu'] as $item): ?>
										<div class="under-menu-subcategory <?php echo isset($item['active']) ? 'active' : '' ?>">
											<a href="<?php echo $this->Html->url($item['url']) ?>" title="<?php echo h($item['title']) ?>">
												<?php echo $item['title'] ?>
											</a>
										</div>
									<?php endforeach ?>
								</div>
							</div>
						<?php endif ?>
					</li>
				<?php endforeach ?>
			</ul>
		<?php else: ?>
			<ul id="UserAccountMenu" class="user-account-menu menu nav-justified">
				<?php foreach (getUserAccountMenu() as $key => $item): ?>
					<li class="<?php echo isset($item['active']) ? 'active' : '' ?>">
						<a href="<?php echo $this->Html->url($item['url']) ?>" title="<?php echo h($item['title']) ?>">
							<?php echo $item['title'] ?>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
	<?php endif ?>
<?php endif ?>