$(document).ready(function() {
	$('#new').on('click', function(event) {
		$.ajax({
			url: '../../new.html',
			type: 'POST',
			success: function() {}
		});
		event.preventDefault;
	});
	$('#current').on('click', function(event) {
		$.ajax({
			url: '../../current.html',
			type: 'POST',
			success: function() {}
		});
		event.preventDefault;
	});
	$('#highScores').on('click', function(event) {
		$.ajax({
			url: '../../highscores.html',
			type: 'POST',
			success: function() {}
		});
		event.preventDefault;
	});
	$('#help').on('click', function(event) {
		$.ajax({
			url: '../../help.html',
			type: 'POST',
			success: function() {}
		});
		event.preventDefault;
	});
});