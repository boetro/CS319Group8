var Session = (function() {
	
	/**
	 * Adds key value pairs to local storage 
	 */
	var set = function(obj) {
		if(typeof obj !== "object") {
			throw "must pass an object of session data to be set into the session init function";
		}

		for(var prop in obj) {

			localStorage[prop] = obj[prop];
		}
	};

	/**
	 * Delete all local storage except properties specified in parameter object
	 */
	var destroy = function(obj) {

		obj = obj || {};
		if(typeof obj !== "object") {
			throw "must pass an object of session data to be set into the session destroy function";
		}

		for(var prop in localStorage) {
			
			// local storage properties will be removed if the property is not specified in the obj or if it is set to false
			if( (obj.hasOwnProperty(prop) && obj[prop]) || !obj.hasOwnProperty(prop)) {
				delete localStorage[prop];
			}
		}
	}

	return {
		set:set,
		destroy:destroy
	};
})();