<?php
session_start();
require_once("config.php");

$sql =
  "select `prodname`,`prodcount`,`cash` from `prod`; ";
$result = mysqli_query($link, $sql);
$row_count = mysqli_num_rows($result);
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
<form method="post">
  <div class="container">
    <h2>購物網 - 購物車</h2>
    <span>
      <?php if ($sUserName == "Guest") : ?>
        <a href="login.php" class="btn btn-outline-success btn-md">登入</a>
      <?php else : ?>
        <a href="login.php?logout=1" class="btn btn-outline-secondary btn-md">登出</a>
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
        </tr>
      </thead>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tbody>
          <tr>
            <td><?= $row["prodname"] ?></td>
            <td><?= $row["prodcount"] ?></td>
            <td><?= $row["cash"] ?></td>
            <td>
              <div class="form-group row">
                <div class="col-2">
                  <input id="count" name="count" type="text" class="form-control" value = "0">
                </div>
              </div>
            </td>
          </tr>

        </tbody>
      <?php } ?>
    </table>
    <a href="cart.php" class="btn btn-outline-success btn-md">加入購物車</a>
    <input type="reset" class="btn btn-outline-secondary btn-md" name="btnReset" id="btnReset" value="重設" />
    </form>
</body>

</html>