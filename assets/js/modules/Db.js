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
	var find = function(id, tableName) {
		
		$.ajax({
			url: CONFIG.Dir + 'php/scripts/test.php',
			type: 'GET',
			data: {id : id, tableName : tableName},
			success: function(response) {
				if(response) {
					console.log($.parseJSON(response));
				} else {
					console.log("Sorry, that user does not exist.");
				}
			},
			error: function(xhr, status, error) {
				
			}
		});
	};

	return {
		find:find,
	};
})();