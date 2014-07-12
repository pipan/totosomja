function cancel_filter_proces(){
	redirect(BASE_URL + "index.php/" + $('#page_language').val() + "/shirt");
}
function filter_proces(){
	redirect(BASE_URL + "index.php/" + $('#page_language').val() + "/shirt/1/" + get_filter_url());
}
function get_filter_url(){
	return $('#product_filter_gender').val() + "-" + $('#product_filter_size').val() + "-" + $('#product_filter_color').val() + "-" + $('#product_filter_price').val(); 
}