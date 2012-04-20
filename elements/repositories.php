<?php
chdir('..');
include_once './epi/Epi.php';
Epi::setPath('base', './epi');
Epi::init('api');

//let's define some access routes
getRoute()->get('/repositories', 'showRepositories');

function showRepositories(){
	echo "soy seco";
}
?>