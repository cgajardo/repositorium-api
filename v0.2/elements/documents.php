<?php
class Documents{
	
	public static function getRandomDocument($repo_id){
	
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
	
		$document = DAOFactory::getDocumentsDAO()->getRandom($repo_id);
	
		DAOFactory::getUsersDAO()->substractPoints($repo_id, $User->id);
	
		return $document;
	}
	
	public static function getDocument($repo_id){
		//no id in request
		if(!isset($_GET['id'])){
			return returnError('488 Missing parameter','Document id parameter expected');
		}
		$docId = $_GET['id'];
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
		if(!$User->isAdmin($repo_id)){
			return returnError('401 Unauthorized','This action can only be performed by admin users');
		}
	
	
		$document = DAOFactory::getDocumentsDAO()->load($docId);
	
		if($document == null){
			return returnError('404 Not Found','Document with id '.$docId.' was not found');
		}
	
		return $document;
	}
	
	public static function addDocument($repo_id){
	
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
	
		//{title:_title; content: _content | file: _file | tag: _tag}
		if(!isset($_POST['title']) || !isset($_POST['content'])){
			return returnError('488 Missing parameter','Title and content are required');
		}
	
		$Document = new Document();
		$Document->author = $User->id;
		$Document->title = $_POST['title'];
		$Document->content = $_POST['content'];
		$Document->created = date("Y-m-d H:i:s");
		if(isset($_POST['file'])){
			$Document->file = $_POST['file'];
		}
		if(isset($_POST['tag'])){
			$Document->tag = $_POST['tag'];
		}
		DAOFactory::getDocumentsDAO()->insert($Document,$repo_id);
	}
	
	
	public static function updateDocument($repo_id){
		
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		if(!$User->isAdmin($repo_id))
			return returnError('401 Unauthorized','Only admin users can perform this action');
		//TODO!!
		
	}
}
?>