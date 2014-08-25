/*
 * Globals
 */
var BLOG_LINK = "LINK-";

/*
 * Classes
 */
function EditorApplication(){
	this.components = {
		link: new LinkComponent(),
		poll: new PollComponent()
	};
	this.pollId = "#message_body_poll";
	this.bodyId = "#message_body"; 
	this.bodyTextareaId = "#message_text";
	this.titleId = "#message_body_title";
	this.titleTextareaId = "#message_title";
	this.title = "";
	this.body = "";
	this.id = 0;
	this.lang = "sk";
	
	this.setTitle = function(){
		this.title = $(this.titleTextareaId).val();
		$(this.titleId).text(this.title);
		this.refreshTitle();
	};
	
	this.setBlogText = function(){
		this.body = $(this.bodyTextareaId).val();
		$(this.bodyId).text(this.body);
		this.refreshBody();
	};
	
	this.setPoll = function(){
		this.refreshPoll();
	};
	
	this.setBold = function(){
		var text = selectEdit($(this.bodyTextareaId), "[B]", "[/B]");
		$(this.bodyTextareaId).val(text);
		this.refresh();
	};

	this.setItalic = function(){
		var text = selectEdit($(this.bodyTextareaId), "[I]", "[/I]");
		$(this.bodyTextareaId).val(text);
		this.refresh();
	};
	
	this.refresh = function(){
		this.setTitle();
		this.setBlogText();
		this.setPoll();
	};
	
	this.refreshComponent = function(id){
		for(property in this.components){
			this.components[property].refreshId(id);
		}
	};

	this.refreshTitle = function(){
		this.refreshComponent(this.titleId);
	};
	
	this.refreshBody = function(){
		this.replaceSpecialChars();
		this.refreshComponent(this.bodyId);
	};
	
	this.refreshPoll = function(){
		this.refreshComponent(this.pollId);
	};
	
	this.replaceSpecialChars = function(){
		var text = $(this.bodyId).html();
		text = replaceRegExp(text, "\\[B\\]", "<b>");
		text = replaceRegExp(text, "\\[/B\\]", "</b>");
		text = replaceRegExp(text, "\\[I\\]", "<i>");
		text = replaceRegExp(text, "\\[/I\\]", "</i>");
		text = replaceRegExp(text, "(\\n|\\r)", "</br>");
		$(this.bodyId).html(text);
	};
	
	this.save = function(){
		$('body').css({'cursor':'wait'});
		$('#body_right a').css({'cursor':'wait'});
		if (editor.id > 0){
			url = BASE_URL + "index.php/admin/message/save_new_message/" + editor.id + "/" + editor.lang;
		}
		else{
			url = BASE_URL + "index.php/admin/message/save_new_message";
		}
		var post = $.post(url, this.getSendableData());
		post.done(function(data, textStatus, jqXHR){
			if (jqXHR.responseText == "" || jqXHR.responseText == "fail"){
				redirect(BASE_URL + "index.php/admin/message/error_save");
			}
			else if (jqXHR.responseText == "success"){
				redirect(BASE_URL + "index.php/admin/message");
			}
			else{
				$("#result").html(jqXHR.responseText);
			}
			$('body').css({'cursor':'default'});
			$('#body_right a').css({'cursor':'default'});
		});
		post.fail(function(jqXHR, textStatus, errorThrown){
			if (jqXHR.responseText == "" || jqXHR.responseText == "fail"){
				redirect(BASE_URL + "index.php/admin/message/error_save");
			}
			else{
				$("#result").html(jqXHR.responseText);
			}
		});
	};
	
	this.getSendableData = function(){
		var sendData = {
			titleTextarea: this.title,
			bodyTextarea: this.body,
			title: encodeURI($(this.titleId).html()),
			body: encodeURI($(this.bodyId).html()),
			link: this.components.link.getSendableData(),
			poll: this.components.poll.getSendableData(),
			poll_question: this.components.poll.question,
			poll_question_en: this.components.poll.question_en,
		};
		return sendData;
	};
}

