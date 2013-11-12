<?php

	if(!isset($_SESSION['gamertag']) || !isset($_SESSION['theme-color'])){
		ob_start();

		//script

		header("Location: ../../login.html");

		ob_end_flush();

		die();
	}else{
		echo json_encode(array(
			'gamertag' => $_SESSION['gamertag'],
			'theme-color' => $_SESSION['theme-color'],
		));
	}

?>