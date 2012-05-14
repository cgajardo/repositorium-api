<?php
	/**
	 * Object representation of challenge element
	 *
	 * @author: cgajardo
	 * @date: 2012-05-13 16:32	 
	 */
	class Challenge{
		
		var $id;
		var $question;
		var $documents;
		var $answera;
		var $answerb;
		
		
		public function toArray(){
			
			return array("id"=>$this->id, "question"=>$this->question, "document"=>array($this->documents), 
					"answera"=>$this->answera, "answerb"=>$this->answerb);
			
		}
			
	}
?>