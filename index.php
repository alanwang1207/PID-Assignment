<?php
session_start();

//載入資料庫配置
require_once("config.php");

$uid = $_SESSION["uid"];
$_SESSION['num'] = 5;
//添加時驗證是否為會員
if (isset($_POST["btnAdd"]) && $uid == 0) {
  echo "<script> alert('請先加入會員');location.replace('login.php');</script>";
} else {
  //驗證數量是否正確 count為輸入的數量
  if (isset($_POST["btnAdd"]) && $_POST["count"] > 0) {

    //抓取添加數量的商品id
    $pid = $_POST["btnsend"];


    //目前購物車添加的商品
    $sql = <<<multi
    select pid from cart where pid = '$pid' and uid = '$uid';
    multi;
    $result = mysqli_query($link, $sql);
    //判斷是否有至少一筆資料
    $countnum = mysqli_num_rows($result);

    //暫存數
    $sql = <<<multi
    select tempcount from prod where pid = '$pid';
    multi;

    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    //將暫存數存到count
    $count = $row["tempcount"];


    //檢查數量是否足夠
    if ($count >= $_POST["count"]) {
      //檢查是否購物車有這項產品 沒有的話就先insert到cart 再update修改暫存數
      if ($countnum == 0) {
        $count = $_POST["count"];

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

//搜尋商品
if (isset($_POST["btnSearchp"])) {
  $keyword = $_POST["keyword"];
  $sql = <<<multi
  select * from prod
  where prodname like '%$keyword%'
  multi;
  $result = mysqli_query($link, $sql);
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
  <link rel="stylesheet" href="css/style.css">
</head>
<!-- 顯示提示字特效 -->
<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<body>

  <div class="container ">
    <div class="p-3 mb-2 bg-info text-white">

      <a href="index.php">
        <h2>購物網 - 首頁</h2>
      </a>
      <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          會員中心
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <?php if ($sUserName == "Guest") : ?>
            <a href="login.php" class="btn btn-success btn-md">登入</a>
          <?php else : ?>
            <a href="login.php?logout=1" class="btn btn-secondary btn-md">登出</a>
          <?php endif; ?>
          <?php if ($sUserName == "Guest") : ?>
            <a href="#" style="text-decoration:none;"></a>
          <?php else : ?>
            <a href="./customer/edit.php?uid=<?= $uid ?>" class="btn btn-primary btn-md">修改會員資料</a>
            <a href="./customer/customer_details.php" class="btn btn-success btn-md">查看訂單</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <tr>
      <h1><?php echo "Hello~ " . $sUserName ?> </h1>
    </tr>
   



    <!-- 輪播圖 -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/1.jpg" class="d-block w-100" height="500" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h1 style="color:black;">beauty fruit</h1>
            <h1 style="font-size: 35px; color:black">蘋果 鳳梨 美味的水果</h1>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/2.jpg" class="d-block w-100" height="500" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h1 style="color:black;">蘋果特寫</h1>
            <h1 style="font-size: 35px; color:black">青蘋果與紅蘋果</h1>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/3.jpg" class="d-block w-100" height="500" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h1 style="color:black;">水果拼盤</h1>
            <h1 style="font-size: 35px; color:black">宛如披薩般的饗宴</h1>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <form method="post">
      <div class="input-group mb-3 mt-3" style="width: 300px;">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default">請輸入商品名</span>
        </div>
        <input type="keyword" class="form-control " pattern="^[\u4e00-\u9fa5a-zA-Z]+$" name="keyword" id="keyword">
        <input name="btnSearchp" id="btnSearchp" type="submit" class="btn btn-primary btn-sm">
      </div>
      <div class="card-deck text-center hover">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="col-3">
            <div class="card mb-3 shadow p-3">
              <img src="prod/upload/<?= $row["prodname"] ?>.png" width="90%" height="150" data-toggle="tooltip" title="<?= $row["prodname"] ?>">
              <div class="card-body" style="text-align:left;"  >
                <p style="color: brown;" ><?php
                                          if ($row["tempcount"] == 0) {
                                            echo "補貨中";
                                          } else {
                                            echo "庫存：".$row["tempcount"];
                                          }
                                          ?></p>
                <p style="color:cornflowerblue;"><strong><?= $row["cash"] . "元" ?></strong></p>
                <form method="post">
                  <p><?= $row["total"] ?></p>

                  <div class="form-group row">
                    <div class="col-6">
                      <input id="count" name="count" type="number" class="form-control " value="<?= $row["count"]; ?>">
                    </div>
                  </div>
                  <td><input type="submit" class="btn btn-outline-primary btn-md" name="btnAdd" id="btnAdd" value="添加" /></td>
              </div>
              <input type="hidden" name="btnsend" id="btnsend" value="<?= $row["pid"] ?>" />
    </form>
  </div>
  </div>
<?php } ?>
</div>
</form>
<?php if ($sUserName == "Guest") : ?>
  <a href="#" style="text-decoration:none;"></a>
<?php else : ?>
  <div class="col-4 mb-2 ml-3">
    <a href="./customer/cart.php" class="btn btn-outline-success btn-md">前往購物車</a>
  </div>
<?php endif; ?>
</div>
</body>

</html>