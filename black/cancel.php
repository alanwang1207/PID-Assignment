<?php

if (!isset($_GET["uid"])) {
  die("uid not found");
}
$uid = $_GET["uid"];
if (!is_numeric($uid))
  die("uid not a number.");
  $sql = <<<multi
  update user set
  dis = '0'
  where uid = $uid
multi;
require("../config.php");
mysqli_query($link, $sql);
echo "<script> alert('修改完成，將跳回會員列表');location.replace('../member.php');</script>";  
// header("location: login.php");
