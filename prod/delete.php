<?php

if (!isset($_GET["pid"])) {
  die("id not found");
}
$pid = $_GET["pid"];
if (!is_numeric($pid))
  die("pid not a number.");
$sql = <<<multi
  delete from prod where pid = $pid
multi;
require("../config.php");
mysqli_query($link, $sql);
echo "<script> alert('刪除成功，將跳回商品管理頁');location.replace('./product.php');</script>";    
// header("location: login.php");
