	<div id="body_right">
		<div id="functions">
			<div><a href="javascript:void(0);" onClick="editor.save();">save</a></div>
			<div><a href="<?php echo base_url()."index.php/admin/blog/help"?>">help</a></div>
		</div>
		<div id="content_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#content_edit_body');">
				content
			</div>
			<div id="content_edit_body">
				<form>
					<div>
						<div><label for="blog_title">title</label></div>
						<div><input id="blog_title" type="text" name="title" value="<?php echo $blog_title;?>" onInput="editor.setTitle();" /></div>
					</div>
					<div>
						<div><label for="blog_text">text</label></div>
						<div><textarea id="blog_text" name="text" onInput="editor.setBlogText();"><?php echo $blog_body;?></textarea></div>
					</div>
					<div>
						<input class="blog_edit_button" type="button" name="bold" value="B" onClick="editor.setBold();" />
						<input class="blog_edit_button" type="button" name="italic" value="I" onClick="editor.setItalic();" />
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
							<div><label for="blog_link_link">link</label></div>
							<div><input id="blog_link_link" name="link_link" type="text" /></div>
						</div>
						<div style="float:left;">
							<div><label for="blog_link_text">text</label></div>
							<div><input id="blog_link_text" class="half_size" name="link_text" type="text" /></div>
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
				<div id="blog_link_list">
				</div>
			</div>
		</div>
		<div id="image_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#image_edit_body');">
				images
			</div>
			<div id="image_edit_body" style="display: none;">
				<div>
					<form id="blog_image_form">
						<div>
							<div><label for="blog_image_link">link</label></div>
							<div><input id="blog_image_link" name="image_link" type="text" /></div>
						</div>
						<div>
							<div style="float:left;">
								<div><label for="blog_image_width">width</label></div>
								<div><input id="blog_image_width" class="half_size" type="text" name="image_width" /></div>
							</div>
							<div style="float:right;">
								<div><label>alignment</label></div>
								<div>
									<input id="image_aligment_left" type="radio" name="image_alignment" value="left" checked />
									<label for="image_aligment_left">left</label>
									<input id="image_aligment_right" type="radio" name="image_alignment" value="right" />
									<label for="image_aligment_right">right</label>
								</div>
							</div>
						</div>
						<div>
							<div style="float:left;">
								<div><label for="blog_image_text">text</label></div>
								<div><input id="blog_image_text" class="half_size" name="image_text" type="text" /></div>
							</div>
							<div style="float:right;">
								<div><label>actions</label></div>
								<div>
									<input type="button" name="image_clear" value="new" onClick="editor.components.image.setSelected(0);" />
									<input type="button" name="image_save" value="save" onClick="editor.components.image.setList();" />
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="blog_image_list">
				</div>
			</div>
		</div>
		<div id="video_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#video_edit_body');">
				videos
			</div>
			<div id="video_edit_body" style="display: none;">
				<div>
					<form id="blog_video_form">
						<div>
							<div><label for="blog_video_link">link</label></div>
							<div><input id="blog_video_link" name="video_link" type="text" /></div>
						</div>
						<div>
							<div style="float:left;">
								<div><label for="blog_video_width">width</label></div>
								<div><input id="blog_video_width" class="half_size" type="text" name="video_width" /></div>
							</div>
							<div style="float:right;">
								<div><label>alignment</label></div>
								<div>
									<input id="video_aligment_left" type="radio" name="video_alignment" value="left" checked />
									<label for="video_aligment_left">left</label>
									<input id="video_aligment_right" type="radio" name="video_alignment" value="right" />
									<label for="video_aligment_right">right</label>
								</div>
							</div>
						</div>
						<div>
							<div style="float:left;">
								<div><label for="blog_video_text">text</label></div>
								<div><input id="blog_video_text" class="half_size" name="video_text" type="text" /></div>
							</div>
							<div style="float:right;">
								<div><label>actions</label></div>
								<div>
									<input type="button" name="video_clear" value="new" onClick="editor.components.video.setSelected(0);" />
									<input type="button" name="video_save" value="save" onClick="editor.components.video.setList();" />
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="blog_video_list">
				</div>
			</div>
		</div>
		<div id="tag_edit" class="light_blue_bg">
			<div class="clickable" onClick="toggleVisibility('#tag_edit_body');">
				Tags
			</div>
			<div id="tag_edit_body">
				<div>
					<form id="blog_tag_form">
						<div>
							<div><label for="blog_tag_series">series</label></div>
							<div>
								<select id="blog_tag_series" name="blog_series" onChange="editor.components.tag.setSeries();">
									<option value="0">none</option>
									<?php 
									foreach ($series as $s){
										if (isset($series_id) && $s['id'] == $series_id){
											?>
											<option value="<?php echo $s['id'];?>" selected="selected"><?php echo $s['series_name'];?></option>
											<?php
										}
										else{
											?>
											<option value="<?php echo $s['id'];?>"><?php echo $s['series_name'];?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div>
							<div><label for="blog_tag_thumbnail">thumbnail</label></div>
							<div>
								<select id="blog_tag_thumbnail" name="blog_thumbnail" onChange="editor.components.tag.changeThumbnail();">
									<option value="0">none</option>
								</select>
							</div>
						</div>
						<div>
							<div style="float:left;">
								<div><label for="blog_tag_text">tag</label></div>
								<div><input id="blog_tag_text" class="half_size" name="tag_text" type="text" /></div>
							</div>
							<div style="float:right;">
								<div><label>actions</label></div>
								<div>
									<input type="button" name="tag_clear" value="new" onClick="editor.components.tag.setSelected(0);" />
									<input type="button" name="tag_save" value="save" onClick="editor.components.tag.setList();" />
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="blog_tag_list">
				</div>
			</div>
		</div>
	</div>
</div>