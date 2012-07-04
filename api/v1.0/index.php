<?php
chdir('..');
include_once('./v1.0/utils.php');
include_once('../epi/Epi.php');
include_once('../v1.0/controller/repositories.php');
include_once('../v1.0/controller/documents.php');
include_once('../v1.0/controller/challenges.php');
include_once('../v1.0/controller/users.php');
include_once('../v1.0/model/include_dao.php');
Epi::setPath('base', '../epi');
Epi::setPath('config', '../api/v1.0');
Epi::init('api');
Epi::init('session');
EpiSession::employ(EpiSession::PHP);

//load paths
getRoute()->load('routes.ini');

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