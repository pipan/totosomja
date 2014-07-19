	<div id="body_right">
		<div id="advertisment" class="body_item">
			<div class="title2 white">
				inzercia
			</div>
		</div>
		<div id="motd" class="body_item">
			<?php 
			if (isset($message_title)){
				?>
				<div id="message_body_title" class="title2 white"><?php echo $message_title;?></div>
				<div id="message_body"><?php echo $message_body;?></div>
				<?php 
				if ($message['poll_id'] != null){
					?>
					<div id="message_body_poll_question" class="title3 white"><?php echo $message['question'.$language_ext];?></div>
					<div id="message_body_poll">
						<?php 
						echo $vote_options;
						?>
					</div>
					<?php 
				}
			}
			else{
				echo $lang->line('message_error_no_message');
			}
			?>   
		</div>  
	</div>
</div>