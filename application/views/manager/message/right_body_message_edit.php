	<div id="body_right">
		<div id="functions">
			<div><a href="javascript:void();" onClick="editor.save();">save</a></div>
		</div>
		<div id="content_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#content_edit_body');">
				content
			</div>
			<div id="content_edit_body">
				<form>
					<div>
						<div><label for="message_title">title</label></div>
						<div><input id="message_title" type="text" name="title" value="<?php echo $message_title;?>" onInput="editor.setTitle();" /></div>
					</div>
					<div>
						<div><label for="message_text">text</label></div>
						<div><textarea id="message_text" name="text" onInput="editor.setBlogText();"><?php echo $message_body;?></textarea></div>
					</div>
				</form>
			</div>
		</div>
		<div id="link_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#link_edit_body');">
				links
			</div>
			<div id="link_edit_body" style="display: none;">
				<div>
					<form>
						<div>
							<div><label for="message_link_link">link</label></div>
							<div><input id="message_link_link" name="link_link" type="text" /></div>
						</div>
						<div style="float:left;">
							<div><label for="message_link_text">text</label></div>
							<div><input id="message_link_text" class="half_size" name="link_text" type="text" /></div>
						</div>
						<div style="float:right;">
							<div><label>actions</label></div>
							<div>
								<input type="button" name="link_clear" value="new" onClick="editor.components.link.setSelected(0);" />
								<input type="button" name="link_save" value="save" onClick="editor.components.link.setList();" />
							</div>
						</div>
					</form>
				</div>
				<div id="message_link_list">
				</div>
			</div>
		</div>
		<div id="poll_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#poll_edit_body');">
				Poll
			</div>
			<div id="poll_edit_body">
				<div>
					<form id="blog_poll_form">
						<div>
							<div><label for="message_poll_qustion">qusrion</label></div>
							<div><input id="message_poll_question" name="poll_question" type="text" value="<?php echo $poll_question;?>" onInput="editor.components.poll.setQuestion();" /></div>
						</div>
						<div style="float:left;">
							<div><label for="message_poll_answer">answer</label></div>
							<div><input id="message_poll_answer"  class="half_size" name="poll_answer" type="text" /></div>
						</div>
						<div style="float:right;">
							<div><label>actions</label></div>
							<div>
								<input type="button" name="poll_clear" value="new" onClick="editor.components.poll.setSelected(0);" />
								<input type="button" name="poll_save" value="save" onClick="editor.components.poll.setList();" />
							</div>
						</div>
					</form>
				</div>
				<div id="message_poll_list">
				</div>
			</div>
		</div>
	</div>
</div>