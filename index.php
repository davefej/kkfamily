<?php 
	session_start();
	if(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "admin" && $_POST["password"] == "kkpass"){
		$_SESSION['admin'] = true;
?>
<html>
	<head>
		<title>admin</title>
		<meta charset="UTF-8">
	</head>
	<body class="admin">
		<table align="center" class="reg_table">
			<tr>
				<td class="reg_table_row_1" colspan="2">Táblák</td>
			</tr>
			<tr>
				<td class="reg_table_col_1">Suppliers</td>
				<td class="reg_table_mid_cell"><a  class="admin_button" href="suppliers.php">clcik me </a></td>
			</tr>
		</table>
	</body>
</html>
		<?php 
	}else
	if(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "raktart" && $_POST["password"] == ""){
	
				header('Location: raktar.php');
		
	}else {
		
		header('Location: index.html');
		return;
	}

?>

