var selectEditOffset = 1;

function selectEdit(o, start, end){
	var text = o.val();
	var selection = text.substring(o[0].selectionStart, o[0].selectionEnd);
	if (selection.length > 0){
		var selectionStartIndex = selection.indexOf(start); 
		var selectionEndIndex = selection.lastIndexOf(end);
		if (selectionStartIndex > -1 && selectionStartIndex < selectEditOffset && selectionEndIndex > selection.length - end.length - selectEditOffset - 1){
			selection = selection.substring(0, selectionStartIndex) + selection.substring(selectionStartIndex + start.length, selectionEndIndex) + selection.substring(selectionEndIndex + end.length, selection.length);
		}
		else{
			selection = start + text.substring(o[0].selectionStart, o[0].selectionEnd) + end;
		}
		text = text.substring(0, o[0].selectionStart) + selection + text.substring(o[0].selectionEnd, text.length);
	}
	return text;
}