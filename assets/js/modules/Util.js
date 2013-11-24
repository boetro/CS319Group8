var Util = (function() {

	/**
	 * Recursively searches array and parses the json for all elements 
	 * Will fail if an array not containing valid json is passed in as an argument
	 *
	 * @param array any size containing valid json
	 */
	var arrayToJson = function(array) {
		if( !(array instanceof Array) ) {
			throw "Array to json method requires paramter to be an array";
		}

		// iteratoe through array elements, if contains more arrays, recursively call this function, else parse the json
		for(var i = 0; i < array.length; i+=1) {
			if(array[i] instanceof Array) {
				arrayToJson(array[i]);
			} else {
				array[i] = $.parseJSON(array[i]);
			}
		}
	};

	return {
		arrayToJson: arrayToJson
	};
}());