<?php

	require '../classes/db.php';

	try{
		session_start();
		$games = array();
		$data = Db::find($_SESSION["id"], "player1_id", "game");
		if($data){
			$size = sizeof($data);
			foreach ($data as $game){
				$opp = $game->player2_id;
				$user = Db::find($opp, "id", "player");
				array_push($games, array(
								'id' => $game->id,
								'opponent' => $user->gamertag,
								'total_moves' => $game->total_moves));
			}
		}
		$data = Db::find($_SESSION["id"], "player2_id", "game");
		if($data){
			$size = sizeof($data);
			foreach ($data as $game){
				$opp = $game->player1_id;
				$user = Db::find($opp, "id", "player");
				array_push($games, array(
								'id' => $game->id,
								'opponent' => $user->gamertag,
								'total_moves' => $game->total_moves));
			}
		}
		if(sizeof($games) < 1){
			echo json_encode(false);
			die();
		}
		echo json_encode($games);

	}catch(Exception $e){
		echo json_encode(array(
			'error' => true,
			'message' => $e->getMessage(),
		));
	}

?>