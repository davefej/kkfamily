<?php
/*
	session_start();
	if(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "admin" && $_POST["password"] == "kkpass"){
		$_SESSION['admin'] = true;
*/
?>
<?php 
require("header.php");
?>

<table align="center" class="maintable" border="1">
	<tr>
		<th class="mainth">
			Bevétel (Raktár)
		</th>
		<th class="mainth">
			Kiadás (Raktár)
		</th>
		<th class="mainth">
			Lejáró Termékek
		</th>
	</tr>
	<tr>
		<td class="maintd">
			<div class="maintddiv">
			</div>
		</td>
		<td class="maintd">
			<div class="maintddiv">
			</div>
		</td>
		<td class="maintd">
			<div class="maintddiv">
			</div>
		</td>
	</tr>
</table>

<?php 
require("footer.php");
?>

<?php 
		/*
	}else
	if(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "raktar" && $_POST["password"] == ""){
	
				header('Location: raktar.php');
		
	}else {
		
		header('Location: index.html');
		return;
	}
*/
?>

