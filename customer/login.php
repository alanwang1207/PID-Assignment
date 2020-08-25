<?php
session_start();
if (isset($_GET["logout"])) {
  session_destroy();
  header("Location: index.php");
  exit();
}

if (isset($_POST["btnHome"])) {
  header("Location: index.php");
  exit();
}

if (isset($_POST["btnOK"])) {
  $sUserName = $_POST["txtUserName"];
  $passWord = $_POST['txtPassword'];
  $cid = "";
  if (trim($sUserName) != "") {
    // echo "Hi {$sUserName} :";

    require_once("config.php");

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);
    mysqli_query($link, "set names utf-8");
    $sql = "select `username`,`password` from `customer` WHERE `username` = '$sUserName' and `password` = '$passWord'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $cid = $row["cid"];
    $row_count = mysqli_num_rows($result);
    //var_dump($row_count);

    $_SESSION["userName"] = $sUserName;
    $_SESSION["cid"] = $cid;
    var_dump($cid);
    if ($row_count != 0) {
      echo "welcome!{$sUserName}";
      header("Location: index.php");
      exit();
    } else {
      echo "<script> alert('輸入資料有誤，請再試一次');location.replace('login.php');</script>";
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
  <title>PID - 購物網</title>
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
          <font color="#FFFFFF">購物網 - 登入</font>
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
          <a href="./add.php" class="btn btn-outline-info btn-md float-right">加入會員</a>
          <input class="btn btn-outline-primary btn-md" type="submit" name="btnHome" id="btnHome" value="回首頁" />
        </td>
      </tr>
    </table>
  </form>
</body>

</html>