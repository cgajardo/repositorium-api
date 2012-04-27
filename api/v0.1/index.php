<?php
chdir('..');
include_once('./v0.1/utils.php');
include_once('../epi/Epi.php');
include_once('../elements/repositories.php');
include_once('../elements/users.php');
include_once('../model/include_dao.php');
Epi::setPath('base', '../epi');
Epi::init('api');



//let's define some access routes

/** repositories **/
//repositories-get
getRoute()->get('/repositories', array('Repositories', 'index'), EpiApi::external);
getRoute()->get('/repositories/(\d+)', array('Repositories','show'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/stats', array('Repositories','showStats'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/users', array('Repositories','showUsers'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/search:([^/]+)', array('Repositories','search'), EpiApi::external);
//repositories-delete
getRoute()->delete('/repositories', 'Forbidden');
getRoute()->delete('/repositories/(\d+)/users', 'Forbidden');

/** users **/
//users-post
getRoute()->post("/users", array('Users', 'add'), EpiApi::external);
getRoute()->post("/users/(\w+)", array('Users', 'login'), EpiApi::external);
//users-get
getRoute()->get("/users/(\w+)", array('Users', 'load'), EpiApi::external);
getRoute()->get("/users/(\w+)/repositories", array('Users', 'loadRepositories'), EpiApi::external);
//users-put
getRoute()->get("/users/(\w+)", array('Users', 'update'), EpiApi::external);
//users-delete
getRoute()->delete("/users", 'Forbidden');
getRoute()->delete("/users/(\w+)/repositories", 'Forbidden');


//RUN!
getRoute()->run();

function showVersion() {
  echo 'The version of this api is 0.1';
}

function Forbidden(){
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}


?>