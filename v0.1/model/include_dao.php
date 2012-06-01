<?php
	//include all DAO files
	require_once('../v0.1/model/sql/Connection.class.php');
	require_once('../v0.1/model/sql/ConnectionFactory.class.php');
	require_once('../v0.1/model/sql/ConnectionProperty.class.php');
	require_once('../v0.1/model/sql/QueryExecutor.class.php');
	require_once('../v0.1/model/sql/Transaction.class.php');
	require_once('../v0.1/model/sql/SqlQuery.class.php');
	require_once('../v0.1/model/core/ArrayList.class.php');
	require_once('../v0.1/model/dao/DAOFactory.class.php');
 	
	require_once('../v0.1/model/dao/RepositoriesDAO.class.php');
	require_once('../v0.1/model/dto/Repository.class.php');
	require_once('../v0.1/model/mysql/RepositoriesMySqlDAO.class.php');
	
	require_once('../v0.1/model/dao/UsersDAO.class.php');
	require_once('../v0.1/model/dto/User.class.php');
	require_once('../v0.1/model/mysql/UsersMySqlDAO.class.php');
	
	require_once('../v0.1/model/dao/DocumentsDAO.class.php');
	require_once('../v0.1/model/dto/Document.class.php');
	require_once('../v0.1/model/mysql/DocumentsMySqlDAO.class.php');
	
	require_once('../v0.1/model/dao/ChallengesDAO.class.php');
	require_once('../v0.1/model/dto/Challenge.class.php');
	require_once('../v0.1/model/mysql/ChallengesMySqlDAO.class.php');
	
	require_once('../v0.1/model/dto/Error.class.php');

?>