<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Material - edit
		</div>
		<div>
			<?php 
			echo validation_errors();
			echo form_open("admin/material/edit/".$material['id']);
			?>
				<div>
					<label for="material_name">name</label>
					<input id="material_name" type="text" name="name" value="<?php echo set_value('name', $material['material_name']);?>" />
				</div>
				<div>
					<label for="material_name_en">name en</label>
					<input id="material_name_en" type="text" name="name_en" value="<?php echo set_value('name_en', $material['material_name_en']);?>" />
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>
	</div>