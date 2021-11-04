<strong class="big_title"><?php echo sprintf(__('Reklamacja do zamówienia nr %s', true), getOrderFullId($order_id, true)) ?></strong>

<br/>
<br/>

<strong class="middle_title"><?php echo sprintf(__('Sporządzona w dniu: %s', true),  showDateTime(date('Y-m-d H:i:s'))) ?></strong>

<br/>
<br/>

<strong class="middle_title"><?php __('Dane nabywcy') ?>:</strong>

<br/>

<table class="reclamation_">
	<tr>
		<td class="label">
			<?php __('Imię') ?>:
		</td>
		<td>
			<?php echo $user['User']['first_name'] ?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<?php __('Nazwisko') ?>:
		</td>
		<td>
			<?php echo $user['User']['last_name'] ?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<?php __('E-mail') ?>:
		</td>
		<td>
			<?php echo $user['User']['email'] ?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<?php __('Telefon') ?>:
		</td>
		<td>
			<?php echo $user['User']['phone'] ?>
		</td>
	</tr>
</table>

<br/>

<strong class="middle_title"><?php __('Reklamowane produkty') ?>:</strong>

<br/>
<br/>

<table class="reclamation_ products">
	<tr>
		<th>
			<?php __('Lp.') ?>
		</th>
		<th>
			<?php __('Nazwa') ?>
		</th>
		<th>
			<?php __('Cena') ?>
		</th>
	</tr>
	
	<?php foreach ($products as $key => $product):?>
		<tr>
			<td>
				<?php echo $key + 1 ?>.
			</td>
			<td>
				<?php echo $product['OrderProduct']['product_name'] ?>
			</td>
			<td>
				<?php echo showOrderPrice(getOrderProductBruttoPrice($product['OrderProduct']), $order_id) ?>
			</td>
		</tr>
	<?php endforeach;?>
</table>

<?php if ($this->data['Order']['description']): ?>
	<br/>
	
	<span class="middle_title"><?php __('Opis reklamacji') ?>:</span>
	
	<br/>
	<br/>
	
	<?php echo nl2br($this->data['Order']['description']) ?>
<?php endif ?>