<?php
require('mysqli.php');


$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody,True);

if(array_key_exists("type",$data)){
	if($data["type"] == "besz"){				
		$sql = "UPDATE `supplier` SET `name` = '".$data['nev']."', `address` = '".$data['cim']."' WHERE `id` = ".$data['id'].";";
	}else if($data["type"] == "alap"){
		$sql = "UPDATE `alapanyag` SET `nev` = '".$data['nev']."', `kategoria` = '".$data['kategoria']."' WHERE `id` = ".$data['id'].";";				
	}else if($data["type"] == "raktar"){
		$sql = "UPDATE `raklap` SET `statusz` = '1', `kiadasido` = now() WHERE `id` = ".$data['id'].";";
	}
	$ret =  update($sql);
	return $ret;
}
 
?>