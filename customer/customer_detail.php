<?php
session_start();

//載入資料庫配置
require_once("../config.php");

$did = $_GET["did"];
//顯示明細

    $sql = <<<multi
select did,username,prodname,prodcount,cash,total,date

from user u join detail d on d.uid =u.uid
where d.did = $did
multi;
    $result = mysqli_query($link, $sql);

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
        <a href="../index.php" ><h2>購物網 - 訂單頁</h2></a>
            
            <a href="./customer_details.php" class="btn btn-outline-primary">回上一頁</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>訂單編號</th>
                        <th>購買人</th>
                        <th>商品名</th>
                        <th>商品數</th>
                        <th>商品單價</th>
                        <th>金額</th>
                        <th>購買日期</th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row["did"] ?></td>
                            <td><?= $row["username"] ?></td>
                            <td><?= $row["prodname"] ?></td>
                            <td><?= $row["prodcount"] ?></td>
                            <td><?= $row["cash"] ?></td>
                            <td><?= $row["total"] ?></td>
                            <td><?= $row["date"] ?></td>

                        </tr>

                        <?php
                        $rowt = (int)$row["total"];
                        $total += $rowt;
                        $tt = $total;
                        ?>
                    <?php } ?>
                    <?php
                    $tt = $total;
                    ?>
                </tbody>
            </table>
            <td>
                <h2>
                    總共 <?= $total ?> 元
                </h2>
            </td>
        </div>
    </form>
</body>

</html>