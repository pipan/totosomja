<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Product - list
		</div>
		<table>
			<tr>
				<td>name</td>
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
				<td>image</td>
				<td>description</td>
				-->
				<td>store</td>
				<!--
				<td>supplier</td>
				-->
				<td>sellable</td>
				<td>update</td>
				<td>change</td>
				<td>create simular</td>
			</tr>
			<?php
			foreach ($product as $p){
				?>
				<tr>
					<td><?php echo $p['product_name'];?></td>
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
					<td><img src="<?php echo "./content/product/image/".$p['product_image'];?>" /></td>
					<td>
					<?php
					read_file("./content/product/description/".$p['id'].".txt");
					?>
					</td>
					-->
					<td><?php echo $p['store'];?></td>
					<!--
					<td><?php echo $p['supplier_name'];?></td>
					-->
					<td><?php echo $p['sellable'];?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/product/update/".$p['id'];?>">update</a></td>
					<td><a href = "<?php echo base_url()."index.php/admin/product/edit/".$p['id'];?>">change</a></td>
					<td><a href = "index.php?new=new&ID=<?php echo $p['id'];?>">simular</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>