<?php
session_start();
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Testing</title>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="assets/js/config.js"></script>
	<script src="assets/js/modules/Db.js"></script>
	<script src="assets/js/modules/Util.js"></script>
	<script src="assets/js/modules/Session.js"></script>
</head>
<body>
	<script>
		// WebSockets Testing

		// initialize web sockets
		/*var websocket = new WebSocket('<?= "ws://localhost:9000/" . $_SESSION["gamertag"] . "?30" ?>');

		console.log('creating web socket connection...');

		websocket.onopen = function(event) {
			console.log("connection established");
			console.log(event);

			// websocket.send("testing");
		}

		websocket.onclose = function(event) {
			console.log("connection closed");
		}

		websocket.onmessage = function(event) {
			// console.log(event);
			console.log("message recieved from the server : " + event.data);
			console.log("message type : " + event.type);
		}*/

		// Web Storage Testing

		console.log(localStorage);
		Session.set({
			firstname: "Holden",
			lastname: "Rehg"
		});

		console.log(localStorage);

		// this should destory nothing
		Session.destroy({
			firstname: false,
			lastname: false
		});

		console.log(localStorage);

		// this should destroy everything except for firstname
		Session.destroy();

		console.log(localStorage);

		// PHP Ajax Module Testing

		// value, column, table
		// var findPromise = Db.find('poop@poo.com', 'email', 'player');
		
		// after your promise resolves
		/*findPromise.done(function(result) {
			console.log($.parseJSON(result));
		});*/ 

		// email, password, gamertag, theme_color
		/*var makePromise = Db.makeUser('holdenrehg@gmail.com', 'password', 'tag', 'blue');
		
		// after your promise resolves
		makePromise.done(function(result) {
			if(result) {

				result = $.parseJSON(result);
				console.log($.parseJSON(result['before']));
				console.log($.parseJSON(result['after']));
			} else {
				console.log('Could not make user');
			}
		});*/

		/*var makeGamePromise = Db.makeGame(64, 65, 5, 5);

		makeGamePromise.success(function(response) {
			var jsonData = $.parseJSON(response);
			jsonData.game = $.parseJSON(jsonData.game);
			
			console.log(jsonData.game.player1);
			jsonData.game.player1 = $.parseJSON(jsonData.game.player1);
			jsonData.game.player2 = $.parseJSON(jsonData.game.player2);
			jsonData.game.board = $.parseJSON(jsonData.game.board);

			console.log(jsonData);
		});*/

		/*var findGamePromise = Db.find('10', 'id', 'game');

		findGamePromise.success(function(result) {
			var game = $.parseJSON(result);
			console.log(game);

			var board = $.parseJSON(game.board);
			Util.arrayToJson(board);
			console.log(board);
		});*/
	</script>
</body>
</html>