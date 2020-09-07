<?php

//按下取消返回商品管理頁
if (isset($_POST["cancelButton"])) {
    header("location: ./product.php");
    exit();
}
//按下ok送資料
if (isset($_POST["okButton"])) {
    $prodname = $_POST["prodname"];
    $prodcount = $_POST["prodcount"];
    $cash = $_POST["cash"];

    //判斷是否有空值
    if (trim(($prodname && $prodcount && $cash) != "")) {
        //引入資料庫配置
        require_once("../config.php");

        //判斷是否重複名稱
        $sql = "select * from prod where prodname = '$prodname'";
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo "<script> alert('商品名稱重複');location.replace('./add.php');</script>";
        } else {

            if ($_FILES['file']['error'] > 0) {
                echo "Error:" . $_FILES["file"]["error"];
            } else {
                // 檔案上傳並顯示基本資料
                // echo "檔案名稱: " . $_FILES['file']['name'] . "<br>";
                // echo "檔案大小: " . ($_FILES['file']['size'] / 1024) .  "Kb<br>";
                // echo "檔案格式: " . $_FILES['file']['type'] . "<br>";
                // echo "暫存名稱: " . $_FILES['file']['tmp_name'] . "<br>";
                // echo "錯誤代碼: " . $_FILES['file']['error'] . "<br>";
            }
            //複製檔案
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                $tempDIR = "./upload";
                if (!is_dir($tempDIR) || !is_writeable($tempDIR))
                    die("目錄不存在或無法寫入 ");
                $localFilename = $_POST["prodname"] .  ".png";  
                move_uploaded_file($_FILES['file']['tmp_name'], iconv("UTF-8", "UTF-8", $tempDIR . "/" . $localFilename)); //將上傳的暫存檔移動到指定目錄
            }
            //新增商品
            $sql = <<<sqlstate
        insert into prod (prodname,prodcount,tempcount,cash)
        values('$prodname','$prodcount','$prodcount','$cash')
      sqlstate;
            mysqli_query($link, $sql);
            echo "<script> alert('添加成功，將跳回商品管理頁');location.replace('./product.php');</script>";
        }
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

    <!-- <form method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="prodname" class="col-4 col-form-label">商品名</label>
            <div class="col-8">
                <input id="prodname" name="prodname" type="text" class="form-control">
            </div>
        </div>

        <input name="file" type="file">
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
    </form> -->
    
    
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <th>商品名</th>
                <th>圖片</th>
                <th>數量</th>
                <th>金額</th>
                
            </thead>
            <tbody>
                <tr>
                    <td><input id="prodname" name="prodname" type="text" class="form-control"></td>
                    <td><input name="file" type="file"></td>
                    <td><input id="prodcount" name="prodcount" type="text" class="form-control"></td>
                    <td><input id="cash" name="cash" type="text" class="form-control"></td>
                </tr>
               
            </tbody>
            
        </table>
    </div>
    <div class="form-group row">
                <div class="offset-4 col-8">
                <button name="okButton" type="submit" class="btn btn-primary">確認送出</button>
                <button name="cancelButton" value="Cancel" type="submit" class="btn btn-secondary">取消修改</button>
                </div>
            </div>
    
</form>
</body>

</html>