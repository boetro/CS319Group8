<?php

  require('chat.php');

  class Chat_Log
  {
  
	private $chat_log = array();

    public function __construct($chat_log) {
    	if(!is_array($chat_log)) 
        	throw new Exception('chat_log paramater must be an array');
    	$this->chat_log = $chat_log;
    }
    
    /**
     * Return a JSON representation of this board 
     **/
    public function toJSONChatLog() {
    	$log = array();
    	for($i = 0; $i < sizeof($this->chat_log); ++$i){
    		array_push($log, $this->chat_log[$i]->toJSONChat());
    	}
    	return json_encode(array('chat_log' => $log));	
    }
  }

?>
