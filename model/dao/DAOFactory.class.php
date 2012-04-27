<?php

/**
 * DAOFactory
 * @author: cgajardo
 * @date: 2012-04-20 01:29
 */
class DAOFactory{
	
	/**
	 * @return RepositoriesDAO
	 */
	public static function getRepositoriesDAO(){
		return new RepositoriesMySqlDAO();
	}
	
	/**
	 * @return UsersDAO
	 */
	public static function getUsersDAO(){
		return new UsersMySqlDAO();
	}


}
?>