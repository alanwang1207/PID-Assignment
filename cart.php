<?php
session_start();
require_once("config.php");
// $sUserName = "";
$uid = $_SESSION["uid"];
var_dump($_SESSION["uid"]);
//修改數量
if (isset($_POST["btnEdit"])) {
  $did = $_POST["btnSend"];
  var_dump($did);

  $count = $_POST["count"];
  $sql =
    "update detail set count = '$count' where did = '$did' ";
    // echo "<script> alert('修改成功');location.replace('./cart.php');</script>";  
}
$result = mysqli_query($link, $sql);
$sql = <<<multi
select u.uid,prodname,cash,count,did,cash*count as total

from user u join detail d on d.uid =u.uid
                 join prod p on p.pid =d.pid
where u.uid=$uid
ORDER BY did ASC
multi;
$result = mysqli_query($link, $sql);

if(isset($_POST["btnDetail"])){
  var_dump($uid);
  $sql =
    "insert into detail2  (did,uid,pid,total,date) values('$did','$uid','$pid','$total',current_timestmp()) ";
    $result = mysqli_query($link, $sql);

}
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
    <h2>購物網 - 購物車</h2>
    <span>
      <?php if ($sUserName == "Guest") : ?>
        <a href="login.php" class="btn btn-outline-success btn-md">登入</a>
      <?php else : ?>
        <a href="login.php?logout=1" class="btn btn-outline-warning btn-md">登出</a>
      <?php endif; ?>
      <a href="edit.php?uid=<?= $uid ?>" class="btn btn-outline-primary btn-md">修改會員資料</a>
    </span>

    <tr>
      <td align="center" bgcolor="#CCCCCC"><?php echo "Hello~ " . $sUserName ?> </td>
    </tr>
    <!-- <img src="hello.jpg" class="rounded-circle img-thumbnail mx-auto d-block" alt="Cinque Terre" style="width:50%"> -->

    <table class="table table-striped">
      <thead>
        <tr>
          <th>商品名</th>
          <th>金額</th>
          <th>購買量</th>
          <th>動作</th>
          <th>單項總價</th>
        </tr>
      </thead>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tbody>
          <tr>
            <td><?= $row["prodname"] ?></td>
            <td><?= $row["cash"] ?></td>
            <form method="post">
              <td>
                <div class="form-group row">
                  <div class="col-3">
                    <input id="count" name="count" type="text" class="form-control" value="<?= $row["count"]; ?>">
                  </div>
                </div>
              </td>
              <td>
                <input type="submit" class="btn btn-outline-secondary btn-md" name="btnEdit" id="btnEdit" value="修改" />
                <a href="./del_cart.php?did=<?= $row["did"] ?>" class="btn btn-outline-danger">刪除</a>
                <input type="hidden"  name="btnSend" id="btnSend" value="<?= $row["did"] ?>" />
              </td>
              <td><?= $row["total"] ?></td>
          </tr>
          </form>
          <?php
          $rowt = (int)$row["total"];
          $total += $rowt;
          ?>
        </tbody>
      <?php } ?>
    </table>

    <td>Total:<?= $total ?></td>
    <a href="index.php" class="btn btn-outline-success btn-md">回首頁</a>
    <input type="submit" class="btn btn-outline-primary btn-md" name="btnDetail" id="btnDetail" value="送出訂單" />
    

</body>

</html>