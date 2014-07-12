<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Type - edit
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/type/edit/".$type['id']);
			?>
				<div>
					<label for="type_name">name</label>
					<input id="type_name" type="text" name="name" value="<?php echo set_value('name', $type['type_name']);?>" />
				</div>
				<div>
					<label for="type_image">image</label>
					<input id="type_image" type="file" name="image" />
				</div>
				<div>
					<label for="type_desription">description</label>
					<textarea id="type_desription" name="description"><?php
					echo set_value('description', read_file("./content/type/description/".$type['id'].".txt"));
					?></textarea>
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>
	</div>