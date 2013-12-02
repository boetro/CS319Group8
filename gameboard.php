<div class="container">		
	<?php 
		echo "Game id is stored in post: " . $_POST['id'];
	?>
	<div class="row">
		<div class="col-md-10 game">
			<div id="gameBoard"></div>
		</div>
		<div class="col-md-2">
			<div id="legend">
				<h4>Legend</h4>
				<div>
					<div class="yourColor" style="width: 10px; height: 10px; background-color: rgb(92, 133, 255); float: left; margin: 5px;"></div>
					You
				</div>
				<div>
					<div class="theirColor" style="width: 10px; height: 10px; background-color: rgb(255, 169, 113); float: left; margin: 5px;"></div>
					Opp 
				</div>
			</div>
			<div id="score">
				<h4>Sequences</h4>
				<div>You: <span id="yourScore">0</div>
				<div>Opp: 0</div>
			</div>
			<div id="chat">
				<h4>Chat</h4>
				<div class="chatbox form-control" id="chatbox">
					
				</div>
				<div id="messageForm">
				    <input class="form-control" id="message" type="text" style="float: left; width: 140px;">
					<button class="btn btn-default" id="send" type="submit" style="float: right;">Send</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-6">
			<h2>Your Hand</h2>
			<div id="yourHand"></div>
		</div>
		<div class="col-md-3">
			<h2>Card Deck</h2>
			<div id="cardDeck">
				<div class="playingCard"></div>
			</div>
		</div>
		<div class="col-md-3">
			<h2>Discard Pile</h2>
			<div id="discard"></div>
		</div>
	</div>
	
	<script type="text/javascript" src="./playing-cards/playingCards.js"></script>
	<script type="text/javascript" src="./playing-cards/playingCards.ui.js"></script>
	<script type="text/javascript" src="./assets/js/scripts/GameBoard.js"></script>
</div>
