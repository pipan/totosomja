/*
 * Globals
 */
var BLOG_LINK = "LINK-";
var BLOG_IMAGE = "IMAGE-";
var BLOG_VIDEO = "VIDEO-";

/*
 * Classes
 */
function EditorApplication(){
	this.components = {
		link: new LinkComponent(),
		image: new ImageComponent(),
		video: new VideoComponent(),
		tag: new TagComponent(),
	};
	this.bodyId = "#blog_body"; 
	this.bodyTextareaId = "#blog_text";
	this.titleId = "#blog_body_title";
	this.titleTextareaId = "#blog_title";
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
	
	this.replaceSpecialChars = function(){
		var text = $("#blog_body").html();
		text = replaceRegExp(text, "\\[B\\]", "<b>");
		text = replaceRegExp(text, "\\[/B\\]", "</b>");
		text = replaceRegExp(text, "\\[I\\]", "<i>");
		text = replaceRegExp(text, "\\[/I\\]", "</i>");
		text = replaceRegExp(text, "(\\n|\\r)", "</p><p>");
		text = "<p>" + text + "</p>";
		$("#blog_body").html(text);
	};
	
	this.save = function(){
		$('body').css({'cursor':'wait'});
		$('#body_right a').css({'cursor':'wait'});
		if (editor.id > 0){
			url = BASE_URL + "index.php/admin/blog/save_new_blog/" + editor.id + "/" + editor.lang;
		}
		else{
			url = BASE_URL + "index.php/admin/blog/save_new_blog";
		}
		var post = $.post(url, this.getSendableData());
		post.done(function(data, textStatus, jqXHR){
			if (jqXHR.responseText == "" || jqXHR.responseText == "fail"){
				redirect(BASE_URL + "index.php/admin/blog/error_save");
			}
			else if (jqXHR.responseText == "success"){
				redirect(BASE_URL + "index.php/admin/blog");
			}
			else{
				$("#result").html(jqXHR.responseText);
			}
			$('body').css({'cursor':'default'});
			$('#body_right a').css({'cursor':'default'});
		});
		post.fail(function(jqXHR, textStatus, errorThrown){
			if (jqXHR.responseText == "" || jqXHR.responseText == "fail"){
				redirect(BASE_URL + "index.php/admin/blog/error_save");
			}
			else{
				$("#result").html(jqXHR.responseText);
			}
			$('body').css({'cursor':'default'});
			$('#body_right a').css({'cursor':'default'});
		});
	};
	
	this.getSendableData = function(){
		var sendData = {
			titleTextarea: this.title,
			bodyTextarea: this.body,
			title: encodeURI($(this.titleId).html()),
			body: encodeURI($(this.bodyId).html()),
			link: this.components.link.getSendableData(),
			image: this.components.image.getSendableData(),
			video: this.components.video.getSendableData(),
			tag: this.components.tag.getSendableData(),
			thumbnail: this.components.tag.thumbnail,
			series: this.components.tag.series,
		};
		return sendData;
	};
}

