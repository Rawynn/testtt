<?php if (module('BOX_CONTACT')): ?>
	<?php
		$email      = setting('GLOBAL_EMAIL_CONTACT');
		
		$phone1     = setting('GLOBAL_CONTACT_PHONE_1');
		$phone2     = setting('GLOBAL_CONTACT_PHONE_2');
		
		$gg1        = setting('GLOBAL_CONTACT_GG_1');
		$gg2        = setting('GLOBAL_CONTACT_GG_2');
		
		$skype1     = setting('GLOBAL_CONTACT_SKYPE_1');
		$skype2     = setting('GLOBAL_CONTACT_SKYPE_2');
		
		$gg_link    = setting('MODULE_BOX_CONTACT_LINK_GG');
		$skype_link = setting('MODULE_BOX_CONTACT_LINK_SKYPE');
	?>
	
	<section class="contact-box aside-box">
		<a class="responsive-toggle" data-type="toggle" href="#<?php echo isset($id) ? $id : 'ContactBox' ?>">
			<?php __('Kontakt') ?>
		</a>
		
		<h2 class="box-header">
			<?php __('Kontakt') ?>
		</h2>
		
		<div class="box-content" id="<?php echo isset($id) ? $id : 'ContactBox' ?>">
			<h3>
				<?php __('Potrzebujesz pomocy?') ?>
			</h3>
			
			<table class="contact-table">
				<?php if ($phone1 || $phone2): ?>
					<tr>
						<td class="contact-icon">
							<div>
								<i class="sprite sprite-tel"></i>
							</div>
						</td>
						<td class="contact-value">
							<?php if ($phone1): ?>
								<span><?php echo $phone1 ?></span>
							<?php endif ?>
							
							<?php if ($phone2): ?>
								<span><?php echo $phone2 ?></span>
							<?php endif ?>
						</td>
					</tr>
				<?php endif ?>
				
				<?php if ($email): ?>
					<tr>
						<td class="contact-icon">
							<div>
								<i class="sprite sprite-mail"></i>
							</div>
						</td>
						<td class="contact-value">
							<?php echo $this->Html->link($email, 'mailto:'.$email) ?>
						</td>
					</tr>
				<?php endif ?>
				
				<?php if ($skype1 || $skype2): ?>
					<tr>
						<td class="contact-icon">
							<div>
								<i class="fa fa-skype"></i>
							</div>
						</td>
						<td class="contact-value">
							<?php if ($skype1): ?>
								<span>
									<?php
										if ($skype_link):
											echo $this->Html->link(
												$skype1,
												'skype:'.$skype1
											);
										else:
											echo $skype1;
										endif;
									?>
								</span>
							<?php endif ?>
							
							<?php if ($skype2): ?>
								<span>
									<?php
										if ($skype_link):
											echo $this->Html->link(
												$skype2,
												'skype:'.$skype2
											);
										else:
											echo $skype2;
										endif;
									?>
								</span>
							<?php endif ?>
						</td>
					</tr>
				<?php endif ?>
				
				<?php if ($gg1): ?>
					<tr>
						<td class="contact-icon">
							<div class="gg-status-icon">
								<?php
									echo $this->Html->image(
										(isSsl() ? 'https' : 'http').'://status.gadu-gadu.pl/users/status.asp?id='.$gg1.'&amp;styl=5',
										array(
											'alt' => $gg1
										)
									)
								?>
							</div>
						</td>
						<td class="contact-value">
							<span>
								<?php
									if ($gg_link):
										echo $this->Html->link(
											$gg1,
											'gg:'.$gg1
										);
									else:
										echo $gg1;
									endif;
								?>
							</span>
						</td>
					</tr>
				<?php endif ?>
				
				<?php if ($gg2): ?>
					<tr>
						<td class="contact-icon">
							<div class="gg-status-icon">
								<?php
									echo $this->Html->image(
										(isSsl() ? 'https' : 'http').'://status.gadu-gadu.pl/users/status.asp?id='.$gg2.'&amp;styl=5',
										array(
											'alt' => $gg2
										)
									)
								?>
							</div>
						</td>
						<td class="contact-value">
							<span>
								<?php
									if ($gg_link):
										echo $this->Html->link(
											$gg2,
											'gg:'.$gg2
										);
									else:
										echo $gg2;
									endif;
								?>
							</span>
						</td>
					</tr>
				<?php endif ?>
			</table>
		</div>
	</section>
<?php endif ?>