/* This File Copyright © 2012 Frank Guetter / Codeien.com */
// GLOBALS

_localStorage = true;



// ON READY (DOM loaded, no images) [see: http://forum.jquery.com/topic/document-ready-and-window-onload-difference]

$(document).ready(function(){
	
	// TEMP DOM READY
	//console.log( "DOM (document object model) READY [fires first][no images]:: " );
	
	// TEMP OBJECT TEST
	myObject1 = new thisObject("myPropertyLiteralBefore");
	myObject1.myMethod();
	myObject1.myProperty = "myPropertyLiteralAfter";
	myObject1.myMethod();
	
	// TEMP SHOW DEVICE TYPE
	//temp_showDeviceType();
	
	// TEMP MAKE ASIDE DRAGGABLE
	temp_makeAsideDraggable();
	
	
	// INIT LOCAL STORAGE DETECT
	if (Modernizr.localstorage) {
	  localStorage.setItem("localStorageItem", "localStorageLiteral");
	  //console.log("LOCAL STORAGE DETECTION - localStorageItem:"+localStorage.getItem("localStorageItem"));
	} else {
	  alert("Bad Browser! No LocalStorage available!!");
	}
	
	// INIT iOS TITLE TAG (for "Save To Home Screen")
	initIOSTitle();
	
	// INIT Smartphone HIDE URL BAR
	initHideMobileURLBar();
	
	// MENU HORIZONTAL NAV
	$('.full-width').horizontalNav({});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});