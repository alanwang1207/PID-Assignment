<?php
session_start();

//載入資料庫配置
require_once("config.php");

$uid = $_SESSION["uid"];

//添加時驗證是否為會員
if (isset($_POST["btnAdd"]) && $uid == 0) {
  echo "<script> alert('請先加入會員');location.replace('login.php');</script>";
} else {
  //驗證數量是否正確
  if (isset($_POST["btnAdd"]) && $_POST["count"] >0 ) {

    $pid = $_POST["btnsend"];

    //添加的商品
    $sql = <<<multi
    select pid from cart where pid = '$pid' and uid = '$uid';
    multi;
    $result1 = mysqli_query($link, $sql);
    $countnum = mysqli_num_rows($result1);

    //暫存數
    $sql = <<<multi
    select tempcount from prod where pid = '$pid';
    multi;

    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $count = $row["tempcount"];


    //檢查數量是否足夠
    if ($count >= $_POST["count"]) {
      if ($countnum == 0) {
        $count = $_POST["count"];
        $_SESSION["count"] = $count;
        $sql = <<<multi
      INSERT INTO cart (pid,count,uid) VALUES
      ('$pid', '$count','$uid')
      multi;
        $result = mysqli_query($link, $sql);

        //判斷數量
        $sql = <<<multi
      update prod set tempcount = tempcount - '$count' where pid = '$pid';
      multi;
        $result = mysqli_query($link, $sql);
        echo "<script> alert('加入成功');location.replace('index.php');</script>";
        exit();
      } else {
        $count = $_POST["count"];
        $_SESSION["count"] = $count;
        $sql = <<<multi
        update cart set count = count + '$count' where pid = '$pid'
      multi;
        $result = mysqli_query($link, $sql);

        //判斷數量
        $sql = <<<multi
      update prod set tempcount = tempcount - '$count' where pid = '$pid';
      multi;
        $result = mysqli_query($link, $sql);
        echo "<script> alert('加入成功');location.replace('index.php');</script>";
        exit();
      }
    } else {
      echo "<script> alert('數量不足，請重新輸入');location.replace('index.php');</script>";
    }
  } else {

    $sql = <<<multi
  select * from prod
  multi;
    $result = mysqli_query($link, $sql);
  }
}







//登入驗證
if (isset($_SESSION["userName"])) {
  $sUserName = $_SESSION["userName"];
} else {
  $sUserName = "Guest";
}
if (isset($_POST["member"])) {
  header("Location: ./index.php");
  exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>PID - 購物網</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

  <div class="container">
    <h2>購物網 - 首頁</h2>
    <span>
      <?php if ($sUserName == "Guest") : ?>
        <a href="login.php" class="btn btn-outline-success btn-md">登入</a>
      <?php else : ?>
        <a href="login.php?logout=1" class="btn btn-outline-secondary btn-md">登出</a>
      <?php endif; ?>

      <?php if ($sUserName == "Guest") : ?>
        <a href="#" style="text-decoration:none;"></a>
      <?php else : ?>
        <a href="./customer/edit.php?uid=<?= $uid ?>" class="btn btn-outline-primary btn-md">修改會員資料</a>
        <a href="./customer/customer_detail.php" class="btn btn-outline-success btn-md">查看訂單</a>
      <?php endif; ?>
    </span>

    <tr>
      <td align="center" bgcolor="#CCCCCC"><?php echo "Hello~ " . $sUserName ?> </td>
    </tr>
    <!-- <img src="hello.jpg" class="rounded-circle img-thumbnail mx-auto d-block" alt="Cinque Terre" style="width:50%"> -->

    <table class="table table-striped">
      <thead>
        <tr>
          <th>商品名</th>
          <th>數量</th>
          <th>金額</th>
          <th>購買量</th>
          <th></th>
        </tr>
      </thead>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tbody>
          <tr>
            <td><?= $row["prodname"] ?></td>
            <td><?= $row["tempcount"] ?></td>
            <td><?= $row["cash"] ?></td>
            <form method="post">
              <td>
                <div class="form-group row">
                  <div class="col-3">
                    <input id="count" name="count" type="number" class="form-control" value="<?= $row["count"]; ?>">
                  </div>
                </div>
              </td>
              <td><input type="submit" class="btn btn-outline-primary btn-md" name="btnAdd" id="btnAdd" value="添加" /></td>
              <td><?= $row["total"] ?></td>
          </tr>
          <input type="hidden" name="btnsend" id="btnsend" value="<?= $row["pid"] ?>" />
          </form>
        </tbody>
      <?php } ?>
    </table>
    <?php if ($sUserName == "Guest") : ?>
        <a href="#" style="text-decoration:none;"></a>
      <?php else : ?>
        <a href="./customer/cart.php" class="btn btn-outline-success btn-md">前往購物車</a>
      <?php endif; ?>

    <input type="reset" class="btn btn-outline-secondary btn-md" name="btnReset" id="btnReset" value="重設" />

</body>

</html>