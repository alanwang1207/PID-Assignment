<?php

//檢查是否有id
if (!isset($_GET["pid"])) {
  die("id not found");
}
$pid = $_GET["pid"];

//檢查id是否為數字或數字的字串
if (!is_numeric($pid))
  die("pid not a number.");

//刪除產品
$sql = <<<multi
  delete from prod where pid = $pid
multi;
require("../config.php");
mysqli_query($link, $sql);
echo "<script> alert('刪除成功，將跳回商品管理頁');location.replace('./product.php');</script>";    

