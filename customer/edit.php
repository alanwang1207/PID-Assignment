<?php
session_start();

//載入資料庫配置
require_once("../config.php");
$uid = $_SESSION["uid"];

//按下取消回首頁
if (isset($_POST["cancelButton"])) {
    header("location: ../index.php");
    exit();
}
if (!isset($_GET["uid"])) {
    die("uid not found.");
}
$uid = $_GET["uid"];
if (!is_numeric($uid))
    die("uid not a number.");

//按下送出
if (isset($_POST["okButton"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    //驗證帳號唯一
    $sql = <<<sqlstate
    select username from user where username = '$username';
  sqlstate;
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);


    //驗證是否改帳號
    $sql = <<<sqlstate
    select username from user where uid = $uid;
  sqlstate;
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $ousername = $row["username"];
    if ($username == $ousername) {
        $sql = <<<multi
        update user set
           password='$password'
        where uid = '$uid';
      multi;
        mysqli_query($link, $sql);
        echo "<script> alert('修改完成，請重新登入');location.replace('../login.php');</script>";
        exit();
    } else {
        //驗證帳號名稱是否使用
        $sql = <<<sqlstate
            select username from user where username = '$username';
            sqlstate;
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo "<script> alert('帳號名稱已被使用，請重新輸入');location.replace('../index.php');</script>";
        } else {
            $sql = <<<multi
            update user set
               username = '$username',
               password='$password'
            where uid = $uid
          multi;
            $result = mysqli_query($link, $sql);
            echo "<script> alert('修改完成，請重新登入');location.replace('../login.php');</script>";
            exit();
        }
    }
} else {
    $sql = <<<multi
    select * from user where uid = $uid
  multi;
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>修改會員資料</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">

        <form method="post">
            <div class="form-group row">
                <label for="username" class="col-4 col-form-label">帳號:</label>
                <div class="col-8">
                    <input id="username" name="username" value="<?= $row["username"] ?>" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-4 col-form-label">密碼:</label>
                <div class="col-8">
                    <input id="password" name="password" value="<?= $row["password"] ?>" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button name="okButton" value="OK" type="submit" class="btn btn-primary">確認修改</button>
                    <button name="cancelButton" value="Cancel" type="submit" class="btn btn-secondary">取消修改</button>
                </div>
            </div>
        </form>

    </div>

</body>

</html>