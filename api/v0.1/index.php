<?php
chdir('..');
include_once('./v0.1/utils.php');
include_once('../epi/Epi.php');
include_once('../elements/repositories.php');
include_once('../elements/users.php');
include_once('../model/include_dao.php');
Epi::setPath('base', '../epi');
Epi::init('api');
Epi::init('session');
EpiSession::employ(EpiSession::PHP);



//let's define some access routes
/** defaul route: WELCOME **/
getRoute()->get('/repositories', array('Repositories', 'index'), EpiApi::external);

/** repositories **/
//repositories-get
getRoute()->get('/repositories', 'showVersion');
getRoute()->get('/repositories/(\d+)', array('Repositories','show'), EpiApi::external);
getRoute()->get('/repositories/(\d+)/stats', array('Repositories','showStats'), EpiApi::external);
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




//RUN!
getRoute()->run();

function showVersion() {
  echo 'The version of this api is 0.1<br>';
  echo 'You can find documentation <a href="http://cgajardo.github.com/repositorium-api/">here</a>';
  
}

function Forbidden(){
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}


?>