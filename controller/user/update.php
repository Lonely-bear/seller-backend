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
$uid = $_POST['uid'];
$username = $_POST['username'];
$nickname = $_POST['nickname'];
$avatarURL = $_POST['avatarURL'];
$openid = $_POST['openid'];
$telephone = $_POST['telephone'];
$lid = $_POST['lid'];
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
        $sql = "INSERT INTO pro_user (username, nickname, openid, avatarURL, telephone, lid, status) 
                VALUES ('$username', '$nickname', '$openid', '$avatarURL', '$telephone', $lid, $status)";
        break;
    // 修改系统配置信息
    case "edit":
        $sql = "UPDATE pro_user 
                SET username='$username', nickname='$nickname', openid='$openid', avatarURL='$avatarURL', telephone='$telephone', lid=$lid, status=$status 
                WHERE uid=$uid";
        break;
    // 删除指定系统配置
    case "delete":
        $sql = "DELETE FROM pro_user WHERE uid=$uid";
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