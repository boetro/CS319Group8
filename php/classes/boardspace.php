<?php

  require 'cards.enum.php';

  class BoardSpace
  {
    
    private $card;
    private $hasChip;
    private $chipColor;
    
    public function __construct() {
      
      // FIXME, fixed set of cards instead of randoms
      $this->card = Cards::randomCard();
      $this->hasChip = false;
      $this->chipColor = false;
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
    
    public function serialize() 
    {  
      return json_encode(array(
        'card' => $this->card,
        'hasChip' => $this->hasChip,
        'chipColor' => $this->chipColor
      ));
    }
    
    public static function unserialize($obj) 
    {
      $newSpace = new BoardSpace();

      $newSpace->chip = $obj->chip;
      $newSpace->hasChip = $obj->hasChip;
      $newSpace->chipColor = $obj->chipColor; 

      return $newSpace;
    }
  }
  
?>
