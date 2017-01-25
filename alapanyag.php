<?php
$selected = "admin";
$selector = "alapanyag";
require("header.php");

require('helper/mysqli.php');
listallalapanyag();

echo "<br/>...";
require("footer.php");
?>
