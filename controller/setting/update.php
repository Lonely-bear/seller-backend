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
$sid = $_POST['sid'];
$sname = $_POST['sname'];
$sval = $_POST['sval'];

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
        $sql = "INSERT INTO sys_setting (sname, sval) 
                VALUES ('$sname', '$sval')";
        break;
    // 修改系统配置信息
    case "edit":
        $sql = "UPDATE sys_setting 
                SET sname='$sname', sval='$sval' 
                WHERE sid=$sid";
        break;
    // 删除指定系统配置
    case "delete":
        $sql = "DELETE FROM sys_setting WHERE sid=$sid";
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