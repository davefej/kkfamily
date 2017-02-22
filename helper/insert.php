<?php
require('mysqli.php');


$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody,True);
$sql = "";
if(array_key_exists("type",$data)){
	
	
	if($data["type"] == "category"){				
		$sql = "INSERT INTO `category` (`id`, `name`, `deleted`) VALUES (NULL, '".$data['name']."', '0')";
	}else if($data["type"] == "user"){
		$sql = "INSERT INTO `user` (`id`, `name`, `password`, `type`, `deleted`) VALUES (NULL, '".$data['name']."', '".$data['password']."', '".$data['user_type']."' , '0')";				
	}else if($data["type"] == "supplier"){
		$sql = "INSERT INTO `supplier` (`id`, `name`, `address`, `deleted`) VALUES (NULL, '".$data['name']."', '".$data['address']."', '0')";
	}else if($data["type"] == "product"){
		$sql = "INSERT INTO `product` (`id`, `name`, `category_id`, `type`, `minimum` , `expire` , `deleted`) VALUES (NULL, '".$data['name']."', '".$data['category_id']."', '".$data['product_type']."', '".$data['min']."', '".$data['expire']."', '0')";
	}else if($data["type"] == "quality_form"){
		$sql = "INSERT INTO `quantity_form` (`id`, `sum_difference`, `appearance`, `consistency`, `smell`, `color`, `clearness`, `pallet_quality`, `decision`) VALUES (NULL, '".$data['sum_difference']."', '".$data['appearance']."', '".$data['consistency']."', '".$data['smell']."', '".$data['color']."', '".$data['clearness']."', '".$data['pallet_quality']."', '".$data['decision']."')";
	}
	
	if($sql === ""){
		if(isset($_SESSION['user_id'])){
			if($data["type"] == "trash"){
				$sql = "INSERT INTO `trash` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES (NULL, '".$data['pallet_id']."', '".$data['amount']."', CURRENT_TIMESTAMP, '".$_SESSION['user_id']."', '0')";
			}else if($data["type"] == "pallet"){
				$sql = "INSERT INTO `pallet` (`id`, `product_id`, `supplier_id`, `time`, `amount`, `printed`, `user_id`, `deleted`) VALUES (NULL, '".$data['product_id']."', '".$data['supplier_id']."', CURRENT_TIMESTAMP, '".$data['amount']."', '0', '".$_SESSION['user_id']."', '0')";
			}else if($data["type"] == "output"){
				$sql = "INSERT INTO `output` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES (NULL, '".$data['pallet_id']."', '".$data['amount']."', CURRENT_TIMESTAMP, '".$_SESSION['user_id']."', '0')";
			}else if($data["type"] == "alert"){
				$sql = "INSERT INTO `alert` (`id`, `type`, `param`, `param2`, `time`, `user_id`, `seen`, `deleted`) VALUES (NULL, '".$data['alert_type']."', '".$data['param']."', '".$data['param2']."', CURRENT_TIMESTAMP, '".$_SESSION['user_id']."', '0', '0')";
			}else if($data["type"] == "alert"){
				$sql = "INSERT INTO `alert` (`id`, `type`, `param`, `param2`, `time`, `user_id`, `seen`, `deleted`) VALUES (NULL, '".$data['alert_type']."', '".$data['param']."', '".$data['param2']."', CURRENT_TIMESTAMP, '".$_SESSION['user_id']."', '0', '0')";

			}
		}else{
			break;
		}
	}

	return insert($sql);
}
 
?>