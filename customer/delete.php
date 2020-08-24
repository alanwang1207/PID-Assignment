<?php

if (!isset($_GET["cid"])) {
  die("cid not found");
}
$id = $_GET["cid"];
if (!is_numeric($cid))
  die("cid not a number.");
$sql = <<<multi
  delete from user where cid = $cid
multi;
require("config.php");
mysqli_query($link, $sql);
echo "<script> alert('刪除成功，將跳回登入頁');location.replace('login.php');</script>";
// header("location: login.php");
