<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Blog - list
		</div>
		<table>
			<tr>
				<td>title</td>
				<td>title en</td>
				<td>series</td>
				<td>post date</td>
				<td></td>
				<td></td>
			</tr>
			<?php
			foreach($blog as $b){
				?>
				<tr>
					<td><?php echo $b['title'];?></td>
					<td><?php echo $b['title_en'];?></td>
					<td><?php echo $b['series_name']?></td>
					<td><?php echo $b['post_date']?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/blog/edit/".$b["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
					<td><a href = "<?php echo base_url()."index.php/admin/blog/edit/".$b["id"]."/en";?>">en</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>