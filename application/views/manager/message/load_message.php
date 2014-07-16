<script>
function load(){
	<?php
	if (isset($message_link)){ 
		foreach ($message_link as $list){
			?>
			editor.components.link.loadList('<?php echo $list['text'];?>', '<?php echo $list['link']?>');
			<?php
		}
	}
	if (isset($message_poll_answer)){
		foreach ($message_poll_answer as $list){
			?>
			editor.components.poll.loadList('<?php echo $list['answer'];?>');
			<?php
		}
	}
	?>
	editor.components.link.render();
	editor.components.poll.question = <?php echo "'".$message['question']."'";?>;
	editor.components.poll.render();
	editor.components.poll.setQuestion();
	editor.id = <?php echo $message['id'];?>;
}
</script>