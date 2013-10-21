<?php

  require('connect.php');
  require('board.php');
  
  $testing = new Board();
  $serialized = serialize($testing);
  
  echo 'serialized : ' . $serialized;
  
  $unserialized = unserialize($serialized);

  echo 'unserialized : ' . $unserialized;
?>
