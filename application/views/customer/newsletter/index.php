<div id="body">
	<div id="body_full" class="white_bg_transparent">
		<div id="body_login">
			<div class="title2">
				<?php echo $lang->line('newsletter_title');?>
			</div>
			<div id="newsletter_form">
				<?php 
				echo validation_errors();
				echo form_open($language."/newsletter");
				?>
					<div>
						<div>
							<label for="newsletter_email"><?php echo $lang->line('newsletter_email_label');?></label>
						</div>
						<div>
							<input id="newsletter_email" type="text" name="newsletter_email" value="<?php echo set_value('newsletter_email');?>">
						</div>
					</div>
					<div style="width: 180px;">
						<div style="float: left;">
							<label class="exception" for="newsletter_agree"><?php echo $lang->line('newsletter_agree_label');?></label>
							<input style="float: right;" id="newsletter_agree" type="checkbox" name="newsletter_agree">
						</div>
					</div>
					<div>
						<input type="submit" name="send" value="<?php echo $lang->line('newsletter_send_button');?>" />
					</div>
				</form>
			</div>
		</div>
	</div>