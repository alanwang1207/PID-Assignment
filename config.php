<!-- XAMPP -->
<!-- 
<?php

$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$dbname = 'pid';
$port = 3306;
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);
mysqli_query($link, "set names utf-8");

?> -->

<!-- MAMP -->

<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'pid';
$port = 8889;
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $port);
mysqli_query($link, "set names utf-8");

?>