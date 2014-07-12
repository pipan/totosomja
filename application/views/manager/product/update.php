<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Product - update
		</div>
		<div>
		<?php 
			echo validation_errors();
			echo form_open_multipart("admin/product/update/".$product['id']);
			?>
				<div>
					<label>name</label>
					<label><?php echo $product['product_name'];?></label>
				</div>
				<div>
					<label for="product_store">store</label>
					<input id="product_store" type="text" name="store" value="<?php echo set_value('store', $product['store']);?>" />
				</div>
				<div>
					<input id="product_sellable" type="checkbox" name="sellable" value="1" <?php echo set_checkbox('sellable', '1', $product['sellable'] == 1);?> />
					<label for="product_sellable">sellable</label>
				</div>
				<div>
					<input type="submit" name="update" value="update" />
				</div>
			</form>
		</div>
	</div>