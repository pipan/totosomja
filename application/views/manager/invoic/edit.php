<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			<?php echo "Order - ".$invoic['invoic_id'];?> 
		</div>
		<?php 
		echo validation_errors();
		echo form_open("admin/orders/edit/".$invoic['id']);
		?>
			<div>
				<label>invoice id</label>
				<span><?php echo $invoic['invoic_id'];?></span>
			</div>
			<div>
				<label>payment status</label>
				<span><?php echo $invoic['payment_status'];?></span>
			</div>
			<div>
				<label>payment date</label>
				<span><?php echo $invoic['transaction_date'];?></span>
			</div>
			<div>
				<label>transaction id</label>
				<span><?php echo $invoic['transaction_id'];?></span>
			</div>
			<div>
				<label>payer name</label>
				<span><?php echo $invoic['buyer_name']." ".$invoic['buyer_surname'];?></span>
			</div>
			<div>
				<label>payer email</label>
				<span><?php echo $invoic['payer_email'];?></span>
			</div>
			<div>
				<label>invioce status</label>
				<select id="order_status" name="order_status">
					<?php 
					if (isset($order_status)){
						foreach ($order_status as $status){
							?>
							<option value="<?php echo $status['id'];?>" <?php echo set_select('order_status', $status['id'], $invoic['order_status_id'] == $status['id']);?>><?php echo $status['status_name'];?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div>
				<label for="ia_town">invoice town</label>
				<input id="ia_town" name="ia_town" type="text" value="<?php echo set_value('ia_town', $invoic['ia_town']);?>">
			</div>
			<div>
				<label for="ia_postal_code">invoice postal code</label>
				<input id="ia_postal_code" name="ia_postal_code" type="text" value="<?php echo set_value('ia_postal_code', $invoic['ia_postal_code']);?>">
			</div>
			<div>
				<label for="ia_street">invoice street</label>
				<input id="ia_street" name="ia_street" type="text" value="<?php echo set_value('ia_street', $invoic['ia_street']);?>">
			</div>
			<div>
				<label for="ia_street_number">invoice street number</label>
				<input id="ia_street_number" name="ia_street_number" type="text" value="<?php echo set_value('ia_street_number', $invoic['ia_street_number']);?>">
			</div>
			<div>
				<label for="ia_country">invoice country</label>
				<input id="ia_country" name="ia_country" type="text" value="<?php echo set_value('ia_country', $invoic['ia_country']);?>">
			</div>
			<div>
				<label for="sa_town">shipping town</label>
				<input id="sa_town" name="sa_town" type="text" value="<?php echo set_value('sa_town', $invoic['sa_town']);?>">
			</div>
			<div>
				<label for="sa_postal_code">shipping postal code</label>
				<input id="sa_postal_code" name="sa_postal_code" type="text" value="<?php echo set_value('sa_postal_code', $invoic['sa_postal_code']);?>">
			</div>
			<div>
				<label for="sa_street">shipping street</label>
				<input id="sa_street" name="sa_street" type="text" value="<?php echo set_value('sa_street', $invoic['sa_street']);?>">
			</div>
			<div>
				<label for="sa_street_number">shipping street number</label>
				<input id="sa_street_number" name="sa_street_number" type="text" value="<?php echo set_value('sa_street_number', $invoic['sa_street_number']);?>">
			</div>
			<div>
				<label for="sa_country">shipping country</label>
				<input id="sa_country" name="sa_country" type="text" value="<?php echo set_value('sa_country', $invoic['sa_country']);?>">
			</div>
			<div>
				<input type="submit" name="edit" value="edit">
			</div>
		</form>
	</div>