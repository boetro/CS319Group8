/** 
 * Dependencies
 *
 * config.js
 */

/**
 * Module primarily used to interact with php scripts, to send and recieve data
 */
var Db = (function() {
	
	/* example 'public' function */
	var find = function(value, column, table) {
		
		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/test.php',
			type: 'POST',
			data: {value : value, column : column, table : table},
			success: function(response) {

				var jsonData = $.parseJSON(response);
				
				if(jsonData['error']) {
					
					throw "There was a problem with find() : " + jsonData['message'];
				} else {

					return jsonData;
				}
			},
			error: function(xhr, status, error) {
				
			}
		});
	};

	var makeUser = function(email, password, gamertag, theme_color) {

		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/addplayer.php',
			type: 'POST',
			data: {email : email, password : password, gamertag : gamertag, theme_color : theme_color},
			success: function(response) {

				var jsonData = $.parseJSON(response);

				if(jsonData['error']) {

					throw "There was a problem with makeUser() : " + jsonData['message'];
				} else {
					
					return jsonData;
				}
			},
			error: function(xhr, status, error) {

			}
		});
	};

	var updateUser = function(value, column) {

		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/updatePlayer.php',
			type: 'POST',
			data: {column : column, value : value},
			success: function(response) {
				console.log(response);
				var jsonData = $.parseJSON(response);
				console.log(response);
				return jsonData;
			},
			error: function(xhr, status, error) {

			}
		});
	};

	return {
		find:find,
		makeUser:makeUser,
		updateUser:updateUser
	};
})();