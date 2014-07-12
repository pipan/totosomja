<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Blog serie - edit
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/blog_series/edit/".$series['id']);
			?>
				<div>
					<label for="serie_name">name</label>
					<input id="serie_name" type="text" name="name" value="<?php echo set_value('name', $series['series_name']);?>" />
				</div>
				<div>
					<input type="submit" name="change" value="change" />
				</div>
			</form>
		</div>
	</div>