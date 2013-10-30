/** 
 * Dependencies
 *
 * config.js
 */

/**
 * Module primarily used to interact with php scripts, to send and recieve data
 */
var Db = (function() {

	/* can use '_' to denote a 'private' variable / function */
	var _examplePrivate = 0;
	
	/* example 'public' function */
	var find = function(value, column, table) {
		
		$.ajax({
			url: CONFIG.Dir + 'php/scripts/test.php',
			type: 'GET',
			data: {value : value, column : column, table : table},
			success: function(response) {

				var jsonData = $.parseJSON(response);

				if(jsonData['error']) {
					console.log(jsonData['message']);
				} else {
					console.log(jsonData);
				}
			},
			error: function(xhr, status, error) {
				
			}
		});
	};

	var makeUser() = function() {

	};

	return {
		find:find,
		makeUser:makeUser,
	};
})();