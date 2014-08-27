<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Page - new
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/static_page/new_page");
			?>
				<div>
					<label for="folder">folder</label>
					<input id="v" type="text" name="folder" value="<?php echo set_value('folder');?>" />
				</div>
				<div>
					<label for="title">title</label>
					<input id="title" type="text" name="title" value="<?php echo set_value('title');?>" />
				</div>
				<div>
					<label for="title_en">title  en</label>
					<input id="title_en" type="text" name="title_en" value="<?php echo set_value('title_en');?>" />
				</div>
				<div>
					<input type="submit" name="save" value="save" />
				</div>
			</form>
		</div>
	</div>