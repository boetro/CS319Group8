<?php
  
  // cards enum
  class Cards 
  {
    const OneOfHearts = '1h';
    const OneOfClubs = '1c';
    const OneOfDiamonds = '1d';
    const OneOfSpades = '1s';
  }

  class BoardSpace implements Serializable
  {
    
    private $card;
    private $hasChip;
    private $chipColor;
    
    public function __construct() {
      
      $this->hasChip = false;
      $this->chipColor = null;
    } 
    
    /**
     * HasChip getter
     **/
    public function hasChip() {
      return $hasChip;
    }
    
    /**
     * Chip color getter
     **/
    public function getChipColor() {
      
      if(!is_null($chipColor)) {
        return $chipColor;
      }
      
      return false;
    }
    
    public function serialize() {
      
      // TODO
    }
    
    public function unserialize() {
      
      // TODO
    }
  }
  
?>
