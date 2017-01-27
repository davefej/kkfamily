<?php

require('mysqli.php');


$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody,True);

if(array_key_exists("type",$data)){
if($data["type"] == "category"){				
		$sql = "UPDATE `category` SET `deleted` = '1' WHERE `category`.`id` = ".$data['id'];
	}else if($data["type"] == "user"){
		$sql = "UPDATE `user` SET `deleted` = '1' WHERE `user`.`id` = ".$data['id'];				
	}else if($data["type"] == "supplier"){
		$sql = "UPDATE `supplier` SET `deleted` = '1' WHERE `supplier`.`id` = ".$data['id'];
	}else if($data["type"] == "product"){
		$sql = "UPDATE `product` SET `deleted` = '1' WHERE `product`.`id` = ".$data['id'];
	}else if($data["type"] == "trash"){
		$sql = "UPDATE `trash` SET `deleted` = '1' WHERE `trash`.`id` = ".$data['id'];
	}else if($data["type"] == "pallet"){
		$sql = "UPDATE `pallet` SET `deleted` = '1' WHERE `pallet`.`id` = ".$data['id'];
	}else if($data["type"] == "output"){
		$sql = "UPDATE `output` SET `deleted` = '1' WHERE `output`.`id` = ".$data['id'];
	}	
	return update($sql); 
}
 
?>