<div id="invoic-header">
	<div id="invoic-logo">
	
	</div>
	<div class="address">
		<div>
			<div class="address-label"><?php echo $lang->line('address_name');?></div>
			<div class="address-value"><?php echo $invoic['firm_name'];?></div>
		</div>
		<div>
			<div class="address-label"><?php echo $lang->line('address_town');?></div>
			<div class="address-value"><?php echo $invoic['fa_town'].", ".$invoic['fa_postal_code'];?></div>
		</div>
		<div>
			<div class="address-label"><?php echo $lang->line('address_street');?></div>
			<div class="address-value"><?php echo $invoic['fa_street'].", ".$invoic['fa_street_number'];?></div>
		</div>
		<div>
			<div class="address-label"><?php echo $lang->line('address_country');?></div>
			<div class="address-value"><?php echo $invoic['fa_country'];?></div>
		</div>
	</div>
</div>
<div id="invoic-body">
	<div class="title1">
		<?php echo $lang->line('invoic_number').": ".$invoic['invoic_id'];?>
	</div>
	<div id="buyer-address">
		<div class="address">
			<div class="title2">
				<?php echo $lang->line('address_invoic_title');?>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_name');?></div>
				<div class="address-value"><?php echo $invoic['buyer_name']." ".$invoic['buyer_surname'];?></div>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_town');?></div>
				<div class="address-value"><?php echo $invoic['ia_town'].", ".$invoic['ia_postal_code'];?></div>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_street');?></div>
				<div class="address-value"><?php echo $invoic['ia_street'].", ".$invoic['ia_street_number'];?></div>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_country');?></div>
				<div class="address-value"><?php echo $invoic['ia_country'];?></div>
			</div>
		</div>
		<div class="address">
			<div class="title2">
				<?php echo $lang->line('address_shipping_title');?>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_name');?></div>
				<div class="address-value"><?php echo $invoic['buyer_name']." ".$invoic['buyer_surname'];?></div>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_town');?></div>
				<div class="address-value"><?php echo $invoic['sa_town'].", ".$invoic['sa_postal_code'];?></div>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_street');?></div>
				<div class="address-value"><?php echo $invoic['sa_street'].", ".$invoic['sa_street_number'];?></div>
			</div>
			<div>
				<div class="address-label"><?php echo $lang->line('address_country');?></div>
				<div class="address-value"><?php echo $invoic['sa_country'];?></div>
			</div>
		</div>
	</div>
	<div id="products">
		<table>
			<tr class="title3">
				<td><?php echo $lang->line('product_name');?></td>
				<td><?php echo $lang->line('product_quantity');?></td>
				<td><?php echo $lang->line('product_price_for_one');?></td>
				<td><?php echo $lang->line('product_price');?></td>
			</tr>
			<?php 
			$total = 0;
			if (isset($product_in_invoic)){
				foreach ($product_in_invoic as $pii){
					?>
					<tr>
						<td><?php echo $pii['product_name'.$language_ext];?></td>
						<td><?php echo $pii['quantity'];?></td>
						<td><?php echo $pii['price']."EUR";?></td>
						<td><?php echo ($pii['price'] * $pii['quantity'])."EUR";?></td>
					</tr>
					<?php
					$total += $pii['price'] * $pii['quantity'];
				}
			}
			?>
			<tr>
				<td colspan="3" class="title3"><?php echo $lang->line('product_price_total_item');?></td>
				<td><?php echo $total."EUR";?></td>
			</tr>
			<tr>
				<td colspan="3" class="title3"><?php echo $lang->line('product_price_tax');?></td>
				<td><?php echo ($total * (TAX) / 100)."EUR";?></td>
			</tr>
			<tr>
				<td colspan="3" class="title3"><?php echo $lang->line('product_price_total');?></td>
				<td><?php echo ($total * (100 + TAX) / 100)."EUR";?></td>
			</tr>
		</table>
	</div>
</div>
<div id="invoic-footer">

</div>