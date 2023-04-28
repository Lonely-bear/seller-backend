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
$name = $_POST['name'];
$avatarURL = $_POST['avatarURL'];
$owner_name = $_POST['owner_name'];
$owner_phone = $_POST['owner_phone'];
$join_time = new DateTime();
$join_time = $join_time->format("Y-m-d H:i:s");
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
    // 新增商家
    case "add":
        $sql = "INSERT INTO pro_seller (name, avatarURL, owner_name, owner_phone, join_time, status) 
                VALUES ('$name', '$avatarURL', '$owner_name', '$owner_phone', '$join_time', $status)";
        break;
    // 修改商家信息
    case "edit":
        $sql = "UPDATE pro_seller 
                SET name='$name', avatarURL='$avatarURL', owner_name='$owner_name', owner_phone='$owner_phone', status=$status 
                WHERE sid=$sid";
        break;
    // 删除指定商家
    case "delete":
        $sql = "DELETE FROM pro_seller WHERE sid=$sid";
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