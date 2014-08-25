	<div id="body_right">
		<?php 
		if (isset($functions)){
			?>
			<div id="functions">
				<?php 
				foreach ($functions as $f){
					?>
					<div>
						<a href="<?php echo $f['link'];?>"><?php echo $f['text'];?></a>
					</div>
					<?php 
				}
				?>
			</div>
			<?php 
		}
		?>
		<div id="navigator" class="light_blue_bg">
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/blog">blog</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/blog_series">blog serie</a>
			</div>
		</div>
	</div>
</div>