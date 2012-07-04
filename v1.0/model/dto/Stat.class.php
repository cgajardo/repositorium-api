<?php
	/**
	 * Object representation of stat element
	 *
	 * @author: cgajardo
	 * @date: 2012-06-13 14:13	 
	 */

	class Stat{
		
		var $users;
		
		var $documents;
		
		var $criterion;
		
		public function toArray(){
			return array("users"=>$this->users, "documents"=>$this->documents, "criterion"=>$this->criterion);
		}
	}