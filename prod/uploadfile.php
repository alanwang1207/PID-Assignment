<?php
if ($_FILES['file']['error'] > 0) {
    echo "Error:" . $_FILES["file"]["error"];
} else {
    // 檔案上傳並顯示基本資料
    echo "檔案名稱: " . $_FILES['file']['name'] . "<br>";
    echo "檔案大小: " . ($_FILES['file']['size'] / 1024) .  "Kb<br>";
    echo "檔案格式: " . $_FILES['file']['type'] . "<br>";
    echo "暫存名稱: " . $_FILES['file']['tmp_name'] . "<br>";
    echo "錯誤代碼: " . $_FILES['file']['error'] . "<br>";
}
// 上傳檔案並存入資料庫


//複製檔案
if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    $tempDIR = "./upload";
    if (!is_dir($tempDIR) || !is_writeable($tempDIR))
        die("目錄不存在或無法寫入 ");

    $tempimage = explode(".", $_FILES['file']['name']);     //取得檔案副檔名，以陣列形式來表示
    $image_Extension = $tempimage[count($tempimage) - 1];  //確保副檔名一定會在最後的位置，確保副檔名正確  
    $dbImage = date("YmdHis") . "." . $image_Extension;     //避免檔案名稱重複  以年月日時分秒.副檔名  作為檔名

    // $ServerFilename = $_POST["prodname"] .  ".png";  // 

    move_uploaded_file($_FILES['file']['tmp_name'], iconv("UTF-8", "UTF-8", $tempDIR . "/" . $dbImage)); //將上傳的暫存檔移動到指定目錄
}




// 檔案上傳並顯示基本資料
echo "<center><font color='red'>";

// echo "檔案名稱: " . $_FILES['myfile']['name'] . "<br>";
// echo "檔案大小: " . $_FILES['myfile']['size'] . "<br>";
// echo "檔案格式: " . $_FILES['myfile']['type'] . "<br>";
// echo "暫存名稱: " . $_FILES['myfile']['tmp_name'] . "<br>";
// echo "錯誤代碼: " . $_FILES['myfile']['error'] . "<br>";


?>
