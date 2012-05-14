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
		//TODO: define stats
	}
	
	
	public static function showUsers($id){
		$users = DAOFactory::getUsersDAO()->getByRepositoryId($id);
		return $users;
	}
	
	public static function search($id, $query, $fields = null){
		$User = getSession()->get('user');
		
		//there's no user in session
		if($User == null){
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "User must be logged in";
			header('HTTP/1.1 401 Unauthorized');
			return $Error->toArray();
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
			
			//TODO: substract the point of this dowload
			//DAOFactory::getUsersDAO()->substractPoints($id);
			
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

}
?>