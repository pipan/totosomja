<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Color - new
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open("admin/color/new_color");
				?>
				<div>
					<label for="color_name">name</label>
					<input id="color_name" type="text" name="name" value="<?php echo set_value('name');?>" />
				</div>
				<div>
					<input type="submit" name="add" value="add" />
				</div>
			</form>
		</div>
	</div>