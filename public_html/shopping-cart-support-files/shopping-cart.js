// JavaScript Document

$(document).ready(function(){
	//	
	// alert("!"); NOT TRIGGERING
});

$(window).load(function(){
	//	
	//alert("!");
	$.get('/shopping-cart-support-files/cart-table.php', function(categoryMenu) {
			$("#cart_table").append(categoryMenu);
	});

});