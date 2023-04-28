<?php
/***************************************
 * 引入公共文件 
 **************************************/

require('../../database.php');
require('../../model/Response.php');

/***************************************
 * 获取参数
 **************************************/

$sid = $_GET['sid'];
$sname = $_GET['sname'];

/***************************************
 * 执行SQL
 **************************************/

if(!$sid && $sname) {
    $sql = "SELECT * FROM sys_setting WHERE sname='$sname'";
}
if($sid && !$sname) {
    $sql = "SELECT * FROM sys_setting WHERE sid=$sid";
}
if($sid && $sname) {
    $sql = "SELECT * FROM sys_setting WHERE sid=$sid and sname='$sname'";
}

$result = $conn->query($sql);

/***************************************
 * 数据处理
 **************************************/

$response = new Response();
$response->data = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response->data[] = $row;
    }
} else {
    $response->msg = '未查找到指定数据';
}

/***************************************
 * 返回响应
 **************************************/
echo json_encode($response);
$conn->close()

?>