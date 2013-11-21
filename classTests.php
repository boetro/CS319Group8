<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Testing</title>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="assets/js/config.js"></script>
	<script src="assets/js/modules/Db.js"></script>
</head>
<body>
	
	<script>

		// value, column, table
		var findPromise = Db.find('poop@poo.com', 'email', 'player');
		
		// after your promise resolves
		findPromise.done(function(result) {
			console.log($.parseJSON(result));
		});

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

		var makeGamePromise = Db.makeGame(64, 65, 5, 5);

		makeGamePromise.success(function(response) {
			var jsonData = $.parseJSON(response);
			jsonData.game = $.parseJSON(jsonData.game);
			
			console.log(jsonData.game.player1);
			jsonData.game.player1 = $.parseJSON(jsonData.game.player1);
			jsonData.game.player2 = $.parseJSON(jsonData.game.player2);
			jsonData.game.board = $.parseJSON(jsonData.game.board);

			console.log(jsonData);
		});

		var findGamePromise = Db.find('1', 'id', 'game');

		findGamePromise.success(function(result) {
			console.log($.parseJSON(result));
		});
	</script>
</body>
</html>