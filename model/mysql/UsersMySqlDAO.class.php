<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-04-26 23:35
 */
class UsersMySqlDAO implements UsersDAO{

/** Public functions **/
	
	public function getPointsInRepo($user_id, $repository_id){
		$sql = "SELECT points FROM repositories_users WHERE repository_id = ? AND user_id = ?";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		$sqlQuery->setNumber($user_id);
		
		return $this->querySingleResult($sqlQuery);
	}
	
	public function updatePassword($email, $password){
		//TODO: averiguar c�mo funciona el tema del SALT
		$sql = "UPDATE users SET password = ? WHERE email = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setString($email);
		$sqlQuery->setString($password);
		
		return $this->execute($sqlQuery);
	}
	
	public function load($id){
		$sql = "SELECT id, email, first_name, last_name, created, active FROM users WHERE id = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($id);
		
		return $this->getRow($sqlQuery);
	}
	
	public function queryByEmail($email){
		$sql = "SELECT id, email, first_name, last_name, created, active FROM users WHERE email = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setString($email);
		
		return $this->getRow($sqlQuery);
	}
	
	public function getByRepositoryId($id){
		$sql = "SELECT u.id, u.email, u.first_name, u.last_name, u.created, u.active 
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
		
		$user->id = $row['id'];
		$user->email = $row['email'];
		$user->name =  $row['first_name'];
		$user->lastname = $row['last_name'];
		$user->created = $row['created'];
		$user->active = $row['active'];
		
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