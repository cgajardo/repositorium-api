<?php
	/**
	 * Object representation of document element
	 *
	 * @author: cgajardo
	 * @date: 2012-05-08 16:34	 
	 */
	class Document{
		
		var $title;
		
		var $content;

		var $author;

		var $created;
		
		var $files;
		
		var $tags;
		
		
		/**
		* returns a repository object mapped to an array
		*/
		public function toArray(){
			//TODO: improve tags and files
			return array("title"=>$this->title, "content"=>$this->content, 
					"author"=>$this->author->toArray(), "created"=>$this->created,"files"=>array($files),
					"tags"=>array($tags));
		}
		
	}
?>