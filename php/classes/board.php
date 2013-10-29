<?php

  require('boardspace.php');

  class Board 
  {
  
    private $state = array(array());
    private $players = array();
  
    public function __construct($players) {
      
      if(!is_array($players)) 
        throw new Exception('players paramater must be an array');
        
      $this->makeBlankBoard();
      $this->players = $players;
    }
    
    /**
     * Return a JSON representation of this board 
     **/
    public function toJSONBoard() {
      
      // TODO
    }
    
    /**
     * Initialize the board with BoardSpace's 
     **/
    private function makeBlankBoard() {
      
      // TODO
    }
  }

?>
