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
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
		
		//user can afford this search
		if($User->canAfford($id)){
			if(isset($_GET['fields'])){
				$fields = $_GET['fields'];
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
	
	
	
	public function join($id){
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		
		$joinId = DAOFactory::getUsersDAO()->joinRepository($id, $User->id);
		$criterion = DAOFactory::getRepositoriesDAO()->getCriterion($id);
		foreach ($criterion as $criteria){
			DAOFactory::getUsersDAO()->asociateCriteria($User->id, $criteria);
		}
		
		
		
	}


}
?>