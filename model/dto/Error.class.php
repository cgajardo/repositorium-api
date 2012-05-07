<?php
	/**
	 * Object representation of error element
	 *
	 * @author: cgajardo
	 * @date: 2012-05-7 11:55	 
	 */
	class Error{
		
		var $status;
		var $message;
		
		public function toArray(){
			return array("status"=>$this->status, "message"=>$this->message);
		}
			
	}
?>