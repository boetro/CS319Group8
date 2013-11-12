$(document).ready(function () {

	$("#update").on("click", function() {

		var bgColor = $("body").css("background-color");

		var json = updateUser("root", bgColor, "theme_color");
		console.log(json);
	});


	var updateUser = function(selector, value, column) {

		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/updatePlayer.php',
			type: 'POST',
			data: {gamertag : selector, column : column, value : value},
			success: function(response) {
				var jsonData = $.parseJSON(response);

				if(jsonData['error']) {

					throw "There was a problem with updateUser() : " + jsonData['message'];
				} else {
					return jsonData;
				}
			},
			error: function(xhr, status, error) {

			}
		});
	};

});

var CONFIG = {
	Dir : 'http://localhost/se319project/CS319Group8/',
};