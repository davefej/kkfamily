<?php
require('configuration.php');
function connect(){
	$mysql_host = getconfig('dbhost');
	$mysql_database = getconfig('dbname');
	$mysql_user = getconfig('dbuser');
	$mysql_password = getconfig('dbpass');
	$db = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	if($db->connect_errno > 0){
		errorlog('error not connected to database');
	}
	if(!mysqli_set_charset($db, "utf8")){
		errorlog('error charset not loading');
	}
	return $db;
}
function insert($sql){
	$mysqli = connect();
	$var = $mysqli->query($sql);
	return $var;
}
function update($sql){
	$mysqli = connect();
	$var = $mysqli->query($sql);
	return $var;
}
function login($user,$pass){
	$mysqli = connect();
	$ret = -1;
	
	if($stmt = $mysqli->prepare("SELECT type FROM user WHERE name = ? and password = ?") ){
		/* bind result variables */
		$stmt->bind_param("ss", $user, $pass);
		$stmt->execute();

		$stmt->bind_result($type);

		/* fetch values */
		while ($stmt->fetch()) {
			$ret = (int)$type;
		}
		/* close statement */
		$stmt->close();
	}

	// close connection
	$mysqli->close();
	return $ret;
}

?>