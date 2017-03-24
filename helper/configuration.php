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

function loginlog($user,$type){
	$myfile = fopen("log/login.txt", "a");
	fwrite($myfile, "\r\n". date('Y-m-d H:i:s') ."\r\n");
	fwrite($myfile, $user." ".$type);
	fclose($myfile);
	
	if($type == "raktar"){
		$myfile = fopen("log/lastlogin.txt", "w");
		fwrite($myfile, $user."#_#".date('Y-m-d H:i:s'));
		fclose($myfile);
	}
	
}

function lastlog(){
	if ($file = fopen("../log/lastlogin.txt", "r")) {
		while(!feof($file)) {
			$line = fgets($file);
			$tmp = explode("#_#",$line);
			break;
		}
		fclose($file);
		
		$current = strtotime(date("Y-m-d"));
		$date    = strtotime($tmp[1]);
		
		$datediff = $date - $current;
		$difference = floor($datediff/(60*60*24));
		$datestr = explode(" ",$tmp[1]);
		if($difference==0)
		{
			//TODAY
			
			return array(
				    "user" => $tmp[0],
				    "day" => $datestr[1]
				);
		}else{
			return array(
					"user" => $tmp[0],
					"day" => $datestr[0]."<br>".$datestr[1]
			);
		}
	}else{
		return array(
					"user" => "",
					"day" => ""
			);
	}
}

?>