/* This File Copyright © 2012 Frank Guetter / Codeien.com */
// FUNCTIONS

function thisFunction(a,b) {
	var x = a*b;
	return x;	
}

function temp_showDeviceType() {
	$('figure').fadeIn(96);
	$('figure').css({'zoom':'2'});
	window.setInterval("$('figure').fadeOut(2000);",1320);
	setTimeout(function(){
			window.scrollTo(0, 1);
	}, 0);
	
}

function temp_makeAsideDraggable() {
        $( "#aside1" ).draggable();
}

function initIOSTitle() {
	if( navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i) ){
		document.title = "Australian Karaoke Pty. Ltd. | Melbourne's No1 Shop for Complete Karaoke Systems, Machines, Components, Machines and Tracks!";
	}
}

function initHideMobileURLBar() {
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
}
