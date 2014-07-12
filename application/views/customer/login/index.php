<div id="body">
	<div id="body_full" class="white_bg_transparent">
		<div id="body_login">
			<div class="title2">
				<?php echo $lang->line('login_title');?>
			</div>
			<div id="login_form">
				<?php 
				if ($login_error){
					echo validation_errors();
				}
				echo form_open($language."/login");
				?>
					<div>
						<div>
							<label for="login_nick"><?php echo $lang->line('login_nickname_label');?></label>
						</div>
						<div>
							<input id="login_nick" type="text" name="login_nickname" value="<?php echo set_value('login_nickname');?>">
						</div>
					</div>
					<div>
						<div>
							<label for="login_pass"><?php echo $lang->line('login_password_label');?></label>
						</div>
						<div>
							<input id="login_pass" type="password" name="login_password">
						</div>
					</div>
					<div>
						<label for="login_remember"><?php echo $lang->line('login_remember_label');?></label>
						<input id="login_remember" type="checkbox" name="login_remember">
					</div>
					<div>
						<input type="submit" name="login" value="<?php echo $lang->line('login_button');?>" />
					</div>
				</form>
			</div>
		</div>
		<div id="body_registration">
			<div class="title2">
				<?php echo $lang->line('registration_title');?>
			</div>
			<div id="reg_form">
				<?php 
				if (!$login_error){
					echo validation_errors();
				}
				echo form_open($language."/login/registration");
				?>
					<div>
						<label for="reg_nick"><?php echo $lang->line('registration_nickname_label');?></label>
						<input id="reg_nick" type="text" name="reg_nickname" value="<?php echo set_value('reg_nickname');?>">
					</div>
					<div>
						<label for="reg_name"><?php echo $lang->line('registration_name_label');?></label>
						<input id="reg_name" type="text" name="reg_name" value="<?php echo set_value('reg_name');?>">
					</div>
					<div>
						<label for="reg_surname"><?php echo $lang->line('registration_surname_label');?></label>
						<input id="reg_surname" type="text" name="reg_surname" value="<?php echo set_value('reg_surname');?>">
					</div>
					<div>
						<label for="reg_email"><?php echo $lang->line('registration_email_label');?></label>
						<input id="reg_email" type="text" name="reg_email" value="<?php echo set_value('reg_email');?>">
					</div>
					<div>
						<label for="reg_pass1"><?php echo $lang->line('registration_password_label');?></label>
						<input id="reg_pass1" type="password" name="reg_pass1">
					</div>
					<div>
						<label for="reg_pass2"><?php echo $lang->line('registration_password_repeat_label');?></label>
						<input id="reg_pass2" type="password" name="reg_pass2">
					</div>
					<div style="padding:20px 0px">
						<div>
							<label for="reg_day"><?php echo $lang->line('registration_birthday_label');?></label>
							<select name="reg_day">
								<option value="0">DD</option>
								<?php
								for ($i = 1; $i <= 31; $i++){
									$j = $i;
									if ($i < 10){
										$j = "0".$i;
									}
									?>
									<option value="<?php echo $i;?>" <?php echo set_select('reg_day', $i);?>><?php echo $j;?></option>
									<?php
								}
								?>
							</select>
							<select name="reg_month">
								<option value="0">MM</option>
								<?php
								for ($i = 1; $i <= 12; $i++){
									if ($i < 10){
										$j = "0".$i;
									}
									?>
									<option value="<?php echo $i;?>" <?php echo set_select('reg_month', $i);?>><?php echo $j;?></option>
									<?php
								}
								?>
							</select>
							<select name="reg_year">
								<option value="0">YYYY</option>
								<?php
								for ($i = date("Y"); $i >= 1900; $i--){
									?>
									<option value="<?php echo $i;?>" <?php echo set_select('reg_year', $i);?>><?php echo $i;?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div>
							<label for="reg_male" class="exception"><?php echo $lang->line('registration_gender_label_male');?></label>
							<input id="reg_male" type="radio" name="reg_gender" value="1" <?php echo set_radio('reg_gender', '1');?>>
							<label class="exception"> / </label>
							<label for="reg_female" class="exception"><?php echo $lang->line('registration_gender_label_female');?></label>
							<input id="reg_female" type="radio" name="reg_gender" value="2" <?php echo set_radio('reg_gender', '2');?>>
						</div>
					</div>
					<div>
						<label for="reg_street"><?php echo $lang->line('registration_street_label');?></label>
						<input id="reg_street" type="text" name="reg_street" value="<?php echo set_value('reg_street');?>">
					</div>
					<div>
						<label for="reg_street_number"><?php echo $lang->line('registration_street_number_label');?></label>
						<input id="reg_street_number" type="text" name="reg_street_number" value="<?php echo set_value('reg_street_number');?>">
					</div>
					<div>
						<label for="reg_town"><?php echo $lang->line('registration_town_label');?></label>
						<input id="reg_town" type="text" name="reg_town" value="<?php echo set_value('reg_town');?>">
					</div>
					<div>
						<label for="reg_psc"><?php echo $lang->line('registration_postal_code_label');?></label>
						<input id="reg_psc" type="text" name="reg_postal_code" value="<?php echo set_value('reg_postal_code');?>">
					</div>
					<div>
						<label for="reg_country"><?php echo $lang->line('registration_country_label');?></label>
						<input id="reg_country" type="text" name="reg_country" value="<?php echo set_value('reg_country');?>">
					</div>
					<div>
						<input type="submit" name="register" value="<?php echo $lang->line('registration_button');?>" />
					</div>
				</form>
			</div>
		</div>
	</div>