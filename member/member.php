<?php
require_once("config.php");
$commandText = <<<SqlQuery
    select cid,username,dis from customer c JOIN black_list b on c.cid = b.bid;
    SqlQuery;
$result = mysqli_query($link, $commandText);

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
        <h2>購物系統 - 會員列表</h2>
        <span>
            <a href="../index.php" class="btn btn-outline-primary">回首頁</a>
        </span>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <span>
                <a href="./block.php?cid=<?= $row["cid"] ?>" class="btn btn-outline-danger">加入黑名單</a>
                <a href="./cancel.php?cid=<?= $row["cid"] ?>" class="btn btn-outline-success">移除黑名單</a>
            </span>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>會員編號</th>
                        <th>帳號</th>
                        <th>停用</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $row["cid"] ?></td>
                        <td><?= $row["username"] ?></td>
                        <td>
                            <input class="btn btn-outline-danger" disabled="disabled" type="checkbox" name="dis" id="dis" value="0" <?= ($row["dis"] == 1) ? "checked" : "" ?>>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>