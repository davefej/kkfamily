<?php
require('mysqli.php');


$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody,True);

if(array_key_exists("type",$data)){
	if($data["type"] == "category"){				
		$sql = "UPDATE `category` SET `name` = '".$data['name']."' WHERE `category`.`id` = ".$data['id'];
	}else if($data["type"] == "user_name"){
		$sql = "UPDATE `user` SET `name` = '".$data['name']."' WHERE `user`.`id` = ".$data['id'];				
	}else if($data["type"] == "user_password"){
		$sql = "UPDATE `user` SET `password` = '".$data['password']."' WHERE `user`.`id` = ".$data['id'];				
	}else if($data["type"] == "supplier"){
		$sql = "UPDATE `supplier` SET `name` = '".$data['name']."', `address` = '".$data['address']."' WHERE `id` = ".$data['id'];
	}else if($data["type"] == "product"){
		$sql = "UPDATE `product` SET `name` = '".$data['name']."', `category_id` = '".$data['category_id']."', `type` = '".$data['product_type']."' , `minimum` = '".$data['min']."' WHERE `product`.`id` = ".$data['id'];
	}else if($data["type"] == "trash"){
		$sql = "UPDATE `trash` SET `pallet_id` = '".$data['pallet_id']."', `amount` = '".$data['amount']."', `time` = '".$data['time']."', `user_id` = '".$data['user_id']."' WHERE `trash`.`id` = ".$data['id'];
	}else if($data["type"] == "pallet"){
		$sql = "UPDATE `pallet` SET `product_id` = '".$data['product_id']."', `supplier_id` = '".$data['supplier_id']."', `time` = '".$data['time']."', `amount` = '".$data['amount']."', `user_id` = '".$data['user_id']."' WHERE `pallet`.`id` = ".$data['id'];
	}else if($data["type"] == "output"){
		$sql = "UPDATE `output` SET `pallet_id` = '".$data['pallet_id']."', `amount` = '".$data['amount']."', `time` = '".$data['time']."', `user_id` = '".$data['user_id']."' WHERE `output`.`id` = ".$data['id'];
	}else if($data["type"] == "alert"){
		$sql = "UPDATE `alert` SET `seen` = '1'  WHERE `id` = ".$data['id'];
	}else if($data["type"] == "inventory"){
		$sql = "UPDATE `pallet` SET `amount` = '".$data['amount']."'  WHERE `id` = ".$data['id'];
	}
	
	
	if(isset($_SESSION['user_id'])){
		if($data["type"] == "theme"){		
			$sql = "UPDATE `user` SET `theme` = '".$data['theme']."'  WHERE `id` = ".$_SESSION['user_id'];
			$_SESSION['theme'] = $data['theme'];
		}
	}
	
	
	return update($sql); 
}
 
?>