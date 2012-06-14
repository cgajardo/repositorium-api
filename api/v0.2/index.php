<?php
chdir('..');
include_once('./v0.2/utils.php');
include_once('../epi/Epi.php');
include_once('../v0.2/elements/repositories.php');
include_once('../v0.2/elements/documents.php');
include_once('../v0.2/elements/challenges.php');
include_once('../v0.2/elements/users.php');
include_once('../v0.2/model/include_dao.php');
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
getRoute()->get('/repositories/(\d+)/users', array('Repositories','showUsers'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/search:([^/]+)', array('Repositories','search'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/documents', array('Documents','getDocument'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/documents/random', array('Documents','getRandomDocument'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/challenges', array('Challenges','getChallenge'), EpiApi::external);

//repositories-post
getRoute()->post('/repositories/(\d+)/join', array('Repositories', 'join'), EpiApi::external);
getRoute()->post('/repositories/(\d+)/documents', array('Documents','addDocument'), EpiApi::external);
getRoute()->post('/repositories/(\d+)/challenge', array('Challenges', 'submit'), EpiApi::external);

//repositories-put
getRoute()->put('/repositories/(\d+)/documents', array('Documents','updateDocument'), EpiApi::external);


//repositories-delete
getRoute()->delete('/repositories', 'Forbidden');
getRoute()->delete('/repositories/(\d+)', 'Forbidden');
getRoute()->delete('/repositories/(\d+)/users', 'Forbidden');

/** users **/
//users-post
getRoute()->post("/users", array('Users', 'add'), EpiApi::external);
getRoute()->post("/users/login", array('Users', 'login'), EpiApi::external);
//users-get
getRoute()->get("/users/([^/]+)", array('Users', 'load'), EpiApi::external);
getRoute()->get("/users/([^/]+)/repositories", array('Users', 'loadRepositories'), EpiApi::external);
//users-put
getRoute()->put("/users/([^/]+)", array('Users', 'update'), EpiApi::external);
//users-delete
getRoute()->delete("/users", 'Forbidden');
getRoute()->delete("/users/([^/]+)/repositories", 'Forbidden');

//RUN!
getRoute()->run();

function showVersion() {
  header('HTTP/1.1 200 OK');
  echo 'The version of this api is 0.1<br>';
  echo 'You can find documentation at http://cgajardo.github.com/repositorium-api';
  exit(0);
  
}

function Forbidden(){
	header('HTTP/1.1 403 Forbidden');
	echo("You can find documentation at http://cgajardo.github.com/repositorium-api/");
	exit(0);
}


?>