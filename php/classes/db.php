<?php  

	require 'connect.php';

	/**
	 * Class that models the functionality of te javascript database module
	 */
	class Db 
	{
		/**
		 * Array of the table names and their columns that exist in the database
		 */
		public static $tables = array(
			"player" => array(
				"id",
				"theme_color",
				"created_at",
				"gamertag",
				"pass_hash",
				"email"
			),		
			"game" => array(
				"id",
				"player1_id",
				"player2_id",
				"total_moves",
				"turn",
				"board"
			),
			"chat_log" => array(
				"id",
				"sender_id",
				"game_id",
				"message",
				"created_at",
				"pretty_time"
			)
		);

		/**
		 * Returns an array of all rows from the given table if found
		 *
		 * @param value
		 * @param string column  
		 * @param string table
		 * @return false if not found in table, or array of rows
		 */
		public static function find($value, $column, $table) 
		{
			// check table against a list of known tables
			if(!array_key_exists($table, Db::$tables))
				throw new Exception("That table name does not exist in the database.");
			else 
			{
				$sub = Db::$tables[$table];
				if(!in_array($column, $sub, true))
					throw new Exception("The column name does not exist in the database.");
			}

			$socket = new Connect();
			$con = $socket->getConnection();

			// hack to force prepared statement to allow variable table names, SQL injection wont occur since checking against const array
			$first = "SELECT * FROM " .  $table . " WHERE " . $column . "='" . $value . "'";
			$select = $con->prepare($first);
			if(!$select->execute())
				throw new Exception("Could not perform select query from find by id function in php Db class.");

			$results = $select->fetchAll(PDO::FETCH_CLASS);
			if(!count($results))
				return false; 

			if(sizeof($results) == 1)
				$results = $results[0];

			return $results;
		}
	}