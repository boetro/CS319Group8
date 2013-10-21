<?php

  require('boardspace.php');

  class Board 
  {
  
    private $state = array(array());
  
    public function __construct() {
      $this->makeBlankBoard();
    }
    
    /**
     * Return a JSON representation of this board 
     **/
    public function getJSONBoard() {
      
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
