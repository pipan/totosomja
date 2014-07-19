<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Product - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>name en</td>
				<!--
				<td>category</td>
				<td>type</td>
				-->
				<td>price</td>
				<!--
				<td>color</td>
				<td>size</td>
				<td>material</td>
				<td>gender</td>
				-->
				<td>image</td>
				<!--
				<td>description</td>
				-->
				<td>store</td>
				<!--
				<td>supplier</td>
				<td>sellable</td>
				-->
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php
			foreach ($product as $p){
				?>
				<tr>
					<td><?php echo $p['product_name'];?></td>
					<td><?php echo $p['product_name_en'];?></td>
					<!--
					<td><?php echo $p['category_name'];?></td>
					<td><?php echo $p['type_name'];?></td>
					-->
					<td><?php echo $p['price'];?></td>
					<!--
					<td><?php echo $p['color_name'];?></td>
					<td><?php echo $p['size_name'];?></td>
					<td><?php echo $p['material_name'];?></td>
					<td><?php echo gender_to_string($p['gender']);?></td>
					-->
					<td><img style="width: 50px;" src="<?php echo content_url()."product/image/".$p['product_image'];?>" /></td>
					<!--
					<td>
					<?php
					read_file("./content/product/description/".$p['id'].".txt");
					?>
					-->
					</td>
					<td><?php echo $p['store'];?></td>
					<!--
					<td><?php echo $p['supplier_name'];?></td>
					<td><?php echo $p['sellable'];?></td>
					-->
					<td class="center"><a href = "<?php echo base_url()."index.php/admin/product/update/".$p['id'];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />update</a></td>
					<td class="center"><a href = "<?php echo base_url()."index.php/admin/product/edit/".$p['id'];?>"><img src="<?php echo assets_url()."images/change_logo.png";?>" />change</a></td>
					<td class="center"><a href = "<?php echo base_url()."index.php/admin/product/new_product/".$p['id'];?>"><img src="<?php echo assets_url()."images/create_simular_logo.png";?>" />create</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>