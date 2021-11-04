<?php if (showCookieInfo()): ?>
	<div class="cookie-message">
		<div class="container">
			<div class="cookie-message-inner <?php echo setting('MODULE_RODO_EXTERNAL_MARKETING_CODES_REQUIRE_PERMISSIONS') ? 'cookie-message-inner-rodo' : '' ?>">
				<div class="cookie-desc-information">
					<p>
						<?php __('Polityka prywantności') ?>:
					</p>
					
					<p>
						<?php
							echo sprintf(
								__('Nasz sklep internetowy używa informacji zapisanych za pomocą plików Cookies, między innymi w celu umożliwienia logowania do systemu, zapewnienia prawidłowego działania schowka, koszyka i mechanizmu składania zamówień, statystyk oraz dostosowania strony do preferencji użytkownika. Więcej informacji - w tym pomoc jak zablokować cookies na naszej stronie - znajdą Państwo %s.', true),
								$this->Html->link(__('w polityce prywatności', true), getStaticPageUrl(9))
							)
						?>
					</p>
				</div>
				
				<a class="close" href="<?php echo $this->Html->url(getAcceptCookiesUrl()) ?>" title="<?php echo h(__('Rozumiem, zamknij', true)) ?>">
					<?php __('Ok Rozumiem') ?>
				</a>
				
				<?php if (setting('MODULE_RODO_EXTERNAL_MARKETING_CODES_REQUIRE_PERMISSIONS')): ?>
					<a data-toggle="modal" href="#RodoCookiesInfo" role="button" class="cookies-info-link" title="<?php echo h(__('Prywatność', true)) ?>">
						<?php __('Prywatność') ?>
					</a>
				<?php endif ?>
			</div>
		</div>
	</div>
	
	<?php if (setting('MODULE_RODO_EXTERNAL_MARKETING_CODES_REQUIRE_PERMISSIONS')): ?>
		<div class="modal fade" id="RodoCookiesInfo" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						
						<h2>
							<?php __('Ustawienia plików Cookie') ?>
						</h2>
					</div>
					
					<div class="modal-body form">
						<?php
							echo $this->Form->input(
								'Cookie.system',
								array(
									'div'      => 'form-row checkbox',
									'type'     => 'checkbox',
									'label'    => __('Pliki cookie związane z funkcjonalnością', true),
									'class'    => 'form-control',
									'disabled' => 'disabled',
									'checked'  => true
								)
							)
						?>
						
						<div class="form-row">
							<?php __('Są zawsze włączone, ponieważ umożliwiają podstawowe działanie strony. Są to między innymi pliki cookie pozwalające pamiętać użytkownika w ciągu jednej sesji lub, zależnie od wybranych opcji, z sesji na sesję. Ich zadaniem jest umożliwienie działania koszyka i procesu realizacji zamówienia, a także pomoc w rozwiązywaniu problemów z zabezpieczeniami i w przestrzeganiu przepisów.') ?>
						</div>
						
						<?php
							echo $this->Form->input(
								'Cookie.marketing',
								array(
									'div'       => 'form-row checkbox',
									'type'      => 'checkbox',
									'label'     => __('Pliki cookie związane z serwisami społecznościowymi i treściami reklamowymi', true),
									'class'     => 'form-control',
									'checked'   => isset($_COOKIE['AtomStore']['MARKETING_COOKIES_ACCEPTED']) ? (bool) $_COOKIE['AtomStore']['MARKETING_COOKIES_ACCEPTED'] : true,
									'data-type' => 'cookie-marketing-enable'
								)
							)
						?>
						
						<div class="form-row">
							<?php echo sprintf(__('Pliki cookies związane z funkcjami społecznościowymi pozwalają łączyć się z serwisami społecznościowymi i udostępniać w nich treści z witryny %s. Pliki cookie związane z treściami reklamowymi (należące do stron trzecich) gromadzą informacje, dzięki którym reklamy zarówno na stronie %s jak i poza nią są zgodne z zainteresowaniami użytkowników. W niektórych przypadkach te pliki cookie wykorzystywane są do przetwarzania danych osobowych. Więcej informacji na temat przetwarzania danych osobowych można znaleźć w %s. Wyłączenie tych plików cookie może spowodować wyświetlanie reklam niezgodnych z zainteresowaniami użytkownika. Mogą też wystąpić błędy podczas łączenia się z serwisami Facebook, Twitter lub innymi serwisami społecznościowymi oraz podczas udostępniania treści w serwisach społecznościowych.', true), $_SERVER['SERVER_NAME'], $_SERVER['SERVER_NAME'], $this->Html->link(__('polityce prywatności', true), getStaticPageUrl(9), array('target' => '_blank'))) ?>
						</div>
					</div>
					
					<div class="modal-footer modal-actions">
						<a class="btn-next btn btn-primary btn-lg" href="#" data-dismiss="modal" aria-hidden="true">
							<?php __('Gotowe') ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>
