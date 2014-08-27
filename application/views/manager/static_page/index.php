<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Page - list
		</div>
		<table>
			<tr>
				<td>folder</td>
				<td>title</td>
				<td>title en</td>
				<td>date</td>
				<td></td>
				<td></td>
			</tr>
			<?php
			foreach($page as $p){
				?>
				<tr>
					<td><?php echo $p['folder'];?></td>
					<td><?php echo $p['page_title'];?></td>
					<td><?php echo $p['page_title_en'];?></td>
					<td><?php echo $p['post_date']?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/static_page/edit/".$p["id"];?>">sk</a></td>
					<td><a href = "<?php echo base_url()."index.php/admin/static_page/edit/".$p["id"]."/en";?>">en</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>