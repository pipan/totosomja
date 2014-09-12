<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			<?php echo "Order - ".$invoic['invoic_id']." add products";?> 
		</div>
		<?php 
		echo validation_errors();
		echo form_open("admin/orders/add_product/".$invoic['id']);
		?>
			<div>
				<label>invoice id</label>
				<span><?php echo $invoic['invoic_id'];?></span>
			</div>
			<div>
				<label for="product_id">product</label>
				<select id="product_id" name="product_id">
					<?php 
					if (isset($product)){
						foreach ($product as $p){
							?>
							<option value="<?php echo $p['id'];?>" <?php echo set_select('product_id', $p['id']);?>><?php echo $p['product_name'];?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div>
				<label for="quantity">quantity</label>
				<input name="quantity" type="text" value="<?php echo set_value('quantity');?>">
			</div>
			<div>
				<input type="submit" name="edit" value="edit">
			</div>
		</form>
	</div>