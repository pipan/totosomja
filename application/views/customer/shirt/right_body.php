	<div id="body_right">
		<div id="filter" class="product_body_item">
			<div class="title2 white"><?php echo $lang->line('filter_title');?></div>
			<div class="product_body_item_info_block">
				<div class="product_body_item_info_line">
					<label for="product_filter_gender"><?php echo $lang->line('filter_label_gender');?></label>
					<select id="product_filter_gender" name="filter_gender" class="dark_exception">
						<option value=""><?php echo $lang->line('form_none');?></option>
						<option value="1" <?php echo set_select('', '', $filter['gender'] == 1);?>><?php echo $lang->line('filter_gender_male');?></option>
						<option value="2" <?php echo set_select('', '', $filter['gender'] == 2);?>><?php echo $lang->line('filter_gender_female');?></option>
					</select>
				</div>
				<div class="body_item_info_line">
					<label for="product_filter_size"><?php echo $lang->line('filter_label_size');?></label>
					<?php 
					select_form('product_filter_size', 'filter_size', $db['size'], 'id', 'size_name', $lang, $filter['size'], 'dark_exception')
					?>
				</div>
				<div class="body_item_info_line">
					<label for="product_filter_color"><?php echo $lang->line('filter_label_color');?><?php echo set_value('filter_color');?></label>
					<?php
					select_form('product_filter_color', 'filter_color', $db['color'], 'id', 'color_name', $lang, $filter['color'], 'dark_exception')
					?>
				</div>
				<div class="body_item_info_line">
					<label for="product_filter_price"><?php echo $lang->line('filter_label_price');?></label>
					<select id="product_filter_price" name="filter_price" class="dark_exception">
						<option value=""><?php echo $lang->line('form_none');?></option>
						<option value="10" <?php echo set_select('', '', $filter['price'] == 10);?>><?php echo $lang->line('filter_price_less10');?></option>
						<option value="20" <?php echo set_select('', '', $filter['price'] == 20);?>><?php echo $lang->line('filter_price_less20');?></option>
						<option value="30" <?php echo set_select('', '', $filter['price'] == 30);?>><?php echo $lang->line('filter_price_less30');?></option>
						<option value="50" <?php echo set_select('', '', $filter['price'] == 50);?>><?php echo $lang->line('filter_price_less50');?></option>
					</select>
				</div>
				<div class="body_item_info_line">
					<input id="page_language" type="hidden" name="language" value="<?php echo $language;?>" />
					<input type="button" name="filter" value="<?php echo $lang->line('filter_filter');?>" onClick="filter_proces();" />
					<input type="button" name="cancel_filter" value="<?php echo $lang->line('filter_cancel');?>" onClick="cancel_filter_proces();" />
				</div>
			</div>
		</div>
	</div>
</div>