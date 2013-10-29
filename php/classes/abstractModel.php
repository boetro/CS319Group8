<?php 

	abstract class AbstractModel {

		/**
		 * Finds (or doesn't) a row in the database with the given ids 
		 *
		 * @param integer id to search for in the database
		 * @return User object that exists in the database or false if it does not exist
		 */
		public static function find($id) {

		}
	}