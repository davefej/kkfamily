<?php
$selected ="admin";
$selector ="product";
require("../common/header.php");


	listProduct();

?>

<div id="category_container" class="hiddendiv" >
<?php categoryOption();?>
</div>

<?php 
require("../common/footer.php");
?>