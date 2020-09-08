<?php
session_start();

//載入資料庫配置
require_once("../config.php");

$uid = $_SESSION['uid'];

//抓取添加數量的商品id
$did = $_POST["detail"];

//顯示明細

if (isset($_POST["more"])) {
    $_SESSION['num'] = $_SESSION['num'] + 5;
    $num = $_SESSION['num'];
    $sql = <<<multi
select distinct(did),date from detail where uid = $uid
ORDER BY did ASC
limit $num
multi;
    $result = mysqli_query($link, $sql);
} else {
    $num = $_SESSION['num'];
    $sql = <<<multi
    select distinct(did),date from detail where uid = $uid
    ORDER BY did ASC
    limit $num
multi;
    $result = mysqli_query($link, $sql);
}

if (isset($_POST["detail"])) {
    header("location:customer_detail.php?did=$did");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PID - 購物網</title>
</head>

<body>
    <form method="post">
        <div class="container">
            <h2>購物網 - 訂單頁</h2>
            <a href="../index.php" class="btn btn-outline-primary">回首頁</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>訂單編號</th>
                        <th>訂購日期</th>
                        <th>訂單詳情</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row["did"] ?></td>
                            <td><?= $row["date"] ?></td>
                            <td>
                                <input type="hidden" name="btnsend" id="btnsend" value="<?= $row["did"] ?>" />
                                <a href="./customer_detail.php?did=<?= $row["did"] ?>" class="btn btn-info">點我查看</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <td>
                <input type="submit" class="btn btn-primary" id="more" name="more" value="更多">
            </td>
        </div>
    </form>
</body>

</html>