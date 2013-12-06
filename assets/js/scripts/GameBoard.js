// $(document).ready(function() {

function loadGameBoard() {
	// initialize web sockets

	try {
		var websocket = new WebSocket('ws://localhost:9000/' + localStorage.gamertag + '?' + localStorage.gameId);
		console.log('creating web sockets connection...');

		websocket.onopen = function(event) {
			console.log('successfully opened web sockets connection');

			Connection.set(websocket);
			Session.set({
				connection: JSON.stringify(websocket)
			});

			console.log(localStorage);
		}

		websocket.onclose = function(event) {
			console.log('web sockets connection closed');

			Connection.remove();
		}

		websocket.onmessage = function(event) {
			console.log('message recieved from web socket server');
		}
	} catch(e) {
		console.log('there was a problem connecting to websockets');
	}

	$("#messageForm").width($("#chatbox").outerWidth());
	
	var timestamps = [];      // Array of chat timestamps
	var chats = [];           // Array of chat messages
	var gameBoard = [];       // Array representing board state
	var hand = [];            // Array of playing cards
	var yourScore = 0;
	var theirScore = 0;
	
	var BACKGROUNDCOLORS = {  // Enum representing the state of a board space
		FREE : 0,     // Open space
		YOURS : 1,    // Taken by one of your moves, but not part of a sequence
		YOURSEQ : 2,  // Taken by one of your moves and part of a sequence
		THEIRS : 3,   // Taken by an opponent's move, but not part of a sequence
		THEIRSEQ : 4  // Taken by an opponent's move and part of a sequence
	};
	
	// TODO: load chats from database
	// TODO: load board state from database
	
	// Create a new deck of cards to be displayed as the game board
	var cardDeck = $('#gameBoard').playingCards();
	
	// Spread the deck to display the card faces (spread lays out a deck in the pattern of a Sequence game board)
	cardDeck.spread();
	
	// Create a new deck of cards to draw from
	var drawDeck = new playingCards();
	// Shuffle the deck
	drawDeck.shuffle();
	
	// Variable to track which card was most recently clicked
	var clickedCard = {};
	
	
	
	// Give the user feedback if the game tried to do something it couldn't
	var showError = function(msg) {
		$('#error').html(msg).show();
		setTimeout(function() { $('#error').fadeOut('slow'); }, 1000);
	};
	
	// Display the cards in the player's hand by using the hand array to generate card html
	var showHand = function() {
		// Select the yourHand div and clear its html
		var el = $('#yourHand');
		el.html('');
		
		// Loop through the hand array, appending the respective card html to the yourHand div
		for (var i = 0; i < hand.length; i++) {
			el.append(hand[i].getHTML());
		}
		
		// Give each card element in a user's hand an id
		// Possible values are hand0, hand1, hand2, hand3, hand4, hand5
		// The id is used when cards are played from the hand to determine which card was played
		$('#yourHand > .playingCard').each(function(index) {
			$(this).attr('id', 'hand' + index);
		});
	};
	
	// Shuffle the deck
	var doShuffle = function() {
		cardDeck.shuffle();
	};
	
	// Draw a new card
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
	
	// Draw 6 cards to fill the player's hand
	doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	
	// Bind a click listener to cards in a player's hand
	// This listener toggles the highlighting of cards in a player's hand and on the game board
	// When a user clicks a card in their hand, it becomes highlighted along with all open spots on the game board that match
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
	});
	
	// Click method for cards on the game board
	// If a user clicks a highlighted card on the game board, they will put a chip on that space
	// Reference: [ rgb(255, 169, 113) ] is the rgb value for the opponent's color
	$("#gameBoard > .playingCard").click(function(card){
		// if the game board card you clicked on is light green
		if ($(".front", this).css("background-color") === "rgb(153, 255, 153)") {
			var classNameOriginal = card.currentTarget.className;
			var className = "." + classNameOriginal.split(" ").join(".");
			
			$("#yourHand > " + className).each(function () {
				if ($(this).attr('id') === clickedCard.id) {
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
			
			$(" .front", this).addClass('occupied');
		}
		
		// Store board state
		$("#gameBoard > .playingCard .front").each(function(index) {
			if ("rgb(92, 133, 255)" === $(this).css("background-color")) {
				gameBoard[index] = BACKGROUNDCOLORS.YOURS;
			}
			
			if ("rgb(255, 169, 113)" === $(this).css("background-color")) {
				gameBoard[index] = BACKGROUNDCOLORS.THEIRS;
			} else if ("rgb(255, 255, 255)" === $(this).css("background-color")) {
				gameBoard[index] = BACKGROUNDCOLORS.FREE;
			}
		});
		
		// Check for sequences
		var numSequence = 0;
		for (var i = 0; i < gameBoard.length; i++) {
			
			if (gameBoard[i] === BACKGROUNDCOLORS.YOURS) {
				if ( i % 12 < 8 ) {
					// Check for horizontal right sequence
					if ((gameBoard[i + 1] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 1] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 2] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 2] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 3] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 3] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 4] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 4] === BACKGROUNDCOLORS.YOURS)) {
						gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 1] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 2] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 3] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 4] = BACKGROUNDCOLORS.YOURSEQ;
						numSequence++;
					}
					
					if (i < 44) {
						// Check for diagonal down/right sequence
						if ((gameBoard[i + 13] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 13] === BACKGROUNDCOLORS.YOURSEQ) &&
								(gameBoard[i + 26] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 26] === BACKGROUNDCOLORS.YOURSEQ) &&
								(gameBoard[i + 39] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 39] === BACKGROUNDCOLORS.YOURSEQ) &&
								(gameBoard[i + 52] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 52] === BACKGROUNDCOLORS.YOURSEQ)) {
							gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 13] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 26] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 39] = BACKGROUNDCOLORS.YOURSEQ;
							gameBoard[i + 52] = BACKGROUNDCOLORS.YOURSEQ;
							numSequence++;
						}
					}
				}
				if ( i % 12 > 3 && i < 48 ) {
					// Check for diagonal down/left sequence
					if ((gameBoard[i + 11] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 11] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 22] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 22] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 33] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 33] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 44] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 44] === BACKGROUNDCOLORS.YOURSEQ)) {
						gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 11] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 22] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 33] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 44] = BACKGROUNDCOLORS.YOURSEQ;
						numSequence++;
					}
				}
				if (i < 48) {
					// Check for down sequence
					if ((gameBoard[i + 12] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 12] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 24] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 24] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 36] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 36] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 48] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 48] === BACKGROUNDCOLORS.YOURSEQ)) {
						gameBoard[i] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 12] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 24] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 36] = BACKGROUNDCOLORS.YOURSEQ;
						gameBoard[i + 48] = BACKGROUNDCOLORS.YOURSEQ;
						numSequence++;
					}
				}
			}
			yourScore = numSequence;
			$("#yourScore").html(yourScore);
		}
	});
	
	// Chat
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
}