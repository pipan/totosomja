<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Blog series - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>name en</td>
				<td></td>
			</tr>
			<?php
			foreach($series as $s){
				?>
				<tr>
					<td><?php echo $s["series_name"];?></td>
					<td><?php echo $s["series_name_en"];?></td>
					<?php 
					if ($s["admin_id"] == $admin_id){
						?>
						<td><a href = "<?php echo base_url()."index.php/admin/blog_series/edit/".$s["id"];?>">change</a></td>
						<?php 
					}
					?>
				</tr>
				<?php
			}
			?>
		</table>
	</div>