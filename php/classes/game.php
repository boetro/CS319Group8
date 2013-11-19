<?php

  require 'boardspace.php';
  require 'player.php';
  require_once 'connect.php';

  class Game
  {
  
    private $id;
    private $board = array(array());
    private $players = array();
    private $totalMoves;
    private $turn;
  
    public function __construct($players, $totalMoves, $turn) 
    {  
      if(!is_array($players)) 
        throw new Exception('players paramater must be an array');
        
      $this->makeBlankBoard();

      $this->players = $players;
      $this->totalMoves = $totalMoves;
      $this->turn = $turn;
    }

    /**
     * Magic getter
     *
     * @param property to get
     * @return property or false if it does not exist
     */
    public function __get($property) 
    { 
      if (property_exists($this, $property)) 
          return $this->$property;

        return false;
    }

    /**
     * Magic setter
     *
     * @param property to set
     * @param value to set the property to
     * @return true on successfull set, false on fail
     */
    public function __set($property, $value) 
    { 
      if($property == 'id')
        throw new Exception("Please do not try to alter the id of the player.");

      if (property_exists($this, $property)) 
      {
          $this->$property = $value;
          return true;
        }

        return false;
    }

    public function push() 
    {
      $socket = new Connect();
      $con = $socket->getConnection();

      $addStmt = "INSERT INTO game (player1_id, player2_id, total_moves, turn, board) VALUES (:player1, :player2, :total_moves, :turn, :board)";
      $updateStmt = "UPDATE game SET player1_id=:player1, player2_id=:player2, total_moves=:total_moves, turn=:turn, board=:board WHERE id=:id";

      if(!isset($this->id)) 
      {
        // create a new game in the database
        $add = $con->prepare($addStmt);
        if( !$add->execute(array(':player1' => $this->players[0]->id, ':player2' => $this->players[1]->id, ':total_moves' => $this->total_moves, ':turn' => $this->turn, ':board' => $this->board))) 
          throw new Exception("Could not add new Player to the database in push function.");

        $this->created_at = date('Y-m-d H:i:s');
        $this->id = $con->lastInsertId(); 
        session_start();
      } 
      else 
      {
        // update current player
        $current = Db::find($this->id, 'id', 'player');

        $update = $con->prepare($updateStmt);
        if(!$update->execute(array(':email' => $this->email, ':pass_hash' => $this->pass_hash, ':gamertag' => $this->gamertag, ':theme_color' => $this->theme_color, ':id' => $this->id))) 
          throw new Exception();
      }
    }
    
    public function serializeBoard() 
    {
      $jsonBoard = array(array());

      foreach($this->board as $key => $row)
      {
        $row = array();

        foreach ($row as $space => $object) 
        {
          array_push($row, serialize($space))    
        }

        array_push($jsonBoard, $row);
      }

      return $jsonBoard;
    }

    /**
     * Initialize the board with BoardSpace's 
     **/
    private function makeBlankBoard() {
      
      // TODO
    }
  }

?>
