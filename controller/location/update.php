<?php
/***************************************
 * 引入公共文件 
 **************************************/

require('../../database.php');
require('../../model/Response.php');

/***************************************
 * 获取参数
 **************************************/

$type = $_POST['type'];
$lid = $_POST['lid'];
$uid = $_POST['uid'];
$lname = $_POST['lname'];

/***************************************
 * 自定义函数
 **************************************/

////////////////////////////////////////

/***************************************
 * 执行SQL
 **************************************/

$response = new Response();
$response->data = [];
$sql = "";
switch($type) {
    // 新增系统配置
    case "add":
        $sql = "INSERT INTO pro_location (uid, lname) 
                VALUES ($uid, '$lname')";
        break;
    // 修改系统配置信息
    case "edit":
        $sql = "UPDATE pro_location 
                SET uid=$uid, lname='$lname' 
                WHERE lid=$lid";
        break;
    // 删除指定系统配置
    case "delete":
        $sql = "DELETE FROM pro_location WHERE lid=$lid";
        break;
    default:
        break;
}
if($sql !== "") {
    $result = $conn->query($sql);
}

/***************************************
 * 数据处理
 **************************************/

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response->data[] = $row;
    }
}

if($result === true) {
    $response->msg = "更新数据成功";
} else {
    $response->msg = "更新数据失败";
}

/***************************************
 * 返回响应
 **************************************/

echo json_encode($response);
$conn->close()

?>