function LinkComponent(){
	this.size = 0;
	this.selected = 0;
	this.list = [];
	this.appliable = ['#blog_text', '#blog_title'];
	this.refreshable = ['#blog_body', '#blog_body_title'];
	
	this.setSelected = function(selected){
		if (selected <= this.size){
			this.selected = selected;
			if (selected > 0){
				this.list[selected - 1].setForm();
			}
			else{
				$("#blog_link_link").val("");
				$("#blog_link_text").val("");
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
		this.list[id] = new BlogLink($("#blog_link_link").val(), $("#blog_link_text").val());
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
		$("#blog_link_list").html(html);
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

function ImageComponent(){
	this.size = 0;
	this.selected = 0;
	this.list = [];
	this.appliable = ['#blog_text'];
	this.refreshable = ['#blog_body'];
	
	this.setSelected = function(selected){
		if (selected <= this.size){
			this.selected = selected;
			if (selected > 0){
				this.list[selected - 1].setForm();
			}
			else{
				$("#blog_image_link").val("");
				$("#blog_image_text").val("");
				$("#blog_image_width").val("");
				$("#blog_image_alignment").val("");
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
		this.list[id] = new BlogImage($("#blog_image_link").val(), $("#blog_image_text").val(), $("#blog_image_width").val(), $('input[name=image_alignment]:checked', '#blog_image_form').val());
		this.render();
		this.renderThumbnailSelect(0);
		this.setSelected(0);
		editor.refresh();
	};
	
	this.loadList = function(text, link, width, alignment){
		this.list[this.size] = new BlogImage(link, text, width, alignment);
		this.size++;
	};
	
	this.render = function(){
		var html = "";
		for (var i = 0; i < this.size; i++){
			html += this.list[i].render(i);
		}
		$("#blog_image_list").html(html);
	};
	
	this.renderThumbnailSelect = function(deleted){
		var html = "<option value='0'>none</option>";
		for (var i = 0; i < this.size; i++){
			html += this.list[i].renderSelect((i + 1));
		}
		$("#blog_tag_thumbnail").html(html);
		editor.components.tag.setThumbnail(deleted);
	};
	
	this.preview = function(text){
		for (var i = 0; i < this.size; i++){
			text = replaceRegExp(text, '\\[' + BLOG_IMAGE + (i + 1) + '\\]', '<img style="width: ' + this.list[i].width + 'px;float: ' + this.list[i].alignment + ';" src="'+ this.list[i].link + '" alt="' + this.list[i].text + '" />');
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
		this.renderThumbnailSelect(id);
		editor.refresh();
	};
	
	this.removeAppliable = function(id){
		for (a in this.appliable){
			removeTextarea(id, BLOG_IMAGE, this.size, this.appliable[a]);
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

function VideoComponent(){
	this.size = 0;
	this.selected = 0;
	this.list = [];
	this.appliable = ['#blog_text'];
	this.refreshable = ['#blog_body'];
	
	this.setSelected = function(selected){
		if (selected <= this.size){
			this.selected = selected;
			if (selected > 0){
				this.list[selected - 1].setForm();
			}
			else{
				$("#blog_video_link").val("");
				$("#blog_video_text").val("");
				$("#blog_video_width").val("");
				$("#blog_video_alignment").val("");
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
		this.list[id] = new BlogVideo($("#blog_video_link").val(), $("#blog_video_text").val(), $("#blog_video_width").val(), $('input[name=video_alignment]:checked', '#blog_video_form').val());
		this.render();
		this.setSelected(0);
		editor.refresh();
	};
	
	this.loadList = function(text, link, width, alignment, code){
		this.list[this.size] = new BlogVideo(link, text, width, alignment);
		this.list[this.size].code = code;
		this.size++;
	};
	
	this.render = function(){
		var html = "";
		for (var i = 0; i < this.size; i++){
			html += this.list[i].render(i);
		}
		$("#blog_video_list").html(html);
	};
	
	this.preview = function(text){
		for (var i = 0; i < this.size; i++){
			text = replaceRegExp(text, '\\[' + BLOG_VIDEO + (i + 1) + '\\]', this.list[i].embed());
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
			removeTextarea(id, BLOG_VIDEO, this.size, this.appliable[a]);
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

function TagComponent(){
	this.size = 0;
	this.selected = 0;
	this.list = [];
	this.thumbnail = 0;
	this.series = 0;
	this.appliable = [];
	this.refreshable = [];
	
	this.setThumbnail = function(deleted){
		if (deleted > 0){
			if (deleted == this.thumbnail){
				this.thumbnail = 0;
			}
			else if (deleted < this.thumbnail){
				this.thumbnail--;
			}
		}
		this.refreshThumbnail();
	};
	
	this.changeThumbnail = function(){
		this.thumbnail = $("#blog_tag_thumbnail").val();
	};
	
	this.setSeries = function(){
		this.series = $("#blog_tag_series").val();
	};
	
	this.refreshThumbnail = function(){
		$("#blog_tag_thumbnail").val(this.thumbnail);
	};
	
	this.setSelected = function(selected){
		if (selected <= this.size){
			this.selected = selected;
			if (selected > 0){
				this.list[selected - 1].setForm();
			}
			else{
				$("#blog_tag_text").val("");
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
		this.list[id] = new BlogTag($("#blog_tag_text").val());
		this.render();
		this.setSelected(0);
	};
	
	this.loadList = function(tag){
		this.list[this.size] = new BlogTag(tag);
		this.size++;
	};
	
	this.render = function(){
		var html = "";
		for (var i = 0; i < this.size; i++){
			html += this.list[i].render(i);
		}
		$("#blog_tag_list").html(html);
	};
	
	this.preview = function(text){
		for (var i = 0; i < this.size; i++){
			
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
	};
	
	/*
	 * tagy sa nebudu aplikovat v texte tak sa nemozu ani vymazavat
	 */
	this.removeAppliable = function(id){
		for (a in this.appliable){
			
		}
	};
	
	/*
	 * tagy sa nebudu refreshovat v blogu
	 */
	this.refreshId = function(id){
		if (this.refreshable.indexOf(id) != -1){
			
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
		$("#blog_link_link").val(this.link);
		$("#blog_link_text").val(this.text);
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

function BlogImage(link, text, width, alignment){
	this.link = link;
	this.text = text;
	this.width = width;
	this.alignment = alignment;
	
	this.setForm = function(){
		$("#blog_image_link").val(this.link);
		$("#blog_image_text").val(this.text);
		$("#blog_image_width").val(this.width);
		$("#blog_image_alignment").val(this.alignment);
	};
	
	this.render = function(i){
		var ret = "<div id='image_" + (i + 1) + "' style='height: 50px;' onMouseover='toggleVisibility(\"#image_" + (i + 1) + " .cancel_cross\");toggleVisibility(\"#image_" + (i + 1) + " .blog_edit_command\");' onMouseout='toggleVisibility(\"#image_" + (i + 1) + " .cancel_cross\");toggleVisibility(\"#image_" + (i + 1) + " .blog_edit_command\");'>" +
			"<div class='clickable' style='float:left; width: 150px; white-space: nowrap;' onClick='editor.components.image.setSelected(" + (i + 1) + ");'>" +
				"<img style='width: 50px;' src='" + this.link + "' alt='" + this.link + "' /> "+ 
			"</div>" +
			"<div class='blog_edit_command'>[" + BLOG_IMAGE + (i + 1) + "]</div>" +
			"<div class='cancel_cross clickable' style='float: right; display: none;' onClick='editor.components.image.removeList(" + (i + 1) + ");'></div>" +
			"</div>";
		return ret;
	};
	
	this.renderSelect = function(i){
		var ret = "";
		ret = "<option value='" + i + "'>" + this.text + " - [" + BLOG_IMAGE + i + "]</option>";
		return ret;
	};
	
	this.getSendableData = function(){
		var sendData = {
			text: this.text,
			link: encodeURI(this.link),
			alignment: this.alignment,
			width: this.width,
		};
		return sendData;
	};
}

function BlogVideo(link, text, width, alignment){
	this.link = link;
	this.text = text;
	this.width = width;
	this.alignment = alignment;
	this.code = undefined;
	
	this.setForm = function(){
		$("#blog_video_link").val(this.link);
		$("#blog_video_text").val(this.text);
		$("#blog_video_width").val(this.width);
		$("#blog_video_alignment").val(this.alignment);
	};
	
	this.render = function(i){
		var ret = "<div id='video_" + (i + 1) + "' onMouseover='toggleVisibility(\"#video_" + (i + 1) + " .cancel_cross\");toggleVisibility(\"#video_" + (i + 1) + " .blog_edit_command\");' onMouseout='toggleVisibility(\"#video_" + (i + 1) + " .cancel_cross\");toggleVisibility(\"#video_" + (i + 1) + " .blog_edit_command\");'>" +
			"<div class='clickable' style='float:left; width: 150px; white-space: nowrap;' onClick='editor.components.video.setSelected(" + (i + 1) + ");'>" + this.text + "</div>" +
			"<div class='blog_edit_command'>[" + BLOG_VIDEO + (i + 1) + "]</div>" +
			"<div class='cancel_cross clickable' style='float: right; display: none;' onClick='editor.components.video.removeList(" + (i + 1) + ");'></div>" +
			"</div>";
		return ret;
	};
	
	this.getType = function(){
		var type = undefined;
		var regexp = new RegExp('.*www.youtube.com.*');
		if (regexp.test(this.link)){
			type = 'youtube';
		}
		return type;
	};
	
	this.getLinkCode = function(){
		if (code == undefined){
			var code = "";
			switch(this.getType()){
			case 'youtube':
				var regexp = new RegExp('v=[^&]+');
				code = this.link.match(regexp);
				code = code.toString();
				code = code.substring(2, code.length);
				break;
			default:
				code = "";
				break;
			}
			this.code = code;
		}
		return this.code;
	};
	
	this.embed = function(){
		var text = "";
		if (this.getType() == 'youtube'){
			text = "<iframe style='float: " + this.alignment + ";' width='" + this.width + "' height='" + ((this.width / 16) * 9) + "' src='//www.youtube.com/embed/" + this.getLinkCode() + "' frameborder='0' allowfullscreen></iframe>";
		}
		return text;
	};
	
	this.getSendableData = function(){
		var sendData = {
			text: this.text,
			link: encodeURI(this.link),
			alignment: this.alignment,
			width: this.width,
			code: this.code,
		};
		return sendData;
	};
}

function BlogTag(text){
	this.text = text.toLowerCase();
	
	this.setForm = function(){
		$("#blog_tag_text").val(this.text);
	};
	
	this.render = function(i){
		var ret = "<div id='tag_" + (i + 1) + "' onMouseover='toggleVisibility(\"#tag_" + (i + 1) + " .cancel_cross\");' onMouseout='toggleVisibility(\"#tag_" + (i + 1) + " .cancel_cross\");'>" +
			"<div class='clickable' style='float:left; width: 150px; white-space: nowrap;' onClick='editor.components.tag.setSelected(" + (i + 1) + ");'>" + this.text + "</div>" +
			"<div class='cancel_cross clickable' style='float: right; display: none;' onClick='editor.components.tag.removeList(" + (i + 1) + ");'></div>" +
			"</div>";
		return ret;
	};
	
	this.getSendableData = function(){
		var sendData = {
			text: this.text,
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