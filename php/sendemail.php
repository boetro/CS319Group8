<?php

include 'user.php';
include 'connect.php';

$socket = new Connect();
$con = $socket->getConnection();

$selectAll = $con->prepare("SELECT email FROM player WHERE gamertag = :username LIMIT 1");

if(!$selectAll->execute(array(':username' => 'cvandyke'))) {
	echo "Error selecting: ";
	print_r($add->errorInfo());
	die();
}
$results = $selectAll->fetchAll(); 
if(count($results) <= 0){
	echo "Could not find username.";
 	die();
}else{
	$to = $results[0]['email'];
	$subject = "It is your turn to play";
	$message = "<Other users name> has played in one of your games.  It is now your turn to play. <link to game>";
	$from = "sequence_notifications@sequencegame.com";
	$headers = "From:" . $from;
	mail($to,$subject,$message,$headers);
	echo "Mail Sent.";
}
?>