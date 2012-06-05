<?php
chdir('..');
include_once('./v0.1/utils.php');
include_once('../epi/Epi.php');
include_once('../v0.1/elements/repositories.php');
include_once('../v0.1/elements/users.php');
include_once('../v0.1/model/include_dao.php');
Epi::setPath('base', '../epi');
Epi::init('api');
Epi::init('session');
EpiSession::employ(EpiSession::PHP);

/** welcome **/
getRoute()->get('/', 'showVersion');

/** repositories **/
//repositories-get
getRoute()->get('/repositories', array('Repositories', 'index'), EpiApi::external);
getRoute()->get('/repositories/(\d+)', array('Repositories','show'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/stats', array('Repositories','showStats'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/random', array('Repositories','getRandomDocument'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/users', array('Repositories','showUsers'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/search:([^/]+);fields:((tags,?|title,?|content,?)*)',array('Repositories','search'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/search:([^/]+)', array('Repositories','search'), EpiApi::external);

//repositories-delete
getRoute()->delete('/repositories', 'Forbidden');
getRoute()->delete('/repositories/(\d+)', 'Forbidden');
getRoute()->delete('/repositories/(\d+)/users', 'Forbidden');

/** users **/
//users-post
getRoute()->post("/users", array('Users', 'add'), EpiApi::external);
getRoute()->post("/users/login", array('Users', 'login'), EpiApi::external);
//users-get
//TODO: regular expression to filter email adresses
getRoute()->get("/users/([^/]+)", array('Users', 'load'), EpiApi::external);
getRoute()->get("/users/([^/]+)/repositories", array('Users', 'loadRepositories'), EpiApi::external);
//users-put
getRoute()->put("/users/([^/]+)", array('Users', 'update'), EpiApi::external);
//users-delete
getRoute()->delete("/users", 'Forbidden');
getRoute()->delete("/users/([^/]+)/repositories", 'Forbidden');

/** challenges **/
//challenges
getRoute()->post("/challenges", array('Challenges', 'submit'), EpiApi::external);

//TODO: tablas de aceptacion

//RUN!
getRoute()->run();

function showVersion() {
  header('HTTP/1.1 200 OK');
  echo 'The version of this api is 0.1<br>';
  echo 'You can find documentation <a href="http://cgajardo.github.com/repositorium-api/">here</a>';
  exit(0);
  
}

function Forbidden(){
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

function RTFM(){
	header('HTTP/1.1 405 Method Not Allowed');
	//TODO: include list of allowed method for this request
	echo 'You can find documentation at http://cgajardo.github.com/repositorium-api/';
	exit(0);
	
}


?>