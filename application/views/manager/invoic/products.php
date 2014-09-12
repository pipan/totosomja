<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			<?php echo "Order - ".$invoic['invoic_id']." products";?> 
		</div>
		<?php 
		echo validation_errors();
		echo form_open("admin/orders/products/".$invoic['id']);
		?>
			<div>
				<label>invoice id</label>
				<span><?php echo $invoic['invoic_id'];?></span>
			</div>
			<?php 
			if (isset($product_in_invoic)){
				$i = 0;
				foreach ($product_in_invoic as $pii){
					$i++;
					?>
					<div>
						<label for="<?php echo "item".$i;?>"><?php echo "item".$i;?></label>
						<select id="<?php echo "item".$i;?>" name="<?php echo "item".$i."_id";?>">
							<?php 
							if (isset($product)){
								foreach ($product as $p){
									?>
									<option value="<?php echo $p['id'];?>" <?php echo set_select('item'.$i.'_id', $p['id'], $pii['product_id'] == $p['id']);?>><?php echo $p['product_name'];?></option>
									<?php
								}
							}
							?>
						</select>
						<input style="width: 50px;" name="<?php echo "item".$i."_quantity";?>" type="text" value="<?php echo set_value('item'.$i.'_quantity', $pii['quantity']);?>">
						<input name="<?php echo "item".$i."_delete";?>" type="checkbox" value="delete" <?php set_checkbox('item'.$i.'_delete', 'delete');?>>delete
					</div>
					<?php
				}
			}
			?>
			<div>
				<input type="submit" name="edit" value="edit">
			</div>
		</form>
	</div>