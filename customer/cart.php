<?php
session_start();

//載入資料庫配置
require_once("../config.php");

//數量驗證,儲存首頁輸入的數量
$uid = $_SESSION["uid"];


//顯示購物車清單
$sql = <<<multi
select u.uid,prodname,cash,count,did,cash*count as total

from user u join cart d on d.uid =u.uid
                 join prod p on p.pid =d.pid
where u.uid=$uid
ORDER BY did ASC
multi;
$result = mysqli_query($link, $sql);



//刪除購物車訂單
if (isset($_POST["btnDel"])) {
  $did = $_POST["btnSend"];

  // 找出產品id
  $sql = <<<multi
      select pid,count
      from cart
      where did = '$did';
      multi;
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $pid = $row["pid"];
  $cartcount = $row["count"];



  //修改產品表暫存數量欄位
  $sql =
    "update prod set tempcount = tempcount + $cartcount where pid = '$pid' ";
  $result = mysqli_query($link, $sql);

  //刪除購物車商品
  $sql = <<<multi
  delete from cart where did = $did
  multi;
  mysqli_query($link, $sql);
  //echo "<script> alert('刪除成功');location.replace('./cart.php');</script>";
}



// 建立訂單
if (isset($_POST["btnDetail"])) {

  //儲存訂單id
  $did = $_POST["btnSend"];
  $sql = "select did from `detail` ORDER BY `detail`.`did` DESC";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);

  //新訂單id等於舊訂單+1
  $newdid = $row['did'] + 1;
  echo $newdid;
  $sql = <<<multi
  select u.uid,d.pid,prodname,cash,count,did,cash*count as total
  
  from user u join cart d on d.uid =u.uid
                   join prod p on p.pid =d.pid
  where u.uid=$uid
  multi;
  $result = mysqli_query($link, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $uid = $row["uid"];
    $prodname = $row["prodname"];
    $prodcount = $row["count"];
    $cash = $row["cash"];
    $total = $row["total"];

    //建立訂單
    $sql = <<<multi
      insert into detail
      (did,uid,prodname,prodcount,cash,total,date) 
      values('$did','$uid','$prodname','$prodcount','$cash','$total',current_timestamp()) 
      multi;
    mysqli_query($link, $sql);
  }




  //刪除真實數量
  $sql =
    "update prod set prodcount = tempcount ";
  mysqli_query($link, $sql);


  //刪除購物車商品
  $sql = <<<multi
  delete from cart where did = '$did';
  multi;
  mysqli_query($link, $sql);





  echo "<script> alert('訂單已完成，感謝您的購買');location.replace('./customer_detail.php');</script>";


}

//身份驗證
if (isset($_SESSION["userName"])) {
  $sUserName = $_SESSION["userName"];
} else {
  $sUserName = "Guest";
}
if (isset($_POST["member"])) {
  header("Location: ../index.php");
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
        <a href="../login.php" class="btn btn-outline-success btn-md">登入</a>
      <?php else : ?>
        <a href="../login.php?logout=1" class="btn btn-outline-warning btn-md">登出</a>
      <?php endif; ?>
      <a href="./edit.php?uid=<?= $uid ?>" class="btn btn-outline-primary btn-md">修改會員資料</a>
    </span>

    <tr>
      <td align="center" bgcolor="#CCCCCC"><?php echo "Hello~ " . $sUserName ?> </td>
    </tr>

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
            <td><?= $row["count"] ?></td>
            <form method="post">
              <td>
                <input type="submit" class="btn btn-outline-danger btn-md" name="btnDel" id="btnDel" value="刪除" />
                <input type="hidden" name="btnSend" id="btnSend" value="<?= $row["did"] ?>" />
              </td>
              <td><?= $row["total"] ?></td>
          </tr>

          <?php
          $rowt = (int)$row["total"];
          $total += $rowt;
          $tt = $total;
          ?>
        </tbody>
      <?php } ?>
      <?php
      $tt = $total;
      ?>
    </table>

    <td>Total:<?= $total ?></td>
    <a href="../index.php" class="btn btn-outline-success btn-md">回首頁</a>
    <input type="submit" class="btn btn-outline-primary btn-md" name="btnDetail" id="btnDetail" value="送出訂單" />
    </form>

</body>

</html>