<div id="body">
	<div id="body_left" class="light_blue_bg_transparent">
		<div class="blog_preview_body_padding">
			<?php 
			foreach ($blogs as $b){
				?>
				<div class="white_bg_transparent blog_preview">
					<div class="title1">
						<?php echo Blog_parser::pure_text($b['title'.$language_ext], $b['blog_id']);?>
					</div>
					<div class="blog_preview_body">
						<?php 
						if ($b['thumbnail'] != null){
							?>
							<div class="blog_preview_thumbnail">
								<img class="blog_preview_thumbnail_image" src="<?php echo $b['thumbnail'];?>" />
							</div>
							<?php
						}
						echo word_limiter(Blog_parser::pure_text(read_file("./content/blog/".$b['blog_id']."/bodyTextarea".$language_ext.".txt"), $b['blog_id']), 50)?>
						<a href="<?php echo base_url()."index.php/".$language."/blog/".$b['slug'.$language_ext];?>"><?php echo $lang->line('word_more');?></a>
					</div>
				</div>
				<?php 
			} 
			page_div($page, $page_offset, $last_page, base_url()."index.php/".$language."/blog/tag/%p/".$tag);
			?>
		</div>
	</div>