function LinkComponent(){
	this.size = 0;
	this.selected = 0;
	this.list = [];
	this.appliable = ['#message_text', '#message_title'];
	this.refreshable = ['#message_body', '#message_body_title'];
	
	this.setSelected = function(selected){
		if (selected <= this.size){
			this.selected = selected;
			if (selected > 0){
				this.list[selected - 1].setForm();
			}
			else{
				$("#message_link_link").val("");
				$("#message_link_text").val("");
			}
		}
	};
	
	this.setList = function(){
		id = this.selected;
		if (id == 0){
			id = this.size;
			this.size++;
		}
		else{
			id--;
		}
		this.list[id] = new BlogLink($("#message_link_link").val(), $("#message_link_text").val());
		this.render();
		this.setSelected(0);
		editor.refresh();
	};
	
	this.loadList = function(text, link){
		this.list[this.size] = new BlogLink(link, text);
		this.size++;
	};
	
	this.render = function(){
		var html = "";
		for (var i = 0; i < this.size; i++){
			html += this.list[i].render(i);
		}
		$("#message_link_list").html(html);
	};
	
	this.preview = function(text){
		for (var i = 0; i < this.size; i++){
			text = replaceRegExp(text, '\\[' + BLOG_LINK + (i + 1) + '\\]', '<a href="'+ this.list[i].link + '" target="_blank">' + this.list[i].text + '</a>');
		}
		return text;
	};
	
	this.removeList = function(id){
		for (var i = (id - 1); i < (this.size - 1); i++){
			this.list[i] = this.list[i + 1];
		}
		this.removeAppliable(id);
		this.size--;
		this.render();
		editor.refresh();
	};
	
	this.removeAppliable = function(id){
		for (a in this.appliable){
			removeTextarea(id, BLOG_LINK, this.size, this.appliable[a]);
		}
	};
	
	this.refreshId = function(id){
		if (this.refreshable.indexOf(id) != -1){
			var text = $(id).html();
			text = this.preview(text);
			$(id).html(text);
		}
	};
	
	this.getSendableData = function(){
		var sendData = [];
		for (var i = 0; i < this.size; i++){
			sendData[i] = this.list[i].getSendableData();
		}
		return sendData;
	};
}

function PollComponent(){
	this.size = 0;
	this.selected = 0;
	this.list = [];
	this.appliable = [];
	this.refreshable = ['#message_body_poll'];
	this.question = "";
	this.question_en = "";
	
	this.setSelected = function(selected){
		if (selected <= this.size){
			this.selected = selected;
			if (selected > 0){
				this.list[selected - 1].setForm();
			}
			else{
				$("#message_poll_answer").val("");
				$("#message_poll_answer_en").val("");
			}
		}
	};
	
	this.setQuestion = function(){
		this.question = $("#message_poll_question").val();
		this.question_en = $("#message_poll_question_en").val();
		this.preview_question();
	};
	
	this.setList = function(){
		if ($("#message_poll_answer").val() != "" && $("#message_poll_answer_en").val() != ""){
			id = this.selected;
			if (id == 0){
				id = this.size;
				this.size++;
			}
			else{
				id--;
			}
			this.list[id] = new BlogPoll($("#message_poll_answer").val(), $("#message_poll_answer_en").val());
			this.render();
			this.setSelected(0);
			editor.refresh();
		}
	};
	
	this.loadList = function(answer, answer_en){
		this.list[this.size] = new BlogPoll(answer, answer_en);
		this.size++;
	};
	
	this.render = function(){
		var html = "";
		for (var i = 0; i < this.size; i++){
			html += this.list[i].render(i);
		}
		$("#message_poll_list").html(html);
	};
	
	this.preview_question = function(){
		if (editor.lang == "sk"){
			$("#message_body_poll_question").html(this.question);
		}
		else{
			$("#message_body_poll_question").html(this.question_en);
		}
	};
	
	this.preview = function(){
		var text = "<ol>";
		for (var i = 0; i < this.size; i++){
			text += "<li>" + this.list[i].preview_value() + "</li>"; 
		}
		text += "</ol>";
		return text;
	};
	
	this.removeList = function(id){
		for (var i = (id - 1); i < (this.size - 1); i++){
			this.list[i] = this.list[i + 1];
		}
		this.removeAppliable(id);
		this.size--;
		this.render();
		editor.refresh();
	};
	
	this.removeAppliable = function(id){
		for (a in this.appliable){
			
		}
	};
	
	this.refreshId = function(id){
		if (this.refreshable.indexOf(id) != -1){
			text = this.preview();
			$(id).html(text);
		}
	};
	
	this.getSendableData = function(){
		var sendData = [];
		for (var i = 0; i < this.size; i++){
			sendData[i] = this.list[i].getSendableData();
		}
		return sendData;
	};
}

