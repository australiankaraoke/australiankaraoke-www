// JavaScript Document

$(document).ready(function(){
	//	
	// alert("!"); NOT TRIGGERING
});

$(window).load(function(){
	//	
	//alert("!");
	$("#search_for_tracks").html("<div style='width: 100%; text-align: center;'><img src='/images/spinner-purple.gif' style='margin-top: 100px;' /></div>");
	$.get('/tracks-support-files/search_for_tracks.php?', function(tracksSearchResult) {
			$("#search_for_tracks").html(tracksSearchResult);
	});
	
});