<?php

	session_start();
	if(
			(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "admin" && $_POST["password"] == "kkpass")
			){
				header('Location: admin.php');
				

	}else
		if(isset($_POST["username"]) && isset($_POST["password"]) &&
				$_POST["username"] == "raktar" && $_POST["password"] == "kkpass"){
	
				header('Location: tablet/bevetel.php');
	}else{
		header('Location: index.html');
	}
?>






