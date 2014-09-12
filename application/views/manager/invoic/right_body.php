	<div id="body_right">
		<?php 
		if (isset($functions)){
			?>
			<div id="functions">
				<?php 
				foreach ($functions as $f){
					$target = "";
					if (isset($f['target'])){
						$target = "target='".$f['target']."'";
					}
					?>
					<div>
						<a href="<?php echo $f['link'];?>" <?php echo $target;?>><?php echo $f['text'];?></a>
					</div>
					<?php 
				}
				?>
			</div>
			<?php 
		}
		?>
		<!--
		<div id="navigator" class="light_blue_bg">
			
		</div>
		 -->
	</div>
</div>