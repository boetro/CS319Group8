<?php

  require('connect.php');
  require('board.php');
  
  $testPlayers = array();
  $testing = new Board($testPlayers);
  $serialized = serialize($testing);
  
  echo 'serialized : ' . $serialized;
  
  $unserialized = unserialize($serialized);

  echo 'unserialized : ' . $unserialized;
?>
