<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-04-26 23:35
 */
class UsersMySqlDAO implements UsersDAO{

/** Public functions **/
	
	public function load($id){
		$sql = "SELECT email, first_name, last_name FROM users WHERE id = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($id);
		
		return $this->getRow($sqlQuery);
	}
	
	public function getByRepositoryId($id){
		$sql = "SELECT u.email, u.first_name, u.last_name 
				FROM users AS u JOIN repositories_users AS ru ON ru.user_id = u.id 
				WHERE ru.repository_id = ?";
		
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($id);
		
		return $this->getList($sqlQuery);
	}


/** Private functions **/
	
	/**
	 * Read row
	 *
	 * @return User
	 */
	protected function readRow($row){
		$user = new User();
		
		$user->email = $row['email'];
		$user->name =  $row['first_name'];
		$user->lastname = $row['last_name'];

		return $user;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return BadgesMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>