<?php
	/**
	 * Object representation of document element
	 *
	 * @author: cgajardo
	 * @date: 2012-05-08 16:34	 
	 */
	class Document{
		
		//private
		var $id;
		
		var $title;
		
		var $content;

		var $author;

		var $created;
		
		var $files;
		
		var $tags;
		
		
		/**
		* returns a document object mapped to an array
		*/
		public function toArray(){
			return array("title"=>$this->title, "content"=>$this->content, 
					"author"=>$this->author->toArray(), "created"=>$this->created,"files"=>$this->files,
					"tags"=>$this->tags);
		}
		
	}
?>