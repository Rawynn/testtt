<style type="text/css">
	table.products th{
		text-align: left;
		width: 200px;
	}
</style>

<div class="logo fl">
	<table class="photo">
		<tr>
			<td>
				<?php
					if ($logo = getTemplatePath('logo')):
						$size = @getimagesize($logo);
						$height = 92;
						
						if ($size):
							if ($size[1] < $height):
								$height = $size[1];
							endif;
						endif;
						
						echo $this->Html->image(
							$logo,
							array(
								'height' => $height
							)
						);
					else:
						echo '<span>'.setting('GLOBAL_STORE_COMPANY').'</span>';
					endif;
				?>
			</td>
		</tr>
	</table>
</div>

<div class="fl top_center">
	<div class="top_center_name center bold border">
		<?php __('Paczka nr.') ?>
	</div>
	
	<div class="top_center_date center border">
		<strong class="date"><?php echo showDate($complaint_package['ComplaintPackage']['created']) ?></strong><br/>
		<small><?php __('data utworzenia') ?></small>
	</div>
</div>

<div class="fl top_right">
	<div class="top_right_number center bold border" style="height: 55px; margin-bottom: 3px; padding-top: 35px; font-size: 25px;">
		<?php echo $complaint_package['ComplaintPackage']['auto_number'] ?>
	</div>
</div>

<div class="clear" style="height: 3px;"></div>

<div>
	<table class="products">
		<tbody>
			<tr>
				<th>
					<?php __('Nazwa klienta') ?>:
				</th>
				<td>
					<?php echo !empty($user['User']['username']) ? $user['User']['username'] : '-' ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php __('Telefon') ?>:
				</th>
				<td>
					<?php echo !empty($user['User']['phone']) ? $user['User']['phone'] : '-' ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php __('E-mail') ?>:
				</th>
				<td>
					<?php echo $user['User']['email'] ?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="clear" style="height: 10px;"></div>
	
	<table class="products">
		<thead>
			<tr>
				<th>
					<?php __('Nr reklamacji') ?>
				</th>
				<th>
					<?php __('Data utworzenia') ?>
				</th>
				<th>
					<?php __('Nr faktury') ?>
				</th>
				<th>
					<?php __('Nr zamówienia') ?>
				</th>
				<th>
					<?php __('Produkt') ?>
				</th>
				<th>
					<?php __('Producent') ?>
				</th>
				<th>
					<?php __('Ilość') ?>
				</th>
				<th>
					<?php __('Opis') ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($complaint_package['Complaint'] as $complaint): ?>
				<tr>
					<td>
						<?php echo $complaint['id'] ?>
					</td>
					<td>
						<?php echo showDate($complaint['created']) ?>
					</td>
					<td>
						<?php echo $complaint['Invoice'] ? $complaint['Invoice']['number'] : '-' ?>
					</td>
					<td>
						<?php echo $complaint['order_id'] ? getOrderFullId($complaint['order_id'], true) : '-' ?>
					</td>
					<td>
						<?php echo $complaint['product_name'] ? $complaint['product_name'] : '-' ?>
					</td>
					<td>
						<?php echo $complaint['producer_id'] ? getProducerName($complaint['producer_id']) : '-' ?>
					</td>
					<td>
						<?php echo showQuantityValue($complaint['quantity'], $complaint['product_id']) ?>
					</td>
					<td>
						<?php echo nl2br($complaint['description']) ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>