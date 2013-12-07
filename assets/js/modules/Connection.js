var Connection = (function() {
	var connection;

	var set = function(toSet) {

		connection = toSet;
	};

	var remove = function() {

		if(connection) {

			console.log("connection is still open. closing...");
			connection.close();
			connection = undefined;
		}
	};

	return {
		set: set,
		remove: remove
	};
})();