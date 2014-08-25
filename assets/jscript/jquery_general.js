function toggleVisibility(id){
	$(id).toggle();
}
function show(id){
	$(id).show();
}
function hide(id){
	$(id).hide();
}

function submitForm(id){
	$(id).submit();
}
function paypalSetQuantity(){
	var q = $('#quantity').val();
	$('#paypal_quantity').val(q);
}

function vote(pollId, answerId, lang){
	$('body').css({'cursor':'wait'});
	$('#body_right a').css({'cursor':'wait'});
	url = BASE_URL + "index.php/" + lang + "/shop/vote";
	var post = $.post(url, {poll_id: pollId, answer_id: answerId, language: lang});
	post.done(function(data, textStatus, jqXHR){
		$("#message_body_poll").html(data);
		$('body').css({'cursor':'default'});
		$('#body_right a').css({'cursor':'default'});
	});
	post.fail(function(jqXHR, textStatus, errorThrown){
		$("#message_body_poll").html('error - reload page or try again later');
		$('body').css({'cursor':'default'});
		$('#body_right a').css({'cursor':'default'});
	});
}