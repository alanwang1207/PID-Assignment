<?php
session_start();
$_SESSION['count'] =0;
//按下登出
if (isset($_GET["logout"])) {
  session_destroy();
  header("Location: index.php");
  exit();
}
//按下回首頁
if (isset($_POST["btnHome"])) {
  header("Location: index.php");
  exit();
}
//按下登入
if (isset($_POST["btnOK"])) {
  $sUserName = $_POST["txtUserName"];
  $passWord = $_POST['txtPassword'];
  if (trim($sUserName) != "") {
    echo "Hi {$sUserName} :";

    require_once("config.php");

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);
    mysqli_query($link, "set names utf-8");
    $sql = "select * from `user` WHERE `username` = '$sUserName' and `password` = '$passWord'";

    $result = mysqli_query($link, $sql);
    //驗證是否有這筆資料
    $row_count = mysqli_num_rows($result);
    //存相關資料到session
    $row = mysqli_fetch_assoc($result);
    $_SESSION['uid'] =  $row["uid"];
    $_SESSION["userName"] = $row["username"];
    $_SESSION["dis"] = $row["dis"];

    if ($row_count != 0) {
      if ($_SESSION["dis"] != 1) {
        echo "welcome!{$sUserName}";
        if ($_SESSION["uid"] == 1) {
          header("Location: admin.php");
        } else {
          header("Location: index.php");
        }
        exit();
      } else {
        echo "您已被加入黑名單";
      }
    } else {
      echo "輸入資料有誤";
      //header("Location: index.php");
      exit();
    }
  } else {
    //echo "請輸入帳號";
    echo '<script language="javascript">';
    echo 'alert("請輸入帳號")';
    echo '</script>';
  }
}
?>


<html>

<head>
  <title>Lab - Login</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <form id="form1" name="form1" method="post" action="login.php">
    <table width="300" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
      <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC">
          <font color="#FFFFFF">會員系統 - 登入</font>
        </td>
      </tr>
      <tr>
        <td width="80" align="center" valign="baseline">帳號</td>
        <td valign="baseline"><input type="text" name="txtUserName" id="txtUserName" /></td>
      </tr>
      <tr>
        <td width="80" align="center" valign="baseline">密碼</td>
        <td valign="baseline"><input type="password" name="txtPassword" id="txtPassword" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC">
          <input type="submit" class="btn btn-outline-success btn-md" name="btnOK" id="btnOK" value="登入" />
          <input type="reset" class="btn btn-outline-secondary btn-md" name="btnReset" id="btnReset" value="重設" />
          <a href="./customer/add.php" class="btn btn-outline-info btn-md float-right">加入會員</a>
          <input class="btn btn-outline-primary btn-md" type="submit" name="btnHome" id="btnHome" value="回首頁" />
        </td>
      </tr>
    </table>
  </form>
</body>

</html>