// $(document).ready(function() {

function loadGameBoard() {
	// initialize web sockets

	var websocket = new WebSocket('ws://localhost:9000/' + localStorage.gamertag + '?' + localStorage.gameId);

	console.log('creating web sockets connection...');

	$('#board > .container').hide();
	$('#board').append('<div id="connecting" class="container alert alert-info">Connecting to Web Sockets...</div>');

	websocket.onopen = function(event) {
		console.log('successfully opened web sockets connection');

		drawBoard(websocket);
	}

	websocket.onclose = function(event) {
		console.log('web sockets connection closed');

		$('#board > .container').html('<div class="alert alert-danger">Sorry, Web Socket connection unexpectedly closed.</div>');
	}

	websocket.onmessage = function(event) {
		console.log('message recieved from web socket server');
		console.log(event);
	}

	websocket.onerror = function(event) {
		console.log("there was a problem connecting to the web sockets server");

		$('#board > .container').html('<div class="alert alert-danger">Could not connect to Web Sockets server.</div>');
	}
}

function drawBoard(websocket) {

	$('#connecting').remove();
	$('#board > .container').fadeIn('slow');
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
	
	// Create a new deck of cards to be displayed as the game board
	var cardDeck = $('#gameBoard').playingCards();

	var gamePromise = Db.find(localStorage.gameId, 'id', 'game'),
		game;

	// Spread the deck to display the card faces (spread lays out a deck in the pattern of a Sequence game board)
	cardDeck.spread(gamePromise);
	
	// Create a new deck of cards to draw from
	var drawDeck = new playingCards();
	// Shuffle the deck
	drawDeck.shuffle();
	
	// Variable to track which card was most recently clicked
	var clickedCard = {};
	
	gamePromise.done(function(data) {
		 game = JSON.parse(data);
         game.board = Util.arrayToJson(JSON.parse(game.board));

         console.log('game loaded:');
         console.log(game);

         // TODO, load game board into the gameBoard array representing state of each card
        var rows = game.board.length,
        	count = 0; 
        for(var y = 0; y < rows; y+=1) {
        	var columns = game.board[y].length;
        	for(var x = 0; x < columns; x+=1) {
        		var boardSpace = game.board[y][x];
        		// free space
        		if(!boardSpace.hasChip) {
        			gameBoard[count] = BACKGROUNDCOLORS.FREE;
        		}
        		// logged user owns this space
        		else if(boardSpace.owner === localStorage.id) {
        			if(boardSpace.sequence) {
        				gameBoard[count] = BACKGROUNDCOLORS.YOURSEQ;
        			} else {
        				gameBoard[count] = BACKGROUNDCOLORS.YOURS;
        			}
        		} 
        		// other player owns this space
        		else {
        			if(boardSpace.sequence) {
        				gameBoard[count] = BACKGROUNDCOLORS.THEIRSEQ;
        			} else {
        				gameBoard[count] = BACKGROUNDCOLORS.THEIRS;
        			}
        		}

        		count+=1;
        	}
        }

        // if its player 2's turn and logged player is player two or player 1's turn and logged player is player one
        if( (game.turn === "1" && game.player2_id === localStorage.id) || (game.turn === "0" && game.player1_id === localStorage.id) ) {
        	$(document).on('click', '#gameBoard > .playingCard', boardListener);
        	$(document).on('click', '#yourHand > .playingCard', handListener);
        } else {
        	$('#board > .container').prepend('<div class="alert alert-info">It is still the other players turn.</div>');
        }
	});
	
	// Give the user feedback if the game tried to do something it couldn't
	var showError = function(msg) {
		$('#error').html(msg).show();
		setTimeout(function() { $('#error').fadeOut('slow'); }, 1000);
	};

	// Clear all green from the game board and hand
	var clear = function() {

		console.log('clearing board');
		$("#gameBoard > .playingCard .front").each(function(index) {
			if($(this).css('background-color') === "rgb(153, 255, 153)") {
				$(this).css('background-color', '#FFF');
			}
		});

		$('#yourHand > .playingCard').each(function(index) {
			$('.front', this).css('background-color', '#FFF');
		});
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

	// Bind a click listener to cards in a player's hand
	// This listener toggles the highlighting of cards in a player's hand and on the game board
	// When a user clicks a card in their hand, it becomes highlighted along with all open spots on the game board that match
	var handListener = function(card) {
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
	}

	// Click method for cards on the game board
	// If a user clicks a highlighted card on the game board, they will put a chip on that space
	// Reference: [ rgb(255, 169, 113) ] is the rgb value for the opponent's color
	var boardListener = function(card) {
		// if the game board card you clicked on is light green
		if ($(".front", this).css("background-color") === "rgb(153, 255, 153)") {

			var coords = $(this)[0].children[0].dataset;
			console.log("y: " + coords.y + " x: " + coords.x);
			var boardSpace = game.board[coords.y][coords.x];
			game.board[coords.y][coords.x] = {
				card: boardSpace.card,
				hasChip: true,
				owner: localStorage.id,
				sequence: boardSpace.sequence
			};
			game.total_moves += 1;
			// flip the turn
			game.turn = 1 - game.turn;
			switchTurn();
			$('#board > .container').prepend('<div class="alert alert-info">It is now other players turn.</div>');
			clear();

			var classNameOriginal = card.currentTarget.className;
			var className = "." + classNameOriginal.split(" ").join(".");
			
			// handle discarding from hand
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

			// save game state
			Db.updateGame(game.id, JSON.stringify(game.board), game.player1_id, game.player2_id, game.total_moves, game.turn);
			$('#yourHand > .playingCard').click(false);
		}
		
		// Check for sequences
		var numSequence = 0;
		console.log('checking for sequences');
		for (var i = 0; i < gameBoard.length; i++) {
			
			if (gameBoard[i] === BACKGROUNDCOLORS.YOURS) {
				if ( i % 12 < 8 ) {
					// Check for horizontal right sequence
					if ((gameBoard[i + 1] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 1] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 2] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 2] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 3] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 3] === BACKGROUNDCOLORS.YOURSEQ) &&
							(gameBoard[i + 4] === BACKGROUNDCOLORS.YOURS || gameBoard[i + 4] === BACKGROUNDCOLORS.YOURS)) {
						console.log('found horizontal sequence');
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
							console.log('found diagonal sequence down/right');
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
						console.log('found diagonal sequence down/left');
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
						console.log('found down sequence');
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

		var changeState = false;
		// Store board state
		$("#gameBoard > .playingCard .front").each(function(index) {

			var coords = $(this)[0].dataset;
			if (gameBoard[index] === BACKGROUNDCOLORS.YOURSEQ) {
				$(this).css('background-color', 'rgb(82, 133, 255)');
				if(game.board[coords.y][coords.x].sequence !== true) {
					game.board[coords.y][coords.x].sequence = true;
					changeState = true;
				}
			} else if(gameBoard[index] === BACKGROUNDCOLORS.THEIRSEQ) {
				$(this).css('background-color', 'rgb(245, 169, 113)');
				if(game.board[coords.y][coords.x].sequence !== true) {
					game.board[coords.y][coords.x].sequence = true;
					changeState = true;
				}
			} 
		});
		if(changeState) {
			console.log('updating game board with board data:');
			console.log(game.board);
			Db.updateGame(game.id, JSON.stringify(game.board), game.player1_id, game.player2_id, game.total_moves, game.turn);
		}
	}

	var switchTurn = function() {
		// unbind the hand and board listeners
		$(document).on('click', '#gameBoard > .playingCard', boardListener);
		$(document).on('click', '#yourHand > .playingCard', handListener);
	}
	
	// Draw 6 cards to fill the player's hand
	doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	doDrawCard();
	
	// Chat
	$("#send").click(function () {
		var d = new Date();
		timestamps[timestamps.length] = d.getInfo() + ' You:';
		var message = $('#message').val();
		chats[chats.length] = message;
		$("#chatbox").append('<div><span style="color: black;">' + timestamps[timestamps.length - 1] + '</span> <span style="color: rgb(92, 133, 255);">' + chats[chats.length - 1] + '</span></div>');
		$("#message").val('');
		$("#chatbox").stop().animate({
				scrollTop: $("#chatbox")[0].scrollHeight
			}, 800);
		//$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);

		console.log('sent a chat message');
		console.log(message);
		websocket.send(JSON.stringify({
			message: message,
			type: 'chat',
			user: localStorage.id,
			game: localStorage.gameId
		}));
	});
	
	Date.prototype.getInfo = function() {
		return this.getMonth() + '/' + this.getDate() + '/' + this.getFullYear() + ' ' + this.getHours() + ':' + this.getMinutes();
	};
}