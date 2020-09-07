<?php

//檢查是否有id
if (!isset($_GET["uid"])) {
  die("uid not found");
}
$uid = $_GET["uid"];

//檢查id是否為數字或數字的字串
if (!is_numeric($uid))
  die("uid not a number.");

//引入資料庫配置
require("../config.php");

  //將dis欄位設為１
  $sql = <<<multi
  update user set
  dis = '1'
  where uid = $uid
multi;
mysqli_query($link, $sql);

echo "<script> alert('修改完成，將跳回會員列表');location.replace('../member/member_list.php');</script>";  

