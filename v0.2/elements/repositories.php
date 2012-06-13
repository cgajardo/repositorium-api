<?php
class Repositories{

	public static function index(){
		$repositories = DAOFactory::getRepositoriesDAO()->queryAll();
		$repos = array();
		foreach($repositories as $repository){
			array_push($repos, $repository->toArray());
		}
		return $repos;
	}
	
	//@deprecated
	public static function indexXml(){
		$repositories = DAOFactory::getRepositoriesDAO()->queryAll();
		$repos = array();
		foreach($repositories as $repository){
			array_push($repos, $repository->toArray());
		}
		$xml = new SimpleXMLElement("<repositories></repositories>");
		array_to_xml($repos,$xml);
		return $xml->asXML();
	}
	
	public static function show($id){
		$repository = DAOFactory::getRepositoriesDAO()->load($id);
		return $repository;
	}
	
	public static function showStats($id){
		$stat = new Stat();
		
		$stat->users = DAOFactory::getRepositoriesDAO()->getNumberOfUsers($id);
		$stat->documents= DAOFactory::getRepositoriesDAO()->getNumberOfDocuments($id);
		$stat->criterion = DAOFactory::getRepositoriesDAO()->getNumberOfCriterion($id);
		
		return $stat->toArray();
	}
	
	
	public static function showUsers($id){
		$users = DAOFactory::getUsersDAO()->getByRepositoryId($id);
		return $users;
	}
	
	public static function search($id, $query){
		
		$User = getSession()->get('user');
		$fields = $_GET['fields'];
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
		
		//user can afford this search
		if($User->canAfford($id)){
			if($fields != null){
				$search  = array("tags", "title", "content", ",");
				$replace = array("tag LIKE '%".$query."%'", "title LIKE '%".$query."%'", "content LIKE '%".$query."%'", " OR ");
				$filter = str_replace($search, $replace, $fields);
			}else{
				$filter = "tag LIKE '%".$query."%' OR title LIKE '%".$query."%' OR content LIKE '%".$query."%'";
			}
			
			$limit = DAOFactory::getRepositoriesDAO()->getPackSize($id);
			$documents = DAOFactory::getDocumentsDAO()->search($id, $filter, $limit);
			
			//to obscure data to user
			foreach ($documents as $documents){
				unset($documents->id);
			}
			
			DAOFactory::getUsersDAO()->substractPoints($id, $User->id);
			
			//returns a list of documents resulting from the search query
			return $documents;
				
		//user cann't afford this search
		}else{
			//put query on session to search when user answers question
			getSession()->set("search_query", $query);
			
			$challenges = DAOFactory::getChallengesDAO()->getChallenges($id,$User->id);
			
			//return a challenge for this user
			return $challenges;
		}
	}
	
	public static function getRandomDocument($id){
		//TODO: user must be logged in order to discount point of this download
		$document = DAOFactory::getDocumentsDAO()->getRandom($id);
		return $document;
	}
	
	public static function getDocument($id){
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
		if(!$User->isAdmin($id)){
			return returnError('401 Unauthorized','This action can only be performed by admin users');
		}
		
		$document = DAOFactory::getDocumentsDAO()->load($docId);
		
		if($document == null){
			return returnError('404 Not Found','Document with id '.$docId.' was not found');
		}
		
		return $document->toArray();
	}
	
	public static function getChallenge($id){
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
			
		$challenges = DAOFactory::getChallengesDAO()->getChallenges($id,$User->id);
			
		//return a challenge for this user
		//TODO: review this, should be more like $challenges->toArray()
		return $challenges;	
	}
	
	
	public static function addDocument($id){
		
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
		//TODO: get today date
		//$Document->created = TODAY
		if(isset($_POST['file'])){
			$Document->file = $_POST['file'];
		}
		if(isset($_POST['tag'])){
			$Document->tag = $_POST['tag'];
		}
		//TODO: call MySQLDAO to save this document!!!!
		
		
	}
	
	public function join($id){
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		
		$id = DAOFactory::getUsersDAO()->joinRepository($id, $User->id);
		
		//TODO: should i return the id?
		
	}


}
?>