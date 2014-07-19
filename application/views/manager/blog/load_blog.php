<script>
function load(){
	<?php 
	foreach ($blog_link as $list){
		?>
		editor.components.link.loadList('<?php echo $list['text'];?>', '<?php echo $list['link']?>');
		<?php
	}
	$i = 1;
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
	foreach ($blog_video as $list){
		?>
		editor.components.video.loadList('<?php echo $list['text'];?>', '<?php echo $list['link']?>', '<?php echo $list['width']?>', '<?php echo $list['alignment']?>', '<?php echo $list['code']?>');
		<?php
	}
	foreach ($blog_tag as $list){
		?>
		editor.components.tag.loadList('<?php echo $list['tag_name'];?>');
		<?php
	}
	?>
	editor.components.link.render();
	editor.components.image.render();
	editor.components.tag.thumbnail = <?php echo $thumbnail;?>;
	editor.components.tag.series = <?php echo $series_id;?>;
	editor.components.image.renderThumbnailSelect(0);
	editor.components.video.render();
	editor.components.tag.render();
	editor.id = <?php echo $blog_id;?>; 
	<?php 
	if (isset($blog_lang)){
		?>
		editor.lang = '<?php echo $blog_lang;?>';
		<?php	
	}
	?>
}
</script>