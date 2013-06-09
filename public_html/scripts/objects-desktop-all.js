/* This File Copyright © 2012 Frank Guetter / Codeien.com */
// OBJECTS

function thisObject(someProperty) {
	// [see: http://www.javascriptkit.com/javatutors/oopjs2.shtml]
	
	//props
	this.myProperty = someProperty;
	//methods
	this.myMethod = function() {
		//console.log( this.myProperty );
	}
} 