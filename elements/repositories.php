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
		
		if($User->canAfford($id)){
			//muestro la lista de documentos	
		}else{
			//muestro la lista de desaf’os
		}
		
		return $User->canAfford($id);
	}

}
?>