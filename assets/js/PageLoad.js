$(document).ready(function() {
	$('#new').on('click', function(event) {
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
		$.ajax({
			url: 'accountsettings.html',
			type: 'POST',
			success: function() {}
		}).done(function(html) {
			$("#content").html(html);
		});
		event.preventDefault;
	});
});
