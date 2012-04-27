<?php
	/**
	 * Object representation of repository element
	 *
	 * @author: cgajardo
	 * @date: 2012-04-20 00:49	 
	 */
	class Repository{
		
		var $id;
		
		var $name;

		var $description;

		var $author;
		
		var $active;
		
		
		/**
		* returns a repository object mapped to an array
		*/
		public function toArray(){
			
			return array("id"=>$this->id, "name"=>$this->name, 
				"description"=>$this->description, "author"=>$this->author, "active"=>$this->active);
		}
		
	}
?>