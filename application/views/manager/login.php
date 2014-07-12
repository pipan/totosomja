<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			admin - login
		</div>
		<div>
			<?php 
			echo validation_errors();
			echo form_open("admin/manager/login/");
			?>
				<div>
					<input type="text" name="name" value="<?php echo set_value('name');?>" />
				</div>
				<div>
					<input type="password" name="password" />
				</div>
				<div>
					<input type="submit" name="login" value="login" />
					<?php
					//custom_button("admin_login_button", "", "", "submit(document.admin_login);", "login", "login", "login");
					?>
				</div>
			</form>
		</div>
	</div>