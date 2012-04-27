<?php
	/**
	 * Object representation of user element
	 *
	 * @author: cgajardo
	 * @date: 2012-04-26 23:30	 
	 */
	class User{
		
		var $email;
		
		var $name;

		var $lastname;

		
		
		/**
		* returns an user object mapped to an array
		*/
		public function toArray(){
			
			return array("email"=>$this->email, "name"=>$this->name, 
				"lastname"=>$this->lastname);
		}
		
	}
?>