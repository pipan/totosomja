<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Category - edit
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/category/edit/".$category['id']);
			?>
				<div>
					<label for="category_name">name</label>
					<input id="category_name" type="text" name="name" value="<?php echo set_value('name', $category['category_name']);?>" />
				</div>
				<div>
					<label for="category_name_en">name en</label>
					<input id="category_name_en" type="text" name="name_en" value="<?php echo set_value('name_en', $category['category_name_en']);?>" />
				</div>
				<div>
					<label for="category_image">image</label>
					<input id="actegory_image" type="file" name="image" />
				</div>
				<div>
					<label for="category_description">description</label>
					<textarea id="category_description" name="description"><?php
					echo set_value('description', read_file("./content/category/description/".$category['id'].".txt"));
					?></textarea>
				</div>
				<div>
					<label for="category_description_en">description en</label>
					<textarea id="category_description_En" name="description_en"><?php
					echo set_value('description_en', read_file("./content/category/description/".$category['id']."_en.txt"));
					?></textarea>
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>
	</div>