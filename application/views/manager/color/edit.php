<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Color - edit
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open("admin/color/edit/".$color['id']);
				?>
				<div>
					<label for="color_name">name</label>
					<input id="color_name" type="text" name="name" value="<?php echo set_value('name', $color['color_name']);?>" />
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>
	</div>