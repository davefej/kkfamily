<?php

	
	if(isset($_POST["username"]) && isset($_POST["password"])){
		session_start();
		
		require 'helper/mysqli.php';
		$ret = login($_POST["username"],$_POST["password"]);
		$login_data = explode("_", $ret);
		if((int)$login_data[0] === 0){
			$_SESSION['user_id'] = $login_data[1];
			header('Location: admin/admin.php');
		}else if((int)$login_data[0] === 1){
			$_SESSION['user_id'] = $login_data[1];
			header('Location: tablet/bevetel.php');
		}else{
			
			header('Location: index.html');
		}
	}else{
		header('Location: index.html');
	}



		
?>





