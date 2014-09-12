<div id="body">
	<div id="body_left_full" class="white_bg_transparent">
		<div class="title2">
			<?php echo $lang->line('purchase_title');?>
		</div>
		<div>
			<div>
			<?php echo $thank_you;?>
			</div>
			<div>
				<?php echo $lang->line('purchase_id').": ".$txn_id;?>
			</div>
			<div>
				<div>
					<?php echo $lang->line('purchase_address_country').": ".$paypal_data['address_country'];?>
				</div>
				<div>
					<?php echo $lang->line('purchase_address_city').": ".$paypal_data['address_city'].", ".$paypal_data['address_zip'];?>
				</div>
				<div>
					<?php echo $lang->line('purchase_address_street').": ".$paypal_data['address_street'];?>
				</div>
				
				<div>
					<?php echo $lang->line('purchase_address_state').": ".$paypal_data['address_state'];?>
				</div>
			</div>
			<?php 
			if (isset($item)){
				foreach ($item as $i){
					?>
					<div>
						<div>
							<?php echo $lang->line('purchase_item').": ".$i['name'];?>
						</div>
						<div>
							<?php echo $lang->line('purchase_quantity').": ".$i['quantity'];?>
						</div>
						<div>
							<?php echo $lang->line('purchase_price').": ".$i['price'];?>
						</div>
					</div>
					<?php
				} 
			}
			?>
			<div>
				<?php echo $lang->line('purchase_price_total').": ".$paypal_data['mc_gross'];?>
			</div>
			<div>
				<?php echo $lang->line('purchase_ice');?>
			</div>
		</div>
	</div>