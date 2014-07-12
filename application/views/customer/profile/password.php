<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div id="body_registration">
			<div class="title2">
				<?php echo $lang->line('profile_title');?>
			</div>
			<div id="reg_form">
				<?php 
				echo validation_errors();
				echo form_open($language."/profile/password");
				?>
					<div>
						<label for="profile_old_password"><?php echo $lang->line('profile_old_password');?></label>
						<input id="profile_old_password" type="password" name="old_password" />
					</div>
					<div>
						<label for="profile_new_password"><?php echo $lang->line('profile_new_password');?></label>
						<input id="profile_new_password" type="password" name="new_password" />
					</div>
					<div>
						<label for="profile_new_password_repeat"><?php echo $lang->line('profile_new_password_repeat');?></label>
						<input id="profile_new_password_repeat" type="password" name="new_password_repeat" />
					</div>
					<div>
						<input type="submit" name="change" value="<?php echo $lang->line('profile_change_password_button');?>" />
					</div>
				</form>
			</div>
		</div>
	</div>