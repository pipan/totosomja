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
				<a class="exception" href="<?php echo base_url();?>index.php/admin/product">products</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/supplier">suppliers</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/color">colors</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/size">sizes</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/material">materials</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/category">categories</a>
			</div>
			<div>
				<a class="exception" href="<?php echo base_url();?>index.php/admin/type">types</a>
			</div>
		</div>
	</div>
</div>