<?php
	/* Ustawienia Paginatora - NIE USUWAĆ!!! */
	$this->element('_default'.DS.'paginator_index_options')
?>

<?php if ($this->Paginator): ?>
	<?php if ($this->Paginator->numbers()): ?>
		<div class="pagination <?php echo isset($class) ? $class : '' ?>" data-loaded="true">
			<?php if (isset($append) && $append): ?>
				<?php
					list($limit, $total) = getProductListPaginatorLimits();
					
					echo $this->Paginator->next(
						sprintf(
							__('Załaduj następne %s z %s produktów', true).
							$this->Html->tag(
								'i',
								'',
								array(
									'class' => 'fa fa-caret-right'
								)
							),
							$limit,
							$total
						),
						array(
							'class'     => 'btn btn-primary',
							'data-type' => 'load-next',
							'escape'    => false
						),
						null,
						array(
							'class'  => 'hide disabled',
							'escape' => false
						)
					);
				?>
			<?php else: ?>
				<ul>
					<?php
						echo $this->Html->tag(
							'li',
							$this->Paginator->prev(
								'',
								array(
									'escape' => false
								),
								null,
								array(
									'class'  => 'disabled',
									'escape' => false
								)
							),
							array(
								'class' => 'pagination-prev'
							)
						);
						
						echo $this->Paginator->numbers(
							array(
								'separator' => '',
								'tag'       => 'li',
								'modulus'   => 3
							)
						);
						
						echo $this->Html->tag(
							'li',
							$this->Paginator->next(
								'',
								array(
									'escape' => false
								),
								null,
								array(
									'class'  => 'disabled',
									'escape' => false
								)
							),
							array(
								'class' => 'pagination-next'
							)
						);
					?>
				</ul>
			<?php endif ?>
		</div>
	<?php endif ?>
<?php endif ?>