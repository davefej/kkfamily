<?php

function getconfig($name){
	$inipath = "conf.ini";
	return parse_ini_file($inipath)["$name"];
}

function errorlog($error){
	if($error == "0"){
		return;
	}
	$myfile = fopen("error.txt", "a");
	fwrite($myfile, "\r\n". date('Y-m-d h:i:sa'). "\r\n");
	fwrite($myfile, $error);
	fclose($myfile);	
}

function logg($error){
	$myfile = fopen("log.txt", "a");
	fwrite($myfile, "\r\n". date('Y-m-d h:i:sa') ."\r\n");
	fwrite($myfile, $error);
	fclose($myfile);
}

?>