<?php

	session_start();

	if(isset($_POST["username"]) && isset($_POST["password"])){
		session_start();
		require 'helper/mysqli.php';
		$ret = login($_POST["username"],$_POST["password"]);
		if($ret === 0){
			header('Location: admin/admin.php');
		}else if($ret === 1){
			header('Location: tablet/bevetel.php');
		}else{
			header('Location: index.html');
		}
	}else{
		header('Location: index.html');
	}



		
?>





