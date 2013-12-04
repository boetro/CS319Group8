<?php

	require '../classes/db.php';

	try{
		session_start();
		$games = array();
		$data = Db::find($_SESSION["id"], "player1_id", "game");
		if($data){
			$size = sizeof($data);
			if($size > 1){
				foreach ($data as $game){
					$opp = $game->player2_id;
					$user = Db::find($opp, "id", "player");
					$yourTurn = false;
					if($game->turn == 0){
						$yourTurn = true;
					}
					array_push($games, array(
									'id' => $game->id,
									'opponent' => $user->gamertag,
									'total_moves' => $game->total_moves,
									'your_turn' => $yourTurn));
				}
			}
			else{
				$opp = $data->player2_id;
				$user = Db::find($opp, "id", "player");
				$yourTurn = false;
				if($data->turn == 0){
					$yourTurn = true;
				}
				array_push($games, array(
					'id' => $data->id,
					'opponent' => $user->gamertag,
					'total_moves' => $data->total_moves,
					'your_turn' => $yourTurn));
			}	
		}
		$data = Db::find($_SESSION["id"], "player2_id", "game");
		if($data){
			$size = sizeof($data);
			if($size > 1){
				foreach ($data as $game){
					$opp = $game->player1_id;
					$user = Db::find($opp, "id", "player");
					$yourTurn = false;
					if($game->turn == 1){
						$yourTurn = true;
					}
					array_push($games, array(
									'id' => $game->id,
									'opponent' => $user->gamertag,
									'total_moves' => $game->total_moves,
									'your_turn' => $yourTurn));
				}
			}
			else{
				$opp = $data->player1_id;
				$user = Db::find($opp, "id", "player");
				$yourTurn = false;
				if($data->turn == 1){
					$yourTurn = true;
				}
				array_push($games, array(
								'id' => $data->id,
								'opponent' => $user->gamertag,
								'total_moves' => $data->total_moves,
								'your_turn' => $yourTurn));
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