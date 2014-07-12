<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Supplier - edit
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open("admin/supplier/edit/".$supplier['id']);
			?>
				<div>
					<label for="supplier_name">name</label>
					<input id="supplier_name" type="text" name="name" value="<?php echo set_value('name', $supplier['supplier_name']);?>" />
				</div>
				<div>
					<label for="supplier_delivery">delivery</label>
					<select id="supplier_delivery" name="delivery_count">
					<?php
					$delivery = delivery_to_form($supplier['supplier_delivery']);
					for ($i = 1; $i <= 30; $i++){ 
						?>
						<option value="<?php echo $i;?>" <?php echo set_select('delivery_count', $i, $delivery[0] == $i);?>><?php echo $i;?></option>
						<?php
					}
					?>
					</select>
					<select name="delivery_time_kind">
					<option value="1" <?php echo set_select('delivery_time_kind', '1', $delivery[1] == 1);?>>day</option>  
					<option value="2" <?php echo set_select('delivery_time_kind', '2', $delivery[1] == 2);?>>week</option>  
					<option value="3" <?php echo set_select('delivery_time_kind', '3', $delivery[1] == 3);?>>month</option>  
					</select>
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>
	</div>