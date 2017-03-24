<?php

function errorlog2($error){
	$myfile = fopen("error.txt", "a");
	fwrite($myfile, "\r\n". date('Y-m-d h:i:sa'). "\r\n");
	fwrite($myfile, $error);
	fclose($myfile);
}
	
	if(isset($_POST["username"]) && isset($_POST["password"])){
		$bool = session_start();
		require 'helper/mysqli.php';
		$ret = login($_POST["username"],$_POST["password"]);
		$login_data = explode("_", $ret);
		if((int)$login_data[0] === 0){
			$_SESSION['user_id'] = $login_data[1];
			loginlog($_POST["username"],"admin");
			header('Location: admin/admin.php');
		}else if((int)$login_data[0] === 1){
			$_SESSION['user_id'] = $login_data[1];
			loginlog($_POST["username"],"raktar");
			header('Location: tablet/bevetel.php');
		}else{
			
			header('Location: index.html');
		}
	}else{
		header('Location: index.html');
	}

		
?>





