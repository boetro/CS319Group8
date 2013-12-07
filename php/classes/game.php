<?php

  require_once 'boardspace.php';
  require_once 'player.php';
  require_once 'connect.php';
  require_once 'boardspace.php';

  class Game
  {
  
    private $id;
    private $board = array(array());
    private $players = array();
    private $totalMoves;
    private $turn;
  
    public function __construct($players, $totalMoves, $turn, $id = null, $board = null) 
    {  
      if(!is_array($players)) 
        throw new Exception('players paramater must be an array');
        
      if(!is_null($board)) 
        $this->board = $board;
      else 
        $this->makeBlankBoard();

      if(!is_null($id))
        $this->id = $id;

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
        if( !$add->execute(array(':player1' => $this->players[0]->id, ':player2' => $this->players[1]->id, ':total_moves' => $this->totalMoves, ':turn' => $this->turn, ':board' => $this->serializeBoard()))) 
          throw new Exception("Could not add new Player to the database in push function.");

        $this->id = $con->lastInsertId(); 
        if(!isset($_SESSION)){
          session_start();
        }
      } 
      else 
      {
        // update current player
        $current = Db::find($this->id, 'id', 'game');

        $update = $con->prepare($updateStmt);
        if(!$update->execute(array(':player1' => $this->players[0]->id, ':player2' => $this->players[1]->id, ':total_moves' => $this->total_moves, ':turn' => $this->turn, ':board' => $this->serializeBoard(), ':id' => $this->id))) 
          throw new Exception();
      }
    }
    
    public function serializeBoard() 
    {
      $jsonBoard = array(array());

      for($y = 0; $y < 8; $y+=1)
      {
        $row = array();
        
        for($x = 0; $x < 12; $x+=1) 
        {
          //BoardSpace::unserialize($this->board[$y][$x]);
          array_push($row, BoardSpace::unserialize($this->board[$y][$x])->serialize());    
        }

        array_push($jsonBoard, $row);
      }

      // first is always empty, so remove it
      array_shift($jsonBoard);
      return json_encode($jsonBoard);
    }

    /**
     * Initialize the board with BoardSpace's 
     **/
    private function makeBlankBoard() 
    {
      // row 1
      $x = 0;
      for($i = 0; $i < 12; $i++)
      {
        $this->board[0][$x++] = new BoardSpace($i);
      }
      
      // row 2
      $x = 0;
      $this->board[1][$x++] = new BoardSpace(35);
      for($i = 36; $i <= 45; $i++)
      {
        $this->board[1][$x++] = new BoardSpace($i);
      }
      $this->board[1][$x++] = new BoardSpace(12);
      
      // row 3
      $x = 0;
      $this->board[2][$x++] = new BoardSpace(34);
      for($i = 63; $i <= 71; $i++)
      {
        $this->board[2][$x++] = new BoardSpace($i);
      }
      $this->board[2][$x++] = new BoardSpace(46);
      $this->board[2][$x++] = new BoardSpace(13);
      
      // row 4
      $x = 0;
      $this->board[3][$x++] = new BoardSpace(33);
      $this->board[3][$x++] = new BoardSpace(62);
      for($i = 83; $i <= 89; $i++)
      {
        $this->board[3][$x++] = new BoardSpace($i);
      }
      $this->board[3][$x++] = new BoardSpace(72);
      $this->board[3][$x++] = new BoardSpace(47);
      $this->board[3][$x++] = new BoardSpace(14);
      
      // row 5
      $x = 0;
      $this->board[4][$x++] = new BoardSpace(32);
      $this->board[4][$x++] = new BoardSpace(61);
      $this->board[4][$x++] = new BoardSpace(82);
      for($i = 95; $i >= 90; $i--){
        $this->board[4][$x++] = new BoardSpace($i);
      }
      $this->board[4][$x++] = new BoardSpace(73);
      $this->board[4][$x++] = new BoardSpace(48);
      $this->board[4][$x++] = new BoardSpace(15);
      
      // row 6
      $x = 0;
      $this->board[5][$x++] = new BoardSpace(31);
      $this->board[5][$x++] = new BoardSpace(60);
      for($i = 81; $i >= 74; $i--)
      {
        $this->board[5][$x++] = new BoardSpace($i);
      }
      $this->board[5][$x++] = new BoardSpace(49);
      $this->board[5][$x++] = new BoardSpace(16);
      
      // row 7
      $x = 0;
      $this->board[6][$x++] = new BoardSpace(30);
      for($i = 59; $i >= 50; $i--)
      {
        $this->board[6][$x++] = new BoardSpace($i);
      }
      $this->board[6][$x++] = new BoardSpace(17);
      
      // row 8
      $x = 0;
      for($i = 29; $i >= 18; $i--)
      {
        $this->board[7][$x++] = new BoardSpace($i);
      }
    }

    public function serialize()
    {
      return json_encode(array(
        'id' => $this->id,
        'player1' => Player::unserialize($this->players[0])->serialize(),
        'player2' => Player::unserialize($this->players[1])->serialize(),
        'totalMoves' => $this->totalMoves,
        'turn' => $this->turn,
        'board' => $this->serializeBoard()
      ));
    }

    // TODO
    public static function unserialize($obj)
    {
      if(is_object($obj) && property_exists($obj, 'board')) 
      {
        $boardArray = json_decode($obj->board);
        $count = 0;
        foreach($boardArray as &$row)
        {
          foreach ($row as $space) 
          {
            $row[$count++] = BoardSpace::unserialize(json_decode($space));
          }
          $count = 0;
        }

        return new Game(
          array(
            Player::unserialize($obj->player1_id),
            Player::unserialize($obj->player2_id)
          ),
          $obj->total_moves,
          $obj->turn,
          $obj->id,
          $boardArray
        );
      } 
      else 
      {
        return false;
      }
    }
  }

?>
