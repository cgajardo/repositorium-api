<?php
class Documents{
	
	public static function getRandom($repo_id){
	
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
	
		$document = DAOFactory::getDocumentsDAO()->getRandom($repo_id);
	
		DAOFactory::getUsersDAO()->substractPoints($repo_id, $User->id);
	
		return $document;
	}
	
	public static function get($repo_id){
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
	
	public static function add($repo_id){
	
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
	
	
	public static function update($repo_id){
		//trying to bypass PHP missing support for PUT and DELETE
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		if(!$User->isAdmin($repo_id))
			return returnError('401 Unauthorized','Only admin users can perform this action');
		
		
		print_r($_PUT);
		if(!isset($_PUT['id']))
			return returnError('488 Missing parameter','Document ID is required');
		
		$Document = DAOFactory::getDocumentsDAO()->load($_PUT['id']);
		
		if($Document == null)
			return returnError('401 Unauthorized','Document does not exist, try creating a new document');
		
		if(isset($_PUT['title']))	
			$Document->title = $_PUT['title'];
		
		if(isset($_PUT['']))
			$Document->content = $_PUT['title'];
		
		DAOFactory::getDocumentsDAO()->update($Document);
		
		
	}
}
?>