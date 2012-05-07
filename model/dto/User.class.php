<?php
	/**
	 * Object representation of user element
	 *
	 * @author: cgajardo
	 * @date: 2012-04-26 23:30	 
	 */
	class User{
		
		//private
		var $id; 
		
		var $email;
		
		var $name;

		var $lastname;

		var $created;
		
		var $active;
		
		
		/**
		* returns an user object mapped to an array
		*/
		public function toArray(){
			
			return array("email"=>$this->email, "name"=>$this->name, 
				"lastname"=>$this->lastname, "created"=>$this->created, 
				"active"=>$this->active);
		}
		
		/**
		 * returns boolean
		 */
		public function canAfford($repository){
			$userPoints = DAOFactory::getUsersDAO()->getPointsInRepo($this->id, $repository);
			print_r($userPoints);
			$downloadCost = DAOFactory::getRepositoriesDAO()->getDownloadCost($repository);
		}
		
	}
?>