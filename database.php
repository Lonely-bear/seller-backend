<?php
define("SERVER", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("DATABASE", "wt");

// 创建链接
$conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);

// 检测链接
if($conn->connect_error) {
    die("连接数据库失败：" . $conn->connect_error);
}
?>