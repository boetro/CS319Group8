<?php

  require_once 'cards.enum.php';

  class BoardSpace
  {
    
    private $card;
    private $hasChip;
    private $chipColor;
    
    public function __construct($card = null, $hasChip = null, $chipColor = null) {
      
      if(!is_null($card))
        $this->card = $card;
      else
        $this->card = Cards::randomCard(); // FIXME, fixed set of cards instead of randoms

      if(!is_null($hasChip))
        $this->hasChip = $hasChip;
      else
        $this->hasChip = false;

      if(!is_null($chipColor))
        $this->chipColor = $chipColor;
      else
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
      return new BoardSpace($obj->card, $obj->hasChip, $obj->chipColor);
    }
  }
  
?>
