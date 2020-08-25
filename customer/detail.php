<?php
require_once("config.php");
$commandText = <<<SqlQuery
select * from prod ;
SqlQuery;

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
        <h2>購物網 - 訂單詳情頁</h2>
        <a href="../index.php" class="btn btn-outline-primary">回首頁</a>
        <a href="./cart.php?pid=<?= $row["pid"] ?>" class="btn btn-outline-success">取消購買</a>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>商品編號</th>
                        <th>商品名</th>
                        <th>數量</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $row["pid"] ?></td>
                        <td><?= $row["prodname"] ?></td>
                        <td><?= $row["prodcount"] ?></td>
                        <td><?= $row["cash"] ?></td>
                    </tr>

                </tbody>
            </table>
        <?php } ?>
    </div>

</body>

</html>