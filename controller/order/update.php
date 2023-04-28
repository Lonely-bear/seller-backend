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
$oid = $_POST['oid'];
$uid = $_POST['uid'];
$tid = $_POST['tid'];
$goods = $_POST['goods'];
$cost = $_POST['cost'];
$confirm_time = new DateTime();
$confirm_time = $confirm_time->format("Y-m-d H:i:s");
$status = $_POST['status'];

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
        $sql = "INSERT INTO pro_order (uid, tid, goods, cost, confirm_time, status) 
                VALUES ($uid, $tid, '$goods', $cost, '$confirm_time', $status)";
        break;
    // 修改系统配置信息
    case "edit":
        $sql = "UPDATE pro_order 
                SET uid=$uid, tid=$tid, goods='$goods', cost='$cost', status=$status 
                WHERE oid=$oid";
        break;
    // 删除指定系统配置
    case "delete":
        $sql = "DELETE FROM pro_order WHERE oid=$oid";
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
    var_dump($conn->error);
    $response->msg = "更新数据失败";
}

/***************************************
 * 返回响应
 **************************************/

echo json_encode($response);
$conn->close()

?>