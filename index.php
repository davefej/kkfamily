<?php

	session_start();
	if(
			(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "admin" && $_POST["password"] == "kkpass")
			||	$_SESSION['admin'] == true && !isset($_POST["username"])){
		$_SESSION['admin'] = true;
		$_SESSION['raktar'] = false;
?>
<?php
$selected ="index";
require("header.php");
?>

<table align="center" class="maintable" border="1">
	<tr>
		<th class="mainth">
			Napi Bevétel (Raktár)
		</th>
		<th class="mainth">
			Napi Kiadás (Raktár)
		</th>
		<th class="mainth">
			Hamarosan Lejáró Termékek
		</th>
	</tr>
	<tr>
		<td class="maintd">
			<div class="maintddiv">
			<?php 			
			require('helper/mysqli.php');
			listnapibevetel();			
			?>
			
			</div>
		</td>
		<td class="maintd">
			<div class="maintddiv">				
				<?php 
				listnapikiadas();
				?>					
			</div>
		</td>
		<td class="maintd">
			<div class="maintddiv">
				<?php 
				listlejar();
				?>
			</div>

<?php 
require("footer.php");
?>

<?php 
		
	}else
	if(isset($_POST["username"]) && isset($_POST["password"]) && 
			$_POST["username"] == "raktar" && $_POST["password"] == "kkpass"){
				$_SESSION['raktar'] = true;
				$_SESSION['admin'] = false;
		
	}
	if($_SESSION['raktar']){
		header('Location: tablet/bevetel.php');
	}
	
	
	if(!$_SESSION['admin'] && !$_SESSION['raktar'] || 
			isset($_POST["username"]) && isset($_POST["password"]) &&
			(($_POST["username"] != "raktar" && $_POST["username"] != "admin") ||
				$_POST["password"] != "kkpass")){
		
		header('Location: index.html');
		return;
	}
	
	
	

?>

