<?php
session_start();
require_once("config.php");

$uid = $_SESSION["uid"];
//數量驗證,儲存首頁輸入的數量
// $indexcount = $_SESSION["count"];
// var_dump($indexcount);

//顯示購物車清單
$sql = <<<multi
select u.uid,prodname,cash,count,did,cash*count as total

from user u join detail d on d.uid =u.uid
                 join prod p on p.pid =d.pid
where u.uid=$uid
ORDER BY did ASC
multi;
$result = mysqli_query($link, $sql);



//修改數量
// if (isset($_POST["btnEdit"])) {
//   $did = $_POST["btnSend"];
//   //  var_dump($did);
//   //更改量
//   $count = $_POST["count"];
//   var_dump($count);



//   $sql = <<<multi
//   select tempcount,p.pid
//   from user u join detail d on d.uid =u.uid
//                    join prod p on p.pid =d.pid
//   where u.uid=$uid
//   ORDER BY did ASC
//   multi;
//   $result = mysqli_query($link, $sql);
//   $row = mysqli_fetch_assoc($result);
//   //暫存量
//   $tempcount = $row["tempcount"];
//   $pid = $row["pid"];
//   var_dump($tempcount);
//   var_dump($pid);



//   //庫存夠
//   if ($count < $tempcount) {
//     //修改量變大
//     if ($indexcount < $count) {
//       (int)$diffcount = $count - $indexcount;
//       // echo $diffcount;

//       //找出產品id
//       $sql = <<<multi
//       select p.pid
//       from user u join detail d on d.uid =u.uid
//                        join prod p on p.pid =d.pid
//       where u.uid=$uid
//       ORDER BY did ASC
//       multi;
//       $result = mysqli_query($link, $sql);
//       $row = mysqli_fetch_assoc($result);
//       $pid = $row["pid"];
//       // var_dump($pid);


//       //修改產品表暫存數量欄位
//       $sql =
//         "update prod set tempcount = tempcount - $diffcount where pid = '$pid' ";
//         $result = mysqli_query($link, $sql);
//        echo "<script> alert('修改成功');location.replace('./cart.php');</script>";  

//     } else {
//       //修改量變小
//       (int)$diffcount = $indexcount - $count;

//       $sql = <<<multi
//       select p.pid
//       from user u join detail d on d.uid =u.uid
//                        join prod p on p.pid =d.pid
//       where u.uid=$uid
//       ORDER BY did ASC
//       multi;
//       $result = mysqli_query($link, $sql);
//       $row = mysqli_fetch_assoc($result);
//       $pid = $row["pid"];
//       // var_dump($pid);

//       //修改產品表暫存數量欄位
//       $sql =
//         "update prod set tempcount =tempcount + $diffcount where pid = '$pid' ";
//        echo "<script> alert('修改成功');location.replace('./cart.php');</script>";  

//       $result = mysqli_query($link, $sql);
//       // mysqli_fetch_assoc($result);
//     }
//     $sql =
//       "update detail set count = '$count' where did = '$did' ";
//     mysqli_query($link, $sql);
//     // mysqli_fetch_assoc($result);
//     echo "<script> alert('修改成功');location.replace('./cart.php');</script>";  
//   }else{
//     echo "<script> alert('庫存不足');location.replace('./cart.php');</script>"; 
//   }
// }

//刪除購物車訂單
if (isset($_POST["btnDel"])) {
  $did = $_POST["btnSend"];
  var_dump($did);
// var_dump($uid);
  // 找出產品id
  $sql = <<<multi
      select pid,count
      from detail
      where did = '$did';
      multi;
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $pid = $row["pid"];
  $cartcount = $row["count"];
  // var_dump($pid);
  // var_dump($cartcount);


  //修改產品表暫存數量欄位
  $sql =
    "update prod set tempcount = tempcount + $cartcount where pid = '$pid' ";
  $result = mysqli_query($link, $sql);

  $sql = <<<multi
  delete from detail where did = $did
  multi;
  require("./config.php");
  mysqli_query($link, $sql);
   echo "<script> alert('刪除成功');location.replace('./cart.php');</script>";
}



// 建立訂單
if (isset($_POST["btnDetail"])) {
  // 
  $did = $_POST["btnSend"];
  $sql = <<<multi
  select u.uid,d.pid,prodname,cash,count,did,cash*count as total
  
  from user u join detail d on d.uid =u.uid
                   join prod p on p.pid =d.pid
  where u.uid=$uid
  order by did asc
  multi;
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $did = $row["did"];
  $uid = $row["uid"];
  $pid = $row["pid"];
  $prodname = $row["prodname"];
  $prodcount = $row["count"];
  $total = $row["total"];
//di ok uid ok pid ok 
  var_dump($did);
  var_dump($uid);
  var_dump($pid);
  var_dump($prodname);
  var_dump($prodcount);
  var_dump($total);

  $sql =<<<multi
    insert into detail2  
    (did,uid,pid,prodname,prodcount,total,date) 
    values('$did','$uid','$pid','$prodname','$prodcount','$total',current_timestamp()) 
    multi;
  mysqli_query($link, $sql);


    //刪除真實數量
  $sql =
    "update prod set prodcount = tempcount  where pid = '$pid' ";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);



  $sql = <<<multi
  delete from detail where did = $did
  multi;
  mysqli_query($link, $sql);


  //使用者數量變更 要修改暫存量

  
  // echo "<script> alert('訂單已完成，感謝您的購買');location.replace('./customer_detail.php');</script>";
  //修改產品表數量欄位

}

//身份驗證
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
            <td><?= $row["count"] ?></td>
            <form method="post">
              <!-- <td>
                <div class="form-group row">
                  <div class="col-3">
                    <input id="count" name="count" type="text" class="form-control" value="<?= $row["count"]; ?>">
                  </div>
                </div>
              </td> -->
              <td>
                <!-- <input type="submit" class="btn btn-outline-secondary btn-md" name="btnEdit" id="btnEdit" value="修改" /> -->
                <input type="submit" class="btn btn-outline-danger btn-md" name="btnDel" id="btnDel" value="刪除" />
                <!-- <a href="./del_cart.php?did=<?= $row["did"] ?>" class="btn btn-outline-">刪除</a> -->
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
    <a href="index.php" class="btn btn-outline-success btn-md">回首頁</a>
    <input type="submit" class="btn btn-outline-primary btn-md" name="btnDetail" id="btnDetail" value="送出訂單" />
    </form>

</body>

</html>