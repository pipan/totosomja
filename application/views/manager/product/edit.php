<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Product - edit
		</div>
		<div>
		<?php 
			echo validation_errors();
			echo form_open_multipart("admin/product/edit/".$product['id']);
			?>
				<div>
					<label for="product_name">name</label>
					<input id="product_name" type="text" name="name" value="<?php echo set_value('name', $product['product_name']);?>" />
				</div>
				<div>
					<label for="product_type">type</label>
					<?php 
					$model['type']->select_form("product_type", "type_id", set_value('type_id', $product['type_id']));
					?>
				</div>
				<div>
					<label for="product_category">category</label>
					<?php 
					$model['category']->select_form("product_category", "category_id", set_value('category_id', $product['category_id']));
					?>
				</div>
				<div>
					<label for="product_price">price</label>
					<input id="product_price" type="text" name="price" value="<?php echo set_value('price', $product['price']);?>" />
				</div>
				<div>
					<label for="product_color">color</label>
					<?php 
					$model['color']->select_form("product_color", "color_id", set_value('color_id', $product['color_id']));
					?>
				</div>
				<div>
					<label for="product_size">size</label>
					<?php 
					$model['size']->select_form("product_size", "size_id", set_value('size_id', $product['size_id']));
					?>
				</div>
				<div>
					<label for="product_material">material</label>
					<?php 
					$model['material']->select_form("product_material", "material_id", set_value('material_id', $product['material_id']));
					?>
				</div>
				<div>
					<label for="product_store">store</label>
					<input id="product_store" type="text" name="store" value="<?php echo set_value('store', $product['store']);?>" />
				</div>
				<div>
					<label for="product_male" class="exception">male</label>
					<input id="product_male" type="radio" name="gender" value="0" <?php echo set_radio('gender', '0', $product['gender'] == 0);?> />
					<label for="product_female" class="exception">female</label>
					<input id="product_female" type="radio" name="gender" value="1" <?php echo set_radio('gender', '1', $product['gender'] == 1);?> />
				</div>
				<div>
					<label for="product_image">image</label>
					<input id="product_image" type="file" name="image" />
				</div>
				<div>
					<label for="product_supplier">supplier</label>
					<?php 
					$model['supplier']->select_form("product_supplier", "supplier_id", set_value('supplier_id', $product['supplier_id']));
					?>
				</div>
				<div>
					<label for="product_description">description</label>
					<textarea id="product_description" name="description"><?php echo set_value('description', read_file("./content/product/description/".$product['id'].".txt"));?></textarea>
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>				
	</div>