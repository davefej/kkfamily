<?php
require('mysqli.php');


$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody,True);

if(array_key_exists("type",$data)){
	if($data["type"] == "besz"){				
		$sql = "INSERT INTO `supplier` (`id`, `name`, `address`, `deleted`) VALUES (NULL, '".$data['nev']."', '".$data['cim']."', '0');";
	}else if($data["type"] == "alap"){
		$sql = "INSERT INTO `alapanyag` (`id`, `nev`, `kategoria`) VALUES (NULL, '".$data['nev']."', '".$data['kategoria']."')";				
	}else if($data["type"] == "raktar"){
		$sql = "INSERT INTO `raklap` (`id`, `alapanyag_id`, `beszallito_id`, `mennyiseg`, `idopont`, `statusz`, `deleted`) VALUES (NULL, '".$data["alap"]."', '".$data["besz"]."', '".$data["suly"]."', CURRENT_TIMESTAMP, '0', '0')";
	}
	insert($sql);
}
 
?>