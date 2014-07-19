<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Type - new
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/type/new_type");
			?>
				<div>
					<label for="type_name">name</label>
					<input id="type_name" type="text" name="name" value="<?php echo set_value('name');?>" />
				</div>
				<div>
					<label for="type_name_en">name en</label>
					<input id="type_name_en" type="text" name="name_en" value="<?php echo set_value('name_en');?>" />
				</div>
				<div>
					<label for="type_image">image</label>
					<input id="type_image" type="file" name="image" />
				</div>
				<div>
					<label for="type_desription">description</label>
					<textarea id="type_desription" name="description"><?php
					echo set_value('description');
					?></textarea>
				</div>
				<div>
					<label for="type_desription_en">description en</label>
					<textarea id="type_desription_en" name="description_en"><?php
					echo set_value('description_en');
					?></textarea>
				</div>
				<div>
					<input type="submit" name="add" value="add" />
				</div>
			</form>
		</div>
	</div>