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
		$sql = "INSERT INTO `supplier` (`id`,`supp_code`, `name`, `address`, `deleted`) VALUES (NULL,'".$data['code']."', '".$data['name']."', '".$data['address']."', '0')";
	}else if($data["type"] == "product"){
		$sql = "INSERT INTO `product` (`id`, `name`, `category_id`, `type`, `minimum` , `expire` , `unit`, `deleted`) VALUES (NULL, '".$data['name']."', '".$data['category_id']."', '".$data['product_type']."', '".$data['min']."', '".$data['expire']."', '".$data['unit']."', '0')";
	}else if($data["type"] == "quality_form"){
		$sql = "INSERT INTO `quantity_form` (`id`, `sum_difference`, `appearance`, `consistency`, `smell`, `color`, `clearness`, `pallet_quality`, `decision`) VALUES (NULL, '".$data['sum_difference']."', '".$data['appearance']."', '".$data['consistency']."', '".$data['smell']."', '".$data['color']."', '".$data['clearness']."', '".$data['pallet_quality']."', '".$data['decision']."')";
	}
	
	if(!isset($data["date"]) || $data["date"] == "NULL" || $data["date"] == ""){
		$data["date"] = "CURRENT_TIMESTAMP";
	}else{
		$data["date"] =  "'".$data["date"]." 00:00:01'";
	}
	if(!isset($data["expire"]) || $data["expire"] == "NULL" || $data["expire"] == ""){
		$data["expire"] = "NULL";
	}else{
		$data["expire"] .= " 23:59:59";
	}
	
	if($sql === ""){
		if(isset($_SESSION['user_id'])){
			if($data["type"] == "trash"){
				$sql = "INSERT INTO `trash` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES (NULL, '".$data['pallet_id']."', '".$data['amount']."', CURRENT_TIMESTAMP, '".$_SESSION['user_id']."', '0')";
			}else if($data["type"] == "pallet"){
				$sql = "INSERT INTO `pallet` (`id`, `quantity_form_id`, `product_id`, `supplier_id`, `time`, `expire`, `amount`, `printed`, `user_id`, `deleted`) VALUES (NULL, '".$data['quality_form']."', '".$data['product_id']."', '".$data['supplier_id']."', ".$data["date"].", '".$data['expire']."', '".$data['amount']."', '0', '".$_SESSION['user_id']."', '0')";
			}else if($data["type"] == "palletdel"){
				$sql = "INSERT INTO `pallet` (`id`, `quantity_form_id`, `product_id`, `supplier_id`, `time`, `expire`, `amount`, `printed`, `user_id`, `deleted`) VALUES (NULL, '".$data['quality_form']."', '".$data['product_id']."', '".$data['supplier_id']."', ".$data["date"].", '".$data['expire']."', '0', '".$_SESSION['user_id']."', '1')";
			}else if($data["type"] == "output"){
				$sql = "INSERT INTO `output` (`id`, `pallet_id`, `amount`, `time`, `user_id`, `deleted`) VALUES (NULL, '".$data['pallet_id']."', '".$data['amount']."', ".$data["date"]." , '".$_SESSION['user_id']."', '0')";
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