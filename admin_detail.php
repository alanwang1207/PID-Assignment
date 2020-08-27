<?php
session_start();
require_once("config.php");
$commandText = <<<SqlQuery
    select * from detail2 ;
    SqlQuery;
// $sql = <<<multi
//     "select u.uid,prodname,cash,count,did,cash*count as total
//     from user u join detail d on d.uid =u.uid
//                  join prod p on p.pid =d.pid 
//                  ORDER BY did ASC";
// multi;
$result = mysqli_query($link, $commandText);
// var_dump($result);

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

    <div class="container">
        <h2>購物系統 - 訂單管理</h2>
        <a href="./admin.php" class="btn btn-outline-primary">回首頁</a>


        <form class="form-inline" method="POST">
            <label for="keyword">請輸入關鍵字 : </label>
            <input type="keyword" class="form-control" pattern="^[\u4e00-\u9fa5a-zA-Z]+$" id="keyword">
            <input type="submit" value="">
        </form>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>訂單編號</th>
                    <th>商品編號</th>
                    <th>購買編號</th>
                    <th>總價</th>
                    <th>購買日期</th>

                </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tbody>
                    <tr>
                        <td><?= $row["did"] ?></td>
                        <td><?= $row["pid"] ?></td>
                        <td><?= $row["uid"] ?></td>
                        <td><?= $row["total"] ?></td>
                        <td><?= $row["date"] ?></td>

                    </tr>

                </tbody>
            <?php } ?>
        </table>

    </div>

</body>

</html>