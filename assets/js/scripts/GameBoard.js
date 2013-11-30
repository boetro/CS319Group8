$(document).ready(function() {

	$("#messageForm").width($("#chatbox").outerWidth());
	// Array of chat messages
	var timestamps = [];
	var chats = [];
	// TODO: load chats from database
	
	// Array representing board state
	var gameBoard = [];
	var BACKGROUNDCOLORS = {
		FREE : 0,
		YOURS : 1,
		YOURSEQ : 2,
		THEIRS : 3,
		THEIRSEQ : 4
	};
	// TODO: load board state from database

	var cardDeck = $('#gameBoard').playingCards();
	cardDeck.spread();
	
	// Array of playing cards
	var hand = [];
	
	var showError = function(msg) {
		$('#error').html(msg).show();
		setTimeout(function() { $('#error').fadeOut('slow'); }, 1000);
	};
	
	var showHand = function() {
		var el = $('#yourHand');
		el.html('');
		for (var i = 0; i < hand.length; i++) {
			el.append(hand[i].getHTML());
		}
		$('#yourHand > .playingCard').each(function(index) {
			$(this).attr('id', 'hand' + index);
		});
	};
	
	var doShuffle = function() {
		cardDeck.shuffle();
		cardDeck.spread();
	};
	
	var doDrawCard = function() {
		if (hand.length == 6) {
			showError('Your hand is full');
			return;
		}
		var c = drawDeck.draw();
		if (!c) {
			showError('No more cards');
			return;
		}
		hand.splice(hand.length, 0, c);
		showHand();
	};
	
	$('#shuffler').click(doShuffle);
	
	$('#draw').click(doDrawCard);
	
	$('#shuffleDraw').click(function() {
		doShuffle();
		doDrawCard();
	});
	
	$('#addCard').click(function() {
		if (!hand.length) {
			showError('Your hand is empty');
			return;
		}
		var c = hand.pop();
		showHand();
		drawDeck.addCard(c);
	});
	
	var drawDeck = new playingCards();
	drawDeck.shuffle();
	doDrawCard();
	doDrawCard();
		doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	
	var clickedCard = {};
	
	$(document).on('click', '#yourHand > .playingCard', function(card) {

		var classNameOriginal = card.currentTarget.className;
		var className = "." + classNameOriginal.split(" ").join(".");
		if ($(className + ' .front').not( ".occupied" ).css("background-color") === "rgb(153, 255, 153)") {
			$(className + ' .front').not( ".occupied" ).css("background-color", "#fff");
			clickedCard = {};
		} else {
			$(".playingCard .front").not( ".occupied" ).css("background-color", "rgb(255, 255, 255)");
			$(className + ' .front').not( ".occupied" ).css("background-color", "rgb(153, 255, 153)");
			clickedCard = {
				card : classNameOriginal,
				id : $(this).attr("id")
			};
		}
		console.log(clickedCard);
	});

	$("#gameBoard > .playingCard").click(function(card){

		// if the game board card you clicked on is light green
		if ($(".front", this).css("background-color") === "rgb(153, 255, 153)") {
			var classNameOriginal = card.currentTarget.className;
			var className = "." + classNameOriginal.split(" ").join(".");
			$("#yourHand > " + className).each(function () {
				console.log(className);
				if ($(this).attr('id') === clickedCard.id) {
					console.log('asdf');
					clickedElement = hand[$(this).attr('id').charAt(4)];
					hand.splice($(this).attr('id').charAt(4), 1);
					showHand();
					var discard = $('#discard');
					discard.html('');
					discard.html(clickedElement.getHTML());
					$("#discard > .playingCard > .front").addClass('occupied');
					doDrawCard();
					$(".playingCard .front").not( $(".occupied") ).css("background-color", "rgb(255, 255, 255)");
				}
			});
			
			
			$(" .front", this).css("background-color", "rgb(92, 133, 255)");
			//rgb(255, 169, 113) Opponents color
			$(" .front", this).addClass('occupied');
		}
		
		// Store board state
		$("#gameBoard > .playingCard .front").each(function(index) {
			console.log($(this).css("background-color"));
			if ("rgb(92, 133, 255)" === $(this).css("background-color")) {
				gameBoard[index] = BACKGROUNDCOLORS.YOURS;
			}
			if ("rgb(255, 169, 113)" === $(this).css("background-color")) {
				gameBoard[index] = BACKGROUNDCOLORS.THEIRS;
			}
			else if ("rgb(255, 255, 255)" === $(this).css("background-color")) {
				gameBoard[index] = BACKGROUNDCOLORS.FREE;
			}
		});
		
		// Check for sequences
		for (var i = 0; i < gameBoard.length; i++) {
			
			if (gameBoard[i] === BACKGROUNDCOLORS.YOURS) {
				if ( i % 12 < 8 ) {
					console.log("Checking for HRS");
					// Check for horizontal right sequence
					if (gameBoard[i + 1] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 2] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 3] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 4] === BACKGROUNDCOLORS.YOURS) {
						gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 1] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 2] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 3] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 4] = BACKGROUNDCOLORS.YOURSEQ;
					}
					
					if (i < 44) {
						console.log("Checking for DiagRS");
						// Check for diagonal down/right sequence
						if (gameBoard[i + 13] === BACKGROUNDCOLORS.YOURS &&
								gameBoard[i + 26] === BACKGROUNDCOLORS.YOURS &&
								gameBoard[i + 39] === BACKGROUNDCOLORS.YOURS &&
								gameBoard[i + 52] === BACKGROUNDCOLORS.YOURS) {
							gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 13] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 26] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 39] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 52] = BACKGROUNDCOLORS.YOURSEQ;
						}
					}
				}
				if ( i % 12 > 3 && i < 48 ) {
					console.log("Checking for DiagLS");
					// Check for diagonal down/left sequence
					if (gameBoard[i + 11] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 22] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 33] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 44] === BACKGROUNDCOLORS.YOURS) {
						gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 11] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 22] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 33] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 44] = BACKGROUNDCOLORS.YOURSEQ;
					}
				}
				if (i < 48) {
					console.log("Checking for DS");
					// Check for down sequence
					if (gameBoard[i + 12] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 24] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 36] === BACKGROUNDCOLORS.YOURS &&
							gameBoard[i + 48] === BACKGROUNDCOLORS.YOURS) {
						gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 12] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 24] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 36] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 48] = BACKGROUNDCOLORS.YOURSEQ;
					}
				}
			}
		}
		console.log(gameBoard);
	});
	
	$("#send").click(function () {
		var d = new Date();
		timestamps[timestamps.length] = d.getInfo() + ' You:';
		chats[chats.length] = $("#message").val();
		$("#chatbox").append('<div><span style="color: black;">' + timestamps[timestamps.length - 1] + '</span> <span style="color: rgb(92, 133, 255);">' + chats[chats.length - 1] + '</span></div>');
		$("#message").val('');
		$("#chatbox").stop().animate({
				scrollTop: $("#chatbox")[0].scrollHeight
			}, 800);
		//$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
	});
	
	Date.prototype.getInfo = function() {
		return this.getMonth() + '/' + this.getDate() + '/' + this.getFullYear() + ' ' + this.getHours() + ':' + this.getMinutes();
	};
});