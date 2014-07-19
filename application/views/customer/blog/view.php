<div id="body">
	<div id="body_left" class="light_blue_bg_transparent">
		<div class="blog_body_padding white_bg_transparent">
			<div id="blog_header">
				<div id="blog_header_title" class="title1">
					<?php 
					echo rawUrlDecode(read_file("./content/blog/".$blog['id']."/title".$language_ext.".txt"));
					?>
				</div>
				<div id="blog_header_info_date" class="gray">
					<?php echo date_to_word($language, $blog['post_date']);?>
				</div>
				<div id="blog_header_info_name" class="gray">
					<?php echo $blog['admin_name']." ".$blog['admin_surname'];?>
				</div>
			</div>
			<div id="blog_body">
				<?php 
				echo rawUrlDecode(read_file("./content/blog/".$blog['id']."/body".$language_ext.".txt"));
				?>
			</div>
			<div class="blog_tags_block">
				<?php
				foreach ($tag as $t){
					?>
					<div class="blog_tag">
						<a href="<?php echo base_url()."index.php/".$language."/blog/tag/".$t['tag_slug'];?>"><?php echo $t['tag_name'];?></a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php 
		if ($login != false){
			?>
			<div class="blog_body_padding white_bg_transparent">
				<div id="new_comment">
					<?php 
					if ($show_error){
						echo validation_errors();
					}
					echo form_open($language."/blog/".$blog['slug'.$language_ext]);
					?>
						<div>
							<textarea name="comment"><?php
							if ($show_error){
								echo set_value('comment');
							}?></textarea>
						</div>
						<div>
							<input type="hidden" name="blog_id" value="<?php echo $blog['id'];?>" />
							<input type="submit" name="send" value="<?php echo $lang->line('blog_comment_send_button');?>" />
						</div>
					</form>
				</div>
			</div>
			<?php
		}
		else{
			?>
				<div class="product_body_padding">
					<?php echo $lang->line('blog_view_error_can_comment');?>
				</div>
				<?php
			}
		foreach ($comments as $c){
			?>
			<div class="blog_body_padding white_bg_transparent">
				<div class="comment">
					<div class="comment_header gray">
						<div class="comment_header_name">
							<?php echo $c['customer_nickname'];?>
						</div>
						<div class="comment_header_date">
							<?php echo date_to_word($language, $c['post_date']);?>
						</div>
					</div>
					<div class="comment_body">
						<?php echo read_file("./content/blog/".$blog['id']."/comments/".$c['id'].".txt");?>
					</div>
				</div>
			</div>
			<?php	
		}
		?>
	</div>