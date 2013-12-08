var Connection = (function() {
	var connection;

	var set = function(toSet) {

		connection = toSet;
	};

	var remove = function() {

		if(connection) {

			console.log("connection is still open. closing...");
			connection.send(JSON.stringify({
				message: '',
				type: 'disconnect',
				user: localStorage.id,
				game: localStorage.gameId
			}));
		}
	};

	return {
		set: set,
		remove: remove
	};
})();