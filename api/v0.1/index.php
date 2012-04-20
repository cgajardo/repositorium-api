<?php
chdir('..');
include_once '../epi/Epi.php';
Epi::setPath('base', '../epi');
Epi::init('api');


//let's define some access routes
getRoute()->get('/', 'showRepositories');
getRoute()->get('/version', 'showVersion');
getApi()->get('/repositories.json', 'showRepositories', EpiApi::external);
getApi()->get('/repositories.xml', 'showRepositories', EpiApi::external);
getRoute()->run();

function showVersion() {
  echo 'The version of this api is 0.1';
}

function showRepositories($type){
	echo 'Repositories '.$type;
}
?>