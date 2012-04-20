<?php
/*
 * Class return connection to database
 *
 * @author: http://phpdao.com
 * @date: 27.11.2007
 */
class ConnectionFactory{
	
	/**
	 * Zwrocenie polaczenia
	 *
	 * @return polaczenie
	 */
	static public function getConnection(){
		$conn = mysql_connect(ConnectionProperty::getHost(), ConnectionProperty::getUser(), ConnectionProperty::getPassword());
		mysql_set_charset('utf8',$conn);
		mysql_select_db(ConnectionProperty::getDatabase());
		if(!$conn){
			throw new Exception('could not connect to database');
		}
		//cgajardo: ejecutamos por seguridad para evitarnos todas las tonterías
		mysql_query("SET NAMES 'utf8'");
		return $conn;
	}

	/**
	 * Zamkniecie polaczenia
	 *
	 * @param connection polaczenie do bazy
	 */
	static public function close($connection){
		mysql_close($connection);
	}
}
?>