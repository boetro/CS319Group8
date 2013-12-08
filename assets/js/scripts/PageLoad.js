$(document).ready(function() {
	$('#new').on('click', function(event) {

		// if websocket connection is still open close it
		// Connection.remove();

		// unset gameID client side session
		Session.destroy({
			gamertag: false,
			id: false,
			gameId: true
		});

		$("#board").html('');
		$.ajax({
			url: 'new.html',
			type: 'POST',
			success: function() {}
		}).done(function(html) {
			$("#content").html(html);
		});
		event.preventDefault;
	});

	$('#current').on('click', function(event) {

		// if websocket connection is still open close it
		// Connection.remove();

		// unset gameID client side session
		Session.destroy({
			gamertag: false,
			id: false,
			gameId: true
		});

		$("#board").html('');
		$.ajax({
			url: 'current.html',
			type: 'POST',
			success: function() {}
		}).done(function(html) {
			$("#content").html(html);
		});
		event.preventDefault;
	});

	$('#highScores').on('click', function(event) {

		// if websocket connection is still open close it
		// Connection.remove();

		// unset gameID client side session
		Session.destroy({
			gamertag: false,
			id: false,
			gameId: true
		});

		$("#board").html('');
		$.ajax({
			url: 'highscores.html',
			type: 'POST',
			success: function() {}
		}).done(function(html) {
			$("#content").html(html);
		});
		event.preventDefault;
	});

	$('#help').on('click', function(event) {

		// if websocket connection is still open close it
		// Connection.remove();

		// unset gameID client side session
		Session.destroy({
			gamertag: false,
			id: false,
			gameId: true
		});

		$("#board").html('');
		$.ajax({
			url: 'help.html',
			type: 'POST',
			success: function() {}
		}).done(function(html) {
			$("#content").html(html);
		});
		event.preventDefault;
	});

	$('#settings').on('click', function(event) {

		// if websocket connection is still open close it
		// Connection.remove();

		// unset gameID client side session
		Session.destroy({
			gamertag: false,
			id: false,
			gameId: true
		});

		$("#board").html('');
		$.ajax({
			url: 'accountsettings.html',
			type: 'POST',
			success: function() {}
		}).done(function(html) {
			$("#content").html(html);
		});
		event.preventDefault;
	});

	$(document).on('click', '#delete', function(event) {
		event.stopPropagation();
		var panel = $(this).parents(".panel");
		var game_id = panel.attr("id");
		$.ajax({
			url: './php/scripts/delete_game.php',
			type: 'POST',
			data: {id : game_id}
		}).done(function(response) {
			$("#" + game_id).parent().remove();
		});
	});

	$(document).on('click', '.loadedGame', function() {
		var gameId = $(this).attr('id');
		var panel = $(this).parents(".panel");

		$('#content').empty();
		$.ajax({
			url: './gameboard.php',
			type: 'POST',
			data: {id : gameId}
		}).done(function(html) {
			$("#board").html(html);
			

			// set client side session to show that your currently in a board game view
			Session.set({
				gameId: gameId
			});

			// wait to load game board.js 
			loadGameBoard();
		});
	});
});
