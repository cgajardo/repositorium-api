<?php
chdir('..');
include_once('./v0.1/utils.php');
include_once('../epi/Epi.php');
include_once('../elements/repositories.php');
include_once('../model/include_dao.php');
Epi::setPath('base', '../epi');
Epi::init('api');


//let's define some access routes
getRoute()->get('/repositories', array('Repositories', 'index'));
getApi()->get('/repositories.json', array('Repositories', 'indexJson'), EpiApi::external);
getRoute()->get('/version', 'showVersion');
getRoute()->run();

function showVersion() {
  echo 'The version of this api is 0.1';
}

?>