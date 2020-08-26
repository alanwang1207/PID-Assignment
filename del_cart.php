<?php

if (!isset($_GET["did"])) {
  die("id not found");
}
$did = $_GET["did"];
if (!is_numeric($did))
  die("did not a number.");
$sql = <<<multi
  delete from detail where did = $did
multi;
require("./config.php");
mysqli_query($link, $sql);
echo "<script> alert('刪除成功，將跳回購物車');location.replace('./cart.php');</script>";    
// header("location: login.php");
