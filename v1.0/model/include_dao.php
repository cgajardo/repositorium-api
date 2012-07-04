<?php
	//include all DAO files
	require_once('../v1.0/model/sql/Connection.class.php');
	require_once('../v1.0/model/sql/ConnectionFactory.class.php');
	require_once('../v1.0/model/sql/ConnectionProperty.class.php');
	require_once('../v1.0/model/sql/QueryExecutor.class.php');
	require_once('../v1.0/model/sql/Transaction.class.php');
	require_once('../v1.0/model/sql/SqlQuery.class.php');
	require_once('../v1.0/model/core/ArrayList.class.php');
	require_once('../v1.0/model/dao/DAOFactory.class.php');
 	
	require_once('../v1.0/model/dao/RepositoriesDAO.class.php');
	require_once('../v1.0/model/dto/Repository.class.php');
	require_once('../v1.0/model/mysql/RepositoriesMySqlDAO.class.php');
	
	require_once('../v1.0/model/dao/UsersDAO.class.php');
	require_once('../v1.0/model/dto/User.class.php');
	require_once('../v1.0/model/mysql/UsersMySqlDAO.class.php');
	
	require_once('../v1.0/model/dao/DocumentsDAO.class.php');
	require_once('../v1.0/model/dto/Document.class.php');
	require_once('../v1.0/model/mysql/DocumentsMySqlDAO.class.php');
	
	require_once('../v1.0/model/dao/ChallengesDAO.class.php');
	require_once('../v1.0/model/dto/Challenge.class.php');
	require_once('../v1.0/model/mysql/ChallengesMySqlDAO.class.php');
	
	require_once('../v1.0/model/dto/Error.class.php');
	require_once('../v1.0/model/dto/Stat.class.php');

?>