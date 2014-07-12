<div id="body">
	<div id="body_left" class="light_blue_bg_transparent">
		<div class="blog_preview_body_padding">
			<?php 
			foreach ($blogs as $b){
				?>
				<div class="white_bg_transparent blog_preview">
					<div class="title1">
						<?php echo Blog_parser::pure_text($b['title'], $b['id']);?>
					</div>
					<div class="blog_preview_body">
						<div>
							<?php echo word_limiter(Blog_parser::pure_text(read_file("./content/blog/".$b['id']."/bodyTextarea.txt"), $b['id']), 50);?>
							<a href="<?php echo base_url()."index.php/".$language."/blog/".$b['slug'];?>"><?php echo $lang->line('word_more');?></a>
						</div>
					</div>
				</div>
				<?php 
			} 
			page_div($page, $page_offset, $last_page, base_url()."index.php/".$language."/blog/%p");
			?>
		</div>
	</div>