<?php

require('configuration.php');

function warning_handler($errno, $errstr) {
	//http_response_code(500);
	errorlog("WARNING DB ERROR \n".$errno+" "+$errstr);
}
set_error_handler("warning_handler", E_WARNING);

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


function connect(){
	$mysql_host = getconfig('dbhost');
	$mysql_database = getconfig('dbname');
	$mysql_user = getconfig('dbuser');
	$mysql_password = getconfig('dbpass');
	$db = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	if($db->connect_errno > 0){
		
		errorlog('error not connected to database');
	}else{
		if(!mysqli_set_charset($db, "utf8")){
			errorlog('error charset not loading');
		}else{
			
		}
	}

	return $db;
}
function insert($sql){
	
	$mysqli = connect();
	$var = $mysqli->query($sql);
	print strval($mysqli->insert_id);
	return $var;
}
function update($sql){
	$mysqli = connect();
	$var = $mysqli->query($sql);
	return $var;
}
function login($user,$pass){
	//errorlog("LOGIN STARTS");
	$mysqli = connect();
	$ret = -1;
	$id = 0; 
	//errorlog("LOGIN SQL STARTS");
	if($stmt = $mysqli->prepare("SELECT id,type,theme FROM user WHERE name = ? and password = ? and deleted = false") ){
		/* bind result variables */
		$stmt->bind_param("ss", $user, $pass);
		$stmt->execute();

		$stmt->bind_result($id,$type,$theme);

		/* fetch values */
		while ($stmt->fetch()) {
			$ret = $type;
			$_SESSION['theme'] = $theme;
		}
		/* close statement */
		$stmt->close();
		//errorlog("USER OK");
	}else{
		errorlog(mysqli_error($mysqli));
		errorlog("hiba");
	}
	//errorlog("ret_id".$ret.'_'.$id);
	// close connection
	$mysqli->close();
	return $ret.'_'.$id;
}


?>