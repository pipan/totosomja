function cancel_filter_proces(){
	redirect(BASE_URL + "index.php/" + $('#page_language').val() + "/shirt");
}
function filter_proces(){
	redirect(BASE_URL + "index.php/" + $('#page_language').val() + "/shirt/1/" + get_filter_url());
}
function get_filter_url(){
	var gender = "";
	var size = "";
	var color = "";
	var price = "";
	if ($('#product_filter_gender').val() != undefined){
		gender = $('#product_filter_gender').val();
	}
	if ($('#product_filter_size').val() != undefined){
		size = $('#product_filter_size').val();
	}
	if ($('#product_filter_color').val() != undefined){
		color = $('#product_filter_color').val();
	}
	if ($('#product_filter_price').val() != undefined){
		price = $('#product_filter_price').val();
	}
	return gender + "-" + size + "-" + color + "-" + price; 
}