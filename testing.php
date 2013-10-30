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
		var findPromise = Db.find('holdenrehg@gmail.com', 'email', 'player');
		
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
	</script>
</body>
</html>