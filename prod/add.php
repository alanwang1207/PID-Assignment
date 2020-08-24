<?php

if (isset($_POST["okButton"])) {
    $prodname = $_POST["prodname"];
    //echo $firstName;
    $prodcount = $_POST["prodcount"];
    $cash = $_POST["cash"];
    
    if (trim(($prodname && $prodcount && $cash) != "")) {
        $sql = <<<sqlstate
    insert into prod (prodname,prodcount,cash)
    values('$prodname','$prodcount','$cash')
  sqlstate;
        require_once("../config.php");
        mysqli_query($link, $sql);   
        echo "<script> alert('添加成功，將跳回商品管理頁');location.replace('./product.php');</script>";    
    } else {
        // 使用js語法
        echo '<script language="javascript">';
        echo 'alert("欄位請輸入完整")';
        echo '</script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加商品資料</title>
</head>

<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <form  method="post">
    <div class="form-group row">
            <label for="prodname" class="col-4 col-form-label">商品名</label>
            <div class="col-8">
                <input id="prodname" name="prodname" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="prodcount" class="col-4 col-form-label">數量</label>
            <div class="col-8">
                <input id="prodcount" name="prodcount" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="cash" class="col-4 col-form-label">金額</label>
            <div class="col-8 ">
                <input id="cash" name="cash" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-4 col-8">
                <button name="okButton" type="submit" class="btn btn-primary">確認送出</button>
            </div>
        </div>
    </form>
</body>

</html>