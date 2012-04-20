<?php
class Repositories{

public static function index(){
	//TODO: cachar el tema de los templates en EPI
	$repositories = DAOFactory::getRepositoriesDAO()->queryAll();
	$repos = array();
	foreach($repositories as $repository){
		array_push($repos, $repository->toArray());
	}
	$xml = new SimpleXMLElement("<repositories></repositories>");
	array_to_xml($repos,$xml);
	echo $xml->asXML();
}

public static function indexJson(){
	$repositories = DAOFactory::getRepositoriesDAO()->queryAll();
	$repos = array();
	foreach($repositories as $repository){
		array_push($repos, $repository->toArray());
	}
	return $repos;
}

public static function show(){
}

}
?>