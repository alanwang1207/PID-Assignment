<?php
if (isset($_POST["cancelButton"])) {
    header("location: ../secret.php");
    exit();
}
if (!isset($_GET["pid"])) {
    die("id not found.");
}
$pid = $_GET["pid"];
if (!is_numeric($pid))
    die("pid not a number.");

//echo $sql;
require_once("config.php");
if (isset($_POST["okButton"])) {
    $prodname = $_POST["prodname"];
    $prodcount = $_POST["prodcount"];
    $cash = $_POST["cash"];
    $sql = <<<multi
    update prod set
    prodname = '$prodname',
    prodcount='$prodcount',
    tempcount='$prodcount',
    cash = '$cash'
    where pid = $pid
  multi;
    $result = mysqli_query($link, $sql);
    echo "<script> alert('修改完成，將跳回商品管理頁');location.replace('./product.php');</script>";    
    //header("location: login.php");

    exit();
} else {
    $sql = <<<multi
    select * from prod where pid = $pid
  multi;
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
}

//var_dump($row);
// header("location: index.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>修改商品資料</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">

        <form method="post">
            <div class="form-group row">
                <label for="prodname" class="col-4 col-form-label">商品名:</label>
                <div class="col-8">
                    <input id="prodname" name="prodname" value="<?= $row["prodname"] ?>" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="prodcount" class="col-4 col-form-label">數量:</label>
                <div class="col-8">
                    <input id="prodcount" name="prodcount" value="<?= $row["prodcount"] ?>" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="cash" class="col-4 col-form-label">金額:</label>
                <div class="col-8">
                    <input id="cash" name="cash" value="<?= $row["cash"] ?>" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button name="okButton" value="OK" type="submit" class="btn btn-primary">確認修改</button>
                    <button name="cancelButton" value="Cancel" type="submit" class="btn btn-secondary">取消修改</button>
                </div>
            </div>
        </form>

    </div>

</body>

</html>