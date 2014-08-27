<script>
function load(){
	<?php 
	if (isset($blog_link)){
		foreach ($blog_link as $list){
			?>
			editor.components.link.loadList('<?php echo $list['text'];?>', '<?php echo $list['link']?>');
			<?php
		}
	}
	$i = 1;
	if (isset($blog_image)){
		foreach ($blog_image as $list){
			if ($blog['thumbnail'] != null){
				if ($list['link'] == $blog['thumbnail']){
					$thumbnail = $i;
				}
			}
			$i++;
			?>
			editor.components.image.loadList('<?php echo $list['text'];?>', '<?php echo $list['link']?>', '<?php echo $list['width']?>', '<?php echo $list['alignment']?>');
			<?php
		}
	}
	if (isset($blog_video)){
		foreach ($blog_video as $list){
			?>
			editor.components.video.loadList('<?php echo $list['text'];?>', '<?php echo $list['link']?>', '<?php echo $list['width']?>', '<?php echo $list['alignment']?>', '<?php echo $list['code']?>');
			<?php
		}
	}
	if (isset($blog_tag)){
		foreach ($blog_tag as $list){
			?>
			editor.components.tag.loadList('<?php echo $list['tag_name'];?>');
			<?php
		}
	}
	?>
	editor.components.link.render();
	editor.components.image.render();
	<?php 
	if (isset($thumbnail)){
		?>
		editor.components.tag.thumbnail = <?php echo $thumbnail;?>;
		<?php	
	} 
	if (isset($series_id)){
		?>
		editor.components.tag.series = <?php echo $series_id;?>;
		<?php	
	}
	?>
	editor.components.image.renderThumbnailSelect(0);
	editor.components.video.render();
	editor.components.tag.render();
	<?php 
	if (isset($blog_id)){
		?>
		editor.id = <?php echo $blog_id;?>;
		<?php
	}
	if (isset($blog_lang)){
		?>
		editor.lang = '<?php echo $blog_lang;?>';
		<?php	
	}
	if (isset($url_save)){
		?>
		editor.urlSave = "<?php echo $url_save;?>";
		<?php
	}
	if (isset($url)){
		?>
		editor.url = "<?php echo $url;?>";
		<?php
	}
	?>
}
</script>