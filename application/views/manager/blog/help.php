<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Product - help
		</div>
		<div class="help_body">
			<div class="help_blok">
				<div class="title3">
					Pred tym ako zacneme s navodom
				</div>
				<ul>
					<li>treba si precitat <a href="<?php echo base_url()."index.php/admin"?>">uvodny tutorial</a></li>
				</ul>
			</div>
			<div class="help_blok">
				<div class="title3">
					Mozne akcie s produktami
				</div>
				<ul>
					<li><a href="<?php echo base_url()."index.php/admin/product/help#help_add_product"?>">vytvorenie noveho produktu</a></li>
					<li><a href="<?php echo base_url()."index.php/admin/product/help#help_change_product"?>">zmena produktu</a></li>
					<li><a href="<?php echo base_url()."index.php/admin/product/help#help_update_product"?>">uprava produktu (ano, je to ine ako zmena)</a></li>
					<li><a href="<?php echo base_url()."index.php/admin/product/help#help_create_simular_product"?>">vytvorenie produktu na zaklade uz existujuceho</a></li>
				</ul>
			</div>
			<div id="help_add_product" class="help_blok">
				<div class="title3">
					Vytvaranie produktu
				</div>
				<ol>
					<li>
						Klikneme na moznost add product
						<div><img src="<?php echo assets_url()."images/help/product/index_add_product.jpg"?>" /></div>
					</li>
					<li>
						Vyplnime vsetky udaje (vsetko je potrebne vyplnit)
						<div><img src="<?php echo assets_url()."images/help/product/add_product_values.jpg"?>" /></div>
					</li>
					<li>
						Klikneme add
					</li>
				</ol>
				<div class="help_note light_blue_bg_transparent">
					<b>Note:</b> Nas novy produkt sa teraz nachadza medzi produktami.
				</div>
			</div>
			<div id="help_change_product" class="help_blok">
				<div class="title3">
					Zmena produktu
				</div>
				<ol>
					<li>
						V zozname si najdeme produkt ktory chceme zmenit a stlacime k nemu patriace tlacitko change
						<div><img src="<?php echo assets_url()."images/help/product/index_change_product.jpg"?>" /></div>
					</li>
					<li>
						Zmenime udaje ktore chceme zmenit
						<div><img src="<?php echo assets_url()."images/help/product/change_product_values.jpg"?>" /></div>
					</li>
					<li>
						Klikneme change
					</li>
				</ol>
				<div class="help_note light_blue_bg_transparent">
					<b>Note:</b> Pri tejto zmene dochadza k zakazaniu stareho produktu a vytvorenia noveho s novymi (zmenenymi parametrami).
					Zakaznik si nic nevsimne, popravde ani admin.
					Toto sa deje z dovodu ak si niektu uz produkt pred zmenou kupil,
					tak ja si ten produkt musim nechat ulozeny aby som mu mohol ukazat co si kupil,
					ale nikto si ho uz kupit nebude moct. Uz bude v ponuke len ten zmeneny.
				</div>
			</div>
			<div id="help_update_product" class="help_blok">
				<div class="title3">
					Uprava produktu
				</div>
				<ol>
					<li>
						V zozname si najdeme produkt ktory chceme upravit a stlacime k nemu patriace tlacitko update
						<div><img src="<?php echo assets_url()."images/help/product/index_update_product.jpg"?>" /></div>
					</li>
					<li>
						Upravime udaje, mozme upravit len pocet kusov na sklade alebo mozme nastavit aby sa dany produkt uz nepredaval
						<div><img src="<?php echo assets_url()."images/help/product/update_product_values.jpg"?>" /></div>
					</li>
					<li>
						Klikneme update
					</li>
				</ol>
				<div class="help_note light_blue_bg_transparent">
					<b>Note:</b> Pri tejto akcii sa iba upravi existujuci produkt, to znamena ze sa nevytvara nova kopia.
				</div>
			</div>
			<div id="help_create_simular_product" class="help_blok">
				<div class="title3">
					vytvorenie produktu na zaklade uz existujuceho
				</div>
				<ol>
					<li>
						V zozname si najdeme produkt podla ktoreho chceme vytvorit novy
						<div><img src="<?php echo assets_url()."images/help/product/index_create_simular_product.jpg"?>" /></div>
					</li>
					<li>
						Upravime udaje ktore chceme mat v novom produkte ine. Urcite je treba upravit nazov aby bol jedinecny
						<div><img src="<?php echo assets_url()."images/help/product/create_simular_product_values.jpg"?>" /></div>
					</li>
					<li>
						Klikneme add
					</li>
				</ol>
			</div>
		</div>
	</div>