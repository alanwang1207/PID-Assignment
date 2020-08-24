<?php

if (!isset($_GET["cid"])) {
  die("id not found");
}
$bid = $_GET["cid"];
if (!is_numeric($bid))
  die("cid not a number.");
  $sql = <<<multi
  update black_list set
  dis = '0'
  where bid = $bid
multi;
require("../config.php");
mysqli_query($link, $sql);
echo "<script> alert('修改完成，將跳回會員列表');location.replace('./member.php');</script>";  
// header("location: login.php");