function BlogLink(link, text){
	var regexp = new RegExp("^(http|https)://.+");
	if (regexp.test(link)){
		this.link = link;
	}
	else{
		this.link = "http://" + link;
	}
	this.text = text;
	
	this.setForm = function(){
		$("#message_link_link").val(this.link);
		$("#message_link_text").val(this.text);
	};
	
	this.render = function(i){
		var ret = "<div id='link_" + (i + 1) + "' onMouseover='toggleVisibility(\"#link_" + (i + 1) + " .cancel_cross\");toggleVisibility(\"#link_" + (i + 1) + " .blog_edit_command\");' onMouseout='toggleVisibility(\"#link_" + (i + 1) + " .cancel_cross\");toggleVisibility(\"#link_" + (i + 1) + " .blog_edit_command\");'>" +
		"<div class='clickable' style='float:left; width: 150px; white-space: nowrap;' onClick='editor.components.link.setSelected(" + (i + 1) + ");'>" + this.text + " | " + this.link + "</div>" +
		"<div class='blog_edit_command'>[" + BLOG_LINK + (i + 1) + "]</div>" +
		"<div class='cancel_cross clickable' style='float: right; display: none;' onClick='editor.components.link.removeList(" + (i + 1) + ");'></div>" +
		"</div>";
		return ret;
	};
	
	this.getSendableData = function(){
		var sendData = {
			text: this.text,
			link: encodeURI(this.link),
		};
		return sendData;
	};
}

function BlogPoll(answer, answer_en){
	this.answer = answer;
	this.answer_en = answer_en;
	
	this.setForm = function(){
		$("#message_poll_answer").val(this.answer);
		$("#message_poll_answer_en").val(this.answer_en);
	};
	
	this.render = function(i){
		var ret = "<div id='poll_" + (i + 1) + "' onMouseover='toggleVisibility(\"#poll_" + (i + 1) + " .cancel_cross\");' onMouseout='toggleVisibility(\"#poll_" + (i + 1) + " .cancel_cross\");'>" +
		"<div class='clickable' style='float:left; width: 150px; white-space: nowrap;' onClick='editor.components.poll.setSelected(" + (i + 1) + ");'>" + this.preview_value() + "</div>" +
		"<div class='cancel_cross clickable' style='float: right; display: none;' onClick='editor.components.poll.removeList(" + (i + 1) + ");'></div>" +
		"</div>";
		return ret;
	};
	
	this.preview_value = function(){
		if (editor.lang == "sk"){
			return this.answer;
		}
		else{
			return this.answer_en;
		}
	};
	
	this.getSendableData = function(){
		var sendData = {
			answer: this.answer,
			answer_en: this.answer_en,
		};
		return sendData;
	};
}

/*
 * Functions
*/
function removeTextarea(id, command, size, formId){
	var html = $(formId).val();
	html = replaceRegExp(html, '\\[' + command + id + '\\]', '');
	for (var i = (id + 1); i <= size; i++){
		html = replaceRegExp(html, '\\[' + command + i + '\\]', '[' + command + (i - 1) + ']');
	}
	$(formId).val(html);
}

/*
* Logic
*/
var editor = new EditorApplication();
$(document).ready(function(){
	if (typeof load == 'function') { 
		load(); 
	}
	editor.refresh();
});