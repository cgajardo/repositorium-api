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
	
	public static function search($id, $query){
		$User = getSession()->get('user');
		
		if($User == null){
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "User must be logged in";
			header('HTTP/1.1 401 Unauthorized');
			return $Error->toArray();
		}
		
		//user can afford this search
		if($User->canAfford($id)){
			//muestro un set aleatorio de documentos TODO: do the search
			$arguments =  explode(";",$query);
			
			if(count($arguments) == 2){
				$fields = explode("fields:",$arguments[1]);
				$fields = $fields[0];
				$search  = array("tags", "title", "content", ",");
				$replace = array("tag LIKE '%?%'", "title LIKE '%?%'", "content LIKE '%?%'", " OR ");
				$injet = str_replace($search, $replace, $fields);
				return "afford".$injet;
			}
			$query = $arguments[0];
			
				
		//user cann't afford this search
		}else{
			//gurado la querry en session y le paso un set de desaf’os
			
			//muestro un set aleatorio de documentos TODO: do the search
			$arguments =  explode(";",$query);

			if(count($arguments) == 2){
				$fields = explode(":",$arguments[1]);
				$fields = $fields[1];
				$search  = array("tags", "title", "content", ",");
				$replace = array("tag LIKE '%?%'", "title LIKE '%?%'", "content LIKE '%?%'", " OR ");
				$injet = str_replace($search, $replace, $fields);
			}
			$query = $arguments[0];
			
		}
	}

}
?>