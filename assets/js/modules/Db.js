/** 
 * Dependencies
 *
 * config.js
 */

/**
 * Module primarily used to interact with php scripts, to send and recieve data
 */
var Db = (function() {
	
	var find = function(value, column, table) {
		
		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/find.php',
			type: 'POST',
			data: {value : value, column : column, table : table}
		});
	};

	var makeUser = function(email, password, gamertag, theme_color) {

		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/addplayer.php',
			type: 'POST',
			data: {email : email, password : password, gamertag : gamertag, theme_color : theme_color}
		});
	};

	var updateUser = function(value, column) {

		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/updatePlayer.php',
			type: 'POST',
			data: {column : column, value : value}
		});
	};

	var makeGame = function(player1, player2, totalMoves, turn) {
		console.log("creating a game with totalMoves : " + totalMoves);
		console.log("creating a game with turn : " + turn);

		return $.ajax({
			url: CONFIG.Dir + 'php/scripts/addgame.php',
			type: 'POST',
			data: {player1 : player1, player2 : player2, totalMoves : totalMoves, turn : turn}
		});
	};

	/**
	 *
	 * @param {number} id 
	 * @param {2d array} board represents 12 x 8 BoardSpace Objects (card value, hasChip, chipColor)
	 */
	var updateGame = function(id, board, player1, player2, totalMoves, turn) {
		console.log("updating game...");
	};

	return {
		find:find,
		makeUser:makeUser,
		updateUser:updateUser,
		makeGame:makeGame
	};
})();