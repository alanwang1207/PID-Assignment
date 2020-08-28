<?php
session_start();
require_once("config.php");
$commandText = <<<SqlQuery
    select * from detail ;
    SqlQuery;

$result = mysqli_query($link, $commandText);

$sql = <<<multi
    select did,username,prodname,prodcount,cash,total,date
    
    from user u join detail d on d.uid =u.uid
    ORDER BY d.did ASC
    multi;
$result = mysqli_query($link, $sql);
// $sql = <<<multi
//     "select u.uid,prodname,cash,count,did,cash*count as total
//     from user u join detail d on d.uid =u.uid
//                  join prod p on p.pid =d.pid 
//                  ORDER BY did ASC";
// multi;

// var_dump($result);

//搜尋商品
if(isset($_POST["btnSearchp"])){
    $keyword = $_POST["keyword"];
    $sql = <<<multi
    select did,username,prodname,prodcount,cash,total,date
    from user u join detail d on d.uid =u.uid
    where prodname like '%$keyword%'
    ORDER BY did ASC
    multi;
    $result = mysqli_query($link, $sql);
}
//搜尋買家
if(isset($_POST["btnSearchb"])){
    $buyer = $_POST["buyer"];
    $sql = <<<multi
    select did,username,prodname,prodcount,cash,total,date
    from user u join detail d on d.uid =u.uid
    where username like '%$buyer%'
    ORDER BY did ASC
    multi;
    $result = mysqli_query($link, $sql);
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

    <div class="container">
        <h2>購物系統 - 訂單管理</h2>
        <a href="./admin.php" class="btn btn-outline-primary">回首頁</a>


        <form class="form-inline" method="POST">
            <label for="keyword">請輸入商品名 : </label>
            <input type="keyword" class="form-control" pattern="^[\u4e00-\u9fa5a-zA-Z]+$" name = "keyword" id="keyword">
            <input name = "btnSearchp" id= "btnSearchp" type="submit" class="btn btn-primary btn-sm">
        </form>

        <form class="form-inline" method="POST">
            <label for="buyer">請輸入購買人 : </label>
            <input type="keyword" class="form-control" pattern="^[\u4e00-\u9fa5a-zA-Z]+$" name = "buyer" id="buyer">
            <input name = "btnSearchb" id= "btnSearchb" type="submit" class="btn btn-primary btn-sm">
        </form>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>訂單編號</th>
                    <th>購買人</th>
                    <th>商品名</th>
                    <th>商品數</th>
                    <th>商品單價</th>
                    <th>總價</th>
                    <th>購買日期</th>

                </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tbody>
                    <tr>
                    <td><?= $row["did"] ?></td>
                        <td><?= $row["username"] ?></td>
                        <td><?= $row["prodname"] ?></td>
                        <td><?= $row["prodcount"] ?></td>
                        <td><?= $row["cash"] ?></td>
                        <td><?= $row["total"] ?></td>
                        <td><?= $row["date"] ?></td>

                    </tr>

                </tbody>
            <?php } ?>
        </table>

    </div>

</body>

</html>