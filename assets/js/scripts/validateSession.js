// var sessionVars = function() {

// 	return $.ajax({
// 		url: CONFIG.Dir + 'php/scripts/getSession.php',
// 		type: 'POST',
// 		success: function(response) {
// 			console.log(response);
// 			try{
// 				var jsonData = $.parseJSON(response);
// 				if(jsonData['error']) {
// 					window.location.replace("login.html");
// 				} else {
// 					return jsonData;
// 				}
// 			}catch (err){
// 				window.location.replace("login.html");
// 			}
// 		},
// 		error: function(xhr, status, error) {

// 		}
// 	});
// };
// var CONFIG = {
// 	Dir : 'http://localhost/se319project/CS319Group8/',
// };

// var x = sessionVars();
// console.log(x);

