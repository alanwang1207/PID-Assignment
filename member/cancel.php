<?php

if (!isset($_GET["id"])) {
  die("id not found");
}
$id = $_GET["id"];
if (!is_numeric($id))
  die("id not a number.");
  $sql = <<<multi
  update user set
  dis = '0'
  where id = $id
multi;
require("../config.php");
mysqli_query($link, $sql);
echo "<script> alert('修改完成，將跳回會員列表');location.replace('./member.php');</script>";  
// header("location: login.php");
