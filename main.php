<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Sequence</title>
		<meta charset="utf-8">
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="all" href="./playing-cards/playingCards.ui.css"/>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="./assets/js/scripts/PageLoad.js" type="text/JavaScript"></script>
		<script type="text/javascript" src="./assets/js/scripts/validateSession.js"></script>
	</head>
	
	<?php
		session_start();
		if(isset($_SESSION['gamertag']) && isset($_SESSION['theme_color']) && isset($_SESSION['id'])){
			echo '<body style="background-color:' . $_SESSION['theme_color'] . ';">';
		}else{
			header("Location: index.php");
			die();
			echo $_SESSION['gamertag'];
		}
	?>
		<div class="container">
			<h1>
				Sequence
			</h1><br>
			
			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav navbar-left">
						<li><a id="new" style="cursor: pointer">New Game</a></li>
						<li><a id="current" style="cursor: pointer">Current Games</a></li>
						<li><a id="highScores" style="cursor: pointer">High Scores</a></li>
						<li><a id="help" style="cursor: pointer">Help</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<?php
								echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $_SESSION['gamertag'] . ' <b class="caret"></b></a>'
							?>
							<ul class="dropdown-menu">
								<li><a id="settings" style="cursor: pointer">Account Settings</a></li>
								<li><a href="./index.php">Log out</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			
			<span style="padding: 0;"class="container" id="content">
				Welcome to Sequence!
			</span>
		</div>
		<div id="board"></div>
	</body>
</html>
